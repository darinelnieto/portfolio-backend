<?php
add_action( 'rest_api_init', function () {
  register_rest_route( 'about', '/content', array(
      array(
          'methods'               => WP_REST_Server::READABLE,
          'callback'              => 'about_handler',
          'permission_callback'   => '__return_true',          
      )
  ));
});
function about_handler(){
    $seo = get_field('seo_about', 'option');
    // Seo
    $keywords = [];
    if(!empty($seo['keywords'])){
        foreach($seo['keywords'] as $key){
        array_push($keywords, $key['keyword']);
        };
    };
    $hero = get_field('hero_about', 'option');
    $tecnical = get_field('tecnical_focus', 'option');
    $tecnical_list = [];
    if(!empty($tecnical['tecnical_list'])){
        foreach($tecnical['tecnical_list'] as $item){
            array_push($tecnical_list, array(
                'description' => $item['description'] ?? '',
                'icon' => wp_get_attachment_image($item['icon'], '', false, array(
                    'class' => 'icon',
                    'loading' => 'lazy',
                    'decoding' => 'async'
                )) ?? ''
            ));
        }
    }
    // Time line
    $experience_content = get_field('experience_content', 'option');
    $experience = [];
    if(!empty($experience_content['time_line'])){
        foreach($experience_content['time_line'] as $item){
            array_push($experience, array(
                'company' => $item['company'] ?? '',
                'date' => $item['date'] ?? '',
                'rol' => $item['rol'] ?? '',
                'description' => $item['description'] ?? ''
            ));
        }
    }
    $about = [
        "hero" => [
            "title" => $hero['title'] ?? '',
            "description" => $hero['description'] ?? '',
            "image" => wp_get_attachment_image($hero['image'], 'full', false, array(
                'class'=> 'hero-image',
                'loading' => 'lazy', 
                'fetchpriority' => 'high',
                'decoding' => 'sync'
            )) ?? '',
            "profesional_title" => $hero['profesional_title'] ?? '',
            "profesional_description" => $hero['profesional_description'] ?? ''
        ],
        "tecnical_focus" => [
            "title" => $tecnical['title'] ?? '',
            "list" => $tecnical_list ?? [],
        ],
        "experience" => [
            "title" => $experience_content['title'] ?? '',
            "time_line" => $experience ?? [], 
        ],
        "seo" => [
            'title' => $seo['title'] ?? '',
            'description' => $seo['description'] ?? '',
            'keywords' => $keywords ?? '',
        ],
    ];
    return $about;
}