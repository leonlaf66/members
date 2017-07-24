<?php
namespace module\umember\controllers;

use WS;

class ProfileController extends \module\umember\Controller
{
    public function actionIndex($prompt=null, $callback=null)
    {
        $userId = WS::$app->user->id;
        $profile = \common\customer\Profile::findOne($userId);
        if(! $profile) {
            $profile = new \common\customer\Profile();
            $profile->user_id = $userId;
        }

        $req = WS::$app->request;
        if($req->isPost) {
            $profile->load($req->post());
            if($profile->validate()) {
                if($profile->save()) {
                    WS::$app->session->setFlash('success', 'Your profile has been modified!');
                    if($callback) {
                        return $this->redirect($callback);
                    }
                    return $this->redirect(['/umember/profile/']);
                }
            }
        }

        if($prompt) {
            WS::$app->session->setFlash('info', 'Please improve your profile in advance!');
        }

        return $this->render('index', [
            'profile'=>$profile
        ]);
    }
}