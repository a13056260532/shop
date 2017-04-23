<?php

namespace Common\Controller;

use Think\Controller;

class BaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        //判断是否登陆
        if (!session('?username')){
            $this->error('您需要先登录,王者！',U('admin/login/index'));die;
        }
        if (method_exists($this,'__init')){
            $this->__init();
        }
    }

    /**
     * 添加方法
     * @param $model 实例化的模型
     * @param $data 处理的数据
     * @param null $url 成功的跳转地址
     * @param \Closure|null $callback 回调函数
     */
    public function store($model,$data,$url=null, \Closure $callback=null){
        //实例化模型并传值
        $res = $model->store($data);
        //回调函数
        if ($res['valid'] && $callback instanceof \Closure){
            $callback($res);
        }
        //通过返回结果来进行提示
        if ($res['valid']){
            $this->success($res['message'],$url);die;
        }else{
            $this->error($res['message']);die;
        }
    }

    /**
     * @param $model 实例化哪个模型
     * @param $order 通过哪个字段排序
     * @param $num 一页显示的条数,默认五条
     * @param $tid 判断是不是类型属性
     */
    public function all_page($model,$order,$num=5,$tid=null){
        if ($tid){
            $count      = $model->where("tid={$tid}")->count();// 查询满足要求的总记录数
        }else{
            $count      = $model->count();// 查询满足要求的总记录数
        }
        $Page       = new \Think\Page($count,$num);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%  ');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $show       = $Page->show();// 分页显示输出
        if ($tid){
            $list = $model->where("tid={$tid}")->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
        }else{
            // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
            $list = $model->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
        }
        $str =<<<str
<style>
    .num,.prev,.next,.first,.end,.rows {
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        color: #337ab7;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
    }
    .current{
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        color: #337ab7;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
        z-index: 3;
        color: #fff;
        cursor: default;
        background-color: #337ab7;
        border-color: #337ab7;
    }
</style>
str;
        $show .=$str;
        $this->assign('page',$show);
        $this->assign('type',$list);
    }
}