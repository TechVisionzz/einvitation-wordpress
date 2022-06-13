<?php

// egister metaboxes against event posttype
function ei_register_event_metaboxes()
{
    $ei_screens = ['event'];
    foreach ($ei_screens as $ei_screen) {
        add_meta_box(
            'ei_event_metaboxes_id',              // Unique ID
            ' ',                                  // Box title
            'ei_custom_boxes_html',               // Content callback, must be of type callable
            $ei_screen                               // Post type
        );
    }
}
add_action('add_meta_boxes', 'ei_register_event_metaboxes');

// define create event custom metaboxes start

function ei_custom_boxes_html($post)
{
    $eventcategory = get_post_meta($post->ID, 'ei_eventcategory', true);
    $eventtype = get_post_meta($post->ID, 'ei_eventtype', true);
    $eventlocationlat = get_post_meta($post->ID, 'ei_eventlocationlat', true);
    $eventlocationlon = get_post_meta($post->ID, 'ei_eventlocationlon', true);
    $eventstarttime = get_post_meta($post->ID, 'ei_eventstarttime', true);
    $eventendtime = get_post_meta($post->ID, 'ei_eventendtime', true);
    $eventreceiver = get_post_meta($post->ID, 'ei_eventreceiver', true);
    $eventags = get_post_meta($post->ID, 'ei_eventags', true);
?>
<script src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap&v=weekly" defer></script>
<!-- <script>

</script> -->

<div class="form-field">
    <label for="ei_eventcategory"><?php _e('Event Category', 'einvitation') ?></label>
    <select required name="ei_eventcategory" class="widthstyle">
        <option value=""><?php _e('Please Select', 'einvitation') ?></option>
        <option <?php echo ($eventcategory == 1) ? 'selected' : ''; ?> value="1">
            <?php _e('corporate', 'einvitation') ?></option>
        <option <?php echo ($eventcategory == 2) ? 'selected' : ''; ?> value="2">
            <?php _e('Gala or Fundraiser', 'einvitation') ?></option>
        <option <?php echo ($eventcategory == 3) ? 'selected' : ''; ?> value="3">
            <?php _e('Show or Performance', 'einvitation') ?></option>
        <option <?php echo ($eventcategory == 4) ? 'selected' : ''; ?> value="4">
            <?php _e('Wedding', 'einvitation') ?></option>
        <option <?php echo ($eventcategory == 5) ? 'selected' : ''; ?> value="5">
            <?php _e('Reunion', 'einvitation') ?></option>
        <option <?php echo ($eventcategory == 6) ? 'selected' : ''; ?> value="6">
            <?php _e('Holiday Party', 'einvitation') ?></option>
        <option <?php echo ($eventcategory == 7) ? 'selected' : ''; ?> value="7">
            <?php _e('Military', 'einvitation') ?></option>
        <option <?php echo ($eventcategory == 8) ? 'selected' : ''; ?> value="8">
            <?php _e('BirthDay', 'einvitation') ?></option>
        <option <?php echo ($eventcategory == 9) ? 'selected' : ''; ?> value="9">
            <?php _e('Faith Based', 'einvitation') ?></option>
        <option <?php echo ($eventcategory == 10) ? 'selected' : ''; ?> value="10">
            <?php _e('other', 'einvitation') ?></option>
    </select>
</div>
<div class="form-field">
    <label for="ei_eventtype"><?php _e('Event Type', 'einvitation') ?></label>
    <select required name="ei_eventtype" class="widthstyle">
        <option <?php echo ($eventtype == 1) ? 'selected' : ''; ?> value="1">
            <?php _e('public', 'einvitation') ?></option>
        <option <?php echo ($eventtype == 2) ? 'selected' : ''; ?> value="2">
            <?php _e('private', 'einvitation') ?></option>
    </select>
</div>
<div class="container1 form-field">
    <?php
        $ei_i = 1;
        if ($eventstarttime) {
            $ei_starttimecounter = 1;

            foreach ($eventstarttime as $ei_starttime) {
                if ($ei_starttimecounter == 1) {
                    $ei_starttimecounter++;
        ?>
    <div>
        <label for="ei_eventstarttime"><?php _e('start time', 'einvitation') ?></label>
        <input id="ei_eventstarttime" type="datetime-local" name="ei_eventstarttime[]" class="datepickerstyle" required
            value="<?php echo (isset($ei_starttime)) ? $ei_starttime : ''; ?>">
        <label for="ei_eventendtime"><?php _e('end time', 'einvitation') ?></label>
        <input id="ei_eventendtime" type="datetime-local" name="ei_eventendtime[]" class="datepickerstyle" required
            value="<?php echo  $eventendtime[$ei_starttimecounter - 2]; ?>">
        <?php
                        $ei_lat = $eventlocationlat[$ei_starttimecounter - 2];
                        $ei_lon = $eventlocationlon[$ei_starttimecounter - 2];
                        ?>
        <a href="javascript:map()" onclick="map()">
            See Location</a>
        <input id="ei_eventlocationlat" type="text" name="ei_eventlocationlat[]"
            placeholder="<?php _e('latitude', 'einvitation') ?>" required
            value="<?php echo  $eventlocationlat[$ei_starttimecounter - 2]; ?>">
        <input id="ei_eventlocationlon" type="text" name="ei_eventlocationlon[]"
            placeholder="<?php _e('longitude', 'einvitation') ?>" required
            value="<?php echo  $eventlocationlon[$ei_starttimecounter - 2]; ?>">
    </div>
    <?php
                } else {
                ?>
    <div>
        <label for="ei_eventstarttime"><?php _e('start time', 'einvitation') ?></label>
        <input id="ei_eventstarttime" type="datetime-local" name="ei_eventstarttime[]" class="datepickerstyle" required
            value="<?php echo (isset($ei_starttime)) ? $ei_starttime : ''; ?>">
        <label for="ei_eventendtime"><?php _e('end time', 'einvitation') ?></label>
        <input id="ei_eventendtime" type="datetime-local" name="ei_eventendtime[]" class="datepickerstyle" required
            value="<?php echo  $eventendtime[$ei_starttimecounter - 1]; ?>">
        <input type="text" name="ei_eventlocationlat[]" placeholder="<?php _e('latitude', 'einvitation') ?>" required
            value="<?php echo  $eventlocationlat[$ei_starttimecounter - 1]; ?>">
        <input type="text" name="ei_eventlocationlon[]" placeholder="<?php _e('longitude', 'einvitation') ?>" required
            value="<?php echo  $eventlocationlon[$ei_starttimecounter - 1]; ?>">
        <a href='#' class='delete'><?php _e('Delete', 'einvitation') ?></a>
    </div>
    <?php
                    $ei_starttimecounter++;
                }
            }
            ?>
    <br />
    <button class="add_form_field"><?php _e('Add more Time & Location', 'einvitation') ?>
    </button>
    <?php
        } else {
        ?>
    <div>
        <label for="ei_eventstarttime"><?php _e('start time', 'einvitation') ?></label>
        <input id="ei_eventstarttime" type="datetime-local" name="ei_eventstarttime[]" class="datepickerstyle" required>
        <label for="ei_eventendtime"><?php _e('end time', 'einvitation') ?></label>
        <input id="ei_eventendtime" type="datetime-local" name="ei_eventendtime[]" class="datepickerstyle" required>
        <a href="#" onclick="openModel(1)" id="myBtn"><?php _e('Select Location', 'einvitation') ?></a>
        <input id="ei_eventlocationlat1" type="text" name="ei_eventlocationlat[]" required
            placeholder="<?php _e('latitude', 'einvitation') ?>">
        <input id="ei_eventlocationlon1" type="text" name="ei_eventlocationlon[]" required
            placeholder="<?php _e('longitude', 'einvitation') ?>">

    </div>
    <br />
    <button class="add_form_field"><?php _e('Add more Time & Location', 'einvitation') ?>
    </button>
    <?php
        } ?>
</div>
<div class="form-field">
    <label for=""><?php _e('Event Tags', 'einvitation') ?></label>
    <input type="text" id="tag-input1" name="tag-input1">
</div>
<div class="form-field">
    <label for="ei_eventreceiver"><?php _e('Event Receiver', 'einvitation') ?></label>
    <select required name="ei_eventreceiver[]" multiple class="widthstyle">
        <?php

            $tax_terms = get_terms('contact', array('hide_empty' => '0'));
            if (count($tax_terms) == 0) {
                echo '<option value=""> no contact is available first add contact</option>';
            } else {
                if ($eventreceiver) {
                    foreach ($tax_terms as $tax_term) :
            ?>
        <option <?php echo in_array($tax_term->term_id, $eventreceiver) ? 'selected' : ''; ?>
            value="<?php echo $tax_term->term_id ?>">
            <?php echo $tax_term->name ?></option>
        <?php
                    endforeach;
                } else {
                    foreach ($tax_terms as $tax_term) :
                    ?>
        <option value="<?php echo $tax_term->term_id ?>">
            <?php echo $tax_term->name ?></option>
        <?php
                    endforeach;
                }
            }
            ?>
    </select>
</div>
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="dvMap" style=" height: 500px">
        </div>
        <a class="okbtn" onclick="onok()">ok</a>
    </div>
</div>
<style>
.okbtn {
    background-color: #f44336;
    color: white;
    padding: 14px 25px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
    margin-top: 2px;
}
</style>
<script>
function onok() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}
var map;
$(document).ready(function() {



    function myMap(lat, long) {

        var myCenter = new google.maps.LatLng(lat, long);
        var mapCanvas = document.getElementById("dvMap");

        var mapOptions = {
            center: myCenter,
            zoom: 15,
            treetViewControl: false,
            mapTypeControl: false
        };

        map = new google.maps.Map(mapCanvas, mapOptions);
        var marker = new google.maps.Marker({
            position: myCenter,
            draggable: true // set marker draggable
        });
        marker.setMap(map);
        // Zoom to 15 when clicking on marker
        google.maps.event.addListener(marker, 'click', function() {
            map.setZoom(15);
            map.setCenter(marker.getPosition());
        });

        // when dragend, show new lat and lng in console
        google.maps.event.addListener(marker, 'dragend', function() {
            console.log("lat: " + marker.position.lat())
            console.log("lng: " + marker.position.lng())
            document.getElementById("ei_eventlocationlat" + currenttextboxid + "").value = marker
                .position.lat();
            document.getElementById("ei_eventlocationlon" + currenttextboxid + "").value = marker
                .position.lng();
        })

        //sets variable for lat and long
        $('.lat').text(lat);
        $('.long').text(long);
    }

    function newLocation(newLat, newLng) {
        map.setCenter({
            lat: newLat,
            lng: newLng
        });
    }

    google.maps.event.addDomListener(window, 'load', myMap(30.65714633981218, 73.10976017120363));


    $(document).ready(function() {
        google.maps.event.addListener(map, 'click', function(event) {
            newLocation(event.myCenter);
        });
    });

});
(function() {
    "use strict";
    // Plugin Constructor
    var TagsInput = function(opts) {
        this.options = Object.assign(TagsInput.defaults, opts);
        this.init();
    };
    // Initialize the plugin
    TagsInput.prototype.init = function(opts) {
        this.options = opts ? Object.assign(this.options, opts) : this.options;

        if (this.initialized) this.destroy();

        if (
            !(this.orignal_input = document.getElementById(this.options.selector))
        ) {
            console.error(
                "tags-input couldn't find an element with the specified ID"
            );
            return this;
        }

        this.arr = [];
        this.wrapper = document.createElement("div");
        this.input = document.createElement("input");
        init(this);
        initEvents(this);

        this.initialized = true;
        return this;
    };

    // Add Tags
    TagsInput.prototype.addTag = function(string) {
        if (this.anyErrors(string)) return;

        this.arr.push(string);
        var tagInput = this;

        var tag = document.createElement("span");
        tag.className = this.options.tagClass;
        tag.innerText = string;

        var closeIcon = document.createElement("a");
        closeIcon.innerHTML = "&times;";

        // delete the tag when icon is clicked
        closeIcon.addEventListener("click", function(e) {
            e.preventDefault();
            var tag = this.parentNode;

            for (var i = 0; i < tagInput.wrapper.childNodes.length; i++) {
                if (tagInput.wrapper.childNodes[i] == tag) tagInput.deleteTag(tag, i);
            }
        });

        tag.appendChild(closeIcon);
        this.wrapper.insertBefore(tag, this.input);
        this.orignal_input.value = this.arr.join(",");

        return this;
    };

    // Delete Tags
    TagsInput.prototype.deleteTag = function(tag, i) {
        tag.remove();
        this.arr.splice(i, 1);
        this.orignal_input.value = this.arr.join(",");
        return this;
    };

    // Make sure input string have no error with the plugin
    TagsInput.prototype.anyErrors = function(string) {
        if (this.options.max != null && this.arr.length >= this.options.max) {
            console.log("max tags limit reached");
            return true;
        }

        if (!this.options.duplicate && this.arr.indexOf(string) != -1) {
            console.log('duplicate found " ' + string + ' " ');
            return true;
        }

        return false;
    };

    // Add tags programmatically
    TagsInput.prototype.addData = function(array) {
        var plugin = this;

        array.forEach(function(string) {
            plugin.addTag(string);
        });
        return this;
    };

    // Get the Input String
    TagsInput.prototype.getInputString = function() {
        return this.arr.join(",");
    };

    // destroy the plugin
    TagsInput.prototype.destroy = function() {
        this.orignal_input.removeAttribute("hidden");

        delete this.orignal_input;
        var self = this;

        Object.keys(this).forEach(function(key) {
            if (self[key] instanceof HTMLElement) self[key].remove();

            if (key != "options") delete self[key];
        });

        this.initialized = false;
    };

    // Private function to initialize the tag input plugin
    function init(tags) {
        tags.wrapper.append(tags.input);
        tags.wrapper.classList.add(tags.options.wrapperClass);
        tags.orignal_input.setAttribute("hidden", "true");
        tags.orignal_input.parentNode.insertBefore(
            tags.wrapper,
            tags.orignal_input
        );
    }

    // initialize the Events
    function initEvents(tags) {
        tags.wrapper.addEventListener("click", function() {
            tags.input.focus();
        });

        tags.input.addEventListener("keydown", function(e) {
            var str = tags.input.value.trim();

            if (!!~[9, 13, 188].indexOf(e.keyCode)) {
                e.preventDefault();
                tags.input.value = "";
                if (str != "") tags.addTag(str);
            }
        });
    }
    // Set All the Default Values
    TagsInput.defaults = {
        selector: "",
        wrapperClass: "tags-input-wrapper",
        tagClass: "tag",
        max: null,
        duplicate: false
    };

    window.TagsInput = TagsInput;
})();
var tagInput1 = new TagsInput({
    selector: "tag-input1",
    duplicate: false,
});
var php_var = "<?php echo $eventags; ?>";
if (php_var) {
    var myarray = php_var.split(',');
    tagInput1.addData(myarray);
}
var currenttextboxid;
// When the user clicks the button, open the modal 
function openModel(ei_id) {
    currenttextboxid = ei_id;
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
        modal.style.display = "none";
        document.getElementById("ei_eventlocationlat" + ei_id + "").value = ' ';
        document.getElementById("ei_eventlocationlon" + ei_id + "").value = ' ';
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}
$(document).ready(function() {
    var wrapper = $(".container1");
    var add_button = $(".add_form_field");

    var x = 1;
    $(add_button).click(function(e) {
        e.preventDefault();
        x++;
        $(wrapper).append(
            "<div><label for='ei_eventstarttime'><?php _e('start time', 'einvitation') ?></label><input class='datepickerstyle' id='ei_eventstarttime' required type='datetime-local' name='ei_eventstarttime[]'><label for='ei_eventendtime'><?php _e('end time', 'einvitation') ?></label><input required class='datepickerstyle' id='ei_eventendtime' type='datetime-local' name='ei_eventendtime[]'><a href='#' onclick='openModel(" +
            x +
            ")'id='myBtn<?php echo $ei_i++; ?>'><?php _e('Select Location', 'einvitation') ?></a><input required id='ei_eventlocationlat" +
            x +
            "' type='text' name='ei_eventlocationlat[]' placeholder='<?php _e('latitude', 'einvitation') ?>'><input required id = 'ei_eventlocationlon" +
            x +
            "' type = 'text' name = 'ei_eventlocationlon[]' required placeholder = '<?php _e('longitude', 'einvitation') ?>'> <a href='#' class='delete'><?php _e('Delete', 'einvitation') ?> </a></div> "

        ); //add input box

    });

    $(wrapper).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });

});
</script>
<?php
}

