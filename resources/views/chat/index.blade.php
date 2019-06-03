<!doctype html>
<html lang="en">

	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>聊天界面</title>
		<link rel="stylesheet" type="text/css" href="{{asset('chat/chat.css')}}" />

		<script src="{{asset('chat/js/jquery.min.js')}}"></script>
		<script src="{{asset('chat/js/flexible.js')}}"></script>
	</head>

	<body>
		<header class="header">
			<a class="back" href="javascript:history.back()"></a>
			<h5 class="tit">追星星的人</h5>
			<div class="right">资料</div>
		</header>
		<div class="message">

			<div class="send">
				<div class="time">05/22 06:30</div>
				<div class="msg">
					<img src="{{asset('chat/images/touxiang.png')}}" alt="" />
					<p><i class="msg_input"></i>你好在不在呀，妹子！</p>
				</div>
			</div>
			<div class="show">
				<div class="time">05/22 06:30</div>
				<div class="msg">
					<img src="{{asset('chat/images/touxiangm.png')}}" alt="" />
					<p><i clas="msg_input"></i>你好你好你好</p>
				</div>
			</div>
		</div>
		<div class="footer">
			<img src="{{asset('chat/images/hua.png')}}" alt="" />
			<img src="{{asset('chat/images/xiaolian.png')}}" alt="" />
			<input type="text"  />
			<p>发送</p>
		</div>
	<script src="{{asset('chat/js/chat.js')}}" type="text/javascript" charset="utf-8"></script>
	</body>

</html>