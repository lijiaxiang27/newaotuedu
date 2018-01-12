<?php
/**
 * Used To    :
 * Author     : lijiaxiang <1612883775@qq.com>
 * CreateTime : 2018/1/12 上午11:10
 */

namespace app\admin\controller;

use think\Db;
use cmf\controller\HomeBaseController;
use think\Request;

class ApiController extends  HomeBaseController
{
    public function get_city(Request $request)
    {
        $id = $request -> param('pid');
        $city  = Db::name('china') -> where('pid',$id) -> select();

        return json($city);
    }
}
