<?php
namespace module\estate\models;

class Rets extends \yii\db\ActiveRecord
{
    protected $retsData = null;

    public static function tableName()
    {
        return 'house_data_v2';
    }

    public function isMls()
    {
        return $this->mls_data !== '{}';
    }

    public function getPhotoUrl()
    {
        if ($this->isMls()) {
            return "http://media.mlspin.com/Photo.aspx?mls={$this->list_no}&n=0&w=800&h=800";
        }
        return "http://photos.listhub.net/MLSLINY/{$this->list_no}/1";
    }

    public function getTitle()
    {
        
    }

    public function getStatusName()
    {

    }

    public function getListPrice()
    {

    }

    public function getData()
    {
        if (is_null($this->retsData)) {
            $this->retsData = $this->isMls()
                ? json_decode($this->mls_data)
                : simplexml_load_string($this->listhub_data);
        }
        return $this->retsData;
    }
}