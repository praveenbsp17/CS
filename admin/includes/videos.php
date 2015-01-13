<?php
ob_start();
$videoTypes = array("Trailer","Short Film");
// Adding or updating Videos
if(isset($_POST['title']) && isset($_POST['pageurl']) && isset($_POST['videotype']) && isset($_POST['videourl']) && isset($_POST['metaKeywords']) && isset($_POST['metaDesc']))
{
	if($_POST['title']!="" && $_POST['pageurl']!="" && $_POST['videotype']!="" && $_POST['videourl']!="" && $_POST['metaKeywords']!="" && $_POST['metaDesc']!="")
	{
		ini_set('max_execution_time', 600);
		
		$nwarr['video_title'] = $_POST['title'];
	    $nwarr['page_url'] = $_POST['pageurl'];
	    $nwarr['video_type'] = $_POST['videotype'];
		$nwarr['video_url'] = $_POST['videourl'];		
	    $nwarr['meta_keywords'] = $_POST['metaKeywords'];
		$nwarr['meta_description'] = $_POST['metaDesc'];
		$nwarr['modified_date'] = date('Y-m-d H:i:s');
		$nwarr['modified_by'] = $_SESSION['aid'];	
			
		
		// checking whether the videos added updated
		if(isset($_POST['video_id']) && $_POST['video_id']!="")
		{
			$wcon = " where id = ".$_POST['video_id'];
			$lid=$Database->Update($nwarr,"videos",$wcon);
			header("location: index.php?op=videos&sucess=yes");
		}
		else
		{
			$nwarr['created_date'] = date('Y-m-d H:i:s');
			$nwarr['created_by'] = $_SESSION['aid'];
			$nwarr['status'] = 1;
			$lid=$Database->insertuser($nwarr,"videos");
			if($lid>0)
			{
			  header("location:index.php?op=videos&sucess=yes");
			}
			else 
			{
			  header("location:index.php?op=videos&Action=Add&error=yes");
			}
		}	
		
		exit();
	}
	else
	{
		header("location:index.php?op=videos&Action=Add&error=empty");
		exit();
	}
}
 
//Deleting Videos
if(isset($_GET['Action']) && $_GET['Action']=='Delete')
{
   $del_sql = "Delete from videos where id = ".$_GET['vid']."";
   $Database->Delete($del_sql);
   header("location:index.php?op=videos");
   exit();
}

// changing Videos status
if(isset($_GET['status']) && $_GET['status']!="")
{
	$q1 = "Update videos set `status` = '".$_GET['status']."' where id = ".$_GET['vid'];	
	//mysql_query($q1) or die(mysql_error());
	$Database->updateStatus($q1);
  	header("location:index.php?op=videos");
	exit();

}

?>
		
