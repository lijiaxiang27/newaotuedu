<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 2017/10/19
 * Time: 下午5:34
 */

namespace app\adminaotu\validate;


use think\Validate;

class AdminProblemValidate extends Validate
{

    protected $rule = [
        'problem' => 'require',
        'answer' => 'require',
    ];

    protected $message = [
        'problem.require' => '问题描述不能为空',
        'answer.require' => '问题回答内容不能为空',
    ];
}