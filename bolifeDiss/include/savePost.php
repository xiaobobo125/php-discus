<?php
	require_once('config.php');
	$title = $_POST['title'];
	$htmlContent = $_POST['htmlContent'];
	$textContent = $_POST['textContent'];
	$authorId = $_POST['authorId'];
	$sql = "insert into post (author_id,html_content,text_content,create_time,update_time,last_reply_time,title)values(".$authorId.",'".$htmlContent."','".$textContent."',now(),now(),now(),'".$title."')";
	$rs=$db->insert($sql);
	$arr = array();
	$arr["success"] = $rs;
	echo json_encode($arr);
?>