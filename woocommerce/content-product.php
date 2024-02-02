<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $_themename_text, $post;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
	<?php
	/**
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' ); ?>

	<div class="product__text_wrapper">

		<?php

		/**
		 * @hooked woocommerce_template_loop_product_title - 10
		 */
		do_action( 'woocommerce_shop_loop_item_title' );

		?>

		<div class="shppb_loop_product__price_wrapper">

			<div class="woocommerce-loop-product__designer shppb notranslate">
				<?php echo esc_html($product->get_attribute('pa_poster-designer')); ?>
			</div>

			<?php
			/**
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
			?>

		</div><!-- ./shppb_loop_product__price_wrapper -->

		<?php

		/**
		 * @hooked woocommerce_template_loop_product_link_close - 5
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item' );

		?>

		<div class="product__bottom_info">
			<div class="product__bottom_col_l"><?php echo $_themename_text['tax_shipping_cost']; ?></div>
			<div class="product__bottom_col_r"><?php echo $_themename_text['shipping_24h']; ?></div>
		</div>

	</div><!-- .product__text_wrapper -->
</li>
