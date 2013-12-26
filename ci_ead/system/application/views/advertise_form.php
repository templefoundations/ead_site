<script type="text/javascript">
function cancel() {
	history.back();
}
</script>

<div id="thin_body">

<form method="post" action="<?php echo site_url('advertise/submit'); ?>">
<h2>Advertise with us</h2>
<p>
eAdmissions.in is an online platform which allows students to buy application forms for admissions in various colleges.
The site is also known for its information wealth about the various courses and colleges in and around Tamilnadu.
Get benefitted by placing your ad in eAdmissions.in
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
<tr>
	<td class="first_col">Phone Number<sup>*</sup></td>
	<td><input type="text" class="textbox" name="contact_phone" value="<?php echo set_value('contact_phone'); ?>" /></td>
	<td>&nbsp;<?php echo form_error('contact_phone'); ?></td>
</tr>
</table>
</div>


<div id="form_section">
<table border="0" cellpadding="5" cellspacing="0" width="90%">
<caption>Advertisement Details</caption>
<tr>
	<td class="first_col">Your site URL<sup>*</sup></td>
	<td><input type="text" class="textbox" name="website_url" value="<?php echo set_value('website_url'); ?>" /></td>
	<td>&nbsp;<?php echo form_error('website_url'); ?></td>
</tr>
<tr>
	<td class="first_col">Description about your Ad<sup>*</sup></td>
	<td><textarea name="ad_desc"><?php echo set_value('ad_desc'); ?></textarea></td>
	<td>&nbsp;<?php echo form_error('ad_desc'); ?></td>
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