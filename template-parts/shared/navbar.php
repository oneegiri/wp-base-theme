<nav class="navbar navbar-expand-lg navbar-light bg-transparent fixed-top">
  <h2 class="sr-only"><?php _e('Main navigation', TEXT_DOMAIN); ?></h2>
  <div class="container justify-content-between align-items-center">
    <a class="navbar-brand" href="<?php echo esc_url(get_home_url()); ?>">
      <img class="logo" src="<?php echo esc_url(get_field('logo', 'option'));
                ?>" alt="<?php echo get_bloginfo('name', 'display'); ?>">
      <img class="logo-alt" src="<?php echo esc_url(get_field('logo_alt', 'option'));
                ?>" alt="<?php echo get_bloginfo('name', 'display'); ?>">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse ml-auto" id="main-menu">
      <div class="d-md-none mobile-header mb-5">
        <img src="<?php echo esc_url(get_field('logo_alt', 'option'));
                  ?>" alt="<?php echo get_bloginfo('name', 'display'); ?>">
        <button type="button" class="close" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <ul class="navbar-nav">
        <?php
        do_action('render_custom_menu', array(
          'menu_name' => 'main',
          'active_class' => 'active',
          'list_item_classes' => 'nav-item',
          'list_anchor_classes' => 'nav-link',
          'list_title_classes' => 'nav-title',
          'sublist_classes' => '',
          'sublist_item_classes' => '',
          'sublist_anchor_classes' => '',
          'sublist_title_classes' => '',
          'data_icon' => '',
        ));
        ?>
      </ul>
    </div>
  </div>
</nav>