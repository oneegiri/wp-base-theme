<?php
declare(strict_types=1);

namespace Core;

/** Add custom shortcodes
 * 
 * Self closing shortcode snippet
 *      'name' => string,
 *      'callback' => function($atts){
 *          //Defaults
 *          $atts = shortcode_atts( array(
 *            'width' => def_value,
 *            'height' => def_value
 *          ), $atts, shortcode_name);
 *
 *          return "width = {$atts[width]}";
 *      }
 * 
 * Enclosing shortcode snippet
 *    'name' => string,
 *    'callback' => function($atts, $content = ''){
 *       return "content = {$content}";
 *    } 
 * 
 * Template driven shortcode snippet
 *    'name' => string,
 *    'callback => function($atts){
 *        ob_start();
 * 
 *        // include template with the arguments (The $args parameter was added in v5.5.0)
 *        get_template_part( 'template-parts/shortcode-template', null, $atts );
 *
 *        return ob_get_clean();
 *    }
 */
final class ShortCode
{
  private $name;
  private $callback;
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
      self::$instance = new ShortCode();
    }

    return self::$instance;
  }

  /**
   * Set the shortcode to be
   * added.
   * 
   * @param string $name
   * @param object $callback
   * ---
   * @return ShortCode
   */
  public function set_shortcode(string $name, object $callback)
  {
    $this->name = $name;
    $this->callback = $callback;
    return $this;
  }

  public function add()
  {
    add_shortcode($this->name, $this->callback);
  }
}
