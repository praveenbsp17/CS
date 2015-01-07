<?php
ob_start();
// Adding or updating Poll
if(isset($_POST['question']) && isset($_POST['option1']) && isset($_POST['option2']) && isset($_POST['option3']) && isset($_POST['option4']))
{
	if(($_POST['question']!="")&&($_POST['option1']!="")&&($_POST['option2']!="")&&($_POST['option3']!="")&&($_POST['option4']!=""))
	{
		$nwarr['question'] = $_POST['question'];
		$nwarr['option1'] = $_POST['option1'];
		$nwarr['option2'] = $_POST['option2'];
		$nwarr['option3'] = $_POST['option3'];
		$nwarr['option4'] = $_POST['option4'];
			
		// checking whether the polls added updated
		if(isset($_POST['Poll_id']) && $_POST['Poll_id']!="")
		{
			$action = 'Edit';
			$wcon = " where id = ".$_POST['Poll_id'];
			$lid=$Database->Update($nwarr,"polls",$wcon);
			header("location: index.php?op=polls&sucess=yes");
		}
		else
		{
			$action = 'Edit';
			$nwarr['createddate'] = date('Y-m-d');	
			$nwarr['status'] = 1;
			$lid=$Database->insertuser($nwarr,"polls");
			if($lid>0)
			{
			  header("location:index.php?op=polls&sucess=yes");
			}
			else 
			{
			  header("location:index.php?op=polls&Action=Add&error=yes");
			}
		}	
		
		exit();
	}
	else
	{
		header("location:index.php?op=polls&Action=".$action."&error=empty");
		exit();
	}
}
 
//Deleting Poll
if(isset($_GET['Action']) && $_GET['Action']=='Delete')
{
   $del_sql = "Delete from polls where id = ".$_GET['pid']."";
   $Database->Delete($del_sql);
   header("location:index.php?op=polls");
   exit();
}

// changing Poll status
if(isset($_GET['status']) && $_GET['status']!="")
{
	$q1 = "Update polls set `status` = '".$_GET['status']."' where id = ".$_GET['pid'];	
	//mysql_query($q1) or die(mysql_error());
	$Database->updateStatus($q1);
  	header("location:index.php?op=polls");
	exit();

}

?>
		
