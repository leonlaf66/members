<?php
namespace module\customer\models;

class MemberProfile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'member_profile';
    }

    public static function primaryKey()
    {
        return ['user_id'];
    }
}