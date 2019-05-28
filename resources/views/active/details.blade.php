@include('public.header')
    <title>用DTcms</title>
    <link rel="shortcut icon" href="http://www.muzhuangnet.com/favicon.ico">

    <script>
        (function(){
            var bp = document.createElement('script');
            var curProtocol = window.location.protocol.split(':')[0];
            if (curProtocol === 'https') {
                bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
            }
            else {
                bp.src = 'http://push.zhanzhang.baidu.com/push.js';
            }
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(bp, s);
        })();
    </script>

    <link rel="stylesheet" type="text/css" href="{{asset('static/content/css/shang.css')}}">
    <script href="{{asset('static/content/js/comm.js')}}"></script>
    <script type="text/javascript" charset="utf-8" href="{{asset('static/content/js/jquery.cookie.js')}}"></script>
</head>
<body class="user-select single">
@include('public.head')
<section class="container">
    <div class="content-wrap">
        <div class="content">
            <header class="article-header">
                <h1 class="article-title"><a href="http://www.muzhuangnet.com/show/269.html" title="用DTcms做一个独立博客网站（响应式模板）">用DTcms做一个独立博客网站（响应式模板）</a></h1>
                <div class="article-meta"> <span class="item article-meta-time">
          <time class="time" data-toggle="tooltip" data-placement="bottom" title="发表时间：2016-10-14"><i class="glyphicon glyphicon-time"></i> 2016-10-14</time>
          </span> <span class="item article-meta-source" data-toggle="tooltip" data-placement="bottom" title="来源：木庄网络博客"><i class="glyphicon glyphicon-globe"></i> 木庄网络博客</span> <span class="item article-meta-category" data-toggle="tooltip" data-placement="bottom" title="MZBlog开源博客"><i class="glyphicon glyphicon-list"></i> <a href="http://www.muzhuangnet.com/list/mznetblog/" title="MZBlog开源博客">MZBlog开源博客</a></span> <span class="item article-meta-views" data-toggle="tooltip" data-placement="bottom" title="浏览量：10081"><i class="glyphicon glyphicon-eye-open"></i> <script type="text/javascript" href="static/content/js/submit_ajax.js"></script></span> <span class="item article-meta-comment" data-toggle="tooltip" data-placement="bottom" title="评论量"><i class="glyphicon glyphicon-comment"></i> <script type="text/javascript" href="static/content/js/submit_ajax.js"></script></span> </div>
            </header>
            <article class="article-content">
                <p>
                    用<a href="http://www.muzhuangnet.com/list/dtcms/">DTcms</a>做一个独立博客网站，采用DTcms V4.0正式版（MSSQL），模板效果请查看本站。（<a href="http://www.muzhuangnet.com/show/305.html" target="_blank">MZ-NetBlog主题html模板下载</a>）
                </p>
                <p>
                    开发环境：SQL2008R2+VS2010。
                </p>
                <p>
                    <span>DTcms V4.0正式版</span>功能<span style="color:#E53333;">已修复和优化</span>：
                </p>
                <p>
                    1、<a target="_blank" href="http://www.muzhuangnet.com/show/290.html">favicon.ico图标后台上传</a>（<a target="_blank" href="http://www.muzhuangnet.com/show/290.html">查看上传方法</a>）。（解决换图标时要连FTP或者开服务器的麻烦）控制面板→系统管理→系统设置→系统基本信息→Favicon。
                </p>
                <p>
                    2、网站副标题（<a target="_blank" href="http://www.muzhuangnet.com/show/296.html">查看设置方法</a>）。控制面板→系统管理→系统设置→系统基本信息→<a href="http://www.muzhuangnet.com/show/296.html">网站副标题</a>。
                </p>
                <p>
                    3、网站LOGO图标全站统一，包括后台。
                </p>
                <p>
                    4、<a href="http://www.muzhuangnet.com/show/299.html" target="_blank">网站导航</a>取博客内容频道的一级栏目类别，并设置当前栏目导航选中。
                </p>
                <p>
                    5、优化SEO标题输入内容验证方式。（例如可以输入“-”符号）
                </p>
                <p>
                    6、优化列表页url配置，使用调用别名组成页面url，形如http://www.muzhuangnet.com/list/muzhuangnet/。
                </p>
                <p>
                    7、全站暂无图片设置。
                </p>
                <p>
                    8、全站路径优化成绝对路径，主站域名+相对路径，如图片链接为http://www.muzhuangnet.com/upload/2016/10/201610182045049676.jpg。
                </p>
                <p>
                    9、显示状态优化选项：正常、不显示；推荐类型优化选项：不允许评论（默认允许评论）、推荐。
                </p>
                <p>
                    10、首页支持翻页,每页8条，浏览器滚动到页面底部，实现自动无刷新加载下一页内容（自动加载5次之后需点击查看更多）。
                </p>
                <p>
                    11、列表页实现自动无刷新加载下一页内容,页面大小取后台设置的值（自动加载5次之后需点击查看更多）。
                </p>
                <p>
                    12、列表右侧显示最新被评论的文章列表，默认8条，无评论则为0条。
                </p>
                <p>
                    13、若有二级目录，列表页显示二级导航。
                </p>
                <p>
                    14、统计整站日志总数、网站运行时长。
                </p>
                <p>
                    15、添加网站开始运行时间设置，控制面板→系统管理→系统设置→系统基本信息→网站开始时间
                </p>
                <p>
                    16、添加站长QQ设置，控制面板→系统管理→系统设置→系统基本信息→QQ
                </p>
                <p>
                    17、添加文章Tags标签。
                </p>
                <p>
                    18、内容描述编辑器为图片自动加alt值，取值为文章标题。
                </p>
                <p>
                    19、删除文章内容页的SEO选项，SEO标题采用文章标题+站点名称的形式，SEO关键词采用文章Tags，SEO描述调用内容摘要。
                </p>
                <p>
                    20、全站广告管理，首页图片轮播、全站右下。广告数量不限制。全站右下广告可上传图片+URL的形式，也可以添加联盟广告的形式。
                </p>
                <p>
                    21、优化搜索结果，引用盘古分词提高搜索精度。
                </p>
                <p>
                    22、评论添加黑名单域名设置，防止恶意刷评论。
                </p>
                <p>
                    23、后台添加百度主动提交代码。
                </p>
                <p>
                    24、文章保存按钮添加百度主动推送，新增或修改文章保存时，实现百度主动推送。
                </p>
                <p>
                    25、后台隐藏个人博客没用的功能，例如会员、订单等。
                </p>
                <p>
                    26、添加模板路径访问限制，防止模板文件路径被下载。
                </p>
                <p>
                    27、读者墙，按照评论数降序排列。
                </p>
                <p>
                    28、RSS订阅。取博客8条文章。
                </p>
                <p>
                    测试站点：本站。
                </p>
                <p>
                    最近时间较忙，就赶紧先更新一个暂时还比较满意的版本上线，后期整理一些BUG以及需要优化的地方再加以改进，若您有什么意见或者好的功能，欢迎在文章评论处指出，谢谢！<a href="http://www.muzhuangnet.com/show/338.html" target="_blank">网站源码已分享</a>，欢迎大家下载使用交流。
                </p>
                <p>欢迎分享，（木庄网络博客交流QQ群：<a href="https://jq.qq.com/?_wv=1027&amp;k=4205AJJ" target="_blank" rel="nofollow" title="562366239">562366239</a>）</p>
                <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_tieba" data-cmd="tieba" title="分享到百度贴吧"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a></div>

                <script>                  window._bd_share_config = { "common": { "bdSnsKey": {}, "bdText": "", "bdMini": "2", "bdMiniList": false, "bdPic": "", "bdStyle": "1", "bdSize": "32" }, "share": {} }; with (document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];</script>
                <p class="article-copyright hidden-xs">转载请注明出处：<a title="木庄网络博客" href="http://www.muzhuangnet.com/index.html">木庄网络博客</a> » <a href="http://www.muzhuangnet.com/show/269.html" title="用DTcms做一个独立博客网站（响应式模板）">用DTcms做一个独立博客网站（响应式模板）</a></p>
            </article>
            <div class="article-tags">标签：<a href="http://www.muzhuangnet.com/tags/list/2/" rel="tag">DTcms博客</a><a href="http://www.muzhuangnet.com/tags/list/3/" rel="tag">木庄网络博客</a><a href="http://www.muzhuangnet.com/tags/list/4/" rel="tag">独立博客</a><a href="http://www.muzhuangnet.com/tags/list/5/" rel="tag">修复优化</a>
            </div>
            <div class="article-shang">
                <p><a href="javascript:void(0)" rel="nofollow" style="color: #fff" onclick="dashangToggle()"
                      class="dashang" title="打赏，支持一下">打赏</a>
                </p>
            </div>
            <div class="hide_box">
            </div>
            <div class="shang_box">
                <a class="shang_close" href="javascript:void(0)" onclick="dashangToggle()" title="关闭">
                    <img href="static/content/picture/close.jpg" alt="取消" /></a>
                <img class="shang_logo" href="static/content/picture/201610171329086541.png" alt="木庄网络博客" />
                <div class="shang_tit">
                    <p>
                        感谢您的支持，我会继续努力的!</p>
                </div>
                <div class="shang_payimg">
                    <img href="static/content/picture/alipayimg.jpg" alt="扫码支持" title="扫一扫" />
                </div>
                <div class="pay_explain">
                    扫码打赏，您说多少就多少</div>
                <div class="shang_payselect">
                    <div class="pay_item checked" data-id="alipay">
                        <span class="radiobox"></span><span class="pay_logo">
                                            <img href="static/content/picture/alipay.jpg" alt="支付宝" /></span>
                    </div>
                    <div class="pay_item" data-id="weipay">
                        <span class="radiobox"></span><span class="pay_logo">
                                            <img href="static/content/picture/wechat.jpg" alt="微信" /></span>
                    </div>
                </div>
                <div class="shang_info">
                    <p>
                        打开<span id="shang_pay_txt">支付宝</span>扫一扫，即可进行扫码打赏哦
                    </p>
                    <p>
                        分享从这里开始，精彩与您同在
                    </p>
                </div>
            </div>
            <div class="relates">
                <div class="title">
                    <h3>相关推荐</h3>
                </div>
                <ul>

                    <li><a href="http://www.muzhuangnet.com/show/533.html" title="Visual Studio已可为苹果iOS11开发应用">Visual Studio已可为苹果iOS11开发应用</a></li>

                    <li><a href="http://www.muzhuangnet.com/show/566.html" title="notepad++插件找不到compare">notepad++插件找不到compare</a></li>

                    <li><a href="http://www.muzhuangnet.com/show/283.html" title="SEO新人需要掌握哪些基本SEO技巧？">SEO新人需要掌握哪些基本SEO技巧？</a></li>

                    <li><a href="http://www.muzhuangnet.com/show/608.html" title="传腾讯华为即将入场区块链，小米也在路上">传腾讯华为即将入场区块链，小米也在路上</a></li>

                    <li><a href="http://www.muzhuangnet.com/show/465.html" title="Github入门步骤简单教程之连接github">Github入门步骤简单教程之连接github</a></li>

                    <li><a href="http://www.muzhuangnet.com/show/426.html" title="中国人工智能的研究越来越牛了！">中国人工智能的研究越来越牛了！</a></li>

                    <li><a href="http://www.muzhuangnet.com/show/186.html" title="DTcms中的tags字符串转换为数组循环输出">DTcms中的tags字符串转换为数组循环输出</a></li>

                    <li><a href="http://www.muzhuangnet.com/show/515.html" title="携程居然退钱了，还等什么！">携程居然退钱了，还等什么！</a></li>

                </ul>
            </div>
            <div class="title" id="comment">
                <h3>评论</h3>
            </div>
            <div id="respond">
                <link rel="stylesheet" type="text/css" href="static/content/css/validate.css"/>
                <link rel="stylesheet" type="text/css" href="static/content/css/pagination.css" />
                <link rel="stylesheet" type="text/css" href="static/content/css/ui-dialog.css" />
                <script type="text/javascript" charset="utf-8" href="static/content/js/jquery.form.min.js"></script>
                <script type="text/javascript" charset="utf-8" href="static/content/js/dialog-plus-min.js"></script>
                <script type="text/javascript" charset="utf-8" href="static/content/js/validform_v5.3.2_min.js"></script>
                <script type="text/javascript" charset="utf-8" href="static/content/js/jquery.pagination.js"></script>
                <script type="text/javascript">
                    $(function() {
                        pageInitComment();

                        AjaxInitForm('#comment-form', '#comment-submit', 1, "", "",269);

                    });

                    function pageInitComment() {
                        AjaxPageList('#comment_list', '/tools/submit_ajax.ashx?action=comment_list&article_id=269');
                    }
                </script>

                <form id="comment-form" name="comment-form" action="/tools/submit_ajax.ashx?action=comment_add&article_id=269" method="POST">
                    <div class="comment">
                        <input name="author" id="author" class="form-control" size="22" placeholder="您的昵称（必填）" maxlength="15" autocomplete="off" type="text" tabindex="1">
                        <input name="email" id="email" class="form-control" size="22" placeholder="您的邮箱（必填）" maxlength="88" autocomplete="off" type="text" tabindex="2">
                        <input name="url" id="url" class="form-control" size="22" placeholder="您的网址（非必填）" maxlength="58" autocomplete="off" type="text" tabindex="3">
                        <div class="comment-box">
                            <textarea placeholder="您的评论或留言（必填）" name="comment-textarea" id="comment-textarea" cols="100%" rows="3" tabindex="4"></textarea>
                            <div class="comment-ctrl">
                                <div class="comment-prompt" style="display: none;"> <i class="fa fa-spin fa-circle-o-notch"></i> <span class="comment-prompt-text">评论正在提交中...请稍后</span> </div>
                                <div class="comment-success" style="display: none;"> <i class="fa fa-check"></i> <span class="comment-prompt-text">评论提交成功...审核通过后显示</span> </div>
                                <button type="submit" name="comment-submit" id="comment-submit" tabindex="5">评论</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div id="postcomments">
                <ol id="comment_list" class="commentlist">
                </ol>
            </div>
        </div>
    </div>
    <aside class="sidebar">
        <div class="fixed">
            <div class="widget widget-tabs">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#notice" aria-controls="notice" role="tab" data-toggle="tab">统计信息</a></li>
                    <li role="presentation"><a href="#contact" aria-controls="contact" role="tab" data-toggle="tab">联系站长</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane contact active" id="notice">
                        <h2>日志总数:
                            539篇
                        </h2>
                        <h2>网站运行:
                            <span id="sitetime"></span></h2>
                    </div>
                    <div role="tabpanel" class="tab-pane contact" id="contact">
                        <h2>交流QQ群:
                            <a href="http://qm.qq.com/cgi-bin/qm/qr?k=OPioQkvS2NOJQnDRVGxipey82VB55-bM" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="bottom" title="交流QQ群:562366239">562366239</a>
                        </h2>
                        <h2>Email:
                            <a href="mailto:admin@muzhuangnet.com" target="_blank" data-toggle="tooltip" rel="nofollow" data-placement="bottom" title="Email:admin@muzhuangnet.com">admin@muzhuangnet.com</a></h2>
                    </div>
                </div>
            </div>
            <div class="widget widget_search">
                <form class="navbar-form" id="searchform">
                    <div class="input-group">
                        <input type="text" class="form-control" onkeydown="if (event.keyCode == 13) {SiteSearch('http://www.muzhuangnet.com/search.html', '#keywords');return false};"
                               size="35" placeholder="请输入关键字" id="keywords" name="keywords" maxlength="15" autocomplete="off" />
                        <span class="input-group-btn">
        <input type="button" value="搜索" onclick="SiteSearch('http://www.muzhuangnet.com/search.html', '#keywords');"
               class="btn btn-default btn-search" id="searchsubmit" value="Search">
    </span>
                    </div>
                </form>

            </div>
        </div>
        <div class="widget widget_hot">
            <h3>最新评论文章</h3>
            <ul>

                <li><a title="MZ-NetBlog后台设置全站favicon.ico" href="http://www.muzhuangnet.com/show/290.html"><span
                            class="thumbnail">
    <img class="thumb" data-original="static/picture/201610181739277776.jpg"
         src="http://www.muzhuangnet.com/upload/201610/18/201610181739277776.jpg"
         alt="MZ-NetBlog后台设置全站favicon.ico" />
