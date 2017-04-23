<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/30
 * Time: 下午9:12
 */

namespace Home\Controller;


use Common\Controller\UserController;
use Common\Model\OrderModel;
use Common\Model\UseraddressModel;
use Org\Util\Cart;
use Think\Crypt;

class AccountController extends UserController
{
    public function index(){
        $title = '订单页';
        $this->assign('title',$title);
        //设置css样式
        $cs = ['account','index'];
        $this->assign('cs',$cs);
        //设置js样式
        $js = ['account','list'];
        $this->assign('js',$js);

        //设置变量控制购物车是否出现
        $mynameiscart = 123;
        $this->assign('mynameiscart',$mynameiscart);

        //设置每个页面的唯一的url
        session('waq_url',U('home/account/index'));
        //获取用户选中的订单id
        //获取选择的商品id
        $goodsid =I('get.goodsid');
        //解密字符串
        $goodsid = Crypt::decrypt($goodsid,'cart');
        //修改字符串为数组
        $goodsid = rtrim($goodsid,',');
        $goodsid = explode(',',$goodsid);
        //新建一个数组
        $goodsArr =[];
        //遍历购物车所有的数据
        foreach($_SESSION['cart']['goods'] as $k=>$v){
            //将商品id传入新数组
            $goodsArr[]=$k;
        }
        //新建一个标识遍历
        $biaoshi = false;
        foreach ($goodsid as $kk=>$vv){
            if(!in_array($vv,$goodsArr)){
                $biaoshi=true;
            }
        }
        //判断get参数是否被修改
        if ($biaoshi){
            $url = U('home/cart/index');
            header("location:{$url}");die;
        }
        $puid = $_SESSION['puid'];
        //获取用户收货地址
        $uaddress = M('useraddress')->where("puid='{$puid}' ")->order('is_m desc')->select();
        $this->assign("uaddress",$uaddress);
        $this->assign('goodsid',$goodsid);

        $this->display();
    }

    /**
     * 异步设置收货地址
     *
     */
    public function setAddress(){
        if (IS_POST){
            $data= I('post.');
            //将用户id写入
            $data['puid']=$_SESSION['puid'];
            //执行添加方法
            $res = (new UseraddressModel())->store($data);
            //根据返回结果处理数据
            if ($res['valid']){
                $data['uaid']=$res['uaid'];
                echo $this->ajaxReturn(['status'=>1,'info'=>$data]);die;
            }else{
                $this->error($res['message']);die;
            }
        }
    }

    //异步获取数据
    public function ajaxGetUinfo(){
        if (IS_AJAX){
            //获取数据
            $data = M('useraddress')->where("uaid={$_POST['uaid']}")->find();
            //将地址转换为数组
            $data['site']=explode(' ',$data['site']);
            echo $this->ajaxReturn($data);die;
        }

    }
    //异步编辑收货地址
    public function ajaxEditAddress(){
        $data = I('post.');
        $data['uaid']=$data['id'];
        //执行编辑
        $res = (new UseraddressModel())->edit($data);
        if ($res['valid']){
            echo $this->ajaxReturn(['status'=>1,'info'=>$data]);die;
        }else{
            $this->error($res['message']);die;
        }
    }

    /**
     * 异步下单
     */
    public  function ajaxSetOrder(){
        if (IS_AJAX){
            $goodsid =I('get.goodsid');
            //解密字符串
            $goodsid = Crypt::decrypt($goodsid,'cart');
            //修改字符串为数组
            $goodsid = rtrim($goodsid,',');
            $goodsid = explode(',',$goodsid);
            //订单名称
            $orderName =$_SESSION['pusername'] .time();
            $orderName = md5($orderName);
            //组成需要的数据
            $data =[
                'uaid'=>$_POST['uaid'],
                'time'=>time(),
                'total'=>$_POST['total'],
                'number'=>$orderName,
                'status'=>"未付款",
                'puid'=>$_SESSION['puid'],
                'goodsid'=>$goodsid
            ];
            $res = (new OrderModel())->store($data);
            if ($res['valid']){
                //立即下单后删除购物车的物品
                foreach ($goodsid as $k=>$v){
                    $datas=array(
                        'sid'=>$v,// 唯一 sid，添加购物车时自动生成
                        'num'=>0
                    );
                    (new Cart())->update($datas);
                }
                echo $this->ajaxReturn(['status'=>1,'info'=>$data]);
                die;
            }else{
                $this->error($res['message']);
            }
        }
    }
    /**
     * 成功下单
     */
    public function checkoutSuccess(){
        $title = '订单页';
        $this->assign('title',$title);
        //设置css样式
        $cs = ['index'];
        $this->assign('cs',$cs);
        //设置js样式
        $js = ['list'];
        $this->assign('js',$js);
        //设置了这个变量可以让该页面不显示购物车
        $mynameiscart = 123;
        $this->assign('mynameiscart',$mynameiscart);

        $this->display();
    }
}