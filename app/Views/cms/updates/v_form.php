<?php

$isEdit = $form_type == 'edit';

?>
<form action="<?= $isEdit ? getURL('cms/the-updates/update') : getURL('cms/the-updates/add') ?>" id="form-product" method="POST" style="padding-inline: 0px;">
    <input type="hidden" id="csrf_token_form" name="<?= csrf_token() ?>">
    <input type="hidden" name="id" id="id" value="<?= $isEdit ? encrypting($row->id) : '' ?>">
    <div class="row w-100">
        <div class="col-4">
            <div class="form-group">
                <label class="required">The Updates Cover</label>
                <div id="file-product"></div>
            </div>
        </div>
        <div class="col-8">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label class="required">Caption Title</label>
                        <input type="text" name="caption" id="caption" class="form-input fs-7" placeholder="e.g Caption 1" value="<?= $isEdit ? $row->caption : '' ?>" required>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="required">Date</label>
                        <input type="text" class="form-input w-100" data-toggle="datepicker" name="update" id="update" placeholder="dd / mm / yyyy" value="<?= $isEdit ? date('d/m/Y', strtotime($row->date)) : date('d/m/Y')  ?>" required />
                    </div>
                </div>
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
            productImage: $('#file-product'),
            caption: $('#caption'),
            select: {
                category: $('#category'),
            },
            form: $('#form-product'),
            datepicker: $('[data-toggle="datepicker"]')
        };

        elements.datepicker.initDateRangePicker({
            singleDatePicker: true,
        })

        elements.productImage.inputFile({
            name: 'image',
            fit: 'contain',
            allowed: ['image/*'],
            width: 250,
            height: 250,
        });

        <?php if ($isEdit && !empty($row->payload->logo)) : ?>
            elements.productImage.inputFile('files', JSON.parse('<?= $row->payload->logo ?? '[]' ?>'));
        <?php endif ?>

        elements.select.category.initSelect2({
            dropdownParent: '#modaldetail',
            url: '<?= getURL('cms/api/getproduct-category') ?>',
            data: (params) => {
                params.options = {
                    value: 'typecode'
                };
                return params;
            }
        });

        elements.form.formSubmit({
            parentNode: '#modaldetail',
            successCallback: (res) => {
                showNotif(res.sukses ? 'success' : 'error', res.pesan);

                if (res.sukses) close_modal('modaldetail');
                if (res.sukses == 1) {
                    tableProduct.ajax.reload(null, false);
                }
            }
        });
    })
</script>