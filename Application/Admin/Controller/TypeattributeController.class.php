<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/17
 * Time: 下午3:14
 */

namespace Admin\Controller;


use Common\Controller\BaseController;
use Common\Model\TypeattributeModel;

class TypeattributeController extends BaseController
{
    protected $tid;
    public function __init(){
        $this->tid = I('get.tid');
        if (!$this->tid){
            $this->error("请先选择要处理的类型",U('admin/type/lists'));
        }
        //获取商品类型id组合
        $tids = M('goods')->getField('tid',true);
        //如果该类型id在组合中，不让删除
        if (in_array($this->tid,$tids)){
            $this->error("该类型已有属性被选择，无法编辑类型属性");die;
        }
    }

    /**
     * 类型属性列表
     */
    public function lists(){
        $tid =$this->tid;
        //获取属于当前类型的属性列表
        $model =new TypeattributeModel();
        $this->all_page($model,'taid',5,$tid);
        $this->display();
    }
    /**
     * 添加类型属性
     */
    public function add(){
        $taid = I('get.taid');
        if(IS_POST){
            $data = I('post.');
            //判断是否是编辑
            if ($taid){
                //是编辑就给字段添加一个主键字段
                $data['taid']=$taid;
            }
            //执行添加或者编辑
            $data['tid']=$this->tid;
            //实例化
            $model = new TypeattributeModel();
            $this->store($model,$data,U('admin/typeattribute/lists',['tid'=>$this->tid]));
        }
        //判断是否是编辑
        if ($taid){
            //如果是编辑把旧数据遍历到页面
            $oldData = M('typeattribute')->find($taid);
            $this->assign('oldData',$oldData);
        }
        $this->display();
    }

    /**
     * 类型属性执行删除
     */
    public function del(){
        //抓取主键
        $taid = I('get.taid');
        //执行删除
        M('typeattribute')->where("taid={$taid}")->delete();
        $this->success('删除成功',U('admin/typeattribute/lists',['tid'=>$this->tid]));
    }
}