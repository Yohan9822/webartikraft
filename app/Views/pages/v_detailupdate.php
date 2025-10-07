<?= $this->include('template/v_header') ?>
<div class="w-full mb-5 h-[550px]">
    <img src="<?= (!empty($cover) ? $cover[0] : '') ?>" alt="contact image" class="w-full h-[550px] object-cover" loading="lazy">
</div>
<section class="h-max px-[1rem] md:px-[3rem] my-6">
    <div class="flex flex-col">
        <span class="font-bold text-gray-800 text-[20px]"><?= $row->caption ?></span>
        <span class="font-normal text-gray-600 text-[16px]"><?= date('d M Y', strtotime($row->date)) ?></span>
    </div>
    <div class="my-4">
        <?= $row->description; ?>
    </div>
</section>
<?= $this->include('template/v_footer') ?>