<?php
	session_start();
include 'include/config.php';
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>BoLife-留言-登陆</title>
        <!-- Bootstrap 核心 CSS 文件 -->
        <link rel="stylesheet" href="./css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/style.css">
    </head>

    <body >
	<?php if(empty($_POST['action'])){?>
        <div class="container">
            <div class="row row-centered">
                <div class="well col-md-6 col-centered">
                    <h2 class="text-center title">欢迎登录</h2>
                    <form action="<?php $_SERVER['PHP_SELF']?>" method="post" role="form">
                        <div class="input-group input-group-md">
                            <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" id="userid" name="userid" placeholder="请输入用户名"/>
                        </div>
                        <div class="input-group input-group-md">
                            <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="请输入密码"/>
                        </div>
                        <br/>
						<input name="action" type="hidden" value="add">
                        <button type="submit" class="btn btn-primary btn-block">登录</button>
                    </form>
                </div>
            </div>
        </div>
	<?php }else{?>
	<div id="alertmsg">
	<?php
		$admin_user=$_POST['userid'];
		//$admin_pass=md5($_POST['admin_pass']);
		$admin_pass=$_POST['password'];
		$rs=$db->execute("select * from account where username='".$admin_user."'");
			if($db->num_rows($rs)!=0){
				//Check PASSWORD
				///////////////////////////////////////////////////////////
				$row=$db->fetch_array($rs);
				$db->free_result($rs);
				if($row['password']==$admin_pass){
					$_SESSION['user']=$row;
					echo "<meta http-equiv=\"refresh\" content=\"0; url=discuss.php\">";
					
				}else{
					echo "<script language=\"javascript\">alert('密码不正确！');history.go(-1)</script>";
				}
			}else{
				echo "<script language=\"javascript\">alert('帐号不正确！');history.go(-1)</script>";
			}
	?>
	</div>
	<?php }?>

        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="./js/jquery.min.js"></script>

        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="./js/bootstrap.min.js"></script>
    </body>
</html>