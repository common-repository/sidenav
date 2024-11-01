<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @stable version: 1.0.0
 * @package    SideNav
 * @subpackage sidenav/includes
 * @author     Larry Judd <tradesouthwest@gmail.com>
 */
add_action( 'admin_menu', 'sidenav_add_options_page' );
add_action( 'admin_init', 'sidenav_settings_init' );

function sidenav_theme_support() {
    register_nav_menus(
        array(
            'sidenav-menuside' => __('Side Off-Canvas Menu', 'sidenav')
            ));
}
add_action('init','sidenav_theme_support');


/**
 * Provides a default value for the theme layout setting.
 *
 * @since    1.0.0
 */
function sidenav_options_defaults() {
    $defaults = array (
     'sidenav_text_field_0' => 1,
     'sidenav_text_field_2' => "sans-serif",
     'sidenav_text_field_3' => "left",
     'sidenav_text_field_1' => 16,
     'sidenav_text_field_4' => 0,
);

return apply_filters ( 'sidenav_settings', $defaults );
}


function sidenav_add_options_page() {

    add_menu_page(
        __( 'Sidenav Options', 'sidenav' ),
        __( 'Sidenav Settings', 'sidenav' ),
        'manage_options',
        'sidenav',
        'sidenav_admin_options_page',
        'dashicons-menu',
        14
    );
}


/**
  * Register settings for options page
  *
  * @since    1.0.0
  */
function sidenav_settings_init() {
    
     if( false == get_option( 'sidenav_settings' ) ) {
		add_option( 'sidenav_settings', 
		apply_filters( 'sidenav_settings_init', sidenav_options_defaults() ) );
	} // end if
    

    add_settings_section(
        'sidenav_pluginPage_section',
        __( 'Controls for SidNav Menu', 'sidenav' ),
        'sidenav_settings_section_callback',
        'sidenav_admin_pluginPage'
    );

    //$id, $title, $callback, $page, $section = 'default', $args = array()
    add_settings_field(
        'sidenav_text_field_0',
        __( 'Turn Menu On or Off', 'sidenav' ),
        'sidenav_text_field_0_render',
        'sidenav_admin_pluginPage',
        'sidenav_pluginPage_section'
    );
    
    add_settings_field(
        'sidenav_text_field_3',
        __( 'Left or Right Side of Theme', 'sidenav' ),
        'sidenav_text_field_3_render',
        'sidenav_admin_pluginPage',
        'sidenav_pluginPage_section'
    );

    add_settings_field(
        'sidenav_text_field_2',
        __( 'Enter Font Name', 'sidenav' ),
        'sidenav_text_field_2_render',
        'sidenav_admin_pluginPage',
        'sidenav_pluginPage_section'
    );
    
    add_settings_field(
        'sidenav_text_field_1',
        __( 'Select Font Size', 'sidenav' ),
        'sidenav_text_field_1_render',
        'sidenav_admin_pluginPage',
        'sidenav_pluginPage_section'
    );
    
    add_settings_field(
        'sidenav_text_field_4',
        __( 'Set Visibility', 'sidenav' ),
        'sidenav_text_field_4_render',
        'sidenav_admin_pluginPage',
        'sidenav_pluginPage_section'
    );
    
register_setting( 'sidenav_admin_pluginPage', 'sidenav_settings' );
}

    /**
     * Fields for on/off, font size, font family and z-index
     *
     * @since    1.0.0
     * @options sidenav-settings
     */
    function sidenav_text_field_0_render() {
        $sdnavpwr = get_option( 'sidenav_settings' )['sidenav_text_field_0'];
    ?>

    <select name="sidenav_settings[sidenav_text_field_0]">
        <option value="1" <?php selected( $sdnavpwr, 1 ); ?>>ON</option>
        <option value="0" <?php selected( $sdnavpwr, 0 ); ?>>OFF</option>
    </select>  

    <?php
    }
    // power switch
    function sidenav_text_field_3_render() {
        $sdnavhand = get_option( 'sidenav_settings' )['sidenav_text_field_3'];
    ?>

    <select name="sidenav_settings[sidenav_text_field_3]">
        <option value="left"  <?php selected( $sdnavhand, 'left' ); ?>>
                           <?php esc_attr_e( 'Left Side', 'sidenav' ); ?></option>
        <option value="right" <?php selected( $sdnavhand, 'right' ); ?>>
                          <?php esc_attr_e( 'Right Side', 'sidenav' ); ?></option>
    </select>  

    <?php
    }
    // font size render    
    function sidenav_text_field_2_render() {
        $sdnavfam = get_option( 'sidenav_settings' )['sidenav_text_field_2'];
        if( $sdnavfam == '' ) $sdnavfam = "sans-serif";
    ?>
   
    <input name="sidenav_settings[sidenav_text_field_2]" 
           type="text"
           id="sidenav_fam" value="<?php echo esc_attr( $sdnavfam ); ?>">
           
    <?php 
    } 
    //font family render
    function sidenav_text_field_1_render() { 
        $sdnavfont = get_option( 'sidenav_settings' )['sidenav_text_field_1'];
    ?>
   
    <input name="sidenav_settings[sidenav_text_field_1]" 
           type="number"
           id="sidenav_fontsize" value="<?php echo esc_attr( $sdnavfont ); ?>" 
           min="9" max="60">
           
    <?php 
    } 
    
    function sidenav_text_field_4_render() {
        $sdnavzin = get_option( 'sidenav_settings' )['sidenav_text_field_4'];
    ?>
   
    <input name="sidenav_settings[sidenav_text_field_4]" 
           type="number"
           id="sidenav_zin" value="<?php echo $sdnavzin; ?>" 
           min="-1" max="100001">
        <span><?php esc_html_e( 'Set to zero!', 'sidenav' ); ?>
        <small> <em><?php _e( 'Some themes will require you to adjust this.*', 'sidenav' ); ?></em></small>
        </span>   
    <?php 
    } 



    //callback for description of section
    function sidenav_settings_section_callback(  ) {

    echo __( 'Change size of font or turn off menu.', 'sidenav' );

    }


    /**
     * Render a mixmat option on Page.
     *
     * @since    1.0.0
     */
     function sidenav_admin_options_page() {

        echo '<div class="wrap">';
        echo '<p><hr></p><h1><span class="dashicons dashicons-admin-settings" style="font-size: 26px"> 
        </span>&nbsp; ';
        echo esc_html__( ' Sidenav SlideOut Menu', 'sidenav' );
        echo '</h1>'; 
        ?>

        <table class="table"><tbody><tr><td>

        <form action='options.php' method='post'>

        <?php
        settings_fields( 'sidenav_admin_pluginPage' );
        do_settings_sections( 'sidenav_admin_pluginPage' ); ?>

        <?php
        submit_button();
        ?>

        </form></td></tr></tbody></table>
        
        <?php
        echo sidenav_display_admin_instructions();
        echo '</div>';

        }



