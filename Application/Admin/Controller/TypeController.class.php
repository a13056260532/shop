<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/17
 * Time: 上午11:09
 */

namespace Admin\Controller;


use Common\Controller\BaseController;
use Common\Model\TypeModel;

class TypeController extends BaseController
{
    /**
     * 添加类型
     */
    public function add(){
        $tid = I('get.tid');
        if (IS_POST){
            $data = I('post.');
            //判断是编辑还是添加
            if ($tid){
                //编辑把tid传入数据中
                $data['tid']=$tid;
            }
            $model =new TypeModel();
            $this->store($model,$data,U('admin/type/lists'));
        }
        //判断是否是编辑
        if ($tid){
            //是编辑就把旧数据遍历到页面
            $oldData = M('type')->where("tid={$tid}")->find();
            $this->assign('oldData',$oldData);
        }
        $this->display();
    }

    /**
     * 类型列表
     */
    public function lists(){
        //获取类型数据
        $model = new TypeModel();
        $this->all_page($model,'tid',5);
        $this->display();
    }

    /**
     * 删除类型
     */
    public function del(){
        //获取要删除的tid
        $tid = I('get.tid');
        //删除type表内的数据
        //获取商品所属的分类id组合
        $tids = M('goods')->getField('tid',true);
        //如果该分类id在组合中，不让删除
        if (in_array($tid,$tids)){
            $this->error("该类型下有商品,无法删除");die;
        }
        M('type')->where("tid={$tid}")->delete();
        //删除所属类型的属性
        M('typeattribute')->where("tid={$tid}")->delete();
        $this->success('删除成功',U('admin/type/lists'));
    }
}