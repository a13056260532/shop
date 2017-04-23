<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/26
 * Time: 下午10:51
 */

namespace Home\Controller;


use Common\Controller\HomeBaseController;
use Org\Util\Cart;

class ContentController extends HomeBaseController
{

    protected $glid;
    protected $glnumber;
    public function index(){
        $url = __SELF__;
        session('waq_url',$url);
        $cs = ['index'];
        $this->assign('cs',$cs);
        $gid = I('get.gid');
        $js= ['list'];
        $this->assign('js',$js);
        //类型属性、商品属性
        $field = m('typeattribute')->alias('ta')
            ->join("__GOODSATTRI__ ga on ta.taid=ga.taid")
            ->where("gid={$gid} and ta.tatype='规格' ")->select();
        if (!$field){
            $url  = U('home/index/index');
            header("location:{$url}");
        }
        $data = [];
        foreach($field as $k=>$v)
        {
            $data[$v['taname']][] = $v;
        }
        $this->assign('data',$data);
        //获取商品数据
        $goodData = M('goods')->where("gid={$gid}")->find();
        $this->assign('goodData',$goodData);

        //title
        $title = $goodData['gname'];
        $this->assign('title',$title);
        //获取该商品总库存
        $total = M('goods')->where("gid={$gid}")->getField('total');
        $this->assign('total',$total);
        //获取商品属性
        $goodAttri = M('goodsattri')->alias('ga')
            ->join('__TYPEATTRIBUTE__ ta ON ga.taid = ta.taid')
            ->where("gid = {$gid} and ta.tatype='属性'")->select();
        $this->assign('goodAttri',$goodAttri);
        //获取中图,大图
        $detailData = M('gooddetail')->where("gid={$gid}")->find();
        $this->assign('detailData',$detailData);
        $bigImg = explode('|',$detailData['big']);
        $mediumImg = explode('|',$detailData['medium']);
        $this->assign('bigImg',$bigImg);
        $this->assign('mediumImg',$mediumImg);
        //判断该用户是否喜欢该商品
        $puid = $_SESSION['puid'];
        $ismylove= M('mylove')->where("gid={$gid} and puid ='{$puid}'")->find();
        $this->assign('ismylove',$ismylove);




        $this->display();
    }
    /**
     * 异步获取库存
     *
     */
    public function ajaxGetTotal()
    {
        if(IS_AJAX)
        {
            $gid = I('post.gid');
            $combine = rtrim(I('post.combine'),',');
            $arrtiID= explode(',',$combine);

            //获取附加价格
            $goodPrice = 0;
            foreach ($arrtiID as $v){
                $goodPrice = $goodPrice + M('goodsattri')->where("gaid={$v}")->getField('added');
            }

            //在货品列表中查找数据
            $data = m('goodslist')->where("gid={$gid} and combine='{$combine}'")->find();
            //如果$data为空
            if(!$data){
                $this->ajaxReturn(['valid'=>0,'total'=>0,'added'=>$goodPrice]);die;
            }
            $this->glid = $data['glid'];
            $this->glnumber=$data['number'];
            //走到这里说明数据库能找到数据
            if($data['inventory']==0){
                //说明库存为0
                $this->ajaxReturn(['valid'=>0,'total'=>0,'added'=>$goodPrice]);die;
            }

            //走到这里说明有库存
            $this->ajaxReturn(['valid'=>1,'total'=>$data['inventory'],'added'=>$goodPrice]);die;
        }
    }

    /**
     * 异步加入购物车
     */
    public function ajaxGetCart(){
        if (IS_AJAX){
            //判断是否是列表页添加商品
            $lists = I('post.lists');
            if ($lists){
                $gid= I('post.gid');
                $price=M('goods')->where("gid={$gid}")->getField('shopprice');
                $combine = M('goodslist')->where("gid={$gid}")->getField('combine');
                if (!$combine){
                    echo $this->ajaxReturn(['valid'=>0,'message'=>'该商品没有任何货品']);die;
                }
                //在货品列表中查找数据
                $waq_data = m('goodslist')->where("gid={$gid} and combine='{$combine}'")->find();
                $options = [];
                $added = 0;

                $arrtiID= explode(',',$combine);
                foreach ($arrtiID as $v){
                    $taid = M('goodsattri')->where("gaid={$v}")->getField('taid');
                    $taname = M('typeattribute')->where("taid={$taid}")->getField('taname');
                    $options[$taname]=M('goodsattri')->where("gaid={$v}")->getField('gavalue');
                    $added +=M('goodsattri')->where("gaid={$v}")->getField('added');
                }
                $allmoney = $price+$added;
                //重组数据
                $data =[
                    'gid'=>$_POST['gid'],
                    'num'=>1,
                    'options'=>$options,
                    'inventory'=>$waq_data['inventory'],
                    'price'=>$allmoney
                ];
                //获取商品数据
                $goodData = M('goods')->where("gid={$data['gid']}")->field('shopprice,gname,shopprice,pic')->find();
                //获取商品参数
                $cartData = [
                    'id'        => $data['gid'], // 商品 ID
                    'name'      =>$goodData['gname'],// 商品名称
                    'num'       => $data['num'], // 商品数量
                    'price'     => $data['price'], // 商品价格
                    'options'   =>[
                        'options'=>$data['options'],
                        'img'=>$goodData['pic'],
                        'inventory'=>$data['inventory'],
                        'glnumber'=>$waq_data['number'],
                        'glid'=>$waq_data['glid'],
                    ]// 其他参数如价格、颜色、可以为数组或字符串
                ];
                (new Cart())->add($cartData);
                echo $this->ajaxReturn(['valid'=>1]);
            }else{
                $gid = I('post.gid');
                $combine = rtrim(I('post.combine'),',');


                //在货品列表中查找数据
                $waq_data = m('goodslist')->where("gid={$gid} and combine='{$combine}'")->find();


                //重组数据
                $data =[
                    'gid'=>$_POST['gid'],
                    'num'=>$_POST['num'],
                    'options'=>$_POST['options'],
                    'inventory'=>$_POST['inventory'],
                    'price'=>$_POST['price']
                ];
                //获取商品数据
                $goodData = M('goods')->where("gid={$data['gid']}")->field('shopprice,gname,shopprice,pic')->find();
                //获取商品参数
                $cartData = [
                    'id'        => $data['gid'], // 商品 ID
                    'name'      =>$goodData['gname'],// 商品名称
                    'num'       => $data['num'], // 商品数量
                    'price'     => $data['price'], // 商品价格
                    'options'   =>[
                        'options'=>$data['options'],
                        'img'=>$goodData['pic'],
                        'inventory'=>$data['inventory'],
                        'glnumber'=>$waq_data['number'],
                        'glid'=>$waq_data['glid'],
                    ]// 其他参数如价格、颜色、可以为数组或字符串
                ];
                (new Cart())->add($cartData);
                echo 1;
            }

        }

    }


    /**
     * 异步添加我喜欢
     */
    public function ajaxAddMyLove(){
        $gid= I('post.gid');
        $puid = $_SESSION['puid'];
        $data = [
            'gid'=>$gid,
            'puid'=>$puid
        ];
        //执行添加
        M('mylove')->add($data);
        echo 1;
    }
}