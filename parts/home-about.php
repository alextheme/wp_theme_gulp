<?php global $post, $_themename_text; ?>

<section class="section about">
    <div class="section_in">
        <div class="about__row">

            <div class="about__col">
                <?php $img_link = get_field('home_about_image', $post->ID); ?>
                <picture class="about__img_w">
                    <source media="(min-width: 1024px)" srcset="<?php echo $img_link; ?>" type="image/png">
                    <img class="about__img" src="<?php echo $img_link; ?>" alt=" " loading="lazy">
                </picture>
            </div>

            <div class="about__col">
                <div class="about__content">
                    <h2 class="about__title m-data">
                        <?php the_field('home_about_title', $post->ID); ?>
                    </h2>

                    <p class="about__description m-data">
                        <span><?php the_field('home_about_description', $post->ID); ?></span>
                    </p>

                    <a class="about__button" href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">
                        <?php echo $_themename_text['btn_catalog']; ?>
                    </a>

                </div>
            </div>
        </div>
    </div>
</section>