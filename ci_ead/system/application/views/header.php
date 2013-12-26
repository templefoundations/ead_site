<body>
<div class="main">
  <div id="header">
    <div class="header_resize">
      <div class="menu_nav">
        <ul>
          <li> <!--class="active"--><?php echo anchor('index/home', 'Home'); ?></li>
          <?php	if ($this->session->userdata('user_id') === FALSE): ?>
          <li><?php echo anchor('search', 'Search'); ?></li>
          <li>
          	<?php echo anchor('inst_registration', 'College Registration'); ?>
          </li>
<?php	
			endif;
			if ($this->session->userdata('user_id') === FALSE):
					echo  '<li>'.anchor('login', 'Login').'</li>';
				else:
					echo  '<li>'.anchor('index/logout', 'Logout').'</li>';
				endif;
			?>
			<li><?php echo anchor('contact_us', 'Contact Us'); ?></li>
          </ul>
      </div>
      <div class="clr"></div>
      <div class="logo"><h1><a href="<?php echo site_url('index/home');?>"><span>eAdmissions</span>.in<sup>alpha</sup><br /><small>one stop destination for college admissions</small></a></h1></div>
      <div class="clear"></div>
    </div>
  </div>
</div>