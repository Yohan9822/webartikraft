<?php

$isEdit = $form_type == 'edit';

?>
<form action="<?= $isEdit ? getURL('cms/company/update') : getURL('cms/company/add') ?>" id="form-company" style="padding-inline: 0px;">
    <div class="form-group">
        <input type="hidden" id="companyid" name="companyid" value="<?= $isEdit ? encrypting($row->companyid) : '' ?>">
        <label>Company Name</label>
        <input type="text" class="form-input fs-7" id="companyname" name="companyname" placeholder="@ex: The Knots" value="<?= $isEdit ? $row->companyname : '' ?>" required>
    </div>
    <div class="form-group">
        <label>Address</label>
        <textarea name="address" id="address" class="form-input fs-7" placeholder="@ex: Diamond Street"><?= $isEdit ? $row->address : '' ?></textarea>
    </div>
    <input type="hidden" id="csrf_token_form" name="<?= csrf_token() ?>">
    <div class="modal-footer">
        <button type="button" class="btn btn-warning btn-md dflex align-center" onclick="return resetForm('form-company')">
            <i class="bx bx-revision margin-r-2"></i>
            <span class="fw-normal fs-7">Reset</span>
        </button>
        <button type="submit" class="btn btn-primary btn-md dflex align-center">
            <i class="bx bx-check margin-r-2"></i>
            <span class="fw-normal fs-7"><?= $isEdit ? 'Update' : 'Save' ?></span>
        </button>
    </div>
</form>
<script>
    $(function() {
        $('#form-company').formSubmit({
            parentNode: '#modaldetail',
            successCallback: (res) => {
                showNotif(res.sukses ? 'success' : 'error', res.pesan);

                if (res.sukses) close_modal('modaldetail');
            }
        })
    });
</script>