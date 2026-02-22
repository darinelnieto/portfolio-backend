<?php
add_action( 'rest_api_init', function () {
  register_rest_route( 'portfolio', '/content', array(
      array(
          'methods'               => WP_REST_Server::READABLE,
          'callback'              => 'portfolio_handler',
          'permission_callback'   => '__return_true',          
      )
  ));
});
function portfolio_handler(){
    $seo = get_field('seo_portfolio', 'option');
    $hero = get_field('hero_portfolio', 'option');
    $portfolio_cat = get_field('portfolio_list', 'option');
    // Seo
    $keywords = [];
    if(!empty($seo['keywords'])){
        foreach($seo['keywords'] as $key){
        array_push($keywords, $key['keyword']);
        };
    };
    // Hero nav
    $nav = [];
    if(!empty($hero['nav'])){
        foreach($hero['nav'] as $item){
            array_push($nav, array(
                'text' => $item['item_text'] ?? '',
                'link' => $item['item_link'] ?? '',
            ));

        }
    }
    // Portfolio
    $portfolio = [];
    if(!empty($portfolio_cat)){
        foreach($portfolio_cat as $item){
            $list = new WP_Query(array('post_type' => 'portfolio', 'portfolio_cat'=> $item['portfolio_category']->slug, 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC',));
            $posts = [];
            if($list->have_posts()){
                while($list->have_posts()){
                    $list->the_post();
                    $project = get_field('project_content', $list->ID);
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
                    array_push($posts, array(
                        'id' =>  get_the_id(),
                        'thumbnail' => get_the_post_thumbnail($list->ID, 'large'),
                        'name' => get_the_title($list->ID),
                        'short_description' => get_the_content(),
                        'name_complement' => $project['name_complement'],
                        'project_type' => $project['project_type'],
                        'description' => $project['content'],
                        'icons'=>$icons
                    ));
                }
                wp_reset_postdata();
            }
            array_push($portfolio, array(
                'section_id' =>  $item['section_id'] ?? '',
                'title' => $item['title'] ?? '',
                'description' => $item['description'] ?? '',
                'posts' => $posts
            ));
        }
    }
    $portfolio_page = [
        'hero' => [
            'title' => $hero['title'] ?? '',
            'desctiprion' => $hero['description'] ?? '',
            'image' => wp_get_attachment_image($hero['image'], 'full', false, array(
                'class' => 'main-image',
                'loading' => 'eager', 
                'fetchpriority' => 'high',
                'decoding' => 'sync'
            )) ?? '',
            'nav' => $nav
        ],
        'portfoilo_list' => $portfolio,
        'cta_text' => get_field('cta_text', 'option') ?? '',
        'seo' => [
            'title' => $seo['title'] ?? '',
            'description' => $seo['description'] ?? '',
            'keywords' => $keywords ?? '',
        ],
    ];
    return $portfolio_page;
}