<?php
	require_once('config.php');
	$userId = $_POST['userId'];
	$postId = $_POST['postId'];
	$content = $_POST['content'];
	$atuserId = $_POST['atuserId'];
	$commentId = $_POST['commentId'];
	$sql = "insert into reply (user_id,atuser_id,post_id,comment_id,content,create_time)values(".$userId.",".$atuserId.",".$postId.",".$commentId.",'".$content."',now())";
	$rs=$db->insert($sql);
	
	$sql = "select * from post where id=".$postId;
	$post = $db->execute($sql);
	$postRow = $db->fetch_array($post);
	$commentCount = $postRow['reply_num'];
	$commentCount=$commentCount+1;
	$commHot = hotCal($commentCount);
	$viewHot = hotCal($postRow['view_num']);
	$goodHot = hotCal($postRow['good_num']);
	$hot = $commHot+$viewHot+$goodHot;
	$sql="update post set reply_num = ".$commentCount.",last_reply_time=now(),hot=".$hot." where id=".$postId;
	$res = $db->update($sql);
	
	$arr = array();
	$arr["success"] = $rs;
	echo json_encode($arr);
	
	function hotCal($commentCount){
		$hot = 0;
		if($commentCount > 100){
			$hot = 33;
		}else{
			$num = (int)($commentCount * $commentCount/100);
			$hot = $num;
		}
		return $hot;
	}
?>