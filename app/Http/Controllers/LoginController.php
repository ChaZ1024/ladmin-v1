<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * 登录页面
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(Request $request){

        if($request->ajax()){

           if(Session::get('code')!=trim(strtolower($request->input('vercode')))){
               $resData=[
                   'msg'=>'验证码错误',
                   'status'=>0,
               ];
           }else{
               $whereMap['account']=$request->input('account');
               $whereMap['status']=1;
               $adminInfo=Admin::where($whereMap)->first();

               if(Hash::check($request->input('password'),$adminInfo['password'])){
                   Session::put('authToken', $whereMap['account']);
                   $resData=[
                       'msg'=>'登录成功',
                       'status'=>1,
                   ];
               }else{
                   $resData=[
                       'msg'=>'账号或密码有误',
                       'status'=>0,
                   ];
               }
           }
           return $resData;

        }else{
            return view('login');
        }


    }

    //生成验证码方法
    public function captcha($tmp)
    {
        $phrase = new PhraseBuilder;
        // 设置验证码位数
        $code = $phrase->build(4);
        // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色
        $builder->setBackgroundColor(76,224,230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(20);
        $builder->setMaxFrontLines(20);
        // 可以设置图片宽高及字体
        $builder->build($width = 90, $height = 35, $font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // 把内容存入session
        Session::flash('code', $phrase);
        // 生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }



}
