<?php
/**
 * d64 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package d64
 */

if ( ! defined( 'D64_VERSION' ) ) {
	/*
	 * Set the theme’s version number.
	 *
	 * This is used primarily for cache busting. If you use `npm run bundle`
	 * to create your production build, the value below will be replaced in the
	 * generated zip file with a timestamp, converted to base 36.
	 */
	define( 'D64_VERSION', '0.1.0' );
}

if ( ! defined( 'D64_TYPOGRAPHY_CLASSES' ) ) {
	/*
	 * Set Tailwind Typography classes for the front end, block editor and
	 * classic editor using the constant below.
	 *
	 * For the front end, these classes are added by the `d64_content_class`
	 * function. You will see that function used everywhere an `entry-content`
	 * or `page-content` class has been added to a wrapper element.
	 *
	 * For the block editor, these classes are converted to a JavaScript array
	 * and then used by the `./javascript/block-editor.js` file, which adds
	 * them to the appropriate elements in the block editor (and adds them
	 * again when they’re removed.)
	 *
	 * For the classic editor (and anything using TinyMCE, like Advanced Custom
	 * Fields), these classes are added to TinyMCE’s body class when it
	 * initializes.
	 */
	define(
		'D64_TYPOGRAPHY_CLASSES',
		'prose prose-neutral max-w-none prose-a:text-primary prose-figure:my-4 prose-figure:py-0 prose-figure:text-d64blue-900 prose-figure:!w-[min(100%,640px)] prose-img:max-w-full'
	);
}

if ( ! function_exists( 'd64_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function d64_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on d64, use a find and replace
		 * to change 'd64' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'd64', get_template_directory() . '/languages' );

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

		// This theme uses wp_nav_menu() in two locations.
		// register_nav_menus(
		// 	array(
		// 		'menu-1' => __( 'Primary', 'd64' ),
		// 		'menu-2' => __( 'Footer Menu', 'd64' ),
		// 	)
		// );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Remove support for block templates.
		remove_theme_support( 'block-templates' );
	}
