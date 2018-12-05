<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>腾讯地图-地图参数使用示例</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=L3YBZ-OTP34-TYUUY-XLJDC-2ROST-LCBJQ"></script>
    <script src="{{asset('js/jquery-1.9.1.min.js')}}"></script>
    <script type="text/javascript" src="https://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>

    <style type="text/css">
        * {
            margin: 0px;
            padding: 0px;
        }
        body,
        button,
        input,
        select,
        textarea {
            font: 12px/22px Verdana, Helvetica, Arial, sans-serif;
        }
        html,
        body {
            height: 100%;
            margin: 0px;
            padding: 0px;
        }
        #container {
            width: 100%;
            height: 100%
        }
        .okBtn{
            width: 100px;
            height: 40px;
            background: #00b7ee;
            position: absolute;
            bottom: 10px;
            right: 150px;
            color: #fff;
            text-align: center;
            line-height: 40px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>

<body onload="init()">
<div id="container"></div>
<div class="okBtn">
    确定
</div>
<script type="text/javascript">
    function init() {
        var location="{$location.lat},{$location.lng}";
        var map = new qq.maps.Map(document.getElementById("container"), {
            // 地图的中心地理坐标。
            center: new qq.maps.LatLng("{$location.lat}", "{$location.lng}"),

            //初始化地图缩放级别
            zoom: 14,

            //如果为 true，在初始化地图时不会清除地图容器内的内容
            noClear: true,

            //用作地图 div 的背景颜色。当用户进行平移时，如果尚未载入图块，则显示此颜色。
            //仅在地图初始化时，才能设置此选项
            backgroundColor: "#000000",

            //boundary规定了地图的边界，当拖拽超出限定的边界范围后，会自动移动回来
            //boundary:new qq.maps.LatLngBounds (ne, sw),

            //地图的默认鼠标指针样式
            draggableCursor: "crosshair",

            //拖动地图时的鼠标指针样式
            draggingCursor: "pointer",

            //地图类型ID
            mapTypeId: qq.maps.MapTypeId.ROADMAP,

            //若为false则禁止拖拽
            draggable: true,

            //若为false则禁止滑轮滚动缩放
            scrollwheel: true,

            //若为true则禁止双击放大
            disableDoubleClickZoom: true,

            //若为false则禁止键盘控制地图
            keyboardShortcuts: true,

            //地图类型控件，若为false则停用状态地图类型控件
            mapTypeControl: true,

            //地图类型控件参数
            mapTypeControlOptions: {
                mapTypeIds: [
                    qq.maps.MapTypeId.ROADMAP,
                    qq.maps.MapTypeId.HYBRID,
                    qq.maps.MapTypeId.SATELLITE
                ],
                position: qq.maps.ControlPosition.TOP_RIGHT
            },

            //地图平移控件，若为false则不显示平移控件
            panControl: true,

            //地图平移控件参数
            panControlOptions: {
                position: qq.maps.ControlPosition.TOP_LEFT
            },

            //地图缩放控件，若为false则不显示缩放控件
            zoomControl: true,

            //地图缩放控件参数
            zoomControlOptions: {
                position: qq.maps.ControlPosition.TOP_LEFT
            },

            //地图比例尺控件，若为false则不显示比例尺控件
            scaleControl: true,

            //地图比例尺控件参数
            scaleControlOptions: {
                position: qq.maps.ControlPosition.BOTTOM_RIGHT
            }

        });

        var center=new qq.maps.LatLng("{$location.lat}", "{$location.lng}")
        var marker = new qq.maps.Marker({
            position: center,
            map: map,
            draggable: true
        });
        // //添加监听事件
        qq.maps.event.addListener(
            map,
            'dblclick',
            function(event) {
                marker.setMap(null)
                var center=new qq.maps.LatLng(event.latLng.getLat(), event.latLng.getLng())
                location=event.latLng.getLat()+","+event.latLng.getLng();
                marker = new qq.maps.Marker({
                    position: center,
                    map: map,
                    draggable: true
                });
                // alert('您点击的位置为:[' + event.latLng.getLng() +
                //     ',' + event.latLng.getLat() + ']');
            }
        );

        $('.okBtn').click(function () {
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            parent.layer.close(index); //再执行关闭
            $("#shopLocation",parent.document).val(location)
        })
    }
</script>
</body>

</html>
