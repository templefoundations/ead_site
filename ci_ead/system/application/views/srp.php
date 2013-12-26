<style>
#search_results {
	min-height: 400px;
}
#search_item {
	padding:5px;
	border:1px #CCC solid;
	margin-bottom:20px;
	font-size: 15px;
}
#search_item a {
	font-size: 15px;
}
.desc {
	font-size: 12px;
	color: #666;
	margin-left: 20px;
	margin-bottom: 15px;
	padding: 5px;
}
#college_filters, #course_filters {
	width: 45%;
	padding: 10px;
	height: 160px;
}
#college_filters {
	float: left;
}
#course_filters {
	float: right;
}
</style>

<div id="thin_body">

<h2>Advanced Search</h2>
<form name="search_form" action="<?php echo site_url('search/submit'); ?>" method="post">
<div id="college_filters">
<h3>College selection options</h3><br>
<table width="95%">
<tr>
	<td>College Name contains</td> 
	<td><input type="text" class="textbox" name="inst_name" title="college" value="<?php echo $this->input->post('inst_name'); ?>" /></td>
</tr>
<tr>
	<td>University</td> 
	<td><select name="university">
		<option value="">-- Any --</option>
	<?php 
		foreach ($search_options['inst_universities'] as $value):
			if (!empty($value))
				echo '<option value="'.$value.'">'.$value.'</option>';
		endforeach; 
	?>
	</select></td>
</tr>
<tr>
	<td>Type</td> 
	<td><select name="inst_type">
		<option value="">-- Any --</option>
	<?php 
		foreach ($search_options['inst_types'] as $value):
			if (!empty($value))
				echo '<option value="'.$value.'">'.$value.'</option>';
		endforeach; 
	?>
	</select></td>
</tr>
<tr>
	<td>Category</td>
	<td><select name="inst_category">
		<option value="">-- Any --</option>
	<?php 
		foreach ($search_options['inst_categories'] as $value):
			if (!empty($value))
				echo '<option value="'.$value.'">'.$value.'</option>';
		endforeach; 
	?>
	</select></td>
</tr>
</table>
</div>

<div id="course_filters">
<h3>Course selection options</h3><br>
<table width="95%">
<tr>
	<td>Course name contains</td> 
	<td><input type="text" class="textbox" name="course_name" title="college" value="<?php echo $this->input->post('course_name'); ?>" /></td>
</tr>
<tr>
	<td>Graduation</td>
	<td><select name="graduation">
		<option value="">-- Any --</option>
	<?php 
		foreach ($search_options['course_graduations'] as $value):
			if (!empty($value))
				echo '<option value="'.$value.'">'.$value.'</option>';
		endforeach; 
	?>
	</select></td>
</tr>
<tr>
	<td>Category</td>
	<td><select name="course_category">
		<option value="">-- Any --</option>
	<?php 
		foreach ($search_options['course_categories'] as $value):
			if (!empty($value))
				echo '<option value="'.$value.'">'.$value.'</option>';
		endforeach; 
	?>
	</select></td>
</tr>
</table>
</div>

<div align="center"><button type="submit" title="Search">Search</button></div>
</form>

<?php if(isset($show_result)): ?>
<div id="search_results">
<h2>Search Results</h2>

<div id="tabs">
<ul>
	<li <?php if($show_appln_forms) echo 'class="current_selection"'; ?>>
		<a href="<?php echo site_url('search/appln_forms#search_results'); ?>">Application forms (<?php echo $total_appln_forms; ?>)</a>
	</li>
	<li <?php if($show_insts) echo 'class="current_selection"'; ?>>
		<a href="<?php echo site_url('search/institutions#search_results'); ?>">Colleges (<?php echo $total_insts; ?>)</a>
	</li>
	<li <?php if($show_courses) echo 'class="current_selection"'; ?>>
		<a href="<?php echo site_url('search/courses#search_results'); ?>">Courses (<?php echo $total_courses; ?>)</a>
	</li>
</ul>
</div>

<?php
echo $this->pagination->create_links();

// Application forms Tab 
if($show_appln_forms==true):
	if ($total_appln_forms == 0): ?>
	<div class="desc">No applications available now ...</div>
<?php 
	else:
	foreach ($appln_forms['active'] as $active_item): ?>
	<div id="search_item" class="active_box rounded">
	<table width="100%" border="0">
	<tr>
		<td width="10%" nowrap="nowrap">Course:</td>
		<td width="64%">&nbsp; <a
			href="<?php echo site_url('info/course/'.$active_item['course']->get_name());?>">
			<?php echo $active_item['course']->get_name();?> </a></td>
		<td width="22%" rowspan="2"><a
			href="<?php echo site_url('online_form/index/'.$active_item['appln_form']->get_id()); ?>"
			class="button"> Apply now </a></td>
	</tr>
	<tr>
		<td>College:</td>
		<td>&nbsp; <a
			href="<?php echo site_url('info/institution/'.$active_item['inst']->get_name());?>">
			<?php echo $active_item['inst']->get_name();?> </a></td>
	</tr>
	<tr>
		<td>University:</td>
		<td>&nbsp;<a href=""><?php echo $active_item['inst']->get_university();?></a></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Last Date</td>
		<td>&nbsp;<b>March 15, 2011</b></td>
		<td><a href="">read more &gt;&gt;</a></td>
	</tr>
	</table>
	</div>
<?php
	endforeach;
	endif; 
?>

<?php
// Colleges Tab 
elseif ($show_insts==true): 
	if ($total_insts == 0): ?>
	<div class="desc">No Colleges found for your search criteria ...</div>
<?php 
	else: ?>
	<table id="list_tbl" width="100%" align="center" cellpadding="5" cellspacing="7">
	<tr id="tbl_head">
		<th>College Name</th>
		<th>Affiliated to</th>
		<th>Type</th>
		<th>Category</th>
	</tr>
	<?php
	foreach ($insts as $inst):
	?>
		<tr>
			<td width="35%"><a
				href="<?php echo site_url('info/institution/'.$inst->get_id()); ?>">
				<?php echo $inst->get_name(); ?> </a></td>
			<td><?php echo $inst->get_university(); ?></td>
			<td><?php echo $inst->get_type(); ?></td>
			<td><?php echo $inst->get_category(); ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
<?php endif;

// Courses Tab
elseif ($show_courses==true): 
	if ($total_courses == 0): ?>
	<div class="desc">No Courses found for your search criteria ...</div>
<?php 
	else: ?>
	<table id="list_tbl" width="100%" align="center" cellpadding="5" cellspacing="5">
	<tr id="tbl_head">
		<th>Course name</th>
		<th>Duration</th>
		<th>Graduation</th>
		<th>Category</th>
	</tr>
	<?php
	foreach ($courses as $course):
	?>
		<tr>
			<td width="30%"><a
				href="<?php echo site_url('info/course/'.$course->get_id()); ?>"> <?php echo $course->get_name(); ?>
			</a></td>
			<td><?php echo $course->get_duration(); ?></td>
			<td><?php echo $course->get_graduation(); ?></td>
			<td><?php echo $course->get_category(); ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
	
<?php
	endif;

endif; ?>

</div> <!-- END SEARCH_RESULTS -->
<?php endif; ?>

</div> <!-- END BODY -->