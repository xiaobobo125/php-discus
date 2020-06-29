<?php
error_reporting(E_ALL ^ E_WARNING);
error_reporting(E_ALL & ~E_NOTICE);
	session_start();
include 'include/config.php';
$id=$_GET['id'];
?>
<!DOCTYPE html>
<html xmlns:th="http://www.thymeleaf.org">
<head>
    <meta charset="utf-8" />
    <title>BoLife-留言</title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/semantic-ui/2.2.13/semantic.min.css" />
    <link rel="stylesheet" href="./css/app.css" />
    <link rel="stylesheet" href="./css/discuss/discussDetail.css" />
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/semantic-ui/2.2.13/semantic.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script type="text/javascript" src="./js/app.js"></script>
    <script type="text/javascript" src="./js/discuss/discussDetail.js"></script>
</head>
<body>
<div class="ui fixed inverted menu">
    <a href="/bolifeDiss/discuss.php" class="header item">
        <img class="ui" src="./img/logo.png" width="32" height="32" alt="" />
        BoLife-留言
    </a>
    <a href="./discuss.php" href="#" class="active item">
        <i class="desktop icon"></i>全部留言
    </a>
    <a href="./discussHot.php" class="  item">
        <i class="list layout icon"></i>留言热榜
    </a>
    <a href="./postDiscuss.php" class=" item">
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
        <p class="section">留言信息</p>
    </div>
</div>
<?php
	$sql="select * from post where id=".$id;
	$rs=$db->execute($sql);
	$row=$db->fetch_array($rs);
	$sql = "select * from account where id=".$row['author_id'];
	$urs=$db->execute($sql);
    $urow=$db->fetch_array($urs);
    
    $sql = "select * from comment where post_id=".$row['id'];
    $comment = $db->execute($sql);
