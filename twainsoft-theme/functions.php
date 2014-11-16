<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Genesis Sample Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.1.2' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700', array(), CHILD_THEME_VERSION );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );


/************************************************************************
 *
 * Some special adjustments for the Twainsoft Blog Theme.
 *
 ************************************************************************
 */

// Add the specific filter to change the language to German.
add_action( 'after_setup_theme', 'twainsoft_child_theme_setup' );
function twainsoft_child_theme_setup() {
    load_child_theme_textdomain( 'genesis', get_stylesheet_directory() . '/languages' );
}

// Remove the original Genesis footer first. I want my own footer.
remove_action( 'genesis_footer', 'genesis_do_footer' );

// And this add my own footer as an action.
add_action( 'genesis_footer', 'twainsoft_do_footer' );
function twainsoft_do_footer() {
	echo 'Copyright &copy; ' . get_bloginfo("name") . ' 2012 - ' . date("Y") . ' | Theme based upon the <a href="http://my.studiopress.com/themes/genesis/" title="Studiopress Genesis Framework">Genesis Framework</a>.';
}