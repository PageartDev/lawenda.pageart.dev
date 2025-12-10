document.addEventListener('DOMContentLoaded', function () {
    const adminBar = document.querySelector('#wpadminbar');
    const nav = document.querySelector('#wrapper-navbar > nav');
    if (adminBar && nav) {
        nav.style.marginTop = adminBar.offsetHeight + 'px';
    }
});

jQuery(function ($) {
    $('body').on('added_to_cart', function (event, fragments, cart_hash, $button) {
        console.log('added_to_cart fired');

        var cartToggle = document.querySelector('[data-bs-target="#miniCartOffcanvas"]');

        if (!cartToggle) {
            console.log('Brak przycisku z data-bs-target="#miniCartOffcanvas"');
            return;
        }

        cartToggle.click();
    });
});


jQuery(document).ready(function ($) {
    let $firstHeading = $('.wc-block-product-filters__overlay-content > div').first().find('h3.wp-block-heading');
    $firstHeading.addClass('is-open');
    $firstHeading.next().show();

    $(document).on('click', '.wc-block-product-filters__overlay-content .wp-block-heading', function () {
        let $heading = $(this);
        let $content = $heading.next();

        $content.stop(true, true).slideToggle(300);
        $heading.toggleClass('is-open');
    });


    $('.btn-trigger-filters').click(function () {
        $('button.wc-block-product-filters__open-overlay').trigger('click');
    })
});




/**
 * Scroll Animation Script using Intersection Observer API
 * Triggers animations when sections enter the viewport.
 */
document.addEventListener("DOMContentLoaded", function() {
    
    // 1. Select all <section> tags on the page
    const sections = document.querySelectorAll('section');

    // 2. Configuration options for the observer
    const options = {
        root: null, // Use the viewport as the root
        threshold: 0.15, // Trigger animation when 15% of the section is visible
        rootMargin: "0px" // No extra margins
    };

    // 3. Create the IntersectionObserver instance
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            
            // Check if the element is currently visible in the viewport
            if (entry.isIntersecting) {
                
                // Add the class that triggers the CSS transition
                entry.target.classList.add('is-visible');
                
                // Performance: Stop observing this element after it has appeared once
                observer.unobserve(entry.target);
            }
        });
    }, options);

    // 4. Start observing each section
    sections.forEach(section => {
        // Optional: Skip the first section if handled by CSS (see SCSS comment)
        observer.observe(section);
    });
});