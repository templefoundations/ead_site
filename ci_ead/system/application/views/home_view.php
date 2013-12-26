<style>
button.big_btn, .big_btn {
	height: 100px;
	font-size: 28px;
	color: #E60000 !important;
}

#site_desc {
	padding: 10px;
	margin-top: 20px;
}
#site_desc img {
	padding: 5px;
	margin-right: 10px;
}
#site_desc p {
	font-family: serif;
	font-size: 16px;
	text-align: justify;
	letter-spacing: 1px;
	line-height: 6mm;
	text-indent: 50px;
}

#home_appln_details, #featured_colleges, #featured_courses {
	margin-top: 20px;
	margin-bottom: 20px;
	padding: 15px;
}
#home_appln_details a {
	font-size: 16px;
}
#home_appln_details h2 {
	margin-top: 0px;
}
#home_active_appln {
	margin-bottom: 20px;
}

#news {
	margin: 10px;
}
#news h2 {
	text-align: center;
}
#news-container {
	border: 1px solid #CCC;
	background: #fCfCfC;
}
#news-container ul li div {
	border-top: 1px solid #CCC;
	padding: 4px;
	font-family: serif;
	font-size: 14px;
}
.left_box, right_box {
	font-size: 14px;
}
</style>
<script type="text/javascript"> 
$(function(){
	$('#news-container').vTicker({ 
		speed: 700,
		pause: 2000,
		animation: 'fade',
		mousePause: true,
		showItems: 4
	});
});
</script> 

<?php  $this->load->view('search_form'); ?>
<div id="thin_body">
<div id="mainbar">

<div id="site_desc" class="white_box rounded">
<img src="<?php echo $this->config->item('images_path').'site_desc.jpg'; ?>" alt="Admissions online" 
	width="200" align="left" />
<p><a href="">eAdmissions.in</a> is an online service provider that aims at enabling users to be able to fill application
 forms for different colleges across the nation on an online basis. In eAdmissions.in, we take the students one step closer to the
 colleges of their dream and also make the task of colleges reaching out to the students simpler. eAdmissions.in provides a
 platform where one can find the application forms for all colleges, hence saving your time spent on searching and applying 
 for the courses of your interest.</p>
<p>eAdmissions.in is the only triumphant website which provides you the facility of filling applications forms for various 
colleges and paying for them online. At eAdmissions.in, with three steps the whole of admissions can be completed. </p>
</div>

<div id="home_appln_details" class="white_box rounded">
<div id="home_active_appln">
<h2>Available Applications</h2>
<div class="info">No application available now ..</div>
<!--<div class="active_box rounded">
<table width="100%" border="0">
	<tr>
		<td width="14%">Course:</td>
		<td width="64%">&nbsp;<a href="<?php echo site_url('info/course/MSc Software Engineering');?>">MSc Software Engineering</a></td>
		<td width="22%" rowspan="2"><a href="<?php echo site_url('online_form/index/2');?>" class="button">Apply NOW</a></td>
	</tr>
	<tr>
		<td>College:</td>
		<td>&nbsp;<a href="<?php echo site_url('info/institution/PSG College of Technology');?>">PSG College of Technology</a></td>
	</tr>
	<tr>
		<td>University:</td>
		<td>&nbsp;<a href="">Anna University of Technology, Coimbatore</a></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Last Date</td>
		<td><b>March 15, 2011</b></td>
		<td><a href="">read more &gt;&gt;</a></td>
	</tr>
</table>
</div>
<div class="active_box rounded">
<table width="100%" border="0">
	<tr>
		<td width="14%">Course:</td>
		<td width="64%">&nbsp;<a href="<?php echo site_url('info/course/MSc Theoretical Computer Science');?>">MSc Theoretical Computer Science</a></td>
		<td width="22%" rowspan="2"><a href="" class="button">Apply NOW</a></td>
	</tr>
	<tr>
		<td>College:</td>
		<td>&nbsp;<a href="<?php echo site_url('info/institution/PSG College of Technology');?>">PSG College of Technology</a></td>
	</tr>
	<tr>
		<td>University:</td>
		<td>&nbsp;<a href="">Anna University of Technology, Coimbatore</a></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Last Date</td>
		<td><b>March 15, 2011</b></td>
		<td><a href="">read more &gt;&gt;</a></td>
	</tr>
