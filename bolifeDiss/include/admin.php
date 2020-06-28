<?php
	if(!empty($_GET['action'])){
		$pageUrl = "/bolifeDiss/index.php";
		if($_GET['action'] == 'logout'){
			session_unset('user');
			session_destroy();
			echo "<meta http-equiv=\"refresh\" content=\"0; url=".$pageUrl."\">";
		}
	}
?>