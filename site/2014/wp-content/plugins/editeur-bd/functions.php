<?php
/*
Plugin Name: Editeur BD
Plugin URI: http://www.birdsdessines.fr
Description: Provides all the tools to connect the comic strip editor to a Wordpress installation
Version: 0.1
Author: Nicolas Demange
Author URI: http://www.alconis.com
License: GPL2
*/

// VARIABLES
$moderators = array(
2, //alconis
6132, //modo
5051, //polomcbee
5398, //caravone
2878, // trevor
3069, // oizon
4031, // gmail
4510, // Croaa
6618, // jmf08
6643, // Flocal93
3917, // Nobody
6565, //moderateur1
6566, //moderateur2
6567, //moderateur3
6568, //moderateur4
6569, //moderateur5
8533, //moderateur6
9525 //moderateur7
);

function exclude_old_users_posts( $query ) {
	if( !is_admin() && !is_search() && $query->is_main_query() ){
		$query->set( 'cat', '-7597');
	}
}
add_action( 'pre_get_posts', 'exclude_old_users_posts' );

function comic_editor_shortcode_handler( ) {

	$swf_url = plugins_url('editor/editor.swf', __FILE__);
	$shortcode_html = '<div class="birds_editor">' .
	'  	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
			id="ComicGenerator" width="900" height="800"
			codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
			<param name="movie" value="' . $swf_url . '" />
			<param name="quality" value="high" />
			<param name="bgcolor" value="#ffffff" />
			<param name="allowScriptAccess" value="sameDomain" />
			<embed src="' . $swf_url . '" quality="high" bgcolor="#ffffff"
				width="900" height="800" name="ComicGenerator" align="middle"
				play="true"
				loop="false"
				quality="high"
				allowScriptAccess="sameDomain"
				type="application/x-shockwave-flash"
				pluginspage="http://www.adobe.com/go/getflashplayer">
			</embed>
		</object>' .
	'</div>';
	return $shortcode_html;
}

add_shortcode( 'comic-editor', 'comic_editor_shortcode_handler' );

function comic_editor2_shortcode_handler( ) {

	$swf_url = plugins_url('editor2/editor.swf', __FILE__);
	$shortcode_html = '<div class="birds_editor">' .
	'  	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
			id="ComicGenerator" width="900" height="800"
			codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
			<param name="movie" value="' . $swf_url . '" />
			<param name="quality" value="high" />
			<param name="bgcolor" value="#ffffff" />
			<param name="allowScriptAccess" value="sameDomain" />
			<embed src="' . $swf_url . '" quality="high" bgcolor="#ffffff"
				width="900" height="800" name="ComicGenerator" align="middle"
				play="true"
				loop="false"
				quality="high"
				allowScriptAccess="sameDomain"
				type="application/x-shockwave-flash"
				pluginspage="http://www.adobe.com/go/getflashplayer">
			</embed>
		</object>' .
	'</div>';
	return $shortcode_html;
}
add_shortcode( 'comic-editor2', 'comic_editor2_shortcode_handler' );

function birds_rss_the_content($content) {
	$is_feed = is_feed();
	global $post;
	
	if ($is_feed){
	
	$img_url = get_post_meta($post->ID, 'large-image', true);
	if ($img_url){
	?>
		<a title="Voir les détails de <?php the_title_rss(); ?>" href="<?php the_permalink_rss(); ?>">
		<img src="<?php echo $img_url; ?>" alt="<?php the_title_rss(); ?>"/>
		</a>
		<br/>
		<p class="comments"><?php comments_popup_link('Aucun Commentaire', '1 Commentaire', '% Commentaires'); ?></p>
		
<?php
	}}else{
		return $content;
	}
}
remove_filter('the_title', 'wptexturize');
add_action('the_content', 'birds_rss_the_content', 95);

function is_admin_logged(){
	global $current_user;
	get_currentuserinfo();
	return $current_user->user_level >=8; // 10 for me !
}

function is_moderator_logged(){
	global $current_user;
	global $moderators;
	get_currentuserinfo();
	return in_array($current_user->ID, $moderators);
}

function mobile_prepare_post( $_post, $post, $fields ) {
    $author = get_userdata($post['post_author']);
    $_post['author_name'] = $author->display_name;

    return $_post;
}

add_filter( 'xmlrpc_prepare_post', 'mobile_prepare_post', 10, 3 );

function blogger_getUserInfo_modified( $args ) {
	global $wp_xmlrpc_server;
	$wp_xmlrpc_server->escape( $args );
 
	$username = $args[1];
	$password  = $args[2];
 
	if ( !$user = $wp_xmlrpc_server->login($username, $password) )
		return $wp_xmlrpc_server->error;

	/* HACK FOR BirdsDessines.fr 
	if ( !current_user_can( 'edit_posts' ) )
		return new IXR_Error( 401, __( 'Sorry, you do not have access to user data on this site.' ) );
	*/

	do_action('xmlrpc_call', 'blogger.getUserInfo');
 
	$struct = array(
		'nickname'  => $user->nickname,
		'userid'    => $user->ID,
		'url'       => $user->user_url,
		'lastname'  => $user->last_name,
		'firstname' => $user->first_name
	);
 
	return $struct;
}
function redefine_xmlrpc_methods( $methods ) {
	// Replace standard XMLRPC API getUserInfo by a modified one.
	$methods['blogger.getUserInfo'] = 'blogger_getUserInfo_modified';
	return $methods;   
}
add_filter( 'xmlrpc_methods', 'redefine_xmlrpc_methods');

// Add custom-field 'bubbles-text' search.
// See:
// - http://www.hashbangcode.com/blog/enable-custom-field-searching-wordpress-26-239.html
// - http://weblogtoolscollection.com/archives/2008/04/13/how-to-only-retrieve-posts-with-custom-fields/
// - http://www.braindonor.net/blog/wordpress-custom-field-search-plugin/102/

function search_bubbletext_join($join) {
	global $wpdb;

	if ( is_search() && isset($_GET['s'])) {
		$join .= " LEFT JOIN $wpdb->postmeta AS m ON ($wpdb->posts.ID = m.post_id) ";
	}
	return($join);
}
add_filter('posts_join','search_bubbletext_join');

function search_bubbletext_where($where) {
	global $wpdb;

	$metaKey = "bubbles-text";
	if ( is_search() && isset($_GET['s']) ) {
		//$where .= " AND m.post_status = 'publish'";
		$where .= " OR (m.meta_key = '" . $metaKey . "' AND m.meta_value LIKE '%" . $wpdb->escape($_GET['s']) . "%')";
	}
	return($where);
}
add_filter('posts_where','search_bubbletext_where');

function search_bubbletext_groupby($groupby) {
	global $wpdb;

	if ( is_search() && isset($_GET['s'])) {
		$groupby .= " $wpdb->posts.ID ";
	}
	return($groupby);
}
add_filter('posts_groupby','search_bubbletext_groupby');


?>