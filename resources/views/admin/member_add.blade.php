@include('public.header')
<!--/meta 作为公共模版分离出去-->

<title>添加用户</title>
<meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
<meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
<article class="page-container">
	<form class="form form-horizontal" id="form-member-add">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>账号：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="输入账号" id="username" name="username">
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>密码：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="password" class="input-text" value="" placeholder="输入密码" id="password" name="password">
			</div>
		</div>

		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
	</form>
</article>

@include('public.footer')

<!--请在下方写此页面业务相关的脚本--> 
@include('public.commonjs')
<script type="text/javascript">
$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	
	$("#form-member-add").validate({
		rules:{
			username:{
				required:true,
				minlength:6,
				maxlength:16
			},
            password: {
			    required:true,
                minlength:6,
                maxlength:16
            }
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
            var url = '/admin/member_logic';
            $(form).ajaxSubmit({
                type: 'post',
                url:url,
                async:false,
                success: function(data){
                    if(data.status == 1){
                        layer.msg(data.msg, {icon: 1, time: 2000},function (){
                            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                            parent.location.reload();
                            parent.layer.close(index);
                        })
                    }else{
                        layer.msg(data.msg, {icon: 2, time: 2000},function (){
                            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                            parent.location.reload();
                            parent.layer.close(index);
                        })
                    }
                }
            });
		}
	});
});
</script> 
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>