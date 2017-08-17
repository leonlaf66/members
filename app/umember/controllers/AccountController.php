<?php
namespace module\umember\controllers;

use WS;

class AccountController extends \module\umember\Controller
{
    public function actionIndex()
    {
        $this->menuId = 'account';

        $account = \common\customer\Account::findOne(\WS::$app->user->id);

        return $this->render('index', [
            'account' => $account
        ]);
    }
    public function actionModifyPassword()
    {
        $this->menuId = 'account';
        
        $form = new \common\customer\account\ModifyPasswordForm();
        $form->user_id = WS::$app->user->id;

        if(WS::$app->request->isPost) {
            $form->load(WS::$app->request->post());
            if($form->validate()) {
                if($form->modifyPassword()) {
                    WS::$app->session->setFlash('success', 'Your password has been modified!');
                }
            }
        }

        return $this->render('modify-password', ['modifyPasswordForm'=>$form]);
    }

    public function actionBindPhone()
    {
        $this->menuId = 'bind-phone';

        return $this->render('bind-phone');
    }
}