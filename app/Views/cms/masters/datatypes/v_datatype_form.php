<?php

$isEdit = $form_type == 'edit';

?>
<form action="<?= $isEdit ? getURL('cms/datatype/update') : getURL('cms/datatype/add') ?>" id="form-type" method="POST" style="padding-inline: 0px;">
    <input type="hidden" id="csrf_token_form" name="<?= csrf_token() ?>">
    <input type="hidden" name="typeid" id="typeid" value="<?= $isEdit ? encrypting($row->typeid) : '' ?>">
    <div class="form-group">
        <label class="required">Category</label>
        <select name="categ" id="categ" class="form-input fs-7" required>
            <option value=""></option>
            <?php if ($isEdit) : ?>
                <option value="<?= $row->catid ?>" selected><?= $row->catname ?></option>
            <?php elseif (!empty($category->id)) : ?>
                <option value="<?= $category->id ?>" selected><?= $category->text ?></option>
            <?php endif ?>
        </select>
    </div>
    <div class="row gutter-sm">
        <div class="col-12">
            <div class="form-group">
                <label>Code (optional)</label>
                <input type="text" class="form-input fs-7 w-100" name="typecode" placeholder="@ex: TP0001, TP0002 ..." value="<?= $isEdit ? $row->typecode : '' ?>" />
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="required">Type Name</label>
                <input type="text" name="typename" id="typename" class="form-input w-100 fs-7" placeholder="@ex: old stuff" value="<?= ($isEdit ? $row->typename : '') ?>" required>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label>Logo</label>
                <div id="file-image"></div>
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

        let elements = {
            image: $('#file-image'),
            select: {
                category: $('#categ'),
            },
            form: $('#form-type')
        };

        elements.image.inputFile({
            name: 'image',
            fit: 'contain',
            allowed: ['image/*'],
            width: 120,
            height: 100,
        });

        <?php if ($isEdit && !empty($row->payload->logo)) : ?>
            elements.image.inputFile('files', JSON.parse('<?= $row->payload->logo ?? '[]' ?>'));
        <?php endif ?>

        elements.select.category.initSelect2({
            dropdownParent: '#modaldetail',
            url: '<?= getURL('cms/api/getcategory') ?>'
        });

        elements.form.formSubmit({
            parentNode: '#modaldetail',
            successCallback: (res) => {
                showNotif(res.sukses ? 'success' : 'error', res.pesan);

                if (res.sukses) close_modal('modaldetail');
            }
        });
    })
</script>