<?php
namespace module\umember\controllers;

use WS;
use yii\data\ActiveDataProvider;

class RetsNewsletterController extends \module\umember\Controller
{
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
        return $this->actionEdit($id);
    }

    public function actionEdit($id=null)
    {
        $this->menuId = 'newsletter';
        
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
                    $successMessage = tt('Your Newsletter has been '.(is_null($id) ? 'created' : 'modified').'!', '你的订阅已经'.(is_null($id) ? '创建' : '修改').'完成!');
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
            
        if($model && $model->id) {
            $model->delete();
        }
        return $this->redirect(['/umember/rets-newsletter/']);
    }
}