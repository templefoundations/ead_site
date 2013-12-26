<script type="text/javascript">
$(function() {
	$("#date_of_birth").datepicker({ 
		dateFormat:'yy-mm-dd',
		changeMonth:'true',
		changeYear:'true',
		defaultDate:'-20y'
	});
});
</script>

<!-- BODY -->
<div id="thin_body">
<div id="adm_form">
<div id="form_details">
<h2>PSG College of Technology</h2>
<h3>Application for <?php echo $course_name; ?></h3>
</div>
<form action="<?php echo site_url('online_form/submit/'.$appln_id); ?>" method="post" enctype="multipart/form-data">
<div id="form_section">
<table border="0" cellpadding="5" cellspacing="0" width="100%">
	<caption>Candidate Details</caption>
	<tr>
		<td class="first_col">Full Name</td>
		<td><input type="text" class="textbox" name="full_name" value="<?php echo set_value('full_name'); ?>" /></td>
		<td>&nbsp;<?php echo form_error('full_name'); ?></td>
	</tr>
	<tr>
		<td class="first_col">Father's Name</td>
		<td><input type="text" class="textbox" name="father_name" value="<?php echo set_value('father_name'); ?>" /></td>
		<td>&nbsp;<?php echo form_error('father_name'); ?></td>
	</tr>
	<tr>
		<td class="first_col">Date of Birth</td>
		<td><input type="text" name="date_of_birth" id="date_of_birth" class="textbox small" 
			value="<?php echo set_value('date_of_birth'); ?>" readonly="readonly" /></td>
		<td>&nbsp;<?php echo form_error('date_of_birth'); ?></td>
	</tr>
	<tr>
		<td class="first_col">Email address</td>
		<td><input type="text" class="textbox" name="cnd_email" value="<?php echo set_value('cnd_email'); ?>" /></td>
		<td>&nbsp;<?php echo form_error('cnd_email'); ?></td>
	</tr>
	<tr>
		<td class="first_col">Location</td>
		<td><input type="text" class="textbox" name="location" value="<?php echo set_value('location'); ?>" /></td>
		<td>&nbsp;<?php echo form_error('location'); ?></td>
	</tr>
</table>
</div>

<?php
foreach ($tables as $table)
{
	echo '<div id="form_section">';
	echo $table;
	echo "</div>";
}
?>

<div id="form_confirmation">
<div>
<p>I, here by agree that all the informations provided above are true</p>
</div>
<p style="color:#C60"><b>After Payment, the BILL will be send to the
email id provided. Verify your email id below</b></p>

<?php $this->load->view('email_verification_form'); ?>

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

<div align="center"><button type="submit">Submit &amp; Pay</button></div>

</div><!-- END FORM CONFIRMATION -->
</form>
</div><!-- END ADM_FORM -->
</div><!-- END BODY -->