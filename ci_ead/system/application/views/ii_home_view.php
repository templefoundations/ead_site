<style>
.lastcol {
	text-align: right;
}
</style>

<div id="thin_body">
<table width="100%">
	<tr>
		<td>
		<h2>Courses registered (<?php echo $data['courses_count']; ?>)</h2>
		</td>
		<td width="20%" class="lastcol">
			<a href="<?php echo site_url('ii_course_registration'); ?>" class="button" 
			title="Click here to post your applications online">Register a Course</a>
		</td>
	</tr>
</table>


<div id="course_list">
<?php
	for ($i=0; $i<$data['courses_count']; $i++): 
?>
<div id="course_item_<?php echo $data[$i]['status']; ?>" class="rounded">
<table width="100%">
	<tr>
		<td height="25" colspan="2">
			<span class="course_name">
			<a href="<?php
			if ($data[$i]['status']!='passive'):
			 	echo site_url('ii_course/index/'.$data[$i]['reg_course_id']);
			 else:
			 	 echo site_url('ii_course/manage/'.$data[$i]['reg_course_id']);
			 endif;
			 ?>">
				<?php echo $data[$i]['course_name']; ?>
			</a>
			</span>
		</td>
		<td width="10%" class="lastcol"><?php echo $data[$i]['status']; ?></td>
	</tr>
	<tr>
		<td height="25" colspan="2">
			<span class="status_spec">
<!--	open from <b><?php //echo $data[$i]['opening_date']; ?></b> to <b><?php //echo $data[$i]['closing_date']; ?></b>	-->
				<?php echo $data[$i]['status_desc']; ?>
			</span></td>
		<td class="lastcol">&nbsp;</td>
	</tr>
	<tr>
		<td height="25">&nbsp;
	<?php if ($data[$i]['status']!='passive'): ?>
		<span class="highlight"><b><?php echo $data[$i]['candidates_count']; ?></b> Candidates applied
		Online</span>
	<?php endif; ?>
		</td>
		<td width="45%" colspan="2" class="lastcol">
		<?php if ($data[$i]['status']!='passive'): ?>
			<a href="<?php echo site_url('ii_course/index/'.$data[$i]['reg_course_id']); ?>">View Activity</a> |
		<?php endif; ?> 
			<a href="<?php echo site_url('ii_course/manage/'.$data[$i]['reg_course_id']); ?>">Manage</a> 
		<?php if ($data[$i]['status']!='passive'): ?>
			| <a href="<?php echo site_url('ii_course/download_all/'.$data[$i]['reg_course_id']); ?>">Download all Applications</a>
		<?php endif; ?>
		</td>
	</tr>
</table>
</div>
<?php endfor; ?>

</div>

<div class="clear"></div>
</div>

<div class="clear"></div>