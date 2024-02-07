<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

global $product, $_themename_text;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

    <h1 class="product_title_mob notranslate">
        <?php echo wp_kses_post($product->get_title()) ?>
    </h1>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">

		<div class="product_sku shppb notranslate"><?php echo esc_html($product->get_sku()) ?></div>

		<h1 class="product_title entry-title notranslate"><?php echo wp_kses_post($product->get_title())?></h1>

		<div class="product_attributes">
			<div class="product_attribute_label">
				<?php echo $_themename_text['poster_designer']; ?>
			</div>
			<div class="product_attribute poster_designer shppb notranslate">
				<?php echo esc_html($product->get_attribute('poster-designer')); ?>
			</div>

			<div class="product_attribute_label">
				<?php echo $_themename_text['orig_poster_title']; ?>
			</div>
			<div class="product_attribute poster_original_title shppb notranslate">
				<?php echo esc_html(_themename_get_text_lang('', 'pl', $product->get_id())); ?>
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
			<div class="product_attribute poster_size notranslate">
				<?php echo esc_html($product->get_attribute('poster-size')); ?>
			</div>
		</div>

		<?php
		/**
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );
		?>
	</div>

	<?php
	/**
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
