<?php
function ei_register_taxonomy_contact()
{
    $labels = array(
        'name' => __('contacts', 'einvitation'),
        'singular_name' => _x('contact', 'taxonomy singular name'),
        'search_items' => __('Search contacts'),
        'all_items' => __('All contacts'),
        'parent_item' => __('Parent contact'),
        'parent_item_colon' => __('Parent contact'),
        'edit_item' => __('Edit contact'),
        'update_item' => __('Update contact'),
        'add_new_item' => __('Add New contact', 'einvitation'),
        'new_item_name' => __('New contact Name'),
        'menu_name' => __('contact'),
    );
    $args = array(
        'hierarchical' => false, // make it hierarchical (like categories)
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'contact'],
    );
    register_taxonomy('contact', ['event'], $args);
}
add_action('init', 'ei_register_taxonomy_contact');