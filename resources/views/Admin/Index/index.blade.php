@extends('Admin.layouts.layout')
@section('title')
@stop

@section('content')
    <div class="layui-body" id="LAY_app_body">
        <div class="layadmin-tabsbody-item layui-show">
            <iframe src="/home" frameborder="0" class="layadmin-iframe"></iframe>
        </div>
    </div>
@stop

@section('leftNav')
    <div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
            <div class="layui-logo" lay-href="/home">
                <span>大象智能</span>
            </div>

            <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu"
                lay-filter="layadmin-system-side-menu">

                @foreach ($navList as $item)
                    <li data-name="{{$item['etitle']}}" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="{{$item['title']}}" lay-direction="2">
                            <i class="layui-icon {{$item['icon']}}"></i>
                            <cite>{{$item['title']}}</cite>
                        </a>
                        <dl class="layui-nav-child">
                            @if(isset($item['son']))
                                @foreach ($item['son'] as $vo)
                                    <dd data-name="{{$vo['etitle']}}">
                                        <a lay-href="{{$vo['router']}}">{{$vo['title']}}</a>
                                    </dd>
                                @endforeach
                            @endif
                        </dl>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>


@stop

@section('js')
    <script>
        layui.config({
            base: '/layuiadmin/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use('index');
    </script>

@stop
