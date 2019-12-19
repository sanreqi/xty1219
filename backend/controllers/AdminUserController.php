<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2019/3/9
 * Time: 21:22
 */

namespace backend\controllers;


use common\models\AdminUser;
use common\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;


class AdminUserController extends BaseController
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
//        $where['status'] = AdminUser::STATUS_ACTIVE;
        $list = AdminUser::getList();
        $data = json_encode($list);
        return $this->render('index', ['data' => $data]);
    }

    /**
     * 添加&编辑管理员用户
     */
    public function actionSaveAdminUser() {
        if (!Yii::$app->request->isAjax) {
            $this->errorAjax('非法访问');
        }

        $id = Yii::$app->request->get('id');

        if (!empty($id)) {
            //update
            $model = AdminUser::findIdentity($id);
            if (empty($model)) {
                $this->errorAjax('非法访问');
            }
            $model->updated_at = time();
        } else {
            //create
            $model = new AdminUser();
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
     * 通过id获取adminuser
     */
    public function actionGetAdminUser() {
        if (!Yii::$app->request->isAjax) {
            $this->errorAjax('非法访问');
        }
        $id = Yii::$app->request->get('id');
        if (empty($id)) {
            $this->errorAjax('参数错误');
        }

        $model = AdminUser::findIdentity($id);
        if (empty($model)) {
            $this->errorAjax('非法操作');
        }

        $data = [
            'id' => $model['id'],
            'username' => $model['username'],
            'truename' => $model['truename'],
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

        $model = AdminUser::findIdentity($id);
        $model->status = AdminUser::STATUS_DELETED;
        if ($model->save()) {
            $this->successAjax();
        } else {
            $errorMsg = current($model->getFirstErrors());
            $this->errorAjax($errorMsg);
        }
    }
}