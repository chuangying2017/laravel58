@include('public.header')
<title>权限管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 权限管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="text-c">
		<form class="Huiform" method="post" action="" target="_self">
			<input type="text" class="input-text" style="width:250px" placeholder="权限名称" id="" name="">
			<button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜权限节点</button>
		</form>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="admin_batch_del('{{route('permission.delete')}}')" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="admin_permission_add('添加权限节点','{{route('permission.add_show')}}','380','340')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加权限节点</a></span> <span class="r">共有数据：<strong>{{$arr->count()}}</strong> 条</span> </div>
	<table class="table table-border table-bordered table-bg">
		<thead>
			<tr>
				<th scope="col" colspan="7">权限节点</th>
			</tr>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="40">ID</th>
				<th width="200">权限名称</th>
				<th>字段名</th>
                <th width="50">父ID</th>
                <th width="100">路径</th>
				<th width="100">操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($arr as $k => $v)
                <tr class="text-c">
                    <td><input type="checkbox" value="{{$v['id']}}" name="box"></td>
                    <td>{{$v['id']}}</td>
                    <td> {{$v['name']}}</td>
                    <td>@empty($v['action'])

                            @if ($v['pid'] <= 0)
                                顶级分类
                                @else
                                子分类
                            @endif

                        @else
                            {{$v['action']}}
                        @endempty
                        </td>
                    <td>{{$v['pid']}}</td>
                    <td>{{$v['path']}}</td>
                    <td><a title="编辑" href="javascript:;" onclick="admin_permission_edit('角色编辑','{{route('permission.edit_show',['id' => $v['id']])}}','','310')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_permission_del(this,'{{$v['id']}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                </tr>
            @endforeach
		</tbody>
	</table>
</div>
@include('public.footer')
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{asset('h-ui/lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">
/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
/*管理员-权限-添加*/
function admin_permission_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-权限-编辑*/
function admin_permission_edit(title,url,w,h){
	layer_show(title,url,w,h);
}

/*管理员-权限-删除*/
function admin_permission_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '{{route('permission.delete')}}',
			dataType: 'json',
            data:{id:id},
			success: function(data){
				$(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}

//节点批量删除
function admin_batch_del(url){
    layer.confirm('确认要删除吗？', function (index) {
        var str = "";
        $('input[name="box"]:checked').each(function () {
            str += $(this).val() + ","
        });

        $.ajax({
            type: "post",
            url: url,
            data: {id: str},
            dataType: 'json',
            async: false, //设置为同步操作就可以给全局变量赋值成功
            success: function (data) {
                if (data.status == 1)
                {
                    layer.msg(data.msg, {icon: 1, time: 2000});
                    location.replace(location.href);
                } else
                {
                    layer.msg(data.msg, {icon: 2, time: 2000});
                }

            }
        });

    });
}
</script>
</body>
</html>
