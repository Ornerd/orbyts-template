<?php
/**
 * CT Custom functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package CT_Custom
 */

if ( ! function_exists( 'ct_custom_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ct_custom_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on CT Custom, use a find and replace
		 * to change 'ct-custom' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ct-custom', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'ct-custom' ),
			'menu-2' => esc_html__( 'Secondary', 'ct-custom' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'ct_custom_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'ct_custom_setup' );

function add_last_item_indicator($items, $args) { //code snippet to help determine the last item in the sub menu
    $total = count($items);
    foreach ($items as $index => $item) {
        if ($index === $total) {
            $item->last_item = true;
        }
    }
    return $items;
}
add_filter('wp_nav_menu_objects', 'add_last_item_indicator', 10, 2);


class Coalition_Nav_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) { //readjusting the menu using the nav walker to match my already designed menu template
		if ($depth === 0) {
    	$output .= '<div class="nav-element">';
        $output .= '<a href="' . esc_url($item->url) . '" class="first-nav">';
        $output .= esc_html($item->title);
        $output .= '</a>';

        $output .= '<span></span>';
		}elseif ($depth === 1) {
            $output .= '<li>';
            $output .= '<a href="' . esc_attr($item->url) . '" class="first-sub-nav">';
            $output .= esc_html($item->title);
            $output .= '</a>';
        }else {
			$output .= '<li>';
            $output .= '<a href="' . esc_attr($item->url) . '" >';
            $output .= esc_html($item->title);
            $output .= '</a>';
		}
    }

    function end_el(&$output, $item, $depth = 0, $args = array()) {
		if ($depth === 0) {
			$output .= '</div>'; 
		}else {
			$output .= '</li>';
		}
       
    }

	function start_lvl(&$output, $depth = 0, $args = array()) {
        if ($depth === 0) {
            $output .= '<ul class="sub-nav">';
        } else {
            $output .= '<ul class="sub-sub-nav">';  
		}
    }

    // End the sub-menu output.
    function end_lvl(&$output, $depth = 0, $args = array()) {
        $output .= '</ul>';
    }
}

class Mini_Nav_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		$classes = !empty($item->classes) ? implode(' ', $item->classes) : ''; //snippet by chat GPT, to help stringify classes for use in nav menu
        $output .= '<a href="' . esc_attr($item->url) . '" class="'. esc_attr($classes) .'">';
        $output .= esc_html($item->title) . '</a> ';

        if ($depth === 0 && empty($item->last_item)) { //where the add_last_item_indicator was useful
        	$output .= ' / ';
        }
    }
}


//START OF CUSTOM THEME SETTINGS CONFIG
function c_theme_settings_page() { //function that displays the theme menu among other wordpress menus.
    add_menu_page(
        'C-Theme Settings',  // Page title
        'C-Theme Settings',  // Menu title
        'manage_options',  // Capability
        'c_theme_settings',  // Menu slug
        'c_theme_settings_config',  // Callback function
        'dashicons-admin-generic',  // gotten from https://developer.wordpress.org/resource/dashicons/#admin-generic
        62// Position in the admin menu, I refered to wordpress add_menu_page documention to carefully decide on what number to use.
    );
}
add_action('admin_menu', 'c_theme_settings_page');

