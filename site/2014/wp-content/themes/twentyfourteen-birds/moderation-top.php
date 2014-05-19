<?php
$current_year= date('Y');
$current_month= date('m');
$current_week= date('W');
$current_day= date('j');

echo '<h2>Top du jour</h2>';

$topday= new WP_Query();
$topday->query('showposts=10&year='.$current_year.'&monthnum='.$current_month.'&day='.$current_day.'&r_sortby=highest_rated&r_orderby=desc');
?>


<ol>
<?php while ($topday->have_posts()) : $topday->the_post(); ?> 

<li><strong><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></strong> par <?php the_author_posts_link(); ?>
<?php if(function_exists('the_ratings')) { the_ratings(); } ?>
</li>

<?php endwhile; ?>  
</ol>

<?php
echo '<h2>Top de la semaine</h2>';

$topweek= new WP_Query();
$topweek->query('showposts=10&year='.$current_year.'&w='.$current_week.'&r_sortby=highest_rated&r_orderby=desc');
?>

<ol>
<?php while ($topweek->have_posts()) : $topweek->the_post(); ?> 

<li><strong><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></strong> par <?php the_author_posts_link(); ?>
<?php if(function_exists('the_ratings')) { the_ratings(); } ?>
</li>

<?php endwhile; ?>  
</ol>

<?php
echo '<h2>Top de la semaine dernière</h2>';
$last_week = $current_week - 1;
$topweek= new WP_Query();
$topweek->query('showposts=10&year='.$current_year.'&w='.$last_week.'&r_sortby=highest_rated&r_orderby=desc');
?>

<ol>
<?php while ($topweek->have_posts()) : $topweek->the_post(); ?> 

<li><strong><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></strong> par <?php the_author_posts_link(); ?>
<?php if(function_exists('the_ratings')) { the_ratings(); } ?>
</li>

<?php endwhile; ?>  
</ol>
