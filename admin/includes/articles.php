<?php
ob_start();
$categories = array("Movies","Politics","Gossips","Reviews");
// Adding or updating Articles
if(isset($_POST['title']) && isset($_POST['pageurl']) && isset($_POST['category']) && isset($_POST['metaKeywords']) && isset($_POST['metaDesc']))
{
	if($_POST['title']!="" && $_POST['pageurl']!="" && $_POST['category']!="" && $_POST['content']!="" && $_POST['metaKeywords']!="" && $_POST['metaDesc']!="")
	{
		ini_set('max_execution_time', 600);
		
		$nwarr['article_title'] = $_POST['title'];
	    $nwarr['page_url'] = $_POST['pageurl'];
	    $nwarr['category'] = $_POST['category'];
	    $nwarr['article_content'] = $_POST['content'];		
		$nwarr['meta_keywords'] = $_POST['metaKeywords'];
		$nwarr['meta_description'] = $_POST['metaDesc'];
		$nwarr['modified_date'] = date('Y-m-d H:i:s');
		$nwarr['modified_by'] = $_SESSION['aid'];	
			
		// image uploading
		$imgError = '';			
		if(isset($_FILES["articleImg"]["name"]) && $_FILES["articleImg"]["name"]!="")
		{
			$target_dir = "../uploads/articles/";
			$target_file_name = basename($_FILES["articleImg"]["name"]);
			$imageFileData = pathinfo($target_file_name);
			$imageFileType = pathinfo($target_file_name,PATHINFO_EXTENSION);
			$newFileName = $imageFileData['filename']."_".time().".".$imageFileData['extension'];
			$target_file = $target_dir . $newFileName;			
			// Check if image file is a actual image or fake image
			$check = getimagesize($_FILES["articleImg"]["tmp_name"]);
			if($check !== false) 
			{
				// Check file size
				if ($_FILES["articleImg"]["size"] <= 10485760) 
				{
					// Allow certain file formats
					if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ) 
					{
					   if (!move_uploaded_file($_FILES["articleImg"]["tmp_name"], $target_file)) 
					   {
						 $imgError = "error";
					   }	
					}
					else
				    { 
					   $imgError = "format";
				    }	
				}
				else
				{
					$imgError = "size";
				}
				
			} 
			else 
			{
				$imgError = "type";
			}
			$nwarr['article_img'] = $newFileName;
		}	
		
		// checking whether the articles added updated
		if(isset($_POST['article_id']) && $_POST['article_id']!="")
		{
			$wcon = " where id = ".$_POST['article_id'];
			$lid=$Database->Update($nwarr,"articles",$wcon);
			header("location: index.php?op=articles&sucess=yes&ierror=".$imgError);
		}
		else
		{
			$nwarr['created_date'] = date('Y-m-d H:i:s');
			$nwarr['created_by'] = $_SESSION['aid'];
			$nwarr['status'] = 1;
			$lid=$Database->insertuser($nwarr,"articles");
			if($lid>0)
			{
			  header("location:index.php?op=articles&sucess=yes&ierror=".$imgError);
			}
			else 
			{
			  header("location:index.php?op=articles&Action=Add&error=yes&ierror=".$imgError);
			}
		}	
		
		exit();
	}
	else
	{
		header("location:index.php?op=articles&Action=Add&error=empty");
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
	 $heading = 'Edit Article Details';
	 $buttonText = 'Save';
	 $title = $articlesData['article_title'];
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
	  if((isset($_GET['error'])) || (isset($_GET['ierror']) && $_GET['ierror']!="")) 
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
		if(isset($_GET['ierror']) && $_GET['ierror']!="")
		{
			switch($_GET['ierror'])
			{
			  case 'error':
			    echo "Sorry, there was an error uploading your file.";
			   break;
			  case 'format':
			     echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			   break;
              case 'size':
			     echo "Sorry, your file is too large.";
			   break;
			  case 'type':
			     echo "Uploaded file is not an image.";
			   break;			  	
			}
		}
		?>
		
	 </div>
	 <?php
	 }?>
	<!-- form start -->
	<form id="articlesForm" action="index.php?op=articles" method="post"  role="form" enctype="multipart/form-data">
		<div class="box-body">
			<div class="form-group">
				<label for="exampleInputTitle">Title</label>
				<input id="articleTitle" type="text" name="title" class="form-control" placeholder="Enter Title" value="<?php echo $title;?>" data-bv-notempty data-bv-notempty-message="Article Title is required">
			</div>
			<div class="form-group">
				<label for="exampleInputPageUrl">Page Url</label>
				<input id="pageUrl" type="text" name="pageurl" class="form-control" placeholder="Page Url" value="<?php echo $pageUrl;?>" data-bv-notempty data-bv-notempty-message="page Url is required">
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
						  $sel = "selected='selected'";	
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
			<div id="contentDiv" class="form-group">
				<label for="exampleInputContent">Content</label>
				<textarea id="content" name="content" class="form-control" placeholder="Enter Article Content" data-bv-notempty data-bv-notempty-message="Article Content is required"><?php echo $content;?></textarea>
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
				<?php
				if($_GET['Action']=='Edit')
				{
				    if($articleImg !="")
					{
						$aImg = $articleImg;
					}
					else
					{
					   $aImg = 'no-image.gif';	
					}	
				?>
			      <div id="imageDiv" style="height:75px;">
				   <div class="margin-bottom-5" style="float:left;width:90px;border:1px solid #ccc;">
				    <img id="articleImage" src="../uploads/articles/<?php echo $aImg;?>" width="90" height="64" />
				   </div>
				   <?php
				   if($articleImg!="")
				   {?> 	   
				   <div class="margin-bottom-5" style="float:left;width:90px;padding-left:10px">
				    <button class="btn btn-small btn-danger" name="deleteImage" id="deleteImage">Delete</button>
				   </div>
				   <?php
				   }?>
                  </div> 				   
				<?php
				}
				?>				
				<input name="articleImg" type="file" id="articleImg">				
			</div>	
		</div><!-- /.box-body -->

		<div class="box-footer">
		    <?php 
			if(($_GET['Action']=='Edit')&&($_GET['aid']>0))
			{?>
				<input type="hidden" readonly="true" name="article_id" value="<?php echo $_GET['aid'];?>" />
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
		 <button id="addButton" class="btn btn-primary pull-right" title="Add Article" data-placement="bottom" data-toggle="tooltip">
		 <i class="fa fa-plus-square"></i>&nbsp;Add</button>
		</div>
		<table id="articlesData" class="table table-bordered table-striped">
			<thead>
				<tr>
				  <th>Sno</th>
				  <th>Image</th>
				  <th>Title</th>
				  <th>Category</th>
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
			 $articles =$Database->fetch_values("select ac.*,c.username as createdBy, m.username as modifiedBy from articles ac,admin c, admin m where ac.created_by = c.id and ac.modified_by = m.id ORDER BY ac.id asc");
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
					if($article['article_img'] !="")
					{
						$articleImg = $article['article_img'];
					}
					else
					{
						$articleImg = 'no-image.gif';
					}
			 ?>
					<tr>
					  <td><?php echo $i;?></td>
					  <td><img src="../uploads/articles/<?php echo $articleImg;?>" width="90" height="64" /></td>
					  <td><?php echo $article['article_title'];?></td>
					  <td><?php echo $article['category'];?></td>
					  <td><?php echo date("d-m-Y H:i:s",strtotime($article['created_date']));?></td>
					  <td><?php echo $article['createdBy'];?></td>
					  <td><?php echo date("d-m-Y H:i:s",strtotime($article['modified_date']));?></td>
					  <td><?php echo $article['modifiedBy'];?></td>
					  <td>
					  <a title="Change Status" data-placement="bottom" data-toggle="tooltip" href='index.php?op=articles&aid=<?=$article['id']?>&status=<?php echo $sval;?>'>					  
					  <?php echo $status;?>
					  </a>
					  </td>
					  <td>
					  <a title="Edit Article" data-placement="bottom" data-toggle="tooltip" href='index.php?op=articles&Action=Edit&aid=<?=$article['id']?>'>
					  <i class="fa fa-pencil-square-o fa-lg"></i></a>
					  &nbsp;
					  <a title="Remove Article" data-placement="bottom" data-toggle="tooltip" href='index.php?op=articles&Action=Delete&aid=<?=$article['id']?>' onclick="return confirm('Are you sure')">
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
	
	// validating the content and submitting the form
	$("#articlesForm").submit(function(){
		if($("#content").val()!="")
		{
			$("#contentDiv").find(".help-block").attr("style","display:none");	
		    $("#contentDiv").addClass("has-success");
			return true;
		}
		else
		{
		  $("#contentDiv").find(".help-block").attr("style","");	
		  $("#contentDiv").addClass("has-error");
		  return false;
		}		
	});
	
	$("#addButton").click(function(){
	  var url = $(location).attr('href')+'&Action=Add';
	  $(location).attr('href',url)
	});	
	
	 <?php 
	if(isset($_GET['Action']))
	{?>
	   // Replace the <textarea id="content"> with a CKEditor
      // instance, using default configuration.
      CKEDITOR.replace('content');	
	  
	  // generating the url by using title
	  $("#articleTitle").blur(function(){
		 $fval = $(this).val()
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')+".html";
		
		$("#pageUrl").val($fval);
        $('#articlesForm').bootstrapValidator('updateStatus','pageurl','VALID').bootstrapValidator('validateField','pageurl');			
	  });
	  
	  // on blur removing validation error for textarea
	  var editor = CKEDITOR.instances['content'];
		if (editor) {
			editor.on('blur', function(event) {
				// Do something
				editor.updateElement();
				var content = $("#content").val().replace(/(<([^>]+)>)/ig,"");
				 if (content!="" && content != "&nbsp;")
				 {
					 $("#contentDiv").find(".help-block").attr("style","display:none");	
					if($("#contentDiv").hasClass("has-error"))
					{
					  $("#contentDiv").removeClass("has-error")	
					}	
					$("#contentDiv").addClass("has-success"); // The action that you would like to call onChange
					if(($('#articlesForm').data('bootstrapValidator').isValid()) && (typeof $("#submitButton") !== typeof undefined && $("#submitButton") !== false))
					{
						$('#articlesForm').bootstrapValidator('disableSubmitButtons', false);		
					}
				}
				else{
					 $("#contentDiv").find(".help-block").attr("style","");	
					 $("#contentDiv").addClass("has-error");
					 $('#articlesForm').bootstrapValidator('disableSubmitButtons', true);		
				}
			});
        }   
	  
    
	  <?php
	   if(($_GET['Action']=='Edit')&&($_GET['aid']>0))
       {?>		   
		$("#deleteImage").click(function(){		
		  $.ajax({
			  url:"ajax/deleteImage.php",
			  type: "POST",
			  data:"articleId=<?php echo $_GET['aid'];?>",
			  success:function(result){
			  $("#imageDiv").html(result);
			 }
		  }); 
		});
	<?php
	   }
	}?>
});
</script>
	
