<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    //

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $shopList = Shop::query()
                ->paginate($request->input('limit'))
                ->toArray();
            $shopCount = Shop::query()->count();
            $resData = [
                'code' => 0,
                'msg' => '',
                'count' => $shopCount,
                'data' => $shopList['data']
            ];
            return $resData;
        } else {
            return view('Admin.Shop.list', ['title' => '商户']);
        }

    }

    public function shopAdd(Request $request){
        if($request->ajax()){
            $insertShopData=$request->input();
            unset($insertShopData['image']);

            $rule = [
                'title' => 'required',
                'pic' => 'required',
                'address' => 'required',
                'discription' => 'required',
                'phone' => 'required',
            ];
            $msg = [
                'title.required' => '名称不能为空',
                'pic.required' => '公司图片不能为空',
                'address.required' => '地址不能为空',
                'discription.required' => '描述不能为空',
                'phone.required' => '电话不能为空',

            ];
            $request->validate($rule, $msg);
            $insertShopData['updated_at'] = date('Y-m-d H:i:s');

            if ($insertShopData['id']) {
                if (Shop::query()->where('id', $insertShopData['id'])->update($insertShopData)) {
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

            } else {
                unset($insertShopData['id']);
                $insertShopData['created_at'] = date('Y-m-d H:i:s');
                if (Shop::query()->where('title', $insertShopData['title'])->count() > 0) {
                    $resData = [
                        'code' => 0,
                        'msg' => '存在相同名称商户',
                        'data' => ''
                    ];
                }else {
                    if (Shop::query()->insert($insertShopData)) {
                        $resData = [
                            'code' => 1,
                            'msg' => '添加成功',
                            'data' => ''
                        ];
                    } else {
                        $resData = [
                            'code' => 0,
                            'msg' => '添加失败',
                            'data' => ''
                        ];
                    }
                }

            }

            return $resData;

        }else{
            return view('Admin.Shop.shopAdd', ['title' => '商户']);
        }

    }

    public function shopEdit(Request $request){

        $shopId = $request->input('id');
        $shopData = Shop::query()->where('id', $shopId)->first();
        return view('Admin.Shop.shopAdd', ['title' => '节点', 'detail' => $shopData]);
    }
}
