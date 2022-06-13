<?php
function ei_register_taxonomy_attendee()
{
    $labels = array(
        'name' => __('attendees', 'einvitation'),
        'singular_name' => _x('attendee', 'taxonomy singular name'),
        'search_items' => __('Search attendees'),
        'all_items' => __('All attendees'),
        'parent_item' => __('Parent attendee'),
        'parent_item_colon' => __('Parent attendee'),
        'edit_item' => __('Edit attendee'),
        'update_item' => __('Update attendee'),
        'add_new_item' => __('Add New attendee', 'einvitation'),
        'new_item_name' => __('New attendee Name'),
        'menu_name' => __('attendee'),
    );
    $args = array(
        'hierarchical' => false, // make it hierarchical (like categories)
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'attendee'],
    );
    register_taxonomy('attendee', ['event'], $args);
}
add_action('init', 'ei_register_taxonomy_attendee');