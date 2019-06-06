@include('public.header')
    <title>我的桌面</title>
</head>
<body>
<div class="page-container">

    <table class="table table-border table-bordered table-bg mt-20">
        <thead>
        <tr>
            <th colspan="2" scope="col">服务器信息</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th width="200">系统</th>
            <td><span id="lbServerName">{!! $systeminfo['os'] !!}</span></td>
        </tr>

        <tr>
            <td>客户端IP </td>
            <td>{{$systeminfo['remote_addr']}}</td>
        </tr>
        <tr>
            <td>服务器端IP</td>
            <td>{{$systeminfo['server_name']}}</td>
        </tr>
        <tr>
            <td>脚本运行占用最大内存 </td>
            <td>{{$systeminfo['memorylimit']}}/td>
        </tr>
        <tr>
            <td>最大上传文件大小</td>
            <td>{{$systeminfo['maxuploadfile']}}</td>
        </tr>

        <tr>
            <td>PHP版本 </td>
            <td>{{$systeminfo['phpversion']}}</td>
        </tr>
        <tr>
            <td>ZEND版本 </td>
            <td>{{$systeminfo['zendversion']}}</td>
        </tr>
        <tr>
            <td>服务器当前时间 </td>
            <td>{{$systeminfo['nowtime']}}</td>
        </tr>

        </tbody>
    </table>
</div>
<footer class="footer mt-20">
    <div class="container">
        <p>
            Copyright &copy;2015-2017 admin manager system All Rights Reserved.
           </p>
    </div>
</footer>
<script type="text/javascript" src="{{asset('h-ui/lib/jquery/1.9.1/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('h-ui/static/h-ui/js/H-ui.min.js"')}}></script>

</body>
</html>