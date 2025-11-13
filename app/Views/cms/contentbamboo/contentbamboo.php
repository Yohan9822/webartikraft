<?php

use App\Models\Cmsfullcontent;

$fullContent = new Cmsfullcontent();

$dataImage = [];
$totalImage = 9;

for ($i = 1; $i <= 9; $i++) {
    $getRow = $fullContent->getByKey($lang, "bamboo-image-$i");
    if (!empty($getRow)) {
        $getRow->payload = json_decode($getRow->payload ?? '{}');

        if (!empty($getRow->payload->image))
            $getRow->payload->image = json_encode(files_preview($getRow->payload->image));

        $getRow->payload->image = json_decode($getRow->payload->image, true);
        $dataImage[$i] = $getRow->payload->image[0];
    } else {
        $dataImage[$i] = null;
    }
}
?>
<div class="w-full h-full flex flex-col">
    <input type="file" id="global-image-input" class="hidden" accept="image/*">

    <div class="my-8 relative editable-image" data-key="bamboo-image-1">
        <img src="<?= $dataImage[1] ?? base_url('public/images/home/10.jpg') ?>" alt="gambar bamboo" class="lazy w-full h-[600px] object-cover">
        <button type="button" title="Change Image" style="width: 40px;height:40px;" class="edit-btn absolute top-2 right-2 bg-white/80 hover:bg-white text-gray-700 rounded-full p-2 shadow-md hidden">
            <i class="bx bx-pencil"></i>
        </button>
    </div>
    <div class="my-8 text-center flex flex-col gap-4">
        <span class="text-5xl uppercase editable-text" data-key="bamboo-text-1" contenteditable="true"><?= $content['bamboo-text-1'] ?></span>
        <span class="text-lg lowercase editable-text" data-key="bamboo-text-2" contenteditable="true"><?= $content['bamboo-text-2'] ?></span>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-5">
        <div class="md:col-span-2">
            <div class="my-8 relative editable-image" data-key="bamboo-image-2">
                <img src="<?= $dataImage[2] ?? base_url('public/images/home/11.jpg') ?>" alt="gambar bamboo" class="lazy w-full h-[500px] object-cover">
                <button type="button" title="Change Image" style="width: 40px;height:40px;" class="edit-btn absolute top-2 right-2 bg-white/80 hover:bg-white text-gray-700 rounded-full p-2 shadow-md hidden">
                    <i class="bx bx-pencil"></i>
                </button>
            </div>
        </div>
        <div class="md:col-span-3">
            <div class="my-8 relative editable-image" data-key="bamboo-image-3">
                <img src="<?= $dataImage[3] ?? base_url('public/images/home/12.jpg') ?>" alt="gambar bamboo" class="lazy w-full h-[500px] object-cover">
                <button type="button" title="Change Image" style="width: 40px;height:40px;" class="edit-btn absolute top-2 right-2 bg-white/80 hover:bg-white text-gray-700 rounded-full p-2 shadow-md hidden">
                    <i class="bx bx-pencil"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<section class="py-8 px-[1rem] md:px-[3rem] bg-white">
    <div class="mb-4 flex items-start justify-between w-full">
        <h2 class="text-4xl uppercase editable-text" data-key="bamboo-material" contenteditable="true"><?= $content['bamboo-material'] ?></h2>
    </div>
    <p class="text-gray-800 w-full md:w-[40%] editable-text" data-key="bamboo-material-text" contenteditable="true">
        <?= $content['bamboo-material-text'] ?>
    </p>
    <div class="flex flex-nowrap overflow-x-auto gap-4 py-4">
        <div class="w-full md:w-1/3 flex flex-col flex-shrink-0 items-start justify-start text-left">
            <div class="my-8 relative editable-image" data-key="bamboo-image-4">
                <img src="<?= $dataImage[4] ?? base_url('public/images/home/3.jpg') ?>" alt="Produk" class="lazy w-full h-[450px] object-cover mb-3" />
                <button type="button" title="Change Image" style="width: 40px;height:40px;" class="edit-btn absolute top-2 right-2 bg-white/80 hover:bg-white text-gray-700 rounded-full p-2 shadow-md hidden">
                    <i class="bx bx-pencil"></i>
                </button>
            </div>
        </div>
        <div class="w-full md:w-1/3 flex flex-col flex-shrink-0 items-start justify-start text-left">
            <div class="my-8 relative editable-image" data-key="bamboo-image-5">
                <img src="<?= $dataImage[5] ?? base_url('public/images/home/4.png') ?>" alt="Produk" class="lazy w-full h-[450px] object-cover mb-3" />
                <button type="button" title="Change Image" style="width: 40px;height:40px;" class="edit-btn absolute top-2 right-2 bg-white/80 hover:bg-white text-gray-700 rounded-full p-2 shadow-md hidden">
                    <i class="bx bx-pencil"></i>
                </button>
            </div>
        </div>
        <div class="w-full md:w-1/3 flex flex-col flex-shrink-0 items-start justify-start text-left">
            <div class="my-8 relative editable-image" data-key="bamboo-image-6">
                <img src="<?= $dataImage[6] ?? base_url('public/images/home/5.jpg') ?>" alt="Produk" class="lazy w-full h-[450px] object-cover mb-3" />
                <button type="button" title="Change Image" style="width: 40px;height:40px;" class="edit-btn absolute top-2 right-2 bg-white/80 hover:bg-white text-gray-700 rounded-full p-2 shadow-md hidden">
                    <i class="bx bx-pencil"></i>
                </button>
            </div>
        </div>
    </div>
