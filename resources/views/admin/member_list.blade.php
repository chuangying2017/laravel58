@include('public.header')
@include('public.paginate_style')
<title>用户管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户中心 <span class="c-gray en">&gt;</span> 用户管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
 {{--   <div class="text-c"> 日期范围：
        <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
        -
        <input type="text" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
        <input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、邮箱" id="" name="">
        <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
    </div>--}}
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
           {{-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius">
                <i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>--}}
            <a href="javascript:;" onclick="member_add('添加用户','{{route("admin.memberAdd")}}','','300')" class="btn btn-primary radius">
                <i class="Hui-iconfont">&#xe600;</i> 添加用户</a></span>
        <span class="r">共有数据：<strong>{{count($member)}}</strong> 条</span> </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="80">ID</th>
                <th width="100">用户名</th>

                <th width="90">客服号</th>

                <th width="90">客服昵称</th>
                <th width="130">加入时间</th>

                <th width="70">状态</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($member as $k => $v)
                <tr class="text-c">
                    <td><input type="checkbox" value="{{$v['id']}}" name="power"></td>
                    <td>{{$k + 1}}</td>
                    <td><u class="text-primary" >{{$v['username']}}</u></td>
                    <td>{{$v['number']}}</td>
                    <td>@empty($v['name']) <li style="color: indianred;list-style-type: none;">暂无昵称</li> @else {{$v['name']}} @endempty</td>
                    <td>{{$v['created_at']}}</td>

                    @if($v['status'] == 'active')

                    <td class="td-status"><span class="label label-success radius">活跃</span></td>

                    <td class="td-manage">
                        <a style="text-decoration:none" onClick="member_stop(this,'{{$v["id"]}}', '{{route('admin.member.statusEdit')}}')" href="javascript:;" title="停用">
                            <i class="Hui-iconfont">&#xe631;</i></a>
                        @else
                        <td class="td-status"><span class="label label-default radius">待用</span></td>

                        <td class="td-manage">
                            <a style="text-decoration:none" onClick="member_start(this,'{{$v["id"]}}', '{{route('admin.member.statusEdit')}}')" href="javascript:;" title="启用">
                                <i class="Hui-iconfont">&#xe631;</i></a>
                        @endif

                        {{--<a title="编辑" href="javascript:;" onclick="member_edit('编辑','member-add.html','4','','510')" class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe6df;</i></a>
                            --}}
                        <a style="text-decoration:none" class="ml-5" onClick="change_password('修改密码','{{route("admin.change_password", ['id' => $v['id']])}}','600','270')" href="javascript:;" title="修改密码">
                            <i class="Hui-iconfont">&#xe63f;</i></a>
                        <a title="删除" href="javascript:;" onclick="member_del(this,'/admin/member_logic/{{$v['id']}}')" class="ml-5" style="text-decoration:none">
                            <i class="Hui-iconfont">&#xe6e2;</i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div id="pull_right">
            <div class="pull-right">
                {!! $member->render() !!}
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
