<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/4/5
 * Time: 上午9:40
 */

namespace Common\Model;


use Think\Model;

class OrderModel extends Model
{
    protected $pk = 'oid';
    protected $tableName = 'order';
    protected $_validate=[
        ['uaid','require','地址不能为空'],
        ['total','require','总价不能为空'],
    ];


    public function store($data){
        if (!$this->create($data)){
            return ['valid'=>0,'message'=>$this->getError()];
        }
        $oid = $this->add($data);
        //循环所有的数据
        foreach ($data['goodsid'] as $k=>$v){
            $olData = [
                'quantity'=>$_SESSION['cart']['goods'][$v]['num'],
                'subtotal'=>$_SESSION['cart']['goods'][$v]['total'],
                'gid'=>$_SESSION['cart']['goods'][$v]['id'],
                'glid'=>$_SESSION['cart']['goods'][$v]['options']['glid'],
                'glnumber'=>$_SESSION['cart']['goods'][$v]['options']['glnumber'],
                'oid'=>$oid,
                'options'=>json_encode($_SESSION['cart']['goods'][$v]['options']['options'],JSON_UNESCAPED_UNICODE)
            ];
            (new OrderlistModel())->add($olData);
        }
        return ['valid'=>1,'message'=>'添加成功'];
    }
}