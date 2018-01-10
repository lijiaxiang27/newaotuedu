<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 2017/10/19
 * Time: 下午5:34
 */

namespace app\adminaotu\validate;


use think\Validate;

class AdminRecruitValidate extends Validate
{

    protected $rule = [
        'title' => 'require',
        'duty' => 'require',
        'salary' => 'require',
        'address' => 'require',
        'detail' => 'require',
    ];

    protected $message = [
        'title.require' => '职位名称不能为空',
        'duty.require' => '岗位职责不能为空',
        'salary.require' => '薪资不能为空',
        'address.require' => '工作地点不能为空',
        'detail.require' => '招聘详情不能为空',
    ];
}