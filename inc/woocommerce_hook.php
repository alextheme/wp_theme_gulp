<?php

/**
 * Support Woocommerce
 */
function _themename_add_woocommerce_support() {
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 150,
        'single_image_width'    => 900,
    ));
//    add_theme_support( 'wc-product-gallery-zoom' );
//    add_theme_support( 'wc-product-gallery-lightbox' );
//    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', '_themename_add_woocommerce_support' );





/**
 * GLOBAL
 */

// Wordpress & Woocommerce Product Title Filter
function _themename_get_lang_title($title) {
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
            return '<span class="shppb notranslate" data-text_languages="' . $title . '">' . _themename_get_text_lang($title, _themename_get_lang()) . '</span>';
        } else {
            return $title;
        }

    }

}
add_filter( 'woocommerce_product_title', '_themename_get_lang_title' );
add_filter( 'the_title', '_themename_get_lang_title' );
add_filter( 'woocommerce_cart_item_name', '_themename_get_lang_title' );





/**
 * Mini Cart Count
 */
add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    $fragments['.cart_bottom_basket__items_count'] = '<span class="cart_bottom_basket__items_count">' . WC()->cart->get_cart_contents_count() . '</span>';
    return $fragments;
});





/*
 * Add wrapper for header
 * including breadcrumbs, title, notice, form
 */
function _themename_add_header_wrapper_start() { ?>
    <div class="archive__header_wrapper">
<?php }
add_action( 'woocommerce_before_main_content', '_themename_add_header_wrapper_start' );





function _themename_add_wrapper_filters_start() { ?>
    <div class="archive__filters_wrapper">
        <div class="archive__designers_filter_wrapper"></div>
<?php }
add_action( 'woocommerce_before_shop_loop', '_themename_add_wrapper_filters_start', 29 );





/*
 * Add wrappers for main content and products list,
 * and moved sidebar to main content wrapper
 */
function _themename_add_main_content_wrapper_start() { ?>
    <?php global $_themename_text; ?>
            <div class="form_display">
                <span class="form_display__label"><?php echo esc_html($_themename_text['display_by'])?></span>
                <div class="form_radio">
                    <label class="form_radio__block">
                        <input class="form_radio__element" id="display_1" value="1" type="radio" name="display_by" checked>
                        <span class="form_display__icon form_display__icon--first">
                            <svg class="icon icon_display_1 icon--size_mod">
                                <use xlink:href="<?php echo get_template_directory_uri() .'/assets/images/icons/sprite.svg#button_1'; ?>"></use>
                            </svg>
                        </span>
                    </label>
                </div>
                <div class="form_radio">
                    <label class="form_radio__block">
                        <input class="form_radio__element" id="display_2" value="2" type="radio" name="display_by">
                        <span class="form_display__icon">
                            <svg class="icon icon_display_2 icon--size_mod">
                                <use xlink:href="<?php echo get_template_directory_uri() .'/assets/images/icons/sprite.svg#button_2'; ?>"></use>
                            </svg>
                        </span>
                    </label>
                </div>
            </div>

        </div><!-- .archive__filters_wrapper -->
    </div><!-- .archive__header_wrapper -->

    <?php

    // Set attribute html-data for Attributes Terms Count Products
    $designers = get_terms( array(
        'taxonomy' => 'pa_poster-designer',
        'hide_empty' => false, // Показывать даже те термины, которые не привязаны к постам
    ) );
    $result = array();
    foreach ($designers as $designer) {
        $result[$designer->slug] = $designer->count;
    }

    $jsonResult = json_encode($result);
    ?>

    <div class="archive__main_content" data-attribute_terms_count_products="<?php echo esc_attr($jsonResult); ?>">
        <div class="archive__products_wrapper">

<?php }
add_action( 'woocommerce_before_shop_loop', '_themename_add_main_content_wrapper_start', 40 );





function _themename_add_close_product_wrapper() {
    echo '</div><!-- .archive__products_wrapper -->';
}
add_action( 'woocommerce_after_shop_loop', '_themename_add_close_product_wrapper', 16 );





function _themename_add_main_content_wrapper_end() {
    echo '</div><!-- .archive__main_content -->';
}
add_action( 'woocommerce_after_shop_loop', '_themename_add_main_content_wrapper_end', 20 );





/**
 * Sidebar moved to
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
if (!is_singular()) {
    add_action('woocommerce_after_shop_loop', 'woocommerce_get_sidebar', 18);
}





/**
 * Breadcrumbs
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'woocommerce_before_main_content', '_themename_woocommerce_breadcrumb', 5 );
function _themename_woocommerce_breadcrumb() { ?>
    <section class="section shop_breadcrumb">
        <div class="section_in">
            <?php woocommerce_breadcrumb(); ?>
        </div>
    </section>
<?php }

add_filter( 'woocommerce_breadcrumb_defaults', function () {
    global $_themename_text;

    $delimeter = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
    <path d="M5.25 4.5L12.75 12L5.25 19.5" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M12.75 4.5L20.25 12L12.75 19.5" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>';

    return array(
        'delimiter'   => '&nbsp;'.$delimeter.'&nbsp;',
        'wrap_before' => '<nav class="woocommerce-breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => $_themename_text['main'],
    );
} );





/**
 * Filters
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

function _themename_catalog_ordering($options) {
    global $_themename_text;
    $options['menu_order'] = $_themename_text['sort_by'];
    return $options;
}
add_filter( 'woocommerce_catalog_orderby', '_themename_catalog_ordering', 30 );





/**
 * Products
 */
function _themename_add_item_text_wrapper_start() { ?>
    <div class="product__text_wrapper">
<?php }
add_action( 'woocommerce_before_shop_loop_item_title', '_themename_add_item_text_wrapper_start', 11 );





