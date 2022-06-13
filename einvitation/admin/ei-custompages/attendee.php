<?php
$ei_user = wp_get_current_user();
$args = array(
    'post_type' => 'event',
    'post_status' => 'publish',
    'post_author' => $ei_user->ID,
);
$ei_getcurrentevents = get_posts($args);
?>
<div class="wrap">
    <h1><?php _e('Event Attendee', 'textdomain'); ?></h1>
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
        <label for="ei_attendeeevent" style="display: block;"><?php _e('Email', 'einvitation') ?></label>
        <input type="email" id="ei_attendeeevent" name="ei_attendeeevent">
    </div>
</div>
<div class="form-field">
    <button id="submitform" style="margin-left: 3px;margin-top: 15px;" class="button red"
        onclick="addAttendee()">Send</button>
</div>
<script>
function addAttendee() {
    // var value = $("#ei_eventname option:selected").value;
    // var e = document.getElementById("ei_eventname");
    // var strUser = e.options[e.selectedIndex].value;
    var ei_email = document.getElementById("ei_attendeeevent").value;
    // ei_eventname
    console.log(ei_email);
    // console.log(strUser);
    var ei_event = 564;
    <?php
        updatepostmeta();
        ?>
}
</script>
<?php
function updatepostmeta()
{
    // fetch both these variable from js variable
    $event = 564;
    $email = 'ahtasham067@gmail.com';
    $args = array(
        'hide_empty' => false, // also retrieve terms which are not used yet
        'meta_query' => array(
            array(
                'key'       => 'ei_contactemail',
                'value'     => $email,
            ),
            array(
                'key'       => 'ei_isverified',
                'value'     => 1,
            ),
        ),
        'taxonomy'  => 'contact',
    );
    $ei_terms = get_terms($args);
    if (count($ei_terms) == 0) {
        echo "Email is not exist in your contact";
    } else {
        // fetch event postmeta from table for update
        $term_vals = get_post_meta($event, $key = 'ei_eventattending', $single = false);
        print_r($term_vals);
        if ($term_vals) {
            $ei_array = unserialize($term_vals);
            $ei_eventarray = count($ei_array);
            for ($i = 0; $i < $ei_eventarray; $i++) {
                if ($ei_array[$i] == $email) {
                    // append data in ei_eventattended and update post meta
                    update_post_meta(
                        $event,
                        'ei_eventattended',
                        'array',
                    );
                } else {
                    echo "you are not subscribe this event";
                }
            }
        } else {
            echo "no one is subscribe  for this event";
        }
    }
}