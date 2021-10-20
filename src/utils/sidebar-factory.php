<?php
/** Register ridebars recursively
 * 
 * array(
 *    [
 *      'name' => string,
 *      'id' => string,
 *      'description' => string,
 *      'before_widget' => string,
 *      'after_widget' => string,
 *      'before_title' => string,
 *      'after_title' => string,
 *    ],
 * ) 
 * @param array $sidebars (see above)
 */
function sidebar_factory(array $sidebars = [])
{
  if (!empty($sidebars)) {
    foreach($sidebars as $sidebar){
      register_sidebar(
        array(
          'name'          => esc_html__($sidebar['name'], TEXT_DOMAIN),
          'id'            => $sidebar['id'],
          'description'   => esc_html__($sidebar['description'], TEXT_DOMAIN),
          'before_widget' => isset($sidebar['before_widget']) ? $sidebar['before_widget'] : '<section id="%1$s" class="widget--%2$s">',
          'after_widget'  => isset($sidebar['after_widget']) ? $sidebar['after_widget'] : '</section>',
          'before_title'  => isset($sidebar['before_title']) ? $sidebar['before_title'] : '<h2 class="widget-title">',
          'after_title'   => isset($sidebar['after_title']) ? $sidebar['after_title'] : '</h2>',
        )
      );
    }
  }
}
