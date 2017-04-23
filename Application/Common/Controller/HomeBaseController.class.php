<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/4/10
 * Time: 上午10:26
 */

namespace Common\Controller;


use Think\Controller;

class HomeBaseController extends Controller
{
    public static $arr=[];
    public function __construct()
    {
        parent::__construct();
        $this->setTopInfo();
    }

    /**
     * 设置头部信息
     */
    public function setTopInfo(){
        $waq_cid=M('category')->where('pid=0')->getField('cid',true);
        $this->assign('cid',$waq_cid);
        foreach ($waq_cid as $k=>$v) {
            $waq_zzz = $this->getSona(m('category')->select(), $v);
            $waq_zzz[] = $v;
            self::$arr=[];
            $gidsz = m('goods')->where("cid in (" . implode(',', $waq_zzz) . ")")->getField('gid', true);
            //说明选的都是不限
            $waq_finalGids = $gidsz;
            //最后的商品id集合：$finalGids
            if($waq_finalGids){
                //gid in (1,2)
                $data = m( 'goods' )->where( "gid in (".implode(',',$waq_finalGids).")" )->select();
            }else{
                $data = [];
            }
            $this->assign('data'.$k, $data);
        }
        //获取所有商品
        $allGoodsData = M('goods')->select();
        $this->assign('allGoodsData',$allGoodsData);
    }
    /**
     * 递归找子集
     */
    public function getSona($data,$cid)
    {
        foreach ($data as $k=>$v){
            if ($v['pid']==$cid){
                self::$arr[]=$v['cid'];
                $this->getSona($data,$v['cid']);
            }
        }
        return self::$arr;
    }
}