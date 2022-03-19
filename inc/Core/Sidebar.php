<?php
declare(strict_types=1);

namespace Core;

/**
 * This class is responsible
 * to register sidebars.
 */
final class Sidebar
{
  private $args;
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
      self::$instance = new Sidebar();
    }

    return self::$instance;
  }

  /**
   * Define the sidebar to
   * be registered.
   * 
   * @param array $args
   * ---
   * @return Sidebar
   */
  public function define_sidebar(array $args)
  {
    $this->args = array(
      'name'          => esc_html__($args['name'], TEXT_DOMAIN),
      'id'            => $args['id'],
      'description'   => esc_html__($args['description'], TEXT_DOMAIN),
      'before_widget' => $args['before_widget'] || '<aside id="%1$s" class="widget--%2$s">',
      'after_widget'  => $args['after_widget'] || '</aside>',
      'before_title'  => $args['before_title'] || '<h2 class="widget-title">',
      'after_title'   => $args['after_title'] || '</h2>',
    );
    return $this;
  }

  /**
   * Trigger the register_sidebar
   * method.
   */
  public function register()
  {
    register_sidebar(
      $this->args
    );
  }
}
