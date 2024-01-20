<?php

function _themename_scripts() {
	wp_enqueue_style( '_themename-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( '_themename-stylesheet', get_template_directory_uri() . '/assets/css/bundle.css', array(), _S_VERSION, 'all' );

    wp_enqueue_script( '_themename-scripts', get_template_directory_uri() . '/assets/js/bundle.js', array('jquery'), _S_VERSION, true );
}

add_action( 'wp_enqueue_scripts', '_themename_scripts' );
