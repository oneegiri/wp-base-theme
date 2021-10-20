<?php

/** Register terms recursively
 * 
 * array(
 *    [
 *      'name' => string,
 *      'taxonomy' => string,
 *      'alias_of' => string [Not required],
 *      'description' => string [Not required],
 *      'parent' => string [Not required],
 *      'slug' => string,
 *    ],
 * ) 
 * @param array $terms (see above)
 */
function term_factory(array $terms = [])
{
  if (!empty($terms)) {
    foreach ($terms as $term) {
      if (!term_exists($term['name'], $term['taxonomy'])) {
        wp_insert_term(
          $term['name'],
          $term['taxonomy'],
          array(
            'alias_of' => isset($term['alias_of']) ? $term['alias_of'] : '',
            'description' => isset($term['description']) ? $term['description'] : '',
            'parent' => isset($term['parent']) ? $term['parent'] : '',
            'slug' => $term['slug']
          )
        );
      }
    }
  }
}
