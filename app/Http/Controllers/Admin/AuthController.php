<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;

class AuthController extends Controller
{
    //
    /**
     * 角色列表
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function role(Request $request)
    {
        if ($request->ajax()) {
            $roleList = DB::table('role')
                ->orderBy('sort', 'ASC')
                ->paginate($request->input('limit'))
                ->map(function ($value) {
                    return (array)$value;
                })
                ->toArray();
            $rolCount = DB::table('role')->count();
            $resData = [
                'code' => 0,
                'msg' => '',
                'count' => $rolCount,
                'data' => $roleList
            ];
            if ($roleList) {
                return $resData;
            }
        } else {
            return view('Admin.Auth.role', ['title' => '角色']);
        }

    }

    /**
     * 编辑角色
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roleEdit(Request $request)
    {
        $roleDb = DB::table('role');
        $roleId = $request->input('id');
        $roleData = $roleDb->where('id', $roleId)->first();
        return view('Admin.Auth.roleAdd', ['title' => '角色', 'detail' => $roleData]);
    }

    /**
     * 删除角色
     * @param Request $request
     * @return array
     */
    public function roleDel(Request $request)
    {
        $roleDb = DB::table('role');
        if ($roleDb->where('id', $request->input('id'))->delete()) {

            $resData = [
                'code' => 1,
                'msg' => '删除成功',
                'data' => ''
            ];
        } else {
            $resData = [
                'code' => 0,
                'msg' => '删除失败',
                'data' => ''
            ];
        }

        return $resData;
    }

    /**
     * 角色添加
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roleAdd(Request $request)
    {
        $roleDb = DB::table('role');
        if ($request->isMethod('post')) {
            $reqRoleData = $request->input();


            $request->validate([
                'title' => 'required|max:30|min:2',
                'status' => 'required',
            ], [
                'title.required' => '角色名不能为空',
                'title.max' => '角色名不能超过30个字符',
                'title.min' => '角色名不能少于2个字符',
                'status.required' => '状态不能为空'
            ]);
            if ($reqRoleData['id']) {
                $reqRoleData['updated_at'] = date('Y-m-d H:i:s');
                if ($roleDb->where('id', $reqRoleData['id'])->update($reqRoleData)) {
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

                if ($roleDb->where('title', $reqRoleData['title'])->first()) {
                    $resData = [
                        'code' => 0,
                        'msg' => '存在相同名称管理员',
                        'data' => ''
                    ];
                } else {
                    unset($reqRoleData['id']);
                    $reqRoleData['created_at'] = date('Y-m-d H:i:s');
                    $reqRoleData['updated_at'] = date('Y-m-d H:i:s');
                    if ($roleDb->insert($reqRoleData)) {
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
        } else {
            return view('Admin.Auth.roleAdd', ['title' => '角色']);
        }

    }

    /**
     * 权限编辑
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function roleAuthEdit(Request $request)
    {

        $nodeDb = DB::table('node');
        $roleDb = DB::table('role');
        $roleNodeDb = DB::table('role_node');
        if ($request->ajax()) {
            if ($request->isMethod('post')) {
                $nodeidList = $request->input('node_id');
                $roleId = $request->input('role_id');
                if ($roleInfo = $roleNodeDb->where('role_id', $roleId)->count() > 0) {

                    if (!$roleNodeDb->where('role_id', $roleId)->delete()) {
                        die();
                    }
                }
                $insertData = array();
                foreach ($nodeidList as $k => $v) {
                    $insertData[] = ['node_id' => $v, 'role_id' => $roleId];
                }
                if ($roleNodeDb->insert($insertData)) {
                    $resData = [
                        'code' => 1,
                        'msg' => '编辑成功',
                        'data' => ''
                    ];
                } else {
                    $resData = [
                        'code' => 0,
                        'msg' => '编辑失败',
                        'data' => ''
                    ];
                }
                return $resData;
            } else {
                $navList = $nodeDb
                    ->select('title', 'router', 'pid', 'id', 'etitle', 'icon')
                    ->get()
                    ->map(function ($value) {
                        return (array)$value;
                    })
                    ->toArray();
                $roleNodeList = $roleNodeDb->where('role_id', $request->input('id'))->get()->map(function ($value) {
                    return (array)$value;
                })
                    ->toArray();
                $checkedId = [];
                foreach ($roleNodeList as $k => $v) {
                    array_push($checkedId, $v['node_id']);
                }
                $navListTree['code'] = 0;
                $navListTree['msg'] = '';
                $navListTree['data'] = $navList;
                $navListTree['checkedId'] = $checkedId;
                return $navListTree;
            }
        } else {
            $roleId = $request->input('id');

            $roleData = $roleDb->where('id', $roleId)->first();
            $navList = $nodeDb
                ->select('title', 'router', 'pid', 'id', 'etitle', 'icon')
                ->get()
                ->map(function ($value) {
                    return (array)$value;
                })
                ->toArray();

            $navListTree = getTree($navList, "id", "pid", 0);
            return view('Admin.Auth.authEdit', ['title' => '权限', 'navlist' => $navListTree, 'detail' => $roleData]);

        }


    }

    /**
     * 管理员列表
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function admin(Request $request)
    {

        if ($request->ajax()) {
            $adminList = DB::table('admins')
                ->orderBy('id', 'ASC')
                ->paginate($request->input('limit'))
                ->map(function ($value) {
                    return (array)$value;
                })
                ->toArray();
            $adminCount = DB::table('admins')->count();
            $resData = [
                'code' => 0,
                'msg' => '',
                'count' => $adminCount,
                'data' => $adminList
            ];

            return $resData;
        } else {
            return view('Admin.Auth.admin', ['title' => '管理员']);
        }
    }

    public function adminEdit(Request $request)
    {
        $adminDb = DB::table('admins');
        $adminId = $request->input('id');
        $adminData = $adminDb
            ->leftJoin('admin_role', 'admins.id', '=', 'admin_role.admin_id')
            ->where('id', $adminId)
            ->first();
//
//        dd($adminData);
        $roleData = DB::table('role')
            ->get()
            ->map(function ($value) {
                return (array)$value;
            })
            ->toArray();

        return view('Admin.Auth.adminAdd', ['title' => '管理员', 'detail' => $adminData, 'roleData' => $roleData]);
    }

    /**
     * 删除管理员
     * @param Request $request
     * @return array
     */
    public function adminDel(Request $request)
    {
        $adminDb = DB::table('admins');
        $adminData = $adminDb->where('id', $request->input('id'))->first();
        if ($adminData->super == 1) {
            $resData = [
                'code' => 0,
                'msg' => '超级管理员不能被删除',
                'data' => ''
            ];
        } else {
            if ($adminDb->where('id', $request->input('id'))->delete()) {

                $resData = [
                    'code' => 1,
                    'msg' => '删除成功',
                    'data' => ''
                ];
            } else {
                $resData = [
                    'code' => 0,
                    'msg' => '删除失败',
                    'data' => ''
                ];
            }
        }
        return $resData;
    }

