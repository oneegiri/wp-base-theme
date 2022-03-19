<?php
declare(strict_types=1);

namespace Core;

/**
 * This class is responsible 
 * to apply filters.
 */
final class Filter
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
      self::$instance = new Filter();
    }

    return self::$instance;
  }

  /**
   * Define the filter to be
   * applied.
   * 
   * @param string $name
   * @param object $callback
   */
  public function define_filter(
    string $name,
    object $callback
  ) {
    $this->name = $name;
    $this->callback = $callback;
    return $this;
  }

  /**
   * Trigger the add_filter
   * method.
   */
  public function add()
  {
    add_filter($this->name, $this->callback);
  }
}
