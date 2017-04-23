<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/17
 * Time: 上午8:36
 */

namespace Admin\Controller;


use Common\Controller\BaseController;

class ConfigController extends BaseController
{
    public function set(){
        if (IS_POST){
            $data = I('post.');
            //判断是编辑还是添加
            if (M('config')->find()){
                $data['id']=1;
            }
            //实例化模型
            $model = new \Common\Model\ConfigModel();
            $this->store($model,$data,U('admin/config/set'));
        }
        $oldData = M('config')->find(1);
        $this->assign('oldData',$oldData);
        $this->display();
    }
}