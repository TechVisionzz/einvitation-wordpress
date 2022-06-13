<?php
add_action('attendee_add_form_fields', 'ei_add_attendee_term_fields');
if (!function_exists('ei_add_attendee_term_fields')) {

    function ei_add_attendee_term_fields($taxonomy)
    {
        $ei_user = wp_get_current_user();
        $args = array(
            'post_type' => 'event',
            'post_status' => 'publish',
            'post_author' => $ei_user->ID,
        );
        $ei_getcurrentevents = get_posts($args);
        // print_r($ei_getcurrentevents);

?>
<div class="form-field">
    <label for="ei_eventname"><?php _e(' Select Event', 'einvitation') ?></label>
    <select required name="ei_eventname" class="widthstyle">


        <?php
                if (count($ei_getcurrentevents) == 0) {
                    echo '<option>' . _e('No Event is available', 'einvitation') . '</option>';
                } else {
                    foreach ($ei_getcurrentevents as $tax_term) :
                        $term_vals = get_post_meta($tax_term->ID, $key = '', $single = false);
                        foreach ($term_vals as $key => $val) {
                            // echo $key . ' : ' . $val[0] . '<br/>';
                            if ($key === "ei_eventstarttime") {
                                $ei_iscurrent = false;
                                $titles = unserialize($val[0]);
                                foreach ($titles as $title) { // Loop through it
                                    if (!$ei_iscurrent) {
                                        if (date('Y-m-d\TH:i') <= $title) {
                                            $ei_iscurrent = true;
                                        }
                                    }
                                }
                                if ($ei_iscurrent) {
                ?>
        <option value="<?php echo $tax_term->ID ?>">
            <?php echo $tax_term->post_name ?></option>
        <?php
                                }
                            }
                        }
                    endforeach;
                }
                ?>
    </select>
</div>
<div class="form-field">
    <label for="ei_attendeeevent"><?php _e('Email', 'einvitation') ?></label>
    <input type="email" id="ei_attendeeevent" name="ei_attendeeevent">
</div>

<?php

    }
}

add_action('attendee_edit_form_fields', 'ei_edit_attendee_term_fields', 10, 2);

if (!function_exists('ei_edit_attendee_term_fields')) {
    function ei_edit_attendee_term_fields($term, $taxonomy)
    {

        $contactemail = get_term_meta($term->term_id, 'ei_attendeeevent', true);
        $contactnumber = get_term_meta($term->term_id, 'ei_eventname', true);
    ?>
<tr class="form-field">
    <th>
        <label for="ei_attendeeevent"><?php _e('Email', 'einvitation') ?></label>
    </th>
    <td>
        <input type="email" id="ei_attendeeevent" name="ei_attendeeevent"
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
</tr>
<?php
    }
}



add_action('created_attendee', 'ei_save_attendee_term_fields');
add_action('edited_attendee', 'ei_save_attendee_term_fields');

if (!function_exists('ei_save_attendee_term_fields')) {
    function ei_save_attendee_term_fields($term_id)
    {
        // echo '<script> alert("hello")</script>';
        echo 'hello';
        // fetch term data based on term email
        $args = array(
            'hide_empty' => false, // also retrieve terms which are not used yet
            'meta_query' => array(
                array(
                    'key'       => 'ei_contactemail',
                    'value'     => $_POST['ei_attendeeevent'],
                )
            ),
            'taxonomy'  => 'contact',
        );
        $ei_terms = get_terms($args);
        print_r($ei_terms);
        if (count($ei_terms) == 0) {
            echo "Email is not exist in your contact";
        } else {
            // fetch event postmeta from table for update
            $term_vals = get_post_meta($_POST['ei_eventname'], $key = 'ei_eventattended', $single = false);
            if ($term_vals) {
                $array = unserialize($$term_vals);
                $array[] = $ei_terms->ID;
                // return serialize($array);
                update_post_meta(
                    $_POST['ei_eventname'],
                    'ei_eventattended',
                    $array,
                );
            }
        }
        if (array_key_exists('ei_eventname', $_POST)) {
            update_post_meta(
                $_POST['ei_eventname'],
                'ei_eventname',
                $_POST['ei_eventname']
            );
        }
    }
}