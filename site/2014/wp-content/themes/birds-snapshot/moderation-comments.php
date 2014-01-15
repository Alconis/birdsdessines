<div class="message">
	Les 50 derniers commentaires du site. Cliquer sur l'heure d'un commentaire pour accéder à la BD associée.
</div>

<div id="comments">
<?php 

$args = array(
	'number' => 50,
	'order' => 'DESC'
);
$comments = get_comments($args);

foreach($comments as $comment) :
	$post_id = $comment->comment_post_ID;
	$post_permalink = get_permalink( $post_id );
	$author = $comment->comment_author;
	$date = $comment->comment_date;
	$content = $comment->comment_content;

?>
<div class="comment">
	<span style="background-color: #F1F1F1; border-top: 1px solid #888; margin-top: 10px;"><strong><?= $author; ?></strong> sur <a href="<?= $post_permalink; ?>">BD#<?= $post_id; ?></a> &agrave; <?= $date; ?> :</span><br/>
	<?= $content; ?>
</div>
<?php

endforeach;

?>


</div>