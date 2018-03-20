<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/3 0003
 * Time: 上午 9:40
 */

namespace app\manager\controller;
use think\Controller;
use think\Rsa;
use app\common\helper\Verify;
use app\manager\model\User as UserModel;
class Index  extends Controller{
    public function index(){

        echo $this->fetch();
    }
    public function verify()
    {
        Verify::verify();
    }
    public function register(){

            echo $this->fetch();

    }
    public function login(){
        session(null);
        if(!empty($_POST['phone']) && !empty($_POST['password'])){
            $_POST['phone']    = Rsa::privDecrypt($_POST['phone']);
            $_POST['password'] = Rsa::privDecrypt($_POST['password']);

            $map['account'] = $_POST['phone'];
            $phone_user   = UserModel::getfind($map);
            if(!empty($phone_user)){
                if($phone_user['password'] == sha1($_POST['password'])){
                    $data['login_time'] =date("Y-m-d H:i:s",time());
                    UserModel::saves($phone_user['id'],$data);
                    session('key'   , $phone_user['account']);
                    session('account'   , $phone_user['account']);
                    session('uniqid'     , $phone_user['uniqid']);
                    $arr['res'] = 'success';
                }else{
                    $arr['res'] = 'error';
                }
            }else{
                $arr['res']     = null;
            }
            return json($arr);
        }else{
            echo $this->fetch();
        }

    }
    public function logins(){
        session(null);

            $_POST['phone']    = Rsa::privDecrypt($_POST['phone']);
            $_POST['password'] = Rsa::privDecrypt($_POST['password']);

            $map['account'] = $_POST['phone'];
            $phone_user   = UserModel::getfind($map);
            if(!empty($phone_user)){
                if($phone_user['password'] == sha1($_POST['password'])){
                    $data['login_time'] =date("Y-m-d H:i:s",time());
                    UserModel::saves($phone_user['id'],$data);
                    session('key'   , $phone_user['account']);
                    session('account'   , $phone_user['account']);
                    session('uniqid'     , $phone_user['uniqid']);
                    $arr['res'] = 'success';
                }else{
                    $arr['res'] = 'error';
                }
            }else{
                $arr['res']     = null;
            }
            return json($arr);
    }
    public function registers(){

        $arr = array();

        $privDecrypt['phone']    = Rsa::privDecrypt(input('phone'));
        $privDecrypt['password'] = Rsa::privDecrypt(input('password'));

        $_POST['phone']    = $privDecrypt['phone'];
        $_POST['password'] = $privDecrypt['password'];

        $map['account'] = $_POST['phone'];
        $phone = UserModel::getfind($map);
        $code=Verify::check(input('code'));
        if(!empty($phone)){
            $arr['ret'] = 'repeat';
        }elseif($code){
            $_SESSION = array();
            session(null);
            $data['belong']   = 'xmyttz';
            $data['uniqid']   = sha1(uniqid());
            $data['account'] = $_POST['phone'];
            $data['password'] = sha1($_POST['password']);
            $data['reg_time'] = date("Y-m-d H:i:s",time());
            $row = Db('user')->strict(false)->insert($data);
            if($row){
                session('account', $data['account']);
                session('face'    , null);
                session('uniqid'  , $data['uniqid']);
                $arr['ret'] = 'success';
            }
        }else{
            $arr['ret'] = 'error';
        }

        return json($arr);

    }

    public function TradeAccount(){
        echo $this->fetch();
    }
    public function SysUser(){
        echo $this->fetch();
    }
    public function SysRole(){
        echo $this->fetch();
    }
    public function SysDeptment(){
        echo $this->fetch();
    }
    public function SysStation(){
        $StationName=input('StationName');
        $row= Db('department')->where('parent_id',-1)->where('del',0)->select();
        $this->assign('data',$row);
        if(!empty($StationName)){
            $row1=Db('job_management')->where('del',0)->where('department_id',input('TypeID'))->where('station_name',$StationName)->find();
        }else{
            $row1=Db('job_management')->where('del',0)->where('department_id',input('id'))->select();
        }
        $this->assign('data1',$row1);
        $this->assign('id',input('id'));
        echo $this->fetch();

    }
    public function index1(){
//        $left = UserModel::left($this->admin);
//        //var_dump($left['title']);
//        $this->assign('title',$left['title']);
//        $this->assign('list',$left['list']);
        $row= Db('department')->where('parent_id',-1)->where('del',0)->select();

        $this->assign('data',$row);
        $b = [];
        foreach ($row as $v) {
            $rows= Db('job_management')->where('department_id',$v['id'])->where('del',0)->select();
            foreach ($rows as $vo){

                if ($vo['department_id'] == $v['id']) {
                    $a=Db('job_management')->where('department_id',$vo['department_id'])->where('del',0)->select();
                    foreach ($a as $vi){
                        if ($vi['department_id'] == $vo['id']) {
                            $b[$vo['id']] = [
                                'department_id' => $vo['department_id'],
                                'station_name'=>$vo['station_name']
                            ];
                        }

                    }

                } else {

                }
            }

        }

        $b = array_values($b);
        $this->assign('user',$b);
        echo $this->fetch();
    }

    public function Create(){
        if(!empty(input('department_name'))&&!empty(input('describe'))){
            $data['date']=date('Y-m-d',time());
            $data['name']=input('department_name');
            $data['describe']=input('describe');
            $data['parent_id']=input('parent_id');
           $row= Db('department')->strict(false)->insert($data);
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
    public function Create_job(){
        if(!empty(input('department_id'))&&!empty(input('station_name'))){
            $data['create_time']=date('Y-m-d H:i:s',time());
            $data['station_name']=input('station_name');
            $data['department_id']=input('department_id');
            $row= Db('job_management')->strict(false)->insert($data);
            if($row){
                $arr['res']='success';
            }else{
                $arr['res']='error';
            }
            return json($arr);
        }else{
            $id=input('id');
            $row= Db('department')->where('id',$id)->where('del',0)->find();

            $this->assign('data',$row);
            echo $this->fetch();
        }



    }
    public function Edit(){
        $id=input('id');
        if(!empty(input('station_name'))){
            $data['station_name']=input('station_name');
            $data['create_time']=date('Y-m-d H:i:s',time());
            $row=Db('job_management')->where('del',0)->where('id',$id)->update($data);
            if($row){
                $arr['res']='success';
            }else{
                $arr['res']='error';
            }
            return json($arr);
        }else{
            $row=Db('job_management')->where('del',0)->where('id',$id)->find();
            $this->assign('data',$row);
            echo $this->fetch();
        }

    }
    public function login_out(){
        session_start();
        $_SESSION = array(); //清除SESSION值.
        if(isset($_COOKIE[session_name()])){  //判断客户端的cookie文件是否存在,存在的话将其设置为过期.
            setcookie(session_name(),'',time()-1,'/');
        }
        session_destroy();  //清除服务器的sesion文件

        $this->redirect("/manager/index/login");
    }



}