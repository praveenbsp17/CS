<?php
ob_start();
//Deleting Poll
if(isset($_GET['Action']) && $_GET['Action']=='Delete')
{
   $del_sql = "Delete from poll_votes where id = ".$_GET['vid']."";
   $Database->Delete($del_sql);
   header("location:index.php?op=poll_votes&pid=".$_GET['pid']);
   exit();
}

// changing Poll status
if(isset($_GET['status']) && $_GET['status']!="")
{
	$q1 = "Update poll_votes set `status` = '".$_GET['status']."' where id = ".$_GET['vid'];	
	//mysql_query($q1) or die(mysql_error());
	$Database->updateStatus($q1);
  	header("location:index.php?op=poll_votes&pid=".$_GET['pid']);
	exit();

}
?>
<div class="box">
	<div class="box-body table-responsive">
	    <table id="pollVotesData" class="table table-bordered table-striped">
			<thead>
				<tr>
				  <th>Sno</th>
				  <th>Voted For</th>
				  <th>User IP</th>
				  <th>Voted Date</th>
				  <th>Status</th>
				  <th>Action</th>
				</tr>
			</thead>
			<tbody>		
			<?php
			 $pollVotes = $Database->fetch_values("select *, v.status as vstatus from poll_votes v,polls p where p.id = v.poll_id and v.poll_id = ".$_GET['pid']." ORDER BY v.id asc");
			 if(count($pollVotes) > 0)
			 {
			    $i=1;
				$votesArray = array('option1'=>0,'option2'=>0,'option3'=>0,'option4'=>0);
			    foreach($pollVotes as $pollVote)
				{
					if($pollVote['vstatus']==1)
					{
					  $status = 'Active';
					  $sval = 0;
					}
					else
					{
						$status = 'Inactive';
						$sval = 1;
					}
					$answerKey = "option".$pollVote['vote'];
					$votesArray[$answerKey] = $votesArray[$answerKey]+1;
			 ?>
					<tr>
					  <td><?php echo $i;?></td>
					  <td><?php echo $pollVote[$answerKey];?></td>
					  <td><?php echo $pollVote['user_ip'];?></td>
					  <td><?php echo date("d-m-Y H:i:s", strtotime($pollVote['voted_datetime']));?></td>
					  <td>
					    <a title="Change Status" data-placement="bottom" data-toggle="tooltip" href='index.php?op=poll_votes&pid=<?=$_GET['pid']?>&vid=<?=$pollVote['id']?>&status=<?php echo $sval;?>'>					  
					     <?php echo $status;?>
					     </a>				  
					  </td>
					  <td>					   
					  <a title="Remove Vote" data-placement="bottom" data-toggle="tooltip" href='index.php?op=poll_votes&Action=Delete&pid=<?=$_GET['pid']?>&vid=<?=$pollVote['id']?>' onclick="return confirm('Are you sure')">
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
<?php
if(count($pollVotes) > 0)
{
  $graphData = array();	
 // calculating the percntage of the votes
 foreach($votesArray as $voteKey => $voteData)
 {
	 $graphData[$voteKey]['label'] = $polls[0][$voteKey];
	 if($voteData>0)
	 {
		$val = $voteData / count($pollVotes) * 100;	 
	 }
	 else{
		 $val = $voteData;	 
	 }
	 $graphData[$voteKey]['value'] = $val;
 }
 
?>
	<!-- Donut chart -->
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><i class="fa fa-bar-chart-o"></i>
			&nbsp;<?php echo $polls[0]['question'];?></h3>
		</div>
		<div class="box-body">
			<div id="votes-chart" style="height: 300px;"></div>
		</div><!-- /.box-body-->
	</div><!-- /.box --> 
<?php
}?>
<!-- FLOT CHARTS -->
<script src="template/js/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="template/js/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>	
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="template/js/plugins/flot/jquery.flot.pie.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(function() {

	<?php
	if(count($pollVotes) > 0 && count($graphData)>0)
	{?>
		/*
		 * DONUT CHART
		 * -----------
		 */

		var donutData = [
			{label: "<?php echo $graphData['option1']['label'];?>", data: <?php echo $graphData['option1']['value'];?>, color: "#3c8dbc"},
			{label: "<?php echo $graphData['option2']['label'];?>", data: <?php echo $graphData['option2']['value'];?>, color: "#0073b7"},
			{label: "<?php echo $graphData['option3']['label'];?>", data: <?php echo $graphData['option3']['value'];?>, color: "#00c0ef"},
			{label: "<?php echo $graphData['option4']['label'];?>", data: <?php echo $graphData['option4']['value'];?>, color: "#83AAF2"}
		];
		$.plot("#votes-chart", donutData, {
			series: {
				pie: {
					show: true,
					radius: 1,
					innerRadius: 0.3,
					label: {
						show: true,
						radius: 2 / 3,
						formatter: labelFormatter,
						threshold: 0.1
					}

				}
			},
			legend: {
				show: true
			}
		});
		/*
		 * END DONUT CHART
		 */
	<?php
	}?>
	
	$('#pollVotesData').dataTable({
		"bPaginate": true,
		"bLengthChange": false,
		"bFilter": false,
		"bSort": true,
		"bInfo": true,
		"bAutoWidth": false,
		"stateSave": true
	});
});

/*
 * Custom Label formatter
 * ----------------------
 */
function labelFormatter(label, series) {
	return "<div style='font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;'>"
			+ label
			+ "<br/>"
			+ Math.round(series.percent) + "%</div>";
}
</script>
	
