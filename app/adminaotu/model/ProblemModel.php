<?php


namespace app\adminaotu\model;


use think\Model;

class ProblemModel extends Model
{

    public static function getOne($id)
    {
        return self::find($id);
    }

    public static function getAll()
    {
        return self::order('id desc,list_order asc')->select();
    }
}