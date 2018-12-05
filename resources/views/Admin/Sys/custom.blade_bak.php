@extends('Admin.layouts.contentlayout')

@section('content')
    <div class="layui-col-md12">
        <div class="layui-card">
            <div class="layui-card-header">自定义设置</div>
            <div class="layui-card-body" pad15>
                <form class="layui-form" action="" lay-filter="component-form-group">
                    <div class="layui-form" wid100 lay-filter="" id="app">
                        <div class="layui-row layui-col-space10 layui-form-item">
                            <div class="layui-col-lg3">
                                <label class="layui-form-label">员工姓名：</label>
                                <div class="layui-input-block">
                                    <input type="text" name="fullname" lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-col-lg3">
                                <label class="layui-form-label">技术工种：</label>
                                <div class="layui-input-block">
                                    <input type="text" name="fullname" lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-col-lg3">
                                <label class="layui-form-label">技术工种：</label>
                                <div class="layui-input-block">
                                    <input type="text" name="fullname" lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
                                </div>
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
    <script src="{{asset('js/vue.min.js')}}"></script>
    <script src="{{asset('js/axios.min.js')}}"></script>
    <script>
        var app = new Vue({
            el: '#app',
            beforeCreate(){
                console.log(111)
            },
            created(){
                var that=this;

                axios({
                    url: "{{route('sysCustom')}}",
                    method: 'get',
                    responseType: 'json', // 默认的
                    headers: {'X-Requested-With': 'XMLHttpRequest'},

                }).then(function (response) {
                    var resData=response.data;
                    if(resData.code==1){
                        that.customList=resData.data;
                    }
                    console.log(response);
                    console.log(response.data);
                }).catch(function (error) {
                    console.log(error);
                })

            },
            data: {
                customList: []
            }
        })
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            var $ = layui.jquery;
            var form = layui.form;
            var table = layui.table;

        });
    </script>

@stop
