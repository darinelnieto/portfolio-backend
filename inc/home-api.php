<?php
add_action( 'rest_api_init', function () {
  register_rest_route( 'home', '/content', array(
      array(
          'methods'               => WP_REST_Server::READABLE,
          'callback'              => 'home_handler',
          'permission_callback'   => '__return_true',          
      )
  ));
});
function home_handler(){
  $seo = get_field('seo_content', 'option');
  $keywords = [];
  if(!empty($seo['keywords'])){
    foreach($seo['keywords'] as $key){
      array_push($keywords, $key['keyword']);
    };
  };
  // Hero content
  $hero = get_field('hero_home', 'option');
  $ctas = $hero['ctas'];
  // specialties
  $specialties = get_field('specialties', 'option');
  $technologies = [];
  if(!empty($specialties['technologies'])){
    foreach($specialties['technologies'] as $item){
      array_push($technologies, array(
        'icon' => wp_get_attachment_image($item['icon'], 'medium', false, array(
          'class' => 'icon-image',
          'loading' => 'lazy',
          'decoding' => 'async'
          )) ?? '',
        'name' => $item['name'] ?? '',
        'description' => $item['description'] ?? '',
      ));
    }
  }
  // Projects
  $projects = [];
  $projects_list = get_field('projects', 'option')['projects_list'];
  if(!empty($projects_list)){
    foreach($projects_list as $item){
      $project = get_field('project_content', $item);
      $icons = [];
      if(!empty($project['icons'])){
        foreach($project['icons'] as $icon){
          array_push($icons, array(
            'icon' => wp_get_attachment_image($icon, 'medium', false, array(
              'class' => 'project-icon', 
              'loading' => 'lazy',
              'decoding' => 'async'
            )) ?? ''
          ));
        }
      }
      array_push($projects, array(
        'thumbnail' => get_the_post_thumbnail($item, 'large'),
        'name' => get_the_title($item),
        'name_complement' => $project['name_complement'],
        'project_type' => $project['project_type'],
        'description' => $project['content'],
        'icons'=>$icons
      ));
    }
  }
  // working methods
  $working_methods = get_field('working_methods', 'option');
  $methods = [];
  if(!empty($working_methods['methods'])){
    foreach($working_methods['methods'] as $item){
      array_push($methods, array(
        'icon' => wp_get_attachment_image($item['icon'], 'medium', false, array(
          'class' => 'methods-icon',
          'loading' => 'lazy',
          'decoding' => 'async'
        )),
        'name' => $item['name'],
        'description' => $item['description']
      ));
    }
  }
  // Home return
  $home = [
    'hero' => [
      'title' => $hero['title'] ?? '',
      'description' => $hero['description'] ?? '',
      'text_end' => $hero['text_end'] ?? '',
      'main_image' => wp_get_attachment_image($hero['main_image'], 'full', false, array(
        'class' => 'hero-image',
        'loading' => 'lazy', 
        'fetchpriority' => 'high',
        'decoding' => 'sync'
      )) ?? '',
      'ctas' => $ctas,
    ],
    'specialties'=>[
      "title" => $specialties['title'] ?? '',
      "description" => $specialties['description'] ?? '',
      "technologies" => $technologies,
    ],
    "projects"=>[
      "title" => get_field('projects', 'option')['title'] ?? '',
      "list" => $projects
    ],
    "working_methods" => [
      "title" => $working_methods['title'] ?? '',
      "description" => $working_methods['description'] ?? '',
      "methods" => $methods
    ],
    'seo' => [
      'title' => $seo['title'] ?? '',
      'description' => $seo['description'] ?? '',
      'keywords' => $keywords ?? '',
    ]
  ];
  return $home;
}