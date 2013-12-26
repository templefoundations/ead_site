<style>
#tabs {
	padding-top: 20px;
}

#appln_forms a {
	font-size: 16px;
}
</style>

<div id="thin_body">

<div id="tabs">
<ul>
	<li class="current_selection"><a
		href="<?php echo site_url('info/registered_courses'); ?>">List of
	Application forms</a></li>
	<li><a href="<?php echo site_url('info/institutions'); ?>">List of
	Colleges</a></li>
	<li><a href="<?php echo site_url('info/courses'); ?>">List of Courses</a></li>
</ul>
</div>

<h2>Application forms (<?php echo $total_reg_courses; ?>)</h2>
<div id="appln_forms"><?php
$pagenav = $this->pagination->create_links();
echo $pagenav;
?>

<div id="available_applns"><?php if (!empty($active_applns) || $total_reg_courses==0): ?>
<h3>Available applications</h3>

<?php if ($total_reg_courses == 0): ?>
<div class="desc">No application available now ...</div>

<?php else:
foreach ($active_applns as $active_item):
?>
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
<?php endforeach; ?> <?php endif; ?> <?php endif; ?>
</div>

<div id="to_open_applns"><?php if (!empty($to_open_applns)): ?>
<h3>Applications opening soon:</h3>
<?php
foreach ($to_open_applns as $item):
?>
<div id="search_item" class="passive_box rounded">
<table width="100%" border="0">
	<tr>
		<td width="10%" nowrap="nowrap">Course:</td>
		<td width="64%">&nbsp; <a
			href="<?php echo site_url('info/course/'.$item['course']->get_name());?>">
			<?php echo $item['course']->get_name();?> </a></td>
		<td width="22%" rowspan="2"></td>
	</tr>
	<tr>
		<td>College:</td>
		<td>&nbsp; <a
			href="<?php echo site_url('info/institution/'.$item['inst']->get_name());?>">
			<?php echo $item['inst']->get_name();?> </a></td>
	</tr>
	<tr>
		<td>University:</td>
		<td>&nbsp;<a href=""><?php echo $item['inst']->get_university();?></a></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Last Date</td>
		<td>&nbsp;<b>March 15, 2011</b></td>
		<td><a href="">read more &gt;&gt;</a></td>
	</tr>
</table>
</div>
<?php endforeach; ?> <?php endif; ?></div>

</div>

</div>