?>
<div class="ui discussList container">
    <div class="ui grid">
        <div class="eleven wide column">
            <h2 class="ui header discuss-title" style="font-size: 16px;">
                <i class="talk outline icon"></i>
                <div class="content"><?php echo $row['title'] ?></div>
            </h2>
            <h2 class="ui header">
                <img class="ui avatar image discuss-author-avatar" style="height: 50px;width:50px;" src="./img/<?php echo $urow['avatar_img_url'] ?>" />
                <div class="content">
                    <a href="#" class="header discuss-author-name">
                        <?php echo $urow['name'] ?>
                    </a>
                    <div class="extra discuss-author-edit-info">
                        <span>编辑于 <?php echo $row['create_time'] ?></span>
                        <span style="margin-left: 28em;">
                                <i class="talk outline icon"></i>
                                <span><?php echo $row['reply_num'] ?></span>
                                |
                                <?php 
                                    $sql="select * from good where post_id=".$id;
                                    $good=$db->execute($sql);
                                    $flag = 1;
                                    while($goodRw=$db->fetch_array($good)){
                                        if($goodRw['account_id'] == $_SESSION['user']['id']){
                                            $flag = 0;
                                        }
                                    }
                                    if($flag == 1 ){
                                ?>
                                    <i class="thumbs outline up icon" id="good" onclick="discussDetailPage.addGood()" ></i>
                                    <span id="goodnum"><?php echo $row['good_num'] ?></span>
                                <?php } else{ ?>
                                        <i class="thumbs outline up icon" id="good" style="color: red;"></i>
                                        <span id="goodnum"><?php echo $row['good_num'] ?></span>
                                <?php } ?>
                                |
                                <i class="unhide icon"></i>
                                <span><?php echo $row['view_num'] ?></span>
                        </span>
                    </div>
                </div>
            </h2>
            <div class="ui piled segment" id="postContent">
               <?php echo $row['html_content'] ?>
            </div>
            <?php 
                if($_SESSION['user']['level'] == 1 || $_SESSION['user']['id'] == $row['author_id']){
            ?>
            <div class="ui vertical right aligned segment">
                <a href="./include/admin.php?action=delete&id=<?php echo $id;?>"><i class="remove circle outline icon"></i>删除</a>
            </div>
            <?php  } ?>
            <div class="ui vertical segment">
                <div class="ui comments">
                    <?php 
                        while($commRow=$db->fetch_array($comment)){
                            $sql = "select * from account where id=".$commRow['user_id'];
                            $commentUser=$db->execute($sql);
                            $commentUserRow=$db->fetch_array($commentUser);
                    ?>
                    <div class="comment">
                        <a class="avatar">
                            <img class="ui avatar image" src="./img/<?php echo $commentUserRow['avatar_img_url'] ?>" />
                        </a>
                        <div class="content">
                            <a class="author"><?php echo $commentUserRow['name'] ?></a>
                            <div class="metadata">
                                <span class="date"><?php echo $commRow['create_time'] ?></span>
                            </div>
                            <div class="text">
                                <p><?php echo $commRow['content'] ?></p>
                            </div>
                            <div class="actions">
                                <a class="reply" onclick="discussDetailPage.showReplyModal(<?php echo $commentUserRow['id']?>,<?php echo $commRow['id']?>)">回复</a>
                            </div>
                        </div>
                        <?php 
                            $sql = "select * from reply where comment_id=".$commRow['id'];
                            $reply = $db->execute($sql);
                            while($replyRow=$db->fetch_array($reply)){
                                $sql = "select * from account where id=".$replyRow['user_id'];
                                $replyUser=$db->execute($sql);
                                $replyUserRow=$db->fetch_array($replyUser);
                                $sql = "select * from account where id=".$replyRow['atuser_id'];
                                $atreplyUser=$db->execute($sql);
                                $atreplyUserRow=$db->fetch_array($atreplyUser);
                        ?>
                        <div class="comments">
                            <div class="comment" each="item2,itemStats2 : ${item.replies">
                                <a class="avatar">
                                    <img class="ui avatar image" src="./img/<?php echo $replyUserRow['avatar_img_url']?>" />
                                </a>
                                <div class="content">
                                    <a class="author"><?php echo $replyUserRow['name']?></a>
                                    <span>回复</span>
                                    <a class="author"><?php echo $atreplyUserRow['name']?></a>
                                    <div class="metadata">
                                        <span class="date" ><?php echo $replyRow['create_time']?></span>
                                    </div>
                                    <div class="text">
                                        <?php echo $replyRow['content']?>
                                    </div>
                                    <div class="actions">
                                        <a class="reply" onclick="discussDetailPage.showReplyModal(<?php echo $replyUserRow['id']?>,<?php echo $replyRow['id']?>)">回复</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <form class="ui reply form">
                        <input type="hidden" name="userId" id="userId" value=" <?php echo $_SESSION['user']['id']?>">
                        <input type="hidden" name="postId" id="postId" value=" <?php echo $id?>">
                        <div class="field">
                            <textarea id="commentContent"></textarea>
                        </div>
                        <div class="ui blue labeled submit icon button" onclick="discussDetailPage.addCommentsAction()"><i class="icon edit"></i>回帖</div>
                    </form>
                </div>
            </div>
        </div>
        <div class="five wide column right">
            <div class="ui segment">
                <div class="ui dividing header">
                    <i class="world icon"></i>个人信息
                </div>
                <div class="ui card">
                <div class="image">
                    <img src="./img/<?php echo $_SESSION['user']['avatar_img_url']; ?>">
                </div>
                <div class="content">
                    <a class="header"><?php echo $_SESSION['user']['name']; ?></a>
                    <div class="meta">
                    <span class="date">QQ:<?php echo $_SESSION['user']['qq']; ?></span><br/>
                    <span class="date">telphone:<?php echo $_SESSION['user']['phone']; ?></span><br/>
                    <span class="date">Email:<?php echo $_SESSION['user']['email']; ?></span>
                    </div>
                    <div class="description">
                    <?php echo $_SESSION['user']['description']; ?>
                    </div>
                </div>
                <div class="extra content">
                    <a>
                    <i class="user icon"></i>
                    <?php echo $_SESSION['user']['email']; ?>
                    </a>
                </div>
                </div>
            </div>
            <div class="ui segment">
                <div class="ui dividing header">
                    <i class="world icon"></i>网站信息
                </div>
                <div class="ui card">
                <div class="image">
                    <img src="./img/bg.jpg ?>">
                </div>
                <?php
                    $sql="select * from post";
                    $total = $db->get_rows($sql);
                    $sql="select * from reply";
                    $reptotal = $db->get_rows($sql);
                    $sql="select * from comment";
                    $comtotal = $db->get_rows($sql);
                    $allcom = $reptotal+$comtotal;
                    $sql="select * from good";
                    $goodtotal = $db->get_rows($sql);
                ?>
                <div class="content">
                    <a class="header">Bo-Life留言板</a>
                    <div class="meta">
                    <span class="date">留言数量:<?php echo $total; ?></span><br/>
                    <span class="date">评论数量:<?php echo $allcom; ?></span><br/>
                    <span class="date">点赞数量:<?php echo $goodtotal; ?></span>
                    </div>
                    <div class="description">
                        打造不一样的留言板！
                    </div>
                </div>
                <div class="extra content">
                    <a>
                    <i class="user icon"></i>
                        管理员邮箱：1259892859@qq.com
                    </a>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 回复模态框 -->
<div class="ui mini modal" id="replyModal">
                            <div class="header">回复</div>
                            <div class="content">
                                <form class="ui form" id="replyModalForm">
                                    <input type="hidden" name="reuserId" id="reuserId" value=" <?php echo $_SESSION['user']['id']?>">
                                    <input type="hidden" id="replyAtuserId" />
                                    <input type="hidden" id="replyCommentId" />
                                    <div class="field required">
                                        <div class="ui input">
                                            <input id="replyContent" type="text" placeholder="" />
                                        </div>
                                    </div>
                                    <div class="ui negative button" id="cancelReplyBtn">取消</div>
                                    <div class="ui positive button" id="confirmReplyBtn">确定</div>
                                </form>
                            </div>
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
        app.init("/discussDetail.html");
        discussDetailPage.init(<?php echo $_SESSION['user']['id'];?>,<?php echo $id;?>);
    });
</script>
</body>
</html>