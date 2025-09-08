<?= $this->extend('cms/template/v_main') ?>

<?= $this->section('content') ?>
<div class="main-content content margin-t-4">
    <div class="card w-100 rounded shadow-sm p-x">
        <div class="row gutter-sm">
            <div class="col-3">
                <div class="form-group">
                    <label>Category</label>
                    <select class="form-input" id="select-category"></select>
                </div>
            </div>
            <div class="col-3">
                <div class="dflex margin-t-20p">
                    <button type="button" class="btn btn-primary btn-icon-text btn-xs" id="btn-filter">
                        <i class="bx bx-filter"></i>
                        <span>Filter</span>
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-icon-text btn-xs margin-l-2" id="btn-clear-filter">
                        <i class="bx bx-x"></i>
                        <span>Clear Filter</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="dflex justify-end">
            <?php if (getAccess(AccessCode::create)) : ?>
                <button class="btn btn-primary btn-icon-text btn-xs" id="btn-add">
                    <i class="bx bx-plus-circle margin-r-2"></i>
                    <span class="fw-normal fs-7">Add New</span>
                </button>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm w-100" id="table-datatype">
                <thead>
                    <tr>
                        <th data-width="30" data-sortable="false">No</th>
                        <th data-width="150">Code</th>
                        <th>Name</th>
                        <th data-width="150">Category</th>
                        <th data-width="150">Created At</th>
                        <th data-width="150">Created By</th>
                        <th data-width="150">Updated At</th>
                        <th data-width="150">Updated By</th>
                        <th data-width="100" data-sortable="false">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script_javascript') ?>
<script type="text/javascript">
    let elements = {
        select: {
            category: $('#select-category')
        },
        table: {
            datatype: $('#table-datatype')
        },
        button: {
            add: $('#btn-add'),
            filter: $('#btn-filter'),
            clearFilter: $('#btn-clear-filter')
        }
    };

    elements.button.add.on('click', () => {
        modalForm(
            'Form Data Type',
            'modal-md',
            '<?= getURL('cms/datatype/form') ?>', {
                category: JSON.stringify(elements.select.category.initSelect2('data'))
            }
        );
    });

    elements.button.filter.on('click', () => {
        tableType.ajax.reload(null, false);
    });

    elements.button.clearFilter.on('click', () => {
        elements.select.category.val(null).trigger('change');

        tableType.ajax.reload(null, false);
    });

    elements.select.category.initSelect2({
        url: '<?= getURL('cms/api/getcategory') ?>',
    });

    let tableType = elements.table.datatype.initDataTable({
        url: '<?= current_url(true) ?>/table',
        data: function(params) {
            params.filter = {
                categoryid: elements.select.category.val(),
            };
            return params;
        },
    });

    $('#modaldetail').on('hidden.bs.modal', () => {
        tableType.ajax.reload(null, false);
    });

    $('#modaldel').on('hidden.bs.modal', () => {
        tableType.ajax.reload(null, false);
    })
</script>
<?= $this->endSection() ?>