<?php
namespace Common\Behaviors;
include "./Application/Common/Common/functions.php";
class AppBehavior extends \Think\Behavior{
    //行为执行入口
    public function run(&$param){
        $data = M('config')->find(1);
        $this->setConfig($data);
    }

    /**
     * 设置全局变量
     * @param $data
     */
    public function setConfig($data){
        $data['content']=json_decode($data['content'],true);
        v('config',$data['content']);
    }


}