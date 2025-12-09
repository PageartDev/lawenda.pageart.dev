<?php

$about_image    = get_field('about_us_section_image');    
$about_subtitle = get_field('about_us_section_subtitle'); 
$about_title    = get_field('about_us_section_title');    
$about_link     = get_field('about_us_section_button');  
?>

<section class="about-us-section">
    <div class="container">
        <div class="row">
            
            <div class="col-md-6">
                <?php if( $about_image ): ?>
                    <img src="<?php echo esc_url($about_image['url']); ?>" alt="<?php echo esc_attr($about_image['alt']); ?>">
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                
                <?php if( $about_subtitle ): ?>
                    <div class="subtitle">
                        <?php echo esc_html($about_subtitle); ?>
                    </div>
                <?php endif; ?>

                <?php if( $about_title ): ?>
                    <h2>
                        <?php echo esc_html($about_title); ?>
                    </h2>
                <?php endif; ?>

                <div class="text-area">
                    <?php the_content(); ?>
                </div>

                <?php if( $about_link ): 
                    $link_url = $about_link['url'];
                    $link_title = $about_link['title'];
                    $link_target = $about_link['target'] ? $about_link['target'] : '_self';
                ?>
                    <a class="btn btn-outline-primary" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
                        <?php echo esc_html( $link_title ); ?>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>