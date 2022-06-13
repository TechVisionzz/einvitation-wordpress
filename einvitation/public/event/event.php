<?php

function ei_events()
{
    $ei_receiverevents = array();
    $ei_userislogin = false;

    $ei_user = wp_get_current_user();
    // $ei_ispresent;
    if ($ei_user && isset($ei_user->user_login)) {
        $ei_useremail = $ei_user->user_email;
        $ei_userislogin = true;
        $args = array(
            'hide_empty' => false, // also retrieve terms which are not used yet
            'meta_query' => array(
                array(
                    'key'       => 'ei_contactemail',
                    'value'     => $ei_useremail,
                )
            ),
            'taxonomy'  => 'contact',
        );
        $ei_terms = get_terms($args);
        if (empty($ei_terms)) {
            $ei_ispresent = false;
        } else {
            foreach ($ei_terms as $ei_term) {
                // echo ($ei_term->term_id);
                $args = array(
                    'post_type' => 'event',
                    'post_status' => 'publish',
                    'meta_query' => array(
                        array(
                            'key'   => 'ei_eventreceiver',
                            'value' => $ei_term->term_id,
                            'compare' => 'LIKE',
                        )
                    )
                );
                $ei_receiverevents = get_posts($args);
                // print_r($ei_receiverevents);
            }
        }
    }
?>
<style>
/* Style the tab  */
.tab {
    overflow: hidden;
}


/* Style the buttons inside the tab */

.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}


/* Change background color of buttons on hover */

.tab button:hover {
    background-color: #ddd;
}


/* Create an active/current tablink class */

.tab button.active {
    background-color: #ccc;
}


/* Style the tab content */

.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}


/* style for cards */

h1 {
    font-size: 2.5rem;
    font-family: 'Montserrat';
    font-weight: normal;
    color: #444;
    text-align: center;
    margin: 2rem 0;
}

.wrapper {
    width: 90%;
    margin: 0 auto;
    max-width: 80rem;
}

.cols {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

.col {
    width: calc(25% - 2rem);
    margin: 1rem;
    cursor: pointer;
}

.container {
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
    -webkit-perspective: 1000px;
    perspective: 1000px;
}

.front,
.back {
    background-size: cover;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.25);
    border-radius: 10px;
    background-position: center;
    -webkit-transition: -webkit-transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
    transition: -webkit-transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
    -o-transition: transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
    transition: transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
    transition: transform .7s cubic-bezier(0.4, 0.2, 0.2, 1), -webkit-transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    text-align: center;
    min-height: 280px;
    height: auto;
    border-radius: 10px;
    color: #fff;
    font-size: 1.5rem;
}

