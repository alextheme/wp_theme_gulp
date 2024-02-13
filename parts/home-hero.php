<?php

global $post, $_themename_text;

if (function_exists('the_field')) {

?>

<section class="home_hero">
    <div class="home_hero__in">
        <h1 class="home_hero__title m-data"><?php the_field('home_hero_title', $post->ID) ?></h1>
        <span class="home_hero__subtitle m-data"><?php the_field('home_hero_subtitle', $post->ID) ?></span>
        <a class="home_hero__button" href="<?php echo esc_url(get_home_url() . '/designers'); ?>">
            <?php echo $_themename_text['designer']; ?>
        </a>

        <ul class="home_hero__gallery_list">
            <?php $home_hero_images = get_field('home_hero_images', $post->ID); ?>
            <?php if ($home_hero_images) { foreach ($home_hero_images as $img) { ?>
                <li class="home_hero__gallery_item">
                    <div class="home_hero__img_w">
                        <img class="home_hero__img" src="<?php echo esc_url($img['url'])?>" alt="">
                    </div>
                </li>
            <?php }} ?>
        </ul>
    </div>
</section>

<?php } ?>