function c_theme_settings_config() {//the page for all my sections, and fields.
	?>
    <div>
        <h1>Coalition Theme Settings</h1>
		<span>
			<?php settings_errors(); ?>
		</span>
        <form method="post" action="options.php">
            <?php
            settings_fields('c_custom_theme_settings_group');
            do_settings_sections('c_theme_settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function c_theme_settings_setup() {
    // Section 1: Logo Upload
    add_settings_section(   // provides area to register your setting fields. eg: one section name can have three fields namely surname, firstname and middlename.
		'c_custom_section_logo', // section id, to help locate where this setting will be categorized.
	 	'Logo Settings',          // settings title–not if sure it's the setting's label though.
		null,                    // a callback function for the setting menu. We don't need one so it'll be set to null
		'c_theme_settings'       // associated with menu slug as in add_menu-page() method
	);

    // Logo upload field
    add_settings_field(
		'c_custom_logo', //field id
		'Upload Logo', //field name
		'c_logo_field', //associated callback function that'll play a role in what this setting will look like.
		'c_theme_settings', //slug again...., this time it's the slug name where this section would be displayed. It may or may not be different from this available slug 
		'c_custom_section_logo'  //same as section id
	);
	register_setting('c_custom_theme_settings_group', 'c_custom_logo');

    add_settings_field(
		'c_custom_logo_width', 
		'Logo Width (px)', 
		'c_logo_field_width', 
		'c_theme_settings', 
		'c_custom_section_logo'
	);
	register_setting('c_custom_theme_settings_group', 'c_custom_logo_width');

    add_settings_field(
		'c_custom_logo_height', 
		'Logo Height (px)', 
		'c_logo_field_height', 
		'c_theme_settings', 
		'c_custom_section_logo'
	);
	register_setting('c_custom_theme_settings_group', 'c_custom_logo_height');

	function c_logo_field() {
		$logo = get_option('c_custom_logo');
		echo '
		<input type="url" name="c_custom_logo" value="' . esc_attr($logo) . '" id="c_custom_logo" />
		<p>*Paste the url of your already uploaded logo in the media database, or any other url to your logo.</p>
		';
	}
	function c_logo_field_width() {
		$logoWidth = get_option('c_custom_logo_width');
		echo ' <input type="number" name="c_custom_logo_width" value="' . esc_attr($logoWidth) . '" id="c_custom_logo_width" />';
	}
	function c_logo_field_height() {
		$logoHeight = get_option('c_custom_logo_height');
		echo ' <input type="number" name="c_custom_logo_height" value="' . esc_attr($logoHeight) . '" id="c_custom_logo_height" />';
	}


// Section 2: Contact Information
    add_settings_section(
		'c_custom_section_contact', 
		'Contact Information',
		 null, 
		'c_theme_settings'
	);
    // Phone number
    add_settings_field(
		'c_custom_phone_number', 
		'Phone Number', 
		'c_custom_phone_number_input_field', 
		'c_theme_settings', 
		'c_custom_section_contact'
	);
    register_setting('c_custom_theme_settings_group', 'c_custom_phone_number');

    // Address
    add_settings_field(
		'c_custom_address', 
		'Address', 
		'c_custom_address_input_field', 
		'c_theme_settings', 
		'c_custom_section_contact'
	);
    register_setting('c_custom_theme_settings_group', 'c_custom_address');

    // Fax number
    add_settings_field(
		'c_custom_fax_number', 
		'Fax Number', 
		'c_custom_fax_number_input_field', 
		'c_theme_settings', 
		'c_custom_section_contact'
	);
    register_setting('c_custom_theme_settings_group', 'c_custom_fax_number');

	function c_custom_phone_number_input_field() {
		$phoneNumber = get_option('c_custom_phone_number');
		echo '<input type="text" value="' . esc_html($phoneNumber) . '" name="c_custom_phone_number" id="c_custom_phone_number" />';
	}
	function c_custom_address_input_field() {
		$address = get_option('c_custom_address');
		echo '<input type="text" value="' . esc_html($address) . '" name="c_custom_address" id="c_custom_address" />';
	}
	function c_custom_fax_number_input_field() {
		$fax = get_option('c_custom_fax_number');
		echo '<input type="text" value="' . esc_html($fax) . '" name="c_custom_fax_number" id="c_custom_fax_number">';
	}


    // Section 3: Social Media Links
    add_settings_section(
		'c_custom_section_social', 
		'Social Media Links', 
		null, 
		'c_theme_settings'
	);

    // Facebook
    add_settings_field(
		'c_custom_facebook', 
		'Facebook URL', 
		'c_custom_facebook_field', 
		'c_theme_settings', 
		'c_custom_section_social'
	);
    register_setting('c_custom_theme_settings_group', 'c_custom_facebook'); 

    // LinkedIn
    add_settings_field(
		'c_custom_linkedIn',
		'LinkedIn URL', 
		'c_custom_linkedIn_field', 
		'c_theme_settings', 
		'c_custom_section_social'
	);
    register_setting('c_custom_theme_settings_group', 'c_custom_linkedIn');

    // Pinterest
    add_settings_field(
		'c_custom_pinterest',
		'Pinterest URL', 
		'c_custom_pinterest_field', 
		'c_theme_settings', 
		'c_custom_section_social'
	);
    register_setting('c_custom_theme_settings_group', 'c_custom_pinterest');

	function c_custom_facebook_field(){
		$facebookURL = get_option('c_custom_facebook');
		echo '<input type="url" name="c_custom_facebook" value="' . esc_url($facebookURL) . '" id="c_custom_facebook"/>';
	}
	function c_custom_linkedIn_field(){
		$linkedInURL = get_option('c_custom_linkedIn');
		echo '<input type="url" name="c_custom_linkedIn" value="' . esc_url($linkedInURL) . '" id="c_custom_linkedIn"/>';
	}
	function c_custom_pinterest_field(){
		$pinterestURL = get_option('c_custom_pinterest');
		echo '<input type="url" name="c_custom_pinterest" value="' . esc_url($pinterestURL) . '" id="c_custom_pinterest"/>';
	}
}
add_action('admin_init', 'c_theme_settings_setup');



/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ct_custom_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'ct_custom_content_width', 640 );
}
add_action( 'after_setup_theme', 'ct_custom_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ct_custom_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ct-custom' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ct-custom' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'ct_custom_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ct_custom_scripts() {
	wp_enqueue_style( 'ct-custom-style', get_stylesheet_uri() );

	wp_enqueue_style( 'custom-theme-styles', get_template_directory_uri() . '/css/styles.css' );

	wp_enqueue_script( 'ct-custom-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'ct-custom-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ct_custom_scripts' );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