// define create event custom metaboxes end


// define save event custom metaboxes start
function ei_save_event_postdata($post_id)
{
    if (array_key_exists('ei_eventcategory', $_POST)) {
        update_post_meta(
            $post_id,
            'ei_eventcategory',
            $_POST['ei_eventcategory']
        );
    }
    // for data and time
    if (array_key_exists('ei_eventlocationlat', $_POST)) {
        $ei_locationlat = $_POST['ei_eventlocationlat'];
        $ei_locationlatcount = count($ei_locationlat);
        $eei_eventlocationlatarray = array();
        for ($i = 0; $i < $ei_locationlatcount; $i++) {
            if ($ei_locationlat[$i] != '') :
                array_push($eei_eventlocationlatarray, $ei_locationlat[$i]);
            endif;
        }
        update_post_meta(
            $post_id,
            'ei_eventlocationlat',
            $eei_eventlocationlatarray
        );
    }
    // for data and time
    if (array_key_exists('ei_eventlocationlon', $_POST)) {
        $ei_locationlon = $_POST['ei_eventlocationlon'];
        $ei_locationloncount = count($ei_locationlon);
        $eei_eventlocationlonarray = array();
        for ($i = 0; $i < $ei_locationloncount; $i++) {
            if ($ei_locationlon[$i] != '') :
                array_push($eei_eventlocationlonarray, $ei_locationlon[$i]);
            endif;
        }
        update_post_meta(
            $post_id,
            'ei_eventlocationlon',
            $eei_eventlocationlonarray
        );
    }
    if (array_key_exists('ei_eventstarttime', $_POST)) {
        $ei_starttime = $_POST['ei_eventstarttime'];
        $ei_starttimecount = count($ei_starttime);
        $ei_eventstarttimearray = array();
        for ($i = 0; $i < $ei_starttimecount; $i++) {
            if ($ei_starttime[$i] != '') :
                array_push($ei_eventstarttimearray, $ei_starttime[$i]);
            endif;
        }
        update_post_meta(
            $post_id,
            'ei_eventstarttime',
            $ei_eventstarttimearray
        );
    }
    if (array_key_exists('ei_eventendtime', $_POST)) {
        $ei_endtime = $_POST['ei_eventendtime'];
        $ei_endtimecount = count($ei_endtime);
        $ei_eventendtimearray = array();
        for ($i = 0; $i < $ei_endtimecount; $i++) {
            if ($ei_endtime[$i] != '') :
                array_push($ei_eventendtimearray, $ei_endtime[$i]);
            endif;
        }
        update_post_meta(
            $post_id,
            'ei_eventendtime',
            $ei_eventendtimearray
        );
    }
    if (array_key_exists('ei_eventtype', $_POST)) {
        update_post_meta(
            $post_id,
            'ei_eventtype',
            $_POST['ei_eventtype']
        );
    }
    // for event receiver

    if (array_key_exists('ei_eventreceiver', $_POST)) {
        $eventreceivercount = $_POST['ei_eventreceiver'];
        $receivercount = count($eventreceivercount);
        echo $receivercount;
        $receiverfeatures = array();
        for ($i = 0; $i < $receivercount; $i++) {
            if ($eventreceivercount[$i] != '') :
                array_push($receiverfeatures, $eventreceivercount[$i]);
            endif;
        }
        update_post_meta(
            $post_id,
            'ei_eventreceiver',
            $receiverfeatures
        );
    }
    // for event tags

    if (array_key_exists('tag-input1', $_POST)) {
        update_post_meta(
            $post_id,
            'ei_eventags',
            $_POST['tag-input1']
        );
    }
    // for event attendee    ei_eventattended
    $ei_eventattendingarray = array();
    update_post_meta(
        $post_id,
        'ei_eventattending',
        $ei_eventattendingarray
    );
    // for event  ei_eventattended
    $ei_eventattendedarray = array();
    update_post_meta(
        $post_id,
        'ei_eventattended',
        $ei_eventattendedarray
    );
}
add_action('save_post', 'ei_save_event_postdata');