<?php
if((isset($_GET['Action']))&&(($_GET['Action']=='Add')||($_GET['Action']=='Edit')))
{
  if(($_GET['Action']=='Edit')&&($_GET['pid']>0))
  {
	 $polls = $Database->fetch_values("select * from polls where id = '".$_GET['pid']."'");
	 $pollsData = array_shift($polls);
	 $heading = 'Edit Poll Details';
	 $buttonText = 'Save';
	 $question = $pollsData['question'];
	 $option1 = $pollsData['option1'];
	 $option2 = $pollsData['option2'];
	 $option3 = $pollsData['option3'];
	 $option4 = $pollsData['option4'];	 
  }
  else
  {
	$heading = 'Add Poll';
	$buttonText = 'Add';
	$question = '';
	$option1 = '';
	$option2 = '';
	$option3 = '';
	$option4 = '';
	
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
	<form id="pollForm" action="index.php?op=polls" method="post"  role="form">
		<div class="box-body">
			<div class="form-group">
				<label for="exampleInputQuestion">Question</label>
				<input type="text" name="question" class="form-control" placeholder="Enter Question" value="<?php echo $question;?>" data-bv-notempty data-bv-notempty-message="Question is required">
			</div>
			<div class="form-group">
				<label for="exampleInputOption1">Option A</label>
				<input type="text" name="option1" class="form-control" placeholder="Enter Option A" value="<?php echo $option1;?>" data-bv-notempty data-bv-notempty-message="Option A is required">
			</div>
			<div class="form-group">
				<label for="exampleInputOption2">Option B</label>
				<input type="text" name="option2" class="form-control" placeholder="Enter Option B" value="<?php echo $option2;?>" data-bv-notempty data-bv-notempty-message="Option B is required">
			</div>
			<div class="form-group">
				<label for="exampleInputOption3">Option C</label>
				<input type="text" name="option3" class="form-control" placeholder="Enter Option C" value="<?php echo $option3;?>" data-bv-notempty data-bv-notempty-message="Option C is required">
			</div>
			<div class="form-group">
				<label for="exampleInputOption4">Option D</label>
				<input type="text" name="option4" class="form-control" placeholder="Enter Option D" value="<?php echo $option4;?>" data-bv-notempty data-bv-notempty-message="Option D is required">
			</div>	
		</div><!-- /.box-body -->

		<div class="box-footer">
		    <?php 
			if(($_GET['Action']=='Edit')&&($_GET['pid']>0))
			{?>
				<input type="hidden" readonly="true" name="Poll_id" value="<?php echo $_GET['pid'];?>" />
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
		<h3 class="box-title">Polls</h3>
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
	    <div class="col-md-12 padding-right-none margin-bottom-5">
		 <button id="addButton" class="btn btn-primary pull-right" title="Add Poll" data-placement="bottom" data-toggle="tooltip">
		 <i class="fa fa-plus-square"></i>&nbsp;Add</button>
		</div>
		<table id="pollsData" class="table table-bordered table-striped">
			<thead>
				<tr>
				  <th>Sno</th>
				  <th>Question</th>
				  <th>Option A</th>
				  <th>Option B</th>
				  <th>Option C</th>
				  <th>Option D</th>
				  <th>Created Date</th>
				  <th>Status</th>
				  <th>Action</th>
				</tr>
			</thead>
			<tbody>		
			<?php
			 $polls =$Database->fetch_values("select * from polls ORDER BY id asc");
			 if(count($polls) > 0)
			 {
			    $i=1;
			    foreach($polls as $poll)
				{
					if($poll['status']==1)
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
					  <td><?php echo $poll['question'];?></td>
					  <td><?php echo $poll['option1'];?></td>
					  <td><?php echo $poll['option2'];?></td>
					  <td><?php echo $poll['option3'];?></td>
					  <td><?php echo $poll['option4'];?></td>
					  <td><?php echo date("d-m-Y",strtotime($poll['createddate']));?></td>
					  <td>
					    <a href='index.php?op=polls&pid=<?=$poll['id']?>&status=<?php echo $sval;?>'>					  
					     <?php echo $status;?>
					     </a>				  
					  </td>
					  <td>
					  <a title="View Poll Results" data-placement="bottom" data-toggle="tooltip" href='index.php?op=polls&Action=Edit&pid=<?=$poll['id']?>'>
					    <i class="fa fa-list-alt fa-lg"></i>
					  </a>
					   &nbsp;&nbsp;
					  <a title="Edit Poll" data-placement="bottom" data-toggle="tooltip" href='index.php?op=polls&Action=Edit&pid=<?=$poll['id']?>'>
					    <i class="fa fa-pencil-square-o fa-lg"></i>
					  </a>
					  &nbsp;
					  <a title="Remove Poll" data-placement="bottom" data-toggle="tooltip" href='index.php?op=poll&Action=Delete&pid=<?=$poll['id']?>' onclick="return confirm('Are you sure')">
					    <i class="fa fa-times fa-lg"></i></a>
					   </td>
					</tr>
			 
			 <?php
			    $i++;}
			 }
			 ?>
			</tbody>
        </table>			
	 </div>
	</div> 

	 
<?php } ?> 

<script type="text/javascript">
$(function() {	
	
	$('#pollsData').dataTable({
		"bPaginate": true,
		"bLengthChange": false,
		"bFilter": false,
		"bSort": true,
		"bInfo": true,
		"bAutoWidth": false,
		"stateSave": true
	});
	
	$('#pollForm').bootstrapValidator();
	$("#addButton").click(function(){
	  var url = $(location).attr('href')+'&Action=Add';
	  $(location).attr('href',url)
	});
	
	$('[data-toggle="tooltip"]').tooltip();
	
});
</script>
	
