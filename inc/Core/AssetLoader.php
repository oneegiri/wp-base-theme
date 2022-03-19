<?php
declare(strict_types=1);

namespace Core;

/**
 * This class is responbile
 * to register/enqueue styles or script.
 */
final class AssetLoader
{
  private $asset;
  private $type;
  private $action;
  private $location;
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
      self::$instance = new AssetLoader();
    }

    return self::$instance;
  }

  /**
   * Define the asset we want to load.
   * 
   * @param array $asset
   * @param string $type
   * @param string $location
   * @param string $action
   * ---
   * @return AssetsLoader
   */
  public function define_asset(
    array $asset,
    string $type,
    string $location,
    string $action = null
  ) {
    $this->asset = $asset;
    $this->type = $type;
    $this->location = $location;
    $this->action = $action;
    return $this;
  }

  /**
   * Register the provided asset
   */
  public function register()
  {
    switch ($this->type) {
      case "style":
        $this->load(
          $this->location,
          function () {
            wp_register_style(
              $this->asset['alias'],
              $this->asset['src'],
              isset($this->asset['deps']) ? $this->asset['deps'] : array()
            );
          },
          $this->action
        );
        break;
      case "script":
        $this->load(
          $this->location,
          function () {
            wp_register_script(
              $this->asset['alias'],
              $this->asset['src'],
              isset($this->asset['deps']) ? $this->asset['deps'] : array(),
              isset($this->asset['in_footer']) ? $this->asset['in_footer'] : true
            );
          },
          $athis->ction
        );
        break;
    }

    return $this;
  }

  /**
   * Enqueue the provided asset
   */
  public function enqueue()
  {
    switch ($this->type) {
      case "style":
        $this->load(
          $this->location,
          function () {
            wp_enqueue_style(
              $this->asset['alias'],
              $this->asset['src'],
              isset($this->asset['deps']) ? $this->asset['deps'] : array()
            );
          },
          $this->action
        );
        break;
      case "script":
        $this->load(
          $this->location,
          function () {
            wp_enqueue_script(
              $this->asset['alias'],
              $this->asset['src'],
              isset($this->asset['deps']) ? $this->asset['deps'] : array(),
              isset($this->asset['in_footer']) ? $this->asset['in_footer'] : true
            );
          },
          $this->action
        );
        break;
    }
  }

  /**
   * Triggers the add_action method
   * to add the style/script.
   * 
   * @param object $callback
   */
  private function load(object $callback)
  {
    if (!empty($this->action)) {
      switch ($this->location) {
        case "admin":
          add_action($this->action, $callback);
          break;
        case "user":
          add_action($this->action, $callback);
          break;
      }
    } else {
      switch ($this->location) {
        case "admin":
          add_action('admin_enqueue_scripts', $callback);
          break;
        case "user":
          add_action('wp_enqueue_scripts', $callback);
          break;
      }
    }
  }
}
