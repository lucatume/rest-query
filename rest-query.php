<?php
/*
Plugin Name: Rest Query
Plugin URI: https://github.com/lucatume/rest-query
Description: REST API powered queries.
Version: 1.0
Author: Luca
Author URI: http://theaveragedev.com 
License: GPL2
*/

include 'vendor/autoload_52.php';

/** @var tad_DI52_Container $container */
$container = include 'bootstrap.php';

include_once 'src/restquery/functions.php';

add_action( 'plugins_loaded', array( $container, 'boot' ) );

