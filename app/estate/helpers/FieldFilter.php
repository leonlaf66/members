<?php
namespace module\estate\helpers;

use WS;

class FieldFilter
{
    public static function url($listNo, $isNotRN = true)
    {
        $typeName = $isNotRN ? 'purchase' : 'lease';
        return WS::$app->houseBaseUrl."{$typeName}/{$listNo}/";
    }

    public static function money($val, $full = true)
    {
        if ($unknownVal = self::unknown($val, false)) return $unknownVal;

        if (\WS::$app->language === 'zh-CN') {
            if ($val > 10000) {
                $val = number_format($val / 10000.0, 2);
                if (!$full) return $val;

                return $val.' 万美元';
            } else {
                $val = number_format($val, 0);
                if (!$full) return $val;

                return $val.' 美元';
            }
        }
        $val = number_format($val, 0);
        if (!$full) return $val;

        return '$'.$val;
    }

    public static function square($val)
    {
        if ($unknownVal = self::unknown($val, false)) return $unknownVal;

        if (\WS::$app->language === 'zh-CN') {
            return intval($val * 0.092903).' 平方米';
        }
        return intval($val).' Sq.Ft';
    }

    public static function statusName($status, $prop)
    {
        if($status === 'NEW') {
            $name = $prop === 'LD' ? '新出售' : '新房源';
            return \WS::$app->language === 'zh-CN' ? $name : 'New';
        }

        $activeCnNm = $prop === 'RN' ? '出租' : '销售';
        if (in_array($status, ['ACT', 'BOM', 'PCG', 'RAC', 'EXT'])) {
            return \WS::$app->language === 'zh-CN' ? $activeCnNm.'中' : 'Active';
        }

        return \WS::$app->language === 'zh-CN' ? '已'.$activeCnNm : 'Sold';
    }

    public static function housePropName($prop)
    {
        $props = [
            'RN' => ['Rental', '租房'],
            'SF' => ['Single Family', '单家庭'],
            'MF' => ['Multi Family', '多家庭'],
            'CC' => ['Condominium', '公寓'],
            'CI' => ['Commercial', '商业用房'],
            'BU' => ['Business Opportunity', '营业用房'],
            'LD' => ['Land', '土地']
        ];

        return tt($props[$prop]);
    }

    public static function unknown($val, $returnRaw = true)
    {
        return $val != '0' && empty($val) ? tt('Unknown', '未提供') : ($returnRaw ? $val : false);
    }
}