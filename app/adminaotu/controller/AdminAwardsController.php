<?php


namespace app\adminaotu\controller;


use app\adminaotu\model\AwardsModel;
use cmf\controller\AdminBaseController;
use think\Db;
use think\Request;

/**
 * Class AdminAwardsController
 * @package app\adminaotu\controller
 * @adminMenuRoot(
 *     'name'   =>'奖项',
 *     'action' =>'default',
 *     'parent' =>'',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   =>'glass',
 *     'remark' =>'奖项'
 * )
 */
class AdminAwardsController extends AdminBaseController
{
    /**
     * 奖项管理
     * @adminMenu(
     *     'name'   => '奖项管理',
     *     'parent' => 'default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '奖项管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $awards = AwardsModel::getAll();
        $this->assign('awards', $awards);
        return $this->fetch();
    }

    /**
     * 奖项编辑
     * @adminMenu(
     *     'name'   => '奖项编辑',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '编辑奖项信息',
     *     'param'  => ''
     * )
     */
    public function edit($id)
    {
        if (Request::instance()->isPost()){
            $data = Request::instance()->post();
            $rs = $this->validate($data, 'AdminAwards');
            if (true !== $rs) {
                $this->error($rs);
            }
            $rst = AwardsModel::update($data);
            if ($rst !== false) {
                $this->success("修改成功！", url("AdminAwards/index"));
            }
            else {
                $this->error("修改失败！");
            }
        }
        $awards = AwardsModel::getOne($id);
        $this->assign('awards', $awards);
        return $this->fetch();
    }

    /**
     * 奖项添加
     * @adminMenu(
     *     'name'   => '奖项添加',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '添加奖项信息',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            $data = Request::instance()->post();
            $rs = $this->validate($data, 'AdminAwards');
            if (true !== $rs) {
                $this->error($rs);
            }
            $Awards = new AwardsModel();
            $rst = $Awards->save($data);
            if ($rst !== false) {
                $this->success("添加成功！", url("AdminAwards/index"));
            }
            else {
                $this->error("添加失败！");
            }

        }
        return $this->fetch();
    }

    /**
     * 奖项删除
     * @adminMenu(
     *     'name'   => '奖项删除',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '删除奖项信息',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $rs = AwardsModel::destroy($id);
        if ($rs) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     * 奖项排序
     * @adminMenu(
     *     'name'   => '奖项排序',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '奖项排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('awards'));
        $this->success("排序更新成功！", '');
    }
}