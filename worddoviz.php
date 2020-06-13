<?php
/**
 * Plugin Name:       wordDoviz
 * Plugin URI:        https://gurmewoo.com/ucretsiz-eklentiler/wordpress-doviz-eklentisi
 * Description:       Wordpress için TCMBB yada Investing ten döviz bilgilerini gösteren widget ve shortcode eklentisi
 * Version:           0.1.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Gurmewoo
 * Author URI:        https://gurmewoo.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       worddoviz
 */ 
require_once('vendor/autoload.php');
require("includes/class-worddoviz.php");

$wordDoviz= new wordDoviz();

 