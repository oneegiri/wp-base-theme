<?php
require_once UTILS_ROOT . '/sidebar-factory.php';

function register_custom_sidebars(){
  sidebar_factory(array(
    [ 
      'name' => 'Footer Sidebar', 
      'id' => 'footer-sidebar', 
      'description' => 'Displays widgets into the footer.',
      'before_widget' => '<div id="%1$s" class="col-6 col-md-3 mb-5 mb-md-0 widget--%2$s">', 
      'after_widget' => '</div>', 
      'before_title' => '<h6 class="widget-title mb-3">', 
      'after_title' => '</h6>', 
    ],
  ));
}

add_action('widgets_init', 'register_custom_sidebars');