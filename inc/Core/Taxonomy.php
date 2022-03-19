<?php
declare(strict_types=1);

namespace Core;

/** Register taxonomies
 * 
 * array(
 *    [
 *      'plural_name' => string,
 *      'singular_name' => string,
 *      'slug' => string,
 *      'post_type' => string|array() [Not required for woocommerce taxonomies],
 *      'woocommerce_related' => bool
 *    ],
 * ) 
 */
final class Taxonomy
{
  private $slug;
  private $args;
  private $labels;
  private $post_type;
  private $woocommerce;
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
      self::$instance = new Taxonomy();
    }

    return self::$instance;
  }

  /**
   * Define the taxonomy to be
   * registered.
   * 
   * @param string $slug
   * @param array $lables
   * @param array $args
   * @param string $post_type
   * @param bool $woocommerce
   * ---
   * @return Taxonomy
   */
  public function define_taxonomy(
    string $slug,
    array $labels,
    array $args,
    string $post_type = "post",
    bool $woocommerce = false
  ) {
    $this->slug = $slug;
    $this->woocommerce = $woocommerce;
    $this->post_type = $post_type;

    $this->$labels = array(
      'name'                       => _x($labels['plural_name'], 'Taxonomy General Name', TEXT_DOMAIN),
      'singular_name'              => _x($labels['singular_name'], 'Taxonomy Singular Name', TEXT_DOMAIN),
      'all_items'                  => __("All {$labels['plural_name']}", TEXT_DOMAIN),
      'parent_item'                => __("Parent {$labels['singular_name']}", TEXT_DOMAIN),
      'parent_item_colon'          => __("Parent {$labels['singular_name']}:", TEXT_DOMAIN),
      'new_item_name'              => __("New {$labels['singular_name']}", TEXT_DOMAIN),
      'add_new_item'               => __("Add New {$labels['singular_name']}", TEXT_DOMAIN),
      'edit_item'                  => __("Edit {$labels['singular_name']}", TEXT_DOMAIN),
      'update_item'                => __("Update {$labels['singular_name']}", TEXT_DOMAIN),
      'view_item'                  => __("View {$labels['singular_name']}", TEXT_DOMAIN),
      'separate_items_with_commas' => __('Separate items with commas', TEXT_DOMAIN),
      'add_or_remove_items'        => __('Add or remove items', TEXT_DOMAIN),
      'choose_from_most_used'      => __('Choose from the most used', TEXT_DOMAIN),
      'popular_items'              => __("Popular {$labels['plural_name']}", TEXT_DOMAIN),
      'search_items'               => __("Search {$labels['plural_name']}", TEXT_DOMAIN),
      'not_found'                  => __('Not Found', TEXT_DOMAIN),
      'no_terms'                   => __("No {$labels['plural_name']}", TEXT_DOMAIN),
      'items_list'                 => __('Items list', TEXT_DOMAIN),
      'items_list_navigation'      => __('Items list navigation', TEXT_DOMAIN)
    );

    $this->$args = array(
      'labels'                     => $this->labels,
      'hierarchical'               => $args['hierarchical'] || true,
      'public'                     => $args['public'] || true,
      'show_ui'                    => $args['show_ui'] || true,
      'show_admin_column'          => $args['show_admin_column'] || true,
      'show_in_nav_menus'          => $args['show_in_nav_menus'] || true,
      'show_tagcloud'              => $args['show_tagcloud'] || true,
      'show_in_rest'               => $args['show_in_rest'] || false,
    );

    $this->register($slug, $this->labels, $this->args);

    return $this;
  }

  /**
   * Trigger the register_taxonomy and register_taxonomy_for_object_type
   * method, if the taxonomy is for woocommerce.
   * 
   * Triggers the register_taxonomy method,
   * if the taxonomy is for our theme.
   */
  public function register()
  {
    if ($this->woocommerce) {
      register_taxonomy($this->slug, 'product', $this->args);
      register_taxonomy_for_object_type($this->slug, 'product');
    } else {
      register_taxonomy($this->slug, $this->post_type, $this->args);
    }
  }
}
