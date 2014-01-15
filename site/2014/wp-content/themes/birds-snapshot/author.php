<?php get_header(); ?>

<div id="content" class="fullspan">
	<div class="container_16 clearfix">
		<div id="leftcontent" class="grid_12">

<?php if ( have_posts() ) : ?>

			<?php
				/* Queue the first post, that way we know
				 * what author we're dealing with (if that is the case).
				 *
				 * We reset this later so we can run the loop
				 * properly with a call to rewind_posts().
				 */
				the_post();
			?>

			<div class="author-info" style="min-height:120px; margin-bottom:10px; padding:4px; background-color:#F1F1F1; border-bottom:1px solid #ABABAB;">
				<div class="author-avatar gravatar" style="height: 96px; width: 96px;">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?>
				</div><!-- .author-avatar -->
				<div class="author-description">
					<h2>A propos de <a class="url fn n" href="<?= esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ); ?>" title="<?= esc_attr( get_the_author() ); ?>" rel="me"><?= get_the_author(); ?></a></h2>
					<p style="text-align:justify;">

					<?php if ( get_the_author_meta( 'description' ) ) : ?>
						<?php the_author_meta( 'description' ); ?>
					<?php else : ?>
						<em>L'auteur n'a pas renseign&eacute; de description dans sa page de profil.</em>
					<?php endif; ?>

					</p>
				</div><!-- .author-description	-->
			</div><!-- .author-info -->

			<?php
				rewind_posts();
			?>

    		<?php while (have_posts()) : the_post(); ?>
            		
				<div class="post">
					
<?php
$hidden = get_post_meta($post->ID, "hidden", $single = true);
if($hidden == 1){
?>
<a title="<?php echo $title; ?>" href="<?php the_permalink(); ?>" class="hiddenMsg">
Cette BD est cachée car elle a été signalée comme à ne pas mettre devant tous les yeux. Pour la voir quand même cliquez ce message.
</a>

<?php
}else{
?>
					<div class="screenshot">
						<div class="screenimg">
<?php					
$img_url = get_post_meta($post->ID, "large-image", $single = true);
$title = trim(get_the_excerpt());
if (strlen($title) == 0) $title = "Voir les détails de " . get_the_title();

?>

<a title="<?php echo $title; ?>" href="<?php the_permalink(); ?>">

<img src="<?php echo $img_url; ?>" alt="<?php the_title(); ?>" width="690" height="246"/>
</a>
						<span><?php the_category(','); ?></span>
						</div>
					</div>
<?php
} // end else if hidden
?>
					<div class="theme">		      
					      	
					      	<span style="float:right;text-align:right;">
					      		<div><?php the_ratings();?></div>
<?php

if( is_moderator_logged() ):
	$moderation_count = get_post_meta($post->ID, 'moderation', true);
?>
							<div class="mod_modo"><a target="_blank" href="/moderation?view=modo&alert=<? the_ID(); ?>&detail=<? the_ID(); ?>"><?=($moderation_count != '' ? $moderation_count : '0');?></a></div>

<?php endif; ?>
					      	</span>

					      	<div><h2><a title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>

<?php
$certified = get_post_meta($post->ID, "certified", true);
if($certified == 1){
?>
 &nbsp;<img src="/wp-content/plugins/editeur-bd/editor/assets/icons/certified.png" style="width: 16px;height:16px;" alt="certified" title="BD certifi&eacute;e comme in&eacute;dite par son auteur !">
<?php
}
?>

						</h2></div>
					      	<div><p class="date">Publié <?php echo time_ago(); ?> par <?php the_author_posts_link(); ?></p></div>
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
		<?php endif; ?>
			
		<?php get_sidebar(); ?>
        
	</div><!-- /container_16 -->
</div><!-- /content -->

<?php get_footer(); ?>