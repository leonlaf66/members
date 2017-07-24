<?php
namespace module\umember\controllers;

use WS;

class WishlistController extends \module\umember\Controller
{
    public function actionIndex($type=1)
    {
        $wishlistQuery = \common\customer\RetsFavorite::findByUserId(WS::$app->user->id);
        if($type == 1) {
            $wishlistQuery->andWhere(['property_type'=>'RN']);
        }
        else {
            $wishlistQuery->andWhere("property_type<>'RN'");
        }
        $wishlist = $wishlistQuery->all();

        return $this->render('index', [
            'typeName'=>$type == 1 ? 'Rental' : 'Buy & Sell',
            'wishlist'=>$wishlist
        ]);
    }

    public function actionRemove($id)
    {
        if($wishlist = \common\customer\RetsFavorite::findOne($id)) {
            if($wishlist->user_id == WS::$app->user->id) {
                $wishlist->delete();
            }
        }
        return true;
    }
}