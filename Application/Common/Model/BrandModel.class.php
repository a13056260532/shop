<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/20
 * Time: 下午3:51
 */

namespace Common\Model;


class BrandModel extends BaseModel
{
    protected $pk='bid';
    protected $tableName='brand';
    protected $_validate = [
        ['bname','require','品牌名称不能为空',1],
        ['logo','require','logo路径不能为空',1],
        ['rank','require','排序不能为空',1],
        ['heat','require','热门不能为空',1],
    ];
    //获取品牌数据
    public function getBrandData(){
        return $this->select();
    }

}