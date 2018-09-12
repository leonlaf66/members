<?php
namespace module\umember\controllers;

use WS;

class WishlistController extends \module\umember\Controller
{
    public function actionIndex($type='1')
    {
        $this->menuId = $type === '1' ? 'wishlist-rental' : 'wishlist-sell';
        $results = WS::$app->graphql->request('house-favorites', [
            'is_rental' => $type === '1'
        ])->find_favorite_houses->items;

        return $this->render('index', [
            'is_rental' => $type == 1,
            'typeName' => $type == 1 ? 'Rental' : 'Buy & Sell',
            'wishlist' => $results
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