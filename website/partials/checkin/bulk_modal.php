<div id='bulk_modal' class="modal_dialog hidden block_buttons">
    <input type="button" value="Bulk Check-In"
           onclick="bulk_check_in(true);"/>
    <input type="button" value="Bulk Check-In Undo"
           onclick="bulk_check_in(false);"/>
    <br/>
    <input type="button" value="Bulk Renumbering"
           onclick="bulk_numbering();"/>
    <input type="button" value="Bulk Eligibility"
           onclick="bulk_eligibility();"/>
    <br/>
    <input type="button" value="Cancel"
           onclick='close_modal("#bulk_modal");'/>
</div>
