<script type="text/javascript">
function send_vcode()
{
	window.document.forms[0].send_vcode_btn.value = "1";
	window.document.forms[0].submit();
}
</script>

<input type="hidden" name="send_vcode_btn" value="0" />

<div id="form_section">
<table width="100%">
<caption>Email ID Verification</caption>
<tr>
	<td width="15%">Email address</td>
	<td><input type="text" class="textbox" name="email_id" value="<?php echo $this->input->post('email_id'); ?>" /></td>
	<td class="error">&nbsp;<?php echo $this->email_verification->email_error_msg; ?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><button type="button" onclick="send_vcode()" title="Send verification code to the above mentioned email address">
		Send Verification Code</button></td>
	<td class="info">&nbsp;<?php echo $this->email_verification->email_msg; ?></td>
</tr>
<tr>
	<td colspan="3" class="info">a verification code is sent to the above mentioned
	email id. Enter the verification code below.</td>
</tr>
<tr>
	<td>Verification code</td>
	<td><input type="text" class="textbox" name="vcode" value="<?php echo $this->input->post('vcode'); ?>" 
		title="Enter the verification code sent to the above mentioned email address" /></td>
	<td class="error">&nbsp;<?php echo $this->email_verification->vcode_msg; ?></td>
</tr>
</table>
</div>