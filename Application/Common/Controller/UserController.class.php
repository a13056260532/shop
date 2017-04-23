<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/30
 * Time: 下午9:13
 */

namespace Common\Controller;


use Think\Controller;

class UserController extends HomeBaseController
{
    public function __construct()
    {
        parent::__construct();
        $url = __SELF__;
        session('waq_url',$url);
        //判断是否登陆
        if (!session('?puid')){
            $url = U('home/login/index');
            header("location:{$url}");die;
        }
        if (method_exists($this,'__init')){
            $this->__init();
        }
    }
}