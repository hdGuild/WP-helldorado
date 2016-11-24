<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>
<div class="welcome-box">
<span>Welcome, Guest!</span>
<a href="#" title="Login" class="login-btn">Login</a>
<a href="#" title="Register" class="register-btn">Register</a>
</div>
<div class="welcome-box-text">
	<?php dynamic_sidebar('sidebar-4'); ?>
</div>
<div class="navigation-sidebar">
	<h4>Navigation</h4>
	<?php if( has_nav_menu('primary') ) :
				wp_nav_menu(array('theme_location' => 'primary', 'menu'=>'Main menu') );
 	 endif; ?>
</div>
 	  	  <div class="navigation-sidebar twits">
 	  	   	<h4>@Twitter</h4>
 	  	   	<?php echo do_shortcode('[statictweets skin="" resource="usertimeline" user="" list="" query="" id="" count="5" retweets="off" replies="off" ajax="off" show="username,avatar,time,media"/]'); ?>
 	  	   </div>
