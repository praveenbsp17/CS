<?php
ob_start();
// Adding or updating Gallery
if(isset($_POST['title']) && isset($_POST['pageurl']) && isset($_POST['metaKeywords']) && isset($_POST['metaDesc']))
{
	if($_POST['title']!="" && $_POST['pageurl']!="" && $_POST['metaKeywords']!="" && $_POST['metaDesc']!="")
	{
		ini_set('max_execution_time', 600);
		
		$nwarr['gallery_title'] = $_POST['title'];
	    $nwarr['page_url'] = $_POST['pageurl'];
	    $nwarr['meta_keywords'] = $_POST['metaKeywords'];
		$nwarr['meta_description'] = $_POST['metaDesc'];
		$nwarr['modified_date'] = date('Y-m-d H:i:s');
		$nwarr['modified_by'] = $_SESSION['aid'];		
		
		// checking whether the gallery added updated
		if(isset($_POST['gallery_id']) && $_POST['gallery_id']!="")
		{
			$wcon = " where id = ".$_POST['gallery_id'];
			$lid=$Database->Update($nwarr,"gallery",$wcon);
			header("location: index.php?op=gallery&sucess=yes");
		}
		else
		{
			$nwarr['created_date'] = date('Y-m-d H:i:s');
			$nwarr['created_by'] = $_SESSION['aid'];		
			$nwarr['status'] = 1;
			$lid=$Database->insertuser($nwarr,"gallery");
			if($lid>0)
			{
			  header("location:index.php?op=gallery&sucess=yes");
			}
			else 
			{
			  header("location:index.php?op=gallery&Action=Add&error=yes");
			}
		}	
		
		exit();
	}
	else
	{
		header("location:index.php?op=gallery&Action=Add&error=empty");
		exit();
	}
}
 
//Deleting Gallery
if(isset($_GET['Action']) && $_GET['Action']=='Delete')
{
   $del_sql = "Delete from gallery where id = ".$_GET['gid']."";
   $Database->Delete($del_sql);
   header("location:index.php?op=gallery");
   exit();
}

// changing Gallery status
if(isset($_GET['status']) && $_GET['status']!="")
{
	$q1 = "Update gallery set `status` = '".$_GET['status']."' where id = ".$_GET['gid'];	
	//mysql_query($q1) or die(mysql_error());
	$Database->updateStatus($q1);
  	header("location:index.php?op=gallery");
	exit();

}

?>
		
<?php
if((isset($_GET['Action']))&&(($_GET['Action']=='Add')||($_GET['Action']=='Edit')))
{
  if(($_GET['Action']=='Edit')&&($_GET['gid']>0))
  {
	 $gallery = $Database->fetch_values("select * from gallery where id = '".$_GET['gid']."'");
	 $galleryData = array_shift($gallery);
	 $heading = 'Edit Gallery Details';
	 $buttonText = 'Save';
	 $title = $galleryData['gallery_title'];
	 $pageUrl = $galleryData['page_url'];
	 $metaKeywords = $galleryData['meta_keywords'];
	 $metaDesc = $galleryData['meta_description'];
	 
  }
  else
  {
	$heading = 'Add Gallery';
	$buttonText = 'Add';
	$title = '';
	$pageUrl = '';
	$metaKeywords = '';
	$metaDesc = '';
  }
?>
  <div class="col-md-12">	
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
		if(isset($_GET['error']) && $_GET['error'] == "empty")
		{?>
			Fields Should not be Empty
		<?php
		}
		else if(isset($_GET['error']) && $_GET['error'] == "yes")
		{?>
			Error Occured While Saving, Please try again
		<?php
		}
		?>
		
	 </div>
	 <?php
	 }?>
	<!-- form start -->
	<form id="galleryForm" action="index.php?op=gallery" method="post"  role="form" enctype="multipart/form-data">
		<div class="box-body">
			<div class="form-group">
				<label for="exampleInputTitle">Title</label>
				<input id="galleryTitle" type="text" name="title" class="form-control" placeholder="Enter Title" value="<?php echo $title;?>" data-bv-notempty data-bv-notempty-message="Gallery Title is required">
			</div>
			<div class="form-group">
				<label for="exampleInputPageUrl">Page Url</label>
				<input id="pageUrl" type="text" name="pageurl" class="form-control" placeholder="Page Url" value="<?php echo $pageUrl;?>" data-bv-notempty data-bv-notempty-message="page Url is required">
			</div>	
			<div class="form-group">
				<label for="exampleInputMetaKeywords">Meta Keywords</label>
				<textarea rows="3" name="metaKeywords" class="form-control" placeholder="Enter Meta Keywords" data-bv-notempty data-bv-notempty-message="Meta Keywords is required"><?php echo $metaKeywords;?></textarea>
			</div>
			<div class="form-group">
				<label for="exampleInputMetaDescription">Meta Description</label>
				<textarea rows="3" name="metaDesc" class="form-control" placeholder="Enter Meta Description" data-bv-notempty data-bv-notempty-message="Meta Description is required"><?php echo $metaDesc;?></textarea>
			</div>				
		</div><!-- /.box-body -->

		<div class="box-footer">
		    <?php 
			if(($_GET['Action']=='Edit')&&($_GET['gid']>0))
			{?>
				<input type="hidden" readonly="true" name="gallery_id" value="<?php echo $_GET['gid'];?>" />
			<?php
			}?>
			<input id="submitButton" type="submit" name="Submit" value="<?php echo $buttonText;?>" class="btn bg-olive btn-block">
		</div>
	</form>
	</div>
 </div>
 
	
