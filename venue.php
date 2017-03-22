<?php
/*
Plugin Name: ICOET Venue and Hotels
GitHub Plugin URI: https://github.com/dcremins/venue
GitHub Branch: master
Description: Venue and Hotels page and widget for ICOET website use
Version: 0.0.2
Author: Devin Cremins
Author URI: http://octopusoddments.com
*/

// Add all files in lib folder into array
$include = [
  '/lib/add-acf.php',           // Add Advanced Custom Fields
  '/lib/add-template.php',      // Venue and Hotels Page Template
  '/lib/venue-options.php',     // Venue and Hotels Options Page
  '/lib/venue-widget.php',      // Venue and Hotels Widget
];

// Require Once each file in the array
foreach ($include as $file) {
    if (!$filepath = (dirname(__FILE__) .$file)) {
        trigger_error(sprintf('Error locating %s for inclusion', $file), E_USER_ERROR);
    }
    require_once $filepath;
}
unset($file, $filepath);

add_action('wp_enqueue_scripts', function () {
     wp_enqueue_script('google-map', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyD2XX1_cJpF4bIxqdJssq9Ekb-w3hGIN5U', array(), '3', true);
     wp_enqueue_script('google-map-init', plugins_url('/js/map-helper.js', __FILE__), array('google-map', 'jquery'), '0.1', true);
     wp_enqueue_style('venue_css', plugins_url('/styles/main.css', __FILE__));
});

add_action('acf/init', function () {
    acf_update_setting('google_api_key', 'AIzaSyD2XX1_cJpF4bIxqdJssq9Ekb-w3hGIN5U');
});
