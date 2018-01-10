<?php


namespace app\aotu\model;


use think\Model;

class ApplyModel extends Model
{

    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public static function getOne($id)
    {
        return self::find($id);
    }

    public static function getAll()
    {
        return self::order('id desc,create_time desc')->select();
    }

}