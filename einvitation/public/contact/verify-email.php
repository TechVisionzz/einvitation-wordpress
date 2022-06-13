<?php
// require_once("../../../../wp-load.php");
require_once('../../../wp-load.php');
if ($_GET['key'] && $_GET['token'] && $_GET['eventId']) {

    echo base64_decode($_GET['key']);
    echo base64_decode($_GET['token']);
    echo base64_decode($_GET['eventId']);
    $args = array(
        'hide_empty' => false, // also retrieve terms which are not used yet
        'meta_query' => array(
            array(
                'key'       => 'ei_contactemail',
                'value'     => base64_decode($_GET['key']),
            )
        ),
        'taxonomy'  => 'contact',
    );
    $ei_terms = get_terms($args);
    print_r($ei_terms);
}