<?php

use App\Models\Cmsfullcontent;

$fullContent = new Cmsfullcontent();

$companyImage1 = "";
$getRow = $fullContent->getByKey($lang, 'company-image-1');
if (!empty($getRow)) {
    $getRow->payload = json_decode($getRow->payload ?? '{}');

    if (!empty($getRow->payload->image))
        $getRow->payload->image = json_encode(files_preview($getRow->payload->image));

    $getRow->payload->image = json_decode($getRow->payload->image, true);
    $companyImage1 = $getRow->payload->image[0];
} else {
    $companyImage1 = base_url('public/images/home/8.jpg');
}
?>
<section class="h-max p-6 flex items-center justify-center my-6">
    <div class="w-full text-center px-6 flex flex-col gap-5">
        <p class="text-lg leading-relaxed text-black italic editable-text"
            data-key="paragraph-1-company"
            contenteditable="true">
            <?= $content['paragraph-1-company'] ?>
        </p>
        <p class="text-gray-800 editable-text" data-key="company-1"
            contenteditable="true">
            <?= $content['company-1'] ?>
        </p>
    </div>
</section>
<section class="py-6">
    <div class="px-[1rem] md:px-[3rem]">
        <div class="mb-8 flex items-start justify-between w-full">
            <h2 class="text-4xl uppercase editable-text" data-key="company-title-1"
                contenteditable="true"><?= $content['company-title-1'] ?></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <p class="text-gray-800">
                <span class="italic font-semibold editable-text" data-key="parap-company-1"
                    contenteditable="true"><?= $content['parap-company-1'] ?></span>
                <br>
                <br>
                <span class="editable-text" data-key="parap-company-2"
                    contenteditable="true"><?= $content['parap-company-2'] ?></span>
                <br>
                <br>
                <span class="editable-text" data-key="parap-company-3"
                    contenteditable="true"><?= $content['parap-company-3'] ?></span>
                <br>
                <br>
                <span class="editable-text" data-key="parap-company-4"
                    contenteditable="true"><?= $content['parap-company-4'] ?></span>
            </p>
            <p class="text-gray-800">
                <span class="italic font-semibold editable-text" data-key="company-title-2" contenteditable="true"><?= $content['company-title-2'] ?></span>
                <br>
                <br>
                <span class="editable-text" data-key="parap-company-5" contenteditable="true"><?= $content['parap-company-5'] ?></span>
                <br>
                <br>
                <span class="italic font-semibold editable-text" data-key="company-title-3" contenteditable="true"><?= $content['company-title-3'] ?></span>
                <br>
                <br>
                <span class="editable-text" data-key="parap-company-6" contenteditable="true"><?= $content['parap-company-6'] ?></span>
                <br>
                <br>
                <span class="editable-text" data-key="parap-company-7" contenteditable="true"><?= $content['parap-company-7'] ?></span>
            </p>
        </div>
    </div>
    <div class="my-8 relative editable-image" data-key="company-image-1">
        <img src="<?= $companyImage1 ?>"
            alt="gambar company"
            class="lazy w-full h-[650px] object-cover">
        <button type="button" title="Change Image" style="width: 40px;height:40px;" class="edit-btn absolute top-2 right-2 bg-white/80 hover:bg-white text-gray-700 rounded-full p-2 shadow-md hidden">
            <i class="bx bx-pencil"></i>
        </button>
        <input type="file" class="hidden image-input" accept="image/*">
    </div>
</section>

<section class="pb-[4rem] px-[1rem] md:px-[3rem]">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="flex flex-col gap-5">
            <div class="mb-8 flex items-start justify-between w-full">
                <h2 class="text-4xl uppercase editable-text" data-key="our-vision" contenteditable="true"><?= $content['our-vision'] ?></h2>
            </div>
            <p class="text-gray-800 editable-text" data-key="parap-vision" contenteditable="true">
                <?= $content['parap-vision'] ?>
            </p>
        </div>
        <div class="flex flex-col gap-5">
            <div class="mb-8 flex items-start justify-between w-full">
                <h2 class="text-4xl uppercase editable-text" data-key="our-value" contenteditable="true"><?= $content['our-value'] ?></h2>
            </div>
            <p class="text-gray-800">
                <span class="editable-text" data-key="parap-value-1" contenteditable="true"><?= $content['parap-value-1'] ?></span>
                <br>
                <br>
                <span class="editable-text" data-key="parap-value-2" contenteditable="true"><?= $content['parap-value-2'] ?></span>
                <br>
                <br>
                <span class="editable-text" data-key="parap-value-3" contenteditable="true"><?= $content['parap-value-3'] ?></span>
            </p>
        </div>
    </div>
</section>