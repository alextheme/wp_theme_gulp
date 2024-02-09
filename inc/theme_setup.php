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
        'designer'            => _themename_create_translate_span('Projektanci || Designers || Designer', false),
        'btn_catalog'         => _themename_create_translate_span('Katalog || Catalog || Katalog', false),
        'view_all'            => _themename_create_translate_span('Pokaż wszystkie || View all || Alle anzeigen', false),
        'tax_shipping_cost'   => _themename_create_translate_span('Łącznie z podatkami, z wyłączeniem kosztów wysyłki || Including taxes, excluding shipping costs || Inkl. Steuern, exkl. Versandkosten', false),
        'shipping_24h'        => _themename_create_translate_span('Wysyłka: 24h || Shipping: 24h || Versand: 24h', false),
        'all_works'           => _themename_create_translate_span('Wszystkie prace || All works || Alle Werke', false),

        'add_to_cart'         => _themename_create_translate_span('Dodaj do Koszyka || Add to Cart || In den Warenkorb legen', false),
        'read_more'           => _themename_create_translate_span('Więcej || Read more || Mehr lesen', false),
        'select_options'      => _themename_create_translate_span('Wybierz opcje || Select options || Optionen wählen', false),
        'added'               => _themename_create_translate_span('Dodany || Added || Hinzugefügt', false),

        // footer
        'footer_menu_title_1' => _themename_create_translate_span('Dostawa i Płatności || Shipping & Payments || Versand & Zahlungen', false),
        'footer_menu_title_2' => _themename_create_translate_span('Szybki Dostęp || Quick Access || Schnellzugriff', false),
        'footer_menu_title_3' => _themename_create_translate_span('Informacje Prawne || Legal Information || Rechtliches', false),
        'copyright'           => _themename_create_translate_span('© PIGASUS Polnischer Posterladen || © PIGASUS Polnischer Posterladen || © PIGASUS Polnischer Posterladen', false),
        'created_by'          => _themename_create_translate_span('Stworzono przez || Created by || Erstellt von', false),

        'contact_title'       => _themename_create_translate_span('Kontakt || Contact || Kontakt', false),

        'product'             => _themename_create_translate_span('Produkt || Product || Produkt', false),
        'subtotal'            => _themename_create_translate_span('Suma częściowa || Subtotal || Zwischensumme', false),
        'view_cart'           => _themename_create_translate_span('Zobacz Koszyk || View cart || Warenkorb ansehen', false),
        'checkout'            => _themename_create_translate_span('Sprawdzić || Checkout || Kasse', false),
        
        'display_by'          => _themename_create_translate_span('Anzeigen nach', false),
        'shop_title'          => _themename_create_translate_span('Wszystkie plakaty || All posters || Alle Poster', false),
        'home_name'           => _themename_create_translate_span('Strona główna || Home || Startseite', false),

        'poster_designer'     => _themename_create_translate_span('Projektant plakatu || Poster Designer || Plakatdesigner', false),
        'poster_designers'    => _themename_create_translate_span('Projektant plakatów || Poster Designer || Plakatdesigner', false),
        'orig_poster_title'   => _themename_create_translate_span('Polski | Oryginalny tytuł plakatu || Polish | Original Poster Title || Polnisch | Originaler Plakattitel', false),
        'year'                => _themename_create_translate_span('Rok || Year || Jahr', false),
        'poster_size'         => _themename_create_translate_span('Rozmiar plakatu || Poster Size || Plakatgröße', false),

        'quantity'            => _themename_create_translate_span('Ilość: || Quantity: || Menge:', false),
        'out_of_stock_info'   => _themename_create_translate_span('Produkt niedostępny, ale możesz się z nami skontaktować: || The product is not available, but you can contact us: || Das Produkt ist nicht verfügbar, aber Sie können uns kontaktieren:', false),
        'phone'               => _themename_create_translate_span('Telefon:', false),
        'email'               => _themename_create_translate_span('Email:', false),

        'have_coupon'         => _themename_create_translate_span('Hast du einen Gutschein?', false),
        'click_here'          => _themename_create_translate_span('Klicke hier, um deinen Gutschein-Code einzugeben.', false),
        'have_coupon_label'   => _themename_create_translate_span('Wenn Du einen Gutscheincode hast, wende ihn bitte unten an.', false),
        'coupon_code'         => _themename_create_translate_span('Gutscheincode', false),
        'apply_coupon'        => _themename_create_translate_span('Gutschein anwenden', false),

        'sort_by'             => _themename_create_translate_span( 'Sortierung nach', false ),
        'main'                => _themename_create_translate_span( 'Startseite', false ),

        'additional_info'     => _themename_create_translate_span('Dodatkowe informacje || Additional Information || Zusätzliche Informationen', false),
        'different_address'   => _themename_create_translate_span('Wysłać przesyłkę na inny adres? || Send delivery to a different address? || Lieferung an eine andere Adresse senden?', false),
    );
}
add_action( 'init', '_themename_set_global_var' );

//
//// Функция, чтобы исключить Германию из метода доставки
//function exclude_germany_from_shipping($available_methods) {
//    // Проверяем, что метод доставки, который мы хотим изменить, доступен
//    if (isset($available_methods['flat_rate'])) {
//        // Проверяем, что это не Германия
//        if (WC()->customer->get_shipping_country() !== 'DE') {
//            // Исключаем метод доставки, если это не Германия
//            unset($available_methods['flat_rate']);
//        }
//    }
//
//    return $available_methods;
//}