<?php
if((isset($_GET['Action']))&&(($_GET['Action']=='Add')||($_GET['Action']=='Edit')))
{
  if(($_GET['Action']=='Edit')&&($_GET['vid']>0))
  {
	 $videos = $Database->fetch_values("select * from videos where id = '".$_GET['vid']."'");
	 $videosData = array_shift($videos);
	 $heading = 'Edit Video Details';
	 $buttonText = 'Save';
	 $title = $videosData['video_title'];
	 $pageUrl = $videosData['page_url'];
	 $svideoType = $videosData['video_type'];
	 $videoUrl = $videosData['video_url'];
	 $metaKeywords = $videosData['meta_keywords'];
	 $metaDesc = $videosData['meta_description'];
	 
  }
  else
  {
	$heading = 'Add Video';
	$buttonText = 'Add';
	$title = '';
	$pageUrl = '';
	$svideoType = '';
	$videoUrl = '';
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
	<form id="videosForm" action="index.php?op=videos" method="post"  role="form" enctype="multipart/form-data">
		<div class="box-body">
			<div class="form-group">
				<label for="exampleInputTitle">Title</label>
				<input id="videoTitle" type="text" name="title" class="form-control" placeholder="Enter Title" value="<?php echo $title;?>" data-bv-notempty data-bv-notempty-message="Video Title is required">
			</div>
			<div class="form-group">
				<label for="exampleInputPageUrl">Page Url</label>
				<input id="pageUrl" type="text" name="pageurl" class="form-control" placeholder="Page Url" value="<?php echo $pageUrl;?>" data-bv-notempty data-bv-notempty-message="page Url is required">
			</div>	
			<div class="form-group">
				<label>Select</label>
				<select name="videotype" class="form-control" data-bv-notempty data-bv-notempty-message="Select Video Type">
				   <option value="">Select Video Type</option>
				   <?php
				    foreach($videoTypes as $videoType)
					{
						if($videoType == $svideoType)
						{
						  $sel = "selected='selected'";	
						}
						else
						{
						 $sel = "";	
						}
					?>
					   <option value="<?php echo $videoType;?>" <?php echo $sel;?>><?php echo $videoType;?></option>
					<?php
					}
					?>		
				</select>
			</div>
			<div class="form-group">
				<label for="exampleInputVideoUrl">video Url</label>
				<input id="videoUrl" type="text" name="videourl" class="form-control" placeholder="Video Url" value="<?php echo $videoUrl;?>" data-bv-notempty data-bv-notempty-message="Video Url is required" data-bv-uri data-bv-uri-message="Please Enter Valid Url">
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
			if(($_GET['Action']=='Edit')&&($_GET['vid']>0))
			{?>
				<input type="hidden" readonly="true" name="video_id" value="<?php echo $_GET['vid'];?>" />
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
		 <button id="addButton" class="btn btn-primary pull-right" title="Add Video" data-placement="bottom" data-toggle="tooltip">
		 <i class="fa fa-plus-square"></i>&nbsp;Add</button>
		</div>
		<table id="videosData" class="table table-bordered table-striped">
			<thead>
				<tr>
				  <th>Sno</th>
				  <th>Title</th>
				  <th>Type</th>
				  <th>Url</th>
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
			 $videos =$Database->fetch_values("select ac.*,c.username as createdBy, m.username as modifiedBy from videos ac,admin c, admin m where ac.created_by = c.id and ac.modified_by = m.id ORDER BY ac.id asc");
			 if(count($videos) > 0)
			 {
			    $i=1;
			    foreach($videos as $video)
				{
					if($video['status']==1)
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
					  <td><?php echo $video['video_title'];?></td>
					  <td><?php echo $video['video_type'];?></td>
					  <td><?php echo $video['video_url'];?></td>
					  <td><?php echo date("d-m-Y H:i:s",strtotime($video['created_date']));?></td>
					  <td><?php echo $video['createdBy'];?></td>
					  <td><?php echo date("d-m-Y H:i:s",strtotime($video['modified_date']));?></td>
					  <td><?php echo $video['modifiedBy'];?></td>
					  <td>
					  <a title="Change Status" data-placement="bottom" data-toggle="tooltip" href='index.php?op=videos&vid=<?=$video['id']?>&status=<?php echo $sval;?>'>					  
					  <?php echo $status;?>
					  </a>
					  </td>
					  <td>
					  <a title="Edit Video" data-placement="bottom" data-toggle="tooltip" href='index.php?op=videos&Action=Edit&vid=<?=$video['id']?>'>
					  <i class="fa fa-pencil-square-o fa-lg"></i></a>
					  &nbsp;
					  <a title="Remove Video" data-placement="bottom" data-toggle="tooltip" href='index.php?op=videos&Action=Delete&vid=<?=$video['id']?>' onclick="return confirm('Are you sure')">
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
	$('#videosData').dataTable({
		"bPaginate": true,
		"bLengthChange": false,
		"bFilter": false,
		"bSort": true,
		"bInfo": true,
		"bAutoWidth": false,
		"stateSave": true
	});
	
	$('#videosForm').bootstrapValidator();	
	
	
	$("#addButton").click(function(){
	  var url = $(location).attr('href')+'&Action=Add';
	  $(location).attr('href',url)
	});	
	
	 <?php 
	if(isset($_GET['Action']))
	{?>	  
	  // generating the url by using title
	  $("#videoTitle").blur(function(){
		 $fval = $(this).val()
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')+".html";
		
		$("#pageUrl").val($fval);
        $('#videosForm').bootstrapValidator('updateStatus','pageurl','VALID').bootstrapValidator('validateField','pageurl');			
	  });
    
	<?php
	}?>
});
</script>
	
