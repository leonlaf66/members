<?php
namespace module\umember\controllers;

use WS;
use yii\data\ActiveDataProvider;

class RetsNewsletterController extends \module\umember\Controller
{
    public function actionIndex($type=1)
    {
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
        var_dump("RetsNewsletterController:update");exit;
        return $this->actionEdit($id);
    }

    public function actionEdit($id=null)
    {
        $model = null;
        if(! is_null($id)) {
            $model = \common\customer\RetsNewsletter::find()
                ->where([
                    'id'=>$id,
                    'user_id'=>WS::$app->user->id
                ])->one();
        }
        if(! $model)
            $model = new \common\customer\RetsNewsletter();

        if(WS::$app->request->isPost) {
            $model->load(WS::$app->request->post());
            $model->user_id = WS::$app->user->id;
            if($model->validate()) {
                if($model->save()) {
                    $successMessage = 'Your Newsletter has been '.(is_null($id) ? 'modified' : 'created').'!';
                    WS::$app->session->setFlash('success', $successMessage);
                    
                    return $this->redirect(['/umember/rets-newsletter/']);
                }
            }
        }

        return $this->render('edit', ['model'=>$model]);
    }

    public function actionDelete($id)
    {
        $model = \common\customer\RetsNewsletter::find()
            ->where([
                'id'=>$id,
                'user_id'=>WS::$app->user->id
            ])->one();
            
        if($model->id) {
            $model->delete();
        }
        return $this->redirect(['/umember/rets-newsletter/']);
    }
}