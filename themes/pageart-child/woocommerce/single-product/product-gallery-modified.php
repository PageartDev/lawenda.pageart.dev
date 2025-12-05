<?php
/**
 * Modified Product Gallery Template
 * 
 * This template creates a gallery with:
 * - Main photo without arrows
 * - Vertical thumbnails on the left with arrows
 * - Draggable main photo
 * 
 * @package PA Modified Gallery
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attachment_ids = $product->get_gallery_image_ids();
$main_image_id = $product->get_image_id();

// Ensure featured image is first and remove duplicates
if ( $main_image_id ) {
    // Remove featured image from gallery if it exists there (to avoid duplicates)
    $attachment_ids = array_filter( $attachment_ids, function( $id ) use ( $main_image_id ) {
        return $id != $main_image_id;
    } );
    // Prepend featured image to ensure it's always first
    $attachment_ids = array_merge( array( $main_image_id ), $attachment_ids );
}

if ( empty( $attachment_ids ) ) {
    return;
}

// Get plugin options
$options = get_option( 'pa_gallery_settings', array() );
$enable_drag = isset( $options['enable_drag'] ) ? $options['enable_drag'] : 1;
$thumbnail_size = isset( $options['thumbnail_size'] ) ? $options['thumbnail_size'] : 'thumbnail';

// Get all images
$images = array();
foreach ( $attachment_ids as $attachment_id ) {
    $images[] = array(
        'id' => $attachment_id,
        'full' => wp_get_attachment_image_url( $attachment_id, 'full' ),
        'large' => wp_get_attachment_image_url( $attachment_id, 'large' ),
        'medium' => wp_get_attachment_image_url( $attachment_id, 'medium' ),
        'thumbnail' => wp_get_attachment_image_url( $attachment_id, $thumbnail_size ),
        'alt' => get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ),
        'title' => get_the_title( $attachment_id ),
    );
}
?>

<div class="pa-gallery-modified" data-enable-drag="<?php echo esc_attr( $enable_drag ); ?>">
    <div class="pa-gallery-wrap-modified">
        <!-- Thumbnail Gallery (Left Column) -->
        <div class="pa-gallery-thumbs-modified">
            <div class="pa-thumbs-container">
                <button class="pa-thumb-prev slick-arrow" aria-label="<?php esc_attr_e( 'Previous', 'pa-modified-gallery' ); ?>" type="button">
                    <i class="fas fa-chevron-up"></i>
                </button>
                <div class="pa-thumbs-slider">
                    <?php foreach ( $images as $index => $image ) : ?>
                        <div class="pa-thumb-slide-modified <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo esc_attr( $index ); ?>" tabindex="0" role="button" aria-label="<?php echo esc_attr( sprintf( __( 'View image %d', 'pa-modified-gallery' ), $index + 1 ) ); ?>">
                            <img 
                                src="<?php echo esc_url( $image['thumbnail'] ); ?>" 
                                alt="<?php echo esc_attr( $image['alt'] ); ?>" 
                                title="<?php echo esc_attr( $image['title'] ); ?>"
                                class="pa-thumb-img-modified"
                                loading="lazy"
                                decoding="async"
                            />
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="pa-thumb-next slick-arrow" aria-label="<?php esc_attr_e( 'Next', 'pa-modified-gallery' ); ?>" type="button">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>

        <!-- Main Gallery (Right Column) -->
        <div class="pa-gallery-main-modified">
            <div class="pa-main-container">
                <?php foreach ( $images as $index => $image ) : ?>
                    <div class="pa-main-slide-modified <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo esc_attr( $index ); ?>">
                        <img 
                            src="<?php echo esc_url( $image['large'] ); ?>" 
                            alt="<?php echo esc_attr( $image['alt'] ); ?>" 
                            title="<?php echo esc_attr( $image['title'] ); ?>"
                            class="pa-main-img-modified"
                            loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>"
                            decoding="async"
                            fetchpriority="<?php echo $index === 0 ? 'high' : 'low'; ?>"
                        />
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
