<?
include_once("../lib/config.php");
 $functionId = $_REQUEST['fid'];	
	
	$itemData='<table width ="100%" cellspacing="0" cellpadding="0">
		   <tr>
			<td width="25%" class="loginbox_text" align="right">
			<label class=label id="company_name_other_display"><b>&nbsp;Select Item</b></label>		</td>
			<td width="5%" align="center" class="label"><b>:</b></td>
			<td align="left">
			 <select name="itemId" class="required">
			  <option value="">Select Item</option>';
				  $items =$Database->fetch_values("select * from items where functionId = '".$functionId."' ORDER BY id desc");
					if(count($items)>0)
					{
						foreach($items as $item)
						{
						 if($aval["itemId"] == $item["id"])
						 {
						  $isel = "selected=\'selected\'";
						 }
						 else
						 {
						   $isel = "";
						 }
						
							$itemData .='<option value="'.$item['id'].'" '.$isel.'>'.$item['title'].'</option>';
						}
					}
					
				$itemData .='</select>
							</td>
							</tr>
							</table>';
	
	

echo $itemData;

?>

