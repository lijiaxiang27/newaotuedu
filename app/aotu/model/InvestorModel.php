<?php


namespace app\aotu\model;


use think\Model;

class InvestorModel extends Model
{

    public function getVideoAttr($value)
    {
        return cmf_get_image_preview_url($value);
    }

    public function getSquareAvatarAttr($value)
    {
        return cmf_get_image_preview_url($value);
    }

    public function getAvatarAttr($value)
    {
        return cmf_get_image_preview_url($value);
    }

}