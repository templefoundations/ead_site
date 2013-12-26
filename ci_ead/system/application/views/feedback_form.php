<script type="text/javascript">
function cancel() {
	history.back();
}
</script>

<div id="thin_body">

<form method="post" action="<?php echo site_url('feedback/submit'); ?>">
<h2>Feedback us</h2>
<p>
"Feedback is the breakfast of champions", says Ken Blanchard, the global leader in leadership training.
Feedback is very much needed for our improvement too as it will allow us to produce the best for you.
So, please do pour in your feedbacks.
</p>
<br />
<div id="form_section">
<table border="0" cellpadding="5" cellspacing="0" width="90%">
<caption>Your details</caption>
<tr>
	<td class="first_col">Name<sup>*</sup></td>
	<td><input type="text" class="textbox" name="contact_name" value="<?php echo set_value('contact_name'); ?>" /></td>
	<td>&nbsp;<?php echo form_error('contact_name'); ?></td>
</tr>
<tr>
	<td class="first_col">Email<sup>*</sup></td>
	<td><input type="text" class="textbox" name="contact_email" value="<?php echo set_value('contact_email'); ?>" /></td>
	<td>&nbsp;<?php echo form_error('contact_email'); ?></td>
</tr>
</table>
</div>


<div id="form_section">
<table border="0" cellpadding="5" cellspacing="0" width="90%">
<caption>Feedback Details</caption>
<tr>
	<td class="first_col">Feedback about<sup>*</sup></td>
	<td><input type="text" class="textbox" name="feedback_about" value="<?php echo set_value('feedback_about'); ?>" /></td>
	<td>&nbsp;<?php echo form_error('feedback_about'); ?></td>
</tr>
<tr>
	<td class="first_col">your valuable feedback<sup>*</sup></td>
	<td><textarea name="feedback"><?php echo set_value('feedback'); ?></textarea></td>
	<td>&nbsp;<?php echo form_error('feedback'); ?></td>
</tr>
</table>
</div>

<div id="form_section">
<table border="0" cellpadding="5" cellspacing="0" width="90%">
	<caption>Captcha</caption>
	<tr>
		<td class="first_col">Enter the text shown in the Image<sup>*</sup></td>
		<td><?php echo $this->recaptcha->recaptcha_get_html($this->config->item('recaptcha_public_key'), $recaptcha_error); ?></td>
		<td>&nbsp;</td>
	</tr>
</table>
</div>

* - mandatory fields

<div align="center">
	<button type="submit">Submit</button>
	<button type="button" onclick="cancel();">Cancel</button>
</div>

</form>

</div>