<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    //
    public function index(){
        $userHasNode=Session::get('userHasNode');
        if($userHasNode=='all'){
            $navList=DB::table('node')
                ->where('status',1)
                ->select('title','router','pid','id','etitle','icon')
                ->get()
                ->map(function ($value) {return (array)$value;})
                ->toArray();
        }else{
            $navList=DB::table('node')
                ->whereIn('router',$userHasNode)
                ->select('title','router','pid','id','etitle','icon')
                ->get()
                ->map(function ($value) {return (array)$value;})
                ->toArray();
        }

        $userInfo=Session::get('userInfo');
        $navListTree=getTree($navList,"id","pid",0);
        return view('Admin.Index.index', ['navList' => $navListTree,'userInfo'=>$userInfo]);
    }


    public function home(){
        return view('Admin.Index.home');
    }
}
