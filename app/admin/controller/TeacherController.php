<?php
/**
 * Used To    :
 * Author     : lijiaxiang <1612883775@qq.com>
 * CreateTime : 2018/1/10 下午3:53
 */

namespace app\admin\controller;

use think\db;
use cmf\controller\AdminBaseController;
use think\Request;

class TeacherController extends AdminBaseController
{
    /**
     * 教师展示页
     * @return mixed
     */
    public function index()
    {
        //获取教师数据
        $teachers = Db::name('teachers') -> order('t_order','desc') -> select();
        $this -> assign('teachers',$teachers);
        return $this -> fetch();
    }

    /**
     * 教师添加页
     * @param Request $param
     * @return mixed
     */
    public function add(Request $param)
    {
        //展示添加页面
        if ($param -> isGet())
        {
            return $this -> fetch();
        }

        //添加讲师数据
        if ($param -> isPost())
        {
            $post = $param -> param();
            if(Db::name('teachers') -> insert($post))
            {
                $this -> success('添加成功');
            }else{
                $this -> error('添加失败');
            }


        }

    }

    /**
     * 讲师修改页面
     * @param Request $param
     * @return mixed
     */
    public function edit(Request $param)
    {
        //展示当前数据
        if ($param -> isGet())
        {
            $t_id = $param -> param('t_id');
            $teacher = Db::name('teachers') -> find($t_id);
            $this -> assign('teacher',$teacher);
            return $this -> fetch();
        }
        //处理修改后的数据
        if ($param -> isPost())
        {
            $data = $param -> param();
            if (Db::name('teachers') -> update($data))
            {
                $this -> success('修改成功');
            }else{
                $this -> error('修改失败');
            }

        }
    }

    /**
     * 删除讲师数据
     */
    public function del()
    {
        $t_id = Request::instance() -> param();
        if (Db::name('teachers')->delete($t_id))
        {
            $this -> success('删除成功');
        }else{
            $this -> error('修改失败');
        }
    }

}