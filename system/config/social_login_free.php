<?php 
$_['social_login_free_setting'] = array(
    "name" => "",
    "size" => "icon", 
    "base_url" => "", 
    "return_page" => "viewed",
    "return_url" => "",
    "background_img" => "data/social_login_free/social_login_free_bg.png",
    "providers" => array ( 

      "Google" => array ( 
        "enabled" => false,
        "keys"    => array ( "id" => "", "secret" => "" ), 
        "id"  => 'google',
        "sort_order" => 1,
        "icon" => 'icon-google-plus',
        "background_color" => '#dd4b39',
        "background_color_active" => '#be3e2e',
      ),

      "Facebook" => array ( 
        "enabled" => false,
        "keys"    => array ( "id" => "", "secret" => "" ), 
        "id"  => 'facebook',
        "sort_order" => 2,
        "icon" => 'icon-facebook',
        "background_color" => '#4864b4',
        "background_color_active" => '#3a5192',
      ),

      "Twitter" => array ( 
        "enabled" => false,
        "keys"    => array ( "key" => "", "secret" => "" ),
        "id"  => 'twitter',
        "sort_order" => 3,
        "icon" => 'icon-twitter-bird',
        "background_color" => '#00ceff',
        "background_color_active" => '#03b3dd',
      )

      
    ),
    'fields' => array('firstname' => array('id' => 'firstname', 'enabled' => true, 'sort_order' => 1, 'type' => 'text'),
                      'lastname' => array('id' => 'lastname', 'enabled' => true, 'sort_order' => 2, 'type' => 'text'),
                      'phone' => array('id' => 'phone', 'enabled' => true, 'sort_order' => 3, 'type' => 'text', 'mask' => '9(999) 9999-9999?9'),
                      'address_1' => array('id' => 'address_1', 'enabled' => true, 'sort_order' => 4, 'type' => 'text'),
                      'address_2' => array('id' => 'address_2', 'enabled' => true, 'sort_order' => 5, 'type' => 'text'),
                      'city' => array('id' => 'city', 'enabled' => true, 'sort_order' => 6, 'type' => 'text'),
                      'postcode' => array('id' => 'postcode', 'enabled' => true, 'sort_order' => 7, 'type' => 'text'),
                      'country_id' => array('id' => 'country_id', 'enabled' => true, 'sort_order' => 8, 'type' => 'select'),
                      'zone_id' => array('id' => 'zone_id', 'enabled' => true, 'sort_order' => 9, 'type' => 'select'),
                      'company' => array('id' => 'company', 'enabled' => true, 'sort_order' => 10, 'type' => 'text'),
                      'company_id' => array('id' => 'company_id', 'enabled' => true, 'sort_order' => 11, 'type' => 'text'),
                      'tax_id' => array('id' => 'tax_id', 'enabled' => true, 'sort_order' => 12, 'type' => 'text'),
                      'password' => array('id' => 'password', 'enabled' => true, 'sort_order' => 13, 'type' => 'password'),
                      'confirm' => array('id' => 'confirm', 'enabled' => true, 'sort_order' => 14, 'type' => 'password')
    ),
    "debug_mode" => false,
    "base_url_index" => true,

    "debug_file" => "logs/social_login_free.txt",  
  );

?>