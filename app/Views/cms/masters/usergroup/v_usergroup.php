<?= $this->extend('cms/template/v_main') ?>

<?= $this->section('content') ?>
<div class="main-content content margin-t-4">
    <div class="card rounded w-100 p-x shadow-sm">
        <div class="card-header dflex align-center justify-end">
            <?php if (getAccess(AccessCode::create)) : ?>
                <button class="btn btn-primary btn-icon-text btn-xs" id="btn-add">
                    <i class="bx bx-plus-circle"></i>
                    <span class="fw-normal fs-7">Add New</span>
                </button>
            <?php endif ?>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-master table-sm fs-7 w-100">
                <thead>
                    <tr>
                        <th data-width="30" data-orderable="false">No</th>
                        <th data-order="asc">Group Name</th>
                        <th data-width="200">Created By</th>
                        <th data-width="150">Created Date</th>
                        <th data-width="200">Updated By</th>
                        <th data-width="150">Updated Date</th>
                        <th data-width="200">Action</th>
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
        'Form Usergroup',
        'modal-lg',
        '<?= getURL('cms/usergroup/form') ?>'
    ));
</script>
<?= $this->endSection() ?>