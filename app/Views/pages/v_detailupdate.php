<?= $this->include('template/v_header') ?>
<div class="w-full mb-5 h-[550px]">
    <img src="<?= (!empty($cover) ? $cover[0] : '') ?>" alt="contact image" class="w-full h-[550px] object-cover" loading="lazy">
</div>
<section class="h-max px-[1rem] md:px-[3rem] my-6">
    <?= $row->description; ?>
</section>
<?= $this->include('template/v_footer') ?>