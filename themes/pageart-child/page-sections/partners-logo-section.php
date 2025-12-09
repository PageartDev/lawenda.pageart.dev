<?php
/**
 * Retrieve ACF fields
 */
$partners_subtitle = get_field('partners_logo_section_subtitle'); // Type: Text
$partners_title    = get_field('partners_logo_section_title');    // Type: Text
$partners_logos    = get_field('partners_logo_section_logos');    // Type: Gallery (Image Array)
$partners_content  = get_the_content();                           // Standard Editor Content
?>

<section class="partners_logo_section">
    <div class="container">
        <div class="row">
            <div class="col">
                
                <?php if( $partners_subtitle ): ?>
                    <div class="subtitle">
                        <?php echo esc_html($partners_subtitle); ?>
                    </div>
                <?php endif; ?>

                <?php if( $partners_title ): ?>
                    <h3 class="title">
                        <?php echo esc_html($partners_title); ?>
                    </h3>
                <?php endif; ?>

                <div class="logo_carousel_wrapper mt-4 mb-4">
                    <?php if( $partners_logos ): ?>
                        
                        <div id="partnersSlider" class="partners-slider-container">
                            <?php foreach( $partners_logos as $logo ): ?>
                                <div class="partner-item">
                                    <img src="<?php echo esc_url($logo['url']); ?>" 
                                         alt="<?php echo esc_attr($logo['alt']); ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>

                    <?php endif; ?>
                </div>

                <div class="second_subtitle mt-4">
                    <?php echo do_shortcode( wpautop( $partners_content ) ); ?>
                </div>

            </div>
        </div>
    </div>

    <style>
        .partners-slider-container {
            display: flex;
            overflow-x: auto;
            cursor: grab; /* Mouse cursor indicates draggable */
            scroll-behavior: smooth; /* Enables smooth scrolling for auto-play */
            gap: 20px;
            padding-bottom: 10px;
            /* Hide scrollbar for clean look */
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
            user-select: none; /* Prevent image highlighting while dragging */
        }
        
        /* Hide scrollbar for Chrome/Safari/Opera */
        .partners-slider-container::-webkit-scrollbar {
            display: none;
        }

        .partners-slider-container.active {
            cursor: grabbing;
            scroll-behavior: auto; /* Remove smooth scroll while dragging for instant response */
        }

        .partner-item {
            flex: 0 0 auto;
            /* Width calculation based on requirements:
               Mobile: 2 items (approx 50%)
               Tablet: 4 items (approx 25%)
               Desktop: 6 items (approx 16.666%)
               Minus a bit for gaps
            */
            width: calc(50% - 10px); 
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .partner-item img {
            max-width: 100%;
            max-height: 80px; /* Limit logo height */
            width: auto;
            filter: grayscale(100%);
            opacity: 0.7;
            transition: 0.3s;
            pointer-events: none; /* Prevent image drag interfering with scroll drag */
        }

        @media (min-width: 768px) {
            .partner-item {
                width: calc(25% - 15px); /* 4 items */
            }
        }

        @media (min-width: 1200px) {
            .partner-item {
                width: calc(16.666% - 17px); /* 6 items */
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.getElementById('partnersSlider');
            if (!slider) return;

            let isDown = false;
            let startX;
            let scrollLeft;
            
            // -----------------------------
            // 1. Drag to Scroll Logic
            // -----------------------------
            slider.addEventListener('mousedown', (e) => {
                isDown = true;
                slider.classList.add('active');
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
                // Pause auto-scroll when user interacts
                clearInterval(autoScrollInterval); 
            });

            slider.addEventListener('mouseleave', () => {
                isDown = false;
                slider.classList.remove('active');
                // Restart auto-scroll
                startAutoScroll();
            });

            slider.addEventListener('mouseup', () => {
                isDown = false;
                slider.classList.remove('active');
                // Restart auto-scroll
                startAutoScroll();
            });

            slider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 2; // *2 for faster scroll speed
                slider.scrollLeft = scrollLeft - walk;
            });

            // -----------------------------
            // 2. Auto Scroll Logic (Every 2s)
            // -----------------------------
            let autoScrollInterval;

            function startAutoScroll() {
                // Clear existing to avoid duplicates
                if(autoScrollInterval) clearInterval(autoScrollInterval);

                autoScrollInterval = setInterval(() => {
                    // Check if slider exists and user is not dragging
                    if (!isDown && slider) {
                        // Calculate width of one item + gap
                        const itemWidth = slider.querySelector('.partner-item').offsetWidth + 20; 
                        
                        // Check if we reached the end
                        // buffer of 5px for calculation errors
                        if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 5) {
                            // Reset to start
                            slider.scrollTo({ left: 0, behavior: 'smooth' });
                        } else {
                            // Scroll next
                            slider.scrollBy({ left: itemWidth, behavior: 'smooth' });
                        }
                    }
                }, 2000); // 2 seconds
            }

            // Init auto scroll
            startAutoScroll();
        });
    </script>
</section>