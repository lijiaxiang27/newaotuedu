<?php


namespace app\adminaotu\model;


use think\Model;

class RecruitModel extends Model
{

    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public function getDetailAttr($value)
    {
        return cmf_replace_content_file_url(htmlspecialchars_decode($value));
    }

    public function getCreateTimeAttr($value)
    {
        return date("Y-m-d H:i:s", $value);
    }

    public static function getOne($id)
    {
        return self::find($id);
    }

    public static function getAll()
    {
        return self::order('id desc,list_order asc')->paginate(20);
    }
}