<?php get_header(); 

$mod_page = ($post->ID == 59102);
?>

<div id="content" class="fullspan">

	<div class="container_16 clearfix">
			
		<div id="leftcontent" class="grid_12">

<?php if(!$mod_page) adsensem_ad('birdsdessines-horizontal'); ?>

		<?php if (have_posts()) : ?>
	
			<?php while (have_posts()) : the_post(); ?>
					
			<div class="post">
				
				<?php if(!$mod_page) : ?>
				<h2 class="title" style="margin-top: 0px !important;"><?php the_title(); ?></h2>				
				<?php endif; ?>
				<div class="entry">

					<?php the_content(); ?>						

				</div><!-- /entry -->
					
			</div><!-- /post -->

			<?php endwhile; ?>

			<div id="postnav">
				<p class="floatleft prev"><?php next_posts_link('Previous Entries') ?></p>
				<p class="floatright next"><?php previous_posts_link('Newer Entries') ?></p>
			</div><!-- /postnav -->
			
		<?php endif; ?>							

		</div><!-- /leftcontent -->
        
        <?php if($post->ID != 21 && $post->ID != 59102 && $post->ID != 79119) get_sidebar(); ?>
        
	</div><!-- /container_16 -->

</div><!-- /content -->

<?php wp_footer(); ?>