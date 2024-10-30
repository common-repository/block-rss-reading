<?php

/**
 * Admin functions: admin.php
 **/

// add settings shortcut url
function block_rss_reading_settings_link($actions, $file){
if(false !== strpos($file, 'block-rss-reading'))
$actions['settings'] = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=block_rss_reading">Settings</a>';

return $actions;

}

add_filter('plugin_action_links', 'block_rss_reading_settings_link', 10, 2);


// register settings
function block_rss_reading_init(){
    register_setting( 'block_rss_reading', 'block_rss_reading' );
}

// add settings page to menu
function add_settings_page() {

add_menu_page( __( 'Block RSS Reading Configuration', 'block_rss_reading' ), __( 'Block RSS Reading', 'block_rss_reading' ), 'manage_options', 'block_rss_reading', 'block_rss_reading_page', FUNCTION_URL . 'assets/img/menu-icon.png' );

}

// add actions
add_action( 'admin_init', 'block_rss_reading_init' );
add_action( 'admin_menu', 'add_settings_page' );

// start settings page
function block_rss_reading_page() {

if ( ! isset( $_REQUEST['updated'] ) )
$_REQUEST['updated'] = false;

?>

<div>

<div id="icon-edit-pages" class="icon32"></div>
<h2><?php _e( 'Block RSS Reading Configuration' ); ?></h2>

<?php // show saved options message
if ( false !== $_REQUEST['updated'] ) : ?>

<div><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>

<?php endif; ?>

<form method="post" action="options.php">

<?php settings_fields( 'block_rss_reading' );

$options = get_option( 'block_rss_reading' ); ?>

<table>

<!-- Option 1: Custom RSS Url -->
<tr valign="top">
<th scope="row"><?php _e( 'Custom RSS Url' ); ?></th>
<td><input id="block_rss_reading[custom_rss_url]" type="text" size="36" name="block_rss_reading[custom_rss_url]" value="<?php esc_attr_e( $options['custom_rss_url'] ); ?>" />
</td>
</tr>

<!-- Option 2: Blocked IP's List -->
<tr valign="top">
<th scope="row"><?php _e( "Blocked IP's List" ); ?></th>
<td>
<textarea id="block_rss_reading[blocked_ip_list]" name="block_rss_reading[blocked_ip_list]" rows="5" cols="36"><?php esc_attr_e( $options['blocked_ip_list'] ); ?></textarea></td>
</tr>

</table>

<p><input name="submit" id="submit" value="Save Changes" type="submit" class="button-primary"></p>
</form>

</div><!-- END wrap -->

<?php } ?>