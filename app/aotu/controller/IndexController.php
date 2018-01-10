<?php

/**
 * Created by PhpStorm.
 * User: test
 * Date: 2017/10/19
 * Time: 下午2:26
 */
namespace app\aotu\controller;

use app\aotu\model\InvestorModel;
use app\aotu\model\SearchModel;
use app\aotu\model\VideoModel;
use cmf\controller\HomeBaseController;
use think\Db;
use think\Request;

class IndexController extends HomeBaseController
{

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        //获取友链 && 渲染模板
        $link = db('links')->field('link_url,link_name')->where('link_status',1)->order('listorder desc')->select();
        $this -> assign('links',$link);
        $action = $request -> action();
        //tag 为 1 则不显示二级菜单
        $tag  = in_array($action, ['index','service','cooperation','course']) ? 1 : 0;
        $this->assign('tag', $tag);
        $this -> assign('action',$action);
    }

    /**
     * 前台首页
     */
    public function index()
    {   //获取幻灯片
        $slide = self::_get_slide();
        //获取投资人
        $investor = self::_get_investor();
        //获取媒体报道
        $report = self::_get_report();
        //获取奖项
        $awards = self::_get_awards();
        //热门新闻前五条
        $news = self::_get_hot_news(5);
        //处理标题长度
        foreach ($news as $k => $v){
            if (mb_strlen($v['post_title'])>15){
                $news[$k]['post_title'] = mb_substr($v['post_title'],0,14).'...';
            }
        }
        //获取一条新闻
        $ids = self::_get_news_ids();
        $one_new= db('portal_post')->field('`id`,post_title,more,post_excerpt')->whereIn('id',$ids)->where(['post_status'=>1,]) -> order('post_hits desc')->find();
        $one_new['more'] = json_decode($one_new['more'],true);
//        dump($one_new);die;
        $this -> assign('one',$one_new);
        $this -> assign('news',$news);
        $this -> assign('awards',$awards);
        $this -> assign('report',$report);
        $this -> assign('investor',$investor);
        $this -> assign('slide',$slide);
        return $this->fetch();
    }

    /**
     * 服务支持
     */
    public function service()
    {
        //获取幻灯片
        $slide = self::_get_slide();

        $this -> assign('slide',$slide);
        return $this -> fetch();
    }

    /**
     * 合作模式
     */
    public function cooperation()
    {
        //获取幻灯片
        $slide = self::_get_slide();

        $this -> assign('slide',$slide);
        //获取成功案例
        $success = self::_get_investor();

        //对手机端数据进行二次处理，将其转换为 两个一组，两组一队
        $arr = array();
        $i=0;
        foreach($success['mobile'] as $k => $v) {
            if ($k%2==0&&$k!=0){
                $i+=1;
            }
            $arr[$i][]=$v;
        }
        $success['mobile'] = $arr;
//        dump($success['mobile']);die;
        $this -> assign('success',$success);
        return $this -> fetch();
    }

    /**
     * 申请授权合作 合作模式表单
     */
    public function coo()
    {
        return $this -> fetch();
    }

    /**
     * 课程体系
     */
    public function course()
    {
        $slide = self::_get_slide();

        $this -> assign('slide',$slide);
        return $this -> fetch();
    }

    /**
     * 新闻
     */
    public function news(Request $request)
    {

        //获取最新新闻ID
        $ids = $this ->_get_news_ids();
        //获取新闻，每页展示10条
        $news = Db::name('portal_post')
            ->field('`id`,post_title,more,post_excerpt,published_time')
            ->whereIn('id',$ids)
            ->where('post_status',1)
            ->where('delete_time = 0')
            ->order('published_time desc')
            ->paginate(10);
//            ->paginate(10,false,[
//                    'path'=>url('index/news','',false)."/[PAGE].html"
//            ]);
        //获取其中的最热新闻前五条
        $hotnews = $this -> _get_hoter_news(5);
        //获取推荐新闻前五条
        $rcmd_news = $this -> _get_rcmd_news(5);
        $this -> assign('rcmd_news',$rcmd_news);
        $this -> assign('hotnews',$hotnews);
        $this -> assign('new_news',$news);
        $this->assign('page', $news->render());
        return $this -> fetch();
    }

    /**
     * 新闻详情
     */
    public function news_detail(Request $request)
    {
        $id = $request -> param('id');
        //获取当前详情
        $detail = db('portal_post')->find($id);
        //获取上一篇下一篇
        $next = db('portal_post') -> field('`id`,post_title') -> where("`id` < $id" )->order('`id` asc')->find();
        $last = db('portal_post') -> field('`id`,post_title') -> where("`id` > $id" )->order('`id` asc')->find();
        //将keywards转换为数组，然后拼接sql条件
        $detail['post_keywords'] = (new SearchModel())->dealString($detail['post_keywords']);
        if (!empty($detail['post_keywords'])){
            $where = '';
            foreach ($detail['post_keywords'] as $k => $v)
            {
                $where .= "post_keywords like '%".$v."%'";
                if (isset($detail['post_keywords'][$k+1]))
                {
                    $where .= ' or ';
                }
            }
            //获取相关文章
            $about = db('portal_post') -> field('`id`,post_title,published_time') -> where($where)->order('`id` asc')->order('published_time desc')->limit(10)->select();
        } else {
            $about = db('portal_post') -> field('`id`,post_title,published_time') ->order('`id` asc')->order('published_time desc')->limit(10)->select();
        }



        //更改数组格式为5条一组
        $about = self::_array_do($about,5,5);

        //获取其中的最热新闻前五条
        $hotnews = $this -> _get_hoter_news(5);
        //获取推荐新闻前五条
        $rcmd_news = $this -> _get_rcmd_news(5);


        $this -> assign('rcmd_news',$rcmd_news);
        $this -> assign('hotnews',$hotnews);
        $this -> assign('about',$about);
        $this -> assign('last',$last);
        $this -> assign('next',$next);
        $this -> assign('detail',$detail);
        return $this -> fetch();
    }

    /**
     * 常见问题
     */
    public function support()
    {
        return $this -> fetch();
    }

    /**
     * 法律声明
     * @return mixed
     */
    public function legal_declaration()
    {
        return $this -> fetch();
    }

    /**
     * 全国分布
     */
    public function dis_country()
    {
        return $this -> fetch();
    }

    /**
     * 全国分布图 （二级页面）
     */
    public function dis_countrys()
    {
        return $this -> fetch();
    }

    /**
     * 凹凸简介
     */
    public function aotu_brief()
    {
        return $this -> fetch();
    }

    /**
     * 凹凸释义
     */
    public function interpretation()
    {
        return $this -> fetch();
    }

    /**
     * 发展历程
     */
    public function dev_history()
    {
        return $this -> fetch();
    }

    /**
     * 核心团队
     */
    public function our_team()
    {
        $team = db('coreteam')->order('list_order')->select();

        $this -> assign('team',$team);
        return $this -> fetch();
    }

    /**
     * 招聘 （职业机会）
     */
    public function recruit()
    {
        //获取招聘信息
        $recruit = db('recruit') ->field('list_order,applicant,status',true)-> where('status',1)->order('list_order')->select();

        $this -> assign('recruit',$recruit);
        return $this -> fetch();
    }

    /**
     * 联系我们
     */
    public function call_us()
    {
        return $this -> fetch();
    }

    /**
     * 360°培训体系
     */
    public function nm()
    {
        return $this -> fetch();
    }

    /**
     * 搜索结果页面
     */
    public function search_result(Request $request)
    {

        //调用模型层
        $model = new SearchModel();
        $model->h = "span";
        $model->color = "#F3931D";
        $q = $request -> param('q');
        $data  = $model -> searchResult($q);
        if (is_array($data['data'])){
            $str['num'] =$data['total'];
        } else {
            $str['num'] =0;
        }
        if (empty($data['data'])) {
            //获取推荐新闻 3条
            $rcmd  = $this ->_get_rcmd_news(3);
            $this -> assign('rcmd',$rcmd);
        }
        $str['title'] = $request -> param('q');
        $this -> assign('str',$str);
        $this -> assign('data',$data['data']);
        $this -> assign('page',$data['page']);
        return $this -> fetch();


    }

    /**
     * 获取 pc&&mobile 首页幻灯片
     * @return mixed
     */
    private static function _get_slide()
    {
        $db = db('slide_item');
        $slide['pc'] = $db -> field('image,url') -> where(['status'=>1,'slide_id'=>1]) -> select();
        $slide['mobile'] = $db -> field('image,url') -> where(['status'=>1,'slide_id'=>2]) -> select();

        return $slide;
    }

    /**
     * 获取投资人（成功案例）
     * @return array
     */
    private static function _get_investor()
    {
        $db = new InvestorModel();
        $investor = $db -> field('name,description,avatar,square_avatar,video') -> order('list_order') ->limit(8)-> select();
        return self::_array_do($investor);

    }

    /**
     * 获取媒体报道
     * @return mixed
     */
    private static function _get_report()
    {
        $db = db('report');
        $report =  $db -> order('list_order')->limit(8)->select();
        return self::_array_do($report);
    }

    /**
     * 获取奖项
     * @return mixed
     */
    private static function _get_awards()
    {
        $db = db('awards');
        $awards =  $db -> order('list_order')->select();
        return self::_array_do($awards);
    }

    /**
     * 获取首页热门新闻  此方法不与 _get_hoter_news 冲突
     * @param int $limit limit get row
     * @param int $more  is only get title(0) or get more (any other)
     * @return mixed
     */
    private static function _get_hot_news($limit=0)
    {
        //获取读取条数
        $limits = $limit!=0?' limit '.$limit:'';

        $sql = 'select `id`,post_title,post_excerpt from cmf_portal_post WHERE `id` IN (select post_id from cmf_portal_category_post WHERE category_id=4 and status =1 ORDER BY list_order ASC) AND post_status = 1 order by published_time desc '.$limits;
        return DB::query($sql);


    }

    /**
     * 获取在分类ID为4（最新/热新闻）下的所有新闻ID
     * @return mixed
     */
    private function _get_news_ids()
    {
        //获取最新新闻ID && 处理为一维数组
        $ids = db('portal_category_post') -> field('post_id') -> where(['category_id'=>4,'status'=>1]) -> select();
        return $this -> change_array($ids);
    }

    /**
     * 获取指定条数的 最新/热门新闻
     * @param $limit int limit rows default 5
     * @return mixed
     */
    private function _get_hoter_news($limit=5)
    {
        $ids = $this -> _get_news_ids();
        return db('portal_post')->field('`id`,post_title,post_excerpt')->whereIn('id',$ids)->where('post_status',1) -> order('post_hits desc')->limit($limit)->select();
    }

    /**
     * 获取指定条数的 推荐新闻
     * @param $limit int limit rows default 5
     * @return mixed
     */
    private function _get_rcmd_news($limit=5)
    {
        $ids = $this -> _get_news_ids();
        return db('portal_post')->field('`id`,post_title,post_excerpt,published_time')
            ->whereIn('id',$ids)
            ->where(['post_status'=>1,'recommended'=>1])
            -> order('published_time desc')
            ->limit($limit)->select();
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

    /**
     * Effect 多维数组转换为一维数组
     * @param $array  数组
     * @return array 一维数组
     */
    private $arrs;
    private function change_array($array)
    {
        foreach ($array as $k => $v) {
            //若$v仍为数组 则调用自身
            if (is_array($v)){
                $this->change_array($v);
            }else{
                $this -> arrs[] = $v;
            }
        }
        return $this -> arrs;

    }

    /**
     * 视频中心
     */
    public function videos()
    {
        if (cmf_is_mobile()){
            $pagesize = 3;
        } else {
            $pagesize = 12;
        }
        $videos = (new VideoModel())->order('list_order asc,id desc')->paginate($pagesize);
        $this->assign('videos', $videos);
        return $this->fetch();
    }

    /**
     * 站点地图
     */
    public function sitemap()
    {
        return $this->fetch();
    }

}



