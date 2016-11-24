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
 	  	   <div class="navigation-sidebar recent-activity">
 	  	   	    <h4>Recent Activity</h4>
 	  	   	    <h5>Friday, September 2</h5>
 	  	   	    <ul>
 	  	   	    	 <li><span>James</span> - Just Signed.<br> Welcome!</li>
 	  	   	    	 <li><span>Mark</span> - Just Signed.<br>
  Welcome!</li>
 	  	   	    	 <li><span>John</span> - Just Signed.<br>
  Welcome!</li>
 <li><span>nency</span> - Just Signed.<br>
  Welcome!</li>
 	  	   	    </ul>
 	  	   	     <h5>Thursday, September 1</h5>
 	  	   	    <ul>
 	  	   	    	 <li><span>James</span> - Just Signed.<br> Welcome!</li>
 	  	   	    	 <li><span>Mark</span> - Just Signed.<br>
  Welcome!</li>
 	  	   	    </ul>
 	  	   	    <h5>Wednesday, August 31</h5>
 	  	   	    <ul>
 	  	   	    	 <li><span>James</span> - Just Signed.<br> Welcome!</li>
 	  	   	    	 <li><span>Mark</span> - Just Signed.<br>
  Welcome!</li>
 	  	   	    	 <li><span>John</span> - Just Signed.<br>
  Welcome!</li>
 <li><span>nency</span> - Just Signed.<br>
  Welcome!</li>
 	  	   	    </ul>
 	  	   </div>