</table>
</div>
<div><a href="<?php echo site_url('info/registered_courses').'#available_applns'; ?>">View all &gt;&gt;</a></div>
</div>
<div id="home_active_appln">
<h2>Applications opening soon</h2>
<div class="passive_box rounded">
<table width="100%" border="0">
	<tr>
		<td width="21%">Course:</td>
		<td width="57%">&nbsp;<a href="<?php echo site_url('info/course/MCA');?>">MCA</a></td>
		<td width="22%">&nbsp;</td>
	</tr>
	<tr>
		<td>College:</td>
		<td>&nbsp;<a href="<?php echo site_url('info/institution/PSG College of Technology');?>">PSG College of Technology</a></td>
		<td width="22%">&nbsp;</td>
	</tr>
	<tr>
		<td>University:</td>
		<td>&nbsp;<a href="">Anna University of Technolgy, Coimbatore</a></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Application open</td>
		<td>from <b>March 15,2011</b> to <b>April 10,2011</b></td>
		<td><a href="">read more &gt;&gt;</a></td>
	</tr>
</table>
</div>-->
<!--<div><a href="<?php echo site_url('info/registered_courses').'#to_open_applns'; ?>">View all &gt;&gt;</a></div>
-->
</div>
<!--<div>
<h1><a href="<?php echo site_url('info/institutions'); ?>">View all Courses &amp; Colleges &gt;&gt;</a></h1>
</div>-->
</div> <!-- END APPLN_FORMS -->

<div id="featured_colleges" class="white_box rounded" style="height:auto;">
<h2>Featured Colleges</h2>

<div id="engg_colleges">
<h3>Engineering Colleges</h3>
<table width="100%" cellpadding="5" cellspacing="0" border="0" class="white_box rounded">
<tr>
	<td><a href="<?php echo site_url('info/institution/141'); ?>">P.S.G College of Technology</a></td>
	<td rowspan="4" width="15%" align="right">
	<img src="<?php echo $this->config->item('images_path'); ?>symbol_engg_coll.jpg" width="100" height="100" />
	</td>
