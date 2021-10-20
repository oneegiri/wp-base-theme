<?php
/**
 * Setup theme constants
 */

define('TEXT_DOMAIN', 'base-theme');
define('THEME_PATH', get_stylesheet_directory());
define('THEME_URI', get_stylesheet_directory_uri());
define('SRC_ROOT', THEME_PATH . '/src');
define('CORE_ROOT', SRC_ROOT . '/core');
define('UTILS_ROOT', SRC_ROOT . '/utils');
define('COMPATIBILITY_ROOT', SRC_ROOT . '/compatibility');
define('PAGE_LOGIC_ROOT', SRC_ROOT . '/logic');
define('ASSETS_URI', THEME_URI . '/assets');
define('VIEWS_PATH', THEME_PATH . '/views');
define('DIST_ROOT', THEME_URI . '/dist');
define('WOO_PATH', THEME_PATH . '/woocommerce');

/**
 * Load all core modules
 */
$modules = [
	'theme-support',
	'actions',
	'filters',
	'post-types',
	'taxonomies',
	'ajax',
	'widgets',
	'assets',
	'acf',
	'admin',
];

for($i = 0; $i < count($modules); $i += 1){
	require_once CORE_ROOT . '/' . $modules[$i] . '.php';
}

/**
 * Load utility functions
 */

require_once UTILS_ROOT . '/custom-menu.php';