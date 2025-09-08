<?php if (getAccess(AccessCode::create)) : ?>
    <form action="<?= getURL("cms/menu/features/add") ?>" method="post" class="no-padding" id="form-features">
        <input type="hidden" name="menuid" value="<?= encrypting($menuid) ?>" />
        <div class="row gutter-sm">
            <div class="col-2">
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" name="code" class="form-input w-100" placeholder="Code" />
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-input w-100" placeholder="Name" />
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="description" class="form-input w-100" placeholder="Description" />
                </div>
            </div>
            <div class="col-2">
                <div class="margin-t-20p">
                    <button type="submit" class="btn btn-primary btn-xs btn-icon-text">
                        <i class="bx bx-plus-circle"></i>
                        <span>Add Feature</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="margin-b-1">
        <button type="button" class="btn btn-outline-primary btn-icon-text btn-xs" id="btn-add-view">
            <i class="bx bx-plus-circle"></i>
            <span>Add View</span>
        </button>
        <button type="button" class="btn btn-outline-primary btn-icon-text btn-xs margin-l-2" id="btn-add-crud">
            <i class="bx bx-plus-circle"></i>
            <span>Add CRUD</span>
        </button>
        <button type="button" class="btn btn-outline-primary btn-icon-text btn-xs margin-l-2" id="btn-add-import-excel">
            <i class="bx bx-plus-circle"></i>
            <span>Add Import Excel</span>
        </button>
        <button type="button" class="btn btn-outline-primary btn-icon-text btn-xs margin-l-2" id="btn-add-export-excel">
            <i class="bx bx-plus-circle"></i>
            <span>Add Export Excel</span>
        </button>
        <button type="button" class="btn btn-outline-primary btn-icon-text btn-xs margin-l-2" id="btn-add-release">
            <i class="bx bx-plus-circle"></i>
            <span>Add Release</span>
        </button>
        <button type="button" class="btn btn-outline-primary btn-icon-text btn-xs margin-l-2" id="btn-add-history">
            <i class="bx bx-plus-circle"></i>
            <span>Add History</span>
        </button>
    </div>
<?php endif ?>
<table class="table table-bordered table-sm fs-7 w-100" id="table-features">
    <thead>
        <tr>
            <th data-width="30">No</th>
            <th data-width="50">Code</th>
            <th data-width="100">Name</th>
            <th>Description</th>
            <th data-width="50">Active?</th>
            <th data-width="50">Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<script type="text/javascript">
    $(function() {
        let elements = {
            form: $('#form-features'),
            table: $('#table-features'),
            features: {
                addView: $('#btn-add-view'),
                addCrud: $('#btn-add-crud'),
                addImportExcel: $('#btn-add-import-excel'),
                addExportExcel: $('#btn-add-export-excel'),
                addRelease: $('#btn-add-release'),
                addHistory: $("#btn-add-history"),
            }
        };

        let tableFeature = elements.table.initDataTable({
            url: '<?= getURL('cms/menu/features/table') ?>',
            data: function(params) {
                params.menuid = '<?= encrypting($menuid) ?>';
                return params;
            },
            rowCallback: (row) => {
                let $row = $(row);

                $row.find('[data-toggle="feature"]').formEditable({
                    url: '<?= getURL('cms/menu/features/updatefield') ?>',
                    action: 'click',
                    value: ($form) => $form.prop('checked'),
                });
            }
        });

        elements.form.formSubmit({
            parentNode: $('#modaldetail'),
            successCallback: (res) => {
                tableFeature.ajax.reload(null, false);
                elements.form.get(0).reset();
            }
        });

        elements.features.addView.on('click', () => addTemplate('view'));
        elements.features.addCrud.on('click', () => addTemplate('crud'));
        elements.features.addImportExcel.on('click', () => addTemplate('import-excel'));
        elements.features.addExportExcel.on('click', () => addTemplate('export-excel'));
        elements.features.addRelease.on('click', () => addTemplate('release'));
        elements.features.addHistory.on('click', () => addTemplate('history'));

        $('#modaldel').on('hidden.bs.modal', () => {
            tableFeature.ajax.reload(null, false);
        });

        function addTemplate(key) {
            $.ajax({
                url: '<?= getURL('cms/menu/features/add-template') ?>',
                type: 'post',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
                    menuid: '<?= encrypting($menuid) ?>',
                    templatekey: key,
                },
                dataType: 'json',
                success: (res) => {
                    tableFeature.ajax.reload(null, false);
                    elements.form.get(0).reset();
                },
                error: () => {}
            })
        }
    });
</script>