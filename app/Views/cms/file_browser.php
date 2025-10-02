<!DOCTYPE html>
<html>

<head>
    <title>File Browser</title>
    <style>
        .file-item {
            display: inline-block;
            margin: 10px;
            text-align: center;
        }

        .file-item img {
            max-width: 100px;
            max-height: 100px;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div>
        <?php foreach ($files as $file): ?>
            <div class="file-item">
                <a href="<?= $file['url'] ?>" onclick="returnFileUrl('<?= $file['url'] ?>')">
                    <img src="<?= $file['url'] ?>" alt="<?= $file['name'] ?>" style="width:100%;height:120px;object:cover;">
                    <p><?= $file['name'] ?></p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <script>
        function returnFileUrl(url) {
            window.opener.CKEDITOR.tools.callFunction(<?= $_GET['CKEditorFuncNum'] ?>, url);
            window.close();
        }
    </script>
</body>

</html>