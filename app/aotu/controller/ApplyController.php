<?php

/**
 * User: zhang
 * Date: 2017/10/20
 * Time: 下午4:34
 */
namespace app\aotu\controller;

use app\aotu\model\ApplyModel;
use app\aotu\model\ConsultModel;
use cmf\controller\HomeBaseController;
use think\Request;
use app\aotu\validate;

class applyController extends HomeBaseController
{

    /**
     * 申请合作数据添加
     */
    public function getApplyData(){
        $data = Request::instance()->post();
        $rs = $this->validate($data, 'AdminApply');
        if (true !== $rs) {
            return json(['code' => 300, 'msg' => $rs]);
        }
        $investor = new ApplyModel();
        $rst = $investor->save($data);
        if ($rst !== false) {
            $arr = ['code' => 200, 'msg' => '提交成功！'];
        }
        else {
            $arr = ['code' => 400, 'msg' => '提交失败！'];
        }
        return json($arr);

    }

    /**
     * 预约沟通提交
     * @param Request $request
     * @return \think\response\Json
     */
    public function consult(Request $request)
    {
        //获取数据 && 校验
        $data = $request->post();
        $msg = $this -> validate($data,'consult');

        if ($msg!==true){
            return json(['code' => 301,'msg'=>$msg]);
        }

        //入库 && return
        $consult = new ConsultModel();
        if ($consult -> save($data)){
            return json(['code'=>200,'msg'=>'提交成功']);
        }else{
            return json(['code'=>500,'msg'=>'提交失败']);
        }

    }

}