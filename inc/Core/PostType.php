<?php
declare(strict_types=1);

namespace Core;

/**
 * This class is responsible
 * to register custom post types
 */
final class PostType
{
  private $slug;
  private $args;
  private $labels;
  private $rewrite;
  private static $instance = null;

  /**
   * Singleton's constructor should not be public. However, it can't be
   * private either if we want to allow subclassing.
   */
  protected function __construct()
  {
  }

  /**
   * Cloning and unserialization are not permitted for singletons.
   */
  protected function __clone()
  {
    throw new Exception('Feature disabled.');
  }

  public function __wakeup()
  {
    throw new Exception('Feature disabled.');
  }

  /**
   * Create an istance of the class
   * if not already created, or return
   * the existing istance.
   */
  public static function init()
  {
    if (self::$instance == null) {
      self::$instance = new PostType();
    }

    return self::$instance;
  }

  /**
   * It will define the custom
   * post type to be registered.
   * 
   * @param string $slug
   * @param array $labels
   * @param array $args
   * ---
   * @return PostType
   */
  public function define_post_type(string $slug, array $labels, array $args)
  {
    $this->slug = $slug;
    $this->$labels = array(
      'name'                  => _x($labels['plural_name'], 'Post Type General Name', TEXT_DOMAIN),
      'singular_name'         => _x($labels['singular_name'], 'Post Type Singular Name', TEXT_DOMAIN),
      'menu_name'             => __($labels['plural_name'], TEXT_DOMAIN),
      'name_admin_bar'        => __($labels['plural_name'], TEXT_DOMAIN),
      'archives'              => __('Item Archives', TEXT_DOMAIN),
      'parent_item_colon'     => __('Parent Item:', TEXT_DOMAIN),
      'all_items'             => __("All {$labels['plural_name']}", TEXT_DOMAIN),
      'add_new_item'          => __('Add New Item', TEXT_DOMAIN),
      'add_new'               => __("Add {$labels['singular_name']}", TEXT_DOMAIN),
      'new_item'              => __("New {$labels['singular_name']}", TEXT_DOMAIN),
      'edit_item'             => __("Edit {$labels['singular_name']}", TEXT_DOMAIN),
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

    isset($args['rewrite']) ? $this->rewrite = $args['rewrite'] : $this->rewrite = null;

    $this->$args = array(
      'label'                 => __($this->labels['singular_name'], TEXT_DOMAIN),
      'description'           => __($args['description'], TEXT_DOMAIN) || "",
      'labels'                => $this->labels,
      'supports'              => $args['supports'] || array('title', 'editor', 'author', 'thumbnail'),
      'taxonomies'            => $args['taxonomies'] || [],
      'hierarchical'          => $args['hierarchical'] || false,
      'public'                => $args['public'] || true,
      'show_ui'               => $args['show_ui'] || true,
      'show_in_menu'          => $args['show_in_menu'] || true,
      'menu_position'         => $args['menu_position'] || 7,
      'menu_icon'             => $args['dash_icon'] || "dashicons-admin-generic",
      'show_in_admin_bar'     => $args['show_in_admin_bar'] || true,
      'show_in_nav_menus'     => $args['show_in_nav_menus'] || true,
      'can_export'            => $args['can_export'] || true,
      'has_archive'           => $args['has_archive'] || true,
      'exclude_from_search'   => $args['exclude_from_search'] || false,
      'publicly_queryable'    => $args['publicly_queryable'] || true,
      'capability_type'       => $args['capability_type'] || 'post',
    );

    if (!empty($this->rewrite)) {
      $this->args['rewrite'] = $this->rewrite;
    }

    $this->register();

    return $this;
  }

  /**
   * Trigger the
   * register_post_type method.
   */
  public function register()
  {
    register_post_type($this->slug, $this->args);
  }
}
