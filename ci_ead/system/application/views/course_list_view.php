<div id="thin_body">

<div id="tabs">
<ul>
	<li><a href="<?php echo site_url('info/registered_courses'); ?>">List of Application forms</a></li>
	<li><a href="<?php echo site_url('info/institutions'); ?>">List of Colleges</a></li>
	<li class="current_selection"><a href="<?php echo site_url('info/courses'); ?>">List of Courses</a></li>
</ul>
</div>

<div id="courses">
<h2>Courses (<?php echo $total_courses; ?>)</h2>

<?php echo $this->pagination->create_links(); ?>

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
</div>

</div>
