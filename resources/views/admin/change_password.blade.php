@include('public.header')

@section('content')
    <title>修改密码</title>
    </head>
    <body>
    <article class="page-container">
        <form action="/admin/member_logic/status" method="post" class="form form-horizontal" id="form-change-password">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>新密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="password" class="input-text" autocomplete="off" placeholder="不修改请留空" name="newpassword" id="newpassword">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="password" class="input-text" autocomplete="off" placeholder="不修改请留空" name="newpassword2" id="new-password2">
                </div>
            </div>
            <input type="hidden" value="{{request()->get('id')}}" name="id">
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;保存&nbsp;&nbsp;">
                </div>
            </div>
            <!-- write description -->
        </form>
    </article>
@endsection
    @yield('content', 'Default Content')
@include('public.footer')

@include('public.commonjs')

@section('javascript_logic')
    <script type="text/javascript">
        $(function(){
            $("#form-change-password").validate({
                rules:{
                    newpassword:{
                        required:true,
                        minlength:6,
                        maxlength:16
                    },
                    newpassword2:{
                        required:true,
                        minlength:6,
                        maxlength:16,
                        equalTo: "#newpassword"
                    },
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit();
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.$('.btn-refresh').click();
                    parent.layer.close(index);
                }
            });
        });
    </script>
    <!--/请在上方写此页面业务相关的脚本-->
@endsection
    @yield('javascript_logic', 'Default Content')
</body>
</html>
