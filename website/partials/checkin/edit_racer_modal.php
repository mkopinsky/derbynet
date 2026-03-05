<div id='edit_racer_modal' class="modal_dialog hidden block_buttons">
  <form id="editracerform">
    <div id="left-edit">
      <label for="edit_firstname">First name:</label>
      <input id="edit_firstname" type="text" name="edit_firstname" value=""/>
      <label for="edit_lastname">Last name:</label>
      <input id="edit_lastname" type="text" name="edit_lastname" value=""/>

      <label for="edit_carno">Car number:</label>
      <input id="edit_carno" type="text" name="edit_carno" value=""/>

      <label for="edit_carname">Car name:</label>
      <input id="edit_carname" type="text" name="edit_carname" value=""/>
    </div>

    <div id="right-edit">
      <label for="edit_partition">
        <?php echo esc($partition_label.':'); ?>
      </label>
      <!-- Populated by javascript -->
      <select id="edit_partition" data-wrapper-class="partition_mselect"></select>

      <label for="edit_note_from">From (if desired):</label>
      <input id="edit_note_from" type="text" name="edit_note_from" value=""/>

      <label for="eligible">Trophy eligibility:</label>
      <input type="checkbox" class="flipswitch" name="eligible" id="eligible"
            data-wrapper-class="trophy-eligible-flipswitch"
            data-off-text="Excluded"
            data-on-text="Eligible"/>
      <br/>

      <input type="submit"/>
      <input type="button" value="Cancel"
        onclick='close_modal("#edit_racer_modal");'/>

      <div id="delete_racer_extension">
        <input type="button" value="Delete Racer"
           class="delete_button"
           onclick="handle_delete_racer();"/>
      </div>
    </div>

  <input id="edit_racer" type="hidden" name="racer" value=""/>

</form>
</div>
<script>
    // Populate dropdown in modals with partition list
    $(function () {
        var partitions = <?php echo to_json($partitions); ?>;
        var partition_label_pl = <?php echo to_json($partition_label_pl); ?>;

        $("#edit_partition").empty();
        for (var i in partitions) {
            var opt = $("<option/>")
                .attr('value', partitions[i].partitionid)
                .text(partitions[i].name);
            opt.appendTo("#edit_partition");
            opt.clone().appendTo("#bulk_who");
        }
        var opt = $("<option/>")
            .attr('value', -1)
            .text("(Edit " + partition_label_pl + ")");
        opt.appendTo("#edit_partition");
        opt.clone().appendTo("#bulk_who");

        mobile_select_refresh($("#edit_partition"));
        mobile_select_refresh($("#bulk_who"));

        {
            var reorder_modal = PartitionsModal(
                "<?php echo esc(partition_label()); ?>",
                "<?php echo esc(partition_label_pl()); ?>",
                partitions, callback_after_partition_modal);

            $("#edit_partition").on('change', function(ev) { on_edit_partition_change(ev.target, reorder_modal); });
            $("#bulk_who").on('change', function(ev) { on_edit_partition_change(ev.target, reorder_modal); });
        }

    });
</script>
