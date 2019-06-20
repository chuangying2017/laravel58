<!doctype html>
<html lang="zh-Hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>微客服</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/amazeui/2.7.2/css/amazeui.min.css">
    <link rel="stylesheet" href="https://cdn.staticfile.org/layer/2.3/skin/layer.css">
    <link rel="stylesheet" href="{{asset('static/chat/css/main.css?v=120208')}}">
    <script src="https://cdn.staticfile.org/vue/2.5.17-beta.0/vue.js"></script>
    <script src="https://cdn.staticfile.org/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/layer/2.3/layer.js"></script>
</head>
<body>
<div id="chat">
    <template>
        <div class="online_window">
            <div class="me_info">
                <div class="me_item">
                    <div class="me_avatar">
                        <img :src="currentUser.avatar" alt="">
                    </div>
                    <div class="me_status">
                        <div class="me_username">
                            <i class="am-icon am-icon-pencil" @click="changeName"></i>
                            昵称:&nbsp;
                            @{{ currentUser.name }}
                        </div>
                        <div class="me_income">@{{currentUser.intro}}</div>
                    </div>
                    <div class="times-icon"><i class="am-icon am-icon-times"></i></div>
                </div>
            </div>
            <div class="online_list">
                <div class="online_list_header">车上乘客</div>
                <div class="online_item" v-on:click="freed(user.number)" v-for="user in roomUser">
                    <template v-if="user">
                        <div class="online_avatar">
                            <i v-bind:id="user.number" ></i>
                            <img :src="user.avatar" alt="">
                        </div>
                        <div class="online_status">
                            <div class="online_username">@{{user.number}}</div>
                        </div>
                        <div class="close-window" v-on:click="removeSession(user.number)">x</div>
                    </template>
                </div>
            </div>
            <div class="online_count">
                <h6>车上乘客 <span>@{{currentCount}}</span> 位</h6>
            </div>
        </div>
        <div class="talk_window">
            <div class="windows_top">
                <div class="windows_top_left"><i class="am-icon am-icon-list online-list"></i> <div class="user-nickname"></div></div>
                <div class="windows_top_right">
                    <a href="javascript:;" @click="changeLogout"
                       style="color: #999">退出</a>
                </div>
            </div>
            <div class="windows_body" id="chat-window" v-scroll-bottom>
                <ul class="am-comments-list am-comments-list-flip">
                    <template v-for="chat in roomChat">
                        <template v-if="chat.type === 'tips'">
                            <div class="chat-tips">
                                <span class="am-badge am-badge-primary am-radius">@{{chat.content}}</span></div>
                        </template>
                        <template v-else>
                            <div v-if="chat.sendTime" class="chat-tips">
                                <span class="am-radius" style="color: #666666">@{{chat.sendTime}}</span>
                            </div>
                            <article class="am-comment" :class="{ 'am-comment-flip' : chat.number == currentUser.number }">
                                <a href="#link-to-user-home">
                                    <img :src="chat.avatar" alt="" class="am-comment-avatar"
                                         width="48" height="48"/>
                                </a>
                                <div class="am-comment-main">
                                    <header class="am-comment-hd">
                                        <div class="am-comment-meta" v-if="chat.name">
                                            <a href="#link-to-user" class="am-comment-author">@{{chat.name}}</a>
                                        </div>
                                        <div class="am-comment-meta" v-else>
                                            <a href="#link-to-user" class="am-comment-author">@{{chat.number}}</a>
                                        </div>
                                    </header>
                                    <div class="am-comment-bd">
                                        <div class="bd-content">
                                            <template v-if="chat.type === 'text'">
                                                @{{chat.content}}
                                            </template>
                                            <template v-else-if="chat.type === 'image'">
                                                <img :src="chat.content" width="100%">
                                            </template>
                                            <template v-else>
                                                @{{chat.content}}
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </template>
                    </template>
                </ul>
            </div>
            <div class="windows_input">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <button type="button" class="am-btn" @click="picture"><i class="am-icon am-icon-picture-o"></i>
                        </button>
                        <input type="file" id="fileInput" style="display: none" accept="image/*">
                    </div>
                </div>
                <div class="input-box">
                    <label for="text-input" style="display: none"></label>
                    <textarea name="" id="text-input" cols="30" rows="10" title=""></textarea>
                </div>
                <div class="toolbar">
                    <div class="left">
                    </div>
                    <div class="right">
                        <button class="send" @click="clearContent">清空内容</button>
                        <button class="send sendBtn" @click="clickBtnSend">发送消息</button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
