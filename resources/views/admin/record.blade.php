@include('public.header')
@include('public.paginate_style')
<title>聊天记录</title>

</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户中心 <span class="c-gray en">&gt;</span> 聊天记录 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    {{--   <div class="text-c"> 日期范围：
           <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
           -
           <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
           <input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="" name="">
           <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
       </div>--}}
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="r">共有数据：<strong>{{count($record)}}</strong> 条</span> </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">

                <th width="80">ID</th>
                <th width="120">客户号</th>

                <th width="90">客服号</th>
                <th width="50">类型</th>
                <th >内容</th>
                <th width="130">加入时间</th>

            </tr>
            </thead>
            <tbody>
            @foreach($record as $k => $v)
                <tr class="text-c">
                    <td>{{$v['id']}}</td>
                    <td><u class="text-primary" >{{$v['client_number']}}</u></td>
                    <td>{{$v['customer_number']}}</td>
                    <td>{{$v['type']}}</td>
                    <td style="text-overflow: clip">{{$v['content']}}</td>
                    <td>{{$v['created_at']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div id="pull_right">
            <div class="pull-right">
                {!! $record->render() !!}
            </div>
        </div>
    </div>
</div>
@include('public.footer')

<!--请在下方写此页面业务相关的脚本-->
@include('public.logic')
<script type="text/javascript">
    /*  $(function(){
          $('.table-sort').dataTable({
              "aaSorting": [[ 1, "desc" ]],//默认第几个排序
              "bStateSave": true,//状态保存
              "aoColumnDefs": [
                 // {"bVisible": false, "aTargets": [ 3 ]}, //控制列的隐藏显示
                  {"orderable":false,"aTargets":[0,8,9]}// 制定列不参与排序
              ]
          });

      });*/

    /*用户-查看*/
    function member_show(title,url,id,w,h){
        layer_show(title,url,w,h);
    }

    /*用户-编辑*/
    function member_edit(title,url,id,w,h){
        layer_show(title,url,w,h);
    }


</script>
</body>
</html>