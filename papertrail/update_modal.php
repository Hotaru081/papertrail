<!-- update_modal.php -->

<div id="updateModal_<?php echo $timestamp; ?>" class="custom-modal">
    <div class="modal-content">
        <h1 style="color: #2667a0;">Update Attachment</h1>

        <?php
        // Fetch details for the selected attachment
        $details_query_modal = mysqli_query($conn, "SELECT particulars, papertype FROM attachments WHERE pno = '$pno' AND timestamp = '$timestamp'");
        $details_row_modal = mysqli_fetch_array($details_query_modal);
        $particulars_modal = $details_row_modal['particulars'];
        $papertype_modal = $details_row_modal['papertype'];
        ?>

        <form action="update_data.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="pno" value="<?php echo $pno; ?>">
            <input type="hidden" name="timestamp" value="<?php echo $timestamp; ?>">
            <input type="hidden" name="particulars" value="<?php echo $particulars_modal; ?>"><br>
            <input type="hidden" name="papertype" value="<?php echo $papertype_modal; ?>"><br>

            <label style="font-size: 25px;" for="new_files">New Files (Image/PDF):</label><br>
            <input style="margin-left: 22%; font-size: 20px; margin-top: 10px" type="file" name="new_files[]" multiple accept="image/*,application/pdf"><br>

            <div style="margin-top: 30px;">
            <input class="btn3" type="submit" value="Update"><br>
            <button class="btn4" style="margin-top: 5px" type="button" onclick="closeCustomModal('updateModal_<?php echo $timestamp; ?>')">Cancel</button>
            </div>
        </form>
    </div>
</div>
