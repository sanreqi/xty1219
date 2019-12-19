<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2019/3/9
 * Time: 21:23
 */

namespace backend\controllers;

use backend\forms\ReportForm;
use common\models\Report;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\web\UploadedFile;

class ReportController extends BaseController
{
    public function actionIndex() {
        if (Yii::$app->request->isAjax) {
            //请求表格数据
            $get = Yii::$app->request->get();
            $search = [];
            if (isset($get['uid'])) {
                $search['uid'] = $get['uid'];
            }
            if (isset($get['keyword'])) {
                $search['keyword'] = $get['keyword'];
            }
            $query = Report::getList($search, 2);

            $provider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);

            $data = $this->formatListData($provider->getModels());
            $this->layerTableDataReturn($data, $provider->getTotalCount());
        } else {
            $userModels = User::getUserOptions();
            $url = Url::current();
            return $this->render('index', ['userModels' => $userModels, 'url' => $url]);
        }
    }

    private function formatListData($data) {
        foreach ($data as &$v) {
            //后台
            $detailUrl = Url::toRoute(['/user/detail', 'uid' => $v['uid']]);
            $v['report'] = '<a href="' . $v['web_path'] . '" download="' . $v['id'] . '">'.$v['name'].'</a>';
            $v['company_name'] = '<a href="'.$detailUrl.'">'.$v['company_name'].'</a>';
            //编辑和删除

            $updateUrl = Url::toRoute(['/report/create-update', 'id' => $v['id']]);
            $createUrl = Url::toRoute(['/report/create-update', 'uid' => $v['uid']]);

            $v['operate'] = '<a href="'.$updateUrl.'" class="update-report layui-btn layui-btn-normal layui-btn-sm" id=' . $v['id'] . '>编辑</a>
                             <button class="delete-report layui-btn layui-btn-danger layui-btn-sm" id=' . $v['id'] . '>删除</button>
                                <a href="'.$createUrl.'" class="update-report layui-btn layui-btn-sm" id=' . $v['id'] . '>上传</a>';
        }

        return $data;
    }


    public function actionDelete() {
        if (!Yii::$app->request->isAjax) {
            $this->errorAjax('非法访问');
        }
        $id = Yii::$app->request->get('id');
        if (empty($id)) {
            $this->errorAjax('参数错误');
        }

        $model = Report::findById($id);
        if (empty($model)) {
            $this->errorAjax('非法访问');
        }

        $model->is_delete = Report::IS_DELETE_YES;
        if ($model->save()) {
            $this->successAjax();
        } else {
            $errorMsg = current($model->getFirstErrors());
            $this->errorAjax($errorMsg);
        }
    }
//    company detail @todo
    //报告列表页 @todo 所有放一起
    public function actionindex1() {

    }

    /*
     * 添加&编辑报告表单页
     */
    public function actionCreateUpdate() {
        $uid = Yii::$app->request->get('uid');
        $id = Yii::$app->request->get('id');
        if (empty($uid) && empty($id)) {
            $this->errorAjax('非法访问');
        }

        if (empty($id)) {
            //添加
            $model = new Report();
            $submitUrl = Url::toRoute(['/report/save', 'uid' => $uid]);
        } else {
            //编辑
            $model = Report::findReportById($id);
            $submitUrl = Url::toRoute(['/report/save', 'id' => $id]);
            if (empty($model)) {
                $this->errorAjax('非法访问');
            }
            $uid = $model->uid;
        }

        //报告列表页面
//        $returnUrl = Url::toRoute(['/user/detail', 'uid' => $uid]);
        $returnUrl = Url::toRoute(['/report/index', 'uid' => $uid]);
        $user = User::findIdentity($uid);
        if (empty($user)) {
            $this->errorAjax('非法访问');
        }

        return $this->render('create_update', [
            'model' => $model, 'submitUrl' => $submitUrl, 'returnUrl' => $returnUrl, 'user' => $user]);
    }

    /*
     * 保存报告
     */
    public function actionSave()
    {
        $form = new ReportForm();

        if (!Yii::$app->request->isPost) {
            $this->errorAjax('非法请求');
        }

        $post = Yii::$app->request->post();
        //id为空时为添加，id不空为编辑，id和uid不能同时为空
        $id = Yii::$app->request->get('id');
        $uid = Yii::$app->request->get('uid');
        if (empty($id) && empty($uid)) {
            $this->errorAjax('非法请求');
        }

        //先赋值
        $form->reportFile = UploadedFile::getInstance($form, 'reportFile');
        $form->name = $post['name'];

        if (!$form->validate()) {
            //表单验证不通过
            $errorMsg = current($form->getFirstErrors());
            $this->errorAjax($errorMsg);
        }

        //添加还是编辑
        $isNewRecord = empty($id) ? 1 : 0;

        if ($isNewRecord) {
            //添加的情况，为了获取id，先插入一条数据
            $model = new Report();
            $model->uid = $uid;
            $model->save();
        } else {
            //编辑的情况
            $model = Report::findReportById($id);
            if (empty($model)) {
                $this->errorAjax('非法访问');
            }
        }

        //给文件命名
        $form->fileName = 'RA' . '_' . time() . '_' . $model->id;
        if (!$form->upload()) {
            empty($id) && $model->delete(); //新增的情况就删除
            $this->errorAjax($form->getErrorMsg());
        }

        if ($model->saveReport($form, $isNewRecord)){
            $this->successAjax();
        } else {
            $this->errorAjax($model->getErrorMsg());
        }
    }

}