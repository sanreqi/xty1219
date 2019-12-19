<?php

namespace common\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "xty_admin_user".
 *
 * @property int $id
 * @property string $username
 * @property string $truename 管理员名字
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class AdminUser extends \yii\db\ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $password;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'xty_admin_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['password', 'safe'],
            [['username', 'truename'], 'required', 'message' => '请填写{attribute}'],
            ['password', 'string', 'max'=> '10','min'=> '6', 'tooLong' => '密码长度须在6-10位之间', 'tooShort'=>'密码长度须在6-10位之间'],




//是否在某个范围内：array('name', 'length', ,'max'=> '10','min'=> '5', 'tooLong'=> '太长了','tooShort'=> '太短了')

//            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
//            [['status', 'created_at', 'updated_at'], 'integer'],
//            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
//            [['truename'], 'string', 'max' => 20],
//            [['auth_key'], 'string', 'max' => 32],
//            [['username'], 'unique'],
//            [['email'], 'unique'],
//            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'truename' => '姓名',
            'auth_key' => 'Auth Key',
            'password_hash' => '密码',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function saveAdminUser($data) {
//        $model = new AdminUser();
//        $model->username = $data['username'];
//        $model->truename = $data['truename'];
//        if (isset($data['']))
    }

    public static function findActiveById($id) {
        $where['status'] = AdminUser::STATUS_ACTIVE;
        $where['id'] = $id;
        return self::where($where)->one();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /*
     * 管理员页面列表数据
     */
    public static function getList($search = []) {
        $where['status'] = self::STATUS_ACTIVE;

        $list = AdminUser::find()->select('id,username,truename')->where($where)->asArray()->all();


        if (!empty($list)) {
            foreach ($list as &$v) {
                $v['operate'] = '<button class="update-admin-user layui-btn layui-btn-normal layui-btn-sm" id=' . $v['id'] . '>编辑</button>
                                 <button class="delete-admin-user layui-btn layui-btn-danger layui-btn-sm" id=' . $v['id'] . '>删除</button>';
            }
        }

        return $list;
    }





    /**
     * 添加用户&注册
     */
//    public function signup() {
//        $user = new User();
//        $user->username = $this->username;
//        $user->setPassword($this->password);
//        $user->generateAuthKey();
//
//        return $user->save() ? $user : null;
//    }
}
