<?= $this->extend('cms/template/v_main') ?>

<?= $this->section('content') ?>
<div class="main-content content margin-t-4">
    <div class="card w-100 rounded shadow-sm p-x" style="position: relative;">
        <div class="card-header dflex justify-end">
            <?php if (getAccess(AccessCode::create)) : ?>
                <button class="btn btn-primary btn-xs btn-icon-text" id="btn-add">
                    <i class="bx bx-save"></i>
                    <span class="fw-normal fs-7"><?= !empty($row) ? 'Update Content' : 'Save Content' ?></span>
                </button>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <form action="<?= !empty($row) ? getURL('cms/bamboo/update') : getURL('cms/bamboo/add') ?>" id="form-bamboo" method="post" style="padding-inline: 0px;">
                <input type="hidden" id="id" name="id" value="<?= !empty($row) ? encrypting($row->id) : '' ?>">
                <div class="form-group">
                    <textarea name="content_bamboo" id="content_bamboo" class="form-input" placeholder="Enter Company content"><?= !empty($row) ? $row->content : '' ?></textarea>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('script_javascript') ?>
<script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
    $(document).ready(function() {
        CKEDITOR.replace('content_bamboo', {
            versionCheck: false,
            height: 600,
            extraPlugins: 'filebrowser',
            filebrowserUploadUrl: '<?= getURL("cms/bamboo/upload") ?>',
            filebrowserBrowseUrl: '<?= getURL("cms/bamboo/browse") ?>'
        });

        let elements = {
            form: $('#form-bamboo'),
            submitBtn: $('#btn-add')
        };

        elements.form.formSubmit({
            beforeSubmit: () => {
                console.log('Before Submit Called');

                const contentData = CKEDITOR.instances.content_bamboo.getData();
                console.log('CKEditor Data:', contentData);

                elements.form.find('[name="content_bamboo"]').val(contentData);
                return true;
            },
            successCallback: (res) => {
                close_modal('modaldetail');

                showNotif(res.sukses == '1' ? 'success' : 'error', res.pesan);

                if (res.sukses == '1') {
                    if (res.link) {
                        setTimeout(() => {
                            window.location.href = res.link;
                        }, 250);
                    }
                }
            },
            errorCallback: (err) => {
                console.error('Error:', err);
                showNotif('error', 'An error occurred while submitting the form.');
            }
        });

        elements.submitBtn.click(function() {
            elements.form.trigger('submit');
        })
    });
</script>
<?= $this->endSection(); ?>