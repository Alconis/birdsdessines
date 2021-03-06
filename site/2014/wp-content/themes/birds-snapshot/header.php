<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

    <title>
		<?php if ( is_home() ) { ?><? bloginfo('name'); ?>&nbsp;|&nbsp;<?php bloginfo('description'); ?><?php } ?>
		<?php if ( is_search() ) { ?><? bloginfo('name'); ?>&nbsp;|&nbsp;Search Results<?php } ?>
		<?php if ( is_author() ) { ?><? bloginfo('name'); ?>&nbsp;|&nbsp;Author Archives<?php } ?>
		<?php if ( is_single() ) { ?><?php wp_title(''); ?>&nbsp;|&nbsp;<? bloginfo('name'); ?><?php } ?>
		<?php if ( is_page() ) { ?><? bloginfo('name'); ?>&nbsp;|&nbsp;<?php wp_title(''); ?><?php } ?>
		<?php if ( is_category() ) { ?><? bloginfo('name'); ?>&nbsp;|&nbsp;Archive&nbsp;|&nbsp;<?php single_cat_title(); ?><?php } ?>
		<?php if ( is_month() ) { ?><? bloginfo('name'); ?>&nbsp;|&nbsp;Archive&nbsp;|&nbsp;<?php the_time('F'); ?><?php } ?>
		<?php if (function_exists('is_tag')) { if ( is_tag() ) { ?><? bloginfo('name'); ?>&nbsp;|&nbsp;Tag Archive&nbsp;|&nbsp;<?php  single_tag_title("", true); } } ?>
    </title>

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php if ( get_option('birds_feedburner_url') <> "" ) { echo get_option('birds_feedburner_url'); } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/css/reset.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/css/text.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/css/960.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/style.css" />
    <link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />
	
	<!--[if lte IE 6]>
	<script defer type="text/javascript" src="<?php bloginfo('template_directory'); ?>/includes/js/pngfix.js"></script>
	<![endif]-->
   	
<!-- TO INCLUDE FLEX BIRDS EDITOR -->
<script src="<?php bloginfo('url'); ?>/birds_editor/AC_OETags.js" language="javascript"></script>
<!-- TO INCLUDE FLEX BIRDS EDITOR -->

	<?php wp_head(); ?>

</head>

<body>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/all.js#xfbml=1&appId=139872552493";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="wrap">

<div id="header" class="fullspan">

	<div class="container_16">
	
		<div class="grid_6" id="logo">
			<h1 <?php if ( get_option('birds_logo') <> "" ) { ?>style="background: url(<?php echo get_option('birds_logo'); ?>) no-repeat !important;"<?php } ?>><a href="<?php echo get_settings('home'); ?>/" title="Revenir à l'accueil"><?php bloginfo('name'); ?></a></h1>
		</div>
		
		<div class="grid_8">
			<h1 class="title"><a href="<?php echo get_settings('home'); ?>/" title="Home"><?php bloginfo('name'); ?></a></h1>
			<p class="description"><?php bloginfo('description'); ?></p>
		</div>
		
		<div id="tagline">

<?php if (is_moderator_logged() ) { ?>
<p><a href="http://www.birdsdessines.fr/moderation/">Page de mod&eacute;ration</a></p>
<?php }else{ ?>
<p><?php bloginfo('description'); ?></p>
<?php } ?>
					
		</div><!-- /nav -->
		
	</div><!-- /container_16 -->

</div><!-- /header -->

<div id="nav" class="fullspan">

		<div class="container_16">
	
		<div class="grid_12">
			<ul>							
				<li <?php if ( is_home() ) { ?> class="current_page_item" <?php } ?>><a href="<?php echo get_option('home'); ?>/">Accueil</a></li>
				<?php wp_list_pages('title_li=&exclude=33155,59102,69061,79119'); ?>				
          </ul>
		</div>
        
        <div class="grid_4 rss">
            
            <ul>
            
			<li><a href="<?php if ( get_option('birds_feedburner_url') <> "" ) { echo get_option('birds_feedburner_url'); } else { echo get_bloginfo_rss('rss2_url'); } ?>" title="Abonnez-vous au flux RSS des Birds Dessines">Suivez les Birds !</a></li>
            
            </ul>

		</div>
		
	</div><!-- /container_16 -->

</div><!-- /steps -->