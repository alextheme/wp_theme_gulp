<?php

global $post, $_themename_text;

?>

<section class="home_hero">
    <div class="home_hero__in">
        <h1 class="home_hero__title m-data"><?php the_field('home_hero_title', $post->ID) ?></h1>
        <span class="home_hero__subtitle m-data"><?php the_field('home_hero_subtitle', $post->ID) ?></span>
        <a class="home_hero__button" href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">
            <?php echo $_themename_text['btn_catalog']; ?>
        </a>
        <ul class="home_hero__gallery_list">
            <?php $home_hero_images = get_field('home_hero_images', $post->ID); ?>
            <?php if ($home_hero_images) { foreach ($home_hero_images as $img) { ?>
                <li class="home_hero__gallery_item">
                    <picture class="home_hero__img_w">
                        <source media="(min-width: 1024px)" srcset="<?php echo esc_url($img['url'])?>" type="image/png">
                        <img class="home_hero__img" src="<?php echo esc_url($img['url'])?>" alt="">
                    </picture>
                </li>
            <?php }} ?>
        </ul>
    </div>
</section>
