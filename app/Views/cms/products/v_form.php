<?php

$isEdit = $form_type == 'edit';
$sizes = ['large', 'medium', 'small'];
$size_payload = [];
if ($isEdit) {
    if (!empty($row->dimension)) {
        $decodedDim = json_decode($row->dimension, true);
        if (is_array($decodedDim)) {
            $size_payload = $decodedDim;
        }
    } elseif (!empty($row->payload->size)) {
        $size_payload = json_decode($row->payload->size, true);
    }
}

function getSizeValue($payload, $sizeKey, $field)
{
    return isset($payload[$sizeKey][$field]) ? $payload[$sizeKey][$field] : '';
}

function getIsActiveChecked($payload, $sizeKey)
{
    return isset($payload[$sizeKey]['isactive']) && $payload[$sizeKey]['isactive'] == '1' ? 'checked' : '';
}

?>
<form action="<?= $isEdit ? getURL('cms/products/update') : getURL('cms/products/add') ?>" id="form-product" method="POST" style="padding-inline: 0px;">
    <input type="hidden" id="csrf_token_form" name="<?= csrf_token() ?>">
    <input type="hidden" name="id" id="id" value="<?= $isEdit ? encrypting($row->id) : '' ?>">

    <ul class="nav nav-tabs" id="productTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="form-tab" data-bs-toggle="tab" data-bs-target="#form-content" type="button" role="tab" aria-controls="form-content" aria-selected="true">Form</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="size-tab" data-bs-toggle="tab" data-bs-target="#size-content" type="button" role="tab" aria-controls="size-content" aria-selected="false">Size</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="additional-tab" data-bs-toggle="tab" data-bs-target="#additional-content" type="button" role="tab" aria-controls="additional-content" aria-selected="false">Additional Images</button>
        </li>
    </ul>

    <div class="tab-content" id="productTabContent" style="padding-block: 12px;">
        <div class="tab-pane fade show active" id="form-content" role="tabpanel" aria-labelledby="form-tab">
            <div class="row w-100 mt-3">
                <div class="col-4">
                    <div class="form-group">
                        <label class="required">Product Image</label>
                        <div id="file-product"></div>
                    </div>
                </div>
                <div class="col-8" style="padding-left: 12px;">
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
                        <label>Description</label>
                        <textarea name="description" rows="4" id="description" class="form-input fs-7" placeholder="e.g. this product...."><?= $isEdit ? $row->description : '' ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="size-content" role="tabpanel" aria-labelledby="size-tab">
            <div class="row w-100" style="margin-block: 10px;">
                <div class="col-12 mt-3">
                    <label class="required fs-7">Product Variations</label>
                    <table class="table table-bordered table-striped fs-7" style="margin-top: 10px;">
                        <thead>
                            <tr>
                                <th style="width: 15%;">Size</th>
                                <th>Dimension (e.g. 250x180x140)</th>
                                <th style="width: 20%;">Weight</th>
                                <th>Color</th>
                                <th style="width: 10%; text-align: center;">Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sizes as $sizeKey) : ?>
                                <tr>
                                    <td class="text-capitalize align-middle">
                                        <span class="fw-bold"><?= ucfirst($sizeKey) ?></span>
                                    </td>

                                    <td class="align-middle">
                                        <input type="text" name="size[<?= $sizeKey ?>][size]" class="form-input fs-7 w-100"
                                            value="<?= getSizeValue($size_payload, $sizeKey, 'size') ?>"
                                            placeholder="e.g. 250x180x140 mm">
                                    </td>

                                    <td class="align-middle">
                                        <input type="text" name="size[<?= $sizeKey ?>][weight]" class="form-input fs-7 w-100"
                                            value="<?= getSizeValue($size_payload, $sizeKey, 'weight') ?>"
                                            placeholder="e.g. 5">
                                    </td>

                                    <td class="align-middle">
                                        <input type="text" name="size[<?= $sizeKey ?>][color]" class="form-input fs-7 w-100"
                                            value="<?= getSizeValue($size_payload, $sizeKey, 'color') ?>"
                                            placeholder="e.g. Black, White">
                                    </td>

                                    <td class="align-middle text-center">
                                        <input type="hidden" name="size[<?= $sizeKey ?>][isactive]" value="0"> <input type="checkbox" name="size[<?= $sizeKey ?>][isactive]" value="1" class="form-check-input"
                                            <?= getIsActiveChecked($size_payload, $sizeKey) ?>>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="additional-content" role="tabpanel" aria-labelledby="additional-tab">
            <div class="row w-100 mt-3">
                <div class="col-12">
                    <div class="form-group">
                        <label>Additional Images</label>
                        <div id="file-additional"></div>
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
        $('#file-additional').inputFile({
            name: 'additional_images[]',
            fit: 'contain',
            allowed: ['image/*'],
            width: 250,
            height: 250,
            multiple: true
        });

        <?php if ($isEdit && !empty($row->payload->logo)) : ?>
            elements.productImage.inputFile('files', JSON.parse('<?= $row->payload->logo ?? '[]' ?>'));
        <?php endif ?>
        <?php if ($isEdit && !empty($row->additionalimages)) :
            $additionalArr = json_decode($row->additionalimages, true);
            $additionalArr = is_array($additionalArr) ? array_map(function ($v) {
                return getURL('public/uploads/products/' . basename($v));
            }, $additionalArr) : [];
        ?>
            $('#file-additional').inputFile('files', <?= json_encode($additionalArr) ?>);
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