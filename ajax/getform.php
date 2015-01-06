<?php
include_once("../lib/config.php");
 $ftype = $_REQUEST['type'];	

if($ftype == 'pwd')
{
 $formContent = '
   <div class="cb_form_instructions">
   If you <strong>lost your password</strong> but know your username, please enter your Username and your E-mail Address, press the Send Password button, and you will receive a new password shortly. Use this new password to access the site.
   </div>
 
   <div id="cb_line_checkusername" style="padding-top:10px;">
   <label for="checkusername">Username :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
 	<input type="text" name="forgot_user_name" id="checkusername" class="required" size="30" maxlength="25" />
  </div>
 
   <div class="cb_form_line" id="cb_line_checkemail">
   <label for="checkemail">E-mail Address :&nbsp;</label>
    <input type="text" name="forgot_email" id="checkemail" class="required" size="30" />
   </div>
  <div style="text-align:center;padding-top:10px;">
  <input type="submit" name="forgot" class="button" id="cbsendnewuspass" value="Send Password" />
  <input type="hidden" name="ftype" value="'.$ftype.'" />
  </div>';
}
else if($ftype == 'uname')
{
	$formContent = '
   <div class="cb_form_instructions">
   If you <strong>lost your username</strong>, please enter your E-mail Address, Then click the Send Username button, and your username will be sent to your email address.
   </div>
 
   <div class="cb_form_line" id="cb_line_checkemail" style="padding-top:10px;">
   <label for="checkemail">E-mail Address :&nbsp;</label>
    <input type="text" name="forgot_email" id="checkemail" class="required" size="30" />
  </div>
  <div style="text-align:center;padding-top:10px;">
  <input type="submit" name="forgot" class="button" id="cbsendnewuspass" value="Send Username" />
  <input type="hidden" name="ftype" value="'.$ftype.'" />
  </div>';
}
else if($ftype == 'both')
{
	$formContent = '
   <div class="cb_form_instructions">
   If you <strong>forgot both your username and your password</strong>, please recover the username first, then the password. To recover your username, please enter your E-mail Address, Then click the Send Username button, and your username will be sent to your email address. From there you can use this same form to recover your password.
   </div>
 
   <div class="cb_form_line" id="cb_line_checkemail" style="padding-top:10px;">
   <label for="checkemail">E-mail Address :&nbsp;</label>
     <input type="text" name="forgot_email" id="checkemail" class="required" size="30" />
  </div>
  <div style="text-align:center;padding-top:10px;">
  <input type="submit" name="forgot" class="button" id="cbsendnewuspass" value="Send Username" />
  <input type="hidden" name="ftype" value="'.$ftype.'" />
  </div>';
}
else 
{
 $formContent = '<div style="padding:10px;color:#ff0000;">Please select atleast one checkbox</div>';
}

echo $formContent;

?>

