<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();  ?>
    <!-- Вивід постів, функцій цикла: the_title() і т.п -->
    <h2><?php the_title(); ?></h2>
    <?php the_content(); ?>
<?php endwhile; else: ?>
    Записів немає
<?php endif; ?>

<?php get_footer(); ?>
