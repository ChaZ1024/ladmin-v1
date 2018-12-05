@extends('Admin.layouts.contentlayout')

@section('content')
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-header">基础设置</div>
            <div class="layui-card-body" pad15>
                <form class="layui-form" action="" lay-filter="component-form-group">
                <div class="layui-form" wid100 lay-filter="">
                    <div class="layui-form-item">
                        <label class="layui-form-label">小程序名</label>
                        <div class="layui-input-block">
                            <input type="text" name="mapp[MAPP_NAME]" value="{{mapp_config('MAPP_NAME')}}" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">小程序码</label>
                        <div class="layui-input-block">
                            <input type="text" name="mapp[MAPP_QRCODE]"  value="{{mapp_config('MAPP_QRCODE')}}" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">APPID</label>
                        <div class="layui-input-block">
                            <input type="text" name="mapp[MAPP_APPID]"  value="{{mapp_config('MAPP_APPID')}}" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">APPSECRET</label>
                        <div class="layui-input-block">
                            <input type="text" name="mapp[COMPANY_APPSECRET]"  value="{{mapp_config('COMPANY_APPSECRET')}}" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit lay-filter="set_miniapp_conf">确认保存</button>
                        </div>
                    </div>
                </div>
                </form>
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
            form.on('submit(set_miniapp_conf)',function (e) {
                console.log(e)

                $.ajax({
                    url: "{{route('miniappConf')}}",
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
