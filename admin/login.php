<?php 
include_once("../lib/config.php");
$error = '';

if(isset($_POST['userid']) && isset($_POST['password']))
{	
	if($_POST['userid']!="" && $_POST['password']!="")
	{
		$nrows=$Database->adminlogin($_POST['userid'],$_POST['password']);
		if(count($nrows) > 0)
		{
		 
		 $_SESSION['name'] = $_POST['userid'];
		 $_SESSION['aid'] = $nrows['id'];
		 $_SESSION['admin_login'] = 'loggedin';
		 if($nrows['admin_type'] == 'Admin')
		 {
		   $_SESSION['adminType'] = 'Administrator';
		 }
		 else
		 {
			$_SESSION['adminType'] = $nrows['admin_type'];
		 }
		  $returnValue = true;
		  header("location:index.php?op=main");
		 exit();
		} 
		else
		{ 
		 $error = '<div id="errorbox" class="bg-gray text-red">Invalid username and/or password!</div>';
		 
		}
	}
	else
	{
		$error = '<div id="errorbox" class="bg-gray text-red">Empty username and/or password!</div>';
	}	
}?>
<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>CineSodhi | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="template/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="template/js/plugins/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="template/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="template/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
		
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
			<div id="login_errors" align="center"><?php echo "$error"; ?> </div>
            <form id="loginForm" action="login.php" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="userid" class="form-control" placeholder="User ID" data-bv-notempty data-bv-notempty-message="User id is required"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" data-bv-notempty data-bv-notempty-message="Password is required"/>
                    </div> 
                </div>
                <div class="footer">      
					<input type="submit" name="Submit" value="Login" class="btn bg-olive btn-block">
                </div>
            </form>

            
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="template/js/bootstrap.min.js" type="text/javascript"></script> 
		<script src="template/js/plugins/bootstrapvalidator/js/bootstrapValidator.min.js" type="text/javascript"></script>   	

    </body>
</html>
<script type="text/javascript">
			$(document).ready(function() {
				$('#loginForm').bootstrapValidator();
			});
		</script>

