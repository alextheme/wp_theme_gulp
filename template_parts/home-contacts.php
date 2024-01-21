<?php global $post; ?>

<section class="section contacts">
    <div class="section_in">
        <div class="contacts_wrapper">

            <div class="contacts__row">

                <div class="contacts__col">

                    <?php get_template_part('template_parts/contacts_content') ?>

                    <?php
                    $contact_images = get_field('home_contacts_images', $post->ID);
                    ?>

                    <picture class="contacts__img_w">
                        <source media="(min-width: 1024px)" srcset="<?php echo $contact_images[0]['img']; ?>" type="image/png">
                        <img class="contacts__img" src="<?php echo $contact_images[0]['img']; ?>" alt=" " loading="lazy">
                    </picture>
                </div>

                <div class="contacts__col">
                    <picture class="contacts__img_w">
                        <source media="(min-width: 1024px)" srcset="<?php echo $contact_images[1]['img']; ?>" type="image/png">
                        <img class="contacts__img" src="<?php echo $contact_images[1]['img']; ?>" alt=" " loading="lazy">
                    </picture>
                </div>

                <div class="contacts__col">
                    <picture class="contacts__img_w">
                        <source media="(min-width: 1024px)" srcset="<?php echo $contact_images[2]['img']; ?>" type="image/jpeg">
                        <img class="contacts__img" src="<?php echo $contact_images[2]['img']; ?>" alt=" " loading="lazy">
                    </picture>
                </div>

            </div>
        </div>
    </div>
</section>

