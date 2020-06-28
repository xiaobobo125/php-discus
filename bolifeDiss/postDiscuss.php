<?php 
error_reporting(E_ALL ^ E_WARNING);
error_reporting(E_ALL & ~E_NOTICE);
session_start(); 
include 'include/config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>BoLife-留言</title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/semantic-ui/2.2.13/semantic.min.css" />
    <link rel="stylesheet" href="./css/app.css" />
    <link rel="stylesheet" href="./css/discuss/postDiscuss.css" />
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/semantic-ui/2.2.13/semantic.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/wangEditor/3.0.15/wangEditor.min.js"></script>
    <script type="text/javascript" src="./js/app.js"></script>
    <script type="text/javascript" src="./js/discuss/postDiscuss.js"></script>
</head>
<body>
<div class="ui fixed inverted menu">
    <a href="/" class="header item">
        <img class="ui" src="./img/logo.png" width="32" height="32" alt="" />
        BoLife-留言
    </a>
    <a href="./discuss.php" href="#" class=" item">
        <i class="desktop icon"></i>全部留言
    </a>
    <a href="./discussHot.php" class="  item">
        <i class="list layout icon"></i>留言热榜
    </a>
    <a href="./postDiscuss.php" class="active item">
        <i class="talk icon"></i>发布留言
    </a>
	<?php 
		if(empty($_SESSION['user'])){
			header("location:index.php");
		}
	?>
    <div class="ui simple dropdown right item">
        <img class="ui avatar image" src="./img/<?php echo $_SESSION['user']['avatar_img_url'];?>" />
        <span><?php echo $_SESSION['user']['name'];?></span> <i class="dropdown icon"></i>
        <div class="menu">
            <a class="item" id="logout" href="./include/admin.php?action=logout">
                <i class="sign out icon"></i>退出
            </a>
        </div>
    </div>
</div>
<div class="ui header container">
    <div class="ui large breadcrumb">
        <a class="section" href="/"><i class="home icon"></i>首页</a>
        <i class="right chevron icon divider"></i>
        <p class="section">发布留言</p>
    </div>
</div>

<div class="ui postDiscuss container">
    <div class="ui negative message">
        <!--<i class="close icon"></i>-->
        <div class="header"><i class="warning icon"></i>注意</div>
        <p>请注意帖子的言语措辞,如果出现恶意中伤别人,诽谤他人,帖子将被删除,发帖人将会被惩罚。</p>
    </div>
    <form class="ui form">
        <div class="field">
            <div class="two fields">
                <div class="twelve wide field">
                    <input name="title" id="postTitle" placeholder="标题：一句话说明你遇到的问题或想分享的经验" type="text" />
                </div>
            </div>
        </div>
        <div class="field" id="editor" name="htmlContent">
        </div>
		<input type="hidden" id="author" name="author" value="<?php echo $_SESSION['user']['id'];?>"/>
        <button class="ui button">取消</button>
        <div class="positive ui button" id="postDiscussSubmitButton">发布</div>
    </form>
</div>
<!-- 不可抗力元素 -->
<div class="second-footer">
</div>
<div id="footer">
    <div class="ui container">
        <div class="ui stackable two columns grid">
            <div class="column">
                <div class="ui two columns grid">
                    <div class="column">
                        <h3>项目介绍</h3>
                        BoLife-留言是为了PHP课程设计开发的一个留言系统。
                    </div>
                    <div class="column">
                        <h3>联系我们</h3>
                        如有问题请发邮件到
                        1259892859@qq.com
                    </div>
                </div>
            </div>
            <div class="right aligned column">
                &copy; 2020 WK All Rights Reserved &nbsp;&nbsp;
                <br />
                网站版本：<a href="#">v1.0.0 Beta #20200627</a>&nbsp;&nbsp;
                服务器时间：<span id="current_server_timer"></span>
                <br />
                站长统计 | 今日IP[91] | 今日PV[4511] | 昨日IP[133] | 昨日PV[10109] | 当前在线[1]
            </div>
        </div>
    </div>
</div>
<script inline="javascript">
    $(function(){
        app.init("/postDiscus.html");
        postDiscussPage.init(<?php $_SESSION['user']['id'] ?>);
    });
</script>
</body>
</html>