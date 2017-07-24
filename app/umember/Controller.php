<?php
namespace module\umember;

use WS;

class Controller extends \module\core\Controller
{
    public function beforeAction($action)
    {
        if(WS::$app->user->isGuest) {
            return $this->redirect(WS::$app->loginUrl.'?back='.WS::$app->request->getHostInfo().WS::$app->request->url);
        }

        if($this->id !== 'profile') {
            $userId = WS::$app->user->id;
            $profile = \common\customer\Profile::findOne($userId);
            if(!$profile || !$profile->phone_number) {
                return $this->redirect(['/umember/profile/', 'prompt'=>1]);
            }
        }

        return parent::beforeAction($action);
    }
}