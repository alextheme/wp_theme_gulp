<?php

/* Template Name: Template Designers Page */

get_header();

global $_themename_text;

$taxonomy_poster_designer = 'pa_poster-designer';

$designers = get_terms( array(
    'taxonomy' => 'pa_poster-designer',
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
            <h2 class="posters__title notranslate">
                <?php
                if ( have_posts() ) :while ( have_posts() ) : the_post();
                the_title();
                endwhile; endif; ?>
            </h2>
        </div>

        <ul class="posters__list">
<?php

$get_value_from = get_field('get_value_from', 'option');

$popular_designer_list = [
    'Andrzej Pągowski',
    'Ryszard Kaja',
    'Franciszek Starowieyski',
    'Jakub Erol',
    'Jerzy Flisak',
    'Jan Młodożeniec',
    'Wiesław Wałkuski',
    'Mieczysław Górowski',
    'Stasys Eidrigevicius',
    'Sebastian Kubica',
    'Tomasz Bogusławski',
    'Wiktor Sadowski',
    'Romuald Socha',
    'Mieczysław Wasilewski',
    'Leszek Żebrowski',
    'Waldemar Świerzy',
];

if ($get_value_from === 'selected') {
    $popular_designer_list = [];
    foreach (get_field('popular_designers_on_the_designers_page', 'option') as $value) {
        array_push($popular_designer_list, trim($value['designer']));
    }
}

if ($get_value_from === 'join') {
    foreach (get_field('popular_designers_on_the_designers_page', 'option') as $value) {
        array_push($popular_designer_list, trim($value['designer']));
    }
}

$designer_index = 0;
$designer_per_page = 16;
$args = array( 'post_type' => 'product', 'posts_per_page' => -1,
    'tax_query' => array( array( 'taxonomy' => 'pa_poster-designer', 'field' => 'term_id', 'terms' => 0 ) ),
);

foreach ($designers as $designer) {

    //if ($designer_index >= $designer_per_page) break;

    if (!in_array($designer->name, $popular_designer_list)) {
        continue;
    }

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
