<style>
input.textbox {
	width:75px;
	padding: 4px;
}
select {
	width: 150px;
}
</style>

<script>
$(function() {
	var dates = $( "#applied_date_from, #applied_date_to" ).datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		gotoCurrent: true,
		numberOfMonths: 2,
		maxDate: 'today',
		onSelect: function( selectedDate ) {
			var option = this.id == "applied_date_from" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" );
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
});
</script>

<div id="thin_body">
<div id="course_heading">
<h2>Course: <?php echo $course_name; ?></h2>
</div>
<div id="course_body">
<div id="tabs">
<ul>
	<li class="current_selection"><a href="<?php echo site_url('ii_course/index/'.$reg_course_id); ?>">Activity</a></li>
	<li><a href="<?php echo site_url('ii_course/manage/'.$reg_course_id); ?>">Manage</a></li>
</ul>
</div>

<div id="tab_content">

<!-- FILTERS -->
<div id="filters">
<form action="<?php echo site_url('ii_course/filter/'.$reg_course_id); ?>" method="post">
<h2>Filters</h2>
<table width="99%">
	<tr>
		<td>
		<div id="heading">Applied Date</div>
		<span id="content"> 
			<input type="text" class="textbox small" name="applied_date_from" id="applied_date_from" maxlength="10" value="<?php echo set_value('applied_date_from'); ?>" readonly="readonly" /> to 
			<input type="text" class="textbox small" name="applied_date_to" id="applied_date_to"  maxlength="10" value="<?php echo set_value('applied_date_to'); ?>" readonly="readonly" /> 
		</span></td>
	</tr>
	<tr>
		<td>
		<div id="heading">Age</div>
		<span id="content">
			<input type="text" class="textbox small" name="age_from" maxlength="2" value="<?php echo set_value('age_from'); ?>" /> to 
			<input type="text" class="textbox small" name="age_to" maxlength="2" value="<?php echo set_value('age_to'); ?>" /> 
		</span></td>
	</tr>
	<tr>
		<td>
		<div id="heading">Location</div>
		<span id="content"> 
		<select name="location">
			<option value="" selected="selected">--All Locations--</option>
			<option value="Coimbatore" <?php echo set_select('location','Coimbatore'); ?>>Coimbatore</option>
			<option value="Nagercoil" <?php echo set_select('location','Nagercoil'); ?>>Nagercoil</option>
			<option value="Madurai" <?php echo set_select('location','Madurai'); ?>>Madurai</option>
			<option value="Chennai" <?php echo set_select('location','Chennai'); ?>>Chennai</option>
			<option value="Bangalore" <?php echo set_select('location','Bangalore'); ?>>Bangalore</option>
		</select> 
		</span></td>
	</tr>
	<tr>
		<td align="center">
		<button>Filter</button>
		</td>
	</tr>
</table>
</form>
</div>
<!-- END FILTERS -->

<div id="candidates">
<div id="controls">
	<a href="<?php echo site_url('ii_course/download_all/'.$reg_course_id); ?>">Download all Applications 
	(<?php echo $total_candidates; ?>)</a>
</div>
<?php
	echo $this->pagination->create_links();
	
	foreach ($data as $candidate): ?>
<div id="candidate" class="rounded">
<table width="100%">
	<tr>
		<td width="8%">Name</td>
		<td width="21%">
			<!--<a href="<?php echo site_url('ii_candidate/index/'.$candidate['candidate_id']); ?>">  -->
			<strong><?php echo $candidate['name']; ?></strong><!--  </a>  -->
		</td>
		<td width="13%">Father's Name</td>
		<td width="28%"><strong><?php echo $candidate['father_name']; ?></strong></td>
		<td width="10%">Appln Number</td>
		<td width="20%"><span class="mode"><strong><?php echo $candidate['application_number']; ?></strong></span></td>
	</tr>
	<tr>
		<td>Location</td>
		<td height="25"><strong><?php echo $candidate['location']; ?></strong></td>
		<td height="25">Date of Birth</td>
		<td height="25"><strong><?php echo $candidate['date_of_birth']; ?></strong></td>
		<td>BILL ID</td>
		<td><strong><?php echo $candidate['bill_number']; ?></strong></td>
	</tr>
	<tr>
		<td>Email ID</td>
		<td colspan="3"><strong><?php echo $candidate['email_id']; ?></strong></td>
		<td>&nbsp;</td>
		<td align="right"><a href="<?php echo site_url('ii_course/download/'.$candidate['candidate_id']); ?>">Download PDF</a></td>
	</tr>
</table>
</div>
<?php endforeach; ?>

</div><!-- END CANDIDATES -->
</div><!-- END TAB CONTENT --> 

</div><!-- END CONTENT BODY -->
<div class="clear"></div>
</div>
