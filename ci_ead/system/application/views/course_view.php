<div id="thin_body">
<h2>
	<a href="<?php echo site_url('info/courses'); ?>">Courses</a> &gt; 
	<?php echo $course->get_name(); ?>
</h2>

<h3>General Informations</h3>
<div id="coll_info">
<table width="90%" align="center">
	<tr>
		<td width="23%">Duration</td>
		<td width="77%"><?php echo $course->get_duration(); ?></td>
	</tr>
	<tr>
		<td>Graduation</td>
		<td><?php echo $course->get_graduation(); ?></td>
	</tr>
	<tr>
		<td>Group</td>
		<td><?php echo $course->get_category(); ?></td>
	</tr>
	<tr>
		<td>Sub Group</td>
		<td><?php echo $course->get_sub_category(); ?></td>
	</tr>
	<tr>
		<td>Qualification degree</td>
		<td><?php echo $course->get_qualification_degree(); ?></td>
	</tr>
</table>
</div>

<?php if ($course->get_desc() != 'NA'): ?>
<h3>Course Description</h3>
<div id="desc">
<p><?php echo $course->get_desc(); ?></p>
</div>
<?php endif; ?>

<h3>Offering colleges</h3>
<div id="courses">
<table width="100%" align="center">
<tr id="tbl_head">
	<th>College Name</th>
	<th>Affiliated to</th>
	<th>Type</th>
	<th>Category</th>
</tr>
<?php
$insts = $course->get_offering_insts();
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
</div>
</div>
