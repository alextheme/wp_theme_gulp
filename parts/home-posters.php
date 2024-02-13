<?php
global $args, $_themename_text;

$mod = $args['mod'];
$title_section = $args['title_section'];

if (key_exists('bg_section', $args)) {
    $bg_section = $args['bg_section'];
} else {
    $bg_section = '';
}

$posters = $args['posters'];

$lang = _themename_get_lang();
?>


<?php
if ($bg_section !== '') {
    $style = 'style="background: #EFEFEF url(' . $bg_section . ') center center no-repeat;background-size:cover;"';
} else {
    $style = '';
}
?>

<?php if (count($args['posters'])) { ?>

<section class="section posters <?php echo esc_attr($mod) ?>" <?php echo esc_attr($style); ?>>
    <div class="section_in">

        <div class="posters__header">
            <h2 class="posters__title m-data"><?php echo esc_html__($title_section) ?></h2>
            <a class="posters__button" href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">
                <?php echo $_themename_text['view_all']; ?>
                <span class="posters__button_i_w icon">
                    <svg class="icon icon_arrow_right icon--size_mod">
                        <use xlink:href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/sprite.svg#arrow_1'); ?>"></use>
                    </svg>
                </span>
            </a>
        </div>

        <ul class="posters__list">

            <?php
            foreach ($args['posters'] as $prd) {
                $product = wc_get_product($prd->ID);
                $product_url = get_permalink($prd->ID);
                $product_image_url = get_the_post_thumbnail_url($prd->ID);
                ?>

                <li class="posters__it">
                    <div class="posters__it_w">

                        <a class="posters__it_link" href="<?= esc_url($product_url); ?>">
                            <picture class="posters__it_img_w">
                                <source media="(min-width: 1024px)" srcset="<?php echo esc_url($product_image_url) ?>"
                                        type="image/png">
                                <img class="posters__it_img" src="<?php echo esc_url($product_image_url) ?>" alt=" "
                                     loading="lazy">
                            </picture>
                        </a>

                        <div class="posters__it_data">
                            <h3 class="posters__it_title notranslate">
                                <!-- JSON DATA -->
                                <a class="posters__it_link notranslate" href="<?php echo esc_url($product_url); ?>">
                                    <?php echo wp_kses_post($product->get_title()); ?>
                                </a>
                            </h3>
                            <div class="posters__it_row">
                                <div class="posters__it_name shppb notranslate">
                                    <?php echo esc_html($product->get_attribute('poster-designer')); ?>
                                </div>
                                <div class="posters__it_price"><?php echo $product->get_price_html(); ?></div>
                            </div>

                            <?php if ($mod === 'posters--popular_mod') { ?>

                                <?php
                                $attributes = $product->get_attributes();
                                $taxonomy_poster_designer = $attributes['pa_poster-designer'];

                                $designer_href = sprintf("%s?filter_poster-designer=%s&single-page=1",
                                    get_permalink( wc_get_page_id( 'shop' )),
                                    $taxonomy_poster_designer->get_slugs()[0]
                                ); ?>

                                <a class="posters__it_btn" href="<?php echo esc_url($designer_href)?>">
                                    <span class="add-to-cart">
                                        <?php echo $_themename_text['all_works']; ?>
                                    </span>
                                </a>

                            <?php } else {

                                if ($product->get_type() === 'simple') { ?>

                                    <a class="posters__it_btn product_type_simple add_to_cart_button ajax_add_to_cart"
                                       data-clases-actions="loading added"
                                       href="?add-to-cart=<?php echo esc_attr($prd->ID); ?>"
                                       data-quantity="1"
                                       data-product_id="<?php echo esc_attr($prd->ID); ?>"
                                       data-product_sku="<?php echo esc_attr($product->get_sku()); ?>"
                                       aria-label="<?php echo esc_attr($product->get_title()); ?>"
                                       aria-describedby=""
                                       rel="nofollow"
                                    >
                                        <span class="add-to-cart">
                                            <?php echo $_themename_text['add_to_cart']; ?>
                                        </span>
                                        <span class="added">
                                            <?php echo $_themename_text['added']; ?>
                                        </span>
                                        <i class="fas fa-shopping-cart">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="18" viewBox="0 0 576 512">
                                                <path opacity="1" fill="#fff" d="M528.1 301.3l47.3-208C578.8 78.3 567.4 64 552 64H159.2l-9.2-44.8C147.8 8 137.9 0 126.5 0H24C10.7 0 0 10.7 0 24v16c0 13.3 10.7 24 24 24h69.9l70.2 343.4C147.3 417.1 136 435.2 136 456c0 30.9 25.1 56 56 56s56-25.1 56-56c0-15.7-6.4-29.8-16.8-40h209.6C430.4 426.2 424 440.3 424 456c0 30.9 25.1 56 56 56s56-25.1 56-56c0-22.2-12.9-41.3-31.6-50.4l5.5-24.3c3.4-15-8-29.3-23.4-29.3H218.1l-6.5-32h293.1c11.2 0 20.9-7.8 23.4-18.7z"/>
                                            </svg>
                                        </i>
                                        <i class="fas fa-box">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                                                <path opacity="1" fill="#fff" d="M50.7 58.5L0 160H208V32H93.7C75.5 32 58.9 42.3 50.7 58.5zM240 160H448L397.3 58.5C389.1 42.3 372.5 32 354.3 32H240V160zm208 32H0V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192z"/>
                                            </svg>
                                        </i>

                                    </a>

                                <?php } else { ?>

                                    <button class="posters__it_btn" type="button"><?php echo $_themename_text['add_to_cart']; ?></button>

                                <?php } ?>

                            <?php } ?>

                            <div class="posters__it_bottom_row">
                                <div class="posters__it_text"><?php echo $_themename_text['tax_shipping_cost']; ?></div>
                                <div class="posters__it_text"><?php echo $_themename_text['shipping_24h']; ?></div>
                            </div>
                        </div>
                    </div>
                </li>

            <?php } ?>

        </ul>

        <a class="posters__bottom_button" href="<?= esc_url(get_permalink(wc_get_page_id('shop'))); ?>">
            <?php echo $_themename_text['view_all']; ?>
            <span class="posters__button_i_w icon">
                <svg class="icon icon_arrow_right icon--size_mod">
                    <use xlink:href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/sprite.svg#arrow_1'); ?>"></use>
                </svg>
            </span>
        </a>
    </div>
</section>

<?php } ?>