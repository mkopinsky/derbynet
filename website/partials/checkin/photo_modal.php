<div id='photo_modal' class="modal_dialog hidden block_buttons">
    <form id="photo_drop" class="dropzone">
        <input type="hidden" name="action" value="photo.upload"/>
        <input type="hidden" id="photo_modal_repo" name="repo"/>
        <input type="hidden" id="photo_modal_racerid" name="racerid"/>
        <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />

        <h3>Capture <span id="racer_photo_repo"></span>
            photo for <span id="racer_photo_name"></span>
        </h3>

        <video id="preview" autoplay="true" muted="true" playsinline="true"></video>

        <div id="left-photo">

            <?php if ($showSettingsWarning) :?>
                <p class="warning">Check <a href="settings.php">photo directory settings</a> before proceeding!</p>
            <?php endif; ?>
            <div class="block_buttons">
                <input type="submit" value="Capture &amp; Check In" id="capture_and_check_in"
                       onclick='g_check_in = true;'/>
                <br/>
                <input type="submit" value="Capture Only"
                       onclick='g_check_in = false;'/>
                <input type="button" value="Cancel"
                       onclick='close_photo_modal();'/>
            </div>
        </div>
        <div id="right-photo">
            <select id="device-picker"></select>

            <label id="autocrop-label" for="autocrop">Auto-crop after upload:</label>
            <div class="centered_flipswitch">
                <input type="checkbox" class="flipswitch" name="autocrop" id="autocrop" checked="checked"/>
            </div>
            <div>
                <a id="thumb-link" class="button_link">To Photo Page</a>
            </div>
        </div>

        <div class="dz-message"><span>NOTE: You can drop a photo here to upload instead</span></div>
    </form>
</div>