</span><span class="text">MZ-NetBlog后台设置全站favicon.ico</span><span class="muted"><i class="glyphicon glyphicon-time"></i>
    2016-11-01
</span><span class="muted"><i class="glyphicon glyphicon-eye-open"></i>758</span></a></li>

                <li><a title="博客下一版本更新意见征集" href="http://www.muzhuangnet.com/show/662.html"><span
                            class="thumbnail">
    <img class="thumb" data-original="static/picture/201610181739277776.jpg"
         src="http://www.muzhuangnet.com/upload/201610/18/201610181739277776.jpg"
         alt="博客下一版本更新意见征集" />
</span><span class="text">博客下一版本更新意见征集</span><span class="muted"><i class="glyphicon glyphicon-time"></i>
    2018-11-02
</span><span class="muted"><i class="glyphicon glyphicon-eye-open"></i>671</span></a></li>

                <li><a title="“复制粘贴”功能的发明者于美国纽约病逝，享年93岁" href="http://www.muzhuangnet.com/show/663.html"><span
                            class="thumbnail">
    <img class="thumb" data-original="static/picture/201812191726019691.png"
         src="http://www.muzhuangnet.com/upload/201812/19/201812191726019691.png"
         alt="“复制粘贴”功能的发明者于美国纽约病逝，享年93岁" />
