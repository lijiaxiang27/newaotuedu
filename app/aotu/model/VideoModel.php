<?php


namespace app\aotu\model;


use think\Model;

class VideoModel extends Model
{

    public function getUrlAttr($value)
    {
        return cmf_get_image_preview_url($value);
    }

}