<?php

$isEdit = $form_type == 'edit';

?>
<form action="<?= $isEdit ? getURL('cms/slide/update') : getURL('cms/slide/add') ?>" id="form-slides" method="POST" style="padding-inline: 0px;">
    <input type="hidden" id="csrf_token_form" name="<?= csrf_token() ?>">
    <input type="hidden" name="id" id="id" value="<?= $isEdit ? encrypting($row->id) : '' ?>">
    <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label class="required">Image</label>
                <div id="file-image"></div>
            </div>
        </div>
        <div class="col-8">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Caption</label>
                        <textarea name="caption" rows="5" id="caption" class="form-input fs-7 w-100" placeholder="e.g Caption 1 2 3" maxlength="200" style="resize: none;"><?= $isEdit ? $row->caption : '' ?></textarea>
                        <div class="dflex align-center justify-end">
                            <span class="fs-7set text-warning">Max. 200 Characters</span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row gutter-sm">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Caption Position</label>
                                <select name="position" id="position" class="form-input fs-7">
                                    <option value=""></option>
                                    <?php if ($isEdit) : ?>
                                        <option value="<?= $row->typecode ?>" selected><?= $row->captionposition ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Slide Type</label>
                                <select name="slidetype" id="slidetype" class="form-input fs-7">
                                    <option value=""></option>
                                    <option value="home" <?= $isEdit && $row->slidetype == 'home' ? 'selected' : '' ?>>Home</option>
                                    <option value="company" <?= $isEdit && $row->slidetype == 'company' ? 'selected' : '' ?>>Company</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label>Sequence</label>
                        <input type="number" name="sequence" id="sequence" class="form-input fs-7 w-100" placeholder="e.g Xx" value="<?= $isEdit ? $row->slideseq : '' ?>">
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
            image: $('#file-image'),
            caption: $('#caption'),
            select: {
                position: $('#position'),
            },
            form: $('#form-slides')
        };

        elements.image.inputFile({
            name: 'image',
            fit: 'contain',
            allowed: ['image/*'],
            width: 250,
            height: 250,
        });

        <?php if ($isEdit && !empty($row->payload->logo)) : ?>
            elements.image.inputFile('files', JSON.parse('<?= $row->payload->logo ?? '[]' ?>'));
        <?php endif ?>

        elements.select.position.initSelect2({
            dropdownParent: '#modaldetail',
            url: '<?= getURL('cms/api/getslide-caption') ?>',
            data: (params) => {
                params.options = {
                    value: 'typecode'
                };
                return params;
            }
        });

        $('#slidetype').initSelect2({
            dropdownParent: '#modaldetail',
        });

        elements.caption.doneTyping(function(el) {
            console.log(el.val());
        });

        elements.form.formSubmit({
            parentNode: '#modaldetail',
            successCallback: (res) => {
                showNotif(res.sukses ? 'success' : 'error', res.pesan);

                if (res.sukses) close_modal('modaldetail');
                if (res.sukses == 1) {
                    tableSlide.ajax.reload(null, false);
                }
            }
        });
    })
</script>