<?php
require_once UTILS_ROOT . '/woocommerce-custom-tabs.php';

add_filter('woocommerce_product_data_tabs', function ($tabs) {

  unset($tabs['advanced']);
  unset($tabs['shipping']);
  

  $custom_tabs = add_woocommerce_tabs(array(
    [
      'label' => 'Technical Information',
      'target' => 'technical_information',
      'class' => ['hide_if_external'],
    ],
  ));

  foreach ($custom_tabs as $tab) {
    $tabs[$tab['label']] = $tab;
  }
  return $tabs;
});

add_action('woocommerce_product_data_panels', function () {
  add_woocommerce_tab_content(array(
    [
      'layout' => '/admin/woocommerce-attribute-selector',
      'args' => array(
        'id' => 'technical_information'
      )
    ],
  ));
});

add_action('woocommerce_process_product_meta', function ($post_id) {
  $product = wc_get_product($post_id);

  if (isset($_POST['packaging_attributes'])) {
    $product->update_meta_data('packaging_attributes', recursive_sanitize_text_field($_POST['packaging_attributes']));
  } else {
    $product->update_meta_data('packaging_attributes', array());
  }
  if (isset($_POST['properties_attributes'])) {
    $product->update_meta_data('properties_attributes', recursive_sanitize_text_field($_POST['properties_attributes']));
  } else {
    $product->update_meta_data('properties_attributes', array());
  }
  if (isset($_POST['standard_properties_attributes'])) {
    $product->update_meta_data('standard_properties_attributes', recursive_sanitize_text_field($_POST['standard_properties_attributes']));
  } else {
    $product->update_meta_data('standard_properties_attributes', array());
  }
  if (isset($_POST['tech_functions_attributes'])) {
    $product->update_meta_data('tech_functions_attributes', recursive_sanitize_text_field($_POST['tech_functions_attributes']));
  } else {
    $product->update_meta_data('tech_functions_attributes', array());
  }

  $product->save();
});


function render_attributes(array $attribute_taxonomies = [], string $id, $savedTerms)
{
  if (!empty($attribute_taxonomies) && is_array($attribute_taxonomies)) {
    if (!empty($savedTerms)) {
      foreach ($attribute_taxonomies as $taxonomy) {
        $attribute_taxonomy_name = $taxonomy->attribute_name;
        $label = $taxonomy->attribute_label ? $taxonomy->attribute_label : $taxonomy->attribute_name;
        $disabled = array_key_exists($attribute_taxonomy_name, $savedTerms) ? 'disabled' : '';

        echo "<option data-parent='{$id}' value='pa_{$attribute_taxonomy_name}' {$disabled}>{$label}</option>";
      }
    } else {
      foreach ($attribute_taxonomies as $taxonomy) {
        $attribute_taxonomy_name = $taxonomy->attribute_name;
        $label = $taxonomy->attribute_label ? $taxonomy->attribute_label : $taxonomy->attribute_name;

        echo "<option data-parent='{$id}' value='pa_{$attribute_taxonomy_name}'>{$label}</option>";
      }
    }
  }
}
add_action('render_attributes', 'render_attributes', 10, 3);

function render_saved_terms($terms)
{
  if (!empty($terms) && is_array($terms)) {
    get_template_part('/template-parts/admin/woocommerce-display-saved-attributes', null, array('saved_terms' => $terms));
  }
}
add_action('render_saved_terms', 'render_saved_terms', 10, 1);

function custom_product_tabs($tabs)
{

  // 1) Removing tabs

  unset( $tabs['description'] );
  unset($tabs['reviews']);
  unset($tabs['additional_information']);

  //2) Adding new tabs

  //Custom description tab
  $tabs['custom_description'] = array(
    'title'     => __('Description', TEXT_DOMAIN),
    'priority'  => 100,
    'callback'  => 'render_description_tab'
  );

  //Resellers tab
  $tabs['resellers_tab'] = array(
    'title'     => __('Resellers', TEXT_DOMAIN),
    'priority'  => 110,
    'callback'  => 'render_resellers_tab'
  );

  //Technical information tab
  $tabs['tech_info_tab'] = array(
    'title'     => __('Technical information', TEXT_DOMAIN),
    'priority'  => 120,
    'callback'  => 'render_technical_information_tab'
  );

  //How to tab
  $tabs['how_to_tab'] = array(
    'title'     => __('How to', TEXT_DOMAIN),
    'priority'  => 130,
    'callback'  => 'render_how_to_tab'
  );

  //Related products tab
  $tabs['custom_related_products_tab'] = array(
    'title'     => __('Related products', TEXT_DOMAIN),
    'priority'  => 140,
    'callback'  => 'render_related_tab'
  );

  return $tabs;
}
add_filter('woocommerce_product_tabs', 'custom_product_tabs');

// Tabs rendering
function render_description_tab()
{
  get_template_part('/template-parts/single-product/tab-description');
}
function render_technical_information_tab()
{
  get_template_part('/template-parts/single-product/tab-technical-information');
}

function render_resellers_tab()
{
  echo '<h2>Description</h2>';
  echo '<p>Custom description tab.</p>';
}
function render_how_to_tab()
{
  get_template_part('/template-parts/single-product/tab-how-to');
}
function render_related_tab()
{
  get_template_part('/template-parts/single-product/tab-custom-related-products');
}