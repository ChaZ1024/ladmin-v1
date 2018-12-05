<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sys;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class SysController extends Controller
{
    //


    public function base(Request $request)
    {

        if ($request->ajax()) {

            $baseData = $request->input();
            $updateBaseData = [];
            foreach ($baseData['sys'] as $k => $v) {
                $updateBaseData[] = [
                    'key' => $k,
                    'value' => $v,
                    'ctype' => 'base',
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
            Sys::query()->where('ctype', 'base')->delete();
            if ( Sys::query()->insert($updateBaseData)) {
                $resData = [
                    'code' => 1,
                    'msg' => '更新成功',
                    'data' => ''
                ];
            } else {
                $resData = [
                    'code' => 0,
                    'msg' => '更新失败',
                    'data' => ''
                ];
            }
            return $resData;

        } else {
            return view('Admin.Sys.base');
        }

    }

    public function custom(Request $request)
    {
        if($request->ajax()){
            $customData=Sys::query()->where('ctype','custom')->get();
            if($customData){
                $resData=[
                    'code'=>1,
                    'msg'=>'获取成功',
                    'data'=>$customData
                ];
            }else{
                $resData = [
                    'code' => 0,
                    'msg' => '获取失败',
                    'data' => ''
                ];
            }
            return $resData;
        }else{
            return view('Admin.Sys.custom');
        }

    }

    public function smtp(Request $request)
    {
        if ($request->ajax()) {

            $smtpData = $request->input();
            $updateSmtpData = [];
            foreach ($smtpData['smtp'] as $k => $v) {
                $updateSmtpData[] = [
                    'key' => $k,
                    'value' => $v,
                    'ctype' => 'smtp',
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
            Sys::query()->where('ctype', 'smtp')->delete();
            if ( Sys::query()->insert($updateSmtpData)) {
                $resData = [
                    'code' => 1,
                    'msg' => '更新成功',
                    'data' => ''
                ];
            } else {
                $resData = [
                    'code' => 0,
                    'msg' => '更新失败',
                    'data' => ''
                ];
            }
            return $resData;

        } else {
            return view('Admin.Sys.smtp');
        }
    }
}
