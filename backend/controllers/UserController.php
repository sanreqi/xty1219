<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2019/3/9
 * Time: 21:22
 */

namespace backend\controllers;


use common\models\User;
use yii\filters\AccessControl;
use Yii;
use yii\helpers\Url;


class UserController extends BaseController
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }

    /*
     * 页面
     */
    public function actionIndex() {
        $where['status'] = User::STATUS_ACTIVE;
        $list = User::getList();
        $list = $this->formatListData($list);
        $data = json_encode($list);
        return $this->render('index', ['data' => $data]);
    }

    public function formatListData($list) {
        if (!empty($list)) {
            foreach ($list as &$v) {
                $detailUrl = Url::toRoute(['/user/detail', 'uid' => $v['id']]);
                $v['company_name'] = '<a target="_blank" href="'.$detailUrl.'">'.$v['company_name'].'</a>';
                $v['operate'] = '<button class="update-user layui-btn layui-btn-normal layui-btn-sm" id=' . $v['id'] . '>编辑</button>
                                 <button class="delete-user layui-btn layui-btn-danger layui-btn-sm" id=' . $v['id'] . '>删除</button>';
            }
        }
        return $list;
    }

    /**
     * 添加&编辑管理员用户
     */
    public function actionSaveUser() {
        if (!Yii::$app->request->isAjax) {
            $this->errorAjax('非法访问');
        }

        $id = Yii::$app->request->get('id');

        if (!empty($id)) {
            //update
            $model = User::findIdentity($id);
            if (empty($model)) {
                $this->errorAjax('非法访问');
            }
            $model->updated_at = time();
        } else {
            //create
            $model = new User();
            $model->created_at = time();
        }

        $post = Yii::$app->request->post();
        $model->load($post);
        if (empty($model->password)) {
            //默认密码
            $model->password = '123456';
        }

        $saveFlag = true; //是否保存成功
        if ($model->validate()) {
            $model->setPassword($model->password);
            $model->generateAuthKey();
            if (!$model->save(false)) {
                $saveFlag = false;
            }
        } else {
            $saveFlag = false;
        }

        if ($saveFlag) {
            $this->successAjax();
        } else {
            $errorMsg = current($model->getFirstErrors());
            $this->errorAjax($errorMsg);
        }
    }

    /*
     * 通过id获取
     */
    public function actionGetUser() {
        if (!Yii::$app->request->isAjax) {
            $this->errorAjax('非法访问');
        }
        $id = Yii::$app->request->get('id');
        if (empty($id)) {
            $this->errorAjax('参数错误');
        }

        $model = User::findIdentity($id);
        if (empty($model)) {
            $this->errorAjax('非法操作');
        }

        $data = [
            'id' => $model['id'],
            'username' => $model['username'],
            'company_name' => $model['company_name'],
        ];

        $this->successAjax($data);
    }

    /*
     * 删除管理员
     */
    public function actionDelete() {
        if (!Yii::$app->request->isAjax) {
            $this->errorAjax('非法访问');
        }
        $id = Yii::$app->request->get('id');
        if (empty($id)) {
            $this->errorAjax('参数错误');
        }

        $model = User::findIdentity($id);
        $model->status = User::STATUS_DELETED;
        if ($model->save()) {
            $this->successAjax();
        } else {
            $errorMsg = current($model->getFirstErrors());
            $this->errorAjax($errorMsg);
        }
    }

    public function actionDetail() {
        $uid = Yii::$app->request->get('uid');
        if (empty($uid)) {
            $this->errorAjax('非法访问');
        }

        $user = User::findIdentity($uid);

        if (empty($user)) {
            $this->errorAjax('非法访问');
        }

        $reportUrl = Url::toRoute(['report/create-update', 'uid' => $uid]);

        return $this->render('detail', ['reportUrl' => $reportUrl, 'user' => $user]);
    }
}