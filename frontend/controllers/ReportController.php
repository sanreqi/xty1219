<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2019/3/16
 * Time: 22:24
 */

namespace frontend\controllers;

use common\models\Report;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;


class ReportController extends BaseController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /*
     * 报告列表页
     */
    public function actionIndex() {
        if (Yii::$app->request->isAjax) {
            //请求表格数据
            $get = Yii::$app->request->get();
            //必须登录用户
            $search['uid'] = Yii::$app->user->id;
            if (isset($get['keyword'])) {
                //id搜索
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
            $url = Url::current();
            return $this->render('index', ['url' => $url]);
        }
    }

    /*
     * 格式化列表数据
     */
    private function formatListData($list) {
        if (empty($list)) {
            return [];
        }
        foreach ($list as &$v) {
            $path = 'http://' . Yii::$app->params['adminHost'] . $v['web_path'];
            //报告名称
            $v['name'] = '<a target="_blank" href="'.$path.'" download="'.$v['id'].'">'.$v['name'].'</a>';
        }

        return $list;
    }


}