<?php
/**
 * Header Navbar (bootstrap5)
 *
 * @package Understrap
 * @since 1.1.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );

$bootstrap_version = get_theme_mod( 'understrap_bootstrap_version', 'bootstrap4' );
$navbar_type       = get_theme_mod( 'understrap_navbar_type', 'collapse' );

// Czy używamy offcanvas dla koszyka (na razie tylko warunek na Bootstrap 5)
$use_cart_offcanvas = ( 'bootstrap5' === $bootstrap_version );
?>

<nav id="main-nav" class="navbar navbar-expand-md navbar-light fixed-top bg-white border-bottom" aria-labelledby="main-nav-label">

	<h2 id="main-nav-label" class="screen-reader-text">
		<?php esc_html_e( 'Main Navigation', 'understrap' ); ?>
	</h2>


	<div class="<?php echo esc_attr( $container ); ?>">



		<button
			class="navbar-toggler"
			type="button"
			data-bs-toggle="collapse"
			data-bs-target="#navbarNavDropdown"
			aria-controls="navbarNavDropdown"
			aria-expanded="false"
			aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>"
		>
			<span class="navbar-toggler-icon"></span>
		</button>

        <!-- Your site branding in the menu -->
		<?php get_template_part( 'global-templates/navbar-branding' ); ?>

		<!-- The WordPress Menu goes here -->
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'container_class' => 'collapse navbar-collapse',
				'container_id'    => 'navbarNavDropdown',
				'menu_class'      => 'navbar-nav ms-auto',
				'fallback_cb'     => '',
				'menu_id'         => 'main-menu',
				'depth'           => 2,
				'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
			)
		);
		?>


        <?php if ( is_active_sidebar( 'menu_right_section' ) ) : ?>
    
            <div class="menu-right-section-container d-flex align-items-center">
                <?php dynamic_sidebar( 'menu_right_section' ); ?>
            </div>

        <?php endif; ?>


        <div class="woocommerce-icons  d-flex align-items-center gap-3">

            <div class="header-searchbar">
                <div class="dropdown">
                    <a class="nav-link position-relative" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false"
                       aria-label="<?php esc_attr_e('Search', 'understrap'); ?>">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <mask id="mask0_165_249" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                  width="24" height="24">
                                <rect width="24" height="23.7363" fill="#D9D9D9"/>
                            </mask>
                            <g mask="url(#mask0_165_249)">
                                <path d="M9.5216 15.4439C7.81392 15.4439 6.36777 14.8581 5.18317 13.6865C3.99856 12.5149 3.40625 11.0847 3.40625 9.39574C3.40625 7.70683 3.99856 6.27657 5.18317 5.10497C6.36777 3.93339 7.81392 3.3476 9.5216 3.3476C11.2293 3.3476 12.6754 3.93339 13.8601 5.10497C15.0447 6.27657 15.637 7.70683 15.637 9.39574C15.637 10.102 15.5171 10.7766 15.2774 11.4194C15.0376 12.0623 14.7177 12.6214 14.3177 13.0969L20.0716 18.7875C20.2101 18.9245 20.2809 19.0966 20.2841 19.3039C20.2873 19.5112 20.2165 19.6865 20.0716 19.8298C19.9267 19.9731 19.7511 20.0447 19.5447 20.0447C19.3383 20.0447 19.1626 19.9731 19.0178 19.8298L13.2639 14.1392C12.7639 14.5474 12.1889 14.867 11.5389 15.0977C10.8889 15.3285 10.2165 15.4439 9.5216 15.4439ZM9.5216 13.9604C10.8101 13.9604 11.9014 13.5182 12.7956 12.6338C13.6899 11.7494 14.137 10.6701 14.137 9.39574C14.137 8.12144 13.6899 7.04208 12.7956 6.15767C11.9014 5.27327 10.8101 4.83106 9.5216 4.83106C8.23313 4.83106 7.14178 5.27327 6.24755 6.15767C5.35333 7.04208 4.90623 8.12144 4.90623 9.39574C4.90623 10.6701 5.35333 11.7494 6.24755 12.6338C7.14178 13.5182 8.23313 13.9604 9.5216 13.9604Z"
                                      fill="#343A40"/>
                            </g>
                        </svg>

                    </a>
                    <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 280px;">
                        <?php if (class_exists('WooCommerce') && function_exists('get_product_search_form')) : ?>
                            <?php get_product_search_form(); ?>
                        <?php else : ?>
                            <?php get_search_form(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


            <?php if (class_exists('WooCommerce')) :
                $cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/');
                $account_page_id = get_option('woocommerce_myaccount_page_id');
                $account_url = $account_page_id ? get_permalink($account_page_id) : wp_login_url();
                $cart_count = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;
                ?>

                <a class="nav-link position-relative" href="<?php echo esc_url($account_url); ?>"
                   aria-label="<?php esc_attr_e('My account', 'understrap'); ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <mask id="mask0_165_252" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                              width="24" height="24">
                            <rect width="24" height="23.7363" fill="#D9D9D9"/>
                        </mask>
                        <g mask="url(#mask0_165_252)">
                            <path d="M12 11.5638C11.0375 11.5638 10.2135 11.2249 9.52813 10.547C8.84271 9.86913 8.5 9.05423 8.5 8.10232C8.5 7.1504 8.84271 6.3355 9.52813 5.65764C10.2135 4.97975 11.0375 4.64081 12 4.64081C12.9625 4.64081 13.7864 4.97975 14.4718 5.65764C15.1572 6.3355 15.5 7.1504 15.5 8.10232C15.5 9.05423 15.1572 9.86913 14.4718 10.547C13.7864 11.2249 12.9625 11.5638 12 11.5638ZM17.9808 19.0955H6.0192C5.59742 19.0955 5.23877 18.9494 4.94327 18.6571C4.64776 18.3648 4.5 18.0101 4.5 17.593V16.8969C4.5 16.4125 4.63302 15.964 4.89905 15.5513C5.16507 15.1386 5.52051 14.8213 5.96537 14.5994C6.95384 14.1201 7.95096 13.7606 8.95672 13.521C9.96249 13.2813 10.9769 13.1615 12 13.1615C13.023 13.1615 14.0375 13.2813 15.0432 13.521C16.049 13.7606 17.0461 14.1201 18.0346 14.5994C18.4794 14.8213 18.8349 15.1386 19.1009 15.5513C19.3669 15.964 19.5 16.4125 19.5 16.8969V17.593C19.5 18.0101 19.3522 18.3648 19.0567 18.6571C18.7612 18.9494 18.4025 19.0955 17.9808 19.0955ZM5.99997 17.612H18V16.8969C18 16.6965 17.9413 16.5111 17.824 16.3406C17.7067 16.17 17.5474 16.0309 17.3461 15.9231C16.4846 15.5034 15.6061 15.1854 14.7107 14.9692C13.8152 14.7531 12.9117 14.645 12 14.645C11.0883 14.645 10.1847 14.7531 9.28927 14.9692C8.39384 15.1854 7.51536 15.5034 6.65382 15.9231C6.45254 16.0309 6.29325 16.17 6.17595 16.3406C6.05863 16.5111 5.99997 16.6965 5.99997 16.8969V17.612ZM12 10.0803C12.55 10.0803 13.0208 9.88666 13.4125 9.4993C13.8041 9.11194 14 8.64628 14 8.10232C14 7.55837 13.8041 7.09271 13.4125 6.70534C13.0208 6.31798 12.55 6.1243 12 6.1243C11.45 6.1243 10.9791 6.31798 10.5875 6.70534C10.1958 7.09271 9.99997 7.55837 9.99997 8.10232C9.99997 8.64628 10.1958 9.11194 10.5875 9.4993C10.9791 9.88666 11.45 10.0803 12 10.0803Z"
                                  fill="#343A40"/>
                        </g>
                    </svg>

                </a>

                <div class="header-cart">
                    <div class="dropdown">
                        <a class="nav-link position-relative" href="<?php echo esc_url($cart_url); ?>"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false"
                           aria-label="<?php esc_attr_e('Cart', 'understrap'); ?>">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <mask id="mask0_165_255" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                      width="24" height="24">
                                    <rect width="24" height="23.7363" fill="#D9D9D9"/>
                                </mask>
                                <g mask="url(#mask0_165_255)">
                                    <path d="M6.3077 21.2637C5.80257 21.2637 5.375 21.0906 5.025 20.7445C4.675 20.3983 4.5 19.9754 4.5 19.4759V8.21642C4.5 7.71683 4.675 7.29396 5.025 6.94781C5.375 6.60166 5.80257 6.42858 6.3077 6.42858H8.25V6.18133C8.25 5.15681 8.61603 4.28255 9.34808 3.55854C10.0801 2.83454 10.9641 2.47253 12 2.47253C13.0359 2.47253 13.9198 2.83454 14.6519 3.55854C15.3839 4.28255 15.75 5.15681 15.75 6.18133V6.42858H17.6922C18.1974 6.42858 18.625 6.60166 18.975 6.94781C19.325 7.29396 19.5 7.71683 19.5 8.21642V19.4759C19.5 19.9754 19.325 20.3983 18.975 20.7445C18.625 21.0906 17.6922 19.7802 17.6922 21.2637H6.3077ZM6.3077 19.7802H17.6922C17.7692 19.7802 17.8397 19.7485 17.9038 19.6851C17.9679 19.6217 18 19.552 18 19.4759V8.21642C18 8.14033 17.9679 8.07058 17.9038 8.00716C17.8397 7.94377 17.7692 7.91207 17.6922 7.91207H15.75V10.1374C15.75 10.3478 15.6782 10.5241 15.5346 10.6661C15.391 10.8081 15.2128 10.8791 15 10.8791C14.7872 10.8791 14.609 10.8081 14.4654 10.6661C14.3218 10.5241 14.25 10.3478 14.25 10.1374V7.91207H9.74995V10.1374C9.74995 10.3478 9.67816 10.5241 9.53457 10.6661C9.39099 10.8081 9.21279 10.8791 8.99997 10.8791C8.78716 10.8791 8.60896 10.8081 8.46537 10.6661C8.32179 10.5241 8.25 10.3478 8.25 10.1374V7.91207H6.3077C6.23077 7.91207 6.16024 7.94377 6.09612 8.00716C6.03202 8.07058 5.99997 8.14033 5.99997 8.21642V19.4759C5.99997 19.552 6.03202 19.6217 6.09612 19.6851C6.16024 19.7485 6.23077 19.7802 6.3077 19.7802ZM9.74995 6.42858H14.25V6.18133C14.25 5.56128 14.0317 5.03539 13.5952 4.60366C13.1586 4.1719 12.6269 3.95603 12 3.95603C11.373 3.95603 10.8413 4.1719 10.4048 4.60366C9.96822 5.03539 9.74995 5.56128 9.74995 6.18133V6.42858Z"
                                          fill="#343A40"/>
                                </g>
                            </svg>

                            <span class="badge rounded-pill bg-primary position-absolute top-0 start-100 translate-middle js-cart-count">
                            <?php echo (int)$cart_count; ?>
                        </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 320px;">
                            <div class="widget_shopping_cart_content">
                                <?php woocommerce_mini_cart(); ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php else : ?>
                <a class="nav-link position-relative" href="<?php echo esc_url(wp_login_url()); ?>"
                   aria-label="<?php esc_attr_e('Log in', 'understrap'); ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <mask id="mask0_165_252" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                              width="24" height="24">
                            <rect width="24" height="23.7363" fill="#D9D9D9"/>
                        </mask>
                        <g mask="url(#mask0_165_252)">
                            <path d="M12 11.5638C11.0375 11.5638 10.2135 11.2249 9.52813 10.547C8.84271 9.86913 8.5 9.05423 8.5 8.10232C8.5 7.1504 8.84271 6.3355 9.52813 5.65764C10.2135 4.97975 11.0375 4.64081 12 4.64081C12.9625 4.64081 13.7864 4.97975 14.4718 5.65764C15.1572 6.3355 15.5 7.1504 15.5 8.10232C15.5 9.05423 15.1572 9.86913 14.4718 10.547C13.7864 11.2249 12.9625 11.5638 12 11.5638ZM17.9808 19.0955H6.0192C5.59742 19.0955 5.23877 18.9494 4.94327 18.6571C4.64776 18.3648 4.5 18.0101 4.5 17.593V16.8969C4.5 16.4125 4.63302 15.964 4.89905 15.5513C5.16507 15.1386 5.52051 14.8213 5.96537 14.5994C6.95384 14.1201 7.95096 13.7606 8.95672 13.521C9.96249 13.2813 10.9769 13.1615 12 13.1615C13.023 13.1615 14.0375 13.2813 15.0432 13.521C16.049 13.7606 17.0461 14.1201 18.0346 14.5994C18.4794 14.8213 18.8349 15.1386 19.1009 15.5513C19.3669 15.964 19.5 16.4125 19.5 16.8969V17.593C19.5 18.0101 19.3522 18.3648 19.0567 18.6571C18.7612 18.9494 18.4025 19.0955 17.9808 19.0955ZM5.99997 17.612H18V16.8969C18 16.6965 17.9413 16.5111 17.824 16.3406C17.7067 16.17 17.5474 16.0309 17.3461 15.9231C16.4846 15.5034 15.6061 15.1854 14.7107 14.9692C13.8152 14.7531 12.9117 14.645 12 14.645C11.0883 14.645 10.1847 14.7531 9.28927 14.9692C8.39384 15.1854 7.51536 15.5034 6.65382 15.9231C6.45254 16.0309 6.29325 16.17 6.17595 16.3406C6.05863 16.5111 5.99997 16.6965 5.99997 16.8969V17.612ZM12 10.0803C12.55 10.0803 13.0208 9.88666 13.4125 9.4993C13.8041 9.11194 14 8.64628 14 8.10232C14 7.55837 13.8041 7.09271 13.4125 6.70534C13.0208 6.31798 12.55 6.1243 12 6.1243C11.45 6.1243 10.9791 6.31798 10.5875 6.70534C10.1958 7.09271 9.99997 7.55837 9.99997 8.10232C9.99997 8.64628 10.1958 9.11194 10.5875 9.4993C10.9791 9.88666 11.45 10.0803 12 10.0803Z"
                                  fill="#343A40"/>
                        </g>
                    </svg>

                </a>
            <?php endif; ?>

            <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#navbarNavOffcanvas"
                    aria-controls="navbarNavOffcanvas"
                    aria-expanded="false"
                    aria-label="<?php esc_attr_e('Open menu', 'understrap'); ?>"
            >
                <svg width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.5 1H16.5" stroke="black" stroke-linecap="round"/>
                    <path d="M0.5 7H16.5" stroke="black" stroke-linecap="round"/>
                    <path d="M0.5 13H16.5" stroke="black" stroke-linecap="round"/>
                </svg>

            </button>

        </div>

	</div><!-- .container(-fluid) -->

</nav><!-- #main-nav -->