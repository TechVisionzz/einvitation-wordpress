<?php

/**
 * Plugin Name:       einvitation
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the functionality on online invitation System.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            TechVionz
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Domain Path:       /languages/
 */


if (!defined('ABSPATH')) {
    die;
}
// load translation files for plugin
add_action('plugins_loaded', 'ei_loadplugin_translation');

function ei_loadplugin_translation()
{
    load_plugin_textdomain('einvitation', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
// admin section start
// add event post types and custom metaboxes
require_once dirname(__FILE__) . '/admin/ei-posttypes/event/eventposttype.php';
require_once dirname(__FILE__) . '/admin/ei-posttypes/event/textboxes.php';
// require_once dirname(__FILE__) . '/admin/ei-taxonomies/event/textboxes.php';
// add contact taxonomies 
require_once dirname(__FILE__) . '/admin/ei-taxonomies/contact/contact.php';
require_once dirname(__FILE__) . '/admin/ei-taxonomies/contact/customization.php';
require_once dirname(__FILE__) . '/admin/ei-taxonomies/contact/textboxes.php';
// add attendee taxonomies 
// require_once dirname(__FILE__) . '/admin/ei-taxonomies/attendee/attendee.php';
// require_once dirname(__FILE__) . '/admin/ei-taxonomies/attendee/customization.php';
// require_once dirname(__FILE__) . '/admin/ei-taxonomies/attendee/textboxes.php';
// admin section end



// public section start

// include event file 
require_once dirname(__FILE__) . '/public/event/event.php';
// require_once dirname(__FILE__) . '/public/contact/verify-email.php';
// require_once dirname(__FILE__) . '/public/contact/contact.php';
add_action('admin_menu', 'wpdocs_register_my_custom_submenu_page');
function wpdocs_register_my_custom_submenu_page()
{
    add_submenu_page(
        'edit.php?post_type=event',
        __('Event Attendee', 'textdomain'),
        __('Event Attendee', 'textdomain'),
        'manage_options',
        'event-attendee',
        'books_ref_page_callback'
    );
}
/**
 * Display callback for the submenu page.
 */
function books_ref_page_callback()
{
    require_once dirname(__FILE__) . '/admin/ei-custompages/attendee.php';
}
function ei_registerallshortcodes()
{
    add_shortcode('ei_events', 'ei_events');
}

add_action('init', 'ei_registerallshortcodes');
// public section end

// styles and js files
function ei_registerstyleandscript()
{
    // register all admin styles
    // wp_register_style('ei_eventstyle', plugins_url('/public/css/event/style.css', __FILE__));
    wp_enqueue_style('style', plugins_url('/admin/css/event/style.css', __FILE__), array(), null, 'all');
    // register all public styles
    wp_enqueue_style('style', plugins_url('/public/css/event/style.css', __FILE__), array(), null, 'all');
    wp_enqueue_style('style', plugins_url('/public/css/contact/style.css', __FILE__), array(), null, 'all');
    // register all scripts
    wp_register_script('ei_eventminifiedscript', plugins_url('/admin/js/event/jquery-3.3.1.js', __FILE__));
    wp_register_script('ei_privateeventscript', plugins_url('/admin/js/event/script.js', __FILE__), array('jquery'), NULL, false);
    wp_register_script('ei_publiceventscript', plugins_url('/public/js/event/script.js', __FILE__), array('jquery'), NULL, false);
    // enque all scripts
    wp_enqueue_script('ei_privateeventscript');
    wp_enqueue_script('ei_publiceventscript');
    wp_enqueue_script('ei_eventminifiedscript');
    // enque all styles
    // wp_enqueue_style('ei_eventstyle');
}

add_action('admin_init', 'ei_registerstyleandscript');