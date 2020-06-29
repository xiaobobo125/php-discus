<?php
	require_once('config.php');
	$userId = $_POST['accountId'];
	$postId = $_POST['postId'];
	$sql = "select * from post where id=".$postId;
	$post = $db->execute($sql);
	$postRow = $db->fetch_array($post);
	$good_num = $postRow['good_num'];
	$good_num=$good_num+1;
	$commHot = hotCal($good_num);
	$viewHot = hotCal($postRow['view_num']);
	$goodHot = hotCal($postRow['reply_num']);
	$hot = $commHot+$viewHot+$goodHot;
	$sql="update post set good_num = ".$good_num.",hot=".$hot." where id=".$postId;
	$res = $db->update($sql);
	$sql = "insert into good(post_id,account_id)values(".$postId.",".$userId.")";
	$rs = $db->insert($sql);
	$arr = array();
	$arr["success"] = $rs;
	$arr['num'] = $good_num;
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