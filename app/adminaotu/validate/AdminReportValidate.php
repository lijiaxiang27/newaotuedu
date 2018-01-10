<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 2017/10/19
 * Time: 下午5:34
 */

namespace app\adminaotu\validate;


use think\Validate;

class AdminReportValidate extends Validate
{

    protected $rule = [
        'description' => 'require',
        'source' => 'require',
        'img' => 'require',
    ];

    protected $message = [
        'description.require' => '描述不能为空',
        'source.require' => '请填写信息来源',
        'img.require' => '请上传媒体图片',
    ];
}