<?php

/*

Plugin Name: Castlegate IT WP You Are Here
Plugin URI: http://github.com/castlegateit/cgit-wp-you-are-here
Description: Easy environment-specific messages.
Version: 1.1
Author: Castlegate IT
Author URI: http://www.castlegateit.co.uk/
License: MIT

*/

if (!defined('ABSPATH')) {
    wp_die('Access denied');
}

require_once __DIR__ . '/classes/autoload.php';

$plugin = new \Cgit\YouAreHere\Plugin();

do_action('cgit_you_are_here_loaded');
