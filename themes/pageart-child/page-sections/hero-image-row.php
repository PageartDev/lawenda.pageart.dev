<?php
/**
 * Template part for displaying the "Hero Image Row" section.
 * This file is loaded automatically by render_custom_page_sections() 
 * based on the post slug: 'hero-image-row'.
 */

// 1. Get the main Group field containing all sub-fields
$hero_group = get_field('hero_image_row_section');

// 2. Check if the group exists to prevent PHP errors
if ( $hero_group ) : 
    
    // Extract sub-fields into variables for cleaner code
    $bg_image_array = $hero_group['hero_image_section_background_image']; // Image Array
    $subtitle       = $hero_group['hero_image_row_section_subtitle'];      // Text
    $title          = $hero_group['hero_image_row_section_title'];         // Text
    $button_array   = $hero_group['hero_image_row_section_button'];        // Link Array
    
    // 3. Conditional check: Render section only if essential content exists (e.g., Image OR Title)
    if ( $bg_image_array || $title ) :
?>

    <section class="hero-image-row" style="background-image: url('<?php echo esc_url($bg_image_array['url']); ?>');">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    
                    <?php if ( $subtitle ) : ?>
                        <div class="subtitle">
                            <?php echo esc_html( $subtitle ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( $title ) : ?>
                        <h1 class="hero-title">
                            <?php echo esc_html( $title ); ?>
                        </h1>
                    <?php endif; ?>

                    <?php 
                    // Check if button array is not empty
                    if ( $button_array ) : 
                        $btn_url    = $button_array['url'];
                        $btn_title  = $button_array['title'];
                        $btn_target = $button_array['target'] ? $button_array['target'] : '_self';
                    ?>
                        <div class="button-wrapper">
                             <a href="<?php echo esc_url( $btn_url ); ?>" 
                                class="btn btn-outline-primary" 
                                target="<?php echo esc_attr( $btn_target ); ?>">
                                 <?php echo esc_html( $btn_title ); ?>
                             </a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>

<?php 
    endif; // End content check
endif; // End group check 
?>