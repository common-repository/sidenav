<?php
/**
 * The plugin form rendering file
 *
 * @since             1.0.0
 * @package           SideNav
 * @subpackage        sidenav/includes
 *
*/

function sidenav_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}

//callback fallback for no menu
function sidenav_side_nav_cb() { 
    ?>
    <div class="sidenav">
        <ul id="sideNav">
            <?php
            wp_list_pages( array(
                'depth' => 3,
                'title_li' => ''
            ) );
            ?>
        </ul>
    </div>
    <?php
}

/**
 * Render side div and menu 
 */
function sidenav_render_side_nav() {

    $sdnavhand = get_option( 'sidenav_settings' )['sidenav_text_field_3'];
         
        if( $sdnavhand == "right" ) { $handed = "sidenav-right"; }
            else { $handed = "sidenav"; }
            
    $handtog = $handed.'-side';
?>

        <div class="toggler <?php echo $handtog; ?>">
			<span onclick="openNav()">
        	<div class="toggler-container">
            	<div class="sbar1"></div>
            	<div class="sbar2"></div>
            	<div class="sbar3"></div>
        	</div>
			</span>
        </div>

<div id="sideSideNav" class="<?php echo $handed; ?>">
    <nav class="sidenav-wrap">
    <a href="javascript:void(0)" class="<?php echo $handed; ?> closebtn" onclick="closeNav()"> &times; </a> 

<?php

wp_nav_menu( array(
    'theme_location' => 'sidenav-menuside',
    'depth'          => 2,
    'menu_class'     => 'sidenav-menu',
    'container_id'   => 'sideNavWrap',
    'items_wrap'     => '<ul>%3$s</ul>',
    'fallback_cb'    => 'sidenav_side_nav_cb'

) );
?>
    </nav></div>    
<?php 

}


/**
 * decide if menu is on or off
 */
$sdnavpwr = get_option( 'sidenav_settings' )['sidenav_text_field_0'];

    if( $sdnavpwr == sidenav_sanitize_integer( 1 ) ) : 
        add_action( 'wp_footer', 'sidenav_render_side_nav', 10, 2 );
        add_shortcode ( 'sidenav_nav', 'sidenav_render_side_nav' );
        
        else : 
/**
 * Remove action $tag, $function_to_remove, $priority
 * https://developer.wordpress.org/reference/functions/remove_action/
*/
        remove_action( 'wp_footer', 'sidenav_render_side_nav', 9 );
endif; 

