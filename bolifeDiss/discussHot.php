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
    <link rel="stylesheet" href="./css/discuss/discuss.css" />
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/semantic-ui/2.2.13/semantic.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script type="text/javascript" src="./js/app.js"></script>
    <script type="text/javascript" src="./js/discuss/discuss.js"></script>
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
    <a href="./discussHot.php" class=" active item">
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
        <div class="active section">留言热榜</div>
    </div>
</div>

<div class="ui discussList container">
    <div class="ui grid">
        <div class="eleven wide column">
            <table class="ui red table">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th>标题</th>
                        <th>热度</th>
                    </tr>
                </thead>
                <tbody>
				<?php
					$sql="select * from post order by hot desc limit 0,50";
					$rs=$db->execute($sql);
					$rows=$db->fetch_array($rs);
					$i = 0;
					while($rows=$db->fetch_array($rs)){
						$i++;
				?>
                    <tr>
                        <td>
						<div class='ui ribbon label 
						<?php 
							if($i == 1) {
								echo" red'>第一</div>";
							}else if($i == 2){
								echo" orange'>第二</div>";
							}else if($i == 3){
								echo" yellow'>第三</div>";
							}else{
								echo"'>".$i."</div>";
							}
						?>
                        </td>
                        <td ><a href="./discussDetail.php?id=<?php echo $rows['id'];?>"><?php echo $rows['title']?></a></td>
                        <td><?php echo $rows['hot']?>℃</td>
                    </tr>
					<?php
					}
					$db->free_result($rs);
					?>
                </tbody>
            </table>
        </div>
        <div class="five wide column">
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
        </div>
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
        app.init(contextPath);
        discussPage.init(pageNum, pageSize, totalPageNum, totalPageSize, posts);
    });
</script>
</body>
</html>