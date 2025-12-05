(function ($) {
    'use strict';

    $(document).ready(function () {
        initModifiedGallery();
    });

    let currentIndex = 0; // Global variable for current slide index

    function initModifiedGallery() {
        const gallery = $('.pa-gallery-modified');
        if (!gallery.length) return;

        // Initialize gallery
        initGallery();

        // Add variant synchronization
        initVariantSync();
    }

    function initGallery() {
        const gallery = $('.pa-gallery-modified');
        if (!gallery.length) return;

        const mainSlides = gallery.find('.pa-main-slide-modified');
        const thumbSlides = gallery.find('.pa-thumb-slide-modified');
        const thumbPrev = gallery.find('.pa-thumb-prev');
        const thumbNext = gallery.find('.pa-thumb-next');
        const thumbsSlider = gallery.find('.pa-thumbs-slider');

        // Set initial active states
        updateMainSlide(0);
        updateThumbSlide(0);
        updateThumbArrows();

        // Add event listeners for thumbnails
        thumbSlides.each(function (index) {
            $(this).off('click').on('click', function (e) {
                e.preventDefault();
                currentIndex = index;
                updateMainSlide(index);
                updateThumbSlide(index);
                updateThumbArrows();
            });
        });

        thumbPrev.off('click').on('click', scrollThumbsUp);
        thumbNext.off('click').on('click', scrollThumbsDown);

        // Add drag support for main images
        mainSlides.each(function () {
            const slide = $(this);
            slide.off('mousedown touchstart mousemove touchmove mouseup touchend mouseleave')
                .on('mousedown', startDrag)
                .on('touchstart', startDrag)
                .on('mousemove', drag)
                .on('touchmove', drag)
                .on('mouseup', endDrag)
                .on('touchend', endDrag)
                .on('mouseleave', endDrag);
        });

        // Keyboard navigation
        $(document).off('keydown.pa-gallery').on('keydown.pa-gallery', function (e) {
            if (gallery.is(':visible')) {
                if (e.key === 'ArrowLeft' && currentIndex > 0) {
                    currentIndex--;
                    updateMainSlide(currentIndex);
                    updateThumbSlide(currentIndex);
                    updateThumbArrows();
                } else if (e.key === 'ArrowRight' && currentIndex < mainSlides.length - 1) {
                    currentIndex++;
                    updateMainSlide(currentIndex);
                    updateThumbSlide(currentIndex);
                    updateThumbArrows();
                }
            }
        });
    }

    function updateMainSlide(index) {
        const gallery = $('.pa-gallery-modified');
        if (!gallery.length) return;

        const mainSlides = gallery.find('.pa-main-slide-modified');
        mainSlides.removeClass('active').eq(index).addClass('active');
    }

    function updateThumbSlide(index) {
        const gallery = $('.pa-gallery-modified');
        if (!gallery.length) return;

        const thumbSlides = gallery.find('.pa-thumb-slide-modified');
        const thumbsSlider = gallery.find('.pa-thumbs-slider');

        thumbSlides.removeClass('active').eq(index).addClass('active');

        // Scroll to active thumbnail
        const activeThumb = thumbSlides.eq(index);
        const isMobile = $(window).width() <= 768;

        if (isMobile) {
            // Horizontal scroll for mobile
            const container = thumbsSlider[0];
            const thumbLeft = activeThumb.position().left;
            const thumbWidth = activeThumb.outerWidth();
            const containerWidth = thumbsSlider.width();
            const scrollLeft = thumbLeft - (containerWidth / 2) + (thumbWidth / 2);

            thumbsSlider.animate({
                scrollLeft: scrollLeft
            }, 300);
        } else {
            // Vertical scroll for desktop
            const container = thumbsSlider[0];
            const thumbTop = activeThumb.position().top;
            const thumbHeight = activeThumb.outerHeight();
            const containerHeight = thumbsSlider.height();
            const scrollTop = thumbTop - (containerHeight / 2) + (thumbHeight / 2);

            thumbsSlider.animate({
                scrollTop: scrollTop
            }, 300);
        }
    }

    function updateThumbArrows() {
        const gallery = $('.pa-gallery-modified');
        if (!gallery.length) return;

        const thumbPrev = gallery.find('.pa-thumb-prev');
        const thumbNext = gallery.find('.pa-thumb-next');
        const thumbsSlider = gallery.find('.pa-thumbs-slider');

        const isMobile = $(window).width() <= 768;
        if (isMobile) {
            // For mobile, check if we can scroll horizontally
            const canScrollLeft = thumbsSlider.scrollLeft() > 0;
            const canScrollRight = thumbsSlider.scrollLeft() < (thumbsSlider[0].scrollWidth - thumbsSlider.width());

            thumbPrev.prop('disabled', !canScrollLeft);
            thumbNext.prop('disabled', !canScrollRight);
        } else {
            // For desktop, check if we can scroll vertically
            const canScrollUp = thumbsSlider.scrollTop() > 0;
            const canScrollDown = thumbsSlider.scrollTop() < (thumbsSlider[0].scrollHeight - thumbsSlider.height());

            thumbPrev.prop('disabled', !canScrollUp);
            thumbNext.prop('disabled', !canScrollDown);
        }
    }

    function scrollThumbsUp() {
        const gallery = $('.pa-gallery-modified');
        if (!gallery.length) return;

        const thumbsSlider = gallery.find('.pa-thumbs-slider');
        const isMobile = $(window).width() <= 768;

        if (isMobile) {
            // On mobile, prev button now scrolls right (due to 180deg rotation)
            thumbsSlider.animate({
                scrollLeft: thumbsSlider.scrollLeft() + 100
            }, 300);
        } else {
            thumbsSlider.animate({
                scrollTop: thumbsSlider.scrollTop() - 110
            }, 300);
        }
        setTimeout(updateThumbArrows, 300);
    }

    function scrollThumbsDown() {
        const gallery = $('.pa-gallery-modified');
        if (!gallery.length) return;

        const thumbsSlider = gallery.find('.pa-thumbs-slider');
        const isMobile = $(window).width() <= 768;

        if (isMobile) {
            // On mobile, next button now scrolls left (due to 180deg rotation)
            thumbsSlider.animate({
                scrollLeft: thumbsSlider.scrollLeft() - 100
            }, 300);
        } else {
            thumbsSlider.animate({
                scrollTop: thumbsSlider.scrollTop() + 110
            }, 300);
        }
        setTimeout(updateThumbArrows, 300);
    }

    // Drag functionality
    let isDragging = false;
    let startX = 0;
    let startY = 0;
    let currentX = 0;
    let currentY = 0;

    function startDrag(e) {
        isDragging = true;
        const clientX = e.type === 'mousedown' ? e.clientX : e.originalEvent.touches[0].clientX;
        const clientY = e.type === 'mousedown' ? e.clientY : e.originalEvent.touches[0].clientY;

        startX = clientX;
        startY = clientY;

        e.preventDefault();
    }

    function drag(e) {
        if (!isDragging) return;

        const clientX = e.type === 'mousemove' ? e.clientX : e.originalEvent.touches[0].clientX;
        const clientY = e.type === 'mousemove' ? e.clientY : e.originalEvent.touches[0].clientY;

        currentX = clientX - startX;
        currentY = clientY - startY;

        e.preventDefault();
    }

    function endDrag(e) {
        if (!isDragging) return;

        isDragging = false;

        const gallery = $('.pa-gallery-modified');
        if (!gallery.length) return;

        const mainSlides = gallery.find('.pa-main-slide-modified');

        // Determine if this was a swipe gesture
        const threshold = 50;
        const isHorizontalSwipe = Math.abs(currentX) > Math.abs(currentY);

        if (isHorizontalSwipe && Math.abs(currentX) > threshold) {
            if (currentX > 0 && currentIndex > 0) {
                // Swipe right - go to previous image
                currentIndex--;
            } else if (currentX < 0 && currentIndex < mainSlides.length - 1) {
                // Swipe left - go to next image
                currentIndex++;
            }

            updateMainSlide(currentIndex);
            updateThumbSlide(currentIndex);
            updateThumbArrows();
        }

        // Reset drag values
        currentX = 0;
        currentY = 0;
    }

    // Handle window resize
    $(window).on('resize', function () {
        updateThumbArrows();
    });

    function initVariantSync() {
        console.log('Initializing variant sync...');

        // Listen for WooCommerce variant changes
        $(document.body).off('found_variation.pa-gallery').on('found_variation.pa-gallery', function (event, variation) {
            console.log('found_variation event triggered:', variation);
            updateGalleryForVariant(variation);
        });

        // Also listen for custom variant change events
        $(document.body).off('woocommerce_variation_has_changed.pa-gallery').on('woocommerce_variation_has_changed.pa-gallery', function (event, variation) {
            console.log('woocommerce_variation_has_changed event triggered:', variation);
            updateGalleryForVariant(variation);
        });

        // Listen for select changes in variation forms
        $(document).off('change.pa-gallery', '.variations_form select').on('change.pa-gallery', '.variations_form select', function () {
            console.log('Variation select changed');
            setTimeout(function () {
                const form = $('.variations_form');
                if (form.length) {
                    console.log('Triggering check_variations');
                    form.trigger('check_variations');
                }
            }, 100);
        });

        // Listen for variation form updates
        $(document.body).off('updated_wc_div.pa-gallery').on('updated_wc_div.pa-gallery', function () {
            console.log('updated_wc_div event triggered');
            // Re-initialize gallery after variation form updates
            setTimeout(function () {
                initGallery();
            }, 200);
        });

        // Additional event listeners for better compatibility
        $(document.body).off('woocommerce_variation_select_change.pa-gallery').on('woocommerce_variation_select_change.pa-gallery', function (event, variation) {
            console.log('woocommerce_variation_select_change event triggered:', variation);
            updateGalleryForVariant(variation);
        })

        // Listen for any variation-related events
        $(document.body).off('variation_change.pa-gallery').on('variation_change.pa-gallery', function (event, variation) {
            console.log('variation_change event triggered:', variation);
            updateGalleryForVariant(variation);
        });
    }

    function updateGalleryForVariant(variation) {
        console.log('updateGalleryForVariant called with:', variation);

        if (!variation) {
            console.log('No variation provided');
            return;
        }

        if (!variation.image) {
            console.log('No image in variation');
            return;
        }

        const gallery = $('.pa-gallery-modified');
        if (!gallery.length) {
            console.log('Gallery not found');
            return;
        }

        const mainSlides = gallery.find('.pa-main-slide-modified');
        console.log('Found', mainSlides.length, 'main slides');

        // Find the slide with matching image
        let variantIndex = -1;
        const variantImageSrc = variation.image.src;
        console.log('Looking for variant image:', variantImageSrc);

        mainSlides.each(function (index) {
            const img = $(this).find('.pa-main-img-modified');
            const imgSrc = img.attr('src');
            console.log('Checking slide', index, 'with image:', imgSrc);

            // Multiple comparison methods for better matching
            if (imgSrc && variantImageSrc) {
                // Method 1: Direct URL comparison
                if (imgSrc === variantImageSrc) {
                    console.log('Direct match found at index:', index);
                    variantIndex = index;
                    return false;
                }

                // Method 2: Compare filename (ignoring size dimensions)
                const imgFilename = imgSrc.split('/').pop().split('?')[0];
                const variantFilename = variantImageSrc.split('/').pop().split('?')[0];
                console.log('Comparing filenames:', imgFilename, 'vs', variantFilename);

                // Remove size dimensions from filenames (e.g., -1024x1024, -600x600)
                const imgBaseFilename = imgFilename.replace(/-\d+x\d+\./, '.');
                const variantBaseFilename = variantFilename.replace(/-\d+x\d+\./, '.');
                console.log('Comparing base filenames:', imgBaseFilename, 'vs', variantBaseFilename);

                if (imgBaseFilename === variantBaseFilename) {
                    console.log('Base filename match found at index:', index);
                    variantIndex = index;
                    return false;
                }

                // Also check original filename match
                if (imgFilename === variantFilename) {
                    console.log('Exact filename match found at index:', index);
                    variantIndex = index;
                    return false;
                }

                // Method 3: Check if variant image is contained in gallery image URL
                if (imgSrc.includes(variantFilename)) {
                    console.log('Contains match found at index:', index);
                    variantIndex = index;
                    return false;
                }

                // Method 4: Check if gallery image is contained in variant image URL
                if (variantImageSrc.includes(imgFilename)) {
                    console.log('Reverse contains match found at index:', index);
                    variantIndex = index;
                    return false;
                }

                // Method 5: Check for similar filenames (without extensions and size dimensions)
                const imgBaseName = imgFilename.split('.')[0].replace(/-\d+x\d+$/, '');
                const variantBaseName = variantFilename.split('.')[0].replace(/-\d+x\d+$/, '');
                console.log('Comparing base names:', imgBaseName, 'vs', variantBaseName);

                if (imgBaseName === variantBaseName && imgBaseName.length > 0) {
                    console.log('Base name match found at index:', index);
                    variantIndex = index;
                    return false;
                }
            }
        });

        console.log('Final variant index:', variantIndex);

        // If variant image found, switch to it
        if (variantIndex >= 0) {
            console.log('Switching to variant image at index:', variantIndex);
            currentIndex = variantIndex;
            updateMainSlide(variantIndex);
            updateThumbSlide(variantIndex);
            updateThumbArrows();
        } else {
            console.log('No matching image found, staying at current index:', currentIndex);
        }
    }

})(jQuery);