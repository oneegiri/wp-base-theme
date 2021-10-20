<?php
/** Register post types recursively
 * 
 * array(
 *    [
 *      'plural_name' => string,
 *      'singular_name' => string,
 *      'description' => string,
 *      'taxonomies' => array, [default->array()]
 *      'dash-icon' => string,
 *      'slug' => string,
 *    ],
 * ) 
 * @param array $post_types (see above)
 */
function post_type_factory(array $post_types = [])
{

  if (!empty($post_types)) {

    foreach ($post_types as $post_type) {
      $labels = array(
        'name'                  => _x($post_type['plural_name'], 'Post Type General Name', TEXT_DOMAIN),
        'singular_name'         => _x($post_type['singular_name'], 'Post Type Singular Name', TEXT_DOMAIN),
        'menu_name'             => __($post_type['plural_name'], TEXT_DOMAIN),
        'name_admin_bar'        => __($post_type['plural_name'], TEXT_DOMAIN),
        'archives'              => __('Item Archives', TEXT_DOMAIN),
        'parent_item_colon'     => __('Parent Item:', TEXT_DOMAIN),
        'all_items'             => __("All {$post_type['plural_name']}", TEXT_DOMAIN),
        'add_new_item'          => __('Add New Item', TEXT_DOMAIN),
        'add_new'               => __("Add {$post_type['singular_name']}", TEXT_DOMAIN),
        'new_item'              => __("New {$post_type['singular_name']}", TEXT_DOMAIN),
        'edit_item'             => __("Edit {$post_type['singular_name']}", TEXT_DOMAIN),
        'update_item'           => __('Update Item', TEXT_DOMAIN),
        'view_item'             => __('View Item', TEXT_DOMAIN),
        'search_items'          => __('Search Item', TEXT_DOMAIN),
        'not_found'             => __('Not found', TEXT_DOMAIN),
        'not_found_in_trash'    => __('Not found in Trash', TEXT_DOMAIN),
        'featured_image'        => __('Featured Image', TEXT_DOMAIN),
        'set_featured_image'    => __('Set featured image', TEXT_DOMAIN),
        'remove_featured_image' => __('Remove featured image', TEXT_DOMAIN),
        'use_featured_image'    => __('Use as featured image', TEXT_DOMAIN),
        'insert_into_item'      => __('Insert into item', TEXT_DOMAIN),
        'uploaded_to_this_item' => __('Uploaded to this item', TEXT_DOMAIN),
        'items_list'            => __('Items list', TEXT_DOMAIN),
        'items_list_navigation' => __('Items list navigation', TEXT_DOMAIN),
        'filter_items_list'     => __('Filter items list', TEXT_DOMAIN)
      );
      //$rewrite = array('slug' => 'event/%%');
      $args = array(
        'label'                 => __($post_type['singular_name'], TEXT_DOMAIN),
        'description'           => __($post_type['description'], TEXT_DOMAIN),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'author', 'thumbnail'),
        'taxonomies'            => $post_type['taxonomies'],
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 7,
        'menu_icon'             => $post_type['dash_icon'],
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        //'rewrite'               => $rewrite
      );
      register_post_type($post_type['slug'], $args);
    }
  }
}
