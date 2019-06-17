<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link href="{{asset('h-ui/static/h-ui/css/H-ui.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('h-ui/static/h-ui.admin/css/H-ui.login.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('h-ui/static/h-ui.admin/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('h-ui/lib/Hui-iconfont/1.0.8/iconfont.css')}}" rel="stylesheet" type="text/css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="{{asset('h-ui/lib/DD_belatedPNG_0.0.8a-min.js')}}" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>后台登录</title>
</head>
<body>

<div class="header"></div>
<div class="loginWraper">
    <div id="loginform" class="loginBox">
        <form class="form form-horizontal" id="form-change-login">
            @csrf
            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                <div class="formControls col-xs-8">
                    <input id="" name="name" type="text" placeholder="账户" class="input-text size-L">
                    <br/>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
                <div class="formControls col-xs-8">
                    <input id="" name="password" type="password" placeholder="密码" class="input-text size-L">

                </div>
            </div>
          {{--  <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <input class="input-text size-L" type="text" placeholder="验证码" onblur="if(this.value==''){this.value='验证码:'}" onclick="if(this.value=='验证码:'){this.value='';}" value="验证码:" style="width:150px;">
                    <img src=""> <a id="kanbuq" href="javascript:;">看不清，换一张</a> </div>
            </div>--}}
         {{--   <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <label for="online">
                        <input type="checkbox" name="online" id="online" value="">
                        使我保持登录状态</label>
                </div>
            </div>--}}
            <div class="row cl">
                <div class="formControls col-xs-7 col-xs-offset-3">
                    <input name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">

                    <input name="" type="reset" class="btn btn-default radius size-L qingkong" value="&nbsp;清&nbsp;&nbsp;&nbsp;&nbsp;空&nbsp;">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="footer">Copyright by admin</div>
</body>
</html>
@include('public.footer')
@include('public.commonjs')
<script type="application/javascript">
    $(function(){
        $("#form-change-login").validate({
            rules:{
                name:{
                    required:true,
                    minlength:6,
                    maxlength:160
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 30
                }
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                var url = '{{route('login')}}';
                $(form).ajaxSubmit({
                    type: 'post',
                    url:url,
                    async:false,
                    success: function(data){
                        console.log(data);
                        if(data.status == 1){
                            layer.msg(data.msg, {icon: 1, time: 1000},function (){
                                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                parent.layer.close(index);
                                window.location.href = data.url;
                            })
                        }else{
                            layer.msg(data.msg, {icon: 2, time: 1500},function (){
                                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                parent.layer.close(index);
                            })
                        }
                    }
                });
            }
        });
    });
</script>
