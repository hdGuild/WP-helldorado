<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	
		<link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicon.ico" type="image/x-icon" />    
			
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php $homeID = get_option('page_on_front'); ?>
<div id="page">
<div class="container top-section">
	 <div class="row">
	 	  <div class="left-section">
	 	  <?php $headImag = CFS()->get('header_image',$homeID); ?>
	 	  	   <div class="header" style="background-image:url('<?php echo $headImag;?>')" >
	 	  	   	    <div class="logo">
	 	  	   	    	 <a href="<?php echo home_url(); ?>" title="HellDorado"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo.png" alt=""></a>
	 	  	   	    </div>
	 	  	   </div>
	 	  	   <div class="navigation">
	 	  	   	<?php if(has_nav_menu ('primary') ) :
						wp_nav_menu( array( 'theme_location' => 'primary', 'menu'=> 'Main menu' ) ); 
					endif;?>
	 	  	   </div>
