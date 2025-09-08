<?= $this->extend('cms/template/v_main') ?>

<?= $this->section('content') ?>
<div class="main-content p-x content margin-t-4">
    <div class="card shadow-sm p-x w-100 rounded">
        <div class="card-header dflex justify-end align-center">
            <?php if (getAccess(AccessCode::create)) : ?>
                <button class="btn btn-primary btn-icon-text btn-xs" id="btn-add">
                    <i class="bx bx-plus-circle"></i>
                    <span class="fw-normal fs-7">Add New</span>
                </button>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-master table-sm w-100">
                <thead>
                    <tr>
                        <th data-width="30" data-orderable="false">No</th>
                        <th data-order="asc">Company Name</th>
                        <th>Address</th>
                        <th data-width="100">Created By</th>
                        <th data-width="120">Created Date</th>
                        <th data-width="100">Updated By</th>
                        <th data-width="120">Updated Date</th>
                        <th data-width="100" data-orderable="false">Action</th>
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
        button: {
            add: $('#btn-add'),
        }
    };

    elements.button.add.on('click', () => modalForm(
        'Form Company',
        'modal-lg',
        '<?= getURL('cms/company/form') ?>'
    ));
</script>
<?= $this->endSection() ?>