<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php

$designer_single_page = '';

?>

<header class="header">
    <div class="header_in">
        <div class="header__row">

            <div class="header__col scrollbarOffset">
                <a class="header__logo notranslate" href="<?php echo esc_url(home_url('/')) ?>" title="Go to home page"
                   aria-label="Go to home page">
                    <div class="header__logo_i_w">
                        <img class="header__logo_i"
                             src="<?php echo get_template_directory_uri() . '/assets/images/logo.svg' ?>" alt="logo" loading="lazy">
                    </div>
                    <div class="header__logo_text">
                        <span><?php bloginfo('name'); ?></span>
                        <span><?php bloginfo('description'); ?></span>
                    </div>
                </a>
            </div>

            <div class="header__col scrollbarOffset">
                <div class="menu_trigger menuTrigger"><span class="menu_trigger_decor"></span></div>

                <?php
                global $post, $product, $_themename_text;

                $header_title_page_attr = '';
                $header_title_page = '';

                // Проверяем, отображается ли страница товаров категории
                if (is_product_category()) {

                    // Получаем ID текущей категории
                    $category_id = get_queried_object_id();

                    // Получаем объект категории по ID
                    $category = get_term($category_id, 'product_cat');

                    // заголовок категории
                    $header_title_page_attr = 'data-text_languages="'. esc_attr($category->name) .'"';
                    $header_title_page = _themename_get_text_lang($category->name, _themename_get_lang());

                } else {

                    $designer_single_page = _themename_get_title_designer_single_page();
                    $title_page = $designer_single_page;

                    if (is_shop()) {
                        $title_page = $_themename_text['shop_title'];
                    } else {
                        if (have_posts()) : while (have_posts()) : the_post();
                            $title_page = get_the_title();
                        endwhile; endif;
                    }

                    $header_title_page = $title_page;
                }

                ?>

                <h1 class="header__page_title notranslate" <?php echo $header_title_page_attr; ?>>
                    <?php echo $header_title_page; ?>
                </h1>

                <!-- Search Form -->
                <?php aws_get_search_form(); ?>

                <?php
                // Google Translate Switcher
                dynamic_sidebar('_themename_gtranslate_widgets');
                echo _themename_get_gtranslate_custom_style();
                ?>

                <div class="header__shop">

                    <a class="header__shop_link header__shop_link--mod_1 miniCartTrigger" href="<?php echo esc_url(wc_get_cart_url()) ?>" aria-label="basket link">
                        <svg class="icon icon_basket icon--size_mod">
                            <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#basket' ?>"></use>
                        </svg>

<!--                        <span class="header__shop_cart_contents_count mini_cart_cnt">-->
<!--                            --><?php ////echo WC()->cart->get_cart_contents_count(); ?>
<!--                            --><?php //echo count(WC()->cart->get_cart()); ?>
<!--                        </span>-->
                    </a>

                    <a class="header__shop_link header__shop_link--mod_2"
                       href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>"
                       aria-label="user link">
                        <svg class="icon icon_user icon--size_mod">
                            <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#user' ?>"></use>
                        </svg>
                    </a>

                    <button type="button" class="header__mobile_search_btn searchTrigger" aria-label="search button">
                        <span class="header__search_icon">
                            <svg class="icon icon_search icon--size_mod">
                                <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#search' ?>"></use>
                            </svg>
                        </span>
                    </button>

                </div>
            </div>
        </div>


        <div class="header__row">
            <?php
            $args = array(
                'theme_location' => 'header_menu',
                'depth' => 1,
                'container' => 'nav',
                'container_class' => 'header__nav',
                'menu_class' => 'header_menu__list notranslate',
            );

            $header_menu = wp_nav_menu($args);
            ?>
        </div>
    </div>
</header>

<div class="wrapper">
    <?php
    $page_name_class = '';

    if (is_shop()) {
        $page_name_class .= ' shop';
    }

    if ($designer_single_page !== '') {
        $page_name_class .= ' designer_single_page';
    }

    if (is_tax()) {
        $page_name_class .= ' shop category_page';
    }
    ?>
    <div class="base<?php echo esc_attr($page_name_class); ?>">