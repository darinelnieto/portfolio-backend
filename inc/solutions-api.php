<?php 
add_action( 'rest_api_init', function () {
  register_rest_route( 'solutions', '/content', array(
      array(
          'methods'               => WP_REST_Server::READABLE,
          'callback'              => 'solutions_handler',
          'permission_callback'   => '__return_true',          
      )
  ));
});
function solutions_handler(){
    $hero = get_field('hero_solutions', 'option');
    $services = get_field('solutions_content', 'option');
    $seo = get_field('seo_solutions', 'option');
    // Service list
    $service_list = [];
    if(!empty($services['services'])){
        foreach($services['services'] as $item){
            array_push($service_list, array(
                'icon' => wp_get_attachment_image($item['icon'], 'medium', false, array(
                    'class' => 'services-icon',
                    'loading' => 'lazy',
                    'decoding' => 'async'
                )) ?? '',
                'name' => $item['name'] ?? '',
                'description' => $item['description'] ?? ''
            ));
        }
    }
    // Seo
    $keywords = [];
    if(!empty($seo['keywords'])){
        foreach($seo['keywords'] as $key){
        array_push($keywords, $key['keyword']);
        };
    };
    $solutions = [
        "hero" => [
            'title' => $hero['title'] ?? '',
            'description' => $hero['description'] ?? '',
            'image' => wp_get_attachment_image($hero['image'], 'full', false, array(
                'class' => 'hero-image',
                'loading' => 'lazy', 
                'fetchpriority' => 'high',
                'decoding' => 'sync'
            )) ?? ''
        ],
        "services" => [
            "title" => $services['title'] ?? '',
            "service_list" => $service_list ?? []
        ],
        'seo' => [
            'title' => $seo['title'] ?? '',
            'description' => $seo['description'] ?? '',
            'keywords' => $keywords ?? [],
        ]
    ];
    return $solutions;
}