<script type="text/javascript" src="{{asset('h-ui/lib/jquery/1.9.1/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('h-ui/lib/layer/2.4/layer.js')}}"></script>
<input type="text" id="copy"  value="{{$location}}" /> <input type="button" value="点击复制" onclick="copy()" />
<img src="{{$url}}" alt=""/>
<script type="application/javascript">
    function copy() {
        var e = document.getElementById("copy");
        e.select(); // 选择对象
        document.execCommand("Copy"); // 执行浏览器复制命令
        layer.msg("复制成功！",{icon:1,time:1000});
    }
</script>
