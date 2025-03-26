<style>
input#input-campaign_password {
    text-indent: 5px;
    -webkit-text-security: disc;
    color: #000;
    font-size: 15px;
  }
</style>
<div id="addNewClinicPopup" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Office</h5>
            <button type="button" class="close modal-close_btn" data-dismiss="modal" aria-label="Close">
                ×
            </button>
        </div>
        <form id="saveClinicFrm" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="csrf_token_1" value="<?php echo $this->security->get_csrf_hash(); ?>">

            <input type="hidden" name="region_id" id="region_id" value="<?php echo $region_id; ?>">

            <input autocomplete="false" name="hidden" type="text" style="display:none;">
            <div class="modal-body">
                <h2>asdfasdfasdf</h2>
            </div>
            <div class="row d-flex justify-content-center">
                <h4 id="mail_success_msg" style="color:green;display: none;"></h4>
                <h4 id="mail_error_msg" style="color:red;display: none;"></h4>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn modal_close_btn pill_btn" data-dismiss="modal">Close</button> <!-- bg-gradient-secondary -->
                <button type="submit" id="save_clinic_btn" class="btn modal_save_btn pill_btn">Save</button>
            </div>
        </form>
    </div>
</div>
<script>
   
   
</script>
