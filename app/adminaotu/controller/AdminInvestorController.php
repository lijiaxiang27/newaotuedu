<?php


namespace app\adminaotu\controller;


use app\adminaotu\model\InvestorModel;
use cmf\controller\AdminBaseController;
use think\Db;
use think\Request;

/**
 * Class AdminInvestorController
 * @package app\adminaotu\controller
 * @adminMenuRoot(
 *     'name'   =>'投资人管理',
 *     'action' =>'default',
 *     'parent' =>'',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   =>'users',
 *     'remark' =>'投资人管理入口'
 * )
 */
class AdminInvestorController extends AdminBaseController
{
    /**
     * 投资人管理
     * @adminMenu(
     *     'name'   => '投资人管理',
     *     'parent' => 'default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '媒体报道管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $investors = InvestorModel::getAll();
        $this->assign('investor', $investors);
        return $this->fetch();
    }

    /**
     * 投资人编辑
     * @adminMenu(
     *     'name'   => '投资人编辑',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '编辑投资人信息',
     *     'param'  => ''
     * )
     */
    public function edit($id)
    {
        if (Request::instance()->isPost()){
            $data = Request::instance()->post();
            $rs = $this->validate($data, 'AdminInvestor');
            if (true !== $rs) {
                $this->error($rs);
            }
            $rst = InvestorModel::update($data);
            if ($rst !== false) {
                $this->success("修改成功！", url("AdminInvestor/index"));
            }
            else {
                $this->error("修改失败！");
            }
        }
        $investor = InvestorModel::getOne($id);
        $this->assign('investor', $investor);
        return $this->fetch();
    }

    /**
     * 投资人添加
     * @adminMenu(
     *     'name'   => '投资人添加',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '添加投资人信息',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            $data = Request::instance()->post();
            $rs = $this->validate($data, 'AdminInvestor');
            if (true !== $rs) {
                $this->error($rs);
            }
            $investor = new InvestorModel();
            $rst = $investor->save($data);
            if ($rst !== false) {
                $this->success("添加成功！", url("AdminInvestor/index"));
            }
            else {
                $this->error("添加失败！");
            }

        }
        return $this->fetch();
    }

    /**
     * 投资人删除
     * @adminMenu(
     *     'name'   => '投资人删除',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '删除投资人信息',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $rs = InvestorModel::destroy($id);
        if ($rs) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     * 投资人排序
     * @adminMenu(
     *     'name'   => '投资人排序',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '投资人排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('investor'));
        $this->success("排序更新成功！", '');
    }
}