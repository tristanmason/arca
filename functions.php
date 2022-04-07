<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;



/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );



/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {

	// Get the theme data.
	$the_theme = wp_get_theme();

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";

	wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $the_theme->get( 'Version' ) );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $the_theme->get( 'Version' ), true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );



/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );



/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @param string $current_mod The current value of the theme_mod.
 * @return string
 */
function understrap_default_bootstrap_version( $current_mod ) {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );



/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );


/**
 * Load ArCA Google fonts
 */
add_action( 'wp_head', 'arca_google_fonts' );
function arca_google_fonts() {
	?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
	<?php
};

/**
 * Load Lottie animations player on homepage
 */
add_action('wp_head', 'arca_lottie_preconnect');
function arca_lottie_preconnect() {
	if ( is_front_page() ) {
		?>
		<link rel="preconnect" href="https://unpkg.com">
		<?php
	}
};
/*
add_action('wp_footer', 'arca_lottie_preconnect');
function arca_lottie_player() {
	if ( is_front_page() ) {
		?>
		<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
		<?php
	}
}; */

/**
* Integrate Advanced Custom Fields
*/

// ACF Options page.
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page();
}

// Annc bar body class.
function arca_annc_bar_class( $classes ) {
	if ( $annc_bar_enabled = get_field( 'annc_bar_enabled', 'option' ) ) {
		$classes[] = 'annc-bar-enabled';
	}
	return $classes;
}
add_filter( 'body_class','arca_annc_bar_class' );

// Annc bar display
function arca_add_annc_bar() {
	$annc_bar_enabled = get_field('annc_bar_enabled', 'option');
	if ($annc_bar_enabled) {
		$annc_bar_text = get_field('annc_bar_text', 'option');
		$annc_bar_link = get_field('annc_bar_link', 'option');
		echo '<div id="arcaAnncBar">';
		echo $annc_bar_text;
		if( $annc_bar_link ): 
			$link_url = $annc_bar_link['url'];
			$link_title = $annc_bar_link['title'];
			$link_target = $annc_bar_link['target'] ? $link['target'] : '_self';
			?>
			<a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
		<?php endif;
		echo '</div>';
	}
}
add_action( 'wp_body_open', 'arca_add_annc_bar' );

/**
 * Change standard footer copyright info to pull from ACF options page
 */
function remove_parent_functions() {
	remove_action( 'understrap_site_info', 'understrap_add_site_info' );
	add_action( 'understrap_site_info', 'understrap_add_site_child_info' );
}
add_action( 'init', 'remove_parent_functions', 15 );
function understrap_add_site_child_info() {
	?>
	<div class="arca-footer-copyright">Copyright &copy; 2020–<?php echo date('Y') . " "; ?><?php the_field('arca_copyright', 'option'); ?></div>
	<?php
}

/**
 * Insert CSS based on extra page styles from ACF
 */
function arca_acf_dynamic_styles() {
	echo "<style>";
	if ( get_field( 'remove_page_tp' ) ) {
		?>
		#full-width-page-wrapper {
			padding-top: 0;
		}
		<?php
	}
	if ( get_field( 'remove_page_bp' ) ) {
		?>
		#full-width-page-wrapper {
			padding-bottom: 0;
		}
		<?php
	}
	echo "</style>";
}
add_action( 'wp_head', 'arca_acf_dynamic_styles' );

// Function that retrieves alt text for featured images, used in team block
function get_the_post_thumbnail_alt($post_id) {
	return get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true);
}

/**
 * Block content filters
 */
add_filter('render_block', function($block_content, $block) {
    // Add Bootstrap card classes to Yoast FAQ blocks
    if('yoast/faq-block' === $block['blockName']) {
        $block_content = str_replace('schema-faq wp-block-yoast-faq-block', 'schema-faq wp-block-yoast-faq-block row row-cols-1 row-cols-lg-3 g-3 gx-lg-5', $block_content);
        $block_content = str_replace('<div class="schema-faq-section', '<div class="col"><div class="schema-faq-section', $block_content);
		$block_content = str_replace('schema-faq-section', 'schema-faq-section card card-body', $block_content);
		$block_content = str_replace('<strong class="schema-faq-question"', '<h3 class="schema-faq-question"', $block_content);
		$block_content = str_replace('</strong>', '</h3>', $block_content);
        $block_content = str_replace('schema-faq-question', 'schema-faq-question h5 card-title pb-3 mb-3 border-bottom border-primary', $block_content);
        $block_content = str_replace('schema-faq-answer', 'schema-faq-answer card-text text-dark', $block_content);
		$block_content = str_replace('</p>', '</p></div>', $block_content);
    }
    // Always return the content
    return $block_content;
}, 10, 2);
