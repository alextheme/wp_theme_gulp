<?php
/**
 * Single Product stock.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/stock.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $_themename_text;
?>
<div class="stock <?php echo esc_attr( $class ); ?>" >

	<?php if( $product->is_on_backorder()) { ?>

		<?php echo wp_kses_post( $availability ); ?>

	<?php } ?>

	<?php if( ! $product->is_in_stock()) { ?>

		<p class="out_of_stock__info"><?php echo $_themename_text['out_of_stock_info']; ?></p>
		<ul class="out_of_stock__contacts">
			<li>
				<span class="contact__label"><?php echo $_themename_text['email']; ?></span>
				<a class="contact__link" href="mailto:<?php echo esc_url(get_field('contacts_email', 'option'))?>"><?php the_field('contacts_email', 'option') ?></a>
			</li>
			<li>
				<span class="contact__label"><?php echo $_themename_text['phone']; ?></span>
				<a class="contact__link" href="tel:<?php echo esc_url(get_field('contacts_phone', 'option'))?>"><?php the_field('contacts_phone', 'option') ?></a>
			</li>
		</ul>

	<?php } ?>

</div>
