<?php

// remove default column from table
function wpse_80027_manage_columns($columns)
{
    // remove taxonomy column
    unset($columns['taxonomy-contacts']); // prepend taxonomy name with 'taxonomy-'

}
add_filter('manage_edit-Events_columns', 'wpse_80027_manage_columns');