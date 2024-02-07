<?php

/**
 * Support Woocommerce
 */
function _themename_add_woocommerce_support()
{
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 150,
        'single_image_width' => 900,
    ));
//    add_theme_support( 'wc-product-gallery-zoom' );
//    add_theme_support( 'wc-product-gallery-lightbox' );
//    add_theme_support( 'wc-product-gallery-slider' );
}

add_action('after_setup_theme', '_themename_add_woocommerce_support');


/**
 * GLOBAL
 */

// Wordpress & Woocommerce Product Title Filter
function _themename_get_lang_title($title)
{
    if (is_admin()) {

        return $title;

    } else {

        // Якщо текст прийшов завернутий в тег <a href="#">text</a>
        if (preg_match("/<a\s+[^>]*>(.*?)<\/a>/i", $title, $matches)) {
            $innerText = $matches[1];

            if (str_contains($innerText, '||')) {
                $span = '<span class="shppb notranslate" data-text_languages="' . $innerText . '">' . _themename_get_text_lang($innerText, _themename_get_lang()) . '</span>';
                return str_replace($innerText, $span, $title);
            } else {
                return $title;
            }
        }

        if (str_contains($title, '||')) {
            return _themename_create_translate_span($title, false);
        } else {

            return $title;

        }

    }

}

add_filter('woocommerce_product_title', '_themename_get_lang_title');
add_filter('the_title', '_themename_get_lang_title');
add_filter('woocommerce_cart_item_name', '_themename_get_lang_title');




/**
 * Mini Cart Count
 */
add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    $fragments['.cart_bottom_basket__items_count'] = '<span class="cart_bottom_basket__items_count">' . WC()->cart->get_cart_contents_count() . '</span>';
    return $fragments;
});


/**
 * Breadcrumbs
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

add_filter('woocommerce_breadcrumb_defaults', function () {
    global $_themename_text;

    $delimeter = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
    <path d="M5.25 4.5L12.75 12L5.25 19.5" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M12.75 4.5L20.25 12L12.75 19.5" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>';

    return array(
        'delimiter' => '&nbsp;' . $delimeter . '&nbsp;',
        'wrap_before' => '<nav class="woocommerce-breadcrumb">',
        'wrap_after' => '</nav>',
        'before' => '',
        'after' => '',
        'home' => $_themename_text['main'],
    );
});


/**
 * Filters
 */
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

function _themename_catalog_ordering($options)
{
    global $_themename_text;
    $options['menu_order'] = $_themename_text['sort_by'];
    return $options;
}

add_filter('woocommerce_catalog_orderby', '_themename_catalog_ordering', 30);


/**
 * Single Page
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);


/**
 * Пагінація
 */
add_filter('woocommerce_pagination_args', function ($args) {

    $args['prev_text'] = '';
    $args['next_text'] = '';
    $args['end_size'] = 2;
    $args['mid_size'] = 1;

    return $args;
});


/**
 * Приховати меню в аккаунті
 */
add_filter('woocommerce_account_menu_items', '_themename_no_downloads', 25);

function _themename_no_downloads($menu_links)
{
    unset($menu_links['downloads']);
    return $menu_links;
}


/**
 * Приховати ТАБ з відгуками
 */
add_filter('woocommerce_product_tabs', '_themename_remove_reviews_tab', 98);
function _themename_remove_reviews_tab($tabs)
{
    unset($tabs['reviews']);
    return $tabs;
}


/**
 * Перенос ввода купона вниз
 */
// Добавить пользовательское поле купона после
add_action('woocommerce_checkout_after_customer_details', 'woocommerce_checkout_coupon_form_custom');
function woocommerce_checkout_coupon_form_custom()
{
    global $_themename_text;
    ?>

    <div class="woocommerce-form-coupon-toggle checkout-coupon-toggle-js">
        <div class="wc-block-components-notice-banner is-info" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"
                 focusable="false">
                <path d="M12 3.2c-4.8 0-8.8 3.9-8.8 8.8 0 4.8 3.9 8.8 8.8 8.8 4.8 0 8.8-3.9 8.8-8.8 0-4.8-4-8.8-8.8-8.8zm0 16c-4 0-7.2-3.3-7.2-7.2C4.8 8 8 4.8 12 4.8s7.2 3.3 7.2 7.2c0 4-3.2 7.2-7.2 7.2zM11 17h2v-6h-2v6zm0-8h2V7h-2v2z"></path>
            </svg>
            <div class="wc-block-components-notice-banner__content">
                <?php echo $_themename_text['have_coupon']; ?>
                <a href="#" class="show-coupon"><?php echo $_themename_text['click_here']; ?></a>
            </div>
        </div>
    </div>

    <div class="coupon-form shppb_custom_coupon_form" style="display:none !important;">
        <p><?php echo $_themename_text['have_coupon_label']; ?></p>
        <p class="form-row form-row-first woocommerce-validated">
            <label><input type="text" name="coupon_code" class="input-text"
                          placeholder="<?php echo $_themename_text['coupon_code']; ?>" id="coupon_code"
                          value=""></label>
        </p>
        <p class="form-row form-row-last">
            <button type="button" class="button" name="apply_coupon"
                    value="<?php echo $_themename_text['apply_coupon']; ?>"><?php echo $_themename_text['apply_coupon']; ?></button>
        </p>
        <div class="clear"></div>
    </div>

<?php }

// jQuery code
add_action('wp_footer', 'custom_checkout_jquery_script');
function custom_checkout_jquery_script()
{
    if (is_checkout() && !is_wc_endpoint_url()) :
        ?>
        <script type="text/javascript">
            jQuery(function ($) {
                $('.coupon-form').css("display", "none"); // Проверка, что поле купона скрыто

                // Показать или скрыть поле купона
                $('.checkout-coupon-toggle-js .show-coupon').on('click', function (e) {
                    $('.coupon-form').toggle(200);
                    e.preventDefault();
                })

                // Скопировать введенный код купона в скрытое поле купона WC по умолчанию
                $('.coupon-form input[name="coupon_code"]').on('input change', function () {
                    $('form.checkout_coupon input[name="coupon_code"]').val($(this).val());
                });

                // При клике кнопки отправить форму купона WooCommerce в скрытую по умолчанию
                $('.coupon-form button[name="apply_coupon"]').on('click', function () {
                    $('form.checkout_coupon').submit();
                });
            });
        </script>
    <?php
    endif;
}


// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
function woocommerce_header_add_to_cart_fragment($fragments)
{
    ob_start(); ?>
    <a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e('View your shopping cart'); ?>">
        <?php
        echo sprintf(_n(
            '%d item',
            '%d items',
            WC()->cart->get_cart_contents_count()
        ),
            WC()->cart->get_cart_contents_count()
        ); ?> - <?php echo WC()->cart->get_cart_total(); ?>
    </a>
    <?php

    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}



/**
 * Додати врапер для фільтра товарів по атрибуту щоб додати клас "notranslate"
 */
add_filter( 'dynamic_sidebar_params', function ($params) {
    if ($params[0]['id'] === 'sidebar-1') {
        $params[0]['before_widget'] = '<div class="sidebar_wrapper notranslate">';
        $params[0]['after_widget'] = '</div><!-- .sidebar_wrapper -->';
    }

    return $params;
} );




/**
 * Change number of products that are displayed per page (shop page)
 */
add_filter( 'loop_shop_per_page', '_themename_loop_shop_per_page', 20 );

function _themename_loop_shop_per_page( $cols ) {
    // $cols contains the current number of products per page based on the value stored on Options –> Reading
    // Return the number of products you wanna show per page.
    $cols = 12;
    return $cols;
}