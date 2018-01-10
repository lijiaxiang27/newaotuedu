<?php


namespace app\adminaotu\controller;


use app\adminaotu\model\RecruitModel;
use cmf\controller\AdminBaseController;
use think\Db;
use think\Request;

/**
 * Class AdminRecruitController
 * @package app\adminaotu\controller
 * @adminMenuRoot(
 *     'name'   =>'工作机会',
 *     'action' =>'default',
 *     'parent' =>'',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   =>'laptop',
 *     'remark' =>'工作机会'
 * )
 */
class AdminRecruitController extends AdminBaseController
{
    /**
     * 工作机会管理
     * @adminMenu(
     *     'name'   => '工作机会管理',
     *     'parent' => 'default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '工作机会管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $recruits = RecruitModel::getAll();
        $this->assign('recruit', $recruits);
        return $this->fetch();
    }

    /**
     * 工作机会编辑
     * @adminMenu(
     *     'name'   => '工作机会编辑',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '编辑工作机会信息',
     *     'param'  => ''
     * )
     */
    public function edit($id)
    {
        if (Request::instance()->isPost()){
            $data = Request::instance()->post();
            $rs = $this->validate($data, 'AdminRecruit');
            if (true !== $rs) {
                $this->error($rs);
            }
            $rst = RecruitModel::update($data);
            if ($rst !== false) {
                $this->success("修改成功！", url("AdminRecruit/index"));
            }
            else {
                $this->error("修改失败！");
            }
        }
        $recruit = RecruitModel::getOne($id);
        $this->assign('recruit', $recruit);
        return $this->fetch();
    }

    /**
     * 工作机会添加
     * @adminMenu(
     *     'name'   => '工作机会添加',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '添加工作机会信息',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            $data = Request::instance()->post();
            $rs = $this->validate($data, 'AdminRecruit');
            if (true !== $rs) {
                $this->error($rs);
            }
            $Recruit = new RecruitModel();
            $rst = $Recruit->save($data);
            if ($rst !== false) {
                $this->success("添加成功！", url("AdminRecruit/index"));
            }
            else {
                $this->error("添加失败！");
            }

        }
        return $this->fetch();
    }

    /**
     * 工作机会删除
     * @adminMenu(
     *     'name'   => '工作机会删除',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '删除工作机会信息',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $rs = RecruitModel::destroy($id);
        if ($rs) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     * 工作机会排序
     * @adminMenu(
     *     'name'   => '工作机会排序',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '工作机会排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('recruit'));
        $this->success("排序更新成功！", '');
    }
}