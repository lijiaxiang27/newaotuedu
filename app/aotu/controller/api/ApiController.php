<?php
/**
 * 提供51ying.net数据接口
 */

namespace app\aotu\controller\api;


use app\aotu\model\CoreteamModel;
use app\aotu\model\InvestorModel;
use app\aotu\model\ReportModel;
use app\aotu\model\SlideItemModel;
use app\aotu\model\AwardsModel;
use think\Controller;
use think\Request;

class ApiController extends Controller
{
    /*
     * banner
     */
    public function getBanner()
    {

        return SlideItemModel::field('image')->where(['status'=>1,'slide_id'=>2])->select();
    }

    /*
     * 投资人 成功案例
     */
    public function getInvestor()
    {
        $tmp = Request::instance()->param('page');
        $page = $tmp != null ? $tmp : 2;
        $data = InvestorModel::field('name,description,avatar,square_avatar,video')->order('list_order')->limit(8)->select()->toArray();
        $data = self::_array_do($data);
        // if ($page != 2){
        //     //对手机端数据进行二次处理，将其转换为 两个一组，两组一队
        //     $arr = array();
        //     $i=0;
        //     foreach($data['mobile'] as $k => $v) {
        //         if ($k%2==0&&$k!=0){
        //             $i+=1;
        //         }
        //         $arr[$i][]=$v;
        //     }
        //     $data['mobile'] = $arr;
        // }
        // return json($data['mobile']);
        return json($data);
    }

    /*
     * 媒体报道
     */
    public function getReports()
    {
        $tmp = Request::instance()->param('limit');
        $limit = $tmp != null ? $tmp : 8;
        $data = ReportModel::order('list_order')->limit($limit)->select()->hidden(['id','list_order']);
        $data = self::_array_do($data);
        return json($data);
    }

    /*
     * 奖项
     */
    public function getAwards()
    {
        $data = AwardsModel::order('list_order')->select()->hidden(['id','list_order']);
        $data = self::_array_do($data);
        return json($data);
    }

    /*
     * 核心团队
     */
    public function getCoreteam()
    {
        return CoreteamModel::order('list_order')->select()->visible(['name','description','content','img']);
    }

    /*
     * 搜索
     */
    public function getSearchResult()
    {
        $param = Request::instance()->param('q');

    }



    /**
     * 将数组处理为pn个一组PC && mn个一组mobile
     * @param $array
     * @return mixed
     */
    private static function _array_do($array,$pn=4,$mn=2)
    {

        $k = 0;
        $m = 0;
        foreach ($array as $key => $v){
            //处理数据为四条一行 PC
            if ($key%$pn ==0 && $key!=0){
                $pc_array[$k+1][]=$v;
                $k++;
            }else{
                $pc_array[$k][]=$v;
            }

            //数据处理为两条一行 mobile
            if ($key%$mn ==0 && $key!=0){
                $mobil_array[$m+1][]=$v;
                $m++;
            }else{
                $mobil_array[$m][]=$v;
            }

        }

        $new_array['pc']=$pc_array;
        $new_array['mobile']=$mobil_array;
        return $new_array;
    }

}