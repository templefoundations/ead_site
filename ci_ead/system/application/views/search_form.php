<style>
input.textbox { border:0px; }
#search label, #search span {
	color:#FFF;
	font-family:"Segoe UI";
	font-size:24px;
	text-transform:none;
}
#search span {
	color:#FFF;
	font-weight:bold;
	font-size:36px;
}
#search span label {
	font-size:16px;
}
</style>

<div class="hbg">
<div  id="search">
<form id="search_form" name="search_form" action="<?php echo site_url('search/submit'); ?>" method="post">
<table border="0" width="100%">
	<tr>
    	<td width="13%"><img src="<?php echo $this->config->item('images_path');?>search.png" /></td>
        <td width="23%"><span>Search<br /><label>by college or course</label></span></td>
	    <td width="64%">
        <table width="75%">
        <tr>
            <td width="20%" height="36"><label>College</label></td>
            <td width="60%"><input type="text" class="textbox" name="inst_name" size="40"  title="college" 
            	value="<?php echo $this->input->post('inst'); ?>" tabindex="1" /></td>
            <td rowspan="2" width="20%"><button type="submit" title="Search" tabindex="3">Search</button></td>
        </tr>
        <tr>
            <td height="41"><label>Course</label></td>
            <td><input type="text" class="textbox" name="course_name" size="40"  title="course" 
            	value="<?php echo $this->input->post('course'); ?>" tabindex="2" /></td>
        </tr>
	    </table>
        </td>
	</tr>
</table>
</form>
</div>
</div>

<!--<div id="search" align="center">
<form id="search_form" name="search_form" action="<?php echo site_url('search'); ?>" method="post">
<table width="50%">
	<tr>
    	<td height="36">College</td>
        <td><input type="text" name="inst" size="40"  title="college" value="<?php echo $this->input->post('inst'); ?>" /></td>
        <td rowspan="2"><button class="submit" title="Search">Search</button></td>
    </tr>
	<tr>
    	<td height="41">Course</td>
        <td><input type="text" name="course" size="40"  title="course" value="<?php echo $this->input->post('course'); ?>" /></td>
    </tr>
</table>
</form>
</div>-->