</span><span class="text">“复制粘贴”功能的发明者于美国纽约病逝，享年93岁</span><span class="muted"><i class="glyphicon glyphicon-time"></i>
    2018-12-19
</span><span class="muted"><i class="glyphicon glyphicon-eye-open"></i>316</span></a></li>

                <li><a title="URL标准化是什么意思？" href="http://www.muzhuangnet.com/show/356.html"><span
                            class="thumbnail">
    <img class="thumb" data-original="static/picture/201612052109411881.jpg"
         src="http://www.muzhuangnet.com/upload/201612/05/201612052109411881.jpg"
         alt="URL标准化是什么意思？" />
</span><span class="text">URL标准化是什么意思？</span><span class="muted"><i class="glyphicon glyphicon-time"></i>
    2016-12-06
</span><span class="muted"><i class="glyphicon glyphicon-eye-open"></i>186</span></a></li>

                <li><a title="如何替换请求URL中的文字" href="http://www.muzhuangnet.com/show/362.html"><span
                            class="thumbnail">
    <img class="thumb" data-original="static/picture/201612081240450915.jpg"
         src="http://www.muzhuangnet.com/upload/201612/08/201612081240450915.jpg"
         alt="如何替换请求URL中的文字" />
</span><span class="text">如何替换请求URL中的文字</span><span class="muted"><i class="glyphicon glyphicon-time"></i>
    2016-12-09
