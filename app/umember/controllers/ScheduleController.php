<?php
namespace module\umember\controllers;

use WS;
use yii\data\ActiveDataProvider;

class ScheduleController extends \module\umember\Controller
{
    public function actionIndex()
    {
        $this->menuId = 'schedule';
        
        $query = \common\estate\gotour\Tour::find()->where(['user_id'=>WS::$app->user->id]);

        $dataProvider = new ActiveDataProvider([  
            'query' => $query,  
            'pagination' => [  
                'pageSize' => 25,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,            
                ]
            ],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionDelete($id=null)
    {
        $id = intval($id);
        $userId = WS::$app->user->id;
        if($tour = \common\estate\gotour\Tour::findOneByUser($id, $userId)) {
            if($tour->delete()) {
                WS::$app->session->setFlash('success', 'The schedule has been deleted!');
            }
        }

        return $this->redirect(['/umember/schedule/']);
    }
}