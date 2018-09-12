<?php
namespace module\umember\controllers;

use WS;
use yii\data\ActiveDataProvider;

class ScheduleController extends \module\umember\Controller
{
    public function actionIndex()
    {
        $this->menuId = 'schedule';

        $items = WS::$app->graphql->request('house-tours')->result->items;
        $items = \yii\helpers\ArrayHelper::index($items, 'id');

        $dataProvider = new ActiveDataProvider([
            'models' => $items,
            'pagination' => [
                'pageSize' => 100,
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
            } else {
                WS::$app->session->setFlash('error', 'The schedule has not been delete!');
            }
        } else {
            WS::$app->session->setFlash('error', 'The schedule has not found!');
        }

        return $this->redirect(['/umember/schedule/']);
    }
}