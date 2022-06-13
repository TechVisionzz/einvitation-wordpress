<?php

/**
 * Register a custom post type called "Event".
 *
 * @see get_post_type_labels() for label keys.
 */
function ei_register_event_custom_post_type()
{
    $labels = array(
        'name'                  => __('Events', 'einvitation'),
        'singular_name'         => _x('Event', 'Post type singular name', 'einvitation'),
        'menu_name'             => __('einvitation', 'einvitation'),
        'name_admin_bar'        => _x('Event', 'Add New on Toolbar', 'einvitation'),
        'add_new'               => __('Add New', 'einvitation'),
        'add_new_item'          => __('Add New Event', 'einvitation'),
        'new_item'              => __('New Event', 'einvitation'),
        'edit_item'             => __('Edit Event', 'einvitation'),
        'view_item'             => __('View Event', 'einvitation'),
        'all_items'             => __('All Events', 'einvitation'),
        'search_items'          => __('Search Events', 'einvitation'),
        'parent_item_colon'     => __('Parent Events', 'einvitation'),
        'not_found'             => __('No Events found', 'einvitation'),
        'not_found_in_trash'    => __('No Events found in Trash', 'einvitation'),
        'featured_image'        => _x('Event Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'einvitation'),
        'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'einvitation'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'einvitation'),
        'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'einvitation'),
        'archives'              => _x('Event archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'einvitation'),
        'insert_into_item'      => _x('Insert into Event', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'einvitation'),
        'uploaded_to_this_item' => _x('Uploaded to this Event', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'einvitation'),
        'filter_items_list'     => _x('Filter Events list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'einvitation'),
        'items_list_navigation' => _x('Events list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'einvitation'),
        'items_list'            => _x('Events list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'einvitation'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'Event'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title'),
    );

    register_post_type('Event', $args);
}

add_action('init', 'ei_register_event_custom_post_type');