<?php
/**
 * Retrieve ACF fields
 */
$form_title    = get_field('form_section_title');    // Type: Text
$form_subtitle = get_field('form_section_subtitle'); // Type: Text
?>

<section class="form_section">
    <div class="container">
        <div class="row">
            
            <div class="col-md-6 title_col">
                
                <?php if( $form_title ): ?>
                    <h3 class="title">
                        <?php echo esc_html($form_title); ?>
                    </h3>
                <?php endif; ?>

                <?php if( $form_subtitle ): ?>
                    <div class="subtitle">
                        <?php echo esc_html($form_subtitle); ?>
                    </div>
                <?php endif; ?>

            </div>

            <div class="col-md-6 form_col">
                <?php
                    /**
                     * Get the content of the post.
                     * We use do_shortcode() to ensure that if the content contains 
                     * a shortcode (like [contact-form-7]), it is executed and rendered properly.
                     * wpautop() is added to keep paragraph formatting for regular text.
                     */
                    $content = get_the_content();
                    echo do_shortcode( wpautop( $content ) );
                ?>
            </div>

        </div>
    </div>
</section>