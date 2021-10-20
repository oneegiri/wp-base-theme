<?php
function get_menu_items($selected_location)
{
  $locations = get_nav_menu_locations();
  $args = array(
    'order'                  => 'ASC',
    'orderby'                => 'menu_order',
    'post_type'              => 'nav_menu_item',
    'post_status'            => 'publish',
    'output'                 => ARRAY_A,
    'output_key'             => 'menu_order',
    'nopaging'               => true,
    'update_post_term_cache' => false
  );
  $items_found = wp_get_nav_menu_items($locations[$selected_location], $args);
  $menu = array();
  $submenu = array();
  if (!empty($items_found)) {
    foreach ($items_found as $m) {
      if (empty($m->menu_item_parent)) {
        $menu[$m->ID]['object_id'] = $m->object_id;
        $menu[$m->ID]['object'] = $m->object;
        $menu[$m->ID]['title'] = $m->title;
        $menu[$m->ID]['url'] = $m->url;
        $menu[$m->ID]['type'] = $m->type;
        $menu[$m->ID]['classes'] = $m->classes;
        $menu[$m->ID]['children'] = array();
      } else {
        $submenu[$m->ID]['object_id'] = $m->object_id;
        $submenu[$m->ID]['object'] = $m->object;
        $submenu[$m->ID]['title'] = $m->title;
        $submenu[$m->ID]['url'] = $m->url;
        $submenu[$m->ID]['type'] = $m->type;
        $submenu[$m->ID]['classes'] = $m->classes;
        $menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
      }
    }
  }
  //var_dump($items);
  $menu = (object)$menu;

  return $menu;
}
add_filter('get_menu_items', 'get_menu_items', 10, 1);

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function add_custom_body_classes($classes)
{
  // Adds a class of hfeed to non-singular pages.
  if (!is_singular()) {
    $classes[] = 'hfeed';
  }

  // Adds a class of no-sidebar when there is no sidebar present.
  if (!is_active_sidebar('sidebar-1')) {
    $classes[] = 'no-sidebar';
  }

  return $classes;
}
add_filter('body_class', 'add_custom_body_classes');

/**
 * Add first and last CSS classes to dynamic sidebar widgets. 
 * Also adds numeric index class for each widget (widget-1, widget-2, etc.)
 */
function widget_first_last_classes($params)
{

  global $my_widget_num; // Global a counter array
  $this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
  $arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets	

  if (!$my_widget_num) { // If the counter array doesn't exist, create it
    $my_widget_num = array();
  }

  // Check if the current sidebar has no widgets (optional)
  /*if (!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) {
    return $params; // No widgets in this sidebar... bail early.
  }*/

  if (isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
    $my_widget_num[$this_id]++;
  } else { // If not, create it starting with 1
    $my_widget_num[$this_id] = 1;
  }

  $class = 'class="widget-' . $my_widget_num[$this_id] . ' '; // Add a widget number class for additional styling options

  if ($my_widget_num[$this_id] == 1 || $my_widget_num[$this_id] < count($arr_registered_widgets[$this_id])) { // If this is the first widget
    $class .= 'widget-first col-12 col-md-2 ';
  } elseif ($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
    $class .= 'widget-last col-12 col-md-6 ';
  }

  //$params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']); // Insert our new classes into "before widget"
  $params[0]['before_widget'] = preg_replace('/class=\"/', "$class", $params[0]['before_widget'], 1);

  return $params;
}
//add_filter('dynamic_sidebar_params', 'widget_first_last_classes');