<div id="footer" class="fullspan">

	<div class="container_16">
		<div class="grid_8 ">
			<p>&copy; <?php the_time('Y'); ?> <?php bloginfo(); ?>. Créé par <a href="http://www.alconis.com" title="Alconis">Nicolas Demange</a> 
| <a href="http://smartkool.com/">Smart Kool Tasks Application</a> 
<?php if (is_admin_logged()) echo " | Admin logged!";  ?></p>
		</div>

	</div><!-- /container_16 -->

</div><!-- /footer -->

</div><!-- /wrap -->

<?php wp_footer(); ?>

<?php if ( get_option('birds_google_analytics') <> "" ) { echo stripslashes(get_option('birds_google_analytics')); } ?>

</body>
</html>