<?php
/**
 * Retrieve ACF fields
 * Note: The text content is retrieved via the standard WordPress editor: the_content()
 */
$why_image    = get_field('why_lavender_section_image');    // Type: Image (Array)
$why_subtitle = get_field('why_lavender_section_subtitle'); // Type: Text
$why_title    = get_field('why_lavender_section_title');    // Type: Text
?>

<section class="why-lavender-section">
    <div class="container">
        <div class="row">
            
            <div class="col-md-5">
                <?php if( $why_image ): ?>
                    <img src="<?php echo esc_url($why_image['url']); ?>" alt="<?php echo esc_attr($why_image['alt']); ?>">
                <?php endif; ?>
            </div>

            <div class="col-md-7">
                
                <?php if( $why_subtitle ): ?>
                    <div class="subtitle">
                        <?php echo esc_html($why_subtitle); ?>
                    </div>
                <?php endif; ?>

                <?php if( $why_title ): ?>
                    <h3>
                        <?php echo esc_html($why_title); ?>
                    </h3>
                <?php endif; ?>

                <div class="text-area">
                    <?php the_content(); ?>
                </div>

            </div>
        </div>
    </div>
</section>