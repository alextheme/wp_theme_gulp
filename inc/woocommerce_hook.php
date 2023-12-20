<?php

function _themename_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', '_themename_add_woocommerce_support' );