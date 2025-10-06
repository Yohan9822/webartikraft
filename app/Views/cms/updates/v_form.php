<?php
$isEdit = $form_type == 'edit';
?>

<form action="<?= $isEdit ? getURL('cms/the-updates/update') : getURL('cms/the-updates/add') ?>" id="form-product" method="POST" style="padding-inline: 0px;">
    <input type="hidden" id="csrf_token_form" name="<?= csrf_token() ?>">
    <input type="hidden" name="id" id="id" value="<?= $isEdit ? encrypting($row->id) : '' ?>">

    <ul class="nav nav-tabs" style="margin-bottom: 1rem;" id="tabMenu" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="form-tab" data-bs-toggle="tab" data-bs-target="#formTab" type="button" role="tab" aria-controls="formTab" aria-selected="true">
                Form
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detailTab" type="button" role="tab" aria-controls="detailTab" aria-selected="false">
                Detail
            </button>
        </li>
    </ul>

    <div class="tab-content" id="tabContent">
        <div class="tab-pane fade show active" id="formTab" role="tabpanel" aria-labelledby="form-tab">
            <div class="row w-100">
                <div class="col-4" style="width: max-content;">
                    <div class="form-group">
                        <label class="required">The Updates Cover</label>
                        <div id="file-product"></div>
                    </div>
                </div>
                <div class="col-8" style="padding-left: 12px;">
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
                                <input type="text" class="form-input w-100" data-toggle="datepicker" name="update" id="update" placeholder="dd / mm / yyyy" value="<?= $isEdit ? date('d/m/Y', strtotime($row->date)) : date('d/m/Y') ?>" required />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="detailTab" role="tabpanel" aria-labelledby="detail-tab">
            <div class="row w-100">
                <div class="col-12">
                    <div class="form-group">
                        <label>Detail Content</label>
                        <textarea name="description" id="description" class="form-input w-100" rows="8"><?= $isEdit ? ($row->description ?? '') : '' ?></textarea>
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
            detailFile: $('#file-detail'),
            caption: $('#caption'),
            form: $('#form-product'),
            datepicker: $('[data-toggle="datepicker"]'),
            description: $('#description')
        };

        CKEDITOR.replace('description', {
            versionCheck: false,
            height: 600,
            extraPlugins: 'filebrowser',
            filebrowserUploadUrl: '<?= getURL("cms/the-updates/upload") ?>',
            filebrowserBrowseUrl: '<?= getURL("cms/the-updates/browse") ?>'
        });

        elements.datepicker.initDateRangePicker({
            singleDatePicker: true,
        });

        elements.productImage.inputFile({
            name: 'image',
            fit: 'contain',
            allowed: ['image/*'],
            width: 250,
            height: 250,
        });

        elements.detailFile.inputFile({
            name: 'detail_file',
            fit: 'contain',
            allowed: ['application/pdf', 'image/*'],
            multiple: false,
            width: 250,
            height: 250,
        });

        <?php if ($isEdit && !empty($row->payload->logo)) : ?>
            elements.productImage.inputFile('files', JSON.parse('<?= $row->payload->logo ?? '[]' ?>'));
        <?php endif ?>

        elements.form.formSubmit({
            parentNode: '#modaldetail',
            beforeSubmit: () => {
                console.log('Before Submit Called');

                const contentData = CKEDITOR.instances.description.getData();
                console.log('CKEditor Data:', contentData);

                elements.form.find('[name="description"]').val(contentData);
                return true;
            },
            successCallback: (res) => {
                showNotif(res.sukses ? 'success' : 'error', res.pesan);
                if (res.sukses) close_modal('modaldetail');
                if (res.sukses == 1) {
                    tableProduct.ajax.reload(null, false);
                }
            }
        });
    });
</script>