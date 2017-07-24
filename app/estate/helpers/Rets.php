<?php
namespace module\estate\helpers;

use WS;
use \yii\helpers\ArrayHelper as AH;

class Rets extends \common\estate\helpers\Rets
{
    public static function getUrl($rets)
    {
        $typeName = $rets->prop_type == 'RN' ? 'lease' : 'purchase';
        return WS::$app->houseBaseUrl."{$typeName}/{$rets->list_no}/";
    }

    public static function getModule()
    {
        return WS::$app->getModule('estate');
    }
}