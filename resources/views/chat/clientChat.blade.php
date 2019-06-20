<!doctype html>
<html lang="zh-Hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>微聊</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/amazeui/2.7.2/css/amazeui.min.css">
    <link rel="stylesheet" href="https://cdn.staticfile.org/layer/2.3/skin/layer.css">
    <link rel="stylesheet" href="{{asset('static/chat/css/client.css?v=1202013')}}">
    <script src="https://cdn.staticfile.org/vue/2.5.17-beta.0/vue.js"></script>
    <script src="https://cdn.staticfile.org/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/layer/2.3/layer.js"></script>
</head>
<body>
<div id="chat">
    <template>
        <div class="talk_window">
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
                            <article class="am-comment" :class="{ 'am-comment-flip' : chat.fd == currentUser.fd }">
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

    var Vm = new Vue({
        el        : '#chat',
        data      : {
            websocketServer  : "{{$server}}",
            websocketInstance: undefined,
            Reconnect        : false,
            ReconnectTimer   : null,
            HeartBeatTimer   : null,
            ReconnectBox     : null,
            currentUser      : {number: '{{$client['number']}}', intro: '{{$client['intro']}}', fd: 0, avatar: '{{$client['avatar']}}'},
            roomUser         : {},
            roomChat         : [],
            up_recv_time     : 0,
            customer_id : 0,
            customer_number: 0,
            daemon_url: "{{get_host()}}"
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

                // 设置axios的参数
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
                var websocketServer = this.websocketServer;
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
                     othis.release('client', 'info', {
                         'client':{'avatar':'{{$client['avatar']}}', 'number': '{{$client['number']}}'},
                         'customer': {
                             'customer_id': '{{$customer['id']}}',
                             'number': '{{$customer['number']}}',
                             'avatar':'{{$customer['avatar']}}',
                             'name': '{{$customer['name']}}'
                         }});
                    othis.websocketInstance.onmessage = function (ev) {
                        try {
                            var data = JSON.parse(ev.data);
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
                                    // 收到 第一次进来的消息
                                    othis.roomChat.push({
                                        type    : data.type ? data.type : 'text',
                                        fd      : 0,
                                        content : data.content,
                                        avatar  : '{{$customer['avatar']}}',
                                        number: data.number,
                                        name:data.name
                                    });
                                    othis.customer_id = data.customer_id; //第一次进来选择客服的Id
                                    othis.customer_number = data.number; //客服编号
                                    break;
                                }
                                case 103 : {
                                    // 收到用户消息
                                    var broadcastMsg = {
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
                                    othis.roomChat.push(broadcastMsg);
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
                                    // 新用户上线
                                    othis.$set(othis.roomUser, 'user' + data.info.fd, data.info);
                                 /*   othis.roomChat.push({
                                        type   : 'tips',
                                        content: '欢迎 ' + data.info.number + ' 加入群聊',
                                    });*/
                                    break;
                                }
                                case 204: {
                                    // 用户已离线
                                    var number = othis.roomUser['user' + data.userFd].number;
                                    othis.$delete(othis.roomUser, 'user' + data.userFd);
                                    othis.roomChat.push({
                                        type   : 'tips',
                                        content: ' ' + number + ' 离开了群聊',
                                    });
                                    break;
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
             * @param content 发送主题
             * @param fd 要发送的用户
             * @param number 客服编号
             * @param masterId 聊天组的id
             */
            broadcastTextMessage : function (content,fd,number,masterId) {

                this.release('Customer', 'sendPersonal', {content: content, type: 'text',toUserFd: fd,number:number,masterId:masterId})
            },
            /**
             * 发送图片消息
             * @param base64_content
             * @param fd 要发送的用户
             * @param number 客服编号
             * @param masterId 聊天组的id
             */
            broadcastImageMessage: function (base64_content,fd,number,masterId) {

                this.release('Customer', 'sendPersonal', {content: base64_content, type: 'image',toUserFd:fd,number:number,masterId:masterId})
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
                var textInput = $('#text-input');
                var content = textInput.val();
                if (content.trim() !== '') {
                    if (this.websocketInstance && this.websocketInstance.readyState === 1) {
                        this.broadcastTextMessage(content,this.customer_id,this.customer_number,this.currentUser.number);
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
                layer.prompt({title: '拒绝吃瓜，秀出你的昵称', formType: 0}, function (number, index) {
                    if (number) {
                        localStorage.setItem('number', number);
                        window.location.reload();
                    }
                    layer.close(index);
                });

            },
            changeLogout : function(){
                $.get('{{route('chat.loginOut')}}', function (data) {
                    if (data.msg == 'success')
                    {
                        window.location.href = data.result.src
                    }
                });
            },
            clearContent : function () {
                var textInput = $('#text-input');
                textInput.val('');
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