</section>
<div class="w-full h-full mb-6">
    <div class="grid grid-cols-8 gap-4">
        <div class="col-span-8 md:col-span-4">
            <div class="my-8 relative editable-image" data-key="bamboo-image-7">
                <img src="<?= $dataImage[7] ?? base_url('public/images/home/13.jpg') ?>" alt="gambar bamboo" class="lazy w-full h-[400px] object-cover">
                <button type="button" title="Change Image" style="width: 40px;height:40px;" class="edit-btn absolute top-2 right-2 bg-white/80 hover:bg-white text-gray-700 rounded-full p-2 shadow-md hidden">
                    <i class="bx bx-pencil"></i>
                </button>
            </div>
        </div>
        <div class="col-span-4 md:col-span-2">
            <div class="my-8 relative editable-image" data-key="bamboo-image-8">
                <img src="<?= $dataImage[8] ?? base_url('public/images/home/14.jpg') ?>" alt="gambar bamboo" class="lazy w-full h-[400px] object-cover">
                <button type="button" title="Change Image" style="width: 40px;height:40px;" class="edit-btn absolute top-2 right-2 bg-white/80 hover:bg-white text-gray-700 rounded-full p-2 shadow-md hidden">
                    <i class="bx bx-pencil"></i>
                </button>
            </div>
        </div>
        <div class="col-span-4 md:col-span-2">
            <div class="my-8 relative editable-image" data-key="bamboo-image-9">
                <img src="<?= $dataImage[9] ?? base_url('public/images/home/15.jpg') ?>" alt="gambar bamboo" class="lazy w-full h-[400px] object-cover">
                <button type="button" title="Change Image" style="width: 40px;height:40px;" class="edit-btn absolute top-2 right-2 bg-white/80 hover:bg-white text-gray-700 rounded-full p-2 shadow-md hidden">
                    <i class="bx bx-pencil"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<section class="py-8 px-[1rem] md:px-[3rem] bg-white flex flex-col gap-4">
    <div class="mb-4 flex items-start justify-center w-full">
        <h2 class="text-4xl editable-text" data-key="bamboo-laminated" contenteditable="true"><?= $content['bamboo-laminated'] ?></h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-gray-800">
        <p class="w-full md:w-[80%] editable-text" data-key="bamboo-laminated-text" contenteditable="true">
            <?= $content['bamboo-laminated-text'] ?>
        </p>
        <p class="w-full md:w-[80%] editable-text" data-key="bamboo-laminated-text-2" contenteditable="true">
            <?= $content['bamboo-laminated-text-2'] ?>
        </p>
        <p class="w-full md:w-[80%] editable-text" data-key="bamboo-laminated-text-3" contenteditable="true">
            <?= $content['bamboo-laminated-text-3'] ?>
        </p>
    </div>
</section>