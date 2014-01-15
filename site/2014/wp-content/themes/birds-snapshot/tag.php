<?php get_header(); ?>

<div id="content" class="fullspan">
	<div class="container_16 clearfix">
		<div id="leftcontent" class="grid_12">
		
    		<?php while (have_posts()) : the_post(); ?>
            	
				<div class="post">
					<div class="screenshot">
						<div class="screenimg">
						
						<?php /*woo_get_image('large-image','690','246');*/ ?>

<a title="Voir les détails de <?php the_title(); ?>" href="<?php the_permalink(); ?>">
<img src="<?php echo get_post_meta($post->ID, "large-image", $single = true); ?>" alt="<?php the_title(); ?>" width="690" height="246"/>
</a>
						<span><?php the_category(','); ?></span>
						</div>
					</div>
					<div class="theme">		      
					      	
					      	<div style="float:right;text-align:right;"><?php the_ratings();?></div>
					      	<div><h2><a title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2></div>
					      	<div><p class="date">Publié le <?php the_time('d M y'); ?> par <?php the_author_posts_link(); ?></p></div>
					      	<div><p class="tags"><?php the_tags('', ', ' , ''); ?></p></div>
					      	<div><p class="comments"><?php comments_popup_link('Aucun Commentaire &raquo;', '1 Commentaire &raquo;', '% Commentaires &raquo;'); ?></p></div>

					</div>
				</div><!-- /post -->
				<div style="clear:both;height:10px;"></div>
			<div style="clear:both;height:0px;"></div>
				
		<?php endwhile; ?>
			
			<div id="postnav">
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
			</div><!-- /postnav -->
		</div><!-- /leftcontent --> 
			
		<?php get_sidebar(); ?>
        
	</div><!-- /container_16 -->
</div><!-- /content -->

<?php get_footer(); ?>