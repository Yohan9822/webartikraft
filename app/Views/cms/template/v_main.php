<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Default Skins' ?></title>

    <link rel="stylesheet" href="<?= base_url('public/cms/css/template.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('public/cms/css/modal.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/cms/css/mystyle.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/cms/css/boxicons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/cms/css/jquery-ui.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/cms/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/cms/css/select2-theme.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/cms/css/notyf.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/cms/css/microtip.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/cms/css/apexcharts.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/cms/css/sweetalert2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/cms/datatable/jquery.dataTables.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/cms/datatable/buttons.dataTables.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/cms/css/daterangepicker.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/cms/css/timepicker.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/cms/css/jquery.nestable.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/cms/vendors/lightbox/css/lightbox.min.css') ?>">
    <?= $this->renderSection('link_css') ?>
</head>

<body>
    <div class="global-containers">
        <?= $this->include('cms/template/v_sidebar') ?>
        <div class="content">
            <div class="container-fluid p-x-y">
                <?= $this->include('cms/template/v_navbar') ?>
                <?= $this->include('cms/template/v_appbar') ?>

                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
</body>
<script src="<?= base_url('public/cms/js/jquery.js') ?>"></script>
<script src="<?= base_url('public/cms/js/jquery-ui.js') ?>"></script>
<script src="<?= base_url('public/cms/js/notyf.js') ?>"></script>
<script src="<?= base_url('public/cms/js/editor.js') ?>"></script>
<script src="<?= base_url('public/cms/js/bootstrap.js') ?>"></script>
<script src="<?= base_url('public/cms/js/select2.min.js') ?>"></script>
<script src="<?= base_url('public/cms/datatable/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('public/cms/datatable/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('public/cms/vendors/lightbox/js/lightbox.min.js') ?>"></script>
<script src="<?= base_url('public/cms/js/apexcharts.js') ?>"></script>
<script src="<?= base_url('public/cms/js/socket.io.min.js') ?>"></script>
<script src="<?= base_url('public/cms/js/JsBarcode.all.min.js') ?>"></script>
<script src="<?= base_url('public/cms/js/sweetalert2.min.js') ?>"></script>
<script src="<?= base_url('public/cms/js/moment.min.js') ?>"></script>
<script src="<?= base_url('public/cms/js/daterangepicker.js') ?>"></script>
<script src="<?= base_url('public/cms/js/timepicker.min.js') ?>"></script>
<script src="<?= base_url('public/cms/js/jquery.nestable.min.js') ?>"></script>
<script src="<?= base_url('public/cms/js/jquery.number.min.js') ?>"></script>
<script src="<?= base_url('public/cms/js/jquery.mask.min.js') ?>"></script>
<script src="<?= base_url('public/cms/js/sidebar.js') ?>"></script>
<script src="<?= base_url('public/cms/js/app.js') ?>"></script>

<?= $this->include('cms/template/v_form_builder') ?>
<?= $this->include('cms/template/v_footer') ?>
<?= $this->renderSection('footer') ?>
<?= $this->renderSection('script_javascript') ?>

</html>