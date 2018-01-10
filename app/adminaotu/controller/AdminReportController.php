<?php


namespace app\adminaotu\controller;


use app\adminaotu\model\ReportModel;
use cmf\controller\AdminBaseController;
use think\Db;
use think\Request;

/**
 * Class AdminReportController
 * @package app\adminaotu\controller
 * @adminMenuRoot(
 *     'name'   =>'媒体报道',
 *     'action' =>'default',
 *     'parent' =>'',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   =>'thumbs-o-up',
 *     'remark' =>'媒体报道'
 * )
 */
class AdminReportController extends AdminBaseController
{
    /**
     * 媒体报道管理
     * @adminMenu(
     *     'name'   => '媒体报道管理',
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
        $reports = ReportModel::getAll();
        $this->assign('report', $reports);
        return $this->fetch();
    }

    /**
     * 媒体报道编辑
     * @adminMenu(
     *     'name'   => '媒体报道编辑',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '编辑媒体报道信息',
     *     'param'  => ''
     * )
     */
    public function edit($id)
    {
        if (Request::instance()->isPost()){
            $data = Request::instance()->post();
            $rs = $this->validate($data, 'AdminReport');
            if (true !== $rs) {
                $this->error($rs);
            }
            $rst = ReportModel::update($data);
            if ($rst !== false) {
                $this->success("修改成功！", url("AdminReport/index"));
            }
            else {
                $this->error("修改失败！");
            }
        }
        $report = ReportModel::getOne($id);
        $this->assign('report', $report);
        return $this->fetch();
    }

    /**
     * 媒体报道添加
     * @adminMenu(
     *     'name'   => '媒体报道添加',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '添加媒体报道信息',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            $data = Request::instance()->post();
            $rs = $this->validate($data, 'AdminReport');
            if (true !== $rs) {
                $this->error($rs);
            }
            $Report = new ReportModel();
            $rst = $Report->save($data);
            if ($rst !== false) {
                $this->success("添加成功！", url("AdminReport/index"));
            }
            else {
                $this->error("添加失败！");
            }

        }
        return $this->fetch();
    }

    /**
     * 媒体报道删除
     * @adminMenu(
     *     'name'   => '媒体报道删除',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '删除媒体报道信息',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $rs = ReportModel::destroy($id);
        if ($rs) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     * 媒体报道排序
     * @adminMenu(
     *     'name'   => '媒体报道排序',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '媒体报道排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('report'));
        $this->success("排序更新成功！", '');
    }
}