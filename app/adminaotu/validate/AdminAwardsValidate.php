<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 2017/10/19
 * Time: 下午5:34
 */

namespace app\adminaotu\validate;


use think\Validate;

class AdminAwardsValidate extends Validate
{

    protected $rule = [
        'description' => 'require',
        'img' => 'require',
    ];

    protected $message = [
        'description.require' => '描述不能为空',
        'img.require' => '请上传奖项图片',
    ];
}