</span><span class="muted"><i class="glyphicon glyphicon-eye-open"></i>118</span></a></li>

                <li><a title="用DTcms做一个独立博客网站（响应式模板）" href="http://www.muzhuangnet.com/show/269.html"><span
                            class="thumbnail">
    <img class="thumb" data-original="static/picture/201610181739277776.jpg"
         src="http://www.muzhuangnet.com/upload/201610/18/201610181739277776.jpg"
         alt="用DTcms做一个独立博客网站（响应式模板）" />
</span><span class="text">用DTcms做一个独立博客网站（响应式模板）</span><span class="muted"><i class="glyphicon glyphicon-time"></i>
    2016-10-14
</span><span class="muted"><i class="glyphicon glyphicon-eye-open"></i>10081</span></a></li>

                <li><a title="网页漂浮广告JS特效源码分享" href="http://www.muzhuangnet.com/show/343.html"><span
                            class="thumbnail">
    <img class="thumb" data-original="static/picture/201611292111471074.jpg"
         src="http://www.muzhuangnet.com/upload/201611/29/201611292111471074.jpg"
         alt="网页漂浮广告JS特效源码分享" />
</span><span class="text">网页漂浮广告JS特效源码分享</span><span class="muted"><i class="glyphicon glyphicon-time"></i>
    2016-11-29
