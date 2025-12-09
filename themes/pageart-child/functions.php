<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

defined('ABSPATH') || exit;

$child_inc_dir = 'inc';

$child_includes = array(
    '/child-enqueue.php',        // style + skrypty + Google Fonts + usunięcie parenta
    '/child-setup.php',          // textdomain, bootstrap5, CF7 autop
    '/child-customizer.php',     // skrypty dla customizera
    '/child-template-tags.php',     // skrypty dla customizera

    // PLUGINS
    '/plugins/body-classes.php',   // dodatkowe klasy w <body>
    '/plugins/svg-support.php',    // obsługa SVG
//    '/plugins/disable-comments.php', // globalne wyłączenie komentarzy
    '/plugins/disable-xmlrpc.php', // wylaczenie pliku xmlrpc
);

if (class_exists('WooCommerce')) {
    $child_includes[] = '/child-woocommerce.php'; // rzeczy do woocommerce
//    $child_includes[] = '/plugins/modified-gallery.php'; // zmodyfikowana galeria woocommerce
}

foreach ($child_includes as $file) {
    $path = get_stylesheet_directory() . '/' . $child_inc_dir . $file;
    if (file_exists($path)) {
        require_once $path;
    }
}












/**
 * Register "Footer Map" widget area.
 * Add this code to your functions.php file.
 */
function register_footer_map_widget() {
    register_sidebar( array(
        'name'          => 'Footer map',          // The name visible in WP Admin
        'id'            => 'footer_map_area',     // The unique ID used to call the widget
        'description'   => 'Place your map widget or HTML code here.',
        'before_widget' => '<div id="%1$s" class="footer-map-widget %2$s">', // Wrapper for the widget
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-map-title">',
        'after_title'   => '</h4>',
    ) );
}
// Hook into the 'widgets_init' action to register the sidebar
add_action( 'widgets_init', 'register_footer_map_widget' );



/**
 * Register "Menu Right Section" widget area.
 */
function register_menu_right_widget() {
    register_sidebar( array(
        'name'          => esc_html__( 'Menu right section', 'understrap' ),
        'id'            => 'menu_right_section', // Уникальный ID
        'description'   => esc_html__( 'Widgets added here will appear in the right section of the menu.', 'understrap' ),
        'before_widget' => '<div id="%1$s" class="menu-right-item %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ) );
}
add_action( 'widgets_init', 'register_menu_right_widget' );



/**
 * Register "Float Element" widget area.
 */
function register_float_element_widget() {
    register_sidebar( array(
        'name'          => esc_html__( 'Float element', 'understrap' ),
        'id'            => 'float_element_area',
        'description'   => esc_html__( 'Widgets added here will float fixed on the screen (e.g., chat button).', 'understrap' ),
        'before_widget' => '<div id="%1$s" class="float-widget-item %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="d-none">', // Скрываем заголовок, обычно он не нужен плавающим кнопкам
        'after_title'   => '</h5>',
    ) );
}
add_action( 'widgets_init', 'register_float_element_widget' );




/**
 * 1. Function to render Page Sections.
 * Logic: 
 * - If a specific template file exists (e.g. page-sections/slug.php), load it.
 * - If NO template file exists, but the post has content in the Editor, render the default layout.
 */
function render_custom_page_sections() {
    $sections = get_field('page_sections');

    if ( $sections ) :
        global $post; 

        foreach ( $sections as $post ) : 
            setup_postdata( $post );
            
            $slug = $post->post_name;
            $file_path = 'page-sections/' . $slug . '.php';

            // 1. Check if a specific PHP template exists for this section
            if ( locate_template( $file_path ) ) {
                
                get_template_part( 'page-sections/' . $slug );

            } 
            // 2. Fallback: If no file exists, check if there is content in the Editor
            elseif ( get_the_content() ) { 
                ?>
                <section class="custom_section section-<?php echo esc_attr($slug); ?>">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                </section>
                <?php
            }

        endforeach;

        wp_reset_postdata(); 
    endif;
}

/**
 * 2. Action to inject sections BEFORE the footer starts.
 * Ensures sections are full-width.
 */
function inject_sections_before_footer() {
    if ( is_singular() ) {
        render_custom_page_sections();
    }
}

// 3. Hook into 'get_footer'
add_action( 'get_footer', 'inject_sections_before_footer', 5 );