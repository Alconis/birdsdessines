<?php get_header(); ?>

	<div id="content" class="fullspan">
		<div class="container_16 clearfix">
			<div id="leftcontent" class="grid_12">

				<article id="post-0" class="post error404 no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title">BD Introuvable</h1>
					</header>

					<div class="entry-content">
						<p>Il semble que la BD demandée n'existe plus. Peut-être la retrouverez-vous en faisant une recherche :</p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
			</div><!-- #leftcontent -->

			<?php get_sidebar(); ?>

		</div><!-- .container_16 -->
	</div><!-- #content -->

<?php get_footer(); ?>