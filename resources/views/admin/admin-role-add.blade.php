@include('public.header')

    <title>新建网站角色 - 管理员管理 - H-ui.admin v3.1</title>

</head>
<body>
<article class="page-container">
    <form action="" method="post" class="form form-horizontal" id="form-admin-role-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="roleName" name="roleName">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">备注：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="description" name="description">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">网站角色：</label>
            <div class="formControls col-xs-8 col-sm-9">
                @foreach($arr as $k => $v)

                    @php
                    $a = $v['parent'];

                    $children = $v['children'];
                    @endphp
                <dl class="permission-list">
                    <dt>
                        <label>
                            <input type="checkbox" value="{{$a['id']}}" name="user-Character-{{$a['id']}}" id="user-Character-{{$a['id']}}">
                            {{$a['name']}}</label>
                    </dt>
                    <dd>
                        @foreach ($children as $item)

                                @php
                                $p1 = $item['parent'];

                                 if(isset($item['children']))
                                 {
                                 $c1 = $item['children'];
                                 }else{
                                  $c1 = [];
                                 }
                                @endphp
                            <dl class="cl permission-list2">
                                <dt>
                                    <label class="">
                                        <input type="checkbox" value="{{$p1['id']}}" name="user-Character-0-{{$p1['id']}}" id="user-Character-0-{{$p1['id']}}">
                                        {{$p1['name']}}</label>
                                </dt>
                              @foreach ($c1 as $k1 => $v1)
                                    <dd>
                                        <label class="">
                                            <input type="checkbox" value="{{$v1['id']}}" name="user-Character-0-0-{{$v1['id']}}" id="user-Character-0-0-{{$v1['id']}}">
                                            {{$v1['name']}}
                                        </label>

                                    </dd>
                              @endforeach
                            </dl>

                        @endforeach
                    </dd>
                </dl>

                @endforeach
                {{--<dl class="permission-list">
                    <dt>
                        <label>
                            <input type="checkbox" value="" name="user-Character-0" id="user-Character-1">
                            用户中心</label>
                    </dt>
                    <dd>
                        <dl class="cl permission-list2">
                            <dt>
                                <label class="">
                                    <input type="checkbox" value="" name="user-Character-1-0" id="user-Character-1-0">
                                    用户管理</label>
                            </dt>
                            <dd>
                                <label class="">
                                    <input type="checkbox" value="" name="user-Character-1-0-0" id="user-Character-1-0-0">
                                    添加</label>
                                <label class="">
                                    <input type="checkbox" value="" name="user-Character-1-0-0" id="user-Character-1-0-1">
                                    修改</label>
                                <label class="">
                                    <input type="checkbox" value="" name="user-Character-1-0-0" id="user-Character-1-0-2">
                                    删除</label>
                                <label class="">
                                    <input type="checkbox" value="" name="user-Character-1-0-0" id="user-Character-1-0-3">
                                    查看</label>
                                <label class="">
                                    <input type="checkbox" value="" name="user-Character-1-0-0" id="user-Character-1-0-4">
                                    审核</label>
                            </dd>
                        </dl>
                    </dd>
                </dl>--}}
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <button type="submit" class="btn btn-success radius"><i class="icon-ok"></i> 确定</button>
            </div>
        </div>
    </form>
</article>

@include('public.footer')

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{asset('h-ui/lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{asset('h-ui/lib/jquery.validation/1.14.0/validate-methods.js')}}"></script>
<script type="text/javascript" src="{{asset('h-ui/lib/jquery.validation/1.14.0/messages_zh.js')}}"></script>
<script type="text/javascript">
    $(function(){
        $(".permission-list dt input:checkbox").click(function(){
            $(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
        });
        $(".permission-list2 dd input:checkbox").click(function(){
            var l =$(this).parent().parent().find("input:checked").length;
            var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
            if($(this).prop("checked")){
                $(this).closest("dl").find("dt input:checkbox").prop("checked",true);
                $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
            }
            else{
                if(l==0){
                    $(this).closest("dl").find("dt input:checkbox").prop("checked",false);
                }
                if(l2==0){
                    $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
                }
            }
        });

        $("#form-admin-role-add").validate({
            rules:{
                roleName:{
                    required:true,
                },
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                var url = '{{route('role.add_post')}}';
                $(form).ajaxSubmit({
                    type: 'post',
                    url:url,
                    async:false,
                    success: function(data){
                        if(data.status == 1){
                            layer.msg(data.msg, {icon: 1, time: 1000},function (){
                                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                parent.location.reload();
                                parent.layer.close(index);
                            })
                        }else{
                            layer.msg(data.msg, {icon: 2, time: 1500},function (){
                                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                parent.location.reload();
                                parent.layer.close(index);
                            })
                        }
                    }
                });
       /*         $(form).ajaxSubmit();
                var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);*/
            }
        });
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>
