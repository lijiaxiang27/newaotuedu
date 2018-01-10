<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 2017/10/19
 * Time: 下午5:34
 */

namespace app\adminaotu\validate;


use think\Validate;

class AdminCoreteamValidate extends Validate
{

    protected $rule = [
        'name' => 'require',
        'description' => 'require',
        'content' => 'require',
        'img' => 'require',
    ];

    protected $message = [
        'name.require' => '投资人姓名不能为空',
        'description.require' => '核心团队描述不能为空',
        'content.require' => '核心团队详情不能为空',
        'img.require' => '请上传核心团队图片',
    ];
}