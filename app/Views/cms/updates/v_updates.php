<?= $this->extend('cms/template/v_main') ?>

<?= $this->section('content') ?>
<div class="main-content content margin-t-4">
    <div class="card w-100 rounded shadow-sm p-x">
        <div class="card-header dflex justify-end">
            <?php if (getAccess(AccessCode::create)) : ?>
                <button class="btn btn-primary btn-xs btn-icon-text" id="btn-add">
                    <i class="bx bx-plus-circle"></i>
                    <span class="fw-normal fs-7">Add New</span>
                </button>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-master table-sm w-100" id="table-updates">
                <thead>
                    <tr>
                        <th data-width="30" data-orderable="false">No</th>
                        <th data-width="120">Cover</th>
                        <th data-width="175">Caption</th>
                        <th data-width="120">Image Size</th>
                        <th data-width="120">Date</th>
                        <th data-width="50">Active?</th>
                        <th data-width="110">Created</th>
                        <th data-width="110">Updated</th>
                        <th data-width="50" data-orderable="false">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script_javascript') ?>
<script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script type="text/javascript">
    let elements = {
        table: $('#table-updates'),
        button: {
            add: $('#btn-add'),
        }
    };

    elements.button.add.on('click', () => modalForm(
        'Form Slide',
        'modal-xl margin-b-5rem',
        '<?= getURL('cms/the-updates/form') ?>'
    ));

    let tableUpdates = elements.table.initDataTable({
        rowCallback: (row) => {
            let $row = $(row);

            $row.find('[data-toggle="update-image"]').formEditable({
                url: '<?= getURL('cms/the-updates/updatefield') ?>',
                action: 'click',
                value: ($form) => $form.prop('checked'),
            })
        }
    });

    $('#modaldetail').on('hidden.bs.modal', () => tableUpdates.ajax.reload(null, false));
    $('#modaldel').on('hidden.bs.modal', () => tableUpdates.ajax.reload(null, false));
</script>
<?= $this->endSection() ?>