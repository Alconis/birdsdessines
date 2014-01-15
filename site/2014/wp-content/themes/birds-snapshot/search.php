<?php get_header(); ?>

<div id="content" class="fullspan">
	<div class="container_16 clearfix">
		<div id="leftcontent" class="grid_12">
		

<?php

$search_query = get_search_query();
$all_users = get_users('blog_id=0&orderby=nicename&role=subscriber&search=*' . $search_query . '*');
if(count($all_users) > 0){
	echo '<h1>Auteurs correspondant à la recherche:</h1><ul>';
	foreach ($all_users as $user) {
		$user_nicename = str_replace($search_query, '<b>'.$search_query.'</b>', $user->user_nicename);
		echo '<li><a href="' . get_author_posts_url($user->ID) . '">' . $user_nicename . '</a></li>';
	}
	
	echo "</ul>";
}

?>

    		<?php 
echo '<h1>BDs correspondant à la recherche:</h1>';

while (have_posts()) : the_post(); ?>
            		
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
					      	<div><p class="date"><a href="http://www.birdsdessines.fr/birds_alert.php?id=<?php the_ID();?>" rel="nofollow">BD incorrecte, offensante, trop de fautes etc.</a></p></div>
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