<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/22 0022
 * Time: 下午 1:50
 */

namespace app\manager\controller;
use think\Controller;
class Trade extends Controller{
    public function getRandomString($len, $chars)
    {
        if (is_null($chars)){
            $chars = $chars;
        }
//        mt_srand(100000*(double)microtime());
        for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
            $str .= $chars[mt_rand(0, $lc)];
        }
        return $str;
    }
    public function trade(){
        $rows=Db('trading_account')->select();
        $this->assign('data',$rows);
        if(empty(input('name'))&&input('counter')==='-1'){
            $row=Db('trading_account')->paginate(30,false,['query' => input('param.')]);
        }else if(!empty(input('name'))&&input('counter')==='-1'){
            $map['name']=input('name');
            $row=Db('trading_account')->where($map)->paginate(30,false,['query' => input('param.')]);
        }
        else if(empty(input('name'))&&empty(input('counter'))){
            $row=Db('trading_account')->paginate(30,false,['query' => input('param.')]);
        }else if(!empty(input('name'))&&empty(input('counter'))){
            $map['name']=input('name');
            $row=Db('trading_account')->where($map)->paginate(30,false,['query' => input('param.')]);
        }else if(empty(input('name'))&&!empty(input('counter'))){
            $map['counter']=input('counter');
            $row=Db('trading_account')->where($map)->paginate(30,false,['query' => input('param.')]);
        }else if(!empty(input('name'))&&!empty(input('counter'))){
            $map['counter']=input('counter');
            $map['name']=input('name');
            $row=Db('trading_account')->where($map)->paginate(30,false,['query' => input('param.')]);
        }
        $this->assign('name',input('name'));
        $this->assign('data',$row);
        echo $this->fetch();
    }
    public function create(){
        $counter_id=input('counter_id');
        $type=input('type');
        $trade_counter_sales_id=input('trade_counter_sales_id');
        $account=input('account');
        $pwd=input('pwd');
        $compwd=input('compwd');
        $name=input('name');
        $account_code=input('account_code');
        $customer=input('customer');
        $money=input('money');
        $status=input('status');
        $rate=input('rate');
        $state_type=input('state_type');
        $is_transferfee=input('is_transferfee');
       if(!empty($counter_id)||!empty($type)||!empty($trade_counter_sales_id)||!empty($account)||!empty($pwd)||!empty($compwd)||!empty($name)||!empty($account_code)||!empty($customer)||!empty($money)||!empty($status)||!empty($state_type)||!empty($is_transferfee)){
           $data['counter']=$counter_id;
           $data['account_type']=$type;
           $data['trade_counter_sales_id']=$trade_counter_sales_id;
           $data['account']=$account;
           $data['pwd']=$pwd;
           $data['compwd']=$compwd;
           $data['name']=$name;
           $data['account_code']=$account_code;
           $data['customer']=$customer;
           $data['money']=$money;
           $data['status']=$status;
           $data['rate']=$rate;
           $data['state_type']=$state_type;
           $data['is_transferfee']=$is_transferfee;
           $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
          $num1= $this->getRandomString(8,$chars);
           $num2= $this->getRandomString(4,$chars);
           $num3= $this->getRandomString(4,$chars);
           $num4= $this->getRandomString(4,$chars);
           $num5= $this->getRandomString(12,$chars);
           $data['check_code']= $num1."-".$num2."-".$num3."-".$num4."-".$num5;
           $data['principal']='总管理,测试分管理';
           $data['creator']='厦门奔一奔';
           $data['create_time']=date('Y-m-d H:i:s',time());
           Db('trading_account')->strict(false)->insert($data);

       }else{
           echo $this->fetch();
       }
    }
    public function Lists(){
        if(empty(input('name'))&&empty(input('counter'))){
            $row=Db('trading_account')->paginate(30,false,['query' => input('param.')]);
        }else if(!empty(input('name'))&&empty(input('counter'))){
            $map['name']=input('name');
            $row=Db('trading_account')->where($map)->paginate(30,false,['query' => input('param.')]);
        }else if(empty(input('name'))&&!empty(input('counter'))){
            $map['counter']=input('counter');
            $row=Db('trading_account')->where($map)->paginate(30,false,['query' => input('param.')]);
        }else if(!empty(input('name'))&&!empty(input('counter'))){
            $map['counter']=input('counter');
            $map['name']=input('name');
            $row=Db('trading_account')->where($map)->paginate(30,false,['query' => input('param.')]);
        }
//        $input   = input('');
//        if(!empty($input['counter']) && $input['counter']===10){
//            $map['counter'] = $input['counter'];
//        }else if(!empty($input['counter']) && $input['counter']!=-1){
//            $map['counter'] = $input['counter'];
//
//        }
//
//          $row=Db('trading_account')->where($map)->paginate(30,false,['query' => input('param.')]);
//        $rows=$row;
//        if($input['name']==''){
//            $a='';
//        }else{
//            $a=$input['name'];
//        }
//        $this->assign('counter',$counter);
        $this->assign('name',input('name'));
        $this->assign('data',$row);
        echo $this->fetch();
    }
    public function ChangeStatus(){

    }
    public function Edit(){
       $id=input('id');
        $data=Db('trading_account')->where('del',0)->where('id',$id)->find();
        $this->assign('data',$data);
        echo $this->fetch();
    }



}