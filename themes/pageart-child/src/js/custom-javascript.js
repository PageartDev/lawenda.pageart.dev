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