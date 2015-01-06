<?php
ob_start();
// Adding or updating Admin
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']))
{
	if(($_POST['username']!="")&&($_POST['password']!="")&&($_POST['email']!=""))
	{
		$nwarr['username'] = $_POST['username'];
		$nwarr['password'] = $_POST['password'];
		$nwarr['email'] = $_POST['email'];
		$nwarr['admin_type'] = $_POST['adminType'];	
		// checking whether the admin added updated
		if(isset($_POST['Admin_id']) && $_POST['Admin_id']!="")
		{
			$action = 'Edit';
			$wcon = " where id = ".$_POST['Admin_id'];
			$lid=$Database->Update($nwarr,"admin",$wcon);
			header("location: index.php?op=admin&sucess=yes");
		}
		else
		{
			$action = 'Edit';
			$nwarr['createddate'] = date('Y-m-d');	
			$nwarr['status'] = 1;
			$lid=$Database->insertuser($nwarr,"admin");
			if($lid>0)
			{
			  header("location:index.php?op=admin&sucess=yes");
			}
			else 
			{
			  header("location:index.php?op=admin&Action=Add&error=yes");
			}
		}	
		
		exit();
	}
	else
	{
		header("location:index.php?op=admin&Action=".$action."&error=empty");
		exit();
	}
}
 
//Deleting Admin
if(isset($_GET['Action']) && $_GET['Action']=='Delete')
{
   $del_sql = "Delete from admin where id = ".$_GET['aid']."";
   $Database->Delete($del_sql);
   header("location:index.php?op=admin");
   exit();
}

// changing Admin status
if(isset($_GET['status']) && $_GET['status']!="")
{
	$q1 = "Update admin set `status` = '".$_GET['status']."' where id = ".$_GET['aid'];	
	//mysql_query($q1) or die(mysql_error());
	$Database->updateStatus($q1);
  	header("location:index.php?op=admin");
	exit();

}

?>
		
<?php
if((isset($_GET['Action']))&&(($_GET['Action']=='Add')||($_GET['Action']=='Edit')))
{
  if(($_GET['Action']=='Edit')&&($_GET['aid']>0))
  {
	 $Admins = $Database->fetch_values("select *,DECODE(password,'auto') AS apass from admin where id = '".$_GET['aid']."'");
	 $adminData = array_shift($Admins);
	 $heading = 'Edit Admin Details';
	 $buttonText = 'Save';
	 $username = $adminData['username'];
	 $password = $adminData['apass'];
	 $email = $adminData['email'];
	 $adminType = $adminData['admin_type'];
  }
  else
  {
	$heading = 'Add Admin';
	$buttonText = 'Add';
	$username = '';
	$password = '';
	$email = '';
	$adminType = '';
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
	<form id="adminForm" action="index.php?op=admin" method="post"  role="form">
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
				<select name="adminType" class="form-control">
				    <?php
					if($adminType == 'Admin')
					{ ?>
						<option value="Admin">Admin</option>
						<option value="Content Writer">Content Writer</option>
					<?php }
					else
					{ ?>
						<option value="Content Writer">Content Writer</option>
						<option value="Admin">Admin</option>
				<?php }	?>				
				</select>
			</div>	
		</div><!-- /.box-body -->

		<div class="box-footer">
		    <?php 
			if(($_GET['Action']=='Edit')&&($_GET['aid']>0))
			{?>
				<input type="hidden" readonly="true" name="Admin_id" value="<?php echo $_GET['aid'];?>" />
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
		<h3 class="box-title">Administrators</h3>
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
		<table id="adminData" class="table table-bordered table-striped">
			<thead>
				<tr>
				  <th>Sno</th>
				  <th>Username</th>
				  <th>Password</th>
				  <th>Email</th>
				  <th>Type</th>
				  <th>Created Date</th>
				  <th>Status</th>
				  <th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
			 $admins =$Database->fetch_values("select * from admin ORDER BY id asc");
			 if(count($admins) > 0)
			 {
			    $i=1;
			    foreach($admins as $admin)
				{
					if($admin['status']==1)
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
					  <td><?php echo $admin['username'];?></td>
					  <td><?php echo $admin['password'];?></td>
					  <td><?php echo $admin['email'];?></td>
					  <td><?php echo $admin['admin_type'];?></td>
					  <td><?php echo date("d-m-Y",strtotime($admin['createddate']));?></td>
					  <td>
					  <?php
					  if($admin['id']>1)
					  {?>
					  <a href='index.php?op=admin&aid=<?=$admin['id']?>&status=<?php echo $sval;?>'>					  
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
					  <a href='index.php?op=admin&Action=Edit&aid=<?=$admin['id']?>'><img src="images/edit.gif" border='0'/></a>
					  <?php
					  if($admin['id']>1)
					  {?>					  
					  &nbsp;&nbsp;<a href='index.php?op=admin&Action=Delete&aid=<?=$admin['id']?>'><img src="images/delete.gif" border='0' onclick="return confirm('Are you sure')"/></a>
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
				<tr><td colspan='8' align='center'><strong>No Admins available...</strong></td></tr>
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
	$('#adminData').dataTable({
		"bPaginate": true,
		"bLengthChange": false,
		"bFilter": false,
		"bSort": true,
		"bInfo": true,
		"bAutoWidth": false,
		"stateSave": true
	});
	
	$('#adminForm').bootstrapValidator();
	$("#addButton").click(function(){
	  var url = $(location).attr('href')+'&Action=Add';
	  $(location).attr('href',url)
	});
});
</script>
	
