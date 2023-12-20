<!doctype html>
<html lang="<?php language_attributes(); ?>">
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>




<div id="page" class="site">

	<header class="header">
		<div class="header_in">
			<div class="header__row">
				<div class="header__col scrollbarOffset"><a class="header__logo" href="#" title="Go to home page" aria-label="Go to home page">
						<div class="header__logo_i_w"><img class="header__logo_i" src="<?php echo get_template_directory_uri() . '/assets/images/logo.png' ?>" alt="logo"></div>
						<div class="header__logo_text"> <span>pigasus</span><span>polish poster shop</span></div></a>
					<div class="header__lang languageSelect">
						<div class="header__lang_button">PL</div>
						<ul class="header__lang_list">
							<li class="header__lang_item current" data-lang="pl">PL</li>
							<li class="header__lang_item" data-lang="en">EN</li>
							<li class="header__lang_item" data-lang="de">DE</li>
						</ul>
						<div class="header__lang_icon">
							<svg class="icon icon_arrow_down icon--size_mod">
								<use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/sprite/sprite.svg#arrow_down' ?>"></use>
							</svg>
						</div>
					</div>
				</div>
				<div class="header__col scrollbarOffset">
					<div class="menu_trigger menuTrigger"><span class="menu_trigger_decor"></span></div>
					<div class="header__page_title">Katalog</div>
					<form class="form_section__header" action="#">
						<div class="header__search">
							<div class="form_input__field">
								<input class="header_input__input" type="text" id="site_search" placeholder="" name="site_search">
							</div>
						</div>
						<div class="header__search_button searchTrigger">
							<div class="header__search_icon">
								<svg class="icon icon_search icon--size_mod">
									<use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/sprite/sprite.svg#search' ?>"></use>
								</svg>
							</div>
						</div>
					</form>
					<div class="header__lang languageSelect">
						<div class="header__lang_button">PL</div>
						<ul class="header__lang_list">
							<li class="header__lang_item current" data-lang="pl">PL</li>
							<li class="header__lang_item" data-lang="en">EN</li>
							<li class="header__lang_item" data-lang="de">DE</li>
						</ul>
						<div class="header__lang_icon">
							<svg class="icon icon_arrow_down icon--size_mod">
								<use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/sprite/sprite.svg#arrow_down' ?>"></use>
							</svg>
						</div>
					</div>
					<div class="header__shop"> <a class="header__shop_link" href="#" aria-label="basket">
							<svg class="icon icon_basket icon--size_mod">
								<use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/sprite/sprite.svg#basket' ?>"></use>
							</svg></a><a class="header__shop_link" href="#" aria-label="user">
							<svg class="icon icon_user icon--size_mod">
								<use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/sprite/sprite.svg#user' ?>"></use>
							</svg></a></div>
				</div>
			</div>
			<div class="header__row">
				<nav class="header__nav">
					<ul class="header_menu__list ">
						<li class="header_menu__item header_menu__item--active_mod "><a class="header_menu__link " href="#">Film posters</a></li>
						<li class="header_menu__item  "><a class="header_menu__link " href="#">Film posters</a></li>
						<li class="header_menu__item  "><a class="header_menu__link " href="#">Film posters</a></li>
						<li class="header_menu__item  "><a class="header_menu__link " href="#">Film posters</a></li>
						<li class="header_menu__item  "><a class="header_menu__link " href="#">Film posters</a></li>
						<li class="header_menu__item  "><a class="header_menu__link " href="#">Film posters</a></li>
						<li class="header_menu__item  "><a class="header_menu__link " href="#">Film posters</a></li>
						<li class="header_menu__item  "><a class="header_menu__link " href="#">Film posters</a></li>
						<li class="header_menu__item  "><a class="header_menu__link " href="#">Film posters</a></li>
					</ul>
				</nav>
			</div>
		</div>
	</header>