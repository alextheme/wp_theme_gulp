<?php

function _themename_setup() {

    if( function_exists('register_nav_menus') ) {
        register_nav_menus(
            array(
                'header_menu' => esc_html__( 'Header menu', '_themename' ),
                'footer_menu_1' => esc_html__( 'Footer menu 1', '_themename' ),
                'footer_menu_2' => esc_html__( 'Footer menu 2', '_themename' ),
                'footer_menu_3' => esc_html__( 'Footer menu 3', '_themename' ),
            )
        );
    }

    if( function_exists('acf_add_options_page') ) {
        acf_add_options_page();
    }

    if( function_exists( 'add_theme_support' ) ) {

        add_theme_support( 'post-thumbnails' );
        //set_post_thumbnail_size( 150, 150, false );

        add_theme_support( 'automatic-feed-links' );

        add_theme_support( 'title-tag' );

        add_theme_support( 'customize-selective-refresh-widgets' );

        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );
    }

    if( function_exists( 'add_image_size' ) ) {
        //add_image_size( 'medium', 283, 408, true );
        //add_image_size( 'large', 1024, 9999, false );
    }

    if( function_exists( 'load_theme_textdomain' ) ) {
        load_theme_textdomain( '_themename', get_template_directory() . '/languages' );
    }

}
add_action( 'after_setup_theme', '_themename_setup' );

function _themename_set_global_var() {
    global $_themename_text;

    $_themename_text = array(
        // home page
        'btn_catalog' => esc_html__('Katalog', '_themename'),
        'view_all' => esc_html__('Alle anzeigen', '_themename'),
        'incl_tax_excl_shipping_cost' => esc_html__('Inkl. Steuern, exkl. Versandkosten', '_themename'),
        'shipping_24h' => esc_html__('Versand: 24h', '_themename'),
        'all_works' => esc_html__('Alle Werke', '_themename'),
        'add_to_cart' => esc_html__('In den Warenkorb legen', '_themename'),
        'added' => esc_html__('Hinzugefügt', '_themename'),

        // footer
        'shipping_payment' => esc_html__('Versand & Zahlungen', '_themename'),
        'quick_links' => esc_html__('Schnellzugriff', '_themename'),
        'legal' => esc_html__('Rechtliches', '_themename'),
        'created_by' => esc_html__('Erstellt von Entsolve.pl', '_themename'),

        'copyright' => esc_html('© PIGASUS Polnischer Posterladen'), // © PIGASUS Polish Poster Shop
        'copyright_lang' => esc_html('© PIGASUS Polski Sklep Plakatowy || © PIGASUS Polish Poster Shop || © PIGASUS Polnischer Posterladen'),

        // designers
        'poster_designers' => esc_html__('Plakatdesigner', '_themename'),

        // shop
        'display_by' => esc_html__('Anzeigen nach', '_themename'),
        'shop_title' => esc_html__('Filmplakate', '_themename'),

        // single product
        'poster_designer' => esc_html__('Plakatdesigner:', '_themename'),
        'polish_original_poster_title' => esc_html__('Polnisch | Originaler Plakattitel:', '_themename'),
        'year' => esc_html__('Jahr:', '_themename'),
        'poster_size' => esc_html__('Plakatgröße:', '_themename'),
        'quantity' => esc_html__('Menge:', '_themename'),
        'out_of_stock_info' => esc_html__('Das Produkt ist vorübergehend nicht verfügbar, Sie können uns jedoch kontaktieren:', '_themename'),
        'phone' => esc_html__('Telefon:', '_themename'),
        'email' => esc_html__('Email:', '_themename'),

        // checout
        'have_coupon' => esc_html__('Hast du einen Gutschein?', '_themename'),
        'click_here' => esc_html__('Klicke hier, um deinen Gutschein-Code einzugeben.', '_themename'),
        'have_coupon_label' => esc_html__('Wenn Du einen Gutscheincode hast, wende ihn bitte unten an.', '_themename'),
        'coupon_code' => esc_html__('Gutscheincode', '_themename'),
        'apply_coupon' => esc_html__('Gutschein anwenden', '_themename'),

        // woocommerce hooks
        'sort_by' => esc_html__( 'Sortierung nach', '_themename' ),
        'main' => esc_html__( 'Startseite', '_themename' ),

        //mini-cart buttons
        'view_cart' => esc_html__( 'Zobacz Koszyk || View cart || Warenkorb ansehen', '_themename' ),
        'checkout' => esc_html__( 'Sprawdzić || Checkout || Kasse', '_themename' ),
    );
}
add_action( 'init', '_themename_set_global_var' );


// Функция, чтобы исключить Германию из метода доставки
function exclude_germany_from_shipping($available_methods) {
    // Проверяем, что метод доставки, который мы хотим изменить, доступен
    if (isset($available_methods['flat_rate'])) {
        // Проверяем, что это не Германия
        if (WC()->customer->get_shipping_country() !== 'DE') {
            // Исключаем метод доставки, если это не Германия
            unset($available_methods['flat_rate']);
        }
    }

    return $available_methods;
}