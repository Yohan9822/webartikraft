<?php

$isEdit = $form_type == 'edit';

?>
<form action="<?= $isEdit ? getURL('cms/usergroup/update') : getURL('cms/usergroup/add') ?>" id="form-usergroup" style="padding-inline: 0px;">
    <div class="form-group">
        <input type="hidden" id="groupid" name="groupid" value="<?= $isEdit ? encrypting($row->groupid) : '' ?>">
        <label>Usergroup Name <span class="text-danger">*</span></label>
        <input type="text" class="form-input fs-7" id="groupname" name="groupname" value="<?= $isEdit ? $row->groupname : '' ?>" placeholder="@ex: Admin" required>
    </div>
    <input type="hidden" id="csrf_token_form" name="<?= csrf_token() ?>">
    <div class="modal-footer">
        <button type="button" class="btn btn-warning dflex align-center" onclick="return resetForm('form-usergroup')">
            <i class="bx bx-revision margin-r-2"></i>
            <span class="fw-normal fs-7">Reset</span>
        </button>
        <button type="submit" class="btn btn-primary dflex align-center">
            <i class="bx bx-check margin-r-2"></i>
            <span class="fw-normal fs-7"><?= ($isEdit ? 'Update' : 'Save') ?></span>
        </button>
    </div>
</form>
<script>
    $(function() {
        $("#form-usergroup").formSubmit({
            parentNode: $('#modaldetail'),
            successCallback: (res) => {
                showNotif(res.sukses ? 'success' : 'error', res.pesan);

                if (res.sukses) close_modal('modaldetail');
            }
        });
    });
</script>