<style>
#courses, #courses a {
	font-size: 14px;
}
</style>

<div id="thin_body">

<div id="tabs">
<ul>
	<li><a href="<?php echo site_url('info/registered_courses'); ?>">List of Application forms</a></li>
	<li class="current_selection"><a href="<?php echo site_url('info/institutions'); ?>">List of Colleges</a></li>
	<li><a href="<?php echo site_url('info/courses'); ?>">List of Courses</a></li>
</ul>
</div>

<div id="courses">
<h2>Colleges (<?php echo $total_insts; ?>)</h2>

<?php echo $this->pagination->create_links(); ?>

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
</div>

</div>
