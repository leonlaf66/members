<?php
namespace module\umember\controllers;

use WS;

class DefaultController extends \module\umember\Controller
{
    public function actionIndex()
    {
        return $this->redirect('/umember/wishlist/?type=2');
    }
}