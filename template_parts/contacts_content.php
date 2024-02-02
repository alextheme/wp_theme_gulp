<?php global $_themename_text; ?>

<div class="contacts__content">

    <h2 class="contacts__title m-data">
        <?php echo $_themename_text['contact_title']; ?>
    </h2>

    <?php if (get_field('contacts_email', 'option')) { ?>

        <a class="contacts__email" href="mailto:<?php the_field('contacts_email', 'option'); ?>">
            <?php the_field('contacts_email', 'option'); ?>
            <span class="contacts__link_icon_w">
                <svg class="icon icon_basket icon--size_mod">
                    <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#mail' ?>"></use>
                </svg>
            </span>
        </a>

    <?php } ?>

    <?php if (get_field('contacts_phone', 'option')) { ?>

        <a class="contacts__phone" href="tel:<?php the_field('contacts_phone', 'option'); ?>">
            <?php the_field('contacts_phone', 'option'); ?>
            <span class="contacts__link_icon_w">
                <svg class="icon icon_basket icon--size_mod">
                    <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#phone' ?>"></use>
                </svg>
            </span>
        </a>
    <?php } ?>

</div>

