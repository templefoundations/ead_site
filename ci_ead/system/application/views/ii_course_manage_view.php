<style>
<!--
textarea {
	width:75%;
}
-->
</style>

<script type="text/javascript">
function cancel() {
	location.href = "<?php echo site_url('ii_course/index/'.$reg_course_id); ?>";
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
<div id="course_heading">
<h2>Course: <?php echo $course_name; ?></h2>
</div>
<!--<div id="course_body">-->
<div id="tabs">
<ul>
	<li><a href="<?php echo site_url('ii_course/index/'.$reg_course_id); ?>">Activity</a></li>
	<li class="current_selection"><a href="">Manage</a></li>
</ul>
</div>
<div id="manage_tab" align="center">
<form method="post" action="<?php echo site_url('ii_course/manage_submit/'.$reg_course_id); ?>" enctype="multipart/form-data">
<table>
	<tr>
		<td colspan="2">Description of this Course in your College</td>
		<td class="error" width="25%"><?php echo form_error('desc'); ?></td>
	</tr>
	<tr>
		<td colspan="3"><textarea name="desc" cols="100" rows="5"><?php echo $data['desc']; ?></textarea></td>
	</tr>
	<tr>
		<td width="182">Upload New Application Form</td>
		<td width="488">
			<input type="file" name="form_file" class="textbox file" size="50" />
		</td>
		<td class="error" width="25%"><?php echo $file_error; ?></td>
	</tr>
	<tr>
		<td height="50" colspan="3"><span class="info">Uploaded Application
		form will be processed soon and we will notify you back</span></td>
	</tr>
	<tr>
		<td>Applications open</td>
		<td> 
			from <input type="text" name="opening_date" id="opening_date" value="<?php echo $data['opening_date']; ?>" />  
			to <input type="text" name="closing_date" id="closing_date" value="<?php echo $data['closing_date']; ?>" />
		</td>
		<td class="error" width="25%">
			<?php echo form_error('opening_date'); ?>, 
			<?php echo form_error('closing_date'); ?>
		</td>
	</tr>
	<tr>
		<td>Application form price</td>
		<td>Rs. <input type="text" name="price" size="6" value="<?php echo $data['price']; ?>" /></td>
		<td class="error" width="25%"><?php echo form_error('price'); ?></td>
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
</div><!-- END TAB CONTENT -->
<!--</div> END CONTENT BODY -->
<div class="clear"></div>
</div>