</tr>
<tr>
	<td><a href="<?php echo site_url('info/institution/1862'); ?>">VIT University (Vellore Institute of Technology</a></td>
</tr>
<tr>
	<td><a href="<?php echo site_url('info/institution/36'); ?>">Coimbatore Institute of Technology</a></td>
</tr>
<tr>
	<td><a href="<?php echo site_url('info/institution/11'); ?>">Amrita Vishwa Vidyapeetham University (Amrita School of Engineering)</a></td>
</tr>
<tr>
	<td><a href="<?php echo site_url('info/institutions'); ?>">View all &gt;&gt;</a></td>
</tr>
</table>
</div>

<div id="medical_colleges" class="right_box rounded">
<h3>Medical Colleges</h3>
<table width="100%" cellpadding="5" cellspacing="0" border="0" class="white_box rounded">
<tr>
	<td><a href="<?php echo site_url('info/institution/807'); ?>">Chettinad University (Chettinad Hospital and Research Institute)</a></td>
	<td rowspan="4" width="15%" align="right">
	<img src="<?php echo $this->config->item('images_path'); ?>symbol_medical_coll.jpg" width="100" height="100" />
	</td>
</tr>
<tr>
	<td><a href="<?php echo site_url('info/institution/817'); ?>">P.S.G. Institute of Medical Sciences and Research</a></td>
</tr>
<tr>
	<td><a href="<?php echo site_url('info/institution/808'); ?>">Christian Medical College</a></td>
</tr>
<tr>
	<td><a href="<?php echo site_url('info/institution/813'); ?>">Madras Medical College and Research Institute</a></td>
</tr>
<tr>
	<td><a href="<?php echo site_url('info/institutions'); ?>">View all &gt;&gt;</a></td>
</tr>
</table>
</div>

<div><a href="<?php echo site_url('info/institutions'); ?>">View all &gt;&gt;</a></div>
</div> <!-- END FEATURED COLLEGES -->

<div id="featured_courses" class="white_box rounded" style="height:auto;">
<h2>Featured Courses</h2>

<div id="engg_courses">
<h3>Engineering Courses</h3>
<table width="100%" cellpadding="5" cellspacing="0" border="0" class="white_box rounded">
<tr>
	<td><a href="<?php echo site_url('info/course/361'); ?>">MSc Software Engineering (Integrated)</a></td>
	<td rowspan="3" width="15%" align="right">
	<img src="<?php echo $this->config->item('images_path'); ?>symbol_engg_sw.png" width="75" height="75" />
	</td>
</tr>
<tr>
	<td><a href="<?php echo site_url('info/course/167'); ?>">MSc Theoritical Computer Science (Integrated)</a></td>
</tr>
<tr>
	<td><a href="<?php echo site_url('info/course/125'); ?>">ME VLSI Design</a></td>
</tr>
<tr>
	<td><a href="<?php echo site_url('info/courses/engineering'); ?>">View all &gt;&gt;</a></td>
</tr>
</table>
</div>

<div id="medical_courses">
<h3>Medical Courses</h3>
<table width="100%" cellpadding="5" cellspacing="0" border="0" class="white_box rounded">
<tr>
	<td><a href="<?php echo site_url('info/course/172'); ?>">MBBS Medicine and Surgery</a></td>
	<td rowspan="3" width="15%" align="right">
	<img src="<?php echo $this->config->item('images_path'); ?>symbol_medical.jpg" width="75" height="75" />
	</td>
</tr>
<tr>
	<td><a href="<?php echo site_url('info/course/177'); ?>">MD Forensic Medicine</a></td>
</tr>
<tr>
	<td><a href="<?php echo site_url('info/course/194'); ?>">MS ENT</a></td>
</tr>
<tr>
	<td><a href="<?php echo site_url('info/courses/medicine'); ?>">View all &gt;&gt;</a></td>
</tr>
</table>
</div>

<div id="nursing_courses">
<h3>Management Courses</h3>
<table width="100%" cellpadding="5" cellspacing="0" border="0" class="white_box rounded">
<tr>
	<td><a href="<?php echo site_url('info/course/433'); ?>">MBA Business Administration</a></td>
	<td rowspan="3" width="15%" align="right">
	<img src="<?php echo $this->config->item('images_path'); ?>symbol_mgt.jpg" width="75" height="75" />
	</td>
</tr>
<tr>
	<td><a href="<?php echo site_url('info/course/435'); ?>">PGPM Post Graduate Programme in Management</a></td>
</tr>
<tr>
	<td><a href="<?php echo site_url('info/course/280'); ?>">BBA Business Administration</a></td>
</tr>
<tr>
	<td><a href="<?php echo site_url('info/courses/management'); ?>">View all &gt;&gt;</a></td>
</tr>
</table>
</div>

<div><a href="<?php echo site_url('info/courses'); ?>">View all &gt;&gt;</a></div>
</div> <!-- END FEATURED COURSES -->

</div> <!-- END MAIN BAR -->

<div id="sidebar">
<div id="news">
<h2>Recent Updates</h2>
<div id="news-container" class="rounded">
<ul>
	<li>
	<div>Site is available for alpha testing</div>
	</li>
	<li>
	<div>Information of more than 3500 colleges available</div>
	</li>
	<li>
	<div>Information of more than 500 courses updated</div>
	</li>
	<li>
	<div>Register your college now with eAdmissions.in</div>
	</li>
</ul>
</div>
<!--<div align="right"><a href="#">View all &gt;&gt;</a></div>
--></div>
</div> <!-- END SIDE BAR -->

</div> <!-- END BODY -->
