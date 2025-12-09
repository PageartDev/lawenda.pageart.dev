<?php

$args = array(
    'post_type'      => 'uslugi',    
    'posts_per_page' => 6,          
    'post_status'    => 'publish',   
    'orderby'        => 'date',      
    'order'          => 'DESC'       
);

$services_query = new WP_Query( $args );
?>

<section class="services-section">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-3 title_col"> <h2>
                    Popularne usługi
                </h2>
                <a href="/uslugi/" class="btn btn-outline-primary">
                    Wszystkie usługi
                </a>
            </div>

            <div class="col-lg-9 services_items"> <div class="row">
                    
                    <?php if ( $services_query->have_posts() ) : ?>
                        <?php while ( $services_query->have_posts() ) : $services_query->the_post(); ?>
                            
                            <div class="col-md-6 col-lg-4">
                                
                                <div class="image">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'large' ); ?>" alt="<?php the_title_attribute(); ?>">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/400x300" alt="Placeholder">
                                    <?php endif; ?>
                                </div>

                                <div class="float_content">
                                    <h4>
                                        <?php the_title(); ?>
                                    </h4>
                                    
                                    <div class="excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    
                                    <a href="<?php the_permalink(); ?>" class="service_link"></a>
                                </div>

                            </div>

                        <?php endwhile; ?>
                        <?php wp_reset_postdata();   ?>
                    
                    <?php else : ?>
                        <p>Nie ma jeszcze żadnych usług.</p>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</section>