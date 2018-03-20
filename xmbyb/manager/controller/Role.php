<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/22 0022
 * Time: 下午 2:25
 */

namespace app\manager\controller;
use think\Controller;

class Role extends Controller{
    public function SysRole(){

        echo $this->fetch();
    }
    public function GetList(){
        $data=Db('role')->select();
        return json($data);
    }
    public function Create(){
        $role_name=input('role_name');
        $parentId=input('parentId');
        $role_describe=input('role_describe');
        if(!empty($role_name)&&!empty($parentId)&&!empty($role_describe)){
            $data['role_name']=$role_name;
            $data['role_describe']=$role_describe;
            $data['parentId']=$parentId;
            $data['add_time']=date('Y-m-d H:i:s',time());
            $row=Db('role')->strict(false)->insert($data);
            if($row){
                $arr['res']='success';
            }else{
                $arr['res']='error';
            }
           return json($arr);
        }else{
            echo $this->fetch();
        }

    }
    public function Edit(){
        echo $this->fetch();
    }
    public function SetMenu(){
        echo $this->fetch();
    }


}