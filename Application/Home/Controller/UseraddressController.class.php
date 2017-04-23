<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/4/7
 * Time: 上午9:58
 */

namespace Home\Controller;


use Common\Controller\UserController;

class UseraddressController extends UserController
{
    /**
     * 展示页面
     */
    public function index(){
        //设置css样式
        $cs = ['account'];
        $this->assign('cs',$cs);
        //设置js样式
        $js = ['list','account'];
        $this->assign('js',$js);
        $puid = $_SESSION['puid'];
        //获取用户收货地址
        $uaddress = M('useraddress')->where("puid={$puid}")->order('is_m desc')->select();
        $this->assign("uaddress",$uaddress);

        $this->display();
    }

    /**
     * 异步删除收货地址
     */
    public function delAddress(){
        //获取uaid
        $uaid = I('post.uaid');
        //执行删除
        M('useraddress')->where("uaid={$uaid}")->delete();
        echo 1;die;
    }
}