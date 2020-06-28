<?php

require_once('sql_class.php');
$db=new db_Mysql(); 
$db->dbServer  = 'localhost';
$db->dbbase   = 'discus';
$db->dbUser  = 'root';
$db->dbPwd  = '1259892859..';
$db->dbconnect(); 
define('MCBOOKINSTALLED', true);
if (PHP_VERSION > '5.2.0'){
	date_default_timezone_set('PRC');
}
?>
