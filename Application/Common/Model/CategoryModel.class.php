<?php
/**
 * Created by PhpStorm.
 * User: wanganqi
 * Date: 2017/3/20
 * Time: 上午9:21
 */

namespace Common\Model;



use Org\Util\Arr;

class CategoryModel extends BaseModel
{
    protected $pk='cid';
    protected $tableName='category';


    /**
     * 获取分类树状图
     */
    public function getCateData(){
        $data = $this->select();
        return (new Arr)->tree($data,'cname');
    }
    /**
     * 获取除了自己还有子集的所有分类
     * @param $cid
     * @return mixed
     */
    public function getCate($cid){
        //获取除了自己的以及自己子集外的所有数据
        $category = $this->select();
        //获取自己子集的所有cid
        $res = $this->findson($category,$cid);
        //把自己的cid加入数据中
        $res[]=$cid;
        //查询除了自己还有自己子集的所有数据
        $map['cid']=['NOTIN',$res];
        return $category = $this->where($map)->select();
    }


    /**
     * 找自己还有自己子集
     * @param $data 所有数据
     * @param $cid 当前的数组
     * @return array 返回是所有子集的集合
     */
    public function findson($data,$cid){
        static $arr=[];
        foreach ($data as $k=>$v){
            if ($v['pid']==$cid){
                $arr[]=$v['cid'];
                $this->findson($data,$v['cid']);
            }
        }
        return $arr;
    }

    /**
     * 执行删除
     */
    public function del($cid){
        //dd($cid);die;
        //获取当前的pid
        $pid= $this->where("cid={$cid}")->getField("pid");
        //把他所有子集提升一级
        $this->upSon($cid,$pid);
        //执行删除
        $res = $this->where("cid={$cid}")->delete();
        return $res;
    }
    /**
     * 给子集升级
     */
    public function upSon($cid,$pid){
        $this->pid= $pid;
        $this->where("pid={$cid}")->save();
    }
}