/**
 * Provide a admin data view for the plugin
 *
 * @since      1.0.0
 *
 * @string $admHTML
 * @returns HTML
 */
function sidenav_display_admin_instructions() {
$iurl =  SIDENAV_URL . '/css/alpha-twitter.png';
$turl = "https://twitter.com/tradesouthwest";
$admHtml = '';
$admHtml .= '<h2>';
$admHtml .= __( 'Menu Builder Information', 'sidenav' );
$admHtml .= '</h2>';
$admHtml .= '
            <table class="widefat"><thead><tr><th>Shortcode</th><th></th></thead><tbody>
            <tr><td><code>[sidenav_nav]</code></td><td> PHP for shortcode is: <code>
            &lt;?php do&#95;shortcode( &#39;sidenav&#95;nav&#39; )&#59; ?&gt;</code> </td></tr></tbody>
            <thead><tr><th>';
$admHtml .= __( 'Style Tips', 'sidenav' ) . '</th><th>';
$admHtml .= __( 'Fine Tunning', 'sidenav' ) . '</th></thead><tbody><tr><td>';
$admHtml .= '<pre>
The following fonts are the best web safe fonts for HTML and CSS:

    Arial (sans-serif)
    Verdana (sans-serif)
    Tahoma (sans-serif)
    Trebuchet MS (sans-serif)
    Times New Roman (serif)
    Georgia (serif)
    Garamond (serif)
    Courier New (monospace)
    Brush Script MT (cursive)
</pre>';

$admHtml .= '<p>' . __( 'The selector for anchor links is <code>#sideNavWrap a</code><br>Plugin should work on most any theme and has been tested on most modern themes. Please let us know if you find a particular problem with any compatibility and we will try to accommodate.','sidenav' );
$admHtml .= '</p></td><td>';
$admHtml .= __( 'Some themes will have a visibility override set at a high value in order to assure that a section on the page is visible on top of another section of the page. This element is called a z-index. You may be required to set a very high z-index by using the Set Visibility setting above in order to get the SideNav to show. Try a few settings above 9000 first then push it higher if the menu is not visible yet. 99999 should be exceedingly high and would not be reccommended unless it is the only thing that works. Otherwise this tells you that the theme may not be compatible with SideNav.', 'sidenav' );
$admHtml .= '<br><strong>' . __( "SET TO ZERO IF NOT USING", "sidenav" ) . '</strong>';
$admHtml .= '</td></tr>';
$admHtml .= '<tr><td><p><a href="https://paypal.me/tradesouthwest" class="button button-primary"  title="paypal.me/tradesouthwest Opens in new window" target="_blank">';
$admHtml .= esc_attr__( 'Donate if you like.', 'sidenav' ) . '</a> | ';
$admHtml .= ' <a href="'.$turl.'" title="Twitter" target="_blank">';
$admHtml .= ' <img src="' . $iurl . '" alt="tweet" width="28" style="position: relative;top:8px;"/></a></span></p></td><td></td></tr> </tbody></table>';
$admHtml .= '<hr>';

    return $admHtml;

}


/**
 * Send css to head
 * @since 1.0.0
 */
function sidenav_display_options_css() {

    echo '<style type="text/css">';
        
    $options = get_option( 'sidenav_settings' );
    $sdnavfont = $options['sidenav_text_field_1'];
    $sdnavfam = $options['sidenav_text_field_2'];
    $sdnavzin = $options['sidenav_text_field_4'];
    
    if( !empty ( $sdnavfont ) ) :
     
    echo '.sidenav a,.sidenav-right a{font-family:'.$sdnavfam.';font-size:'.$sdnavfont.'px;color:#fdfdfd;}';
    else : 
    echo '.sidenav a { font-family: sans-serif; font-size: 1em;}';
    endif;
    
        if( $sdnavzin !== "0" ) {  
        echo '.toggler-container, .sidenav, .sidenav-right {z-index:'.$sdnavzin.';}'; } 
         
    echo '</style>';
}
add_action( 'wp_head', 'sidenav_display_options_css' );


//load display functions
require plugin_dir_path( __FILE__ ) . 'sidenav-editor.php';
