<?php
/**
 * PA Modified Product Gallery – wersja pod motyw (bez enqueue CSS/JS)
 */


/**
 * Inicjalizacja po załadowaniu motywu
 */
add_action('after_setup_theme', 'pa_modified_gallery_setup');

function pa_modified_gallery_setup()
{

    // Teksty (opcjonalnie, jeśli chcesz tłumaczenia)
    load_child_theme_textdomain(
            'pa-modified-gallery',
            get_stylesheet_directory() . '/languages'
    );

    // Sprawdzenie WooCommerce
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', 'pa_modified_gallery_woocommerce_missing_notice');
        return;
    }

    // Usuwamy domyślną galerię WooCommerce
    remove_action(
            'woocommerce_before_single_product_summary',
            'woocommerce_show_product_images',
            20
    );

    // Dodajemy naszą zmodyfikowaną galerię
    add_action(
            'woocommerce_before_single_product_summary',
            'pa_modified_gallery_show',
            20
    );

    // Ustawienia w panelu
    if (is_admin()) {
        add_action('admin_menu', 'pa_modified_gallery_add_admin_menu');
        add_action('admin_init', 'pa_modified_gallery_admin_init');
    }
}

/**
 * Komunikat gdy WooCommerce nie jest aktywny
 */
function pa_modified_gallery_woocommerce_missing_notice()
{
    echo '<div class="error"><p><strong>' .
            esc_html__('PA Modified Product Gallery', 'pa-modified-gallery') .
            '</strong> ' .
            esc_html__('requires WooCommerce to be installed and active.', 'pa-modified-gallery') .
            '</p></div>';
}

/**
 * Wyświetlenie zmodyfikowanej galerii na stronie produktu
 */
function pa_modified_gallery_show()
{
    global $product;

    if (!$product) {
        return;
    }

    $attachment_ids = $product->get_gallery_image_ids();
    $main_image_id = $product->get_image_id();

    if (!$main_image_id && empty($attachment_ids)) {
        return;
    }

    pa_modified_gallery_load_template('single-product/product-gallery-modified.php');
}

/**
 * Wczytanie szablonu z motywu
 *
 * Szukamy:
 *  /your-child-theme/woocommerce/single-product/product-gallery-modified.php
 */
function pa_modified_gallery_load_template($relative_path)
{
    $template_path = trailingslashit(get_stylesheet_directory()) . 'woocommerce/' . $relative_path;

    if (file_exists($template_path)) {
        include $template_path;
    }
}

/**
 * Dodanie strony z ustawieniami
 */
function pa_modified_gallery_add_admin_menu()
{
    add_options_page(
            __('PA Modified Gallery Settings', 'pa-modified-gallery'),
            __('PA Modified Gallery', 'pa-modified-gallery'),
            'manage_options',
            'pa-modified-gallery',
            'pa_modified_gallery_admin_page'
    );
}

/**
 * Rejestracja ustawień
 */
function pa_modified_gallery_admin_init()
{
    // Domyślne opcje, jeśli jeszcze nie istnieją
    if (false === get_option('pa_gallery_settings')) {
        $default_options = array(
                'enable_drag' => 1,
                'thumbnail_size' => 'thumbnail',
        );
        add_option('pa_gallery_settings', $default_options);
    }

    register_setting('pa_modified_gallery_settings', 'pa_gallery_settings');

    add_settings_section(
            'pa_gallery_section',
            __('Gallery Settings', 'pa-modified-gallery'),
            'pa_modified_gallery_settings_section_callback',
            'pa-modified-gallery'
    );

    add_settings_field(
            'enable_drag',
            __('Enable Drag Support', 'pa-modified-gallery'),
            'pa_modified_gallery_enable_drag_callback',
            'pa-modified-gallery',
            'pa_gallery_section'
    );

    add_settings_field(
            'thumbnail_size',
            __('Thumbnail Size', 'pa-modified-gallery'),
            'pa_modified_gallery_thumbnail_size_callback',
            'pa-modified-gallery',
            'pa_gallery_section'
    );
}

/**
 * Opis sekcji
 */
function pa_modified_gallery_settings_section_callback()
{
    echo '<p>' . esc_html__('Configure the modified gallery settings.', 'pa-modified-gallery') . '</p>';
}

/**
 * Checkbox: Enable Drag
 */
function pa_modified_gallery_enable_drag_callback()
{
    $options = get_option('pa_gallery_settings');
    $enabled = isset($options['enable_drag']) ? (int)$options['enable_drag'] : 1;

    echo '<input type="checkbox" name="pa_gallery_settings[enable_drag]" value="1" ' .
            checked(1, $enabled, false) . ' />';
}

/**
 * Select: Thumbnail Size
 */
function pa_modified_gallery_thumbnail_size_callback()
{
    $options = get_option('pa_gallery_settings');
    $size = isset($options['thumbnail_size']) ? $options['thumbnail_size'] : 'thumbnail';

    $sizes = array(
            'thumbnail' => __('Thumbnail (150x150)', 'pa-modified-gallery'),
            'medium' => __('Medium (300x300)', 'pa-modified-gallery'),
            'large' => __('Large (1024x1024)', 'pa-modified-gallery'),
    );

    echo '<select name="pa_gallery_settings[thumbnail_size]">';
    foreach ($sizes as $value => $label) {
        echo '<option value="' . esc_attr($value) . '" ' .
                selected($size, $value, false) . '>' .
                esc_html($label) . '</option>';
    }
    echo '</select>';
}

/**
 * Strona ustawień w panelu
 */
function pa_modified_gallery_admin_page()
{
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('pa_modified_gallery_settings');
            do_settings_sections('pa-modified-gallery');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}