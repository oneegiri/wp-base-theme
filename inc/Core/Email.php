<?php
declare(strict_types=1);

namespace Core;

final class Email
{

  public $to;
  public $subject;
  public $template;
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
      self::$instance = new Email();
    }

    return self::$instance;
  }

  /** 
   * Set the data before sending the actual email
   * 
   * The email template to use for the email,
   * has to be located in ```templates/emails```. 
   * 
   * Only the filename with no extension has to be specified.
   *
   * @param string $to
   * @param string $subject
   * @param string $template
   * ---
   * @return Email
   */
  public function set_email_data(
    string $to,
    string $subject,
    string $template
  ) {
    $this->to = $to;
    $this->subject = $subject;
    $this->template = $template;
    return $this;
  }

  /** 
   * Send the email to its recipient
   *
   * ```$params``` will be available in the email template,
   * as ```$data```. It will be **NULL** if nothing has been passed down,
   * or it will contain an **ARRAY** of data to use in the email.
   *
   * @param array $params 
   */
  public function send(array $params)
  {
    $data = !empty($params) ? $params : null;

    ob_start();
    include(VIEWS_PATH . "/emails/{$this->template}.php");
    $email_content = ob_get_contents();
    ob_end_clean();

    wp_mail(
      $this->to,
      $this->subject,
      $email_content
    );
  }
}
