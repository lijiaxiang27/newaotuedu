<?php


namespace app\adminaotu\controller;


use app\adminaotu\model\ProblemModel;
use cmf\controller\AdminBaseController;
use think\Db;
use think\Request;

/**
 * Class AdminProblemController
 * @package app\adminaotu\controller
 * @adminMenuRoot(
 *     'name'   =>'常见问题',
 *     'action' =>'default',
 *     'parent' =>'',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   =>'question-circle',
 *     'remark' =>'常见问题'
 * )
 */
class AdminProblemController extends AdminBaseController
{
    /**
     * 常见问题管理
     * @adminMenu(
     *     'name'   => '常见问题管理',
     *     'parent' => 'default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '常见问题管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $problems = ProblemModel::getAll();
        $this->assign('problem', $problems);
        return $this->fetch();
    }

    /**
     * 常见问题编辑
     * @adminMenu(
     *     'name'   => '常见问题编辑',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '编辑常见问题信息',
     *     'param'  => ''
     * )
     */
    public function edit($id)
    {
        if (Request::instance()->isPost()){
            $data = Request::instance()->post();
            $rs = $this->validate($data, 'AdminProblem');
            if (true !== $rs) {
                $this->error($rs);
            }
            $rst = ProblemModel::update($data);
            if ($rst !== false) {
                $this->success("修改成功！", url("AdminProblem/index"));
            }
            else {
                $this->error("修改失败！");
            }
        }
        $problem = ProblemModel::getOne($id);
        $this->assign('problem', $problem);
        return $this->fetch();
    }

    /**
     * 常见问题添加
     * @adminMenu(
     *     'name'   => '常见问题添加',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '添加常见问题信息',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            $data = Request::instance()->post();
            $rs = $this->validate($data, 'AdminProblem');
            if (true !== $rs) {
                $this->error($rs);
            }
            $Problem = new ProblemModel();
            $rst = $Problem->save($data);
            if ($rst !== false) {
                $this->success("添加成功！", url("AdminProblem/index"));
            }
            else {
                $this->error("添加失败！");
            }

        }
        return $this->fetch();
    }

    /**
     * 常见问题删除
     * @adminMenu(
     *     'name'   => '常见问题删除',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '删除常见问题信息',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $rs = ProblemModel::destroy($id);
        if ($rs) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     * 常见问题排序
     * @adminMenu(
     *     'name'   => '常见问题排序',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '常见问题排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('problem'));
        $this->success("排序更新成功！", '');
    }
}