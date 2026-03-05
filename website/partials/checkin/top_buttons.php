<div id="top-buttons" class="block_buttons">
    <img id="barcode-button" src="img/barcode.png"
         onclick="handle_barcode_button_click()"/>
    <input id="mobile-button" type="button" value="Mobile"
           onclick="handle_qrcode_button_click()"/>
    <input class="bulk_button"
           type="button" value="Bulk"
           onclick='show_bulk_form();'/>
    <?php if ($include_new_racer_button): ?>
        <input type="button" value="New Racer"
               onclick='show_new_racer_form();'/>
    <?php else: ?>
        <div style='padding: 10px 15px; font-size: x-large; line-height: 1.3; margin-bottom: 20px; margin-top: 3px; '>&nbsp;</div>
    <?php endif; ?>
</div>
