<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/22 0022
 * Time: 下午 2:04
 */

namespace app\manager\controller;
use think\Controller;

class User extends Controller{
    public function SysUser(){
        $UserName=input('UserName');

        if(!empty($UserName)){
            $data= Db('user_management')->where('del',0)->where('User_Name',$UserName)->select();
        }else{
            $data=Db('user_management')->where('del',0)->select();
        }

        $this->assign('data',$data);
        echo $this->fetch();
    }
    public function Create(){
        $data=Db('department')->where('del',0)->select();
        $this->assign('data',$data);
        echo $this->fetch();
    }
    public function Creates(){
       $DeptID=input('DeptID');
       $StationID=input('StationID');
       $rolediv=input('rolediv');
       $User_Name=input('User_Name');
       $User_Pwd=input('User_Pwd');
       $RealName=input('RealName');
       $Email=input('Email');
       $UserCer=input('UserCer');
       $UserPhone=input('UserPhone');
       $StopTrade=input('StopTrade');
       $EntrustNum=input('EntrustNum');
       $data['DeptID']=$DeptID;
       $data['StationID']=$StationID;
       $data['rolediv']=$rolediv;
       $data['User_Name']=$User_Name;
       $data['User_Pwd']=$User_Pwd;
       $data['RealName']=$RealName;
       $data['Email']=$Email;
       $data['UserCer']=$UserCer;
       $data['UserPhone']=$UserPhone;
       $data['StopTrade']=$StopTrade;
       $data['EntrustNum']=$EntrustNum;
       $data['del']=0;
       $row=Db('user_management')->strict(false)->insert($data);
       if($row){
           $arr['res']='success';
       }else{
           $arr['res']='error';
       }
       return json($arr);

    }
    public function CheckUserLimit(){

    }
    public function UserInfoCheck(){

    }
    public function GetStaionByDept(){
        $deptid=input('deptid');
        $data=Db('job_management')->where('department_id',$deptid)->where('del',0)->select();
        return json($data);
    }
    public function ResetPwd(){
        $id=input('id');
        if(!empty(input('User_Pwd'))){
            $User_Pwd_Conf=input('User_Pwd_Conf');
            if($User_Pwd_Conf==input('User_Pwd')){

                $data['User_Pwd']=$User_Pwd_Conf;

                $row= Db('user_management')->where('del',0)->where('id',input('ID'))->update($data);

                if($row){
                    $arr['res']='success';
                }else{
                    $arr['res']='error';
                }
            }else{
                $arr['res']='null';
            }
            return  json($arr);

        }else{
           $user= Db('user_management')->where('del',0)->where('id',$id)->find();
            $this->assign('user',$user);
            echo $this->fetch();
        }

    }
        public function Edit(){
        $id=input('id');
            $user= Db('user_management')->where('del',0)->where('id',$id)->find();
            $this->assign('user',$user);
        echo $this->fetch();
        }

}