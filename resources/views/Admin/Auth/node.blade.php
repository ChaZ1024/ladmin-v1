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

    <script type="text/html" id="title">
        @{{#  if(d.level === 0){ }}
        <span style="color:#ff0000">@{{d.html}}@{{d.title}}</span>
        @{{#  } else { }}
        @{{d.html}}@{{d.title}}
        @{{#  } }}

    </script>

    <script type="text/html" id="status">
        @{{#  if(d.status === 1){ }}
        <span style="color: #F581B1;">显示</span>
        @{{#  } else { }}
        <span style="color: #ddd;">隐藏</span>
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
                ,url:"{{route('authNode')}}"
                ,cols: [[
                    {field:'id', width:80, title: 'ID', sort: true}
                    ,{field:'title',  title: '名称',toolbar:"#title"}
                    ,{field:'router',  title: '路由'}
                    ,{field:'pid',  title: '父id', }
                    ,{field:'etitle',  title: '英文名'}
                    ,{field:'icon',  title: 'icon图标'}
                    ,{field:'status', title: '状态',toolbar:"#status"}
                    ,{  title: '操作', toolbar:'#controller'}
                ]]
                ,page: true
                ,limit:60
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
                            content: "{{route('authNodeAdd')}}" //iframe的url
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
                            content: "{{route('authNodeEdit')}}?id="+data.id //iframe的url
                        });
                        break;
                    case 'del':

                        $.ajax({
                            url: "{{route('authNodeDel')}}",
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
