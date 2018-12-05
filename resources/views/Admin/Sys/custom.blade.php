@extends('Admin.layouts.contentlayout')

@section('content')
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-header">自定义设置</div>
            <div class="layui-card-body" pad15>
                <form class="layui-form" action="" lay-filter="component-form-group">
                    <div class="layui-form" wid100 lay-filter="">
                        <div class="layui-form-item">
                            <label class="layui-form-label">系统名称</label>
                            <div class="layui-input-block">
                                <input type="text" name="sys[SYS_NAME]" value="{{sys_config('SYS_NAME')}}" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">系统域名</label>
                            <div class="layui-input-block">
                                <input type="text" name="sys[SYS_DOMAIN]"  value="{{sys_config('SYS_DOMAIN')}}" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">备案号</label>
                            <div class="layui-input-block">
                                <input type="text" name="sys[SYS_RECORD]"  value="{{sys_config('SYS_RECORD')}}" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">公司名称</label>
                            <div class="layui-input-block">
                                <input type="text" name="sys[COMPANY_NAME]"  value="{{sys_config('COMPANY_NAME')}}" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">公司地址</label>
                            <div class="layui-input-block">
                                <input type="text" name="sys[COMPANY_ADD]"  value="{{sys_config('COMPANY_ADD')}}" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">联系电话</label>
                            <div class="layui-input-block">
                                <input type="text" name="sys[COMPANY_PHONE]"  value="{{sys_config('COMPANY_PHONE')}}" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">邮箱地址</label>
                            <div class="layui-input-block">
                                <input type="text" name="sys[COMPANY_EMAIL]"  value="{{sys_config('COMPANY_EMAIL')}}" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">版权信息</label>
                            <div class="layui-input-block">
                                <textarea name="sys[SYS_COPYRIGHT]" class="layui-textarea">{{sys_config('SYS_COPYRIGHT')}}</textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <button class="layui-btn" lay-submit lay-filter="set_website">确认保存</button>
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
            form.on('submit(set_website)',function (e) {
                console.log(e)

                $.ajax({
                    url: "{{route('sysBase')}}",
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
