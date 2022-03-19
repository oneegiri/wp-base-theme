<?php
/**
 * How to use it
 * do_action('render_custom_menu', [
 *     'menu_name' => 'main-menu',
 *     'active_class' => '',
 *     'list_item_classes' => 'list__item',
 *     'list_anchor_classes' => 'list__link',
 *     'list_title_classes' => 'list__title',
 *     'sublist_classes' => 'list',
 *     'sublist_item_classes' => 'list__item',
 *     'sublist_anchor_classes' => 'list__link',
 *     'sublist_title_classes' => 'list__title',
 *     'data_icon' => '',
 * ]);
 */
function render_custom_menu($params)
{
  /*$check = is_home() || is_front_page() ? $params['active_class'] : '';
  $homeItem = '
  <li class="'.$check.' '.$params['list_item_classes'].'">
    <a href="'.get_home_url().'" class="'.$params['list_anchor_classes'].'">
      <!--<h3 class="'.$params['list_title_classes'].'">Home</h3>-->
      Home
    </a>
  </li>
  ';
  echo $homeItem;*/

  $items = apply_filters('get_menu_items', $params['menu_name']);

  //var_dump($items);

  $id_element = get_queried_object_id();

  $list_term = array();

  if (is_single()) {
    $term_element = wp_get_post_terms($id_element, 'category');
    $list_term = wp_list_pluck($term_element, 'term_id');
  }

  if (is_category()) {
    $term_selected = get_term($id_element, 'category');
    $list_term[] = $term_selected->parent;
  }

  $objectQueried = get_queried_object();

  global $gPostTypeArchive;

  foreach ($items as $menu_item) {
    $listBlock = '';
    $menu_item = (object)$menu_item;
    $link_pattern = '<a href="{link}" class="list__link">';

    if (!empty($menu_item->children)) {
      $link_pattern = '<a class="' . $params['sublist_anchor_classes'] . '" data-icon="' . $params['data_icon'] . '">';
    }
    //Primary menu
    switch ($menu_item->type) {
      case 'taxonomy':
        $info_term = get_term($menu_item->object_id, $menu_item->object);
        $isCurrent = $menu_item->object_id == get_queried_object_id() || in_array($menu_item->object_id, $list_term) ? $params['active_class'] : '';
        $hasChildren = $menu_item->children ? 'dropdown' : '';
        $listBlock .= '
              <li class="' . $isCurrent . ' ' . $params['list_item_classes'] . ' ' . $hasChildren . '">
              <a class="' . $params['list_anchor_classes'] . '" href="' . $menu_item->url . '">
                  <h6 class="' . $params['list_title_classes'] . '">' . $info_term->name . '</h6>
              </a>
            ';
        echo $listBlock;
        break;
      case 'post_type_archive':
        //$info_term = get_term($menu_item->object_id,$menu_item->object);
        $isCurrent = $objectQueried->name == $menu_item->object ||  $gPostTypeArchive ==  $menu_item->object ? $params['active_class'] : '';
        $hasChildren = $menu_item->children ? 'dropdown' : '';
        $listBlock .= '
            <li class="' . $isCurrent . ' ' . $params['list_item_classes'] . ' ' . $hasChildren . '">
            <a class="' . $params['list_anchor_classes'] . '" href="' . $menu_item->url . '">
              <h6 class="' . $params['list_title_classes'] . '">' . $menu_item->title . '</h6>
            </a>
          ';
        echo $listBlock;
        break;
      default:
        $info_post = get_post($menu_item->object_id);
        $isCurrent = $menu_item->object_id == get_queried_object_id() || strcmp($menu_item->url, get_home_url(null, '/')) == 0 && (is_home() || is_front_page())  ? $params['active_class'] : '';
        $hasChildren = $menu_item->children ? 'dropdown' : '';
        $is_cart = strtolower($menu_item->title) == 'cart' ? true : false;
        $cart_icon = '';
        $cart_attr = '';
        if($is_cart){
          $cart_icon = 'data-icon="basket"';
          $cart_attr = 'data-cart="true"';
        }
        $listBlock .= '
          <li class="' . $isCurrent . ' ' . $params['list_item_classes'] . ' ' . $hasChildren . '">
            <a ' . $cart_attr . ' class="' . $params['list_anchor_classes'] . '" href="' . $menu_item->url . '">
              <h6 ' . $cart_icon . ' class="' . $params['list_title_classes'] . '">' . $menu_item->title . '</h6>
            </a>
          ';
        echo $listBlock;
        break;
    }
    //Submenu
    if (!empty($menu_item->children)) {
      $subListBlock = '';
      $childrenBlock = '';
      foreach ($menu_item->children as $menu_item_child) {
        $menu_item_child = (object)$menu_item_child;
        switch ($menu_item_child->type) {
          case 'taxonomy':
            $info_term = get_term($menu_item_child->object_id, $menu_item_child->object);
            $isCurrent = $menu_item_child->object_id == get_queried_object_id() || in_array($menu_item_child->object_id, $list_term) ? $params['active_class'] : '';
            $childrenBlock .= '
                    <li class="' . $isCurrent . ' ' . $params['sublist_item_classes'] . '">
                      <a href="' . $menu_item_child->url . '" class="' . $params['sublist_anchor_classes'] . '">
                          <h6 class="' . $params['sublist_title_classes'] . '">' . $info_term->name . '</h6>
                      </a>
                    </li>
                  ';
            break;
          default:
            $info_post = get_post($menu_item_child->object_id);
            $isCurrent = $menu_item_child->object_id == get_queried_object_id()  ? $params['active_class'] : '';
            $childrenBlock .= '
                  <li class="' . $isCurrent . ' ' . $params['sublist_item_classes'] . '">
                    <a href="' . $menu_item_child->url . '" class="' . $params['sublist_anchor_classes'] . '">
                        <h6 class="' . $params['sublist_title_classes'] . '">' . $info_post->post_title . '</h6>
                    </a>
                  </li>
                ';
            break;
        }
      }
      $subListBlock .= '
        <ul class="' . $params['sublist_classes'] . '">' . $childrenBlock . '</ul>
        ';
      echo $subListBlock;
    }
  }
}
add_action('render_custom_menu', 'render_custom_menu', 10, 1);