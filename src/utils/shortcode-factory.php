<?php
/** Add custom shortcodes recursively
 * 
 * Self closing shortcode snippet
 * array(
 *    [
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
 *    ],
 * ) 
 * 
 * Enclosing shortcode snippet
 * array(
 *  [
 *    'name' => string,
 *    'callback' => function($atts, $content = ''){
 *       return "content = {$content}";
 *    } 
 *  ],
 * )
 * 
 * Template driven shortcode snippet
 * array(
 *  [
 *    'name' => string,
 *    'callback => function($atts){
 *        ob_start();
 * 
 *        // include template with the arguments (The $args parameter was added in v5.5.0)
 *        get_template_part( 'template-parts/shortcode-template', null, $atts );
 *
 *        return ob_get_clean();
 *    }
 *  ],
 * )
 * @param array $shortcodes (see above)
 */
function add_shortcodes(array $shortcodes)
{
  foreach($shortcodes as $shortcode){
    add_shortcode($shortcode['name'], $shortcode['callback']);
  }
}