    /**
     * 添加管理员
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminAdd(Request $request)
    {
        $adminDb = DB::table('admins');
        if ($request->ajax()) {
            $insertData = $request->input();
            $insertData['updated_at'] = date('Y-m-d H:i:s');
            $insertAdminRoleData['role_id'] = $request->input('role');
            $insertAdminRoleData['admin_id'] = $request->input('id');
            unset($insertData['role']);
            unset($insertData['image']);
            DB::beginTransaction();
            if ($request->isMethod('post')) {
                $rule = [
                    'account' => 'required|max:30|min:2',
                    'password' => 'required|max:30|min:6',
                    'phone' => 'required|max:12|min:10',
                ];
                $msg = [
                    'account.required' => '账号不能为空',
                    'password.required' => '密码不能为空',
                    'phone.required' => '电话不能为空',
                    'account.max' => '账号不能超过30个字符',
                    'password.max' => '账号不能超过30个字符',
                    'phone.max' => '账号不能超过12个字符',
                    'account.min' => '角色名不能少于2个字符',
                    'password.min' => '角色名不能少于6个字符',
                    'phone.min' => '角色名不能少于10个字符',
                ];
                if ($request->input('id')) {
                    $resmsg = "更新";
                    if (!$request->input('password')) {
                        unset($rule['password']);
                        unset($insertData['password']);
                    } else {
                        $insertData['password'] = bcrypt($insertData['password']);
                    }
                    $request->validate($rule, $msg);
                    $updateAdminData = $adminDb->where('id', $insertData['id'])->update($insertData);
                } else {
                    $resmsg = "添加";
                    $request->validate($rule, $msg);
                    $insertData['created_at'] = date('Y-m-d H:i:s');
                    $insertData['password'] = bcrypt($insertData['password']);
                    $updateAdminData = $adminDb->insertGetId($insertData);
                    $insertAdminRoleData['admin_id'] = $updateAdminData;
                }
                $adminRoleDb = DB::table('admin_role');

                if ($adminRoleDb->where('admin_id', $insertAdminRoleData['admin_id'])->count() > 0) {
                    $adminRoleDb->where('admin_id', $insertAdminRoleData['admin_id'])->delete();
                }
                $insertAdminRole = $adminRoleDb->insert($insertAdminRoleData);


                if ($insertAdminRole && $updateAdminData) {
                    $resData = [
                        'code' => 1,
                        'msg' => $resmsg . "成功"
                    ];
                    DB::commit();

                } else {
                    $resData = [
                        'code' => 1,
                        'msg' => $resmsg . "失败"
                    ];
                    DB::rollback();
                }

                return $resData;
            }
        } else {
            $roleData = DB::table('role')
                ->get()
                ->map(function ($value) {
                    return (array)$value;
                })
                ->toArray();

            return view('Admin.Auth.adminAdd', ['title' => '管理员', 'roleData' => $roleData]);
        }


    }

    /**
     * 节点列表
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function node(Request $request)
    {
        if ($request->ajax()) {
            $nodeList = DB::table('node')
                ->orderBy('id', 'ASC')
                ->paginate($request->input('limit'))
                ->map(function ($value) {
                    return (array)$value;
                })
                ->toArray();

            $nodeList = recursive($nodeList);
            $nodeCount = DB::table('node')->count();
            $resData = [
                'code' => 0,
                'msg' => '',
                'count' => $nodeCount,
                'data' => $nodeList
            ];
            return $resData;
        } else {
            return view('Admin.Auth.node', ['title' => '节点']);
        }
    }

    /**
     * 编辑节点
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function nodeEdit(Request $request)
    {
        $nodeDb = DB::table('node');
        $nodeList = $nodeDb
            ->get()
            ->map(function ($value) {
                return (array)$value;
            })
            ->toArray();

        $nodeList = recursive($nodeList);

        $nodeData = $nodeDb->where('id', $request->input('id'))->first();

        return view('Admin.Auth.nodeAdd', ['title' => '节点', 'nodeList' => $nodeList, 'detail' => $nodeData]);

    }

    /**
     * 删除节点
     * @param Request $request
     * @return array
     */
    public function nodeDel(Request $request)
    {
        $nodeDb = DB::table('node');
        if ($nodeDb->where('id', $request->input('id'))->delete()) {

            $resData = [
                'code' => 1,
                'msg' => '删除成功',
                'data' => ''
            ];
        } else {
            $resData = [
                'code' => 0,
                'msg' => '删除失败',
                'data' => ''
            ];
        }

        return $resData;
    }

