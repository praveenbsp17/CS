<?php
include_once("../lib/config.php");
//$inactive = 180;

$inactive = 60 * 60;
//session_destroy();
//print_r($_SESSION);
if(isset($_SESSION['starts']) ) 
{
  $session_life = time() - $_SESSION['starts'];
	if($session_life > $inactive)
	{
	header("Location: logout.php");
	exit();
	}
}

$_SESSION['starts'] = time();

if($_SESSION['admin_login']!='loggedin') 
{
  header("location: login.php");
 exit();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CineSodhi Admin Panel</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="template/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="template/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="template/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="template/css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="template/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="template/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
		<!-- DATA TABLES -->
        <link href="template/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="template/js/plugins/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="template/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
		
		<!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="template/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="template/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="template/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- datepicker -->
        <script src="template/js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="template/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
		<!-- DATA TABES SCRIPT -->
        <script src="template/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="template/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
		<script src="template/js/plugins/bootstrapvalidator/js/bootstrapValidator.min.js" type="text/javascript"></script>  
         <!-- AdminLTE App -->
        <script src="template/js/AdminLTE/app.js" type="text/javascript"></script>
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="index.php?op=main" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                CineSodhi
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $_SESSION['name'];?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="template/img/avatar5.png" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo $_SESSION['name'];?> - <?php echo $_SESSION['adminType'];?>
                                        <!--<small>Member since Nov. 2012</small>-->
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="index.php?op=admin&Action=Edit&aid=<?php echo $_SESSION['aid'];?>" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
	
