<?php
ob_start();
// Adding or updating Articles
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']))
{
	if(($_POST['username']!="")&&($_POST['password']!="")&&($_POST['email']!=""))
	{
		$nwarr['username'] = $_POST['username'];
		$nwarr['password'] = $_POST['password'];
		$nwarr['email'] = $_POST['email'];
		$nwarr['article_type'] = $_POST['articleType'];	
		// checking whether the articles added updated
		if(isset($_POST['article_id']) && $_POST['article_id']!="")
		{
			$action = 'Edit';
			$wcon = " where id = ".$_POST['article_id'];
			$lid=$Database->Update($nwarr,"articles",$wcon);
			header("location: index.php?op=articles&sucess=yes");
		}
		else
		{
			$action = 'Edit';
			$nwarr['createddate'] = date('Y-m-d');	
			$nwarr['status'] = 1;
			$lid=$Database->insertuser($nwarr,"articles");
			if($lid>0)
			{
			  header("location:index.php?op=articles&sucess=yes");
			}
			else 
			{
			  header("location:index.php?op=articles&Action=Add&error=yes");
			}
		}	
		
		exit();
	}
	else
	{
		header("location:index.php?op=articles&Action=".$action."&error=empty");
		exit();
	}
}
 
//Deleting Articles
if(isset($_GET['Action']) && $_GET['Action']=='Delete')
{
   $del_sql = "Delete from articles where id = ".$_GET['aid']."";
   $Database->Delete($del_sql);
   header("location:index.php?op=articles");
   exit();
}

// changing Articles status
if(isset($_GET['status']) && $_GET['status']!="")
{
	$q1 = "Update articles set `status` = '".$_GET['status']."' where id = ".$_GET['aid'];	
	//mysql_query($q1) or die(mysql_error());
	$Database->updateStatus($q1);
  	header("location:index.php?op=articles");
	exit();

}

?>
		
