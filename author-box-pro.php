<?php

/*
  Plugin Name: MeliBu WP Author Box Pro
  Plugin URI:  http://samet-tarim.de/
  Description: The utimative tool for Authors. Must have plugin for all powerfull blogs with Authors. This powerfull Author Box has more than a Pro plugin.
  Version:     1.0
  Author:      Samet Tarim
  Author URI:  http://samet-tarim.de/
  Text Domain: author-box-pro
  Domain Path: /languages/
  License:     GPLv2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html

  MeliBu WP Author Box Pro is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 2 of the License, or
  any later version.

  MeliBu WP Author Box Pro is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with MeliBu WP Author Box Pro. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

// No Script kiddies
if (!defined('ABSPATH')) {
    exit;
}

// Full Path
if (!defined('MB_AUTHOR_BOX_PATH')) {

    /**
     * plugin_dir_path() 
     * 
     * @since   2.8.0
     * @link    https://developer.wordpress.org/reference/functions/plugin_dir_path/
     */
    define('MB_AUTHOR_BOX_PATH', plugin_dir_path(__FILE__));
}

// Globals
global $MB_AUTHOR_BOX_BACKEND, $MB_AUTHOR_BOX_FRONTEND;

/**
 * WP - is_admin() 
 * 
 * @since   1.5.1
 * @link    https://codex.wordpress.org/Function_Reference/is_admin
 */
if (is_admin()) {

    // LOAD BACKEND ////////////////////////////////////////////////////////////////
    // Load Backend class
    require_once MB_AUTHOR_BOX_PATH . 'classes/class.MelibuBackend.php';
    require_once MB_AUTHOR_BOX_PATH . 'classes/class.MelibuMetaBox.php';

    /**
     * PHP - class_exists()
     * 
     * @since   4.x
     * @link    http://php.net/manual/de/function.class-exists.php
     */
    if (class_exists('MB_AUTHOR_BOX_BACKEND')) {

        // Instance Backend class
        $MB_AUTHOR_BOX_BACKEND = new MB_AUTHOR_BOX_BACKEND();

        /**
         * register_activation_hook()
         * 
         * @since   2.7.0
         * @link    https://codex.wordpress.org/Function_Reference/register_activation_hook
         */
        register_activation_hook(__FILE__, array('MB_AUTHOR_BOX_BACKEND', 'activate')); // Hier ist wichtig das es ein Array ist um die Klasse und die funktion zu übergeben 
        /**
         * register_deactivation_hook()
         * 
         * @since   2.7.0
         * @link    https://codex.wordpress.org/Function_Reference/register_deactivation_hook
         */
        register_deactivation_hook(__FILE__, array('MB_AUTHOR_BOX_BACKEND', 'deactivate'));
        /**
         * register_uninstall_hook()
         * 
         * @since   2.7.0
         * @link    https://codex.wordpress.org/Function_Reference/register_uninstall_hook
         */
        register_uninstall_hook(__FILE__, array('MB_AUTHOR_BOX_BACKEND', 'uninstall'));
    }

    // Add a link to the settings page onto the plugin page
    if (isset($MB_AUTHOR_BOX_BACKEND)) {

        // Add the settings link to the plugins page
        function melibu_plugin_settings_author_box_link($links) {

            $settings_link = '<a href="admin.php?page=melibu-plugin-author-admin-control-menu-1">' . __('Options', 'author-box-pro') . '</a>';
            array_unshift($links, $settings_link);
            return $links;
        }

        $plugin = plugin_basename(__FILE__);
        add_filter("plugin_action_links_$plugin", 'melibu_plugin_settings_author_box_link');
    }
}

// LOAD FRONTEND ///////////////////////////////////////////////////////////////
// Load Frontend class
require_once MB_AUTHOR_BOX_PATH . 'classes/class.MelibuFrontend.php';
require_once MB_AUTHOR_BOX_PATH . 'classes/class.MelibuOptions.php';
require_once MB_AUTHOR_BOX_PATH . 'classes/class.MelibuHelper.php';
require_once MB_AUTHOR_BOX_PATH . 'classes/class.MelibuAuthor.php';

/**
 * PHP - class_exists()
 * 
 * @since   4.x
 * @link    http://php.net/manual/de/function.class-exists.php
 */
if (class_exists('MB_AUTHOR_BOX_FRONTEND')) {

    // Instance Frontend class
    $MB_AUTHOR_BOX_FRONTEND = new MB_AUTHOR_BOX_FRONTEND();
}