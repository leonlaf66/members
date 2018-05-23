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

    // 修改邮件地址
    public function actionBindEmailAddress()
    {
        if (WS::$app->request->isPost) {
            if ($account = \common\customer\Account::findOne(WS::$app->user->id)) {
                $userId = WS::$app->user->id;
                $email = WS::$app->request->post('email');

                $targetUrl = WS::$app->params['passport']['baseUrl'];
                $targetUrl .= '/bind-email-address/';
                $targetUrl .= '?token='.md5('USLEJU-'.$userId.'-'.$email).'&uid='.$userId.'&email='.$email;

                $account->sendBindEmail($email, $targetUrl);
                return $this->ajaxJson(true);
            }
        }
        return ajaxJson(false);
    }

    public function actionBindPhone()
    {
        $this->menuId = 'bind-phone';

        return $this->render('bind-phone');
    }

    /*绑定微信帐号*/
    public function actionBindWechat($code = null)
    {
        $options = WS::$app->params['wechat'];
        $wxadv = new \common\wechat\WXAdv($options['appId'], $options['appSecret']);
        if ($openId = $wxadv->get_open_id($code)) {
            $db = WS::$app->db;
            $userId = WS::$app->user->id;

            $db->createCommand() // 更新user.open_id
                ->update(
                    'member', [
                        'open_id' => $openId
                    ],
                    'id=:id', [
                        ':id' => $userId
                    ]
                )->execute();

            if ($userInfo = $wxadv->get_user_info($openId)) {
                // 写入profile.name
                if ((new \yii\db\Query())->from('member_profile')->where(['user_id' => $userId])->exists()) {
                    $db->createCommand() // 更新name，仅更新name为null的
                        ->update('member_profile', ['name' => $userInfo['nickname']], 'user_id=:id and name is null', [':id' => $userId])->execute();
                } else { // 不存在时创建
                    $db->createCommand()
                        ->insert([
                            'user_id' => $userId,
                            'name' => $userInfo['nickname'],
                            'from' => $userInfo['country'] === '中国' ? 'cn' : 'us'
                        ])
                        ->execute();
                }
            }

            // 停用掉原有微信帐号
            $db->createCommand()
                ->update('member', [
                    'flags' => 1
                ], 'open_id=:open_id and id<>:id', [
                    ':id' => $userId,
                    ':open_id' => $openId
                ])->execute();
        }

        WS::$app->session->setFlash('success', 'Your wechat has been binded!');
        return $this->redirect(['/account/']);
    }

    /*解绑微信帐号*/
    public function actionUnbindWechat()
    {
        $db = WS::$app->db;
        $userId = WS::$app->user->id;

        $db->createCommand() // 设定open_id为null即可
            ->update('member', ['open_id' => null], 'id=:id', [':id' => $userId])
            ->execute();

        WS::$app->session->setFlash('success', 'Your wechat has been unbinded!');
        return $this->redirect(['/account/']);
    }
}