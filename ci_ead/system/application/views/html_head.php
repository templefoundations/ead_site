<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="KEYWORDS" content="Admissions, Admission, eAdmission, e-Admission, online-admission, online admission,
	College, Institution, Engineering, Engineering college, Medical, Medical College, Bussiness College, Management Institution,
	Course, Program, Engineering, BE, BTech, B.E., B.Tech, MBBS, Nursing, MBA,
	Application form, Application, Applications, Online payment, College enquiry, College search, Course search, search">
<meta name="DESCRIPTION" content="eAdmissions.in is an online service provider that aims at enabling users to be able to 
	fill application forms for different colleges across the nation on an online basis. In eAdmissions.in, we take the students 
	one step closer to the colleges of their dream and also make the task of colleges reaching out to the students simpler. 
	eAdmissions.in provides a platform where one can find the application forms for all colleges, hence saving your time spent on 
	searching and applying for the courses of your interest.">
<meta name="CLASSIFICATION" content="Admissions, College, Institution, Course, Program, Application form, Online">
<meta name="COPYRIGHT" content="Templefoundations.com">

<title>eAdmissions - <?php echo $title;?></title>
<?php
// Link all css files
if (isset($css_list))
{
	foreach ($css_list as $cssfile) : ?>
	<link  href="<?php echo $cssfile; ?>" rel="stylesheet" type="text/css" />
	<?php endforeach; 
}

// Include all js files
if (isset($js_list))
{
	foreach ($js_list as $jsfile) : ?>
	<script src="<?php echo $jsfile; ?>" type="text/javascript" ></script>
	<?php endforeach; 
}?>
</head>