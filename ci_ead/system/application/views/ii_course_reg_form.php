<style>
<!--
textarea {
	width:75%;
}
-->
</style>

<script type="text/javascript">
function cancel() {
	location.href = "<?php echo site_url('ii_home'); ?>";
}

$(function() {
	var dates = $( "#opening_date, #closing_date" ).datepicker({
//		defaultDate: "+1w",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		gotoCurrent: true,
		numberOfMonths: 2,
		onSelect: function( selectedDate ) {
			var option = this.id == "opening_date" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" );
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
//	
//	$("#opening_date").datepicker({ dateFormat:'yy-mm-dd', changeMonth:'true', gotoCurrent:true, minDate:+7 });
//	$("#closing_date").datepicker({ dateFormat:'yy-mm-dd', changeMonth:'true', gotoCurrent:true, minDate:+14, defaultDate:+30  });
});
</script>

<div id="thin_body">
<div id="manage_tab" align="center">
<h2>Course Registration</h2>
<form method="post" action="<?php echo site_url('ii_course_registration/submit'); ?>" enctype="multipart/form-data">
<table>
	<tr>
		<td>Course*</td>
		<td><select name="course_id">
			<option value="" selected="selected">-- Select a Course --</option>
			<?php
			foreach ($courses as $course):
					echo '<option value="'.$course->get_id().'" '.set_select('course_id', $course->get_id()).' >'
						.$course->get_name().' </option>';
			endforeach;
			?>
		</select></td>
		<td class="error" width="25%"><?php echo form_error('course_id'); ?></td>
	</tr>
	<tr>
		<td colspan="2">Description of this Course in your College</td>
		<td class="error" width="25%"><?php echo form_error('desc'); ?></td>
	</tr>
	<tr>
		<td colspan="3"><textarea name="desc" cols="100" rows="5"><?php echo set_value('desc'); ?></textarea></td>
	</tr>
	<tr>
		<td width="182">Upload Application Form*</td>
		<td width="488">
			<input type="file" class="textbox file" name="form_file" value="<?php echo set_value('form_file'); ?>" size="50" />
		</td>
		<td class="error" width="25%"><?php echo $file_error; ?></td>
	</tr>
	<tr>
		<td height="50" colspan="3"><span class="info">Uploaded Application
		form will be processed soon and we will notify you back</span></td>
	</tr>
	<tr>
		<td>Application form price*</td>
		<td>Rs. <input type="text" class="textbox small" name="price" size="6" value="<?php echo set_value('price'); ?>" /></td>
		<td class="error" width="25%"><?php echo form_error('price'); ?></td>
	</tr>
	<tr>
		<td>Applications open</td>
		<td>
			from <input type="text" class="textbox small" name="opening_date" id="opening_date" value="<?php echo set_value('opening_date'); ?>"
				readonly="readonly" /> to 
			<input type="text" class="textbox small" name="closing_date" id="closing_date" value="<?php echo set_value('closing_date'); ?>"
				readonly="readonly" />
		</td>
		<td class="error" width="25%">
			<?php echo form_error('opening_date'); ?>, 
			<?php echo form_error('closing_date'); ?>
		</td>
	</tr>
	<tr>
		<td>Enter the text shown in the image*</td>
		<td><?php echo $this->recaptcha->recaptcha_get_html($this->config->item('recaptcha_public_key'), $recaptcha_error); ?></td>
		<td class="error" width="25%">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" class="info">* - mandatory fields</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<button type="submit">Submit</button>
			<button type="button" onclick="cancel();">Cancel</button>
		</td>
	</tr>
</table>
</form>
</div>
<div class="clear"></div>
</div>
<!-- END BODY -->