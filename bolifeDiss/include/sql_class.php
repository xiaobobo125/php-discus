<?php
class db_Mysql {
  /**�û���
   * @var String
   */
  var $dbServer;
  var $dbDatabase; 
  var $dbbase;
  var $dbUser;
  var $dbPwd;
  var $dbLink;
  var $result;// ִ��query�����ָ��
  var $num_rows;// ���ص���Ŀ��
  var $insert_id;// �������һ��ʹ�� INSERT ָ��� ID
  var $affected_rows;// ����query������Ӱ�������Ŀ
  
/**
 * ȡ�����ݿ�����
 */
function dbconnect()
{
   $this->dbLink=@mysql_connect($this->dbServer,$this->dbUser,$this->dbPwd);
   if(!$this->dbLink) $this->dbhalt("�����������ݿ�!");
   if($this->dbbase=="") $this->dbbase=$this->dbDatabase;
   if(!@mysql_select_db($this->dbbase,$this->dbLink))
   $this->dbhalt("���ݿⲻ����!");
   mysql_query("SET NAMES 'utf-8'");
} 

function execute($sql)
{
   $this->result=mysql_query($sql);
   return $this->result;
}

function fetch_array($result)
{
	return mysql_fetch_array($result);
}

public function get_rows($sql)
{
	return mysql_num_rows(mysql_query($sql));
}

function num_rows($result)
{
	return mysql_num_rows($result);
}

function data_seek($result,$rowNumber)
{
	return mysql_data_seek($result,$rowNumber);
}
	
function dbhalt($errmsg)
{
   $msg="database is wrong!";
   $msg=$errmsg;
   echo"$msg";
   die();
}

function delete($sql){
   $result=$this->execute($sql);
   $this->affected_rows=mysql_affected_rows($this->dbLink);
   $this->free_result($result);
   return $this->affected_rows;
}
  
function insert($sql){
	if ($result = mysql_query($sql)) {
	} else {
		//�趨ʧ��
		echo 'SQLִ��ʧ��:<br>';
		echo '�����SQLΪ:', $sql, '<br>';
		echo '����Ĵ���Ϊ:', mysql_errno(), '<br>';
		echo '�������ϢΪ:', mysql_error(), '<br>';
		die;
	}
	$this->insert_id=mysql_insert_id($this->dbLink);
	$this->free_result($result);
	return $result;
}
  
function update($sql)
{
   $result=$this->execute($sql);
   $this->affected_rows=mysql_affected_rows($this->dbLink);
   $this->free_result($result);
   return $this->affected_rows;
}

function get_num($result)
{
   $num=@mysql_numrows($result);
   return $num;
}
 
function free_result($result)
{
   @mysql_free_result($result);
}

function dbclose()
{
   mysql_close($this->dbLink);
}

}// end class
?>

