<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/25/025
 * Time: 15:53
 */

namespace app\aotu\validate;


use think\Validate;

class ConsultValidate extends Validate
{
    //todo……
    protected $rule = [
        'name'     => 'require',
        'phone'    => 'require|checkUserPhone',
        'province' => 'require',
        'city'     => 'require'
    ];

    protected $message = [
        'name'     => '姓名不能为空',
        'phone'    => '手机号不能为空',
        'province' => '省不能为空',
        'city'     => '市不能为空'
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
            return '您输入的手机号码格式有误';
        } else {
            return true;
        }
    }
}