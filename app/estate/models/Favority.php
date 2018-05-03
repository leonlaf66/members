<?php
namespace module\estate\models;

class Favority extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'house_member_favority';
    }

    public static function findByUserId($userId)
    {
        return self::find()
            ->where(['user_id'=>$userId])
            ->orderBy('created_at', 'DESC')
            ->limit(1000);
    }

    public function getRets()
    {
        return Rets::findOne($this->list_no);
    }

    public function getUser()
    {
        return $this->hasOne(\common\customer\Account::className(), ['id'=>'user_id'])->one();
    }

    public static function addOrRemove($listNo, $userId)
    {
        if(self::have($listNo, $userId)) {
            return self::remove($listNo, $userId);
        }

        return self::add($listNo, $userId);
    }

    public static function add($listNo, $userId)
    {
        if(self::have($listNo, $userId)) {
            return null;
        }

        $areaId = \WS::$app->area->id;

        $rets = null;
        if ($areaId === 'ma') {
            $rets = \common\estate\Rets::findOne($listNo);
        } else {
            $rets = \common\listhub\estate\House::findOne($listNo);
        }

        if(! $rets) {
            return null;
        }

        $m = new self();
        $m->user_id = $userId;
        $m->list_no = $listNo;
        $m->property_type = $rets->prop_type;
        $m->created_at = date('Y-m-d H:i:s');
        $m->area_id = $areaId;

        return $m->save();
    }

    public static function remove($listNo, $userId)
    {
        if(!self::have($listNo, $userId)) {
            return null;
        }

        $item = self::findByListNo($listNo);
        if(! $item) {
            return null;
        }

        return $item->delete() > 0;
    }

    public static function findByListNo($listNo)
    {
        return self::find()->where(['list_no' => $listNo])->one();
    }

    public static function have($listNo, $userId)
    {
        return self::find()->where(['list_no'=>$listNo, 'user_id'=>$userId])->exists();
    }

    public static function search()
    {
        $m = new self();
        
        return new \yii\data\ActiveDataProvider([
            'query' => $m->find(),
            'pagination' => [
                'pagesize' => 15
             ]
        ]);
    }
}