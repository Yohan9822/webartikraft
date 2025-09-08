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
            <table class="table table-bordered table-master table-sm w-100" id="table-slide">
                <thead>
                    <tr>
                        <th data-width="30" data-orderable="false">No</th>
                        <th data-width="120">Preview</th>
                        <th data-width="175" data-order="asc">Caption</th>
                        <th data-width="120">Caption Position</th>
                        <th data-width="50">Sequence</th>
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
<script type="text/javascript">
    let elements = {
        table: $('#table-slide'),
        button: {
            add: $('#btn-add'),
        }
    };

    elements.button.add.on('click', () => modalForm(
        'Form Slide',
        'modal-lg margin-b-5rem',
        '<?= getURL('cms/slide/form') ?>'
    ));

    let tableSlide = elements.table.initDataTable({
        rowCallback: (row) => {
            let $row = $(row);

            $row.find('[data-toggle="slide-image"]').formEditable({
                url: '<?= getURL('cms/slide/updatefield') ?>',
                action: 'click',
                value: ($form) => $form.prop('checked'),
            })
        }
    });

    $('#modaldetail').on('hidden.bs.modal', () => tableUser.ajax.reload(null, false));
    $('#modaldel').on('hidden.bs.modal', () => tableUser.ajax.reload(null, false));
</script>
<?= $this->endSection() ?>