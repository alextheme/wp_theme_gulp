<?php

function _themename_scripts() {
	wp_enqueue_style( '_themename-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( '_themename-stylesheet', get_template_directory_uri() . '/assets/css/bundle.css', array(), _S_VERSION, 'all' );

    wp_enqueue_script( '_themename-scripts', get_template_directory_uri() . '/assets/js/bundle.js', array('jquery'), _S_VERSION, true );

    // Mini Cart -- For buttons +/-
    wp_localize_script( '_themename-scripts', 'my_ajax_object', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'ic-mc-nc' ),
        )
    );
}

add_action( 'wp_enqueue_scripts', '_themename_scripts' );




/**
 *
 * Mini Cart -- For buttons +/-
 * https://github.com/anisur2805/woocommerce-mini-cart-ajax-plus-minus
 *
 */

// Here is the AJAX call
add_action( 'wp_ajax_ic_qty_update', 'ic_qty_update' );
add_action( 'wp_ajax_nopriv_ic_qty_update', 'ic_qty_update' );

function ic_qty_update() {
    $key    = sanitize_text_field( $_POST['key'] );
    $number = intval( sanitize_text_field( $_POST['number'] ) );

    $cart = [
        'count'      => 0,
        'total'      => 0,
        'item_price' => 0,
    ];

    if ( $key && $number > 0 && wp_verify_nonce( $_POST['security'], 'ic-mc-nc' ) ) {
        WC()->cart->set_quantity( $key, $number );
        $items              = WC()->cart->get_cart();
        $cart               = [];
        $cart['count']      = WC()->cart->cart_contents_count;
        $cart['total']      = WC()->cart->get_cart_total();
        $cart['item_price'] = wc_price( $items[$key]['line_total'] );
    }

    echo json_encode( $cart );
    wp_die();
}


// Here I modify two more hooks for plus/minus button
add_action( 'woocommerce_after_quantity_input_field', 'ic_display_quantity_plus', 10, 2 );
function ic_display_quantity_plus() {
    echo '<button type="button" class="ic-item-quantity-btn plus" data-type="plus">+</button>';
}

add_action( 'woocommerce_before_quantity_input_field', 'ic_display_quantity_minus' );
function ic_display_quantity_minus() {
    echo '<button type="button" class="ic-item-quantity-btn minus" data-type="minus">-</button>';
}
