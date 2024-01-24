<?php

/* Template Name: Template Designers Page */

get_header();

global $_themename_text;

$taxonomy_poster_designer = 'pa_poster-designer';

$designers = get_terms( array(
    'taxonomy' => $taxonomy_poster_designer,
    'hide_empty' => true, // Показывать термины, которые привязаны к постам
) );

?>

<section class="section posters_breadcrumb">
    <div class="section_in">
        <?php woocommerce_breadcrumb(); ?>
    </div>
</section>

<section class="section posters posters--designers_mod" >
    <div class="section_in">

        <div class="posters__header">
            <h2 class="posters__title"><?php esc_html_e('Designers', '_themename') ?></h2>
        </div>

        <ul class="posters__list">

<?php

$designer_per_page = 16;
$designer_index = 0;
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => -1,
    'tax_query'      => array(
        array(
            'taxonomy' => $taxonomy_poster_designer,
            'field'    => 'term_id',
            'terms'    => 0,
        ),
    ),
);

foreach ($designers as $designer) {

    if ($designer_index >= $designer_per_page) break;

    $args['tax_query'][0]['terms'] = $designer->term_id;

    $query = new WP_Query( $args );

    $get_one_post = true;

    $designer_href = sprintf("%s?filter_poster-designer=%s&single-page=1",
        get_permalink( wc_get_page_id( 'shop' )),
        $designer->slug
    );

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();

            if (!$get_one_post) break; ?>

            <li class="posters__it">
                <div class="posters__it_w">

                    <a class="posters__it_img_w" href="<?php echo esc_url($designer_href)?>">
                        <span class="posters__it_img"><?php the_post_thumbnail(); ?></span>
                    </a>

                    <div class="posters__it_data">
                        <h3 class="posters__it_title notranslate"><?php esc_html_e($designer->name); ?></h3>

                        <a class="posters__it_btn" href="<?php echo esc_url($designer_href)?>">
                            <span>
                                <?php echo $_themename_text['all_works']; ?>
                            </span>
                        </a>
                    </div>
                </div>
            </li>

            <?php $get_one_post = false; ?>
        <?php } ?>


    <?php wp_reset_postdata(); ?>

    <?php } ?>

    <?php $designer_index++; ?>

<?php } ?>

        </ul>
    </div>
</section>


<section class="section designers">
    <div class="section_in">

        <h2 class="designers__title"><?php echo $_themename_text['poster_designers']; ?></h2>
        <ul class="designers__list notranslate">
            <?php foreach ($designers as $designer) { ?>

                <?php
                $designer_getquery = sprintf("%s?filter_poster-designer=%s&single-page=1",
                    get_permalink( wc_get_page_id( 'shop' )),
                    $designer->slug
                );
                ?>

                <li class="designers__item">
                    <a class="designers__link" href="<?php echo esc_url($designer_getquery)?>">
                        <span class="designers__link_text"><?php echo $designer->name; ?></span>&nbsp;
                        <span>(<?php echo $designer->count; ?>)</span>
                    </a>
                </li>

            <?php } ?>
        </ul>

    </div>
</section>

<?php get_footer();
