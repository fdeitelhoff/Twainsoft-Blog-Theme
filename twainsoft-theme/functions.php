<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Twainsoft Blog Theme' );
define( 'CHILD_THEME_URL', 'http://www.fabiandeitelhoff.de' );
define( 'CHILD_THEME_VERSION', '0.0.4' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css', array(), CHILD_THEME_VERSION );
	
}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

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

// Add an own reading more filter without the jumping functionality.
add_filter('the_content_more_link', 'twainsoft_read_more_without_jumping');
function twainsoft_read_more_without_jumping($post) {
     return '<p><a href="'.get_permalink($post->ID).'" class="read-more">'. __( '[Read more...]', 'genesis' ) .'</a></p>';
}

// Change the separator and the label for the breadcrumb.
add_filter( 'genesis_breadcrumb_args', 'sp_breadcrumb_args' );
function sp_breadcrumb_args( $args ) {
	$args['sep'] = ' &raquo; ';
	$args['labels']['prefix'] = '&raquo; ';

	return $args;
}

// Add a new filter to change the post info information.
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	if ( !is_page() ) {
		return '<i class="fa fa-calendar"></i> [post_date] [post_edit_datetime] <i class="fa fa-user"></i> [post_author_posts_link]'; // [post_comments]';
	}
}

// Add a new shortcode for the edit date and time of an post.
add_shortcode( 'post_edit_datetime', 'sp_post_edit_datetime' );
function sp_post_edit_datetime() {
    $artikel_erstellt = get_the_date('U');
    $artikel_aktualisiert = get_post_modified_time('U');

    // Will be shown if the post was edited 12 hours after it was published.
    if (($artikel_aktualisiert - $artikel_erstellt ) > 43200)
    {
        return '<i class="fa fa-pencil-square-o" title="Post Edit Date & Time"></i> <time class="entry-edit-time" title="Post Edit Date & Time" itemprop="dateEdited" datetime="' . get_the_modified_date('c') . '">' . get_the_modified_date('d. F Y') . ' - ' . get_post_modified_time('H:i') . '</time>';
    }
	
	return '';
}

// Remove the old Genesis entry header action, add our own and then re-add the Genesis function for the header.
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action( 'genesis_entry_header', 'sp_genesis_entry_header' );
add_action( 'genesis_entry_header', 'genesis_do_post_title' );
function sp_genesis_entry_header() {
    echo sprintf ('<p class="entry-reading-data"><i class="fa fa-clock-o"></i> %1$s, %2$s W&ouml;rter %3$s %4$s</p>', post_read_time(), sp_post_word_count(), genesis_post_comments_shortcode(''), genesis_post_edit_shortcode('') );
}

// Shortcode for the word count of a post.
add_shortcode( 'post_word_count', 'sp_post_word_count' );
function sp_post_word_count() {
	$content = get_post_field( 'post_content', $post->ID );
	$count = str_word_count( strip_tags( $content ) );
 
	return $count;
}