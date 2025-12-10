<?php
/**
 * Retrieve ACF fields
 * Keys matched against scf-export-2025-12-09.json
 */
$faq_title    = get_field('faq_section_title');    // Type: Text
$faq_subtitle = get_field('faq_section_subtitle'); // Type: Text
$faq_btn      = get_field('faq_section_button');   // Type: Link
$faq_items    = get_field('faq_section_tab');      // Type: Repeater
?>

<section class="faq_section">
    <div class="container">
        <div class="row">
            
            <div class="col-md-5 mb-4 mb-md-0">
                
                <?php if( $faq_title ): ?>
                    <h3 class="title">
                        <?php echo esc_html($faq_title); ?>
                    </h3>
                <?php endif; ?>

                <?php if( $faq_subtitle ): ?>
                    <div class="subtitle mb-4">
                        <?php echo esc_html($faq_subtitle); ?>
                    </div>
                <?php endif; ?>

                <?php if( $faq_btn ): 
                    $btn_url = $faq_btn['url'];
                    $btn_title = $faq_btn['title'];
                    $btn_target = $faq_btn['target'] ? $faq_btn['target'] : '_self';
                ?>
                    <a href="<?php echo esc_url( $btn_url ); ?>" class="btn btn-outline-primary" target="<?php echo esc_attr( $btn_target ); ?>">
                        <?php echo esc_html( $btn_title ); ?>
                    </a>
                <?php endif; ?>

            </div>

            <div class="col-md-7">
                <?php if( $faq_items ): ?>
                    
                    <div class="accordion" id="faqAccordion">
                        
                        <?php foreach( $faq_items as $key => $item ): 
                            // Generate unique IDs for Bootstrap controls based on loop index
                            $id_head = 'heading' . $key;
                            $id_collapse = 'collapse' . $key;
                            
                            // UX Logic: Open the first item by default
                            $is_first = ($key === 0);
                            $show_class = $is_first ? 'show' : '';
                            $btn_collapsed = $is_first ? '' : 'collapsed';
                            $aria_expanded = $is_first ? 'true' : 'false';

                            // CSS Logic: Add 'show-collapse' class if this item is open by default
                            $item_active_class = $is_first ? ' show-collapse' : '';

                            // Data extraction: Using correct keys from JSON
                            $question_text = $item['faq_section_tab_question'] ?? ''; 
                            $answer_text   = $item['faq_section_tab_answer'] ?? '';
                        ?>
                            <div class="accordion-item<?php echo $item_active_class; ?>">
                                
                                <h2 class="accordion-header" id="<?php echo $id_head; ?>">
                                    <button class="accordion-button <?php echo $btn_collapsed; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $id_collapse; ?>" aria-expanded="<?php echo $aria_expanded; ?>" aria-controls="<?php echo $id_collapse; ?>">
                                        <?php echo esc_html( $question_text ); ?>
                                    </button>
                                </h2>

                                <div id="<?php echo $id_collapse; ?>" class="accordion-collapse collapse <?php echo $show_class; ?>" aria-labelledby="<?php echo $id_head; ?>" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <?php 
                                            // Using wp_kses_post to allow safe HTML in the answer
                                            echo wp_kses_post( $answer_text ); 
                                        ?>
                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>


                <a href="<?php echo esc_url( $btn_url ); ?>" class="btn btn-outline-primary" target="<?php echo esc_attr( $btn_target ); ?>">
                    <?php echo esc_html( $btn_title ); ?>
                </a>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Select the accordion container
        var myAccordion = document.getElementById('faqAccordion');
        
        if(myAccordion) {
            // Event listener: When an accordion item starts to OPEN
            myAccordion.addEventListener('show.bs.collapse', function (e) {
                // Find the parent .accordion-item and ADD the class
                e.target.closest('.accordion-item').classList.add('show-collapse');
            });

            // Event listener: When an accordion item starts to CLOSE
            myAccordion.addEventListener('hide.bs.collapse', function (e) {
                // Find the parent .accordion-item and REMOVE the class
                e.target.closest('.accordion-item').classList.remove('show-collapse');
            });
        }
    });
    </script>

</section>