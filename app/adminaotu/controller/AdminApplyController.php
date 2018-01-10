<?php


namespace app\adminaotu\controller;


use app\adminaotu\model\ApplyModel;
use cmf\controller\AdminBaseController;
use think\Db;
use think\Request;

/**
 * Class AdminApplyController
 * @package app\adminaotu\controller
 * @adminMenuRoot(
 *     'name'   =>'申请合作数据管理',
 *     'action' =>'default',
 *     'parent' =>'',
 *     'display'=> true,
 *     'order'  => 10000,
 *     'icon'   =>'database',
 *     'remark' =>'申请合作数据管理入口'
 * )
 */
class AdminApplyController extends AdminBaseController
{
    /**
     * 申请合作数据管理
     * @adminMenu(
     *     'name'   => '申请合作数据管理',
     *     'parent' => 'default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '申请合作管理',
     *     'param'  => ''
     * )
     */
    public function index()
    {
        $applys = ApplyModel::getAll();
        $this->assign('apply', $applys);
        return $this->fetch();
    }

    /**
     * 申请合作数据查看
     * @adminMenu(
     *     'name'   => '申请合作数据查看',
     *     'parent' => 'default',
     *     'display'=> true,
     *     'hasView'=> true,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '申请合作管理',
     *     'param'  => ''
     * )
     */
    public function detail($id)
    {
        $apply = ApplyModel::getOne($id);
        $this->assign('apply', $apply);
        return $this->fetch();
    }

    /**
     * 申请合作数据删除
     * @adminMenu(
     *     'name'   => '申请合作数据删除',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '删除申请合作数据信息',
     *     'param'  => ''
     * )
     */
    public function delete($id)
    {
        $rs = ApplyModel::destroy($id);
        if ($rs) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     * 申请合作数据标记
     * @adminMenu(
     *     'name'   => '申请合作标记已读',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '申请合作标记已读',
     *     'param'  => ''
     * )
     */
    public function isread($id)
    {
        $rs = ApplyModel::update(['id'=>$id,'status'=>1]);
        if ($rs) {
            $this->success("标记成功！");
        } else {
            $this->error("标记失败！");
        }
    }

    /**
     * 预约咨询
     * @adminMenu(
     *     'name'   => '预约咨询列表',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '预约咨询标记已读',
     *     'param'  => ''
     * )
     */

    public function consult_show()
    {
        $data = db('consult')->paginate(20);

        $this -> assign('data',$data);
        return $this -> fetch();
    }

    /**
     * 预约咨询标记
     * @adminMenu(
     *     'name'   => '预约咨询标记已读',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '预约咨询标记已读',
     *     'param'  => ''
     * )
     */
    public function consult_save(Request $request)
    {
        $where['id'] = $request -> param('id');
        $where['is_read'] = 1;
        if(db('consult')->update($where))
        {
            $this->success("标记成功！");
        }else {
            $this->error("标记失败！");
        }
    }

    /**
     * 预约咨询删除
     * @adminMenu(
     *     'name'   => '预约咨询删除',
     *     'parent' => 'default',
     *     'display'=> false,
     *     'hasView'=> false,
     *     'order'  => 30,
     *     'icon'   => '',
     *     'remark' => '预约咨询删除',
     *     'param'  => ''
     * )
     */
    public function consult_del(Request $request)
    {
        $id = $request -> param('id');
        if(db('consult')->delete($id))
        {
            $this->success("标记成功！");
        }else {
            $this->error("标记失败！");
        }
    }

}