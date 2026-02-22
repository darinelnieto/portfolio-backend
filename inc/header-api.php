<?php
add_action( 'rest_api_init', function () {
  register_rest_route( 'header', '/content', array(
      array(
          'methods'               => WP_REST_Server::READABLE,
          'callback'              => 'header_handler',
          'permission_callback'   => '__return_true',          
      )
  ));
});
function header_handler(){
  $logo = get_field('custom_logo', 'option');
  $logo_white = get_field('custom_logo_white', 'option');
  $header = [
    'favicon' => get_field('favicon', 'option')['url'] ?? '',
    'logo' => wp_get_attachment_image($logo, 'medium', false, array( 
      'class' => 'main-logo', 
      'loading' => 'lazy',
      'decoding' => 'async'
    )) ?? '',
    'nav' => get_field('nav_menu', 'option') ?? '',
  ];
  return $header;
} 