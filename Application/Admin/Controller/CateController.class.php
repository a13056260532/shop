<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/20
 * Time: 上午8:27
 */

namespace Admin\Controller;


use Common\Controller\BaseController;
use Common\Model\CategoryModel;
use Org\Util\Arr;

class CateController extends BaseController
{
    public static $cid = [];
    /**
     * 添加顶级分类
     */
    public function add(){
        $cid = I('get.cid');
        if (IS_POST){
            $data = I('post.');
            //分类属于顶级
            $data['pid']=0;

            //执行添加
            $model = new CategoryModel();
            $this->store($model,$data,U('admin/cate/lists'));
        }
        //获取所有类型
        $type = M('type')->select();
        $this->assign('type',$type);
        $this->display();
    }

    /**
     * 列表页
     */
    public function lists(){
        //获取所有分类
        $category = M('category')->select();
        //树妆形式遍历页面
        $s = (new Arr())->tree($category,'cname','cid','pid');
        //dd($s);die;
        $this->assign('category',$s);
        $this->display();
    }
    /**
     * 编辑页
     */
    public function edit(){
        $cid = I('get.cid');
        //获取商品分类Id组合
        $cids = M('goods')->getField('cid',true);
        //如果该分类id在组合中，不让删除
        if (in_array($cid,$cids)){
            $this->error("该分类已有商品选择，无法编辑该分类");die;
        }
        if (IS_POST){
            $data = I('post.');
            $data['cid']=$cid;
            //执行编辑
            $model = new CategoryModel();
            $this->store($model,$data,U('admin/cate/lists'));
        }
        //获取所有的类型
        $type = M('type')->select();
        $this->assign('type',$type);
        //获取除了自己还有子集的所有数据
        $category = (new CategoryModel())->getCate($cid);
        $this->assign('category',$category);
        //获取旧数据
        $oldData = M('category')->find($cid);
        $this->assign('oldData',$oldData);
        $this->display();
    }
    /**
     * 添加子类
     */
    public function addson(){
        $cid = I('get.cid');
        if (IS_POST){
            //添加主键
            $data=I('post.');
            $model = new CategoryModel();
            $this->store($model,$data,U('admin/cate/lists'));
        }
        //获取获取当前分类
        $type = M('category')->where("cid=$cid")->find();
        $this->assign('category',$type);
        //获取所有的分类
        $type = M('type')->select();
        $this->assign('type',$type);
        $this->display();
    }
    /**
     * 执行删除
     */
    public function del(){
        $cid = I('get.cid');
        //判断该品牌是否正在使用
        //获取商品所属的分类id组合
        $cids = M('goods')->getField('cid',true);
        //如果该分类id在组合中，不让删除
        if (in_array($cid,$cids)){
            $this->error("该分类下有商品,无法删除");die;
        }
        //执行删除返回结果
        (new CategoryModel())->del($cid);
        //判断是否成功
        $this->success("删除成功",U('admin/cate/lists'));die;

    }
}