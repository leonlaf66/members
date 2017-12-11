<?php
namespace module\estate\helpers;

use WS;
use \yii\helpers\ArrayHelper as AH;

class Rets extends \common\estate\helpers\Rets
{
    public static function getUrl($rets)
    {
        $typeName = $rets->prop_type == 'RN' ? 'lease' : 'purchase';
        $listNo = $rets->list_no ?? $rets->id;
        return WS::$app->houseBaseUrl."{$typeName}/{$listNo}/";
    }

    public static function getModule()
    {
        return WS::$app->getModule('estate');
    }
}