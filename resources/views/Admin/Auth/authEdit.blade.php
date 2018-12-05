@extends('Admin.layouts.contentlayout')

@section('content')
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card" style="padding: 30px;">
                <form class=" layui-form layui-form-pane" action="">
                    <div class="layui-form-item">
                        <label class="layui-form-label">角色名称</label>
                        <div class="layui-input-block">
                            <input class="layui-input" value="{{$detail->title}}" type="text" disabled
                                   placeholder=""/>
                        </div>
                        <input name="role_id" type="hidden" value="{{$detail->id}}" type="text"/>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">选择权限</label>
                        <div class="layui-input-block">
                            <div id="LAY-auth-tree-index" style="margin-left: 30px;"></div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" type="submit" lay-submit lay-filter="LAY-auth-tree-submit">提交
                            </button>
                            <button class="layui-btn layui-btn-primary" type="reset">重置</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>

        layui.config({
            base: '/layuiadmin/modules/' //静态资源所在路径
        }).extend({
            authtree: 'authtree' //主入口模块
        }).use(['jquery', 'authtree', 'form', 'layer'], function () {
            var $ = layui.jquery;
            var authtree = layui.authtree;
            var form = layui.form;
            var layer = layui.layer;

            $.ajax({
                url: "{{route('authRoleAuthEdit')}}?id=" + $('input[name=role_id]').val(),
                dataType: 'json',
                type: "GET",
                success: function (data) {
                    var trees = authtree.listConvert(data.data, {
                        primaryKey: 'id'
                        , startPid: 0
                        , parentKey: 'pid'
                        , nameKey: 'title'
                        , valueKey: 'id'
                        , checkedKey: data.checkedId
                    });
                    authtree.render('#LAY-auth-tree-index', trees, {
                        inputname: 'authids[]',
                        layfilter: 'lay-check-auth',
                        autowidth: true,
                    });
                }
            });


            form.on('submit(LAY-auth-tree-submit)', function (e) {
                var authids = authtree.getChecked('#LAY-auth-tree-index');
                $.ajax({
                    url: "{{route('authRoleAuthEdit')}}",
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    type: "POST",
                    data: {role_id: $('input[name=role_id]').val(), node_id: authids},
                    success: function (data) {
                        var icon = 5;
                        if (data.code == 1) {
                            icon = 6;
                            setTimeout(function () {
                                window.parent.location.reload();
                            },1500)

                        }
                        layer.msg(data.msg, {icon: icon})
                    }
                });
                return false;

            })
        });
    </script>

@stop
