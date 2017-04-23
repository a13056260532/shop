<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/20
 * Time: 下午12:56
 */

namespace Admin\Controller;


use Common\Controller\BaseController;
use Common\Model\BrandModel;

class BrandController extends BaseController
{
    /**
     * 品牌列表
     */
    public function lists(){
        //获取所有数据
        $oldData = M('brand')->select();
        $this->assign('oldData',$oldData);
        $model = new  BrandModel();
        $this->all_page($model,'bid',3);
        $this->display();
    }

    /**
     * 品牌添加
     */
    public function add(){
        $bid = I('get.bid');
        if (IS_POST){
            $data = I('post.');
            //判断是否是编辑
            if ($bid){
                $data['bid']=$bid;
            }
            //实例化的模型
            $model = new BrandModel();
            $this->store($model,$data,U('admin/brand/lists'));
        }
        //判断是否是编辑页面
        if ($bid){
            //获取旧数据
            $oldData=M('brand')->find($bid);
            $this->assign('oldData',$oldData);
        }
        $this->display();
    }
    public function del(){
        //获取要删除的bid
        $bid = I('get.bid');
        //判断该品牌是否正在使用
        //获取商品所属的品牌id组合
        $bids = M('goods')->getField('bid',true);
        //如何该品牌在组合中，不然删除
        if (in_array($bid,$bids)){
            $this->error("该品牌下有商品,无法删除");die;
        }
        //删除logo
        //获取logo地址
        $logo = M('brand')->where("bid={$bid}")->getField('logo');
        unlink($logo);
        //执行删除
        M('brand')->where("bid={$bid}")->delete();
        $this->success("删除成功",U('admin/brand/lists'));

    }
}