    /**
     *添加节点
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function nodeAdd(Request $request)
    {
        $nodeDb = DB::table('node');
        if ($request->ajax()) {
            $insertNodeData = $request->input();
            $rule = [
                'title' => 'required',
                'router' => 'required',
                'etitle' => 'required',
            ];
            $msg = [
                'title.required' => '标题不能为空',
                'router.required' => '路由不能为空',
                'etitle.required' => '英文名称不能为空',

            ];
            $request->validate($rule, $msg);
            $insertNodeData['updated_at'] = date('Y-m-d H:i:s');
            if ($insertNodeData['id']) {
                if ($nodeDb->where('id', $insertNodeData['id'])->update($insertNodeData)) {
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
                unset($insertNodeData['id']);
                $insertNodeData['created_at'] = date('Y-m-d H:i:s');
                if ($nodeDb->where('router', $insertNodeData['router'])->count() > 0) {
                    $resData = [
                        'code' => 0,
                        'msg' => '存在相同路由的节点',
                        'data' => ''
                    ];
                } elseif ($nodeDb->where('etitle', $insertNodeData['etitle'])->count() > 0) {
                    $resData = [
                        'code' => 0,
                        'msg' => '存在相同英文名的节点',
                        'data' => ''
                    ];
                } else {
                    if ($nodeDb->insert($insertNodeData)) {
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

        } else {

            $nodeList = $nodeDb
                ->get()
                ->map(function ($value) {
                    return (array)$value;
                })
                ->toArray();

            $nodeList = recursive($nodeList);
            return view('Admin.Auth.nodeAdd', ['title' => '节点', 'nodeList' => $nodeList]);


        }


    }

}
