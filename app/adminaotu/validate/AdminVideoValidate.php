<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 2017/10/19
 * Time: 下午5:34
 */

namespace app\adminaotu\validate;


use think\Validate;

class AdminVideoValidate extends Validate
{

    protected $rule = [
        'title' => 'require',
        'img' => 'require',
        'url' => 'require',
    ];

    protected $message = [
        'title.require' => '视频名称不能为空',
        'img.require' => '视频缩略图不能为空',
        'url.require' => '请上传视频',
    ];
}