function _themename_add_poster_designer_name() {
    global $post;
    $product = wc_get_product($post->ID);
    $poster_designer = $product->get_attribute('pa_poster-designer');
    ?>

    <div class="woocommerce-loop-product__designer shppb notranslate"><?php echo esc_html($poster_designer); ?></div>

<?php }
add_action( 'woocommerce_after_shop_loop_item_title', '_themename_add_poster_designer_name', 6 );





function _themename_add_bottom_info() { ?>
    <?php global $_themename_text; ?>

        <div class="product__bottom_info">
            <div class="product__bottom_col_l"><?php echo $_themename_text['incl_tax_excl_shipping_cost']; ?></div>
            <div class="product__bottom_col_r"><?php echo $_themename_text['shipping_24h']; ?></div>
        </div>
    </div><!-- .product__text_wrapper -->

<?php }
add_action( 'woocommerce_after_shop_loop_item', '_themename_add_bottom_info', 11 );





/**
 * Single Page
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );





function _themename_show_title_for_mobile() { ?>
    <h1 class="product_title_mob">
        <?php
        global $product;
        echo wp_kses_post($product->get_title())
        ?>
    </h1>
<?php }
add_action( 'woocommerce_before_single_product_summary', '_themename_show_title_for_mobile', 9 );


function _themename_show_attributes() {
    global $product;
    global $_themename_text; ?>

    <div class="product_sku shppb notranslate"><?php echo esc_html($product->get_sku()) ?></div>

    <h1 class="product_title entry-title"><?php echo wp_kses_post($product->get_title())?></h1>

    <div class="product_attributes">
        <div class="product_attribute_label">
            <?php echo $_themename_text['poster_designer']; ?>
        </div>
        <div class="product_attribute poster_designer shppb notranslate">
            <?php echo esc_html($product->get_attribute('poster-designer')); ?>
        </div>

        <div class="product_attribute_label">
            <?php echo $_themename_text['polish_original_poster_title']; ?>
        </div>
        <div class="product_attribute poster_original_title shppb notranslate">
            <?php echo esc_html(_themename_get_text_lang('', 'pl', false, $product->get_id())); ?>
        </div>

        <div class="product_attribute_label">
            <?php echo $_themename_text['year']; ?>
        </div>
        <div class="product_attribute poster_year">
            <?php echo esc_html($product->get_attribute('year-of-release')); ?>
        </div>

        <div class="product_attribute_label">
            <?php echo $_themename_text['poster_size']; ?>
        </div>
        <div class="product_attribute poster_size">
            <?php echo esc_html($product->get_attribute('poster-size')); ?>
        </div>
    </div>

    <?php
}
add_action( 'woocommerce_single_product_summary', '_themename_show_attributes', 4 );




// Пагінація

add_filter('woocommerce_pagination_args', function ($args) {

    $args['prev_text'] = '';
    $args['next_text'] = '';
    $args['end_size'] = 2;
    $args['mid_size'] = 1;

    return $args;
});



// Приховати меню в аккаунті

add_filter( 'woocommerce_account_menu_items', '_themename_no_downloads', 25 );

function _themename_no_downloads( $menu_links ){

	unset( $menu_links[ 'downloads' ] );
	return $menu_links;

}



/**
* Приховати ТАБ з відгуками
 */
add_filter( 'woocommerce_product_tabs', '_themename_remove_reviews_tab', 98);
function _themename_remove_reviews_tab($tabs) {

    unset($tabs['reviews']);

    return $tabs;
}



// Перенос ввода купона вниз

// Добавить пользовательское поле купона после
add_action( 'woocommerce_checkout_after_customer_details', 'woocommerce_checkout_coupon_form_custom' );
function woocommerce_checkout_coupon_form_custom() {
    global $_themename_text;
    ?>

    <div class="woocommerce-form-coupon-toggle checkout-coupon-toggle-js">
        <div class="wc-block-components-notice-banner is-info" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false">
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
            <label><input type="text" name="coupon_code" class="input-text" placeholder="<?php echo $_themename_text['coupon_code']; ?>" id="coupon_code" value=""></label>
        </p>
        <p class="form-row form-row-last">
            <button type="button" class="button" name="apply_coupon" value="<?php echo $_themename_text['apply_coupon']; ?>"><?php echo $_themename_text['apply_coupon']; ?></button>
        </p>
        <div class="clear"></div>
    </div>

<?php }

// jQuery code
add_action( 'wp_footer', 'custom_checkout_jquery_script' );
function custom_checkout_jquery_script() {
    if ( is_checkout() && ! is_wc_endpoint_url() ) :
    ?>
    <script type="text/javascript">
    jQuery( function($){
        $('.coupon-form').css("display", "none"); // Проверка, что поле купона скрыто

        // Показать или скрыть поле купона
        $('.checkout-coupon-toggle-js .show-coupon').on( 'click', function(e){
            $('.coupon-form').toggle(200);
            e.preventDefault();
        })

        // Скопировать введенный код купона в скрытое поле купона WC по умолчанию
        $('.coupon-form input[name="coupon_code"]').on( 'input change', function(){
            $('form.checkout_coupon input[name="coupon_code"]').val($(this).val());
        });

        // При клике кнопки отправить форму купона WooCommerce в скрытую по умолчанию
        $('.coupon-form button[name="apply_coupon"]').on( 'click', function(){
            $('form.checkout_coupon').submit();
        });
    });
    </script>
    <?php
    endif;
}




// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start(); ?>
	<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>">
	    <?php echo sprintf (_n( '%d item', '%d items', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?> - <?php echo WC()->cart->get_cart_total(); ?>
    </a>
	<?php

	$fragments['a.cart-contents'] = ob_get_clean();

	return $fragments;
}