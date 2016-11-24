<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<div id="<?php the_ID(); ?>">
	<h1 class="entry-title"> <?php the_title(); ?> </h1>
	
	<?php if(has_post_thumbnail() ) { 
				echo get_the_post_thumbnail();
			} ?>
			
			<?php the_content(); ?>
			<?php echo get_the_tag_list('<p>Tags: ',', ','</p>'); ?>
</div>