<script>
    var nickname;

        @if (!$user->name)
            nickname = '{{$user->number}}';
        @else
            nickname = '{{$user->name}}';
        @endif

    var Vm = new Vue({
        el        : '#chat',
        data      : {
            websocketServer  : "{{$server}}",
            websocketInstance: undefined,
            Reconnect        : false,
            ReconnectTimer   : null,
            HeartBeatTimer   : null,
            ReconnectBox     : null,
            currentUser      : {number: '{{$user->number}}', intro: '-----------', fd: 0, avatar: 0,name:nickname},
            roomUser         : {},
            roomChat         : [],
            up_recv_time     : 0,
            userData: {}, //存储所有的用户数据
            AllFd: {},
            chatCurrent_number : 0,  //当前聊天对象
            customer_id : "{{$user->id}}",
            daemon_url: "{{get_host()}}",
        },
        created   : function () {
            this.connect();
        },
        mounted   : function () {
            var othis = this;
            var textInput = $('#text-input');
            textInput.on('keydown', function (ev) {
                if (ev.keyCode == 13 && ev.shiftKey) {
                    textInput.val(textInput.val() + "\n");
                    return false;
                } else if (ev.keyCode == 13) {
                    othis.clickBtnSend();
                    ev.preventDefault();
                    return false;
                }
            });
            $('.online-list').on('click', function () {
                $('.online_window').show();
                $('.windows_input').hide();
            });
            $('.times-icon').on('click', function () {
                $('.online_window').hide();
                $('.windows_input').show();
            });
            var input = document.getElementById("fileInput");
            input.addEventListener('change', readFile, false);

            function readFile() {
                var file = this.files[0];
                //判断是否是图片类型
                if (!/image\/\w+/.test(file.type)) {
                    alert("只能选择图片");
                    return false;
                }
                if (file.size > 8388608) {
                    alert('图片大小不能超过8MB');
                    return false;
                }
                var formData = new FormData();
                formData.append('image', file);

                // 设置ajax的参数
                var options = {
                    url: '{{route('chat.file_upload')}}',
                    data: formData,
                    type: 'post',
                    dataType:'json',
                    processData: false,
                    contentType: false,
                    success: function(data)
                    {
                        if (data.status == 1)
                        {
                            var reader = new FileReader();
                            reader.readAsDataURL(file);
                            reader.onload = function (e) {
                                othis.broadcastImageMessage(data.path,othis.customer_id,othis.customer_number,othis.currentUser.number)
                            }
                        }
                    },error:function(err,type){
                        console.log(err,type)
                    }
                };
                $.ajax(options);
            }
        },
        methods   : {
            connect              : function () {
                var othis = this;
                //设置本地客户端的昵称
         //     var number = localStorage.getItem('number');
                var websocketServer = this.websocketServer;
            /*    if (number) {
                    websocketServer += '?number=' + encodeURIComponent(number)
                }*/
                this.websocketInstance = new WebSocket(websocketServer);
                this.websocketInstance.onopen = function (ev) {
                    // 断线重连处理
                    if (othis.ReconnectBox) {
                        layer.close(othis.ReconnectBox);
                        othis.ReconnectBox = null;
                        clearInterval(othis.ReconnectTimer);
                    }
                    // 前端循环心跳 (1min)
                    othis.HeartBeatTimer = setInterval(function () {
                        othis.websocketInstance.send('PING');
                    }, 1000 * 30);
                    // 请求获取自己的用户信息和在线列表
                    var cus = {};
                    cus.customer_id = othis.customer_id;
                    cus.number = othis.currentUser.number;
                    othis.release('index', 'info',cus); //插入在线列表
                   // othis.release('index', 'online');
                    othis.websocketInstance.onmessage = function (ev) {
                        try {
                            var data = JSON.parse(ev.data);
                            console.log(data)
                            if (data.sendTime) {
                                if (othis.up_recv_time + 10 * 1000 > (new Date(data.sendTime)).getTime()) {
                                    othis.up_recv_time = (new Date(data.sendTime)).getTime();
                                    data.sendTime = null;
                                } else {
                                    othis.up_recv_time = (new Date(data.sendTime)).getTime();
                                }
                            }
                            switch (data.action) {
                                case 101: {
                                    // 收到管理员消息
                                    othis.roomChat.push({
                                        type    : data.type ? data.type : 'text',
                                        fd      : 0,
                                        content : data.content,
                                        avatar  : 'https://www.gravatar.com/avatar/3ee60266a353746d6aab772fb9e2d398?s=200&d=identicon',
                                        number: data.number
                                    });
                                    break;
                                }
                                case 103 : {
                                    // 收到用户消息
                                    var broadcastMsg;

                                    broadcastMsg = {
                                        type    : data.type,
                                        fd      : data.fromUserFd,
                                        content : data.content,
                                        avatar  : data.avatar,
                                        number: data.number,
                                        sendTime: data.sendTime,
                                        name:data.name
                                    };

                                    if (data.type == 'image')
                                    {
                                        broadcastMsg.content = othis.daemon_url + data.content;
                                    }

                                    if (typeof(othis.roomUser['user'+ data.number]) == "undefined")
                                    {
                                        if (data.number != othis.currentUser.number)
                                        {
                                            othis.$set(othis.roomUser,'user'+ data.number,{avatar:data.avatar, number:data.number,fd:data.fromUserFd});
                                        }
                                    }

                                    if (typeof(othis.userData[data.masterId]) == "undefined")
                                    {
                                        othis.userData[data.masterId] = [];
                                    }

                                    othis.userData[data.masterId].push(broadcastMsg);

                                    othis.AllFd['user' + data.number] = data.fromUserFd;
                                    //当发送的用户 等于 当前聊天窗口的用户 马上推送到当前聊天窗口
                                    var arr = [othis.chatCurrent_number,othis.currentUser.number];
                                    if (arr.includes(data.number))
                                    {
                                        othis.roomChat.push(broadcastMsg);
                                    }else{
                                        var unread = $('#'+data.number);
                                        unread.removeClass('news_note');
                                        unread.addClass('news_note');
                                        if (unread.text() == '99+' || unread.text() > 99)
                                        {
                                            unread.text('99+')
                                        }else{
                                            if (!unread.text())
                                            {
                                                unread.text(1);
                                            }else{
                                                unread.text(parseInt(unread.text()) + 1);
                                            }

                                        }
                                    }

                                    break;
                                }
                                case 104 : {
                                    // 收到最后消息
                                    var lastMsg = {
                                        type    : data.type,
                                        fd      : data.fromUserFd,
                                        content : data.content,
                                        avatar  : data.avatar,
                                        number: data.number,
                                        sendTime: data.sendTime
                                    };
                                    othis.roomChat.push(lastMsg);
                                    break;
                                }
                                case 201: {
                                    // 刷新自己的用户信息
                                    othis.currentUser.intro = data.intro;
                                    othis.currentUser.avatar = data.avatar;
                                    othis.currentUser.fd = data.userFd;
                                    othis.currentUser.number = data.number;
                                    break;
                                }
                                case 202: {
                                    // 刷新当前的在线列表
                                    othis.roomUser = data.list;
                                    break;
                                }
                                case 203: {
                                    // 将新用户插入会话 列表 用户上线
                                    othis.$set(othis.roomUser, 'user' + data.info.number, data.info);

                                    break;
                                }
                                case 204: {
                                    // 用户已离线
                                    var number = othis.roomUser['user' + data.number].number;
                                    othis.$delete(othis.roomUser, 'user' + data.number);
                                    othis.roomChat.push({
                                        type   : 'tips',
                                        content: ' ' + number + ' 离开了',
                                    });
                                    break;
                                }
                                case 205:{
                                    othis.currentUser.name = data.info.name;

                                    $.ajax({
                                        url:'{{route('chat.customer_update')}}',
                                        data:{id:'{{$user['id']}}',name:data.info.name},
                                        dataType:'json',
                                        type: 'POST',
                                        success: function (data) {
                                            console.log(data)
                                        },error:function (res,type) {
                                            console.log(res,type)
                                        }
                                    });
                                }
                                case 206:{
                                    /**  删除客服端的客服 聊天会话 窗口 */
                                    othis.$delete(othis.roomUser, 'user' + data.ClientNumber);
                                }
                            }
                        } catch (e) {
                            console.warn(e);
                        }
                    };
                    othis.websocketInstance.onclose = function (ev) {
                        othis.doReconnect();
                    };
                    othis.websocketInstance.onerror = function (ev) {
                        othis.doReconnect();
                    }
                }
            },
            doReconnect          : function () {
                var othis = this;
                clearInterval(othis.HeartBeatTimer);
                othis.ReconnectBox = layer.msg('已断开，正在重连...', {
                    scrollbar : false,
                    shade     : 0.3,
                    shadeClose: false,
                    time      : 0,
                    offset    : 't'
                });
                othis.ReconnectTimer = setInterval(function () {
                    othis.connect();
                }, 1000)
            },
            /**
             * 向服务器发送消息
             * @param controller 请求控制器
             * @param action 请求操作方法
             * @param params 携带参数
             */
            release              : function (controller, action, params) {
                controller = controller || 'index';
                action = action || 'action';
                params = params || {};
                var message = {controller: controller, action: action, params: params}
                this.websocketInstance.send(JSON.stringify(message))
            },
            /**
             * 发送文本消息
             * @param content
             * @param fd 客服id
             * @param number 客户号
             * @param name 客服名称
             */
            broadcastTextMessage : function (content,fd,number,name) {
                console.log('send text', fd , number,name)
                this.release('Customer', 'sendPersonal',
                    {content: content, type: 'text',toUserFd:fd,number:number,masterId:number,mode:'customer',name:name}
                    )
            },
            /**
             * 发送图片消息
             * @param base64_content
             * @param fd 客服id
             * @param number 客户号
             * @param name 客服名称
             */
            broadcastImageMessage: function (base64_content,fd,number,name) {
                console.log('send image', fd , number,name)
                this.release('Customer', 'sendPersonal',
                    {content: base64_content, type: 'image',toUserFd:fd,number:number,masterId:number,mode:'customer',name:name}
                    )
            },
            picture              : function () {
                var input = document.getElementById("fileInput");
                input.click();
            },
            /**
             * 点击发送按钮
             * @return void
             */
            clickBtnSend         : function () {
                var othis = this;
                var textInput = $('#text-input');
                var content = textInput.val();


                if (othis.chatCurrent_number <= 0)
                {
                    layer.msg('请选择发送的用户');
                    return;
                }

                if (content.trim() !== '') {
                    if (this.websocketInstance && this.websocketInstance.readyState === 1) {
                        this.broadcastTextMessage(content,othis.customer_id,othis.chatCurrent_number,othis.currentUser.name);
                        textInput.val('');
                    } else {
                        layer.tips('连接已断开', '.windows_input', {
                            tips: [1, '#ff4f4f'],
                            time: 2000
                        });
                    }
                } else {
                    layer.tips('请输入消息内容', '.windows_input', {
                        tips: [1, '#3595CC'],
                        time: 2000
                    });
                }
            },
            changeName           : function () {
                var othis = this;

                layer.prompt({title: '更变昵称', formType: 0}, function (name, index) {
                    if (name) {
                        othis.release('index','updateCustomerName',{name:name,number:othis.currentUser.number});
                       /* localStorage.setItem('name', name);
                        window.location.reload();*/
                    }
                    layer.close(index);
                });

            },
            changeLogout : function(){
                $.get('{{route('chat.loginOut')}}', function (data) {
                    if (data.msg == 'success')
                    {
                        window.location.href = data.src
                    }
                });
            },
            freed: function(fe){

                this.session_record(fe);

            },
            clearContent : function () {
                var textInput = $('#text-input');
                textInput.val('');
            },
            removeSession: function(number){
                    let othis = this;
                    console.log(number,othis.currentUser.number);
                    othis.release('Customer','deleteSessionRecord', {customer_number:othis.currentUser.number,client_number:number});
            },
            checkPic: function(obj, fileSize)
            {
                //检查文件类型和大小
                var picExts = 'jpg|jpeg|png|bmp|gif|webp';
                var photoExt = obj.value.substr(obj.value.lastIndexOf(".") + 1).toLowerCase(); //获得文件后缀名
                var pos = picExts.indexOf(photoExt);
                if (pos < 0) {
                    alert("您选中的文件不是图片，请重新选择");
                    return false;
                }
                fileSize = Math.round(fileSize / 1024 * 100) / 100; //单位为KB
                if (fileSize > 30 * 1024) {
                    alert("您选择的图片大小超过限制(最大为30M)，请重新选择");
                    return false;
                }
                return true;
            },
            fileOneChange: function(uploadFile)
            {
                //选择图片触发事件
                if (!window.File || !window.FileList || !window.FileReader) {
                    alert("您的浏览器不支持File Api");
                    return;
                }

                var file = uploadFile.files[0];
                var fileSize = file.size;

                //先检查图片类型和大小
                if (!checkPic(uploadFile, fileSize)) {
                    return;
                }

                //预览图片
                var reader = new FileReader();
                var preDiv = document.getElementById('previewPicDiv');
                reader.onload = (function(file) {
                    return function(e) {
                        preDiv.innerHTML = '';
                        var span = document.createElement('span');
                        span.innerHTML = '<img class="img-responsive" src="' + this.result + '" alt="' + file.name + '" />';
                        //span.innerHTML = '<img class="img-thumbnail" src="' + this.result + '" alt="' + file.name + '" />';
                        preDiv.insertBefore(span, null);
                    };
                })(file);
                //预览图片
                reader.readAsDataURL(file);
            },
            uploadPic: function () {
                var uploadFiles = document.getElementById('upd_pic');
                var file = uploadFiles.files[0];
                var businessType; //业务类型，1-发群图片，2-向好友发图片
                if (selType == webim.SESSION_TYPE.C2C) { //向好友发图片
                    businessType = webim.UPLOAD_PIC_BUSSINESS_TYPE.C2C_MSG;
                } else if (selType == webim.SESSION_TYPE.GROUP) { //发群图片
                    businessType = webim.UPLOAD_PIC_BUSSINESS_TYPE.GROUP_MSG;
                }
                //封装上传图片请求
                var opt = {
                    'file': file, //图片对象
                    'onProgressCallBack': onProgressCallBack, //上传图片进度条回调函数
                    //'abortButton': document.getElementById('upd_abort'), //停止上传图片按钮
                    'To_Account': selToID, //接收者
                    'businessType': businessType //业务类型
                };
       /*         //上传图片
                webim.uploadPic(opt,
                    function(resp) {
                        //上传成功发送图片
                        sendPic(resp, file.name);
                        $('#upload_pic_dialog').modal('hide');
                    },
                    function(err) {
                        alert(err.ErrorInfo);
                    }
                );*/
            },
            session_record: function(client_number){
                let othis = this;
                $.ajax({
                    url:'{{route('chat.sessionRecord')}}',
                    data: {client_number:client_number,customer_id:'{{$user['id']}}'},
                    dataType:'json',
                    type:'POST',
                    success: function(data)
                    {
                        console.log(data);
                        othis.roomChat = [];
                        for (let i =0; i < data.msg.length; i++)
                        {
                            let append_data = {};
                            let arr1 = data.msg[i];
                            if (arr1.mode == 'send')
                            {
                                append_data.number = arr1.client_number;
                                append_data.avatar = 'https://www.gravatar.com/avatar/772270462a6954311c9a96b1f441a6f4?s=120&amp;d=identicon';
                                append_data.name = null;
                            }else{
                                append_data.number = othis.currentUser.number;
                                append_data.name = othis.currentUser.name;
                                append_data.avatar = othis.currentUser.avatar;
                            }

                            append_data.type = arr1.type == 'msg' ? 'text' : 'image';
                            append_data.content = arr1.content;

                            othis.roomChat.push(append_data);

                        }

                        var redPoint = $('#' + client_number);

                        redPoint.text('');

                        redPoint.removeClass('news_note');

                        $('div.windows_top_left').find('div.user-nickname').text(client_number);

                        $('.online_item.background-user').removeClass('background-user');

                        redPoint.parent().parent().addClass('background-user');

                        othis.chatCurrent_number = client_number;

                    },error:function(error,type)
                    {
                        console.log(error,type);
                    }
                })
            }
        },
        computed  : {
            currentCount() {
                return Object.getOwnPropertyNames(this.roomUser).length - 1;
            }
        },
        directives: {
            scrollBottom: {
                componentUpdated: function (el) {
                    el.scrollTop = el.scrollHeight
                }
            }
        }
    });
</script>
</body>
</html>
