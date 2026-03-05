<?php
// The table of racers can be presented in order by name, car, or class (and
// then by name within the class).  Each sortable column has a header which is a
// link to change the ordering, with the exception that the header for the
// column for ordering currently in use is NOT a link (because it wouldn't do
// anything).
function column_header($text, $o) {
  global $order;
  return "<a data-order='".$o."' "
      .($o == $order ? "" : " href='#'").">".$text."</a>";
}
?>
<div id="main-checkin-table-div">
    <table id="main-checkin-table" class="main_table">
        <thead>
        <tr>
            <th/>
            <th><?php echo column_header(esc($partition_label), 'partition'); ?></th>
            <th><?php echo column_header('Car Number', 'car'); ?></th>
            <th>Photo</th>
            <th><?php echo column_header('Last Name', 'name'); ?></th>
            <th>First Name</th>
            <th>Car Name &amp; From</th>
            <th>Passed?</th>
            <?php if ($use_xbs):?>
                <th><?php echo $xbs_award_name; ?></th>
            <?php endif; ?>
        </tr>
        </thead>

        <tbody id="main_tbody">

        </tbody>
    </table>
</div>

<script>
    function set_checkin_table_height() {
        $("#main-checkin-table-div").height(
            $(window).height() - $(".banner").height() - $("#top-buttons").height());
    }
    $(function() { set_checkin_table_height(); });
    $(window).on('resize', set_checkin_table_height);


    function addrow0(racer) {
        return add_table_row('#main_tbody', racer,
            <?php echo $use_xbs ? json_encode($xbs_award_name) : "false"; ?>);
    }

    <?php
    foreach ($racers as $n => $rs) {
        // TODO
        $rs['rankseq'] = $ranks[$rs['rankid']]['seq'];
        if (is_null($rs['note'])) {
            $rs['note'] = '';
        }
        echo "addrow0(".to_json(json_table_row($rs, $n + 1)).");\n";
    }
    ?>
</script>
