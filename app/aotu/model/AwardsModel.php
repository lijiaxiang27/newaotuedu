<?php
/**
 * User: zhang
 * Date: 2017/11/14
 * Time: 下午5:58
 */

namespace app\aotu\model;


use think\Model;

class AwardsModel extends Model
{
    public function getImgAttr($value)
    {
        return cmf_get_image_preview_url($value);
    }
}