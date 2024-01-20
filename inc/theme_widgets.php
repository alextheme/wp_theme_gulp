<?php

function _themename_content_width()
{
    $GLOBALS['content_width'] = apply_filters('_themename_content_width', 1220);
}

add_action('after_setup_theme', '_themename_content_width', 0);

function _themename_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar', '_themename'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here.', '_themename'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => esc_html__('gTranslate', '_themename'),
        'id' => '_themename_gtranslate_widgets',
        'description' => __('Widget for site language switching buttons', '_themename'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
}

add_action('widgets_init', '_themename_widgets_init');










