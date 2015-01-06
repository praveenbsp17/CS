<?php
class Database {


var $server   = ""; //database server
var $user     = ""; //database login name
var $pass     = ""; //database login password
var $database = ""; //database name
var $pre      = ""; //table prefix
//var $username = array();


#######################
//internal info
var $error = "";
var $errno = 0;

//number of rows affected by SQL query
var $affected_rows = 0;

var $link_id = 0;
var $query_id = 0;


#-#############################################
# desc: constructor
function Database($server, $user, $pass, $database, $pre=''){
//echo phpinfo();exit;
        $this->server=$server;
	$this->user=$user;
	$this->pass=$pass;
	$this->database=$database;
	$this->pre=$pre;
}#-#constructor()


#-#############################################
# desc: connect and select database using vars above
# Param: $new_link can force connect() to open a new link, even if mysql_connect() was called before with the same parameters
function connect($new_link=false) {
	$this->link_id=mysql_connect($this->server,$this->user,$this->pass,$new_link);

	if (!$this->link_id) {//open failed
		$this->oops("Could not connect to server: <b>$this->server</b>.");
		}

	if(!@mysql_select_db($this->database, $this->link_id)) {//no database
		$this->oops("Could not open database: <b>$this->database</b>.");
		}

	// unset the data so it can't be dumped
	$this->server='';
	$this->user='';
	$this->pass='';
	$this->database='';
}#-#connect()


#-#############################################
# desc: close the connection
function close() {
	if(!@mysql_close($this->link_id)){
		$this->oops("Connection close failed.");
	}
}#-#close()


#-#############################################
# Desc: escapes characters to be mysql ready
# Param: string
# returns: string
function escape($string) {
	if(get_magic_quotes_runtime()) $string = stripslashes($string);
	return mysql_real_escape_string($string);
}#-#escape()


#-#############################################
# Desc: executes SQL query to an open connection
# Param: (MySQL query) to execute
# returns: (query_id) for fetching results etc
function query($sql) {
	// do query
	$this->query_id = @mysql_query($sql, $this->link_id);

	if (!$this->query_id) {
		$this->oops("<b>MySQL Query fail:</b> $sql");
		return 0;
	}

	$this->affected_rows = @mysql_affected_rows($this->link_id);

	return $this->query_id;
}#-#query()


// Admin Login

function adminlogin($uname,$pwd)
{
	$query = "SELECT * FROM admin WHERE username='".$uname."' and password=ENCODE('".$pwd."','auto') and status = 1";
	$result = mysql_query($query);
	$nrow = mysql_num_rows($result);

	if($nrow>0)
	{
	  $row = mysql_fetch_array($result);
	  return $row;
	}
}
function userlogin($userId,$pwd)
{
	$query = "SELECT uid,lcId FROM mlm_users WHERE lcId='".$userId."' and password='".$pwd."'";
	$result = mysql_query($query) or die(mysql_error());
	$nrow = mysql_num_rows($result);

	$user_array = array();
	if($nrow>0)
	{
	  $row = mysql_fetch_array($result);
	  $user_array['uid'] = $row['uid'];
	  $user_array['lcId'] = $row['lcId'];
	  return $user_array;
	}
}
function fetch_array($query_id=-1) {
	// retrieve row
	if ($query_id!=-1) {
		$this->query_id=$query_id;
	}

	if (isset($this->query_id)) {
		$record = @mysql_fetch_assoc($this->query_id);
	}else{
		$this->oops("Invalid query_id: <b>$this->query_id</b>. Records could not be fetched.");
	}

	return $record;
}#-#fetch_array()


function fetch_values($Ed_sql)
{
	//echo $Ed_sql;
	//exit();
	//$Ed_sql = "select *,DECODE(password,'auto') AS apass from admin";
	$Ed_res = mysql_query($Ed_sql);

	$out = array();
	while ($row = $this->fetch_array($Ed_res,$Ed_sql)){
		$out[] = $row;
	}

	//$Ed_row = mysql_fetch_array($Ed_res);
	return $out;
}

function num_values($Ed_sql)
{
	//echo $Ed_sql;
	//exit();
	//$Ed_sql = "select *,DECODE(password,'auto') AS apass from admin";
	$Ed_res = mysql_query($Ed_sql);
	$row = mysql_num_rows($Ed_res);

	//$Ed_row = mysql_fetch_array($Ed_res);
	return $row;
}

 function insertuser($fields,$table) {
   $app = '';
   $p = 1;
   foreach($fields as $key=>$val)
   {
	   // echo $table;
   if(($key=='password')&&($table=='admin'))
   {
     $app.= $key ."=ENCODE('".$val."', 'auto')";
   }
   else
   {
   $app.= $key ."='".addslashes($val)."'";
   }

   if($p<count($fields))
   $app.=" , ";
   $p++;
   }
   //echo "INSERT INTO ".$table." SET ".$app."";
   //exit();
   $sql = mysql_query("INSERT INTO ".$table." SET ".$app);
   $lid = mysql_insert_id();
   return $lid;
   }

  function Update($fields,$table,$wcond) {
   $app = '';
   $p = 1;
   foreach($fields as $key=>$val)
   {
   // echo $table;
   if(($key=='password')&&($table=='admin'))
   {
     $app.= $key ."=ENCODE('".$val."', 'auto')";
   }
   else
   {
   $app.= $key ."='".addslashes($val)."'";
   }
   if($p<count($fields))
   $app.=" , ";
   $p++;
   }
  //echo "Update ".$table." SET ".$app.$wcond;
  //exit();
  $sql = mysql_query("Update ".$table." SET ".$app.$wcond );

   return $sql;
   }

   function Delete($d_sql)
   {
   	$d_res = mysql_query($d_sql);
    return $d_res;
   }
   
   function updateStatus($up_sql)
   {
   	$up_status = mysql_query($up_sql);
    return $up_status;
   }

   function oops($msg)
   {
     return $msg;
   }

   

}//CLASS Database
?>