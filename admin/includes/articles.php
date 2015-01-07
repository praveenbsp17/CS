<?php
ob_start();
$categories = array("News","Politics","Gossips","Reviews");
// Adding or updating Articles
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']))
{
	if(($_POST['username']!="")&&($_POST['password']!="")&&($_POST['email']!=""))
	{
		$nwarr['title'] = $_POST['title'];
	    $nwarr['page_url'] = $articlesData['page_url'];
	    $nwarr['category'] = $articlesData['category'];
	    $nwarr['article_content'] = $articlesData['article_content'];
		$nwarr['article_img'] = $articlesData['article_img'];
		$nwarr['meta_keywords'] = $articlesData['meta_keywords'];
		$nwarr['meta_description'] = $articlesData['meta_description'];
		// checking whether the articles added updated
		if(isset($_POST['article_id']) && $_POST['article_id']!="")
		{
			$nwarr['modifieddate'] = date('Y-m-d H:i:s');
			$nwarr['modifiedby'] = $_SESSION['aid'];		
			$action = 'Edit';
			$wcon = " where id = ".$_POST['article_id'];
			$lid=$Database->Update($nwarr,"articles",$wcon);
			header("location: index.php?op=articles&sucess=yes");
		}
		else
		{
			$nwarr['createddate'] = date('Y-m-d H:i:s');
			$nwarr['createdby'] = $_SESSION['aid'];		
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
	 $title = $articlesData['title'];
	 $pageUrl = $articlesData['page_url'];
	 $acategory = $articlesData['category'];
	 $content = $articlesData['article_content'];
	 $articleImg = $articlesData['article_img'];
	 $metaKeywords = $articlesData['meta_keywords'];
	 $metaDesc = $articlesData['meta_description'];
	 
  }
  else
  {
	$heading = 'Add Article';
	$buttonText = 'Add';
	$title = '';
	$pageUrl = '';
	$acategory = '';
	$content = '';
	$articleImg = '';
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
				<label for="exampleInputTitle">Title</label>
				<input type="text" name="title" class="form-control" placeholder="Enter Title" value="<?php echo $title;?>" data-bv-notempty data-bv-notempty-message="Article Title is required">
			</div>
			<div class="form-group">
				<label for="exampleInputPageUrl">Page Url</label>
				<input type="text" name="pageurl" class="form-control" placeholder="Page Url" value="<?php echo $pageUrl;?>" data-bv-notempty data-bv-notempty-message="page Url is required">
			</div>	
			<div class="form-group">
				<label>Select</label>
				<select name="category" class="form-control" data-bv-notempty data-bv-notempty-message="Select Category">
				   <option value="">Select Category</option>
				   <?php
				    foreach($categories as $category)
					{
						if($category == $acategory)
						{
						  $sel = "";	
						}
						else
						{
						 $sel = "";	
						}
					?>
					   <option value="<?php echo $category;?>" <?php echo $sel;?>><?php echo $category;?></option>
					<?php
					}
					?>		
				</select>
			</div>
			<div class="form-group">
				<label for="exampleInputContent">Content</label>
				<textarea id="content" name="title" class="form-control" placeholder="Enter Article Content" data-bv-notempty data-bv-notempty-message="Article Content is required"><?php echo $content;?></textarea>
			</div>
			<div class="form-group">
				<label for="exampleInputMetaKeywords">Meta Keywords</label>
				<textarea rows="3" name="metaKeywords" class="form-control" placeholder="Enter Meta Keywords" data-bv-notempty data-bv-notempty-message="Meta Keywords is required"><?php echo $metaKeywords;?></textarea>
			</div>
			<div class="form-group">
				<label for="exampleInputMetaDescription">Meta Description</label>
				<textarea rows="3" name="metaDesc" class="form-control" placeholder="Enter Meta Description" data-bv-notempty data-bv-notempty-message="Meta Description is required"><?php echo $metaDesc;?></textarea>
			</div>
			<div class="form-group">
				<label for="articleImg">Article Image</label>
				<input type="file" id="articleImg">				
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
		 <button id="addButton" class="btn btn-primary pull-right" title="Add Article" data-placement="bottom" data-toggle="tooltip">
		 <i class="fa fa-plus-square"></i>&nbsp;Add</button>
		</div>
		<table id="articlesData" class="table table-bordered table-striped">
			<thead>
				<tr>
				  <th>Sno</th>
				  <th>Title</th>
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
					  <td><?php echo $article['category'];?></td>
					  <td><?php echo date("d-m-Y H:i:s",strtotime($article['created_date']));?></td>
					  <td>
					  <a title="Change Status" data-placement="bottom" data-toggle="tooltip" href='index.php?op=articles&aid=<?=$article['id']?>&status=<?php echo $sval;?>'>					  
					  <?php echo $status;?>
					  </a>
					  </td>
					  <td>
					  <a title="Edit Article" data-placement="bottom" data-toggle="tooltip" href='index.php?op=articles&Action=Edit&aid=<?=$article['id']?>'>
					  <i class="fa fa-pencil-square-o fa-lg"></i></a>
					  <?php
					  if($article['id']>1)
					  {?>					  
					  &nbsp;
					  <a title="Remove Article" data-placement="bottom" data-toggle="tooltip" href='index.php?op=articles&Action=Delete&aid=<?=$article['id']?>' onclick="return confirm('Are you sure')">
					  <i class="fa fa-times fa-lg"></i></a>
					  <?php
					  }
					  ?>
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
<!-- CK Editor -->
<script src="template/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
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
	
	// Replace the <textarea id="content"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('content');
	
});
</script>
	
