<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 2017/10/19
 * Time: 下午5:34
 */

namespace app\aotu\validate;


use think\Validate;

class AdminApplyValidate extends Validate
{

    protected $rule = [
        'name' => 'require',
        'phone' => 'require|checkUserPhone'
    ];

    protected $message = [
        'name.require' => '投资人姓名不能为空',
        'phone.require' => '请输入手机号',
        'phone.checkUserPhone' => '您输入的手机号码格式有误',

    ];

    /**
     * 用户手机号验证
     * @param $value
     * @return bool|string
     */
    protected function checkUserPhone($value)
    {
        $res = preg_match('/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$|17[0-9]{9}$/', $value);
        if (!$res) {
            return false;
        } else {
            return true;
        }
    }
}