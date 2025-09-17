<?php

$isEdit = $form_type == 'edit';

?>
<form action="<?= $isEdit ? getURL('cms/categoryproduct/update') : getURL('cms/categoryproduct/add') ?>" id="form-category" method="POST" style="padding-inline: 0px;">
    <input type="hidden" id="csrf_token_form" name="<?= csrf_token() ?>">
    <input type="hidden" name="id" id="id" value="<?= $isEdit ? encrypting($row->id) : '' ?>">
    <div class="row w-100">
        <div class="col-12">
            <div class="form-group">
                <label class="required">Category Name</label>
                <input type="text" name="categoryname" id="categoryname" class="form-input fs-7 w-100" placeholder="e.g Category 1" value="<?= $isEdit ? $row->categoryname : '' ?>" required>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger btn-icon-text btn-xs" onclick="close_modal('modaldetail')">
            <i class="bx bx-x"></i>
            <span class="fw-normal fs-7">Cancel</span>
        </button>
        <button type="submit" class="btn btn-primary btn-icon-text btn-xs margin-l-2">
            <i class="bx bx-check"></i>
            <span class="fw-normal fs-7"><?= $isEdit ? 'Update' : 'Save' ?></span>
        </button>
    </div>
</form>
<script>
    $(function() {
        var elements = {
            form: $('#form-category')
        };

        elements.form.formSubmit({
            parentNode: '#modaldetail',
            successCallback: (res) => {
                showNotif(res.sukses ? 'success' : 'error', res.pesan);

                if (res.sukses) close_modal('modaldetail');
                if (res.sukses == 1) {
                    tableCategory.ajax.reload(null, false);
                }
            }
        });
    })
</script>