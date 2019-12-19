<?php
/**
 * Created by PhpStorm.
 * User: srq
 * Date: 2019/3/15
 * Time: 16:37
 */

namespace common\models;

use yii\db\ActiveRecord;

class XtyActiveRecord extends ActiveRecord {

    protected $errorMsg;

    public function setErrorMsg($errorMsg) {
        $this->errorMsg = $errorMsg;
    }

    public function getErrorMsg() {
        return $this->errorMsg;
    }
}