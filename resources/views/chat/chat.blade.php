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
    <link rel="stylesheet" href="/static/chat/css/main.css?v=120203">
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
                            {{--<i class="am-icon am-icon-pencil" @click="changeName"></i> --}}
                            编号:&nbsp;
                            {{$user->number}}
                        </div>
                        <div class="me_income">@{{currentUser.intro}}</div>
                    </div>
                    <div class="times-icon"><i class="am-icon am-icon-times"></i></div>
                </div>
            </div>
            <div class="online_list">
                <div class="online_list_header">车上乘客</div>
                <div class="online_item" v-for="user in roomUser">
                    <template v-if="user">
                        <div class="online_avatar">
                            <img :src="user.avatar" alt="">
                        </div>
                        <div class="online_status">
                            <div class="online_username">@{{user.username}}</div>
                        </div>
                    </template>
                </div>
            </div>
            <div class="online_count">
                <h6>车上乘客 <span>@{{currentCount}}</span> 位</h6>
            </div>
        </div>
        <div class="talk_window">
            <div class="windows_top">
                <div class="windows_top_left"><i class="am-icon am-icon-list online-list"></i> 微客服</div>
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
                            <article class="am-comment" :class="{ 'am-comment-flip' : chat.fd == currentUser.userFd }">
                                <a href="#link-to-user-home">
                                    <img :src="chat.avatar" alt="" class="am-comment-avatar"
                                         width="48" height="48"/>
                                </a>
                                <div class="am-comment-main">
                                    <header class="am-comment-hd">
                                        <div class="am-comment-meta">
                                            <a href="#link-to-user" class="am-comment-author">@{{chat.username}}</a>
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
                    <div class="left">{{--<a href="http://www.easyswoole.com/" target="_blank">POWER BY EASYSWOOLE V3</a>--}}
                    </div>
                    <div class="right">
                        <button class="send" @click="clickBtnSend">发送消息</button>
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
            currentUser      : {username: '-----', intro: '-----------', fd: 0, avatar: 0},
            roomUser         : {},
            roomChat         : [],
            up_recv_time     : 0,
            AllFd: {},
            customer_number : "{{$user->number}}",  //客户编号 or 客服编号
            customer_id : "{{$user->id}}"
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
                if (file.size > 1048576) {
                    alert('图片大小不能超过1MB');
                    return false;
                }
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function (e) {
                    othis.broadcastImageMessage(this.result,othis.customer_id,othis.customer_number)
                }
            }
        },
        methods   : {
            connect              : function () {
                var othis = this;
                //设置本地客户端的昵称
                var username = localStorage.getItem('username');
                var websocketServer = this.websocketServer;
                if (username) {
                    websocketServer += '?username=' + encodeURIComponent(username)
                }
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
                    cus.username = othis.customer_number;
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
                                        username: data.username
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
                                        username: data.username,
                                        sendTime: data.sendTime
                                    };

                                    othis.AllFd['user' + data.fromUserFd] = data.fromUserFd;
                                    if (data.username != othis.currentUser.username)
                                    {
                                        othis.customer_number = data.username;
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
                                        username: data.username,
                                        sendTime: data.sendTime
                                    };
                                    othis.roomChat.push(lastMsg);
                                    break;
                                }
                                case 201: {
                                    // 刷新自己的用户信息
                                    othis.currentUser.intro = data.intro;
                                    othis.currentUser.avatar = data.avatar;
                                    othis.currentUser.fd = data.fd;
                                    othis.currentUser.username = data.username;
                                    break;
                                }
                                case 202: {
                                    // 刷新当前的在线列表
                                    othis.roomUser = data.list;
                                    break;
                                }
                                case 203: {
                                    // 将新用户插入会话 列表
                                    othis.$set(othis.roomUser, 'user' + data.info.fd, data.info);
                                   /* othis.roomChat.push({
                                        type   : 'tips',
                                        content: '欢迎 ' + data.info.username + ' 加入群聊',
                                    });*/
                                    break;
                                }
                                case 204: {
                                    // 用户已离线
                                    var username = othis.roomUser['user' + data.userFd].username;
                                    othis.$delete(othis.roomUser, 'user' + data.userFd);
                                    othis.roomChat.push({
                                        type   : 'tips',
                                        content: ' ' + username + ' 离开了',
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
             * @param content
             * @param fd 客服id
             * @param username 客户号
             */
            broadcastTextMessage : function (content,fd,username) {
                console.log('send text', fd , username)
                this.release('Customer', 'sendPersonal', {content: content, type: 'text',toUserFd:fd,username:username})
            },
            /**
             * 发送图片消息
             * @param base64_content
             * @param fd 客服id
             * @param username 客户号
             */
            broadcastImageMessage: function (base64_content,fd,username) {
                console.log('send image', fd , username)
                this.release('Customer', 'sendPersonal', {content: base64_content, type: 'image',toUserFd:fd,username:username})
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
                        this.broadcastTextMessage(content,this.customer_id,this.customer_number);
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
                layer.prompt({title: '拒绝吃瓜，秀出你的昵称', formType: 0}, function (username, index) {
                    if (username) {
                        localStorage.setItem('username', username);
                        window.location.reload();
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