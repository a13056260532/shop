<?php
namespace Home\Controller;
use Common\Controller\HomeBaseController;
use Org\Util\Arr;
class IndexController extends HomeBaseController
{

    public function index(){
        $cs = ['index'];
        $this->assign('cs',$cs);
        //设置跳转地址
        $url = __SELF__;
        session('waq_url',$url);
        //title
        $title = '商城首页';
        $this->assign('title',$title);
        //加载相关JS
        $js=[
            'index'
        ];
        $this->assign('js',$js);


        //获取分类所有数据
        $data = M('category')->select();
        //将数据处理成层级的结构
        $cateData = (new Arr())->channelLevel($data, $pid = 0, $html = "&nbsp;");
        $this->assign('cateData',$cateData);

        //获取所有商品
        $goodsData = M('goods')->select();
        $this->assign('goodsData',$goodsData);
        //设置跳转地址
        $url = __SELF__;
        session('waq_url',$url);
        $this->display();
    }

    /**
     * 递归找子集
     */
    public function getSon($data,$cid,$isaq=null)
    {
        static $temp = [];
        if (!$isaq){
            foreach($data as $k=>$v)
            {
                if($v['pid']==$cid)
                {
                    $temp[] = $v['cid'];
                    $this->getSon($data,$v['cid']);
                }
            }
            return $temp;
        }else{
            $temp =[];
        }

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

}