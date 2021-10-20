<?php
if(class_exists('ACF')){
  define( 'ACF_LITE' , false );
  acf_add_options_page();
}