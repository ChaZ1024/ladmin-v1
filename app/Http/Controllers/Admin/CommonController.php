<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CommonController extends Controller
{
    //

    public function uploadImg(Request $request)
    {
        if ($request->isMethod('post')) {
            $file = $request->file('image');
            if ($file) {
                $extension = $file->guessExtension();
                $newName = str_random(18) . "." . $extension;
                $file->move(base_path() . '/public/storage/uploads', $newName);
                $idCardFrontImg = '/storage/uploads/' . $newName;
                $resData = ['code' => 1, 'msg' => '上传成功', 'data' => ['image' => $idCardFrontImg]];
            } else {
                $resData = ['code' => 0, 'msg' => '上传失败', 'data' => []];
            }
            return $resData;
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
        $builder->setBackgroundColor(76, 224, 230);
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
    public function noauth(){
        echo "<center><span style='margin-top: 40%;color: #FF5722;font-size: 30px;'>无权限</span></center>";
    }


    public function map(){


        return view('Admin.Common.map');

    }

}
