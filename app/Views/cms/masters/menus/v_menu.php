<?= $this->extend('cms/template/v_main') ?>

<?= $this->section('content') ?>
<div class="main-content content margin-t-4">
    <div class="card shadow-sm p-x w-100 rounded">
        <div class="card-header dflex justify-end">
            <button class="btn btn-outline-primary btn-icon-text btn-md margin-r-2" id="btn-add">
                <i class="bx bx-filter"></i>
                <span>Sort Menu</span>
            </button>
            <?php if (getAccess(AccessCode::create)) : ?>
                <button class="btn btn-primary btn-icon-text btn-md" onclick="return modalForm('Add Menu', 'modal-lg', '<?= getURL('cms/menu/form') ?>')">
                    <i class="bx bx-plus-circle"></i>
                    <span class="fw-normal fs-7">Add New</span>
                </button>
            <?php endif ?>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm table-master fs-7 w-100">
                <thead>
                    <tr>
                        <th data-width="30" data-orderable="false">No</th>
                        <th data-order="asc">Menu Name</th>
                        <th data-width="100">Master Name</th>
                        <th>Menu Link</th>
                        <th data-width="50" data-orderable="false">Menu Icon</th>
                        <th data-width="150" data-orderable="false">Action</th>
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
        'Sort Menu',
        'modal-md margin-b-5rem',
        '<?= getURL('cms/menu/sort') ?>'
    ));
</script>
<?= $this->endSection() ?>