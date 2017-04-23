<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/28
 * Time: 上午11:04
 */

namespace Home\Controller;


use Common\Controller\HomeBaseController;
use Org\Util\Cart;
use Think\Crypt;

class CartController extends HomeBaseController
{
    public function index(){
        $cs = ['index'];
        $this->assign('cs',$cs);
        $url = __SELF__;
        session('waq_url',$url);

        //设置了这个变量可以让该页面不显示购物车
        $mynameiscart = 123;
        $this->assign('mynameiscart',$mynameiscart);
        //设置头部
        $title = '购物车';
        $this->assign('title',$title);
        //设置使用的js
        $js = ['list'];
        $this->assign('js',$js);
        //获取购物车参数
        $cart = session('cart');
        $this->assign('cart',$cart);
        $this->display();
    }

    /**
     * 异步更新商品数量
     */
    public function ajaxSetNum(){
        $data = [
            'sid'=>$_POST['id'],
            'num'=>$_POST['num']
        ];
        (new Cart())->update($data);
    }

    /**
     * 异步删除商品
     */
    public function delShops(){
       $goodid = $_POST['goodid'];
        $data=array(
            'sid'=>$goodid,// 唯一 sid，添加购物车时自动生成
            'num'=>0
        );
        (new Cart())->update($data);
        echo 1;
    }
    //异步设置session
    public function ajaxSetGoodId(){
        //获取商品的属性
        $str=I('post.goodsid');
        //加密字段
        $str = Crypt::encrypt($str,'cart');
        echo $str;



        //$_SESSION["waq_goodsid"] =$goodsid['goodsid'];
    }
}