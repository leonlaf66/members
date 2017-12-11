<?php
namespace module\umember\controllers;

use WS;
use yii\data\ActiveDataProvider;

class RetsNewsletterController extends \module\umember\Controller
{
    protected $areas = [];

    public  function init()
    {
        $this->areas = [
            'ma'=>tt('Massachusetts', '麻省州'),
            'ny'=>tt('New York', '纽约'),
            'ga'=>tt('Georgia', '佐治亚州'),
            'il'=>tt('Illinois', '伊利诺斯州'),
            'ca'=>tt('California', '加州')
        ];

        return parent::init();
    }

    public function actionIndex()
    {
        $this->menuId = 'newsletter';

        $query = \common\customer\RetsNewsletter::find()->where(['user_id'=>WS::$app->user->id]);

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

    public function actionUpdate($id)
    {
        return $this->actionEdit(null, $id);
    }

    public function actionEdit($area_id=null, $id=null)
    {
        $this->menuId = 'newsletter';
        
        $model = null;
        if(! is_null($id)) {
            $model = \common\customer\RetsNewsletter::find()
                ->where([
                    'id'=>$id,
                    'user_id'=>WS::$app->user->id
                ])->one();
            $area_id = $model->area_id;
        }

        if(! $model) {
            $model = new \common\customer\RetsNewsletter();
            $model->area_id = $area_id;
        }

        if(WS::$app->request->isPost) {
            $model->load(WS::$app->request->post());
            $model->user_id = WS::$app->user->id;
            if($model->validate()) {
                if($model->save()) {
                    $successMessage = tt('Your Newsletter has been '.(is_null($id) ? 'created' : 'modified').'!', '你的订阅已经'.(is_null($id) ? '创建' : '修改').'完成!');
                    WS::$app->session->setFlash('success', $successMessage);
                    
                    return $this->redirect(['/umember/rets-newsletter/']);
                }
            }
        }

        return $this->render('edit', [
            'model'=>$model,
            'areaId' => $area_id,
            'areas' => $this->areas
        ]);
    }

    public function actionDelete($id)
    {
        $model = \common\customer\RetsNewsletter::find()
            ->where([
                'id'=>$id,
                'user_id'=>WS::$app->user->id
            ])->one();
            
        if($model && $model->id) {
            $model->delete();
        }
        return $this->redirect(['/umember/rets-newsletter/']);
    }
}