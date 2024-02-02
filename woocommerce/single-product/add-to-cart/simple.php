<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product, $_themename_text;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<?php
		do_action( 'woocommerce_before_add_to_cart_quantity' );
		?>

		<div class="add_to_cart__wrapper">
			<div class="add_to_cart__row">
				<?php global $product; ?>
				<p class="price simple_price"><?php echo $product->get_price_html(); ?></p>

				<div class="input_group">
					<div class="input_group__label"><?php echo $_themename_text['quantity']; ?></div>

					<div class="input_group__quantity">
						<div class="quantity__button">
							<button class="button button_minus">
								<svg width="5" height="2" viewBox="0 0 5 2" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M4.94886 0.0880681V1.18182H0.494318V0.0880681H4.94886Z" fill="black"/>
								</svg>
							</button>
						</div><!-- ./quantity__button -->

		<?php
		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			)
		);

		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>

						<div class="quantity__button">
							<button class="button button_plus">
								<svg width="7" height="8" viewBox="0 0 7 8" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M3.05682 7.30398V0.741477H4.17045V7.30398H3.05682ZM0.332386 4.57955V3.46591H6.89489V4.57955H0.332386Z" fill="black"/>
								</svg>
							</button>
						</div><!-- ./quantity__button -->
					</div><!-- ./input_group__quantity -->
				</div><!-- ./input_group -->
			</div><!-- ./add_to_cart__row -->

			<div class="add_to_cart__row_bottom">
				<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

				<div class="add_to_cart__bottom_info">
					<div class="add_to_cart__bottom_info_row_l"><?php echo $_themename_text['tax_shipping_cost']; ?></div>
					<div class="add_to_cart__bottom_info_row_r"><?php echo $_themename_text['shipping_24h']; ?></div>
				</div>
			</div><!-- ./add_to_cart__row -->
		</div><!-- ./add_to_cart__wrapper -->


		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
