<?php

/** Enqueue styles or scripts into the front-end
 * 
 * -Scripts
 * 
 * array(
 *    [
 *      'cdn' => true|false (optional),
 *      'alias' => string,
 *      'src' => string,
 *      'deps' => array, [default->array()]
 *      'in_footer' => true|false [default->true]
 *    ],
 * ) 
 * 
 * -Styles
 * 
 * array(
 *    [
 *      'cdn' => true|false (optional),
 *      'alias' => string,
 *      'src' => string,
 *      'deps' => array, [default->array()]
 *      
 *    ],
 * )
 *
 * @param string $type style|script
 * @param array $assets (see above)
 */
function enqueue_assets(string $type, array $assets)
{
  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  if ($type == 'style') {
    enqueue_custom_styles($assets);
  } else {
    enqueue_custom_scripts($assets);
  }
}

/** Register styles or scripts into the front-end
 * 
 * -Scripts
 * 
 * array(
 *    [
 *      'cdn' => true|false (optional),
 *      'alias' => string,
 *      'src' => string,
 *      'deps' => array, [default->array()]
 *      'in_footer' => true|false [default->true]
 *    ],
 * ) 
 * 
 * -Styles
 * 
 * array(
 *    [
 *      'cdn' => true|false (optional),
 *      'alias' => string,
 *      'src' => string,
 *      'deps' => array, [default->array()]
 *      
 *    ],
 * )
 *
 * @param string $type style|script
 * @param array $assets (see above)
 */
function register_assets(string $type, array $assets)
{
  if ($type == 'style') {
    register_custom_styles($assets);
  } else {
    register_custom_scripts($assets);
  }
}

/** Register styles or scripts in wp-admin
 * 
 * -Scripts
 * 
 * array(
 *    [
 *      'cdn' => true|false (optional),
 *      'alias' => string,
 *      'src' => string,
 *      'deps' => array, [default->array()]
 *      'in_footer' => true|false [default->true]
 *    ],
 * ) 
 * 
 * -Styles
 * 
 * array(
 *    [
 *      'cdn' => true|false (optional),
 *      'alias' => string,
 *      'src' => string,
 *      'deps' => array, [default->array()]
 *      
 *    ],
 * )
 *
 * @param string $type style|script
 * @param array $assets (see above)
 */
function enqueue_admin_assets(string $type, array $assets)
{
  if ($type == 'style') {
    enqueue_custom_styles($assets);
  } else {
    enqueue_custom_scripts($assets);
  }
}

/** Enqueue styles or scripts in wp-admin
 * 
 * -Scripts
 * 
 * array(
 *    [
 *      'cdn' => true|false (optional),
 *      'alias' => string,
 *      'src' => string,
 *      'deps' => array, [default->array()]
 *      'in_footer' => true|false [default->true]
 *    ],
 * ) 
 * 
 * -Styles
 * 
 * array(
 *    [
 *      'cdn' => true|false (optional),
 *      'alias' => string,
 *      'src' => string,
 *      'deps' => array, [default->array()]
 *      
 *    ],
 * )
 *
 * @param string $type style|script
 * @param array $assets (see above)
 */
function register_admin_assets(string $type, array $assets)
{
  if ($type == 'style') {
    register_custom_styles($assets);
  } else {
    register_custom_scripts($assets);
  }
}


/**
 * Functions to add custom assets recursively
 */

function register_custom_scripts($scripts)
{
  foreach ($scripts as $script) {
    if (!empty($script['cdn'])) {
      wp_register_script(
        $script['alias'],
        $script['src'],
        isset($script['deps']) ? $script['deps'] : array(),
        isset($script['in_footer']) ? $script['in_footer'] : true
      );
    } else {
      wp_register_script(
        $script['alias'],
        $script['src'],
        isset($script['deps']) ? $script['deps'] : array(),
        isset($script['in_footer']) ? $script['in_footer'] : true
      );
    }
  }
}

function enqueue_custom_scripts($scripts)
{
  foreach ($scripts as $script) {
    if (!empty($script['cdn'])) {
      wp_enqueue_script(
        $script['alias'],
        $script['src'],
        isset($script['deps']) ? $script['deps'] : array(),
        isset($script['in_footer']) ? $script['in_footer'] : true
      );
    } else {
      wp_enqueue_script(
        $script['alias'],
        $script['src'],
        isset($script['deps']) ? $script['deps'] : array(),
        isset($script['in_footer']) ? $script['in_footer'] : true
      );
    }
  }
}

function register_custom_styles($styles)
{
  foreach ($styles as $style) {
    if (!empty($style['cdn'])) {
      wp_register_style(
        $style['alias'],
        $style['src'],
        isset($style['deps']) ? $style['deps'] : array()
      );
    } else {
      wp_register_style(
        $style['alias'],
        $style['src'],
        isset($style['deps']) ? $style['deps'] : array()
      );
    }
  }
}

function enqueue_custom_styles($styles)
{
  foreach ($styles as $style) {
    if (!empty($style['cdn'])) {
      wp_enqueue_style(
        $style['alias'],
        $style['src'],
        isset($style['deps']) ? $style['deps'] : array()
      );
    } else {
      wp_enqueue_style(
        $style['alias'],
        $style['src'],
        isset($style['deps']) ? $style['deps'] : array()
      );
    }
  }
}
