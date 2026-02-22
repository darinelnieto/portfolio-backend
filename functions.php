<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register Theme Scripts
 * https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/
 */
function ditto_scripts() {
  wp_enqueue_style( 'core', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'main-styles', get_template_directory_uri() . '/css/main.bundle.css' );
  wp_enqueue_style('bootstrap.css', get_template_directory_uri() . '/css/bootstrap.min.css');
  wp_enqueue_style('owl-carousel.css', get_template_directory_uri() . '/css/owl.carousel.min.css');
  wp_enqueue_style('font-awesome.css', get_template_directory_uri() . '/css/font-awesome.css');
  wp_enqueue_style('aos.css', get_template_directory_uri() . '/css/aos.css');

  wp_enqueue_script( 'main-scripts', get_template_directory_uri() . '/js/main.bundle.js', array( 'jquery' ), '', true );
  wp_enqueue_script('jquery.js', get_template_directory_uri() . '/js/jquery-3.5.1.min.js', true);
  wp_enqueue_script('bootstrap.js',  get_template_directory_uri() . '/js/bootstrap.min.js');
  wp_enqueue_script('owl-carousel.js', get_template_directory_uri() . '/js/owl.carousel.min.js');
  wp_enqueue_script('font-awesome.js', get_template_directory_uri() . '/js/font-awesome.js');
  wp_enqueue_script('aos.js', get_template_directory_uri() . '/js/aos.js');
  wp_register_script('custom.js', get_template_directory_uri() . '/js/custom.js', array('jquery'), '1', true);
  wp_enqueue_script('custom.js');
}
add_action( 'wp_enqueue_scripts', 'ditto_scripts');

/**
 * Register Navigation Menus
 * https://developer.wordpress.org/reference/functions/register_nav_menus/
 */
function ditto_navigation_menus() {
  $locations = array(
    'main_menu' => __( 'Main Menu', 'text_domain' )
  );
  register_nav_menus( $locations );
}
add_action( 'init', 'ditto_navigation_menus' );

/**
 * Theme support
 * https://developer.wordpress.org/reference/functions/add_theme_support/
 */
add_theme_support( 'custom-logo' );

/**
 * Disable Gutenberg
 */
add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter('use_block_editor_for_post_type', '__return_false', 10);
/*========= Search form =========*/
function wpdocs_my_search_form($form)
{
  $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url('/') . '" >
	<input type="text" value="' . get_search_query() . '" name="s" id="s" class="input-search" placeholder="Búsqueda..."/>
	<button id="searchsubmit" class="searchsubmit"><i class="fas fa-search"></i></button>
	</form>';

  return $form;
}
add_filter('get_search_form', 'wpdocs_my_search_form');
/*
*  Options
*/
if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
	  'page_title'    => 'Options theme',
	  'menu_title'    => 'Options theme',
	  'menu_slug'     => 'theme-settings',
	  'capability'    => 'edit_posts',
	  'redirect'      =>  true
	));
  acf_add_options_sub_page(array(
    'page_title'     => 'Footer',
    'menu_title'     => 'Footer',
    'parent_slug'   => 'theme-settings',
  ));
  acf_add_options_sub_page(array(
    'page_title'     => 'Header',
    'menu_title'     => 'Header',
    'parent_slug'   => 'theme-settings',
  ));
  acf_add_options_sub_page(array(
    'page_title'     => 'Home',
    'menu_title'     => 'Home',
    'parent_slug'   => 'theme-settings',
  ));
  acf_add_options_sub_page(array(
    'page_title'     => 'About',
    'menu_title'     => 'About',
    'parent_slug'   => 'theme-settings',
  ));
  acf_add_options_sub_page(array(
    'page_title'     => 'Solutions',
    'menu_title'     => 'Solutions',
    'parent_slug'   => 'theme-settings',
  ));
  acf_add_options_sub_page(array(
    'page_title'     => 'Portfolio',
    'menu_title'     => 'Portfolio',
    'parent_slug'   => 'theme-settings',
  ));
}
/*========= Header content =========*/
define('THEME_INC', get_template_directory() . '/inc/');

// Cargar archivos
require_once THEME_INC . 'header-api.php';
require_once THEME_INC . 'footer-api.php';
require_once THEME_INC . 'home-api.php';
require_once THEME_INC . 'about-api.php';
require_once THEME_INC . 'solutions-api.php';
require_once THEME_INC . 'portfolio-api.php';

/*=========== Team post ===========*/ 
add_theme_support('post-thumbnails');
add_post_type_support( 'portfolio', 'thumbnail' );
function portfolio_post(){
  /*====== Argument post type =====*/
  $projects = array(
    'public' => true,
    'has_archive' => true,
    'label'  => 'Projects',
    'menu_icon' => 'dashicons-portfolio',
    'supports' => ['title', 'editor', 'thumbnail']
  );
  /*============ Register post type ============*/
  register_post_type('portfolio', $projects);
  /*============ Argument taxonimy ============*/
   $labels = array(
    'name' => _x('Portofilo category', 'taxonomy general name'),
    'singular_name' => _x('Portofilo category', 'taxonomy singular name'),
    'search_items' =>  __('Search Portofilo category'),
    'all_items' => __('All Portofilo category'),
    'parent_item' => __('Parent Portofilo category'),
    'parent_item_colon' => __('Parent Portofilo category:'),
    'edit_item' => __('Edit Portofilo category'),
    'update_item' => __('Update Portofilo category'),
    'add_new_item' => __('Add New Portofilo category'),
    'new_item_name' => __('New Portofilo category Name'),
    'menu_name' => __('Portofilo category'),
  );
  /*========== Register taxonomi ==========*/
  register_taxonomy('portfolio_cat', array('portfolio'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array('slug' => 'portfolio_cat'),
  ));
}
add_action('init', 'portfolio_post', 3);

add_filter( 'wp_rest_cache/allowed_endpoints', 'registrar_mis_endpoints_headless', 10, 1 );
function registrar_mis_endpoints_headless( $allowed_endpoints ) {
    $namespaces = ['home', 'header', 'footer', 'about', 'portfolio', 'solutions'];
    foreach ( $namespaces as $ns ) {
        if ( ! isset( $allowed_endpoints[ $ns ] ) ) {
            $allowed_endpoints[ $ns ][] = 'content';
        }
    }
    return $allowed_endpoints;
}