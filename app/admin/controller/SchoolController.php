<?php
/** 校区管理
 * Used To    :
 * Author     : lijiaxiang <1612883775@qq.com>
 * CreateTime : 2018/1/11 下午5:07
 */

namespace app\admin\controller;


use cmf\controller\AdminBaseController;
use think\Db;
use think\Request;

class SchoolController extends AdminBaseController
{
    /**
     * 校区展示页
     * @return mixed
     */
    public function index()
    {
        $where = '';
        //post 请求为查询操作
        if (Request::instance() -> isPost())
        {
            //设置初始状态
            $stu = false;
            //获取查询参数
            $param = Request::instance() -> param();
            //处理查询参数
            foreach ($param as $k =>  $v) {
                //跳过省参数
                if($k=='province') continue;
                if ($v != '')
                {
                    $stu = true;
                }
                $where .= $k.' like "%'.$v.'%" and ';
            }

            //如果除了省之外没有传递其他数据 则查询省信息
            if ($param['province']!='' && !$stu)
            {
                $s_province = Db::name('china')
                    ->  field('id')
                    ->  where('pid=0 and name like "'.$param['province'].'%"')
                    ->  find();
                $where .= 'province_id = '.$s_province['id'];

            }else{
                //补全where 条件最后的and
                $where .= '1=1';
            }
            //将查询条件传递回前台
            $this -> assign('param',$param);
        }

        //获取校区及其所在市
        $schools  =  Db::name('school_china_view')
                  -> where($where)
                  -> paginate(20);

        //获取省
        $province = $this -> _get_province_do();

        $this -> assign('province',$province);
        $this -> assign('schools',$schools);
        $this -> assign('page',$schools->render());

        return $this -> fetch();



    }

    /**
     * 添加校区
     * @param Request $request
     * @return mixed
     */
    public function add(Request $request)
    {
        //展示WEB页面
        if ($request -> isGet())
        {
            $province = $this -> _get_province_do();

            $this -> assign('province',$province);

            return $this -> fetch();
        }

        //提交数据处理
        if ($request -> isPost())
        {
            $params = $request -> param();
            //数据验证
            $check = $this -> _check_params($params);
            if($check !== true)
            {
                $this -> error($check);
            }

            if(Db::name('school') -> insert($params))
            {
                $this -> success('添加成功');
            }else{
                $this -> error('添加失败');
            }
        }
    }

    /**
     * 校区修改
     * @param Request $request
     * @return mixed
     */
    public function save(Request $request)
    {
        //修改页面
        if ($request -> isGet())
        {
            $id = $request -> param('id');
            $school = Db::name('school') -> find($id);
            //获取当前省份下的所有市
            $city = Db::name('china')
                    ->field('pid',true)
                    ->where('pid',$school['province_id'])
                    ->select();
            //获取所有省
            $provinces = $this -> _get_province_do();

            $this -> assign('school',$school);
            $this -> assign('provinces',$provinces);
            $this -> assign('city',$city);

            return $this -> fetch();
        }

        //修改处理
        if ($request -> isPost())
        {
            $params = $request -> param();
            //数据验证
            $check = $this -> _check_params($params);
            if($check !== true)
            {
                $this -> error($check);
            }

            if(Db::name('school') -> update($params))
            {
                $this -> success('修改成功');
            }else{
                $this -> error('修改失败');
            }
        }
    }

    public function del(Request $request)
    {
        $id = $request -> param('id');

        if (Db::name('school')->delete($id))
        {
            $this -> success('删除成功');
        }else{
            $this -> error('删除失败');
        }
    }

    /**
     * 获取所有一级省/市 并处理为ID => NAME 的形式
     * @param $province
     * @return array
     */
    private  function _get_province_do()
    {
        //获取所有的省
        $province = Db::name('china') ->field('pid',true) ->  where('pid',0) -> select();
        unset($province[0]);
        $new_province = array();
        foreach ($province as $v)
        {
            $new_province[$v['id']] = $v['name'];
        }
        return $new_province;
    }

    /**
     * 数据验证
     * @param $data
     * @return bool|string
     */
    private function _check_params($data)
    {
        //数据验证非空
        foreach ($data as $v)
        {
            if ($v == '')
            {
                return '非法数据';break;
            }
        }

        return true;
    }
}