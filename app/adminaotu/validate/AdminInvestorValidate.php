<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 2017/10/19
 * Time: 下午5:34
 */

namespace app\adminaotu\validate;


use think\Validate;

class AdminInvestorValidate extends Validate
{

    protected $rule = [
        'name' => 'require',
        'description' => 'require',
        'avatar' => 'require',
        'square_avatar' => 'require',
        'video' => 'require',
    ];

    protected $message = [
        'name.require' => '投资人姓名不能为空',
        'description.require' => '投资人描述不能为空',
        'avatar.require' => '请上传投资人头像(圆形)',
        'square_avatar.require' => '请上传投资人头像(方形)',
        'video.require' => '请上传投资人视频',
    ];
}