<?php

$isEdit = $form_type == 'edit';

?>
<form action="<?= $isEdit ? getURL('cms/user/update') : getURL('cms/user/add') ?>" id="form-user" style="padding-inline: 0px;">
    <div class="form-group">
        <?php if ($isEdit) : ?>
            <input type="hidden" id="password_lama" name="password_lama" value="<?= $row->password ?>">
            <input type="hidden" id="id" name="id" value="<?= $isEdit ? $row->userid : '' ?>">
            <input type="hidden" id="username_old" name="username_old" value="<?= $isEdit ? $row->username : '' ?>">
        <?php endif ?>
        <label>Name :</label>
        <input type="text" class="form-input fs-7" id="name" name="name" value="<?= $isEdit ? $row->name : '' ?>" placeholder="@ex: Admin Staff">
    </div>
    <div class="form-group">
        <label>Username :</label>
        <input type="text" class="form-input fs-7" id="username" name="username" value="<?= $isEdit ? $row->username : '' ?>" placeholder="@ex: admin##">
    </div>
    <div class="form-group">
        <label>Password :</label>
        <input type="password" class="form-input fs-7" id="password" name="password" <?= $isEdit ? '' : 'required' ?> placeholder="••••••••••••">
    </div>
    <input type="hidden" id="csrf_token_form" name="<?= csrf_token() ?>">
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger btn-icon-text btn-xs" onclick="close_modal('modaldetail')">
            <i class="bx bx-x"></i>
            <span class="fw-normal fs-7">Cancel</span>
        </button>
        <button type="submit" class="btn btn-primary btn-icon-text btn-xs">
            <i class="bx bx-check"></i>
            <span class="fw-normal fs-7"><?= $isEdit ? 'Update' : 'Save' ?></span>
        </button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('#form-user').formSubmit({
            parentNode: $('#modaldetail'),
            successCallback: (res) => {
                showNotif(res.sukses ? 'success' : 'error', res.pesan);

                if (res.sukses) close_modal('modaldetail');
            }
        });
    })
</script>