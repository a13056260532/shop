<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/24
 * Time: 下午1:52
 */

namespace Common\Model;



use Think\Model;

class GoodslistModel extends Model
{
    protected $pk = 'glid';
    protected $tableName ='goodslist';
    protected $_validate = [
        ['inventory','require','请输入库存量'],
        ['number','require','请输入货品货号'],
        ['number','require','请输入货品货号'],
    ];
    public function store($data)
    {
        //dd($data);die;
        //判断规格是否选完
        foreach ($data['combine'] as $k=>$v){
            if (!$v){
                return['valid'=>false,'message'=>'请重新选择规格'];
            }
        }
        //判断数据库中这种组合是否已经存在
        $combine = implode(',',$data['combine']);
        $oldData = M('goodslist')->select();
        foreach ($oldData as $k=>$v){
            if ($v['combine']==$combine){
                return['valid'=>false,'message'=>'该组合ID已存在。请重新选择'];
            }
        }
        //判断该商品的库存总量是否超过商品总库存

        //执行自动验证
        if ($this->create()){
            //将组合代码的数组转换成json对象
            $data['combine']=implode(',',$data['combine']);
            //执行添加
            $this->add($data);
            //获取货品总数量
            $inventory  = $this->where("gid={$data['gid']}")->getField('inventory',true);
            $num = 0;
            foreach ($inventory as $k=>$v){
                $num = $num+$v;
            }
            //把货品总量存储到商品表
            $goods =M('goods');
            $total['total']=$num;
            $goods->where("gid={$data['gid']}")->save($total);
            return ['valid'=>true,'message'=>'添加成功'];
        }else{
            return['valid'=>false,'message'=>$this->getError()];
        }
    }

}