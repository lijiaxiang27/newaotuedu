<?php

/**
 * User: zhang
 * Date: 2017/10/30
 * Time: 上午9:24
 */
namespace app\aotu\model;

use think\Db;
use think\Model;
use think\Request;
use app\aotu\model\ApplyModel;

class SearchModel extends Model
{
    public $h = "span";
    public $color = "#F3931D";

    //搜索实现
    public function searchResult($search_string)
    {
        $search_string = $this->dealString($search_string);
        $where = '';
        foreach ($search_string as $k=>$v){
            if ($v == ''){
                continue;
            } elseif ($k == 0) {
                $where .= " `post_title` like '%$v%' ";
            } else {
                $where .= " or `post_title` like '%$v%' ";
            }
        }
        $search_string_tostr = implode('+', $search_string);
        $result = Db::name("portal_post")->field("id,post_title,post_excerpt,published_time")->where("$where")->where("`post_status` = 1 and `delete_time` = 0")->paginate(10,false,['query'=> ['q'=>$search_string_tostr]]);
        $rst['page'] = $result->render();
        $rst['total'] = $result->total();
        $data = $result->toArray();
        $rst['data'] = $this->replaceString($data['data'], $search_string);
        return $rst;
    }

    //处理用户搜索的字符串
    public function dealString($keyword)
    {
//        $keyword=urlencode($keyword);//将关键字编码
//        $keyword=preg_replace("/(%7E|%60|%21|%40|%23|%24|%25|%5E|%26|%27|%2A|%28|%29|%2B|%7C|%5C|%3D|\-|_|%5B|%5D|%7D|%7B|%3B|%22|%3A|%3F|%3E|%3C|%2C|\.|%2F|%A3%BF|%A1%B7|%A1%B6|%A1%A2|%A1%A3|%A3%AC|%7D|%A1%B0|%A3%BA|%A3%BB|%A1%AE|%A1%AF|%A1%B1|%A3%FC|%A3%BD|%A1%AA|%A3%A9|%A3%A8|%A1%AD|%A3%A4|%A1%A4|%A3%A1|%E3%80%82|%EF%BC%81|%EF%BC%8C|%EF%BC%9B|%ef%bc%8f|%EF%BC%9F|%EF%BC%9A|%E3%80%81|%E2%80%A6%E2%80%A6|%E2%80%9D|%E2%80%9C|%E2%80%98|%E2%80%99|%EF%BD%9E|%EF%BC%8E|%EF%BC%88)+/",' ',$keyword);
//        $keyword=urldecode($keyword);//将过滤后的关键字解码
        $preg_letter = "/[A-Za-z0-9]+$/";
        $preg = "/[\x{4e00}-\x{9fa5}]+/u";
        preg_match_all($preg,$keyword,$matches);
        preg_match_all($preg_letter,$keyword,$matches_letter);
        $keyword = $matches[0];
        $keyword_letter = $matches_letter[0];
        $keyword = array_merge($keyword, $keyword_letter);
        return $keyword;
    }

    /**
     * 搜索结果中的关键词高亮显示
     * @param $str  元数据
     * @param $searchStr  需要替换的关键词
     * @return mixed 返回替换后的数据 数组或者字符串
     */
    private function replaceString($str, $searchStr)
    {
        if (is_array($str)){
            foreach ($searchStr as $k=>$v){
                foreach ($str as $kk=>&$vv){
                    $vv = str_ireplace($v, "<".$this->h." style='color:".$this->color."' >".$v."</".$this->h.">", $vv);
                }
            }
        } else {
            $searchStr = str_ireplace($str, "<".$this->h." style='color:".$this->color."' >".$str."</".$this->h.">", $str);
        }
        return $str;
    }


}