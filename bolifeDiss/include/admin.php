<?php
	require_once('config.php');
	if(!empty($_GET['action'])){
		$pageUrl = "/bolifeDiss/index.php";
		if($_GET['action'] == 'logout'){
			session_unset('user');
			session_destroy();
			echo "<meta http-equiv=\"refresh\" content=\"0; url=".$pageUrl."\">";
		}
		if($_GET['action'] == 'delete'){
			$pageUrl = "/bolifeDiss/discuss.php";
			$postId = $_GET['id'];
			$sql = "delete from post where id=".$postId;
			$db->delete($sql);
			echo "<meta http-equiv=\"refresh\" content=\"0; url=".$pageUrl."\">";
		}
	}
?>