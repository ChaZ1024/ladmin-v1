@extends('Admin.layouts.contentlayout')

@section('content')
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">{{$title}}列表</div>
                <div class="layui-card-body">
                    <table class="layui-hide" id="list" lay-filter="list"></table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/html" id="controller">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
    <script type="text/html" id="addInfo">
            <a class="layui-btn layui-btn-xs" lay-event="add">添加{{$title}}</a>
    </script>

    <script type="text/html" id="avatar">
        @{{#  if(d.avatar!=''){ }}
        <img src="@{{d.avatar}}" style="width: 25px;height: 25px"  alt="">
        @{{#  } else { }}
        <img src="{{asset('image/default.jpg') }}" style="width: 25px;height: 25px" alt="">
        @{{#  } }}
    </script>
    <script type="text/html" id="status">
        @{{#  if(d.status === 1){ }}
        <span style="color: #F581B1;">正常</span>
        @{{#  } else { }}
        <span style="color: #ddd;">禁用</span>
        @{{#  } }}
    </script>
    <script type="text/html" id="super">
        @{{#  if(d.super === 1){ }}
        <span style="color: #F581B1;">超级管理员</span>
        @{{#  } else { }}
        <span style="color: #999;">普通管理员</span>
        @{{#  } }}
    </script>

@stop

@section('js')

    <script>
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            var $ = layui.jquery;
            var form = layui.form;
            var table = layui.table;
            var dataTable = table.render({
                elem: '#list',
                toolbar:'#addInfo'
                ,url:"{{route('authAdmin')}}"
                ,cols: [[
                    {field:'id', width:80, title: 'ID', sort: true}
                    ,{field:'avatar', width:80,  align:'center',  title: '头像',  toolbar:'#avatar'}
                    ,{field:'account',  title: '账号'}
                    ,{field:'password',  title: '密码', }
                    ,{field:'super',title:"超级管理员",toolbar:"#super"}
                    ,{field:'phone',  title: '电话'}
                    ,{field:'email',  title: 'email'}
                    ,{field:'status', title: '状态',toolbar:"#status"}
                    ,{  title: '操作', toolbar:'#controller'}
                ]]
                ,page: true
            });
            table.on('toolbar(list)', function(obj){
                var layEvent = obj.event; //获得 lay-event 对应的值
                switch (layEvent) {
                    case 'add':
                        layer.open({
                            type: 2,
                            title: "{{$title}}添加",
                            shadeClose: true,
                            shade: 0.8,
                            area: ['80%', '80%'],
                            content: "{{route('authAdminAdd')}}" //iframe的url
                        });
                        break;
                }
            });
            table.on('tool(list)', function(obj){
                var data = obj.data //获得当前行数据

                    ,layEvent = obj.event; //获得 lay-event 对应的值
                console.log(layEvent)
                switch (layEvent) {
                    case 'edit':
                        layer.open({
                            type: 2,
                            title: "{{$title}}编辑",
                            shadeClose: true,
                            shade: 0.8,
                            area: ['80%', '80%'],
                            content: "{{route('authAdminEdit')}}?id="+data.id //iframe的url
                        });
                        break;
                    case 'del':

                        $.ajax({
                            url: "{{route('authAdminDel')}}",
                            dataType: 'json',
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                            type: "POST",
                            data: {id:data.id},
                            success: function (data) {
                                var icon = 5;
                                if (data.code == 1) {
                                    icon = 6;
                                    setTimeout(function () {
                                        window.location.reload();
                                    },1500)

                                }
                                layer.msg(data.msg, {icon: icon})
                            }
                        });

                        break;
                }
            });
        });
    </script>

@stop
