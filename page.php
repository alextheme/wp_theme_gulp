<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();  ?>

    <!-- Вивід постів, функцій цикла: the_title() і т.п -->
    <?php
    $page_name = '';
    if (function_exists('is_account_page') && is_account_page()) $page_name = 'my_account';
    if (function_exists('is_cart') && is_cart()) $page_name = 'cart';
    if (is_page('cart-classic')) $page_name = 'cart-classic';
    ?>

    <section class="section <?php echo esc_attr($page_name); ?>">
        <div class="section_in">

        <?php if (!is_page(['my-account', 'cart', 'cart-classic'])) { ?>
            <h2><?php the_title(); ?></h2>
        <?php } ?>

        <?php the_content(); ?>

        </div>
    </section>

<?php endwhile; else: ?>
    Записів немає
<?php endif; ?>

<?php get_footer(); ?>
