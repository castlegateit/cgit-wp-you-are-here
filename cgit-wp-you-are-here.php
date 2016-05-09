<?php

/*

Plugin Name: Castlegate IT WP You Are Here
Plugin URI: http://github.com/castlegateit/cgit-wp-you-are-here
Description: Easy environment-specific messages.
Version: 1.0
Author: Castlegate IT
Author URI: http://www.castlegateit.co.uk/
License: MIT

*/

use Cgit\YouAreHere;

require __DIR__ . '/src/autoload.php';

// Load plugin
add_action('init', function() {
    YouAreHere::getInstance();
});
