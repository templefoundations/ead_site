<div id="thin_body">
<h2>College Login</h2>
<div id="login" align="center">
<form action="<?php echo site_url('login'); ?>" method="post" >
<table cellpadding="5">
	<tr>
		<td colspan="3" align="center"><div class="error"><?php echo validation_errors(); ?></div></td>
	</tr>
	<tr>
		<td height="36">Username</td>
		<td colspan="2"><input name="username" type="text" class="textbox" value="<?php echo set_value('username'); ?>" /></td>
	</tr>
	<tr>
		<td height="41">Password</td>
		<td colspan="2"><input name="password" type="password" class="textbox" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td height="41">
			<button type="submit" class="submit" title="Login">Login</button>
		</td>
		<td height="41">
			<a href="">Forgot Password ?</a>
		</td>
	</tr>
	<!--<tr height="41">
		<td><a href="<?php echo site_url('user_registration'); ?>">New User ?</a></td>
		<td></td>
		<td></td>
	</tr>
	<tr height="41">
		<td><a href="<?php echo site_url('inst_registration'); ?>">College Registration ?</a></td>
		<td></td>
		<td></td>
	</tr>-->
</table>
</form>
</div>
</div>