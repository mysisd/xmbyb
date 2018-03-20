<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/3 0003
 * Time: 上午 11:29
 */
namespace app\manager\model;
use think\Model;
class User extends Model{
    public static function getfind($map){
        return Db('user')->where('del',0)->where($map)->find();
    }
    public static function saves($id,$data){
        return Db('user')->strict(false)->where('id',$id)->update($data);
    }
    public static function left($data) {
        $left = array();
        $adminlist = Db('adminlist');
        $adminuser = Db('adminuser');
        $title_num = explode(',',$data['path']);
        $list_num  = explode(',',$data['list']);
        foreach($title_num as $key => $v){
            $title_name = $adminlist->where('url',$v)->where('del',0)->order('order_num')->value('name');
            $left['title'][$key] = $title_name;
            if($list_num[0]!='all'){
                foreach($list_num as $list_key => $list_v){
                    $map_list['id']   = $list_v;
                    $map_list['path'] = $v;
                    $list_row = $adminlist->where($map_list)->where('del',0)->order('order_num')->find();
                    if(!!$list_row){
                        $left['list'][$key][$list_key] = $list_row;
                    }
                }
            }else{
                $left['list'][$key] = $adminlist->where('path',$v)->where('del',0)->order('order_num')->select();
            }
        }
        return $left;
    }
}