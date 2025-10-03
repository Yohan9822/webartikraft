<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Arti Kraft Indonesia has a manufacturing facility, enhanced with cutting-edge technologies and machines to process productions.">
    <meta name="keywords" content="Company Profile, artikraft, artikraft indonesia, manufacturing, company profile, handicrafts, accessories, Tasikmalaya, west java">
    <meta name="author" content="Artikraft Indonesia">
    <title><?= $title ?></title>
    <link rel="icon" href="<?= base_url('public/icon.ico') ?>" type="image/x-icon">

    <meta property="og:title" content="<?= $title ?>">
    <meta property="og:description" content="Arti Kraft Indonesia has a manufacturing facility, enhanced with cutting-edge technologies and machines to process productions.">
    <meta property="og:image" content="<?= base_url('public/logo.png') ?>">
    <meta property="og:url" content="<?= base_url() ?>">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $title ?>">
    <meta name="twitter:description" content="Arti Kraft Indonesia has a manufacturing facility, enhanced with cutting-edge technologies and machines to process productions.">
    <meta name="twitter:image" content="<?= base_url('public/logo.png') ?>">

    <!-- Load Assets -->
    <link rel="stylesheet" href="<?= base_url('public/css/boxicons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/css/notyf.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/css/splide.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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

        * {
            font-family: 'TTRamillas', sans-serif !important;
        }

        .italic {
            font-family: 'Font Italic', sans-serif;
        }
    </style>
</head>

<body class="flex flex-col w-full min-h-screen relative overflow-x-hidden">
    <?php if (!isset($woNav)): ?>
        <?= $this->include('template/v_navbar') ?>
    <?php endif; ?>