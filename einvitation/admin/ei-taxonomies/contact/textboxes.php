<?php
add_action('contact_add_form_fields', 'ei_add_contact_term_fields');
if (!function_exists('ei_add_contact_term_fields')) {

    function ei_add_contact_term_fields($taxonomy)
    {
?>
<div class="form-field">
    <label for="ei_contactemail"><?php _e('Email', 'einvitation') ?></label>
    <input type="email" id="ei_contactemail" name="ei_contactemail">
</div>
<div class="form-field">
    <label for="ei_contactnumber"><?php _e('contact number', 'einvitation') ?></label>
    <input type="tel" id="ei_contactnumber" name="ei_contactnumber" placeholder=" eg:03001111111" pattern="[0-9]{11}"
        required>
</div>
<?php

    }
}

add_action('contact_edit_form_fields', 'ei_edit_contact_term_fields', 10, 2);

if (!function_exists('ei_edit_contact_term_fields')) {
    function ei_edit_contact_term_fields($term, $taxonomy)
    {

        $contactemail = get_term_meta($term->term_id, 'ei_contactemail', true);
        $contactnumber = get_term_meta($term->term_id, 'ei_contactnumber', true);
    ?>
<tr class="form-field">
    <th>
        <label for="ei_contactemail"><?php _e('Email', 'einvitation') ?></label>
    </th>
    <td>
        <input type="email" id="ei_contactemail" name="ei_contactemail"
            value="<?php echo (isset($contactemail)) ? $contactemail : ''; ?>">
    </td>
</tr>
<tr class="form-field">
    <th>
        <label for="ei_contactnumber"><?php _e('contact number', 'einvitation') ?></label>

    </th>
    <td>
        <input type="tel" id="ei_contactnumber" name="ei_contactnumber" placeholder="03001111111" pattern="[0-9]{11}"
            required value="<?php echo (isset($contactnumber)) ? $contactnumber : ''; ?>">
    </td>
    <!-- <input type="hidden" name="ei_contactverification" value="1"> -->
    <!-- <input type="text" id="ei_contactverification" name="ei_contactverification" required> -->
</tr>
<?php
    }
}



add_action('created_contact', 'ei_save_contact_term_fields');
add_action('edited_contact', 'ei_save_contact_term_fields');

if (!function_exists('ei_save_contact_term_fields')) {
    function ei_save_contact_term_fields($term_id)
    {
        // echo "called term";


        update_term_meta(
            $term_id,
            'ei_contactemail',
            sanitize_text_field($_POST['ei_contactemail'])
        );
        update_term_meta(
            $term_id,
            'ei_contactnumber',
            sanitize_text_field($_POST['ei_contactnumber'])
        );
        // if (!isset($_POST['ei_contactverification'])) {
        //     $codeis = 1;
        // } else {
        //     $codeis = 0;
        // }

        // update_term_meta(
        //     $term_id,
        //     'ei_contactverification',
        //     $codeis
        // );
        $token = rand();
        update_term_meta(
            $term_id,
            'ei_contactverification',
            $token
        );
        update_term_meta(
            $term_id,
            'ei_isverified',
            true
        );
    }
}