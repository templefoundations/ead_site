<div id="thin_body">
<h2>
	<a href="<?php echo site_url('info/institutions'); ?>">Colleges</a> &gt; 
	<?php echo $inst->get_name(); ?>
</h2>
<h3>General Informations</h3>
<div id="coll_info">
<table width="90%" align="center">
	<tr>
		<td>Affiliated to</td>
		<td><?php echo $inst->get_university(); ?></td>
	</tr>
	<tr>
		<td>Established Year</td>
		<td><?php echo $inst->get_established_year(); ?></td>
	</tr>
	<tr>
		<td>Type</td>
		<td><?php echo $inst->get_type(); ?></td>
	</tr>
	<tr>
		<td>Category</td>
		<td><?php echo $inst->get_category(); ?></td>
	</tr>
	<tr>
		<td>District</td>
		<td><?php echo $inst->get_district(); ?></td>
	</tr>
	<tr>
		<td>State</td>
		<td><?php echo $inst->get_state(); ?></td>
	</tr>
	<tr>
		<td>Address</td>
		<td><?php echo $inst->get_address();?></td>
	</tr>
	<tr>
		<td>Phone Numbers</td>
		<td><?php echo $inst->get_phone_numbers(); ?></td>
	</tr>
	<tr>
		<td>Contact Email Address</td>
		<td><?php echo $inst->get_email_address(); ?></td>
	</tr>
	<!--<tr>
        	  <td>Rank in India</td>
        	  <td>19</td>
      	  </tr>-->
</table>
</div>
<!--<h3>College Description</h3>
    <div id="desc">
   	  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vel nunc in nunc aliquet rhoncus. Vivamus tortor magna, faucibus eu aliquam in, fringilla in risus. Vestibulum diam purus, mollis at condimentum nec, cursus id eros. Phasellus ut sapien lectus. Nunc sit amet tellus est. Praesent vel dui eros, in rhoncus nibh. Etiam gravida, velit at posuere commodo, lacus justo cursus erat, nec fringilla lorem felis a ligula. Praesent nunc quam, suscipit a aliquam et, ornare et risus. Donec rhoncus, sapien vitae interdum luctus, erat odio congue tellus, vitae aliquet nisi odio sit amet augue. Morbi mollis porta tincidunt. Cras at urna ac ligula fringilla rhoncus. </p>    
    </div>
    -->
<h3>Courses Offered</h3>
<div id="courses">
<table width="100%" align="center">
<tr id="tbl_head">
	<th>Course name</th>
	<th>Duration</th>
	<th>Graduation</th>
	<th>Category</th>
</tr>
<?php
$courses = $inst->get_offered_courses();
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

</div> <!-- END BODY -->