<?php
if((isset($_GET['Action']))&&(($_GET['Action']=='Add')||($_GET['Action']=='Edit')))
{
  if(($_GET['Action']=='Edit')&&($_GET['aid']>0))
  {
	 $articles = $Database->fetch_values("select * from articles where id = '".$_GET['aid']."'");
	 $articlesData = array_shift($articles);
	 $heading = 'Edit Articles Details';
	 $buttonText = 'Save';
	 $username = $articlesData['username'];
	 $password = $articlesData['apass'];
	 $email = $articlesData['email'];
	 $articlesType = $articlesData['articles_type'];
  }
  else
  {
	$heading = 'Add Article';
	$buttonText = 'Add';
	$username = '';
	$password = '';
	$email = '';
	$articlesType = '';
  }
?>
<div class="col-md-3">&nbsp;</div>
  <div class="col-md-6">	
	<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><?php echo $heading;?></h3>
	</div><!-- /.box-header -->
	<?php
	  if(isset($_GET['error'])) 
	  {	    
	  ?>
	  <div class="alert alert-danger alert-dismissable">
		<i class="fa fa-ban"></i>
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<b>Alert!</b>
		<?php	
		if($_GET['error'] == "empty")
		{?>
			Fields Should not be Empty
		<?php
		}
		else if($_GET['error'] == "yes")
		{?>
			Error Occured While Saving, Please try again
		<?php
		}?>
	 </div>
	 <?php
	 }?>
	<!-- form start -->
	<form id="articlesForm" action="index.php?op=articles" method="post"  role="form">
		<div class="box-body">
			<div class="form-group">
				<label for="exampleInputEmail1">Username</label>
				<input type="text" name="username" class="form-control" placeholder="Enter Username" value="<?php echo $username;?>" data-bv-notempty data-bv-notempty-message="User name is required">
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Password</label>
				<input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo $password;?>" data-bv-notempty data-bv-notempty-message="Password is required">
			</div>	
			<div class="form-group">
				<label for="exampleInputEmail1">Email ID</label>
				<input type="email" name="email" class="form-control" placeholder="Enter Email ID" value="<?php echo $email;?>" data-bv-notempty data-bv-notempty-message="Email ID is required" data-bv-emailaddress="true" data-bv-emailaddress-message="Please enter valid Email ID">
			</div>
			<div class="form-group">
				<label>Select</label>
				<select name="articlesType" class="form-control">
				    <?php
					if($articlesType == 'articles')
					{ ?>
						<option value="articles">articles</option>
						<option value="Content Writer">Content Writer</option>
					<?php }
					else
					{ ?>
						<option value="Content Writer">Content Writer</option>
						<option value="articles">articles</option>
				<?php }	?>				
				</select>
			</div>	
		</div><!-- /.box-body -->

		<div class="box-footer">
		    <?php 
			if(($_GET['Action']=='Edit')&&($_GET['aid']>0))
			{?>
				<input type="hidden" readonly="true" name="articles_id" value="<?php echo $_GET['aid'];?>" />
			<?php
			}?>
			<input type="submit" name="Submit" value="<?php echo $buttonText;?>" class="btn bg-olive btn-block">
		</div>
	</form>
	</div>
 </div>
 <div class="col-md-3">&nbsp;</div>
	
<?php }
else
{ ?>
	<div class="box">
	  <div class="box-header padding-bottom-10">
		<h3 class="box-title">Articles</h3>
	  </div><!-- /.box-header -->
	  <?php
	  if(isset($_GET['sucess']) &&  $_GET['sucess'] == 'yes')
	  {?>
	  <div class="alert alert-success alert-dismissable">
		<i class="fa fa-check"></i>
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<b>Alert!</b> Successfully Done.
	 </div>
	 <?php
	 }?>
	 <div class="box-body table-responsive">
	    <div><button id="addButton" class="btn btn-primary pull-right">Add</button></div>
		<table id="articlesData" class="table table-bordered table-striped">
			<thead>
				<tr>
				  <th>Sno</th>
				  <th>Title</th>
				  <th>Content</th>
				  <th>Category</th>
				  <th>Type</th>
				  <th>Created Date</th>
				  <th>Status</th>
				  <th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
			 $articles =$Database->fetch_values("select * from articles ORDER BY id asc");
			 if(count($articles) > 0)
			 {
			    $i=1;
			    foreach($articles as $article)
				{
					if($article['status']==1)
					{
					  $status = 'Active';
					  $sval = 0;
					}
					else
					{
						$status = 'Inactive';
						$sval = 1;
					}
			 ?>
					<tr>
					  <td><?php echo $i;?></td>
					  <td><?php echo $article['article_title'];?></td>
					  <td><?php echo $article['article_content'];?></td>
					  <td><?php echo $article['email'];?></td>
					  <td><?php echo $article['articles_type'];?></td>
					  <td><?php echo date("d-m-Y",strtotime($article['created_date']));?></td>
					  <td>
					  <?php
					  if($article['id']>1)
					  {?>
					  <a href='index.php?op=articles&aid=<?=$article['id']?>&status=<?php echo $sval;?>'>					  
					  <?php echo $status;?>
					  </a>
					  <?php
					  }
					  else
					  {
						echo $status;
  					  } ?>
					  </td>
					  <td>
					  <a href='index.php?op=articles&Action=Edit&aid=<?=$article['id']?>'><img src="images/edit.gif" border='0'/></a>
					  <?php
					  if($article['id']>1)
					  {?>					  
					  &nbsp;&nbsp;<a href='index.php?op=articles&Action=Delete&aid=<?=$article['id']?>'><img src="images/delete.gif" border='0' onclick="return confirm('Are you sure')"/></a>
					  <?php
					  }
					  ?>
				    </td>
					</tr>
			 
			 <?php
			    $i++;}
			 }
			 else
			 {
			 ?>
				<tr><td colspan='8' align='center'><strong>No Articles available...</strong></td></tr>
			 <?php
			 }
			 ?>
			</tbody>
        </table>			
	 </div>
	</div> 

	 
<?php } ?> 

<script type="text/javascript">
$(function() {
	$('#articlesData').dataTable({
		"bPaginate": true,
		"bLengthChange": false,
		"bFilter": false,
		"bSort": true,
		"bInfo": true,
		"bAutoWidth": false,
		"stateSave": true
	});
	
	$('#articlesForm').bootstrapValidator();
	$("#addButton").click(function(){
	  var url = $(location).attr('href')+'&Action=Add';
	  $(location).attr('href',url)
	});
});
</script>
	
