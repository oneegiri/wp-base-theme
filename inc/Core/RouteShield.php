<?php

declare(strict_types=1);

namespace Core;

final class TemplateShield
{
  private $routes;
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
      self::$instance = new TemplateShield();
    }

    return self::$instance;
  }

  /**
   * Define the templates to be
   * checked before rendering, in order to
   * block any user from accessing them,
   * if certain rules are not met.
   */
  public function define_routes(array $routes)
  {
    $this->routes = $routes;
  }

  private function get_user()
  {
    $user = wp_get_current_user();
    
    return $user;
  }

  private function shield()
  {
    foreach($this->routes as $route){
      switch($route["guard"]){
        case "auth:admin": //Only a logged in user with admin role can access
          if(!is_logged_in()){
            wp_redirect( home_url( '/signup/' ) );
            exit();
          }
          break;
        case "auth:user": //Only a logged in user can access
          break;
        
      }
    }
  }
}
