<?php
/**
 * Retrieve ACF fields
 * Note: 'make_an_appointment' content field is removed, using standard WP content instead.
 */
$appt_bg_image = get_field('make_an_appointment_background_image'); 
$appt_subtitle = get_field('make_an_appointment_subtitle');         
$appt_title    = get_field('make_an_appointment_title');            
$appt_btn      = get_field('make_an_appointment_button');           
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
                    <?php 
                        // Выводит стандартный контент поста (из главного редактора)
                        the_content(); 
                    ?>
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