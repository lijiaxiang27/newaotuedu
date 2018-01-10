<?php
/**
 * User: zhang
 * Date: 2017/11/14
 * Time: 下午5:39
 */

namespace app\aotu\model;


use think\Model;

class SlideItemModel extends Model
{

    public function getImageAttr($value)
    {
        return cmf_get_image_preview_url($value);
    }
}