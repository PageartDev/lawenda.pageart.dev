<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$container = get_theme_mod('understrap_container_type');
?>


<?php if ( is_active_sidebar( 'footer_map_area' ) ) : ?>
    <div class="footer-map-container">
        <?php dynamic_sidebar( 'footer_map_area' ); ?>
    </div>
<?php endif; ?>



<?php get_template_part('sidebar-templates/sidebar', 'footerfull'); ?>

<div class="wrapper bg-black" id="wrapper-footer">

    <div class="<?php echo esc_attr($container); ?>">

        <div class="row">

            <div class="col-md-6">
                <p>
                   <?php 
                        printf( 
                            esc_html__( 'Lawenda warszawa © %s Wszelkie prawa zastrzeżone', 'understrap' ), 
                            date( 'Y' ) 
                        ); 
                    ?>
                </p>

            </div>
            <div class="col-md-6">
                <p>
                    <?php
                    echo sprintf(
                    /* translators: 1: Theme name, 2: Theme author */
                            esc_html__('Realizacja: %1$s', 'understrap'),
                            '<a href="' . esc_url(__('https://pageart.agency', 'understrap')) . '" target="_blank">
                                    <img src="/wp-content/uploads/2025/12/pageart_logo.svg">
                                </a>'
                    );
                    ?>
                </p>

            </div>


        </div><!-- .row -->

    </div><!-- .container(-fluid) -->

    <!-- Float element -->
    <?php if ( is_active_sidebar( 'float_element_area' ) ) : ?>
    
        <div class="float-element-container">
            <?php dynamic_sidebar( 'float_element_area' ); ?>
        </div>

    <?php endif; ?>

</div><!-- #wrapper-footer -->

<?php // Closing div#page from header.php. ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>

