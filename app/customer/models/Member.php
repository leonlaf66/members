<?php
namespace module\customer\models;

class Member extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'member';
    }

    public function getName()
    {
        $name = (new \yii\db\Query())
            ->select('name')
            ->from('member_profile')
            ->where(['user_id' => $this->id])
            ->scalar();

        if (! $name) {
            $name = explode('@', $this->email)[0];
        }

        return $name;
    }
}