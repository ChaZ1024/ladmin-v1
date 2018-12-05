<?php
/**
 * Created by PhpStorm.
 * User: chaz
 * Date: 18-11-27
 * Time: 下午9:42
 */

function getTree($arr,$key,$fkey,$num)
{
    $list = array();
    foreach($arr as $val){
        $val['checked']="true";
        if($val[$fkey] == $num){
            $tmp = getTree($arr,$key,$fkey,$val[$key]);
            if($tmp){
                $val['son'] = $tmp;
            }

            $list[] = $val;
        }
    }
    return $list;
}


function recursive($array,$pid=0,$level=0){
    $arr = array();
    foreach ($array as $v) {
        if($v['pid'] == $pid){
            $v['level'] = $level;
            $v['html'] = str_repeat('---',$level);
            $arr[] = $v;
            $arr = array_merge($arr,recursive($array,$v['id'],$level+1));
        }
    }
    return $arr;
}


function sys_config($k){
    $configData=\Illuminate\Support\Facades\DB::table('sys_config')->where('key',$k)->first();
    if($configData){
        return $configData->value;
    }else{
        return '';
    }
}



function mapp_config($k){
    $configData=\Illuminate\Support\Facades\DB::table('miniapp_conf')->where('key',$k)->first();
    if($configData){
        return $configData->value;
    }else{
        return '';
    }
}