<?php }
else
{ ?>
	<div class="box">
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
		 <button id="addButton" class="btn btn-primary pull-right" title="Add Gallery" data-placement="bottom" data-toggle="tooltip">
		 <i class="fa fa-plus-square"></i>&nbsp;Add</button>
		</div>
		<table id="galleryData" class="table table-bordered table-striped">
			<thead>
				<tr>
				  <th>Sno</th>
				  <th>Title</th>
				  <th>Created Date</th>
				  <th>Created By</th>
				  <th>Modified Date</th>
				  <th>Modified By</th>
				  <th>Status</th>
				  <th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
			 $gallery =$Database->fetch_values("select g.*,c.username as createdBy, m.username as modifiedBy from gallery g,admin c, admin m where g.created_by = c.id and g.modified_by = m.id ORDER BY g.id asc");
			 if(count($gallery) > 0)
			 {
			    $i=1;
			    foreach($gallery as $gal)
				{
					if($gal['status']==1)
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
					  <td><?php echo $gal['gallery_title'];?></td>
					  <td><?php echo date("d-m-Y H:i:s",strtotime($gal['created_date']));?></td>
					  <td><?php echo $gal['createdBy'];?></td>
					  <td><?php echo date("d-m-Y H:i:s",strtotime($gal['modified_date']));?></td>
					  <td><?php echo $gal['modifiedBy'];?></td>
					  <td>
					  <a title="Change Status" data-placement="bottom" data-toggle="tooltip" href='index.php?op=gallery&gid=<?=$gal['id']?>&status=<?php echo $sval;?>'>					  
					  <?php echo $status;?>
					  </a>
					  </td>
					  <td>
					  <a title="View Gallery Images" data-placement="bottom" data-toggle="tooltip" href='index.php?op=gallery_images&Action=Edit&gid=<?=$gal['id']?>'>
					  <i class="fa fa-folder-open fa-lg"></i></a>
					  &nbsp;
					  <a title="Edit Gallery" data-placement="bottom" data-toggle="tooltip" href='index.php?op=gallery&Action=Edit&gid=<?=$gal['id']?>'>
					  <i class="fa fa-pencil-square-o fa-lg"></i></a>
					  &nbsp;
					  <a title="Remove Gallery" data-placement="bottom" data-toggle="tooltip" href='index.php?op=gallery&Action=Delete&gid=<?=$gal['id']?>' onclick="return confirm('Are you sure')">
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
	$('#galleryData').dataTable({
		"bPaginate": true,
		"bLengthChange": false,
		"bFilter": false,
		"bSort": true,
		"bInfo": true,
		"bAutoWidth": false,
		"stateSave": true
	});
	
	$('#galleryForm').bootstrapValidator();	
	$("#addButton").click(function(){
	  var url = $(location).attr('href')+'&Action=Add';
	  $(location).attr('href',url)
	});	
	
	 <?php 
	if(isset($_GET['Action']))
	{?> 	
	  
	  // generating the url by using title
	  $("#galleryTitle").blur(function(){
		 $fval = $(this).val()
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')+".html";
		
		$("#pageUrl").val($fval);
        $('#galleryForm').bootstrapValidator('updateStatus','pageurl','VALID').bootstrapValidator('validateField','pageurl');			
	  });
	  
	<?php	   
	}?>
});
</script>
	
