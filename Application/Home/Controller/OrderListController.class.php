<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/4/6
 * Time: 上午8:54
 */

namespace Home\Controller;


use Common\Controller\UserController;

class OrderListController extends UserController
{
    /**
     * 订单页面
     */
    public function index(){

        $title = '我的订单';
        $this->assign('title',$title);
        //设置css样式
        $cs = ['index'];
        $this->assign('cs',$cs);
        //设置js样式
        $js = ['list'];
        $this->assign('js',$js);
        //设置跳转地址
        $url = __SELF__;
        session('waq_url',$url);

        $status = I('get.status');
        $puid =$_SESSION['puid'];
        //判断是否通过状态来查询
        if ($status){
            $orderData = M('order')->where("puid='{$puid}' and status='{$status}'")->select();
        }else{
            //查询数据
            $orderData = M('order')->where("puid='{$puid}' ")->select();
        }
        $nm = M('order')->where("puid='{$puid}' and status='未付款'")->count();
        $df = M('order')->where("puid='{$puid}' and status='待发货'")->count();
        $yf = M('order')->where("puid='{$puid}' and status='已发货'")->count();
        $ok = M('order')->where("puid='{$puid}' and status='已完成'")->count();
        $this->assign('nm',$nm);
        $this->assign('df',$df);
        $this->assign('yf',$yf);
        $this->assign('ok',$ok);
        $this->assign('orderData',$orderData);
        $this->display();
    }

    /**
     * 异步删除订单数据
     */
    public function ajaxDelOrder(){
        $oid=$_POST['oid'];
        //删除订单数据
        M('order')->where("oid={$oid}")->delete();
        //删除订单列表数据
        M('orderlist')->where("oid={$oid}")->delete();
        echo 1;
    }

    /**
     * 我喜欢的页面
     */
    public function mylove(){

        $title = '我喜欢';
        $this->assign('title',$title);
        //设置css样式
        $cs = ['index'];
        $this->assign('cs',$cs);
        //设置js样式
        $js = ['list'];
        $this->assign('js',$js);
        //设置跳转地址
        $url = __SELF__;
        session('waq_url',$url);

        $puid =$_SESSION['puid'];
        $loveData = M('mylove')->where("puid='{$puid}'")->select();
        foreach ($loveData as $k =>$v){
            $gid= $v['gid'];
            $loveData[$k]['good']= M('goods')->where("gid={$gid}")->find();
        }
        $this->assign('loveData',$loveData);

        $this->display();
    }
    /**
     * 异步删除我喜欢的商品
     */
    public function ajaxDelLove(){
        $gid=I('post.gid');
        $puid=$_SESSION['puid'];
        //执行删除
        M('mylove')->where("gid = {$gid} and puid='{$puid}'")->delete();
        echo 1;
    }

}