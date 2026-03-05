<?php @session_start(); ?>
<?php
require_once('inc/data.inc');
require_once('inc/authorize.inc');
session_write_close();
require_once('inc/banner.inc');
require_once('inc/car-numbering.inc');
require_once('inc/schema_version.inc');
require_once('inc/photo-config.inc');
require_once('inc/classes.inc');
require_once('inc/partitions.inc');
require_once('inc/locked.inc');
require_once('inc/checkin-table.inc');
require_once('inc/checkin-table-data.inc');
require_once('partials/partials_helper.inc');

require_permission(CHECK_IN_RACERS_PERMISSION);

// This is the racer check-in page.  It appears as a table of all the registered
// racers, with a flipswitch for each racer.  Clicking on the check-in button
// invokes some javascript that sends an ajax POST request to check-in (or
// un-check-in) that racer.  See checkin.js.

// In addition to the actual check-in, it's possible to change a
// racer's car number from this form, or mark the racer for our
// "exclusively by scout" award.

// Here on the server side, a GET request sends HTML for the whole
// page.  POST requests to make changes to the database are sent to
// action.php, and produce just a small XML document.

// Our pack provides an "exclusively by scout" award, based on a
// signed statement from the parent.  Collecting the statement is part
// of the check-in process, so there's provision for a checkbox on the
// check-in form.  For groups that don't do this, $xbs will be false
// (and $xbs_award_name will be blank), and the checkboxes won't be
// shown.
$xbs = read_raceinfo_boolean('use-xbs');
$xbs_award_name = xbs_award();

$order = '';
if (isset($_GET['order']) && in_array($_GET['order'], ['name', 'class', 'car', 'partition']))
  $order = $_GET['order'];
if (!$order)
    $order = 'name';


function to_json($array) {
    return json_encode($array, JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES |
            JSON_HEX_AMP | JSON_HEX_TAG | JSON_HEX_APOS);
}

?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Check-In</title>
<link rel="stylesheet" type="text/css" href="css/dropzone.min.css"/>
<link rel="stylesheet" type="text/css" href="css/mobile.css"/>
<?php require('inc/stylesheet.inc'); ?>
<link rel="stylesheet" type="text/css" href="css/main-table.css"/>
<link rel="stylesheet" type="text/css" href="css/checkin.css"/>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/qrcode.min.js"></script>
<script type="text/javascript" src="js/ajax-setup.js"></script>
<script type="text/javascript">
var g_order = '<?php echo $order; ?>';
var g_action_on_barcode = "<?php
  echo isset($_SESSION['barcode-action']) ? $_SESSION['barcode-action'] : "locate";
?>";

var g_preferred_urls = <?php echo json_encode(preferred_urls(/*use_https=*/true),
                                              JSON_HEX_TAG | JSON_HEX_AMP | JSON_PRETTY_PRINT); ?>;

</script>
<script type="text/javascript" src="js/mobile.js"></script>
<script type="text/javascript" src="js/dashboard-ajax.js"></script>
<script type="text/javascript" src="js/modal.js"></script>
<script type="text/javascript" src="js/dropzone.min.js"></script>
<script type="text/javascript" src="js/partitions-modal.js"></script>
<script type="text/javascript" src="js/video-device-picker.js"></script>
<script type="text/javascript" src="js/imagecapture.js"></script>
<script type="text/javascript" src="js/photo-capture-modal.js"></script>
<script type="text/javascript" src="js/find-racer.js"></script>
<script type="text/javascript" src="js/checkin.js"></script>
</head>
<body>
<?php
make_banner('Racer Check-In');

echo include_partial('partials/checkin/top_buttons.php', array(
        'include_new_racer_button' => have_permission(REGISTER_NEW_RACER_PERMISSION),
));

// Main check-in table

list($classes, $classseq, $ranks, $rankseq) = classes_and_ranks();
$racers = get_racers($order);

echo include_partial('partials/checkin/main_checkin_table.php', array(
        'use_xbs' => $xbs,
        'xbs_award_name' => $xbs_award_name,
        'partition_label' => partition_label(),
        'racers' => $racers,
        'ranks' => $ranks
));

?>

<?php
// Modals
echo include_partial('partials/checkin/edit_racer_modal.php', array(
        'partitions' => get_partitions(),
        'partition_label' => partition_label(),
        'partition_label_pl' => partition_label_pl(),
));
echo include_partial('partials/checkin/photo_modal.php', array(
        'showSettingsWarning' => headshots()->status() != 'ok',
));
echo include_partial('partials/checkin/bulk_modal.php');

list($car_numbering_mult, $car_numbering_smallest) = read_car_numbering_values();
echo include_partial('partials/checkin/bulk_renumbering_modal.php', array(
        'car_numbering_mult' => $car_numbering_mult,
        'car_numbering_smallest' => $car_numbering_smallest,
        'partition_label_lc' => partition_label_lc()
));

echo include_partial('partials/checkin/barcode_settings_modal.php');
echo include_partial('partials/checkin/qrcode_settings_modal.php');

?>

<?php require_once('inc/ajax-pending.inc'); ?>

<div id="find-racer" class="hidden">
  <div id="find-racer-form">
    Find Racer:
    <input type="text" id="find-racer-text" name="narrowing-text" class="not-mobile"/>
    <span id="find-racer-message"
        ><span id="find-racer-index" data-index="1">1</span>
        of
        <span id="find-racer-count">0</span>
    </span>
    <img onclick="cancel_find_racer()" src="img/cancel-20.png"/>
  </div>
</div>

</body>
</html>
