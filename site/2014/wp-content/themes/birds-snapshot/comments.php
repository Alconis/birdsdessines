<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments">This post is password protected. Enter the password to view comments.</p>

			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'alt';
?>

<?php
	global $bm_comments;
	global $bm_trackbacks;
	
	split_comments( $comments );
?>

<!-- You can start editing here. -->

<?php if ($comments) : ?>

	
	<?php
		$trackbackcounter = count( $bm_trackbacks );
		$commentcounter = count( $bm_comments );
	?>

	<h2><?php echo $commentcounter; ?> Comments For This Post</h2>

	<ol class="commentlist">

	<?php foreach ($bm_comments as $comment) : ?>

		<li class="<?php echo $oddcomment; ?> <?php if(function_exists("author_highlight")) author_highlight(); ?>" id="comment-<?php comment_ID() ?>">

         <?php
         	// Determine which gravatar to use for the user
         	$email =  $comment->comment_author_email;
            $grav_url = "http://www.gravatar.com/avatar.php?gravatar_id=".md5($email). "&default=".urlencode($GLOBALS['defaultgravatar'])."&size=60";
            $usegravatar = get_option('premiumnews_gravatar');
         ?>

			<span class="gravatar"><img src="<?php echo $grav_url; ?>" width="60" height="60" alt="" /></span>
			
			<cite><?php comment_author_link() ?> <a class="metadata" href="#comment-<?php comment_ID() ?>" title="">(<?php comment_date('F jS, Y') ?> at <?php comment_time() ?>)</a></cite>
			<div style="margin-bottom:10px;clear:left;"></div>

			<?php comment_text() ?>
            
            <div style="clear:both;height:10px;"></div>

		</li>

	<?php /* Changes every other comment to a different class */
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'alt';
	?>

	<?php endforeach; /* end for each comment */ ?>

	</ol>

	<?php if ( count( $bm_trackbacks ) > 0 ) { ?>

	<h2><?php echo $trackbackcounter; ?> Trackbacks For This Post</h2>

	<ol class="commentlist">

	<?php foreach ($bm_trackbacks as $comment) : ?>

		<li class="<?php echo $oddcomment; ?> <?php if(function_exists("author_highlight")) author_highlight(); ?>" id="comment-<?php comment_ID() ?>">

			<cite><?php comment_author_link() ?> <a class="metadata" href="#comment-<?php comment_ID() ?>" title="">(<?php comment_date('F jS, Y') ?> at <?php comment_time() ?>)</a></cite>
			<br />

			<?php comment_text() ?>

		</li>

	<?php /* Changes every other comment to a different class */
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'alt';
	?>

	<?php endforeach; /* end for each comment */ ?>

	</ol>

	<?php } ?>

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<h2>Envie de laisser un commentaire ?</h2>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p class="alert">You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small>Nom <?php if ($req) echo "(requis)"; ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small>Adresse mail(ne sera pas publiée) <?php if ($req) echo "(requise)"; ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small>Site internet</small></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comment" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="Envoyer le commentaire" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>
