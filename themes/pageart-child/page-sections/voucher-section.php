<?php
/**
 * Retrieve ACF fields
 */
$voucher_image    = get_field('voucher_section_image');    // Type: Image (Array)
$voucher_subtitle = get_field('voucher_section_subtitle'); // Type: Text
$voucher_title    = get_field('voucher_section_title');    // Type: Text
$voucher_btn      = get_field('voucher_section_button');   // Type: Link
?>

<section class="voucher_section">
    <div class="container">
        <div class="row">
            
            <div class="col-md-6 img_col">
                <?php if( $voucher_image ): ?>
                    <img src="<?php echo esc_url($voucher_image['url']); ?>" alt="<?php echo esc_attr($voucher_image['alt']); ?>">
                <?php endif; ?>
            </div>

            <div class="col-md-6 content_col">
                
                <?php if( $voucher_subtitle ): ?>
                    <div class="subtitle">
                        <?php echo esc_html($voucher_subtitle); ?>
                    </div>
                <?php endif; ?>

                <?php if( $voucher_title ): ?>
                    <h3 class="title">
                        <?php echo esc_html($voucher_title); ?>
                    </h3>
                <?php endif; ?>

                <div class="content">
                    <?php the_content(); ?>
                </div>

                <?php if( $voucher_btn ): 
                    $btn_url = $voucher_btn['url'];
                    $btn_title = $voucher_btn['title'];
                    $btn_target = $voucher_btn['target'] ? $voucher_btn['target'] : '_self';
                ?>
                    <a href="<?php echo esc_url( $btn_url ); ?>" class="btn btn-outline-primary" target="<?php echo esc_attr( $btn_target ); ?>">
                        <?php echo esc_html( $btn_title ); ?>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>