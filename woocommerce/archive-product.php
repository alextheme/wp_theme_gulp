<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' ); ?>

	<section class="section shop_breadcrumb">
		<div class="section_in">
			<?php woocommerce_breadcrumb(); ?>
		</div>
	</section>

<?php

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

if ( woocommerce_product_loop() ) { ?>

	<div class="archive__header_wrapper">

		<?php } ?>

		<header class="woocommerce-products-header">
			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

				<h1 class="woocommerce-products-header__title page-title">
					<?php
					$archive_page_title = _themename_get_title_designer_single_page();
					if ($archive_page_title) {
						echo esc_html($archive_page_title);
					} else {
						woocommerce_page_title();
					} ?>
				</h1>

			<?php endif; ?>

			<?php
			/**
			 * Hook: woocommerce_archive_description.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
			?>

		</header>

		<?php if ( woocommerce_product_loop() ) { ?>

		<div class="archive__filters_wrapper">
			<div class="archive__designers_filter_wrapper"></div>

			<?php
				/**
				 * Hook: woocommerce_before_shop_loop.
				 *
				 * @hooked woocommerce_output_all_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

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
			</div><!-- .form_display -->

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

			<?php
			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();

					/**
					 * Hook: woocommerce_shop_loop.
					 */
					do_action( 'woocommerce_shop_loop' );

					wc_get_template_part( 'content', 'product' );
				}
			}

			woocommerce_product_loop_end();

			/**
			 * Hook: woocommerce_after_shop_loop.
			 *
			 * @hooked woocommerce_pagination - 10
			 */
			do_action( 'woocommerce_after_shop_loop' );

			?>

		</div><!-- .archive__products_wrapper -->

		<?php
		/**
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
		?>

			<?php

			} else {
				/**
				 * Hook: woocommerce_no_products_found.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action( 'woocommerce_no_products_found' );
			}

			?>

	</div><!-- .archive__main_content -->

<?php


/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );
