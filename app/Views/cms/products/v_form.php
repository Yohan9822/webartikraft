<?php

$isEdit = $form_type == 'edit';

?>
<form action="<?= $isEdit ? getURL('cms/products/update') : getURL('cms/products/add') ?>" id="form-product" method="POST" style="padding-inline: 0px;">
    <input type="hidden" id="csrf_token_form" name="<?= csrf_token() ?>">
    <input type="hidden" name="id" id="id" value="<?= $isEdit ? encrypting($row->id) : '' ?>">
    <div class="row w-100">
        <div class="col-4">
            <div class="form-group">
                <label class="required">Product Image</label>
                <div id="file-product"></div>
            </div>
        </div>
        <div class="col-8">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label class="required">Category</label>
                        <select name="category" id="category" class="form-input fs-7" required>
                            <option value=""></option>
                            <?php if ($isEdit) : ?>
                                <option value="<?= $row->typecode ?>" selected><?= $row->categoryname ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="required">Product Name</label>
                        <input type="text" name="productname" id="productname" class="form-input fs-7" placeholder="e.g Product 1" value="<?= $isEdit ? $row->productname : '' ?>" required>
                    </div>
                </div>
                <!-- <div class="col-12">
                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" name="price" id="price" onkeyup="price_keyup(this)" class="form-input fs-7" placeholder="e.g Xxxxxx" value="<?= $isEdit ? $row->price : '' ?>">
                    </div>
                </div> -->
                <div class="col-12">
                    <div class="form-group">
                        <label class="required">Material</label>
                        <select name="material" id="material" class="form-input fs-7" required>
                            <option value=""></option>
                            <?php if ($isEdit) : ?>
                                <option value="<?= $row->materialcode ?>" selected><?= $row->materialname ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 dflex flex-column">
            <div class="form-group">
                <label>Dimension</label>
                <textarea name="dimension" id="dimension" rows="3" class="form-input fs-7" placeholder="e.g 250x180x140 mm"><?= $isEdit ? $row->dimension : '' ?></textarea>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="4" id="description" class="form-input fs-7" placeholder="e.g. this product...."><?= $isEdit ? $row->description : '' ?></textarea>
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
                material: $('#material')
            },
            form: $('#form-product')
        };

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
        elements.select.material.initSelect2({
            dropdownParent: '#modaldetail',
            url: '<?= getURL('cms/api/getproduct-material') ?>',
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