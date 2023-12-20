<?php

if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0.0' );
}

require get_template_directory() . '/inc/woocommerce_hook.php';

//function _themename_setup() {
//
//	load_theme_textdomain( '_themename', get_template_directory() . '/languages' );
//
//	// Add default posts and comments RSS feed links to head.
//	add_theme_support( 'automatic-feed-links' );
//
//	add_theme_support( 'title-tag' );
//
//	add_theme_support( 'post-thumbnails' );
//
//	// This theme uses wp_nav_menu() in one location.
//	register_nav_menus(
//		array(
//			'main_menu' => esc_html__( 'Primary', '_themename' ),
//			'bottom_menu_1' => esc_html__( 'Bottom_1', '_themename' ),
//			'bottom_menu_2' => esc_html__( 'Bottom_2', '_themename' ),
//			'bottom_menu_3' => esc_html__( 'Bottom_3', '_themename' ),
//		)
//	);
//
//	add_theme_support(
//		'html5',
//		array(
//			'search-form',
//			'comment-form',
//			'comment-list',
//			'gallery',
//			'caption',
//			'style',
//			'script',
//		)
//	);
//
//	add_theme_support(
//		'custom-background',
//		apply_filters(
//			'_themename_custom_background_args',
//			array(
//				'default-color' => 'ffffff',
//				'default-image' => '',
//			)
//		)
//	);
//
//	add_theme_support( 'customize-selective-refresh-widgets' );
//
//	add_theme_support(
//		'custom-logo',
//		array(
//			'height'      => 250,
//			'width'       => 250,
//			'flex-width'  => true,
//			'flex-height' => true,
//		)
//	);
//}
//add_action( 'after_setup_theme', '_themename_setup' );
//
//function _themename_content_width() {
//	$GLOBALS['content_width'] = apply_filters( '_themename_content_width', 1220 );
//}
//add_action( 'after_setup_theme', '_themename_content_width', 0 );
//
//function _themename_widgets_init() {
//	register_sidebar(
//		array(
//			'name'          => esc_html__( 'Sidebar', '_themename' ),
//			'id'            => 'sidebar-1',
//			'description'   => esc_html__( 'Add widgets here.', '_themename' ),
//			'before_widget' => '<section id="%1$s" class="widget %2$s">',
//			'after_widget'  => '</section>',
//			'before_title'  => '<h2 class="widget-title">',
//			'after_title'   => '</h2>',
//		)
//	);
//}
//add_action( 'widgets_init', '_themename_widgets_init' );
//
//function _themename_scripts() {
//	wp_enqueue_style( '_themename-style', get_stylesheet_uri(), array(), _S_VERSION );
//	wp_enqueue_style( '_themename-stylesheet', get_template_directory_uri() . '/assets/css/bundle.css', array(), _S_VERSION, 'all' );
//
//    wp_enqueue_script( '_themename-scripts', get_template_directory_uri() . '/assets/js/bundle.js', array('jquery'), _S_VERSION, true );
//
//	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
//		wp_enqueue_script( 'comment-reply' );
//	}
//}
//add_action( 'wp_enqueue_scripts', '_themename_scripts' );
//
//require get_template_directory() . '/inc/woocommerce_settings.php';
