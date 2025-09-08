<?php

$isEdit = $form_type == 'edit';

?>
<form action="<?= $isEdit ? getURL('cms/category/update') : getURL('cms/category/add') ?>" id="form-scateg" method="POST" style="padding-inline: 0px;">
    <input type="hidden" id="csrf_token_form" name="<?= csrf_token() ?>">
    <div class="form-group">
        <label>Code (optional)</label>
        <input type="text" class="form-input w-100" name="catcode" placeholder="@ex: C0001, C0002 ..." value="<?= $isEdit ? $row->catcode : '' ?>" />
    </div>
    <div class="form-group">
        <label>Category Name <span class="text-danger">*</span></label>
        <input type="hidden" name="catid" id="catid" value="<?= $isEdit ? encrypting($row->catid) : '' ?>">
        <input type="text" name="catname" id="catname" class="form-input fs-7" placeholder="@ex: security" value="<?= $isEdit ? $row->catname : '' ?>">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-warning btn-md dflex align-center" onclick="return resetForm('form-scateg')">
            <i class="bx bx-revision margin-r-2"></i>
            <span class="fw-normal fs-7">Reset</span>
        </button>
        <button type="submit" class="btn btn-primary btn-md dflex align-center">
            <i class="bx bx-check margin-r-2"></i>
            <span class="fw-normal fs-7"><?= $isEdit ? 'Update' : 'Save' ?></span>
        </button>
    </div>
</form>
<script type="text/javascript">
    $(function() {
        $('#form-scateg').formSubmit({
            parentNode: '#modaldetail',
            successCallback: (res) => {
                showNotif(res.sukses ? 'success' : 'error', res.pesan);

                if (res.sukses) close_modal('modaldetail');
            }
        })
    });
</script>