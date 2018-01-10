<?php


namespace app\adminaotu\controller;


use app\adminaotu\model\CoreteamModel;
use cmf\controller\AdminBaseController;
use think\Db;
use think\Request;

/**
 * Class AdminCoreteamController
 * @package app\adminaotu\controller
 * @adminMenuRoot(
 *     'name'   =>'核心团队管理',
 *     'action' =>'default',
 *     'parent' =>'',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   =>'thumbs-o-up',
 *     'remark' =>'核心团队管理入口'
 * )
 */
class AdminCoreteamController extends AdminBaseController
{
    /**
     * 核心团队管理
     * @adminMenu(
     *     'name'   => '核心团队管理',
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
        $coreteams = CoreteamModel::getAll();
        $this->assign('coreteam', $coreteams);
        return $this->fetch();
    }

    /**
     * 核心团队编辑
     * @adminMenu(
     *     'name'   => '核心团队编辑',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '编辑核心团队信息',
     *     'param'  => ''
     * )
     */
    public function edit($id)
    {
        if (Request::instance()->isPost()){
            $data = Request::instance()->post();
            $rs = $this->validate($data, 'AdminCoreteam');
            if (true !== $rs) {
                $this->error($rs);
            }
            $rst = CoreteamModel::update($data);
            if ($rst !== false) {
                $this->success("修改成功！", url("AdminCoreteam/index"));
            }
            else {
                $this->error("修改失败！");
            }
        }
        $coreteam = CoreteamModel::getOne($id);
        $this->assign('coreteam', $coreteam);
        return $this->fetch();
    }

    /**
     * 核心团队添加
     * @adminMenu(
     *     'name'   => '核心团队添加',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '添加核心团队信息',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            $data = Request::instance()->post();
            $rs = $this->validate($data, 'AdminCoreteam');
            if (true !== $rs) {
                $this->error($rs);
            }
            $coreteam = new CoreteamModel();
            $rst = $coreteam->save($data);
            if ($rst !== false) {
                $this->success("添加成功！", url("AdminCoreteam/index"));
            }
            else {
                $this->error("添加失败！");
            }

        }
        return $this->fetch();
    }

    /**
     * 核心团队删除
     * @adminMenu(
     *     'name'   => '核心团队删除',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '删除核心团队信息',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $rs = CoreteamModel::destroy($id);
        if ($rs) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     * 核心团队排序
     * @adminMenu(
     *     'name'   => '核心团队排序',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '核心团队排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('coreteam'));
        $this->success("排序更新成功！", '');
    }
}