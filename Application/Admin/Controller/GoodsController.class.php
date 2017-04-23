<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/21
 * Time: 上午10:52
 */

namespace Admin\Controller;


use Common\Controller\BaseController;
use Common\Model\BrandModel;
use Common\Model\CategoryModel;
use Common\Model\GoodsattriModel;
use Common\Model\GoodsModel;
use Common\Model\TypeattributeModel;

class GoodsController extends BaseController
{
    protected $db;
    public function __init(){
        $this->db = new GoodsModel();
    }
    /**
     * 添加商品
     */
    public function add(){
        if (IS_POST){
            $data= I('post.');
            $res = $this->db->store($data);
            if ($res['valid']){
                $this->success($res['message'],U('admin/goods/lists'));die;
            }else{
                $this->error($res['message']);die;
            }
        }
        //获取所有分类
        $cateData = (new CategoryModel())->getCateData();
        $this->assign('cateData',$cateData);
        //获取所有品牌
        $brandData = (new BrandModel())->getBrandData();
        $this->assign('brandData',$brandData);
        $this->display();
    }

    /**
     * 异步进行判断是分类有哪些属性
     */
    public function ajaxGetSpec(){
        if (IS_AJAX){
            //接收ajax发送的数据
            $tid = I('post.tid');

            //实例化模型获取数据
            $data = (new TypeattributeModel())->getArriData($tid);
            //将数组中的tavalue转换为数组
            foreach ($data as $k=>$v){
                $data[$k]['tavalue']=explode("|",$v['tavalue']);
                $data[$k]['tavalue']=array_filter($data[$k]['tavalue']);
            }
            echo $this->ajaxReturn($data);
        }
    }

    /**
     * 商品列表
     */
    public function lists(){
        //获取旧数据
        $model = new GoodsModel();
        $this->all_page($model,'time desc',10);
        $this->display();
    }

    /**
     * 编辑页面
     */
    public function edit(){
        //3.获取gid
        $gid= I('get.gid');

        //9.执行编辑
        //获取所有的gaid
        $gaid = M('goodsattri')->where("gid={$gid}")->getField('gaid',true);
        $data = I('post.');
        $data['gid'] =$gid;
        $data['gaid']=$gaid;

        if (IS_POST){
            //执行添加
            $res = $this->db->store($data);
            //根据返回值判断成败
            if ($res['valid']){
                $this->success($res['message'],U('admin/goods/lists'));die;
            }else{
                $this->error($res['message']);die;
            }
        }

        if (!$gid){
            $this->error('该商品不存在，请重新选择');
            die;
        }

        //4.获取商品表数据还有详细列表
        $oldGoodsData =M('goods')->alias('g')
            ->join('__GOODDETAIL__ ga ON g.gid=ga.gid')
            ->where("g.gid={$gid}")->find();
        $this->assign('oldGoodsData',$oldGoodsData);
        if (!$oldGoodsData){
            $this->error('该商品数据错误，请删除后重新处理');
            die;
        }
        //5.获取tid
        $tid = $oldGoodsData['tid'];
        //6.获取所属属性属性
        $attrData = M('typeattribute')->where("tid={$tid} and tatype='属性'")->select();
        //将数组中的tavalue转换为数组
        foreach ($attrData as $k=>$v){
            $attrData[$k]['tavalue']=explode("|",$v['tavalue']);
            $attrData[$k]['tavalue']=array_filter($attrData[$k]['tavalue']);
        }

        $this->assign('attrData',$attrData);
        //7.获取当前商品所属的属性
        $goodAttriDate = M('goodsattri')->alias('g')
            ->join("__TYPEATTRIBUTE__ ta ON g.taid=ta.taid")
            ->where("g.gid={$gid} and tatype='属性' ")->getField('gavalue',true);
        //将数据分配到页面
        $this->assign('goodAttriDate',$goodAttriDate);

        //8.获取规格数据
        $specData = m('typeattribute')->alias('ta')
            ->join("__GOODSATTRI__ ga on ta.taid=ga.taid")
            ->where("ta.tatype='规格' and ga.gid={$gid}")->select();

        foreach($specData as $k=>$v){
            $specData[$k]['tavalue'] = explode('|',$v['tavalue']);
        }

        $this->assign('specData',$specData);

        //1.获取所有分类
        $cateData = (new CategoryModel())->getCateData();
        $this->assign('cateData',$cateData);
        //2.获取所有品牌
        $brandData = (new BrandModel())->getBrandData();
        $this->assign('brandData',$brandData);
        $this->display();
    }

    /**
     * 执行删除
     */
    public function del(){
        //获取gid
        $gid = I('get.gid');
        //1.删除商品属性表
            M('goodsattri')->where("gid={$gid}")->delete();
        //2.删除商品详情表
            //先删除缩略图
                //获取图片地址
                $detailImg =M('gooddetail')->where("gid={$gid}")->getField('small,medium,big');
                $detailImg=current($detailImg);
                foreach ($detailImg as $k=>$v){
                    $detailImg[$k]=explode('|',$v);
                }
                //删除缩略图
                foreach ($detailImg['small'] as $kk=>$vv){
                    unlink($vv);
                    unlink($detailImg['medium'][$kk]);
                    unlink($detailImg['big'][$kk]);
                }
                //删除数据
                M('gooddetail')->where("gid={$gid}")->delete();
        //3.删除商品表
            //删除商品列表图文件
                $listImg=M('goods')->where("gid={$gid}")->getField('pic');
                unlink($listImg);
                //删除数据
                M('goods')->where("gid={$gid}")->delete();
        //4.删除货品表数据
                M('goodslist')->where("gid={$gid}")->delete();
                $this->success("删除成功",U('admin/goods/lists'));
    }

}