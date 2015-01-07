<!--content start here --->
<div class="wrapper row-offcanvas row-offcanvas-left">
	<?php
	// including left menu
	include_once("leftmenu.php");
	?>
	<!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
				<?php
				/*---- creating bread crumbs----- */
				if(isset($_GET['op']) && $_GET['op']!="")
				{
				  switch($_GET['op'])
				  {
				    case 'main':
					$pageHeading = 'Dashboard';
					$b1Title = 'Dashboard';
					break;
					case 'articles':
					$pageHeading = 'Articles';
					$b1Title = 'Articles';
					break;
					case 'polls':
					$pageHeading = 'Polls';
					$b1Title = 'Polls';
					break;
					case 'admin':
					$pageHeading = 'Administrators';
					$b1Title = 'Admins';
					break;
				  }
				  
				  if(isset($_GET['Action']))
				  {
					switch($_GET['Action'])
				   {
					case 'Add':
					$b2Title = 'Add '.substr($b1Title,0,-1);
					break;
					case 'Edit':
					$b2Title = 'Edit '.substr($b1Title,0,-1);
					break;
				   }
				  }
					
					$body = $_GET['op'];
					$filename="includes/".$body.".php";
					if(file_exists($filename))
					{	
					 $includeFile = $filename;	
					}
					else
					{
					 $pageHeading = '404';
					 $b1Title = '404';
					 $includeFile = "includes/404error.php";
					}
				}
				?>
                <section class="content-header">
                    <h1>
                        <?php echo $pageHeading;?>
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                      <li>
						<a href="index.php?op=main"><i class="fa fa-dashboard"></i> Home</a>
					  </li>
					  <?php
					  if(isset($_GET['Action']))
					  {?>
                       <li><a href="index.php?op=<?php echo $_GET['op'];?>"><?php echo $b1Title;?></a></li>
					   <li class="active"><?php echo $b2Title;?></li>
					  <?php
					  }
					  else
					  {?>
					   <li class="active"><?php echo $b1Title;?></li>
					  <?php
					  }?>
                    </ol>
                </section>
				<!-- Main content -->
                <section class="content">
				<?php
				include_once($includeFile);
				?>
				</section>
			</aside>	
</div>				

			