</span><span class="muted"><i class="glyphicon glyphicon-eye-open"></i>317</span></a></li>

                <li><a title="Window 下Redis的安装步骤" href="http://www.muzhuangnet.com/show/578.html"><span
                            class="thumbnail">
    <img class="thumb" data-original="static/picture/201708031048541173.jpg"
         src="http://www.muzhuangnet.com/upload/201708/03/201708031048541173.jpg"
         alt="Window 下Redis的安装步骤" />
</span><span class="text">Window 下Redis的安装步骤</span><span class="muted"><i class="glyphicon glyphicon-time"></i>
    2017-12-15
</span><span class="muted"><i class="glyphicon glyphicon-eye-open"></i>88</span></a></li>

            </ul>
        </div>

        <div class="widget widget_sentence">

            <a href="https://s.click.taobao.com/b2Su5Zw" target="_blank" rel="nofollow" title="学生9块9特惠云服务器">
                <img style="width: 100%" href="static/content/picture/201710260936114611.jpg" alt="学生9块9特惠云服务器" /></a>

        </div>

    </aside>
</section>
@include('public.footer')
{{--<div id="rightClickMenu">
    <ul class="list-group rightClickMenuList">
        <li class="list-group-item disabled">欢迎访问木庄网络博客</li>
        <li class="list-group-item disabled"><span>可复制：</span>代码框内的文字。</li>
        <li class="list-group-item disabled"><span>方法：</span>Ctrl+C。</li>
    </ul>
</div>--}}
@include('public.commonjs')

<script type="text/javascript">
    $("#author").val($.cookie('nickCookie'));
    $("#email").val($.cookie('emailCookie'));
    $("#url").val($.cookie('urlCookie'));
</script>
<script type="text/javascript">
    function siteTime() {
        window.setTimeout("siteTime()", 1000);
        var seconds = 1000;
        var minutes = seconds * 60;
        var hours = minutes * 60;
        var days = hours * 24;

        var today = new Date();
        var todayYear = today.getFullYear();
        var todayMonth = today.getMonth();
        var todayDate = today.getDate();

        var t1 = Date.UTC(2016,7,8);
        var t2 = Date.UTC(todayYear, todayMonth, todayDate);
        var diff = t2 - t1;

        var diffDays = Math.floor(diff / days);
        document.getElementById("sitetime").innerHTML = diffDays + " 天 ";
    }
    siteTime();
</script>

</body>
</html>
