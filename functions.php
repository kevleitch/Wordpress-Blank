<?php
//
//###########################################################################################
//Show ALL Admin settings (for Admins only)
function all_settings_link() {
	add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
}
add_action('admin_menu', 'all_settings_link');
//
//###########################################################################################
// remove admin bar for all users
function remove_admin_bar(){
    return false;
}
add_filter( 'show_admin_bar' , 'remove_admin_bar');
//
//###########################################################################################
// remove clutter from top admin bar
function do_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
        $wp_admin_bar->remove_menu('new-content');
}
add_action( 'wp_before_admin_bar_render', 'do_admin_bar_render' );
//
//###########################################################################################
// get rid of unwanted widgets from admin widget area
function do_unregister_widgets() {
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_Tag_Cloud');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Akismet');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Nav_Menu_Widget');
}
add_action( 'widgets_init', 'do_unregister_widgets', 11 );
//
//###########################################################################################
// Kill links to certain pages in Admin area
function remove_links_menu() {
	remove_menu_page('index.php'); // Dashboard
	remove_menu_page('edit.php'); // Posts
	remove_menu_page('upload.php'); // Media
	remove_menu_page('link-manager.php'); // Links
	remove_menu_page('edit.php?post_type=page'); // Pages
	remove_menu_page('edit-comments.php'); // Comments
	remove_menu_page('themes.php'); // Appearance
	remove_menu_page('plugins.php'); // Plugins
	remove_menu_page('users.php'); // Users
	remove_menu_page('tools.php'); // Tools
	remove_menu_page('options-general.php'); // Settings
}
add_action('admin_menu', 'remove_links_menu');
//
//###########################################################################################
// add themes widgets (these are just examples)
function do_widgets_init() {
    register_sidebar( array(
	'name' => 'Footer Right',
	'id' => 'footer_right',
	'before_widget' => '<div class="footer-column footer-right">',
	'after_widget' => '</div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
    ));
    register_sidebar( array(
	'name' => 'Footer Middle Right',
	'id' => 'footer_middle_right',
	'before_widget' => '<div class="footer-column footer-middle-right">',
	'after_widget' => '</div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
    ));
}
add_action( 'widgets_init', 'do_widgets_init' );
//
//###########################################################################################
// Add a branded widget in WordPress Dashboard
function do_dashboard_widget_function() {
    echo "<p><strong>Welcome to the CLIENT NAME Website Administration Area</strong></p>
    <p>From here you can manage all aspects of your website, easily and quickly. If you get stuck, please contact <a href='mailto:EMAIL'>NAME</a> at COMPANY for help.</p>
        <hr style='clear: both;' />
        <p><small><strong>Release Date: M Y | Author: Kev Leitch, <a href='http://DOMAIN'>COMPANY</a> | For: BRAND</strong></small></p>";
}
function do_add_dashboard_widgets() {
	wp_add_dashboard_widget('wp_dashboard_widget', 'Information', 'BRANDED_dashboard_widget_function');
}
add_action('wp_dashboard_setup', 'do_add_dashboard_widgets' );
//
//###########################################################################################
// Remove 'screen options' tab from admin area
function remove_screen_options_tab() {
    return false;
}
add_filter('screen_options_show_screen', 'remove_screen_options_tab');
//
//###########################################################################################
// Remove 'help' tab from admin area
function do_remove_help_tabs() {
    $screen = get_current_screen();
    $screen->remove_help_tabs();
}
add_action('admin_head', 'do_remove_help_tabs');
//
//###########################################################################################
// ######### REMOVE VARIOUS NAGS ############################################################
// Remove admin menu nag - and unecessary extra 'home' link
function do_remove_core() {
    remove_submenu_page( 'index.php', 'update-core.php' );
    remove_submenu_page( 'index.php', 'index.php' );
}
add_action( 'admin_init', 'do_remove_core' );
// Make the plugins stop displaying update nags
function filter_plugin_updates($value) {
    unset($value->response['akismet/akismet.php']); // repeat for all plugins you have installed
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );
// Make top bar Admin nag go away totally
function hide_nag() {
	remove_action( 'admin_notices', 'update_nag', 3 );
}
add_action('admin_menu', 'hide_nag');
//
//###########################################################################################
// Remove ability to add new pages
function modify_menu(){
  global $submenu;
  unset($submenu['edit.php?post_type=page'][10]);
}
add_action('admin_menu','modify_menu');
function hide_buttons(){
  global $current_screen;  
  if($current_screen->id == 'edit-page' || $current_screen->id == 'page'){
    echo '<style>.add-new-h2{display: none;}</style>';  
  }
}
add_action('admin_head','hide_buttons');
//###########################################################################################
// Remove crap from Admin screen and make it easier to understand!
function do_remove_admin_elements() {
    echo '
        <style type="text/css">
            .versions p,
            .versions #wp-version-message,
            .first.b.b-cats,
            .t.cats,
            .first.b.b-tags,
            .t.tags,
            #dashboard_right_now h3.hndle span {
                display: none !important;
            }
            #dashboard_right_now h3.hndle:before {
                content: "Activity On Your Site";
            }
            .table_content .sub:before {
                content: "Website ";
            }
            .table_content .sub:after {
                content: ": Blog Posts & Web Pages";
            }
            .table_discussion .sub:before {
                content: "Comments & ";
            }
            .table_discussion .sub:after {
                content: " On Your Blog Posts";
            }
            .wrap h2:before {
                content: "Wine Sorted Administration ";
            }
            .t.posts a:before {
                content: "Blog ";
            }
            .t.pages a:before {
                content:"Web ";
            }
            .last.t.comments a:before {
                content:"Live ";
            }
            .last.t.comments a:after {
                content:" On Your Blog Posts";
            }
        </style>
    ';
}
add_action('admin_head', 'do_remove_admin_elements');
//
//###########################################################################################
// Kill self pings
function kill_self_ping( &$links ) {
	foreach ( $links as $l => $link )
		if ( 0 === strpos( $link, get_option( 'home' ) ) )
			unset($links[$l]);
	}
add_action( 'pre_ping', 'kill_self_ping' );
//
//###########################################################################################
// Remove unncessary header info
function remove_header_info() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'start_post_rel_link');
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'adjacent_posts_rel_link');
}
add_action('init', 'remove_header_info');
//
//###########################################################################################
// Customise the amount of words to use in the_excerpt
function custom_excerpt_length( $length ) {
	return 20; // alter amount as required
}
add_filter( 'excerpt_length', 'custom_excerpt_length');
//###########################################################################################
// Implement customer user profile items
// use it like this: the_author_meta('phone', $current_author->ID)
function update_contact_methods( $contactmethods ) {
	// Remove unwanted default fields  
	unset($contactmethods['aim']);  
	unset($contactmethods['jabber']);  
	unset($contactmethods['yim']);  
	// Add new fields  
	$contactmethods['phone'] = 'Phone';  
	$contactmethods['mobile'] = 'Mobile';  
	$contactmethods['address'] = 'Address';  
	return $contactmethods;
}
add_filter('user_contactmethods','my_custom_userfields',10,1);
?>