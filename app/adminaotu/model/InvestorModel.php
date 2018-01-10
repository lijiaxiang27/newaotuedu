<?php


namespace app\adminaotu\model;


use think\Model;

class InvestorModel extends Model
{

    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public static function getOne($id)
    {
        return self::find($id);
    }

    public static function getAll()
    {
        return self::order('id desc,list_order asc')->limit(8)->select();
    }
}