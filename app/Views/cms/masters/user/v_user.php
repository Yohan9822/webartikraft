<?= $this->extend('cms/template/v_main') ?>

<?= $this->section('content') ?>
<div class="main-content content margin-t-4">
    <div class="card p-x shadow-sm w-100">
        <div class="card-header dflex align-center justify-end">
            <?php if (getAccess(AccessCode::create)) : ?>
                <button class="btn btn-primary btn-icon-text btn-xs" id="btn-add">
                    <i class="bx bx-plus-circle"></i>
                    <span class="fw-normal fs-7">Add New</span>
                </button>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm fs-7 w-100" id="table-user">
                <thead>
                    <tr>
                        <th data-width="30" data-orderable="false">No</th>
                        <th data-order="asc">Name</th>
                        <th>Username</th>
                        <th data-width="100">Created By</th>
                        <th data-width="150">Created Date</th>
                        <th data-width="100">Updated By</th>
                        <th data-width="150">Updated Date</th>
                        <th data-width="30">Active?</th>
                        <th data-width="180">Action</th>
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
        table: $('#table-user'),
        button: {
            add: $('#btn-add'),
        }
    };

    elements.button.add.on('click', () => modalForm(
        'Form User',
        'modal-lg',
        '<?= getURL('cms/user/form') ?>'
    ));

    let tableUser = elements.table.initDataTable({
        rowCallback: (row) => {
            let $row = $(row);

            $row.find('[data-toggle="user"]').formEditable({
                url: '<?= getURL('cms/user/updatefield') ?>',
                action: 'click',
                value: ($form) => $form.prop('checked'),
            })
        }
    });

    $('#modaldetail').on('hidden.bs.modal', () => tableUser.ajax.reload(null, false));
    $('#modaldel').on('hidden.bs.modal', () => tableUser.ajax.reload(null, false));
</script>
<?= $this->endSection() ?>