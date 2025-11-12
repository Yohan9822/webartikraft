<?= $this->include('template/v_header') ?>
<?php

use App\Models\Cmsfullcontent;

$lang = service('request')->getLocale();

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
    <img data-src="<?= $dataImage[1] ?? base_url('public/images/home/10.jpg') ?>" alt="gambar bamboo" class="lazy w-full h-[600px] object-cover">
    <div class="my-8 text-center flex flex-col gap-4">
        <span class="text-5xl uppercase"><?= lang('Global.bamboo-text-1') ?></span>
        <span class="text-lg lowercase"><?= lang('Global.bamboo-text-2') ?></span>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-5">
        <div class="md:col-span-2">
            <img data-src="<?= $dataImage[2] ?? base_url('public/images/home/11.jpg') ?>" alt="gambar bamboo" class="lazy w-full h-[500px] object-cover">
        </div>
        <div class="md:col-span-3">
            <img data-src="<?= $dataImage[3] ?? base_url('public/images/home/12.jpg') ?>" alt="gambar bamboo" class="lazy w-full h-[500px] object-cover">
        </div>
    </div>
</div>
<section class="py-8 px-[1rem] md:px-[3rem] bg-white">
    <div class="mb-4 flex items-start justify-between w-full">
        <h2 class="text-4xl uppercase"><?= lang('Global.bamboo-material') ?></h2>
    </div>
    <p class="text-gray-800 w-full md:w-[40%]">
        <?= lang('Global.bamboo-material-text') ?>
    </p>
    <div class="flex flex-nowrap overflow-x-auto gap-4 py-4">
        <?php for ($s = 0; $s <= 2; $s++): ?>
            <div class="w-full md:w-1/3 flex flex-col flex-shrink-0 items-start justify-start text-left">
                <img data-src="<?= $dataImage[4] ?? base_url('public/images/home/3.jpg') ?>" alt="Produk" class="lazy w-full h-[450px] object-cover mb-3" />
            </div>
            <div class="w-full md:w-1/3 flex flex-col flex-shrink-0 items-start justify-start text-left">
                <img data-src="<?= $dataImage[5] ?? base_url('public/images/home/4.png') ?>" alt="Produk" class="lazy w-full h-[450px] object-cover mb-3" />
            </div>
            <div class="w-full md:w-1/3 flex flex-col flex-shrink-0 items-start justify-start text-left">
                <img data-src="<?= $dataImage[6] ?? base_url('public/images/home/5.jpg') ?>" alt="Produk" class="lazy w-full h-[450px] object-cover mb-3" />
            </div>
        <?php endfor; ?>
    </div>
</section>
<div class="w-full h-full mb-6">
    <div class="grid grid-cols-8 gap-4">
        <div class="col-span-8 md:col-span-4">
            <img data-src="<?= $dataImage[7] ?? base_url('public/images/home/13.jpg') ?>" alt="gambar bamboo" class="lazy w-full h-[400px] object-cover">
        </div>
        <div class="col-span-4 md:col-span-2">
            <img data-src="<?= $dataImage[8] ?? base_url('public/images/home/14.jpg') ?>" alt="gambar bamboo" class="lazy w-full h-[400px] object-cover">
        </div>
        <div class="col-span-4 md:col-span-2">
            <img data-src="<?= $dataImage[9] ?? base_url('public/images/home/15.jpg') ?>" alt="gambar bamboo" class="lazy w-full h-[400px] object-cover">
        </div>
    </div>
</div>
<section class="py-8 px-[1rem] md:px-[3rem] bg-white flex flex-col gap-4">
    <div class="mb-4 flex items-start justify-center w-full">
        <h2 class="text-4xl"><?= lang('Global.bamboo-laminated') ?></h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-gray-800">
        <p class="w-full md:w-[80%]">
            <?= lang('Global.bamboo-laminated-text') ?>
        </p>
        <p class="w-full md:w-[80%]">
            <?= lang('Global.bamboo-laminated-text-2') ?>
        </p>
        <p class="w-full md:w-[80%]">
            <?= lang('Global.bamboo-laminated-text-3') ?>
        </p>
    </div>
</section>
<?= $this->include('template/v_footer') ?>