endif;
add_action( 'after_setup_theme', 'd64_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function d64_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer', 'd64' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'd64' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'd64_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function d64_scripts() {
	wp_enqueue_style( 'd64-style', get_stylesheet_uri(), array(), D64_VERSION );
	wp_enqueue_script( 'd64-script', get_template_directory_uri() . '/js/script.min.js', array(), D64_VERSION, true );
	wp_enqueue_script('my-ajax-script', get_template_directory_uri() . '/js/ajax-blog-script.js', array('jquery'), null, true);
	wp_enqueue_script('my-page-search', get_template_directory_uri() . '/js/ajax-page-search.js', array('jquery'), null, true);
	wp_enqueue_script('html2canvas', 'https://html2canvas.hertzen.com/dist/html2canvas.min.js', array(), '1.4.1', true);

	wp_localize_script('my-ajax-script', 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'd64_scripts' );

/**
 * Enqueue the block editor script.
 */
function d64_enqueue_block_editor_script() {
	wp_enqueue_script(
		'd64-editor',
		get_template_directory_uri() . '/js/block-editor.min.js',
		array(
			'wp-blocks',
			'wp-edit-post',
		),
		D64_VERSION,
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'd64_enqueue_block_editor_script' );

/**
 * Create a JavaScript array containing the Tailwind Typography classes from
 * D64_TYPOGRAPHY_CLASSES for use when adding Tailwind Typography support
 * to the block editor.
 */
function d64_admin_scripts() {
	?>
	<script>
		tailwindTypographyClasses = '<?php echo esc_attr( D64_TYPOGRAPHY_CLASSES ); ?>'.split(' ');
	</script>
	<?php
}
add_action( 'admin_print_scripts', 'd64_admin_scripts' );

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function d64_tinymce_add_class( $settings ) {
	$settings['body_class'] = D64_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'd64_tinymce_add_class' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';


/**
 * Excerpt on Pages
 */

function d64_add_excerpt_to_pages() {
    add_post_type_support('page', 'excerpt');
}
add_action('init', 'd64_add_excerpt_to_pages');


// Dont limit the excerpt length
function custom_excerpt_length( $length ) {
	return 999;
}

// Dont add a [...] or Continue Reading link to the excerpt
function new_excerpt_more( $more ) {
	return '';
}


/**
 * Custom Image Sizes
 */

 function theme_custom_image_sizes() {
    // For 16:9 aspect ratio
    add_image_size('large-16-9', 1920, 1080, true); // Large screens
    add_image_size('medium-16-9', 960, 540, true);  // Medium screens/tablets
    add_image_size('small-16-9', 480, 270, true);   // Small screens/mobiles

    // For 1:1 aspect ratio
    add_image_size('large-1-1', 1200, 1200, true);
    add_image_size('medium-1-1', 600, 600, true);
    add_image_size('small-1-1', 300, 300, true);
}
add_action('after_setup_theme', 'theme_custom_image_sizes');


/**
 * Filter Blog Posts
 */
function fetch_filtered_posts() {
    $categories = isset($_POST['categories']) ? $_POST['categories'] : array();
    $authors = isset($_POST['authors']) ? $_POST['authors'] : array();
    $searchTerm = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
	$paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    $args = array(
        'post_type' => 'post',
		'post_status' => 'publish',
        'posts_per_page' => 8,
		'paged' => $paged,
        's' => $searchTerm // This adds the search functionality
    );

    // Filter by categories
    if (!empty($categories)) {
        $args['category__in'] = $categories;
    }

    // Filter by authors
    $meta_queries = array();
    if (!empty($authors)) {
        foreach ($authors as $author) {
            $meta_queries[] = array(
                'key' => 'author',
                'value' => '"' . $author . '"', // Searching for serialized arrays
                'compare' => 'LIKE'
            );
        }
    }

    // If we have meta queries, add them to the query
    if (!empty($meta_queries)) {
        $args['meta_query'] = array('relation' => 'OR') + $meta_queries;
    }

    $query = new WP_Query($args);
    
	$output = array();

    ob_start(); // Begin output buffering

    // Display the posts
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            get_template_part('template-parts/components/post-tile');
        endwhile;
        $output['content'] = ob_get_clean();

        // Add Pagination to the output array
        $output['pagination'] = paginate_links(array(
            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'format' => '?paged=%#%',
            'current' => $paged,
            'total' => $query->max_num_pages,
            'type' => 'plain',
            'show_all' => false,
            'end_size' => 1,
            'mid_size' => 0,
            'prev_next' => true,
            'prev_text' => __('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>'),
            'next_text' => __('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>'),
            'add_args' => false,
            'add_fragment' => '',
        ));
    else :
	$page = get_page_by_path('aktuelles');
	if ($page) :
    $no_content = get_field('no-content', $page->ID);
    $output['content'] = '<div class="place-center w-full flex flex-col gap-2 text-center">
        <div class="pb-2 ">
            <span class="text-8xl w-10 rounded-full">🔍</span>
        </div>
        <p class="text-center">' . $no_content . '</p>
    </div>';
    $output['pagination'] = '';
	endif;
endif;
    wp_reset_postdata();

    // Send JSON response
    wp_send_json($output);
    die();
}
add_action('wp_ajax_fetch_filtered_posts', 'fetch_filtered_posts'); 
add_action('wp_ajax_nopriv_fetch_filtered_posts', 'fetch_filtered_posts');


//Options Page for Custom Navigation Menu 
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Navigation',
        'menu_title' => 'Navigation',
        'menu_slug'  => 'navigation',
        'capability' => 'edit_posts',
        'redirect'   => false,
		'icon_url'  => 'dashicons-list-view',
		'position' => '30'
    ));
}

// Whitelist Gutenberg Blocks
function my_allowed_block_types( $allowed_blocks ) {
    return array(
        'core/paragraph',
        'core/heading',
        'core/list',
        'core/quote',
        'core/table',
        'core/image',
        'core/seperator',
        'core/youtube',
        'core/pullquote',
		'core/shortcode',
		'core/buttons',
        // ... other block names
    );
}
add_filter( 'allowed_block_types', 'my_allowed_block_types' );

