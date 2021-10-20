<?php
function multilingualpress_get_translations()
{
  $args = \Inpsyde\MultilingualPress\Framework\Api\TranslationSearchArgs::forContext(new \Inpsyde\MultilingualPress\Framework\WordpressContext())
    ->forSiteId(get_current_blog_id())
    ->includeBase();

  $translations = \Inpsyde\MultilingualPress\resolve(
    \Inpsyde\MultilingualPress\Framework\Api\Translations::class
  )->searchTranslations($args);

  return $translations;
}

function generate_language_switcher()
{
  $translations = array_reverse(multilingualpress_get_translations());

  $output = '';
  $items = '';
  $current_lang = '';
  $i = 0;
  foreach ($translations as $translation) {
    $language = $translation->language();
    $iso_name = $language->isoName(); //Full country name
    $url = $translation->remoteUrl();
    $language_locale = $language->locale(); // en_GB, en_US etc.
    $language_code = substr($language_locale, strpos($language_locale, "_") + 1);

    if ($url) {
      $is_current = $i == 0 ? 'current' : '';

      if ($language_code == 'US' || $language_code == 'GB') {
        $language_code = 'EN';
      }

      if ($i == 0) {
        if ($language_code == 'US' || $language_code == 'GB') {
          $current_lang = 'EN';
        } else {
          $current_lang = $language_code;
        }
      }

      $items .= "<li class='switcher__item {$is_current}' data-language='" . $language_locale . "'>";
      $items .= "<a class='switcher__link' href='${url}'>";
      $items .= "<img src='" . get_stylesheet_directory_uri() . '/images/flags/' . $language_locale . ".svg'>";
      $items .= "<span>{$language_code}</span>";
      $items .= "</a>";
      $items .= "</li>";
    }

    $i += 1;
  }

  if ($items) {
    $output .= '<div class="switcher__wrap">';
    $output .= "<span class='switcher__current'>{$current_lang}</span>";
    $output .= '<ul class="switcher">';
    $output .= $items;
    $output .= '</ul>';
    $output .= '</div>';
  }

  echo $output;
}
add_action('render_language_switcher', 'generate_language_switcher', 10);
