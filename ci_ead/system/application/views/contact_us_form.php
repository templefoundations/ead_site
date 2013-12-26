<script type="text/javascript">
function cancel() {
	history.back();
}
</script>

<div id="thin_body">

<form method="post" action="<?php echo site_url('contact_us/submit'); ?>">
<h2>Contact Us</h2>
<p>Contact us for queries, solutions and partnership opportunities.<br></p>

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
<tr>
	<td class="first_col">Phone Number</td>
	<td><input type="text" class="textbox" name="contact_phone" value="<?php echo set_value('contact_phone'); ?>" /></td>
	<td>&nbsp;<?php echo form_error('contact_phone'); ?></td>
</tr>
</table>
</div>


<div id="form_section">
<table border="0" cellpadding="5" cellspacing="0" width="90%">
<caption>What's the reason behind contacting us</caption>
<tr>
	<td class="first_col">Subject<sup>*</sup></td>
	<td><input type="text" class="textbox" name="subject" value="<?php echo set_value('subject'); ?>" /></td>
	<td>&nbsp;<?php echo form_error('subject'); ?></td>
</tr>
<tr>
	<td class="first_col">Description of the reason<sup>*</sup></td>
	<td><textarea name="reason_desc"><?php echo set_value('reason_desc'); ?></textarea></td>
	<td>&nbsp;<?php echo form_error('reason_desc'); ?></td>
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

<table class="style7" border="0" width="279">
    <tbody><tr>
      <td width="59"><span class="style10">Phone</span></td>

      <td width="210"><span class="style10">+91  720 026 8649 </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><span class="style10">+91  979 053 8038</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>

      <td><span class="style10">+91  959 781 7231</span></td>
    </tr>
  </tbody></table>
  <p>  
  </p>
  mail us at <a href="mailto:contact@eadmissions.in">contact@eadmissions.in</a>

</div>