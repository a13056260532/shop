<?php
namespace Home\Controller;

use Common\Controller\HomeBaseController;
use Common\Model\GoodsModel;

class ListsController extends HomeBaseController
{

    public function index ()
    {
        $title= '列表页';
        $this->assign('title',$title);
        $cs = ['index'];
        $this->assign('cs',$cs);
        //搜索框内的内容
        $seach_waq = I('get.p');
        $this->assign('seach_waq',$seach_waq);
        $js= ['list'];
        $this->assign('js',$js);
        $cid = I('get.cid');
        //dd(m('category')->select());
        $p = I('get.p');
        if ($p){

//            //1.处理面包屑
//            $fatherData = $this->getFather(m('category')->select(),$cid);
//            //数组翻转
//            $fatherData = array_reverse($fatherData);
//            $this->assign('fatherData',$fatherData);
            $mbData = $p;
            $this->assign('mbData',$mbData);

            $searData = (new GoodsModel())->where("gname like '%{$p}%'")->getField('cid',true);
            $searData = array_unique($searData);
            //2.实现筛选
            if ($searData){
                //(1)找到当前分类以及其子集数据
                $cids = [];
                foreach ($searData as $k=>$v){
                    $data=m('category')->select();
                    $sear = $this->getSonlist($data,$v);
                    $sear[] = $v;
                    foreach ($sear as $kk=>$vv){
                        $cids[] =$vv;
                    }
                }

                $gids = m('goods')->where("cid in (".implode(',',$cids).")")->getField('gid',true);
                //设置跳转地址
                $url = __SELF__;
                session('waq_url',$url);        //dd($gids);
                if($gids)
                {
                    //说明下面有商品
                    //关联商品属性表和类型属性表
                    $field = m('goodsattri')->alias('ga')
                        ->join('__TYPEATTRIBUTE__ ta on ga.taid=ta.taid')
                        ->where("ga.gid in (".implode(',',$gids).")")
                        ->group('ga.gavalue')->select();

                    //定义空数组，对$field进行重组，taid一样的放一起
                    $temp = [];
                    foreach($field as $k=>$v)
                    {
                        $temp[$v['taid']][] = $v;
                    }
                    $finalTemp = [];
                    foreach($temp as $k=>$v)
                    {
                        $finalTemp[] = [
                            'name'=>m('typeattribute')->where("taid={$k}")->getField('taname'),
                            'value'=>$v,
                        ];
                    }
                    $this->assign('finalTemp',$finalTemp);
                    //dd($finalTemp);
                    //准备地址栏的参数：?param=0_0_0_0
                    $param = isset($_GET['param']) ? explode('_',$_GET['param']) : array_fill(0,count($finalTemp),0);
                    //dd($param);
                    $this->assign('param',$param);
                    foreach($param as $k=>$v)
                    {
                        if($v)
                        {//说明有筛选动作
                            $gavalue = m('goodsattri')->where("gaid={$v}")->getField('gavalue');
                            $filterGids[] = m('goodsattri')->where("gavalue='{$gavalue}'")->getField('gid',true);
                        }
                    }
                    //如果有filterGids，说你那个param参数中有不是0
                    if($filterGids)
                    {
                        $finalGids = $filterGids[0];
                        foreach($filterGids  as $k=>$v)
                        {
                            $finalGids=array_intersect($finalGids,$v);
                        }
                        //跟$gids求交集，foreach循环param中if判断里面，找出来的gid可能不在我们当前gids范围
                        $finalGids = array_intersect($finalGids,$gids);
                    }else{
                        //说明选的都是不限
                        $finalGids = $gids;
                    }
                    //dd($filterGids);
                }else{
                    //说明没有商品
                    $finalGids = [];
                }
                //最后的商品id集合：$finalGids
                if($finalGids){
                    //gid in (1,2)
                    $data = m( 'goods' )->where( "gid in (".implode(',',$finalGids).")" )->select();
                }else{
                    $data = [];
                }
                $this->assign('data',$data);


            }else{
                $cids=M('category')->getField('cid',true);
            }
        }else{



            //1.处理面包屑
            $fatherData = $this->getFather(m('category')->select(),$cid);
            //数组翻转
            $fatherData = array_reverse($fatherData);
            $this->assign('fatherData',$fatherData);
            //2.实现筛选
            if ($cid){
                //(1)找到当前分类以及其子集数据
                $data=m('category')->select();

                $cids = $this->getSonlist($data,$cid);
                $cids[] = $cid;
            }else{
                $cids=M('category')->getField('cid',true);
            }
            //select * from goods where cid in (1,2,3,4)
            //"cid in ()"
            $gids = m('goods')->where("cid in (".implode(',',$cids).")")->getField('gid',true);
            //设置跳转地址
            $url = __SELF__;
            session('waq_url',$url);        //dd($gids);
            if($gids)
            {
                //说明下面有商品
                //关联商品属性表和类型属性表
                $field = m('goodsattri')->alias('ga')
                    ->join('__TYPEATTRIBUTE__ ta on ga.taid=ta.taid')
                    ->where("ga.gid in (".implode(',',$gids).")")
                    ->group('ga.gavalue')->select();

                //定义空数组，对$field进行重组，taid一样的放一起
                $temp = [];
                foreach($field as $k=>$v)
                {
                    $temp[$v['taid']][] = $v;
                }
                $finalTemp = [];
                foreach($temp as $k=>$v)
                {
                    $finalTemp[] = [
                        'name'=>m('typeattribute')->where("taid={$k}")->getField('taname'),
                        'value'=>$v,
                    ];
                }
                $this->assign('finalTemp',$finalTemp);
                //dd($finalTemp);
                //准备地址栏的参数：?param=0_0_0_0
                $param = isset($_GET['param']) ? explode('_',$_GET['param']) : array_fill(0,count($finalTemp),0);
                //dd($param);
                $this->assign('param',$param);
                foreach($param as $k=>$v)
                {
                    if($v)
                    {//说明有筛选动作
                        $gavalue = m('goodsattri')->where("gaid={$v}")->getField('gavalue');
                        $filterGids[] = m('goodsattri')->where("gavalue='{$gavalue}'")->getField('gid',true);
                    }
                }
                //如果有filterGids，说你那个param参数中有不是0
                if($filterGids)
                {
                    $finalGids = $filterGids[0];
                    foreach($filterGids as $k=>$v)
                    {
                        $finalGids=array_intersect($finalGids,$v);
                    }
                    //跟$gids求交集，foreach循环param中if判断里面，找出来的gid可能不在我们当前gids范围
                    $finalGids = array_intersect($finalGids,$gids);
                }else{
                    //说明选的都是不限
                    $finalGids = $gids;
                }
                //dd($filterGids);
            }else{
                //说明没有商品
                $finalGids = [];
            }
            //最后的商品id集合：$finalGids
            if($finalGids){
                //gid in (1,2)
                $data = m( 'goods' )->where( "gid in (".implode(',',$finalGids).")" )->select();
            }else{
                $data = [];
            }
            $this->assign('data',$data);
        }

        $this->display();
    }

    /**
     * 回去父级数据
     */
    public function getFather($data,$cid)
    {
        static $temp = [];
        foreach($data as $k=>$v)
        {
            if($v['cid']==$cid)
            {
                $temp[] = $v;
                $this->getFather($data,$v['pid']);
            }
        }
        return $temp;
    }

    /**
     * 递归找子集
     */
    public function getSonlist($data,$cid)
    {
        static $temp = [];
        foreach($data as $k=>$v)
        {
            if($v['pid']==$cid)
            {
                $temp[] = $v['cid'];
                $this->getSonlist($data,$v['cid']);
            }
        }
        return $temp;
    }

}