<?php

$isEdit = $form_type == 'edit';
$isMaster = $isEdit && empty($row->masterid);

?>
<form action="<?= $isEdit ? getURL('cms/menu/update') : getURL('cms/menu/add') ?>" id="form-menu" style="padding-inline: 0px !important;">
    <div class="form-group">
        <label for="masters">With Master ? <input type="checkbox" class="form-input" id="masters" onclick="check_master(this)" <?= $isEdit ? (!$isMaster ? 'checked' : '') : '' ?>></label>
        <input type="hidden" id="menuid" name="menuid" value="<?= $isEdit ? encrypting($row->menuid) : '' ?>">
    </div>
    <div class="form-group">
        <label>Master Menu</label>
        <select name="masterid" id="masterid" class="form-input" style="width: 100% !important" <?= ($isEdit) ? (!$isMaster ? '' : 'disabled') : 'disabled' ?>>
            <?php if ($isEdit) : ?>
                <option value="<?= encrypting($row->masterid) ?>" selected><?= $row->mastername ?></option>
            <?php endif ?>
        </select>
    </div>
    <div class="form-group">
        <label>Menu Name :</label>
        <input type="text" class="form-input" name="menuname" id="menuname" value="<?= $isEdit ? $row->menuname : '' ?>" placeholder="@ex: Company Master" required>
    </div>
    <div class="form-group">
        <label>Menu Link :</label>
        <input type="text" class="form-input" name="menulink" id="menulink" value="<?= $isEdit ? $row->menulink : '' ?>" placeholder="@ex: company" required>
    </div>
    <div class="form-group">
        <label>Menu Icon :</label>
        <input type="text" class="form-input" name="menuicon" id="menuicon" value="<?= $isEdit ? $row->menuicon : '' ?>" placeholder="@ex: bx bx-building">
    </div>
    <input type="hidden" name="<?= csrf_token() ?>" id="csrf_token_form">
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-md btn-icon-text" onclick="close_modal('modaldetail')">
            <i class="bx bx-x margin-r-2"></i><span class="fw-normal fs-7">Cancel</span>
        </button>
        <button type="submit" class="btn btn-primary btn-md btn-icon-text">
            <i class="bx bx-save margin-r-2"></i>
            <span class="fw-normal fs-7"><?= ($isEdit ? 'Update' : 'Save') ?></span>
        </button>
    </div>
</form>
<script>
    $(document).ready(function() {

        $('#form-menu').formSubmit({
            parentNode: '#modaldetail',
            successCallback: (res) => {
                showNotif(res.sukses ? 'success' : 'error', res.pesan);

                close_modal('modaldetail');
                refresh_tablemaster();
            },
        });

        $('#masterid').initSelect2({
            url: '<?= getURL('cms/api/menu/get-master') ?>',
            dropdownParent: $('#modaldetail'),
        });
    })

    function check_master(elem) {
        if ($(elem).is(':checked')) {
            $("#masterid").removeAttr('disabled');
        } else {
            $("#masterid").val(null).trigger('change')
            $("#masterid").attr('disabled', 'disabled');
        }
    }
</script>