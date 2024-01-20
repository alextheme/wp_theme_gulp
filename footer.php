<?php global $_themename_text; ?>

<?php if (!is_home()) { ?>

	<section class="section contacts contacts--mod_1">
		<div class="section_in">
			<?php get_template_part('template_parts/contacts_content'); ?>
		</div>
	</section>

<?php } ?>

</div><!-- .base -->

	<footer class="footer">
		<div class="footer_in">
			<div class="footer__row">
				<div class="footer__col">
					<a class="footer__logo notranslate" href="<?php echo esc_url(home_url('/')) ?>" title="Go to home page" aria-label="Go to home page">
						<div class="footer__logo_i_w">
							<img class="footer__logo_i" src="<?php echo get_template_directory_uri() . '/assets/images/logo.png' ?>" alt="logo">
						</div>
						<div class="footer__logo_text">
							<span><?php bloginfo('name'); ?></span>
							<span><?php bloginfo('description'); ?></span>
						</div>
					</a>
				</div>

				<div class="footer__col">
					<h4 class="footer_menu_label"><?php echo $_themename_text['shipping_payment']; ?></h4>
					<?php wp_nav_menu(array(
						'theme_location' => 'shipping_payment',
						'depth' => 1,
						'container' => '',
						'menu_class' => 'footer_menu__list',
					)); ?>
				</div>

				<div class="footer__col">
					<h4 class="footer_menu_label"><?php echo $_themename_text['quick_links']; ?></h4>
					<?php wp_nav_menu(array(
						'theme_location' => 'quick_links',
						'depth' => 1,
						'container' => '',
						'menu_class' => 'footer_menu__list',
					)); ?>
				</div>

				<div class="footer__col">
					<h4 class="footer_menu_label"><?php echo $_themename_text['legal']; ?></h4>
					<?php wp_nav_menu(array(
						'theme_location' => 'legal',
						'depth' => 1,
						'container' => '',
						'menu_class' => 'footer_menu__list',
					)); ?>
				</div>

			</div><!-- .footer__row -->

			<div class="footer__row">

				<div class="footer__copyright"><?php echo $_themename_text['copyright']; ?></div>

				<ul class="footer__pay_methods">
					<?php for ($i = 1; $i <= 4; $i++) { ?>
						<li class="footer__pay_img_w"><img class="footer__pay_img" src="<?php echo get_template_directory_uri() . '/assets/images/payments/'.$i.'.png' ?>" alt=""></li>
					<?php } ?>
				</ul>

				<a class="footer__created_by" href="https://entsolve.pl"><?php echo $_themename_text['created_by']; ?></a>

			</div><!-- .footer__row -->

		</div><!-- .footer__in -->
	</footer><!-- .footer -->
</div><!-- .wrapper -->

<!-- popups -->
<?php woocommerce_mini_cart(); ?>

<!-- bottom basket button -->
<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart_bottom_basket__btn miniCartTrigger">
	<span class="cart_bottom_basket__items_count">
		<?php echo WC()->cart->get_cart_contents_count(); ?>
		<?php //echo count(WC()->cart->get_cart()); ?>
	</span>
	<span class="cart_bottom_basket__icon">
		<svg class="icon icon_basket_2 icon--size_mod">
			<use xlink:href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/sprite.svg#basket_2'); ?>"></use>
		</svg>
	</span>
</a>



<?php wp_footer(); ?>

</body>
</html>
