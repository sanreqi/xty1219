<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2019/3/13
 * Time: 20:11
 */

namespace common\models;

use yii\db\ActiveRecord;
use Yii;
use yii\db\Query;

class Report extends XtyActiveRecord
{

    const IS_DELETE_NO = 0;
    const IS_DELETE_YES = 1;

    public $errorMsg;

    public function rules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'xty_report';
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

    /**
     * 报告列表
     * @param array $search
     * @param bool $returnType 1-返回数据 2-返回query 3-返回count
     * @return array|int|string
     */
    public static function getList($search = [], $returnType = 1) {
        if (!in_array($returnType, [1,2,3])) {
            return false;
        }

        $query = new Query();
        $query
            ->select('r.id,r.uid,r.name,r.code,r.date,r.web_path,u.company_name')
            ->from(['r' => 'xty_report'])
            ->innerJoin(['u' => 'xty_user'], 'r.uid = u.id')
            ->where(['is_delete' => Report::IS_DELETE_NO]);

        if (isset($search['uid']) && !empty($search['uid'])) {
            $query->andWhere(['uid' => $search['uid']]);
        }

        if (isset($search['keyword']) && !empty($search['keyword'])) {
            $query->andWhere(['or', ['=', 'code', $search['keyword']], ['like', 'name', $search['keyword']]]);
        }

        $query->orderBy('r.id desc');

        if ($returnType == 1) {
            //是否返回数量
            return $query->all();
        } elseif ($returnType == 2) {
            return $query;
        } else {
            return $query->count();
        }
    }

    /*
     * 通过id查找report
     */
    public static function findReportById($id) {
        $where['id'] = $id;
        $where['is_delete'] = self::IS_DELETE_NO;
        return Report::find()->where($where)->one();
    }

    /*
     * 保存报告
     */
    public function saveReport($form, $isNewRecord) {
        //修改model
        if ($isNewRecord) {
            //添加
            $this->created_at = time();
        } else {
            //编辑
            $this->updated_at = time();
        }
        $this->name = $form->name;
        $this->physical_path = $form->physicalPath;
        $this->web_path = $form->webPath;
        if ($this->save()) { //保存
            return true;
        } else {
            $isNewRecord && $this->delete(); //新增的情况就删除
            $this->errorMsg = current($this->getFirstErrors());
            return false;
        }
    }

    /*
     * 通过主键id查询
     */
    public static function findById($id) {
        $model = Report::find()
                ->where(['is_delete' => self::IS_DELETE_NO])
                ->andWhere(['id' => $id])
                ->one();

        return $model;
    }


}