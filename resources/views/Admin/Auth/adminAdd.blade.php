@extends('Admin.layouts.contentlayout')

@section('content')
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">{{$title}}{{isset($detail->id)?'编辑':'添加'}}</div>
                <div class="layui-card-body">
                    <form class="layui-form" action="" lay-filter="component-form-group">

                        <div class="layui-form-item">
                            <label class="layui-form-label">头像</label>
                            <div class="layui-input-block">
                                <div class="layui-upload">
                                    <button type="button" class="layui-btn" id="uploadImage">上传图片</button>
                                    <div class="layui-upload-list">
                                        <img class="layui-upload-img"
                                             src="{{!empty($detail->avatar)?$detail->avatar:asset('image/default.jpg') }}"
                                             style="width: 60px;height: 60px" alt="" id="demo1">
                                        <img class="layui-upload-img" src="">
                                        <input type="hidden" name="avatar" id="avatarUrl"
                                               value="{{isset($detail->avatar)?$detail->avatar:'' }}">
                                        <p id="demoText"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">账号</label>
                            <div class="layui-input-block">
                                <input type="text" name="account"
                                       value="{{isset($detail->account)?$detail->account:''}}" lay-verify="required"
                                       autocomplete="off"
                                       placeholder="请输入{{$title}}账号" class="layui-input">
                                <input type="hidden" name="id" value="{{isset($detail->id)?$detail->id:''}}"/>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">密码</label>
                            <div class="layui-input-block">
                                <input type="text" name="password" value="" autocomplete="off"
                                       placeholder="请输入{{$title}}密码" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">角色</label>
                            <div class="layui-input-block">
                                <select name="role" lay-filter="aihao">

                                    @foreach($roleData as $k=>$v)
                                        @if(isset($detail->role_id))
                                            @if($detail->role_id==$v['id'])
                                                <option value="{{$v['id']}}" selected>{{$v['title']}}</option>
                                            @else
                                                <option value="{{$v['id']}}">{{$v['title']}}</option>
                                            @endif
                                        @else
                                            <option value="{{$v['id']}}">{{$v['title']}}</option>
                                        @endif


                                    @endforeach

                                </select>
                            </div>

                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">邮箱</label>
                            <div class="layui-input-block">
                                <input type="text" name="email" value="{{isset($detail->email)?$detail->email:''}}"
                                       lay-verify="required" autocomplete="off"
                                       placeholder="请输入{{$title}}邮箱" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">电话</label>
                            <div class="layui-input-block">
                                <input type="text" name="phone" value="{{isset($detail->phone)?$detail->phone:''}}"
                                       lay-verify="required" autocomplete="off"
                                       placeholder="请输入{{$title}}电话" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">超级管理员</label>
                            <div class="layui-input-block">
                                @if(isset($detail->super))
                                    <input type="radio" name="super" {{$detail->super==1?'checked=""':''}} value="1"
                                           title="是">
                                    <input type="radio" name="super" value="0"
                                           title="否" {{$detail->super==0?'checked=""':''}} >
                                @else
                                    <input type="radio" name="super" value="1" title="是">
                                    <input type="radio" name="super" value="0" title="否" checked="">
                                @endif
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">状态</label>
                            <div class="layui-input-block">
                                @if(isset($detail->status))
                                    <input type="radio" name="status" {{$detail->status==1?'checked=""':''}} value="1"
                                           title="开启">
                                    <input type="radio" name="status" value="0"
                                           title="禁用" {{$detail->status==0?'checked=""':''}} >
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
        <img src="" id="avatarUrl" alt="">
    </div>

@stop

@section('js')

    <script>
        layui.use(['layer', 'table', 'form', 'upload'], function () {
            var layer = layui.layer;
            var $ = layui.jquery;
            var form = layui.form;
            var upload = layui.upload;

            //普通图片上传
            var uploadInst = upload.render({
                elem: '#uploadImage'
                , url: '{{route('uploadImg')}}'
                , headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                , field: "image"
                , before: function (obj) {
                    //预读本地文件示例，不支持ie8
                    obj.preview(function (index, file, result) {
                        $('#demo1').attr('src', result); //图片链接（base64）
                    });
                }
                , done: function (res) {
                    //如果上传失败
                    if (res.code == 0) {
                        return layer.msg('上传失败', {icon: 6});
                    } else {
                        var url = res.data.image;
                        $("#avatarUrl").val(url);
                    }
                    //上传成功
                }
                , error: function () {
                    //演示失败状态，并实现重传
                    var demoText = $('#demoText');
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function () {
                        uploadInst.upload();
                    });
                }
            });
            form.on('submit(component-form-demo1)', function (e) {

                $.ajax({
                    url: "{{route('authAdminAdd')}}",
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
                            }, 1500)

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
