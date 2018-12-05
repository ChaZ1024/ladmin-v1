@extends('Admin.layouts.contentlayout')

@section('content')
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-header">邮件服务</div>
            <div class="layui-card-body">

                <div class="layui-form" wid100 lay-filter="">
                    <div class="layui-form-item">
                        <label class="layui-form-label">SMTP服务器</label>
                        <div class="layui-input-inline">
                            <input type="text" name="smtp[SMTP_SERVER]" value="{{sys_config('SMTP_SERVER')}}" class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">如：smtp.163.com</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">SMTP端口号</label>
                        <div class="layui-input-inline" style="width: 80px;">
                            <input type="text" name="smtp[SMTP_PORT]" value="{{sys_config('SMTP_PORT')}}" class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">一般为 25 或 465</div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">发件人邮箱</label>
                        <div class="layui-input-inline">
                            <input type="text" name="smtp[SMTP_EMAIL]" value="{{sys_config('SMTP_EMAIL')}}" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">发件人昵称</label>
                        <div class="layui-input-inline">
                            <input type="text" name="smtp[SMTP_NICKNAME]" value="{{sys_config('SMTP_NICKNAME')}}" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">邮箱登入密码</label>
                        <div class="layui-input-inline">
                            <input type="text" name="smtp[SMTP_PASSWORD]" value="{{sys_config('SMTP_PASSWORD')}}" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit lay-filter="set_system_email">确认保存</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@stop

@section('js')

    <script>
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            var $ = layui.jquery;
            var form = layui.form;
            var table = layui.table;
            form.on('submit(set_system_email)',function (e) {
                console.log(e)

                $.ajax({
                    url: "{{route('sysSmtp')}}",
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    type: "POST",
                    data: e.field,
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

                return false;
            })
        });
    </script>

@stop
