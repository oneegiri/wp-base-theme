<?php

class Email
{

  public $to;
  public $subject;
  public $template;

  public function __construct()
  {
    $this->init();
  }

  public function init()
  {
    $filters = array(
      [
        'name' => 'wp_mail_content_type',
        'callback' => function ($ctype) {
          return 'text/html';
        }
      ],
      [
        'name' => 'wp_mail_charset',
        'callback' => function ($chset) {
          return 'UTF-8';
        }
      ],
      [
        'name' => 'wp_mail_from',
        'callback' => function () {
          return '';
        }
      ],
      [
        'name' => 'wp_mail_from_name',
        'callback' => function () {
          return '';
        }
      ]
      );

      foreach($filters as $filter){
        add_filter($filter['name'], $filter['callback']);
      }
  }

  /** Set the data before sending the actual email
   *
   * @param string $to The recipient of this email
   * @param string $subject Subject of this email
   * @param string $template The email template to use for this email,
   *                         located in ```templates/emails```, only filename
   *                         with no extension has to be specified.
   * @return EmailController Returns its parent class for method chaining
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

  /** Send the email to its recipient
   *
   *   ```$params``` will be available in the email template
   *   as ```$data```, It will be **NULL** if nothing has been passed down 
   *   or it will contain an **ARRAY** of data to use in the email.
   *
   * @param array $params A set of data to pass down and use
   *                      into the email template.
   *
   * @return Email Returns its parent class for method chaining
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

    return $this;
  }
}
