<div id="bulk_details_modal" class="modal_dialog hidden block_buttons">
    <form id="bulk_details">
        <h2 id="bulk_details_title"></h2>

        <label id="who_label" for="bulk_who">Assign car numbers to</label>
        <select id="bulk_who">
            <option value="all">All</option>
            <!-- Replaced by javascript -->
        </select>

        <div id="numbering_controls" class="hidable">
            <label for="number_auto">Numbering:</label>
            <input id="number_auto" name="number_auto"
                   type="checkbox" class="flipswitch eligible-flip"
                   checked="checked"
                   data-wrapper-class="trophy-eligible-flipswitch"
                   data-off-text="Custom"
                   data-on-text="Standard"/>
            <div id="numbering_start_div" style="display: none">
                <label for="bulk_numbering_start">Custom numbering from:</label>
                <input type="number" id="bulk_numbering_start" name="bulk_numbering_start"
                       disabled="disabled"
                       value="<?php echo $car_numbering_smallest; ?>"/>
            </div>
            <div id="bulk_numbering_explanation">
                <p>Car numbers start at <?php echo $car_numbering_smallest; ?>
                        <?php if ($car_numbering_mult != 0): ?><br/>
                        and the hundreds place increments for each <?php echo $partition_label_lc; ?>.
                        <?php else: ?>.
                        <?php endif; ?>
                </p>
            </div>

        </div>

        <div id="elibility_controls" class="hidable">
            <label for="bulk_eligible">Trophy eligibility:</label>
            <input type="checkbox" class="flipswitch eligible-flip"
                   checked="checked"
                   name="bulk_eligible" id="bulk_eligible"
                   data-wrapper-class="trophy-eligible-flipswitch"
                   data-off-text="Excluded"
                   data-on-text="Eligible"/>
        </div>

        <input type="submit"/>
        <input type="button" value="Cancel"
               onclick='pop_modal("#bulk_details_modal");'/>
    </form>
</div>
