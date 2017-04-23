<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/24
 * Time: 上午10:54
 */

namespace Admin\Controller;


use Common\Controller\BaseController;
use Common\Model\GoodslistModel;

class GoodslistController extends BaseController
{
    public function index(){
        $gid = I('get.gid');
        if (IS_POST){
            $data = I('post.');
            $data['gid']=$gid;
            //执行添加
            $res = (new GoodslistModel())->store($data);
            if ($res['valid']){
                $this->success($res['message'],U('admin/goodslist/index',['gid'=>$gid]));die;
            }else{
                $this->error($res['message']);die;
            }
        }
        //获取列表所有数据
        $goodslistData = M('goodslist')->where("gid={$gid}")->select();
        //将原数据组成新格式
        foreach ($goodslistData as $k=>$v){
            //创建一个新数组
            $newArr = [];
            //将组合id字符串转换维数组
            $goodslistData[$k]['combine']=explode(',',$v['combine']);
            //通过其属性id获取其属性名称
            foreach ($goodslistData[$k]['combine'] as $kk=>$vv){
                //将其属性id转换为键名，属性值转换为键值
                $newArr[$vv]=M('goodsattri')->where("gaid={$vv}")->getField('gavalue');
            }
            $goodslistData[$k]['combine']=$newArr;
        }

        $this->assign('goodslistData',$goodslistData);
        //获取属性数组
        $oldData = M('goodsattri')->alias('ga')
                ->join('__TYPEATTRIBUTE__ ta ON ga.taid=ta.taid')
                ->where("ga.gid={$gid} and ta.tatype='规格' ")->select();
        //处理数据
        $data = [];
        foreach ($oldData as $k=>$v){
            $data[$v['taname']][]=$v;
        }
        $this->assign('data',$data);
        $this->display();
    }
    /**
     * ajax判断商品属性组合是否存在
     */
    public function iscombine(){
        if (IS_AJAX){
            //将提交的数据combine字段的数组转换为字符串
            $combine = implode(',',$_POST['combine']);
            //获取数据存在的数据
            $data = M('goodslist')->select();
            //循环数据获取combine字段
            foreach ($data as $k=>$v){
                //判断组合id是否已存在
                if ($v['combine']==$combine){
                    echo 0 ;die;
                }
            }
            echo 1;die;
        }
    }
    /**
     * 删除货品
     */
    public function del(){
        //获取
        $glid = I('get.glid');
        //获取gid
        $gid=I('get.gid');
        //执行删除命令
        M('goodslist')->where("glid={$glid}")->delete();
        //原商品数量减少当前货品的数量
        //获取货品总数量
        $inventory  = (new GoodslistModel())->where("gid={$gid}")->getField('inventory',true);
        $num = 0;
        foreach ($inventory as $k=>$v){
            $num = $num+$v;
        }
        //把货品总量存储到商品表
        $goods =M('goods');
        $total['total']=$num;
        $goods->where("gid={$gid}")->save($total);
        //成功提示
        $this->success("删除成功",U('admin/goodslist/index',['gid'=>$gid]));

    }
}