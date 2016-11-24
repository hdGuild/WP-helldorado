<?php
/*
* Template Name: Blog Page
*/

get_header(); ?>
<div class="content-area clearfix">
	<div class="content-area-left">
		<main class="site-main" role="main">
			<?php query_posts(array('post_type'=>'blogs', 'posts_per_page'=>-1, 'order'=> 'DESC'));
				if( have_posts() ) : 
					while(have_posts() ) : the_post(); ?>
							<a href="<?php echo get_permalink(); ?>" ><h1 class="entry-title"><?php the_title(); ?></h1></a>
							<?php the_content(); ?>
							<?php echo get_the_tag_list('<p>Tags: ',', ','</p>'); ?>
					<?php endwhile; wp_reset_query(); ?>
				<?php endif; ?>
		</main>
	</div>
</div><!-- .content-area -->
</div>		
<div class="right-sidebar content-area-right">
	<?php get_sidebar('blog'); ?>
</div>
</div>
</div>
<div class="clear"></div>	
<?php get_footer(); ?>