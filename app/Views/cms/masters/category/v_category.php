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
            <table class="table table-bordered table-master table-sm w-100">
                <thead>
                    <tr>
                        <th data-width="30" data-orderable="false">No</th>
                        <th data-width="150" data-order="asc">Code</th>
                        <th>Category Name</th>
                        <th data-width="150">Created At</th>
                        <th data-width="100">Created By</th>
                        <th data-width="150">Updated By</th>
                        <th data-width="100">Updated Date</th>
                        <th data-width=" 100" data-orderable="false">Actions</th>
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
        'Form Category',
        'modal-md margin-b-5rem',
        '<?= getURL('cms/category/form') ?>'
    ));
</script>
<?= $this->endSection() ?>