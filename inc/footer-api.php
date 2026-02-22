<?php
add_action( 'rest_api_init', function () {
  register_rest_route( 'footer', '/content', array(
      array(
          'methods'               => WP_REST_Server::READABLE,
          'callback'              => 'footer_handler',
          'permission_callback'   => '__return_true',          
      )
  ));
});
function footer_handler(){
    $contact = get_field('contact', 'option');
    $services = [];
    if(!empty($contact['services_type'])){
        foreach($contact['services_type'] as $item){
            array_push($services, array(
                'item' => $item['service']
            ));
        }
    }
    // Footer
    $footer_content = get_field('footer', 'option');
    $contact_nav = [];
    if(!empty($footer_content['contact'])){
        foreach($footer_content['contact'] as $item){
            array_push($contact_nav, array(
                'icon' => wp_get_attachment_image($item['icon'], 'medium', false, array(
                    'class' => 'icon-image', 
                    'loading' => 'lazy',
                    'decoding' => 'async'
                )) ?? '',
                'link' => $item['contact_text']['url'] ?? '',
                'text' => $item['contact_text']['title'] ?? ''
            ));
        }
    }
    // Social networks
    $social_networks = [];
    if(!empty($footer_content['social_networks'])){
        foreach($footer_content['social_networks'] as $item){
            array_push($social_networks, array(
                'icon' => wp_get_attachment_image($item['icon'], 'medium', false, array(
                    'class' => 'icon-image',
                    'loading' => 'lazy',
                    'decoding' => 'async'
                )) ?? '',
                'link' => $item['item']['url'] ?? '',
                'text' => $item['item']['title'] ?? ''
            ));
        }
    }
    $footer = [
        'contact' => [
            'title' => $contact['form_title'] ?? '',
            'description' => $contact['form_description'] ?? '',
            'form' => [
                'name_label' => $contact['name_label'] ?? '',
                'email_label' => $contact['email_label'] ?? '',
                'phone_label' => $contact['phone_label'] ?? '',
                'services_placeholder' => $contact['services_placeholder'] ?? '',
                'service' => $services ?? [],
                'button_text' => $contact['button_text'] ?? '',
                'sms_thank_you' => $contact['sms_thank_you'] ?? ''
            ]
        ],
        'footer' => [
            'contact_nav' => [
                'title' => $footer_content['contacto_title'] ?? '',
                'nav' => $contact_nav ?? []
            ],
            'social_networks' => [
                'title' => $footer_content['social_networks_title'] ?? '',
                'nav' => $social_networks ?? []
            ],
            'menu' => [
                'title' => $footer_content['menu_title'] ?? '',
                'menu_items' => $footer_content['menu_items'] ?? ''
            ],
            'copy_right' => $footer_content['copyright'] ?? '',
        ]
    ];
    return $footer;
}