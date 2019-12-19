<?php
namespace frontend\controllers;

use common\models\User;
use frontend\forms\LoginForm;
use frontend\models\Bag;
use frontend\models\Student;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidArgumentException;
use yii\di\Container;
use yii\di\Instance;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use ReflectionClass;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */

/*
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'login-ajax', 'error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['menu', 'logout', 'modify-password', 'error'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

/*

    /**
     * Logs in a user.
     *
     * @return mixed
     * @todo 图形验证码
     */
    public function actionLogin()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $model = new LoginForm();
            $model->setAttributes($post);
            if ($model->login()) {
                $this->successAjax();
            } else {
                $this->errorAjax('用户名或密码错误');
            }
        } else {
            return $this->render('login');
        }
    }

    /*
     * 登录请求
     */
    public function actionLoginAjax() {
        $model = new LoginForm();
        $model->load(Yii::$app->request->post());
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->successAjax();
        } else {
            $this->errorAjax("用户名或密码错误");
        }
    }

    /*
     * 登出
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        $this->successAjax();
    }

    /*
     * 错误页面
     */
    public function actionError() {
        $this->layout = false;
        return $this->render('error');
    }


    /**
     * Requests password reset.
     *
     * @return mixed
     */
//    public function actionRequestPasswordReset()
//    {
//        $model = new PasswordResetRequestForm();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if ($model->sendEmail()) {
//                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
//
//                return $this->goHome();
//            } else {
//                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
//            }
//        }
//
//        return $this->render('requestPasswordResetToken', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
//    public function actionResetPassword0($token)
//    {
//        try {
//            $model = new ResetPasswordForm($token);
//        } catch (InvalidArgumentException $e) {
//            throw new BadRequestHttpException($e->getMessage());
//        }
//
//        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
//            Yii::$app->session->setFlash('success', 'New password saved.');
//
//            return $this->goHome();
//        }
//
//        return $this->render('resetPassword', [
//            'model' => $model,
//        ]);
//    }

    /*
     * 菜单页面
     */
    public function actionMenu() {
        return $this->render('menu');
    }

    /*
     * 修改密码
     */
    public function actionModifyPassword() {
        $uid = Yii::$app->user->id;
        if (Yii::$app->request->isAjax) {
            $model = User::findIdentity($uid);
            $post = Yii::$app->request->post();
            if (empty($post['old_password']) || empty($post['new_password']) || empty($post['confirm_password'])) {
                $this->errorAjax('密码不能为空');
            }
            if (!$model->validatePassword($post['old_password'])) {
                $this->errorAjax('旧密码错误');
            }
            if ($post['new_password'] != $post['confirm_password']) {
                $this->errorAjax('两次密码不一致');
            }
            $model->setPassword($post['new_password']);
            $model->generateAuthKey();
            $model->updated_at = time();
            if ($model->save()) {
                //登出
                Yii::$app->user->logout();
                $this->successAjax();
            } else {
                $errorMsg = current($model->getFirstErrors());
                $this->errorAjax($errorMsg);
            }
        } else {
            return $this->render('modify_password');
        }
    }	


    public function actionTest() {

phpinfo();
exit;
$serv = new \Swoole\Server('0.0.0.0', 9501, SWOOLE_BASE, SWOOLE_SOCK_TCP);



#exit;
#$http = new swoole_http_server("127.0.0.1", 9501);
#exit;

phpinfo();
exit;

$serv = new Swoole\Server("127.0.0.1", 9501); 

//监听连接进入事件
$serv->on('Connect', function ($serv, $fd) {  
    echo "Client: Connect.\n";
});

//监听数据接收事件
$serv->on('Receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, "Server: ".$data);
});

//监听连接关闭事件
$serv->on('Close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

//启动服务器
$serv->start(); 
    }


}
