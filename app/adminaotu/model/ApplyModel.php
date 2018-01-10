<?php


namespace app\adminaotu\model;


use think\Model;

class ApplyModel extends Model
{

    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public static function getOne($id)
    {
        return self::find($id);
    }

    public static function getAll()
    {
        return self::order('id desc,create_time desc')->paginate(20);
    }

    public function getSexAttr($value)
    {
        $arr = [
            '0'=>'男',
            '1'=>'女'
        ];
        return $arr[$value];
    }

    public function getEduAttr($value)
    {
        $arr = [
            '0'=>'未选择',
            '1'=>'初中及以下',
            '2'=>'高中/中专/技校',
            '3'=>'大学专科',
            '4'=>'大学本科',
            '5'=>'硕士及以上'
        ];
        return $arr[$value];
    }

    public function getBusinessAttr($value)
    {
        $arr = [
            '0'=>'未选择',
            '1'=>'教育类',
            '2'=>'金融类',
            '3'=>'服务类（医疗/护理/美容/保健/餐饮/旅游）',
            '4'=>'IT/通信/电子/互联网',
            '5'=>'房地产/建筑业',
            '6'=>'贸易/批发/零售/租赁业',
            '7'=>'生产/加工/制造',
            '8'=>'文化/传媒/娱乐/体育',
            '9'=>'政府/非盈利机构',
            '10'=>'农/林/牧/渔',
            '11'=>'其他',
        ];
        return $arr[$value];
    }

    public function getIncomeAttr($value)
    {
        $arr = [
            '0'=>'未选择',
            '1'=>'10万以下',
            '2'=>'10万-30万',
            '3'=>'30万-50万',
            '4'=>'50万-100万',
            '5'=>'100万以上'
        ];
        return $arr[$value];
    }

    public function getReasonAttr($value)
    {
        $arr = [
            '0'=>'喜欢教育行业',
            '1'=>'有相关行业经验',
            '2'=>'高投资回报率',
            '3'=>'稳定的行业前景',
            '4'=>'作为自己多元化投资的一项',
            '5'=>'作为改变我人生的一项事业',
            '6'=>'一种回馈社会的慈善事业',
        ];
        if (!empty($value)){
            $value = explode(',', $value);
            $str = '';
            foreach ($value as $k=>$v){
                $str .= $arr[$v] . ',';
            }
            $str = rtrim($str, ',');
        } else {
            $str = "未选择";
        }

        return $str;
    }
}