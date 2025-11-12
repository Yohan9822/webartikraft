<?php

use App\Models\Cmsfullcontent;

$fullContent = new Cmsfullcontent();

$furnishingImage1 = "";
$getRow = $fullContent->getByKey($lang, 'furnishing-image-1');
if (!empty($getRow)) {
    $getRow->payload = json_decode($getRow->payload ?? '{}');

    if (!empty($getRow->payload->image))
        $getRow->payload->image = json_encode(files_preview($getRow->payload->image));

    $getRow->payload->image = json_decode($getRow->payload->image, true);
    $furnishingImage1 = $getRow->payload->image[0];
} else {
    $furnishingImage1 = base_url('public/images/home/9.jpg');
}
?>
<div class="my-8 relative editable-image" data-key="furnishing-image-1">
    <img src="<?= $furnishingImage1 ?>"
        alt="gambar company"
        class="lazy w-full h-[650px] object-cover">
    <button type="button" title="Change Image" style="width: 40px;height:40px;" class="edit-btn absolute top-2 right-2 bg-white/80 hover:bg-white text-gray-700 rounded-full p-2 shadow-md hidden">
        <i class="bx bx-pencil"></i>
    </button>
    <input type="file" class="hidden image-input" accept="image/*">
</div>