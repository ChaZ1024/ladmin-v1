<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



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
                   Session::put('userInfo', $adminInfo);

                   if($adminInfo['super']==1){
                       Session::put('userHasNode','all');
                   }else{

                       $userHasNode=DB::table('admin_role')
                           ->rightJoin('role_node','role_node.role_id','=','admin_role.role_id')
                           ->leftJoin('node','role_node.node_id','=','node.id')
                           ->where('admin_role.admin_id','=',$adminInfo->id)
                           ->select('node.router')
                           ->get();
                        $userHasNodeList=[];
                        foreach ($userHasNode as $k=>$v){
                            $userHasNodeList[]=$v->router;
                        }

                       $sysNode=DB::table('node')->select('router')->get();

                        $sysNodeList=[];
                       foreach ($sysNode as $k=>$v){
                           $sysNodeList[]=$v->router;
                       }
                       Session::put('sysNode',$sysNodeList);
                       Session::put('userHasNode',$userHasNodeList);

                   }



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
            return view('Admin.login');
        }


    }




}
