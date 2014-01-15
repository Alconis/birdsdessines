<?php get_header(); ?>

<div id="content" class="fullspan">
	<div class="container_16 clearfix">		

<?php adsensem_ad('birdsdessines-horizontal'); ?>

    		<?php while (have_posts()) : the_post(); ?>
    		
		<div class="post">


            		<h2>
				<?php the_title(); ?>
<?php
$certified = get_post_meta($post->ID, "certified", true);
if($certified == 1){
?>
 &nbsp;<img src="/wp-content/plugins/editeur-bd/editor/assets/icons/certified.png" alt="certified" title="BD certifi&eacute;e comme in&eacute;dite par son auteur !">
<?php
}
?>
			</h2>
<?php
$hidden = get_post_meta($post->ID, "hidden", $single = true);

if($hidden == 1){
?>
<div class="hiddenMsg">
Cette BD a &eacute;t&eacute; signal&eacute;e comme &agrave; ne pas mettre devant tous les yeux. Aussi, elle n'apparaitra pas directement dans les recherches du site.
</div>

<?php
}
?>
			<div class="large-screenshot">

<?php					
$img_url = get_post_meta($post->ID, "large-image", $single = true);
?>

				<img src="<?php echo $img_url; ?>" alt="<?php the_title(); ?>" />

			</div><!-- /screenshot-->
		
		</div><!-- /post -->

		<div style="clear:both;height:15px;"></div>      
                        
		<div class="grid_6 alpha">
			<div class="post">
            
				<h3>D&eacute;tails</h3>
				<p><strong>Auteur:</strong> <?php the_author_posts_link(); ?></p>
				<p class="date">Publi&eacute; <?php echo time_ago(); ?></p>
				<p><strong>Cat&eacute;gories:</strong> <?php the_category(','); ?></p>
				<p><strong>Note:</strong> <?php if(function_exists('the_ratings')) { the_ratings(); } ?></p>

<?php
if(wp_get_current_user()->ID == $post->post_author){
	echo '<a class="delete_link" href="http://www.birdsdessines.fr/birds_trash.php?post_id=' . $post->ID . '">Supprimer ma BD</a><em style="color:#AAAAAA">(Une confirmation vous sera demandée.)</em>';
}
?>

<?php

if( is_moderator_logged() ):
	$moderation_count = get_post_meta($post->ID, 'moderation', true);
?>
							<div class="mod_modo"><a target="_blank" href="/moderation?view=modo&alert=<?=$post->ID; ?>&detail=<?=$post->ID; ?>"><?=($moderation_count != '' ? $moderation_count : '0');?></a></div>

<?php endif; ?>

			</div><!-- /post -->
		</div><!-- /grid_6 omega -->
		<div class="grid_6 omega">
			<div class="post">
            
            				<h3>Description:</h3>
<?php 
$content = get_the_content();
if($content != '') {
	the_content();
}else{
	echo "Aucune description.";
}
?>

                			<h3>Transcription:</h3>
<?php 
$transcript = get_post_meta($post->ID, 'bubbles-text', true);
if($transcript != '') {
  echo $transcript ;
}else{
  echo "Aucun transcript.";
}
?>
<br>
<div class="fb-like" data-href="<? the_permalink();?>" data-send="true" data-layout="button_count" data-width="100" data-show-faces="false" data-font="arial"></div>

<a href="https://twitter.com/share" class="twitter-share-button" data-via="BirdsDessines" data-lang="fr">Tweeter</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

			</div><!-- /post -->
		</div><!-- /grid_6 omega -->        
			
		<?php endwhile; ?>
            
		<div style="clear:both;height:15px;"></div> 
		<div id="comments">
			<?php comments_template(); ?>
		</div>	
			
		<div id="postnav">
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</div><!-- /postnav -->
        
	</div><!-- /container_16 -->
</div><!-- /content -->

<?php get_footer(); ?>