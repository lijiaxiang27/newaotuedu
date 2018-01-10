<?php


namespace app\adminaotu\controller;


use app\adminaotu\model\VideoModel;
use cmf\controller\AdminBaseController;
use think\Db;
use think\Request;

/**
 * Class AdminVideoController
 * @package app\adminaotu\controller
 * @adminMenuRoot(
 *     'name'   =>'官方视频',
 *     'action' =>'default',
 *     'parent' =>'',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   =>'youtube-play',
 *     'remark' =>'官方视频管理入口'
 * )
 */
class AdminVideoController extends AdminBaseController
{
    /**
     * 官方视频管理
     * @adminMenu(
     *     'name'   => '官方视频管理',
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
        $videos = VideoModel::getAll();
        $this->assign('video', $videos);
        return $this->fetch();
    }

    /**
     * 官方视频编辑
     * @adminMenu(
     *     'name'   => '官方视频编辑',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '编辑官方视频信息',
     *     'param'  => ''
     * )
     */
    public function edit($id)
    {
        if (Request::instance()->isPost()){
            $data = Request::instance()->post();
            $rs = $this->validate($data, 'AdminVideo');
            if (true !== $rs) {
                $this->error($rs);
            }
            $rst = VideoModel::update($data);
            if ($rst !== false) {
                $this->success("修改成功！", url("AdminVideo/index"));
            }
            else {
                $this->error("修改失败！");
            }
        }
        $video = VideoModel::getOne($id);
        $this->assign('video', $video);
        return $this->fetch();
    }

    /**
     * 官方视频添加
     * @adminMenu(
     *     'name'   => '官方视频添加',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '添加官方视频信息',
     *     'param'  => ''
     * )
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            $data = Request::instance()->post();
            $rs = $this->validate($data, 'AdminVideo');
            if (true !== $rs) {
                $this->error($rs);
            }
            $video = new VideoModel();
            $rst = $video->save($data);
            if ($rst !== false) {
                $this->success("添加成功！", url("AdminVideo/index"));
            }
            else {
                $this->error("添加失败！");
            }

        }
        return $this->fetch();
    }

    /**
     * 官方视频删除
     * @adminMenu(
     *     'name'   => '官方视频删除',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '删除官方视频信息',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $rs = VideoModel::destroy($id);
        if ($rs) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     * 官方视频排序
     * @adminMenu(
     *     'name'   => '官方视频排序',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '官方视频排序',
     *     'param'  => ''
     * )
     */
    public function listOrder()
    {
        parent::listOrders(Db::name('video'));
        $this->success("排序更新成功！", '');
    }
}