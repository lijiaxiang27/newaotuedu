<?php
/**
 * User: zhang
 * Date: 2017/11/16
 * Time: 上午10:07
 */

namespace app\aotu\model;


use think\Model;

class CoreteamModel extends Model
{
    public function getImgAttr($value)
    {
        return cmf_get_image_preview_url($value);
    }
}