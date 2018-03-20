<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/3 0003
 * Time: 上午 10:44
 */
namespace app\common\helper;
use Gregwar\Captcha\CaptchaBuilder;
class Verify
{
    /**
     * 生成验证码
     */
    public static function verify()
    {
        $builder = new CaptchaBuilder();
        $builder->build()->output();
        session('verify_code', $builder->getPhrase());

    }
    /**
     * 检测验证码是否正确
     * @param $code
     * @return bool
     */
    public static function check($code)
    {
        return ($code == session('verify_code') && $code != '') ? true : false;
    }


}