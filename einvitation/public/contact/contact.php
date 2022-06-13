<?php
$user = wp_get_current_user();
$ei_loginuseremail;
$ei_contactemail;
$ei_contactnumber;
$ei_contactname;
$ei_ispresent = false;
if ($user && isset($user->user_login)) {
    // print_r($user);
    $ei_loginuseremail = $user->user_email;
    $args = array(
        'hide_empty' => false, // also retrieve terms which are not used yet
        'meta_query' => array(
            array(
                'key'       => 'ei_contactemail',
                'value'     => $ei_loginuseremail,
            )
        ),
        'taxonomy'  => 'contact',
    );
    $terms = get_terms($args);
    if ($terms) {
        foreach ($terms as $term) {
            $ei_contacttermmeta = get_term_meta($term->term_id, '', true);
            foreach ($ei_contacttermmeta as $key => $val) {
                $ei_contactname = $term->name;
                if ($key === "ei_contactnumber") {
                    $ei_contactnumber = $val[0];
                }
                if ($key === "ei_contactemail") {
                    $ei_contactemail = $val[0];
                }
            }
        }
    }
    if (empty($terms)) {
        $ei_ispresent = false;
    } else {
        $ei_ispresent = true;
    }
}
?>
<style>
.ei_contactform {
    margin-top: 30px;
}

.ei_contactformbtn {
    margin-top: 20px !important;
}

.alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
}

.alert.success {
    background-color: #04AA6D;
}

.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}
</style>
<script>
var close = document.getElementsByClassName("closebtn");
var i;
for (i = 0; i < close.length; i++) {
    close[i].onclick = function() {
        var div = this.parentElement;
        div.style.opacity = "0";
        setTimeout(function() {
            div.style.display = "none";
        }, 600);
    }
}
</script>

<form class="ei_contactform" id="pippin_create_post" action="" method="POST">
    <label for="ei_name"><?php _e('Name', 'einvitation') ?></label>
    <input name="ei_name" id="ei_name" type="text" <?php echo ($user && $ei_ispresent == true) ? 'readonly' : ' ' ?>
        value="<?php echo ($user && $ei_ispresent == true) ? $ei_contactname : ' ' ?>" />
    <label for="ei_contactemail"><?php _e('Email', 'einvitation') ?></label>
    <input type="email" id="ei_contactemail" name="ei_contactemail"
        <?php echo ($user && isset($user->user_login) && $ei_ispresent == false) ? 'readonly' : (($user && isset($user->user_login) && $ei_ispresent == true) ? 'readonly' : ' ') ?>
        value="<?php echo ($user && isset($user->user_login) && $ei_ispresent == false) ? $ei_loginuseremail : (($user && isset($user->user_login) && $ei_ispresent == true) ? $ei_contactemail : ' ') ?>">
    <label for="ei_contactnumber"><?php _e('Contact Number', 'einvitation') ?></label>
    <input type="tel" id="ei_contactnumber" name="ei_contactnumber" placeholder=" eg:03001111111" pattern="[0-9]{11}"
        value="<?php echo ($user && $ei_ispresent == true) ? $ei_contactnumber : ' ' ?>"
        <?php echo ($user && $ei_ispresent == true) ? 'readonly' : ' ' ?> required>
    <input type="hidden" name="ei_contactverification" value="0">
    <?php wp_nonce_field('contact_nonce', 'contact_nonce_field'); ?>
    <input class="ei_contactformbtn" type="submit" name="job_submit" value="<?php _e('Subscribe', 'einvitation'); ?>" />
</form>
<?php
include_once plugin_dir_path(__DIR__) . 'event/event.php';
if (isset($_POST['contact_nonce_field']) && wp_verify_nonce($_POST['contact_nonce_field'], 'contact_nonce')) {

    if (strlen(trim($_POST['ei_name'])) < 1 || strlen(trim($_POST['ei_contactemail'])) < 1 || strlen(trim($_POST['ei_contactnumber'])) < 1) {
        // $redirect = add_query_arg('post', 'failed', home_url($_POST['_wp_http_referer']));
    } else {
        $ei_selectedeventid = '<script>ei_eventid</script>';
        echo $ei_selectedeventid;
        $result = wp_insert_term(
            $_POST['ei_name'],   // the term 
            'contact', // the taxonomy
            array(
                'slug'        =>  $_POST['ei_name'],
                'parent'      => '',
            )
        );
        if (is_wp_error($result)) {
            $error_string = $result->get_error_message();
            echo '<div id="message" class="error"><p>' . $error_string . '</p> </div>';
        } else {
            // echo $ei_id;
            $ei_termid;
            $ei_counter = 0;
            foreach ($result as $rel) {
                if ($ei_counter == 0) {
                    $ei_termid = $rel;
                    $ei_counter++;
                }
            }
            update_term_meta(
                $ei_termid,
                'ei_contactnumber',
                sanitize_text_field($_POST['ei_contactnumber'])
            );
            update_term_meta(
                $ei_termid,
                'ei_contactemail',
                sanitize_text_field($_POST['ei_contactemail'])
            );
            $token = rand();
            update_term_meta(
                $ei_termid,
                'ei_contactverification',
                $token
            );
            update_term_meta(
                $ei_termid,
                'ei_isverified',
                false
            );
            echo
            '<div class="alert success">
            <span class="closebtn">&times;</span>  
            <strong>Success!</strong> check your email and click on the link to verify email.
          </div>';

            // $ei_basepath = WP_PLUGIN_DIR . '/einvitation';
            $link = "<a href='localhost/test/wp-content/plugins/einvitation/public/contact/verify-email.php?key=" .  base64_encode($_POST['ei_contactemail']) . "&token=" .  base64_encode($token) . "&eventId=" .  base64_encode($ei_id) . "'>Click and Verify Email</a>";
            // $link = "<a href='" . $ei_basepath . "/public/contact/verify-email.php?key=" .  base64_encode($_POST['ei_contactemail']) . "&token=" .  base64_encode($token) . "&eventId=" .  base64_encode($ei_id) . "'>Click and Verify Email</a>";
            // $link = "<a href='" . plugin_dir_path(__DIR__) . "/contact/verify-email.php?key=" . $_POST['ei_contactemail'] . "&token=" . $token . "'>Click and Verify Email</a>";
            // $link = "<a href=' ".plugin_dir_path(__DIR__) . 'contact/verify-email.php?key=" . $_POST['ei_contactemail'] . "&token=" . $token . "'."'>Click and Verify Email</a>";
            $header = "From: ahtasham067@gmail.com\r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $header .= "X-Priority: 1\r\n";
            $message = $link;

            $status = mail("ahtasham067da@gmail.com", "subject", $message, $header);

            if ($status) {
                // echo '<p>Your mail has been sent!</p>';
            } else {
                echo '<p>Something went wrong. Please try again!</p>';
            }
        }
    }
}