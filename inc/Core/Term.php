<?php
declare(strict_types=1);

namespace Core;

/**
 * This class is responsible to
 * register custom terms
 */
final class Term{
  private $name;
  private $slug;
  private $taxonomy;
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
   * if not already created or return
   * the existing istance
   */
  public static function init()
  {
    if (self::$instance == null) {
      self::$instance = new Term();
    }

    return self::$instance;
  }

  /**
   * Define the term to register
   * @param string $name
   * @param string $slug
   * @param string $taxonomy
   * @param array $args
   * ---
   * @return Term
   */
  public function define_term(
    string $name, 
    string $slug, 
    string $taxonomy, 
    array $args
  )
  {
    $this->name = $name;
    $this->slug = $slug;
    $this->taxonomy = $taxonomy;
    $this->args = array(
      'alias_of' => $args['alias_of'] || '',
      'description' => $args['description'] || '',
      'parent' => $args['parent'] || '',
      'slug' => $this->slug
    );
    return $this;
  }

  /**
   * Trigger wp_insert_term if the
   * term is not already registered.
   */
  public function insert()
  {
    if (!term_exists($this->name, $this->taxonomy)) {
      wp_insert_term(
        $this->name,
        $this->taxonomy,
        $this->args
      );
    }
  }
}
