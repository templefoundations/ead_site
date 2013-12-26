<style>
#reg_desc li {
	font-size: 12px;
	color: #555;
}
</style>

<script type="text/javascript">
function cancel() {
	//location.href = "<?php echo site_url('ii_home'); ?>";
	history.back();
}
</script>

<div id="thin_body">

<form method="post" action="<?php echo site_url('inst_registration/submit'); ?>">
<h2>College Registration</h2>

<div id="reg_desc" class="white_box rounded">
<p>Benefits of registering your college with us</p>
<ul>
<li>Presence of your college online 24*7</li>
<li>Promotion your college and course</li>
<li>Profile about your college at free of cost</li>
<li>Receive enquiries from applicants and general janta</li>
<li>Sell application form/ Prospectus at free of cost</li>
<li>Receive filled application form for various courses from applicants online</li>
<li>Manage received admission applications with Comprehensive reporting system using 20 plus searchable parameters</li>
<li>Review applications and set interview dates</li>
<li>Print and download received applications in pdf file.</li>
<li>Export applications in excel format.</li>
<li>Easy and Secured Payments Collections through Net Banking, Credit Card, Debit Card, Mobile Banking etc.</li>
<li>Free technical support from eadmissions.in and from Temple Foundations</li>
</ul>
<p>
If you want all these benefits all you have to do register your college with us. For registering fill the application form given below. We will get back to you within 48 hours 
</p>
</div>

<div id="form_section">
<table width="90%">
<caption>Your details</caption>
<tr>
	<td class="first_col">Name</td>
	<td><input type="text" class="textbox" name="contact_name" value="<?php echo set_value('contact_name'); ?>" /></td>
	<td>&nbsp;<?php echo form_error('contact_name'); ?></td>
</tr>
<tr>
	<td class="first_col">Email</td>
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
<table width="90%">
<caption>College Details</caption>
<tr>
	<td class="first_col">College Name</td>
	<td><input type="text" class="textbox" name="inst_name" value="<?php echo set_value('inst_name'); ?>" /></td>
	<td>&nbsp;<?php echo form_error('inst_name'); ?></td>
</tr>
<tr>
	<td class="first_col">Address</td>
	<td><textarea name="inst_address"><?php echo set_value('inst_address'); ?></textarea></td>
	<td>&nbsp;<?php echo form_error('inst_address'); ?></td>
</tr>
<tr>
	<td class="first_col">City</td>
	<td><input type="text" class="textbox" name="inst_city" value="<?php echo set_value('inst_city'); ?>" /></td>
	<td>&nbsp;<?php echo form_error('inst_city'); ?></td>
</tr>
<tr>
	<td class="first_col">State</td>
	<td><input type="text" class="textbox" name="inst_state" value="<?php echo set_value('inst_state'); ?>" /></td>
	<td>&nbsp;<?php echo form_error('inst_state'); ?></td>
</tr>
<tr>
	<td class="first_col">Pin code</td>
	<td><input type="text" class="textbox" name="inst_pincode" value="<?php echo set_value('inst_pincode'); ?>" /></td>
	<td>&nbsp;<?php echo form_error('inst_pincode'); ?></td>
</tr>
<tr>
	<td class="first_col">College website URL</td>
	<td><input type="text" class="textbox" name="inst_website_url" value="<?php echo set_value('inst_website_url'); ?>" /></td>
	<td>&nbsp;<?php echo form_error('inst_website_url'); ?></td>
</tr>
</table>
</div>

<div id="form_section">
<table border="0" cellpadding="5" cellspacing="0" width="100%">
	<caption>Captcha</caption>
	<tr>
		<td class="first_col">Enter the text shown in the Image</td>
		<td><?php echo $this->recaptcha->recaptcha_get_html($this->config->item('recaptcha_public_key'), $recaptcha_error); ?></td>
		<td>&nbsp;</td>
	</tr>
</table>
</div>

<div align="center">
	<button type="submit">Submit</button>
	<button type="button" onclick="cancel();">Cancel</button>
</div>

</form>

</div>