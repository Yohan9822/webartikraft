<?= $this->include('template/v_header') ?>
<div class="w-full h-full pb-10 flex flex-col gap-8">
    <img src="<?= base_url('public/images/home/9.jpg') ?>" alt="gambar furnishing" class="object-cover w-full h-[550px]" loading="lazy">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-2 items-center">
        <p class="px-[1rem] md:px-[3rem] text-gray-800">
            <?= lang('Global.parap-fur-1') ?>
        </p>
        <img src="<?= base_url('public/images/home/6.jpg') ?>" alt="gambar furnishing" class="object-cover w-full h-[95%]" loading="lazy">
    </div>
</div>
<section class="splide py-16 px-[1rem] md:px-[3rem] bg-white text-center">
    <div class="mb-8 flex md:flex-row flex-col items-start justify-between w-full">
        <h2 class="text-4xl uppercase"><?= lang('Global.products') ?></h2>
        <div class="flex flex-col items-center justify-center text-[#545454] cursor-pointer hover:text-[#477524]">
            <span class="text-sm mb-1"><?= lang('Global.view-all') ?></span>
            <div class="bg-black w-full h-[1.5px]"></div>
        </div>
    </div>
    <div class="splide__track">
        <ul class="splide__list md:text-left text-center">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $pr): ?>
                    <li class="splide__slide flex flex-col">
                        <img src="<?= $pr['image'] ?>" alt="Produk" class="w-full h-[200px] object-cover mb-3 rounded shadow-lg" loading="lazy" />
                        <span><?= $pr['productname'] ?></span>
                        <span class="text-gray-500"><?= $pr['category'] ?></span>
                        <span class="text-xs"><?= $pr['dimension'] ?></span>
                        <span><?= 'Rp. ' . $pr['price'] ?></span>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</section>
<?= $this->include('template/v_footer') ?>
<script>
    $(window).on('load', function() {
        new Splide('.splide', {
            type: 'slide',
            perMove: 10,
            grid: {
                rows: 2,
                cols: 5,
                gap: {
                    row: '1rem',
                    col: '1rem',
                },
            },
            gap: '1rem',
            pagination: false,
            arrows: true,
            breakpoints: {
                768: {
                    perPage: 1,
                    grid: false,
                },
            },
        }).mount(window.splide.Extensions);
    })
</script>