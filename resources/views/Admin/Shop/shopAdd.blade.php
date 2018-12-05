@extends('Admin.layouts.contentlayout')

@section('content')
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">{{$title}}{{isset($detail->id)?'编辑':'添加'}}</div>
                <div class="layui-card-body">
                    <form class="layui-form" action="" lay-filter="component-form-group">

                        <div class="layui-form-item">
                            <label class="layui-form-label">商户照片</label>
                            <div class="layui-input-block">
                                <div class="layui-upload">
                                    <button type="button" class="layui-btn" id="uploadImage">上传图片</button>
                                    <div class="layui-upload-list">
                                        <img class="layui-upload-img"
                                             src="{{!empty($detail->pic)?$detail->pic:asset('image/default-shop.jpg') }}"
                                             style="width: 120px;height: 60px" alt="" id="demo1">
                                        <input type="hidden" name="pic" id="imageUrl"
                                               value="{{isset($detail->pic)?$detail->pic:'' }}">
                                        <p id="demoText"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">商户名称</label>
                            <div class="layui-input-block">
                                <input type="text" name="title"
                                       value="{{isset($detail->title)?$detail->title:''}}" lay-verify="required"
                                       autocomplete="off"
                                       placeholder="请输入{{$title}}账号" class="layui-input">
                                <input type="hidden" name="id" value="{{isset($detail->id)?$detail->id:''}}"/>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">商户地址</label>
                            <div class="layui-input-block">
                                <input type="text" name="address" value="{{isset($detail->address)?$detail->address:''}}" autocomplete="off"
                                       placeholder="请输入{{$title}}地址" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">商户介绍</label>
                            <div class="layui-input-block">
                                    <textarea name="discription" placeholder="请输入{{$title}}介绍" class="layui-textarea">{{isset($detail->discription)?$detail->discription:''}}</textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">商户电话</label>
                            <div class="layui-input-block">
                                <input type="text" name="phone" value="{{isset($detail->phone)?$detail->phone:''}}"
                                       lay-verify="required" autocomplete="off"
                                       placeholder="请输入{{$title}}电话" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">商户经度</label>
                            <div class="layui-input-block">
                                <input type="text" name="lat" value="{{isset($detail->lat)?$detail->lat:''}}"
                                       lay-verify="required" autocomplete="off"
                                       placeholder="请输入{{$title}}经度" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">商户纬度</label>
                            <div class="layui-input-block">
                                <input type="text" name="lon" value="{{isset($detail->lon)?$detail->lon:''}}"
                                       lay-verify="required" autocomplete="off"
                                       placeholder="请输入{{$title}}纬度" class="layui-input">
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
                                    <input type="radio" name="status" value="1" title="开启"  checked="">
                                    <input type="radio" name="status" value="0" title="禁用">
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
                        $("#imageUrl").val(url);
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
                    url: "{{route('shopAdd')}}",
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
