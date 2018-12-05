<?php

namespace App\Http\Controllers\Admin;

use App\Models\Miniappconf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MiniappController extends Controller
{
    //
    public function conf(Request $request){
        if ($request->ajax()) {

            $confData = $request->input();
            $updateMiniappConfData = [];
            foreach ($confData['mapp'] as $k => $v) {
                $updateMiniappConfData[] = [
                    'key' => $k,
                    'value' => $v,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
            Miniappconf::query()->delete();
            if ( Miniappconf::query()->insert($updateMiniappConfData)) {
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
            return view('Admin.Miniapp.conf');
        }
    }
}
