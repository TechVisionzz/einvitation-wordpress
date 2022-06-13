<?php

// remove default column from table
add_filter('manage_edit-attendee_columns', function ($columns) {
    if (isset($columns['description']))
        unset($columns['description']);
    if (isset($columns['slug']))
        unset($columns['slug']);
    if (isset($columns['posts']))
        unset($columns['posts']);
    return $columns;
});
// add custom colums in table
global  $ei_email;
global  $ei_contactnumber;
function add_attendee_columns($columns)
{
    $ei_email = __("Email", "einvitation");
    $ei_contactnumber = __("Contact Number", "einvitation");
    $columns['ei_contactemail'] = $ei_email;
    $columns['ei_contactnumber'] = $ei_contactnumber;
    return $columns;
}
add_filter('manage_edit-attendee_columns', 'add_attendee_columns');

// function add_contacts_column_content($content, $column_name, $term_id)
// {
//     $term_vals = get_term_meta($term_id);
//     switch ($column_name) {
//         case 'ei_contactemail':
//             foreach ($term_vals as $key => $val) {
//                 if ($key == "ei_contactemail") {
//                     $content = $val[0];
//                 }
//             }
//             break;
//         case 'ei_contactnumber':
//             foreach ($term_vals as $key => $val) {
//                 if ($key == "ei_contactnumber") {
//                     $content = $val[0];
//                 }
//             }
//             break;
//         default:
//             break;
//     }
//     return $content;
// }
// add_filter('manage_contact_custom_column', 'add_contacts_column_content', 10, 3);

// remove default text boxes (slug)
if (!function_exists('ei_remove_attendee_taxonomy_metabox')) {
    function ei_remove_attendee_taxonomy_metabox()
    {

        global $taxonomy;

        $modified_tax_arr = array('attendee');

        if (empty($taxonomy) || !in_array($taxonomy, $modified_tax_arr)) {
            return;
        }

?>
<style>
.form-field.term-slug-wrap,
.form-field.term-parent-wrap,
.form-field.term-description-wrap {
    display: none;
}
</style>
<?php

    }
}
add_action('admin_head', 'ei_remove_attendee_taxonomy_metabox');