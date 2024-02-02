<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woo.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! empty( $breadcrumb ) ) {

    global $_themename_text;

	echo $wrap_before;

	foreach ( $breadcrumb as $key => $crumb ) {

		echo $before;

        $text_translate = $crumb[0];

        if (in_array($crumb[0], ['Startseite', 'startseite', 'Main', 'main', 'Home', 'home', 'Strona Główna', 'strona główna']) ) {

            $text_translate = $_themename_text['home_name'];

        } elseif (is_shop()) {

            $text_translate = $_themename_text['shop_title'];

        } elseif (is_product_category()) {

            $category_id = get_queried_object_id();
            $category = get_term($category_id, 'product_cat');
            $text_translate = _themename_create_translate_span($category->name, false);

        } else {

            if (have_posts()) : while (have_posts()) : the_post();
                $text_translate = get_the_title();
            endwhile; endif;

        }

        if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
            echo '<a href="' . esc_url( $crumb[1] ) . '">' . $text_translate . '</a>';
        } else {
            echo $text_translate;
        }

		echo $after;

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo $delimiter;
		}
	}

	echo $wrap_after;

}
