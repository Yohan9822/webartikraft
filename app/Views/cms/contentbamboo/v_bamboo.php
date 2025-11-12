<?= $this->extend('cms/template/v_main') ?>

<?= $this->section('content') ?>
<style>
    @font-face {
        font-family: 'TTRamillas';
        src: url('<?= getURL('public/fonts/fontregular.ttf') ?>') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'Font Italic';
        src: url('<?= getURL('public/fonts/fontitalic.ttf') ?>') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    .main-content * {
        font-family: 'TTRamillas', sans-serif !important;
    }

    .italic {
        font-family: 'Font Italic', sans-serif;
    }

    .editable-text[contenteditable="true"]:hover {
        outline: 2px dashed #ccc;
        cursor: text;
    }
</style>
<div class="main-content content margin-t-4">
    <div class="card w-100 rounded shadow-sm" style="position: relative;padding:12px;">
        <div class="dflex align-center justify-between">
            <span>
                Update <b class="text-primary"><i>ENGINEERED BAMBOO</i></b> menu content
            </span>

            <div class="btn-group" role="group" aria-label="Language switcher">
                <button
                    type="button"
                    class="btn btn-secondary dflex align-center lang-btn fs-7"
                    style="width: 110px;"
                    data-lang="id">
                    <img src="https://flagcdn.com/w20/id.png" alt="Indonesia" class="me-2">
                    Indonesia
                </button>
                <button
                    type="button"
                    class="btn btn-primary dflex align-center lang-btn fs-7 active"
                    style="width: max-content;"
                    data-lang="en">
                    <img src="https://flagcdn.com/w20/gb.png" alt="English" class="me-2">
                    English
                </button>
            </div>
        </div>

        <link rel="stylesheet" href="<?= base_url('public/css/boxicons.css') ?>">
        <link rel="stylesheet" href="<?= base_url('public/css/notyf.css') ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/css/splide.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <div class="border mt-4" id="load-page">
            <?= $this->include('cms/contentbamboo/contentbamboo') ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('script_javascript') ?>
<script>
    let currentKey = null;
    let currentImage = null;
    let lastContent = {};

    function imageLoad() {
        $('.editable-image').hover(function() {
            $(this).find('.edit-btn').fadeIn(200);
        }, function() {
            $(this).find('.edit-btn').fadeOut(200);
        });

        $('.edit-btn').on('click', function() {
            const parent = $(this).closest('.editable-image');
            const key = parent.data('key');
            const globalInput = $('#global-image-input');

            globalInput.data('targetKey', key);
            globalInput.data('parentSelector', `[data-key="${key}"]`);
            globalInput.click();
        });
    }

    function loadToggle() {
        $('.editable-text[contenteditable="true"]').on('input', function() {
            const el = $(this);
            const key = el.data('key');
            lastContent[key] = el.html().trim();
        });

        $('.editable-text[contenteditable="true"]').on('blur', function() {
            const el = $(this);
            const key = el.data('key');
            const content = lastContent[key] ?? el.html().trim();

            if (el.data('updating')) return;
            el.data('updating', true);

            $.ajax({
                url: '<?= base_url('cms/updatefullcontent') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    key,
                    menu: 'bamboo',
                    content,
                    _t: new Date().getTime()
                },
                success: function(response) {
                    if (!response.success) showError(response.pesan);
                },
                error: function(xhr, status, error) {
                    showError(error);
                },
                complete: function() {
                    el.data('updating', false);
                }
            });
        });

        // proses update image
        $('#global-image-input').on('change', function() {
            const file = this.files[0];
            const targetKey = $(this).data('targetKey');
            const parent = $(`.editable-image[data-key="${targetKey}"]`);
            const imgEl = parent.find('img');

            if (!file) return;
            if (!file.type.startsWith('image/')) {
                alert('File must be an image (jpg, png, dll)');
                return;
            }

            const formData = new FormData();
            formData.append('file', file);
            formData.append('key', targetKey);
            formData.append('menu', 'bamboo');

            const oldSrc = imgEl.attr('src');
            imgEl.css('opacity', '0.5');

            $.ajax({
                url: '<?= base_url('cms/updateimage') ?>',
                type: 'POST',
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    try {
                        if (response.success == 1 && response.url) {
                            $('#load-page').html(response.view);
                        } else {
                            showError('Failed updating image ' + response.pesan);
                            imgEl.attr('src', oldSrc);
                        }
                        imageLoad();
                        loadToggle();
                    } catch (e) {
                        showError('Error parsing response');
                        imgEl.attr('src', oldSrc);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    showError(thrownError);
                    imgEl.attr('src', oldSrc);
                },
                complete: function() {
                    imgEl.css('opacity', '1');
                    $('#global-image-input').val('');
                }
            });
        });
    }

    $(document).ready(function() {
        loadToggle();
        imageLoad()

        // change language
        $(document).on('click', '.lang-btn', function() {
            const selectedLang = $(this).data('lang');

            $.ajax({
                url: '<?= base_url('cms/switchLang') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    lang: selectedLang,
                    menu: 'bamboo'
                },
                success: function(response) {
                    if (response.success && response.view) {
                        $('#load-page').html(response.view);
                        loadToggle();
                    } else {
                        showError('Failed to switch language.');
                    }
                },
                error: function() {
                    showError('An error occurred while switching language.');
                }
            });
        });

    });
</script>
<?= $this->endSection(); ?>