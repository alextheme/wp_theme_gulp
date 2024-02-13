<?php

/* Template Name: Template Home Page */

get_header();

if (function_exists('get_field')) {

    global $post;

    get_template_part('parts/home', 'hero');

    $args = array(
        'mod' => '',
        'title_section' => get_field('poster_of_the_month_title', $post->ID),
        'posters' => get_field('poster_of_the_month', $post->ID),
    );
    get_template_part('parts/home', 'posters', $args);


    $args = array(
        'mod' => 'posters--popular_mod',
        'title_section' => get_field('popularni_autorzy_title', $post->ID),
        'posters' => get_field('popularni_autorzy', $post->ID),
        'bg_section' => get_field('popularni_autorzy_background', $post->ID),
    );
    get_template_part('parts/home', 'posters', $args);


    $args = array(
        'mod' => 'posters--new_mod',
        'title_section' => get_field('new_additions_pigasus_title', $post->ID),
        'posters' => get_field('new_additions_pigasus', $post->ID),
    );
    get_template_part('parts/home', 'posters', $args);

    get_template_part('parts/home', 'about');

    get_template_part('parts/home', 'contacts');

}

get_footer();
