<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

class IndexController extends Controller
{
    //
    public function index(){
        $userNavList=[
            'nav1'=>[
                
            ]
        ];
        return view('Index.index', ['name' => '学院君']);
    }


    public function home(){
        return view('Index.home');
    }
}
