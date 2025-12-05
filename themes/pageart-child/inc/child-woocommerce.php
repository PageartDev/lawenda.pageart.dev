<?php

add_action('wp_enqueue_scripts', function () {
    if (class_exists('WooCommerce')) {
        wp_enqueue_script('wc-cart-fragments');
    }
}, 20);

add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    if (!class_exists('WooCommerce') || !function_exists('WC') || !WC()->cart) {
        return $fragments;
    }

    ob_start();
    $count = WC()->cart->get_cart_contents_count();
    ?>
    <span class="badge rounded-pill bg-primary position-absolute top-0 start-100 translate-middle js-cart-count">
        <?php echo esc_html($count); ?>
    </span>
    <?php
    $fragments['.js-cart-count'] = ob_get_clean();

    ob_start();
    ?>
    <div class="widget_shopping_cart_content">
        <?php woocommerce_mini_cart(); ?>
    </div>
    <?php
    $fragments['.widget_shopping_cart_content'] = ob_get_clean();

    return $fragments;
});


// Remove old buttons
remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10);
remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20);

// Added new buttons
add_action('woocommerce_widget_shopping_cart_buttons', function () {
    echo '<a href="' . esc_url(wc_get_cart_url()) . '" class="btn btn-outline-primary">' . esc_html__('View cart', 'woocommerce') . '</a>';
    echo '<a href="' . esc_url(wc_get_checkout_url()) . '" class="btn btn-primary">' . esc_html__('Checkout', 'woocommerce') . '</a>';
}, 30);

add_filter('body_class', function ($classes) {
//    if (function_exists('is_cart') && is_cart()) {
//        $classes[] = 'woocommerce';
//    }
//
//    if (function_exists('is_checkout') && is_checkout()) {
//        $classes[] = 'woocommerce';
//    }
//
//    if(is_front_page() || is_home()) {
//        $classes[] = 'woocommerce';
//    }

    $classes[] = 'woocommerce';

    return $classes;
});


// Nadpisanie klas przycisku "Dodaj do koszyka" w blokach WooCommerce
add_filter('render_block', function ($block_content, $block) {
    // Sprawdzamy, czy to jest blok WooCommerce z produktami
    if (isset($block['blockName']) && strpos($block['blockName'], 'woocommerce/product') !== false) {
        // Zamiana klas w linkach "Dodaj do koszyka"
        $block_content = preg_replace(
                '/class="([^"]*?)add_to_cart_button([^"]*?)"/',
                'class="btn btn-primary add_to_cart_button ajax_add_to_cart"',
                $block_content
        );
    }
    return $block_content;
}, 10, 2);


add_action('woocommerce_before_shop_loop', 'otworz_wrapper_naglowka_listy', 15);
function otworz_wrapper_naglowka_listy()
{
    echo '<div class="cat-wc-head-info">';
    echo '<button class="d-md-none btn-trigger-filters">Filtry <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <mask id="mask0_112_1045" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                <rect width="20" height="20" fill="#D9D9D9"/>
                </mask>
                <g mask="url(#mask0_112_1045)">
                <path d="M10.0002 12.5L5.8335 8.33334H14.1668L10.0002 12.5Z" fill="#1C1B1F"/>
                </g>
                </svg>
                </button>';
}

add_action('woocommerce_before_shop_loop', 'zamknij_wrapper_naglowka_listy', 35);
function zamknij_wrapper_naglowka_listy()
{
    echo '</div>';
}


add_action('wp_footer', function () {
    if (!class_exists('WooCommerce')) {
        return;
    }

    $bootstrap_version = get_theme_mod('understrap_bootstrap_version', 'bootstrap4');

    if ('bootstrap5' !== $bootstrap_version) {
        return;
    }
    ?>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="miniCartOffcanvas"
         aria-labelledby="miniCartOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="miniCartOffcanvasLabel">
                <?php esc_html_e('Your cart', 'woocommerce'); ?>
            </h5>
            <button type="button" class="btn-close text-reset"
                    data-bs-dismiss="offcanvas"
                    aria-label="<?php esc_attr_e('Close', 'woocommerce'); ?>"></button>
        </div>

        <div class="offcanvas-body">
            <div class="widget_shopping_cart_content">
                <?php woocommerce_mini_cart(); ?>
            </div>
        </div>
    </div>

    <?php
});