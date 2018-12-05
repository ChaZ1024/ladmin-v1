@extends('Admin.layouts.contentlayout')

@section('content')
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">{{$title}}{{isset($detail->id)?'编辑':'添加'}}</div>
                <div class="layui-card-body">
                    <form class="layui-form" action="" lay-filter="component-form-group">

                        <div class="layui-form-item">
                            <label class="layui-form-label">{{$title}}名称</label>
                            <div class="layui-input-block">
                                <input type="text" name="title" value="{{isset($detail->title)?$detail->title:''}}" lay-verify="required" autocomplete="off"
                                       placeholder="请输入{{$title}}名称" class="layui-input">
                                <input type="hidden" name="id" value="{{isset($detail->id)?$detail->id:''}}" />
                            </div>
                        </div>



                        <div class="layui-form-item">
                            <label class="layui-form-label">角色状态</label>
                            <div class="layui-input-block">
                                @if(isset($detail->status))
                                    <input type="radio" name="status" {{$detail->status==1?'checked=""':''}} value="1" title="开启">
                                    <input type="radio" name="status" value="0" title="禁用" {{$detail->status==0?'checked=""':''}} >
                                @else
                                    <input type="radio" name="status" value="1" title="开启">
                                    <input type="radio" name="status" value="0" title="禁用" checked="">
                                @endif

                            </div>
                        </div>

                        <div class="layui-form-item layui-layout-admin">
                            <div class="layui-input-block">
                                <div class="layui-footer" style="left: 0;">
                                    <button class="layui-btn" lay-submit="" lay-filter="component-form-demo1">立即提交
                                    </button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')

    <script>
        layui.use(['layer', 'table', 'form'], function () {
            var layer = layui.layer;
            var $ = layui.jquery;
            var form = layui.form;
            form.on('submit(component-form-demo1)', function (e) {

                $.ajax({
                    url: "{{route('authRoleAdd')}}",
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    type: "POST",
                    data: e.field,
                    success: function (data) {
                        var icon = 5;
                        if (data.code == 1) {
                            icon = 6;
                            setTimeout(function () {
                                window.parent.location.reload();
                            },1500)

                        }
                        layer.msg(data.msg, {icon: icon})
                    },
                    error: function (msg) {
                        if (msg.statusText != 'OK') {
                            $.each(msg.responseJSON.errors, function (key, value) {
                                layer.msg(value[0], {icon: 5})
                            });
                        } else {

                        }
                    },
                })
                return false;
            })
        });
    </script>

@stop