.back {
    background: #cedce7;
    background: -webkit-linear-gradient(45deg, #cedce7 0%, #596a72 100%);
    background: -o-linear-gradient(45deg, #cedce7 0%, #596a72 100%);
    background: linear-gradient(45deg, #cedce7 0%, #596a72 100%);
}

.front:after {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
    width: 100%;
    height: 100%;
    content: '';
    display: block;
    opacity: .6;
    background-color: #000;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    border-radius: 10px;
}

.container:hover .front,
.container:hover .back {
    -webkit-transition: -webkit-transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
    transition: -webkit-transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
    -o-transition: transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
    transition: transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
    transition: transform .7s cubic-bezier(0.4, 0.2, 0.2, 1), -webkit-transform .7s cubic-bezier(0.4, 0.2, 0.2, 1);
}

.back {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
}

.inner {
    -webkit-transform: translateY(-50%) translateZ(60px) scale(0.94);
    transform: translateY(-50%) translateZ(60px) scale(0.94);
    top: 50%;
    position: absolute;
    left: 0;
    width: 100%;
    padding: 2rem;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    outline: 1px solid transparent;
    -webkit-perspective: inherit;
    perspective: inherit;
    z-index: 2;
}

.container .back {
    -webkit-transform: rotateY(180deg);
    transform: rotateY(180deg);
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
}

.container .front {
    -webkit-transform: rotateY(0deg);
    transform: rotateY(0deg);
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
}

.container:hover .back {
    -webkit-transform: rotateY(0deg);
    transform: rotateY(0deg);
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
}

.container:hover .front {
    -webkit-transform: rotateY(-180deg);
    transform: rotateY(-180deg);
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
}

.front .inner p {
    font-size: 2rem;
    margin-bottom: 2rem;
    position: relative;
}

.front .inner p:after {
    content: '';
    width: 4rem;
    height: 2px;
    position: absolute;
    background: #C6D4DF;
    display: block;
    left: 0;
    right: 0;
    margin: 0 auto;
    bottom: -.75rem;
}

.front .inner span {
    color: rgba(255, 255, 255, 0.7);
    font-family: 'Montserrat';
    font-weight: 300;
}

@media screen and (max-width: 64rem) {
    .col {
        width: calc(33.333333% - 2rem);
    }
}

@media screen and (max-width: 48rem) {
    .col {
        width: calc(50% - 2rem);
    }
}

@media screen and (max-width: 32rem) {
    .col {
        width: 100%;
        margin: 0 0 2rem 0;
    }
}

.mainheading {
    text-align: center;
}
</style>
<h2 class="mainheading"><?php echo _e('My Events', 'einvitation') ?></h2>
<?php
    if ($ei_userislogin) {
    ?>
<div class="tab">
    <button class="tablinks" onclick="openCity(event, 'ei_currentevents')"
        id="defaultOpen"><?php _e('Current Events', 'einvitation') ?></button>
    <button class="tablinks"
        onclick="openCity(event, 'ei_pastevents')"><?php _e('Past Events', 'einvitation') ?></button>
</div>
<div id="ei_currentevents" class="tabcontent">
    <div class="wrapper">
        <h3 class="mainheading"><?php _e('Event As Receiver', 'einvitation') ?></h3>
        <?php
                if ($ei_userislogin) {
                ?>
        <div class="cols">
            <?php

                        if (count($ei_receiverevents) == 0) {
                            echo '<p>' . _e('No Public Event is available', 'einvitation') . '</p>';
                        } else {
                            foreach ($ei_receiverevents as $tax_term) :
                                $term_vals = get_post_meta($tax_term->ID, $key = '', $single = false);
                                foreach ($term_vals as $key => $val) {
                                    $ei_eventisPublic = true;
                                    if ($key === "ei_eventtype" && $val[0] == 1) {
                                        $ei_eventisPublic = true;
                                    } else {
                                        $ei_eventisPublic = false;
                                    }
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
            <div class="col" ontouchstart="this.classList.toggle('hover');">
                <div class="container">
                    <div class="front" style="background-image: url(https://unsplash.it/500/500/)">
                        <div class="inner">
                            <p><?php echo $tax_term->post_name ?></p>
                            <span><?php if ($ei_eventisPublic) {
                                                                        echo ("Public");
                                                                    } else {
                                                                        echo ("Private");
                                                                    }
                                                                    ?></span>
                        </div>
                    </div>
                    <div class="back">
                        <div class="inner">
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Alias cum repellat velit quae
                                suscipit c.</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                                        }
                                    }
                                }
                            endforeach;
                        }

                        ?>
        </div>
        <?php
                }
                ?>

    </div>
    <!-- event as attendee -->
    <div class="wrapper">
        <h3 class="mainheading"><?php _e('Event As Attendee', 'einvitation') ?></h3>
        <?php
                if ($ei_userislogin) {
                ?>
        <div class="cols">
            <?php

                        if (count($ei_receiverevents) == 0) {
                            echo '<p>' . _e('No  Event is available', 'einvitation') . '</p>';
                        } else {
                            foreach ($ei_receiverevents as $tax_term) :
                                $term_vals = get_post_meta($tax_term->ID, $key = '', $single = false);
                                foreach ($term_vals as $key => $val) {

                                    if ($key === "ei_eventtype") {
                        ?>
            <div class="col" ontouchstart="this.classList.toggle('hover');">
                <div class="container">
                    <div class="front" style="background-image: url(https://unsplash.it/500/500/)">
                        <div class="inner">
                            <p><?php echo $tax_term->post_name ?></p>
                            <span><?php if ($key === "ei_eventtype" && $val[0] == 1) {
                                                                    echo ("Public");
                                                                } else {
                                                                    echo ("Private");
                                                                }
                                                                ?></span>
                        </div>
                    </div>
                    <div class="back">
                        <div class="inner">
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Alias cum repellat velit quae
                                suscipit c.</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                                    }
                                }
                            endforeach;
                        }

                        ?>
        </div>
        <?php
                }
                ?>

    </div>
</div>

<div id="ei_pastevents" class="tabcontent">
    <div class="wrapper">
        <h3 class="mainheading"><?php _e('Event As Receiver', 'einvitation') ?></h3>
        <?php
                if ($ei_userislogin) {
                ?>
        <div class="cols">
            <?php

                        if (count($ei_receiverevents) == 0) {
                            echo '<p>' . _e('No Public Event is available', 'einvitation') . '</p>';
                        } else {
                            foreach ($ei_receiverevents as $tax_term) :
                                $term_vals = get_post_meta($tax_term->ID, $key = '', $single = false);
                                foreach ($term_vals as $key => $val) {
                                    $ei_eventisPublic = true;
                                    if ($key === "ei_eventtype" && $val[0] == 1) {
                                        $ei_eventisPublic = true;
                                    } else {
                                        $ei_eventisPublic = false;
                                    }
                                    // echo $key . ' : ' . $val[0] . '<br/>';
                                    if ($key === "ei_eventstarttime") {
                                        $ei_iscurrent = false;
                                        $titles = unserialize($val[0]);
                                        foreach ($titles as $title) { // Loop through it
                                            if (!$ei_iscurrent) {
                                                if (date('Y-m-d\TH:i') > $title) {
                                                    $ei_iscurrent = true;
                                                }
                                            }
                                        }
                                        if ($ei_iscurrent) {
                        ?>
            <div class="col" ontouchstart="this.classList.toggle('hover');">
                <div class="container">
                    <div class="front" style="background-image: url(https://unsplash.it/500/500/)">
                        <div class="inner">
                            <p><?php echo $tax_term->post_name ?></p>
                            <span><?php if ($ei_eventisPublic) {
                                                                        echo ("Public");
                                                                    } else {
                                                                        echo ("Private");
                                                                    }
                                                                    ?></span>
                        </div>
                    </div>
                    <div class="back">
                        <div class="inner">
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Alias cum repellat velit quae
                                suscipit c.</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                                        }
                                    }
                                }
                            endforeach;
                        }

                        ?>
        </div>
        <?php
                }
                ?>

    </div>
    <!-- event as attendee -->
    <div class="wrapper">
        <h3 class="mainheading"><?php _e('Event As Attendee', 'einvitation') ?></h3>
        <?php
                if ($ei_userislogin) {
                ?>
        <div class="cols">
            <?php

                        if (count($ei_receiverevents) == 0) {
                            echo '<p>' . _e('No Public Event is available', 'einvitation') . '</p>';
                        } else {
                            foreach ($ei_receiverevents as $tax_term) :
                                $term_vals = get_post_meta($tax_term->ID, $key = '', $single = false);
                                foreach ($term_vals as $key => $val) {

                                    if ($key === "ei_eventtype") {
                        ?>
            <div class="col" ontouchstart="this.classList.toggle('hover');">
                <div class="container">
                    <div class="front" style="background-image: url(https://unsplash.it/500/500/)">
                        <div class="inner">
                            <p><?php echo $tax_term->post_name ?></p>
                            <span><?php if ($key === "ei_eventtype" && $val[0] == 1) {
                                                                    echo ("Public");
                                                                } else {
                                                                    echo ("Private");
                                                                }
                                                                ?></span>
                        </div>
                    </div>
                    <div class="back">
                        <div class="inner">
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Alias cum repellat velit quae
                                suscipit c.</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                                    }
                                }
                            endforeach;
                        }

                        ?>
        </div>
        <?php
                }
                ?>

    </div>
</div>
<?php
    } else {
        echo ('<p>to view your events first login</p>');
        wp_login_form();
    }
    ?>
<h2 class="mainheading"><?php _e('Public Events', 'einvitation') ?></h2>

<div class="wrapper">
    <div class="cols">
        <?php
            $args = array(
                'post_type' => 'event',
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key'   => 'ei_eventtype',
                        'value' => 1,
                        'compare' => 'LIKE',
                    )
                )
            );

            $latest_books = get_posts($args);
            if (count($latest_books) == 0) {
                echo '<p>' . _e('No Public Event is available', 'einvitation') . '</p>';
            } else {
                foreach ($latest_books as $tax_term) :
                    $terms_vals = get_post_meta($tax_term->ID, $key = '', $single = false);
                    foreach ($terms_vals as $key => $val) {
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
                                if ($ei_receiverevents) {
                                    foreach ($ei_receiverevents as $ei_receiverevent) {
                                        if ($ei_receiverevent->post_title == $tax_term->post_name) {
                                            // echo "found";
                                            // in this event user is register as a receiver so it will only work if user is logged in
                                        } else {
            ?>
        <div class="col" ontouchstart="this.classList.toggle('hover');">
            <div class="container">
                <div class="front" style="background-image: url(https://unsplash.it/500/500/)">
                    <div class="inner">
                        <p><?php echo $tax_term->post_name ?></p>
                        <span><?php echo ("Public") ?></span>
                    </div>
                </div>
                <div class="back">
                    <div class="inner">
                        <?php
                                                            $ei_id = $tax_term->ID;
                                                            ?>
                        <div class="ei_cursor" onclick="openModel(<?= $ei_id ?>)"
                            id="myBtn<?php echo $tax_term->ID; ?>">
                            <?php _e('subscribe', 'einvitation') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
                                        }
                                    }
                                } else {
                                    ?>
        <div class="col" ontouchstart="this.classList.toggle('hover');">
            <div class="container">
                <div class="front" style="background-image: url(https://unsplash.it/500/500/)">
                    <div class="inner">
                        <p><?php echo $tax_term->post_name ?></p>
                        <span><?php echo ("Public") ?></span>
                    </div>
                </div>
                <div class="back">
                    <div class="inner">
                        <?php
                                                    $ei_id = $tax_term->ID;
                                                    ?>
                        <div class="ei_cursor" onclick="openModel(<?= $ei_id ?>)"
                            id="myBtn<?php echo $tax_term->ID; ?>">
                            <?php _e('subscribe', 'einvitation') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
                                }
                            }
                        }
                    }
                endforeach;
            }

            ?>
    </div>
</div>
<div id="myModal1" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="close">&times;</div>
        <?php
            // echo plugin_dir_path(__DIR__) . 'contact/contact.php';
            require_once plugin_dir_path(__DIR__) . 'contact/contact.php';
            ?>
    </div>
</div>
</div>
<style>
/* The Modal (background) */
.ei_cursor {
    cursor: pointer;
}

.modal {
    margin-left: 10%;
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 1;
    /* Sit on top */
    padding-top: 100px;
    /* Location of the box */
    left: 0;
    top: 0;
    width: 80%;
    /* Full width */
    height: 100%;
    /* Full height */
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgb(0, 0, 0);
    /* Fallback color */
    background-color: rgba(0, 0, 0, 0.4);
    /* Black w/ opacity */
}


/* Modal Content */

.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}


/* The Close Button */

.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>
<script>
function openModel(ei_id) {
    var modal = document.getElementById("myModal1");
    modal.style.display = "block";
    var ei_eventid = ei_id;
    // Get the button that opens the modal
    var btn = document.getElementById("myBtn" + ei_eventid + "");
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}
document.getElementById("defaultOpen").click();

function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>
<?php
}