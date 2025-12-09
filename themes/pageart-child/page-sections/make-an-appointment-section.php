<?php
/**
 * Retrieve ACF fields
 */
$appt_bg_image = get_field('make_an_appointment_background_image'); // Type: Image (Array)
$appt_subtitle = get_field('make_an_appointment_subtitle');         // Type: Text
$appt_title    = get_field('make_an_appointment_title');            // Type: Text
$appt_content  = get_field('make_an_appointment_content');          // Type: WYSIWYG Editor
$appt_btn      = get_field('make_an_appointment_button');           // Type: Link
?>

<section class="appointment_section" style="background-image: url('<?php echo $appt_bg_image ? esc_url($appt_bg_image['url']) : ''; ?>');">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                
                <?php if( $appt_subtitle ): ?>
                    <div class="subtitle">
                        <?php echo esc_html($appt_subtitle); ?>
                    </div>
                <?php endif; ?>

                <?php if( $appt_title ): ?>
                    <h3 class="title">
                        <?php echo esc_html($appt_title); ?>
                    </h3>
                <?php endif; ?>

                <div class="text-content">
                    <?php echo $appt_content; ?>
                </div>

                <?php if( $appt_btn ): 
                    $btn_url = $appt_btn['url'];
                    $btn_title = $appt_btn['title'];
                    $btn_target = $appt_btn['target'] ? $appt_btn['target'] : '_self';
                ?>
                    <a href="<?php echo esc_url( $btn_url ); ?>" class="btn btn-outline-primary" target="<?php echo esc_attr( $btn_target ); ?>">
                        <?php echo esc_html( $btn_title ); ?>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>