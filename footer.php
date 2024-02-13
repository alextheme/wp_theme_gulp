<?php global $_themename_text; ?>

<?php if (!is_home()) { ?>

	<section class="section contacts contacts--mod_1">
		<div class="section_in">
			<?php get_template_part('parts/contacts_content'); ?>
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
							<img class="footer__logo_i" src="<?php echo get_template_directory_uri() . '/assets/images/logo.svg' ?>" alt="logo" loading="lazy">
						</div>
						<div class="footer__logo_text">
							<span><?php bloginfo('name'); ?></span>
							<span><?php bloginfo('description'); ?></span>
						</div>
					</a>
				</div>

				<div class="footer__col">
					<h4 class="footer_menu_label m-data">
						<?php echo $_themename_text['footer_menu_title_1']; ?>
					</h4>
					<?php wp_nav_menu(array(
						'theme_location' => 'footer_menu_1',
						'depth' => 1,
						'container' => '',
						'menu_class' => 'footer_menu__list notranslate',
					)); ?>
				</div>

				<div class="footer__col">
					<h4 class="footer_menu_label m-data">
						<?php echo $_themename_text['footer_menu_title_2']; ?>
					</h4>
					<?php wp_nav_menu(array(
						'theme_location' => 'footer_menu_2',
						'depth' => 1,
						'container' => '',
						'menu_class' => 'footer_menu__list notranslate',
					)); ?>
				</div>

				<div class="footer__col">
					<h4 class="footer_menu_label m-data">
						<?php echo $_themename_text['footer_menu_title_3']; ?>
					</h4>
					<?php wp_nav_menu(array(
						'theme_location' => 'footer_menu_3',
						'depth' => 1,
						'container' => '',
						'menu_class' => 'footer_menu__list notranslate',
					)); ?>
				</div>

			</div><!-- .footer__row -->

			<div class="footer__row">

				<div class="footer__copyright notranslate">
					<span>©&nbsp;<?php bloginfo('name'); ?>&nbsp;<?php bloginfo('description'); ?></span>
				</div>

				<ul class="footer__pay_methods">
					<?php for ($i = 1; $i <= 5; $i++) { ?>
						<li class="footer__pay_img_w">
							<img class="footer__pay_img"
								src="<?php echo get_template_directory_uri() . '/assets/images/payments/'.$i.'.png' ?>"
								alt=""
								loading="lazy"></li>
					<?php } ?>
				</ul>

				<div class="footer__created_by">
					<span><?php echo $_themename_text['created_by']; ?> <a href="https://entsolve.pl">entsolve.pl</a></span>
				</div>

			</div><!-- .footer__row -->

		</div><!-- .footer__in -->
	</footer><!-- .footer -->
</div><!-- .wrapper -->

<!-- popups -->
<?php woocommerce_mini_cart(); ?>

<!-- bottom basket button -->
<?php if( !is_cart() ) { ?>
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
<?php } ?>



<?php wp_footer(); ?>

</body>
</html>
