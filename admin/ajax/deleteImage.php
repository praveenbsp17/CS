<?php
 if(isset($_POST['articleId']) && $_POST['articleId']!="")
 {
	include_once("../../lib/config.php");	 
	$nwarr['article_img'] = ''; 
	$nwarr['modified_date'] = date('Y-m-d H:i:s');
	$nwarr['modified_by'] = $_SESSION['aid'];		
	$wcon = " where id = ".$_POST['articleId'];
	$lid=$Database->Update($nwarr,"articles",$wcon);
	if($lid)
	{
		echo "<img src='../uploads/articles/no-image.gif'  width='90' height='64'/>";
	}	
	exit();
 }	 
?>		
