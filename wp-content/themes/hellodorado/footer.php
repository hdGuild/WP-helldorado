<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

	<div class="container footer-top">
	 <div class="row">
	 	  <div class="ft-logo">
	 	  	   <a href="<?php echo home_url(); ?>" title="HellDorado"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/ft-logo.png" alt=""></a>
	 	  </div>
	 	  <div class="ft-right">
	 	  	   <span>Stay Connected</span>
	 	  	   <ul>
	 	  	   	    <li><a href="#" title="Facebook"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/fb-ic.png" alt=""></a></li>
	 	  	   	    <li><a href="#" title="Youtube"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/youtube-ic.png" alt=""></a></li>
	 	  	   	    <li><a href="#" title="Twitter"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/twit-ic.png" alt=""></a></li>
	 	  	   	    <li><a href="#" title="Googleplus"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/google-ic.png" alt=""></a></li>
	 	  	   	    <li><a href="#" title="Instagram"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/insta-ic.png" alt=""></a></li>
	 	  	   	    <li><a href="#" title="Linkedin"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/linkedin-ic.png" alt=""></a></li>
	 	  	   	    <li><a href="#" title="BlockQuote"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/blockqc-ic.png" alt=""></a></li>
	 	  	   	    <li><a href="#" title="Steam"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/steam-ic.png" alt=""></a></li>
	 	  	   	    <li><a href="#" title="Rss"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/rss-ic.png" alt=""></a></li>
	 	  	   </ul>
	 	  </div>
	 </div>
</div>
<div class="container footer">
	 <div class="row">
	 	  <p>&copy; Copyright <?php echo date('Y') ?> <span>Hell Dorado.</span> - All Rights Reserved.</p>
	 	  <div class="back-to-top">
	 	  	   BACK TO TOP
	 	  </div>
	 </div>
</div>
</div>


<a href="#menu" class="mm-fixed-top mm-slideout" id="hamburger"><span></span></a>
<nav id="menu">
	<?php if( has_nav_menu('primary') ) :
				wp_nav_menu(array('theme_location' => 'primary', 'menu' => 'Main menu'));
	endif; ?>
</nav>

<?php wp_footer(); ?>
</body>
</html>
