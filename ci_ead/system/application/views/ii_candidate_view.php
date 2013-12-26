<div id="thin_body" align="center">
<div id="print_body" align="center">
<div id="controls">
<div align="left" style="float: left">
	<a href="<?php echo site_url('ii_course/index/'.$reg_course_id); ?>">&lt;&lt;Back to Course Page</a>
</div>
<div align="right"><a href="#">Print</a></div>
</div>
<h2>PSG College of Technology</h2>
<h3>Application for <?php echo $course_name; ?></h3>
<?php
foreach ($tables as $table)
{
	echo $table;
	echo "<br />";
} 
?>
<!--<table>
	<tr>
		<td colspan="2"><strong>Attached Certificates</strong></td>
		<td width="61%" colspan="3"><a href="#">Download All</a></td>
	</tr>
	<tr>
		<td width="22%">Birth Certificate</td>
		<td width="17%"><img src="images/certificate.jpg" width="100"
			height="100" border="1" /></td>
		<td><a href="#">View</a> / <a href="#">Download</a></td>
	</tr>
	<tr>
		<td>Community Certificate</td>
		<td><img src="images/certificate.jpg" width="100" height="100"
			border="1" /></td>
		<td><a href="#">View</a> / <a href="#">Download</a></td>
	</tr>
	<tr>
		<td>Marks Certificate</td>
		<td><img src="images/certificate.jpg" width="100" height="100"
			border="1" /></td>
		<td><a href="#">View</a> / <a href="#">Download</a></td>
	</tr>
</table>
--></div>
</div>
