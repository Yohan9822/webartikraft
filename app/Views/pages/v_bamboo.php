<?= $this->include('template/v_header') ?>
<div class="w-full h-full flex flex-col">
    <img src="<?= base_url('public/images/home/4.png') ?>" alt="gambar bamboo" class="w-full h-[600px] object-cover">
    <div class="my-8 text-center flex flex-col gap-4">
        <span class="text-5xl uppercase">beatifully engineered</span>
        <span class="text-lg lowercase">made from sustainable material</span>
    </div>
    <div class="grid grid-cols-5">
        <div class="col-span-2">
            <img src="<?= base_url('public/images/home/4.png') ?>" alt="gambar bamboo" class="w-full h-[500px] object-cover">
        </div>
        <div class="col-span-3">
            <img src="<?= base_url('public/images/home/5.jpg') ?>" alt="gambar bamboo" class="w-full h-[500px] object-cover">
        </div>
    </div>
</div>
<section class="py-8 px-[1rem] md:px-[3rem] bg-white">
    <div class="mb-4 flex items-start justify-between w-full">
        <h2 class="text-4xl uppercase">A BEAUTIFUL MATERIAL.</h2>
    </div>
    <p class="text-gray-800 w-full md:w-[40%]">
        We’ve created an entirely new and innovative high-performance
        material for commercial and residential spaces
    </p>
    <div class="flex flex-nowrap overflow-x-auto gap-4 py-4">
        <?php for ($s = 0; $s <= 10; $s++): ?>
            <div class="w-full md:w-1/3 flex flex-col flex-shrink-0 items-start justify-start text-left">
                <img src="<?= base_url('public/images/home/3.jpg') ?>" alt="Produk" class="w-full h-[450px] object-cover mb-3" />
            </div>
            <div class="w-full md:w-1/3 flex flex-col flex-shrink-0 items-start justify-start text-left">
                <img src="<?= base_url('public/images/home/4.png') ?>" alt="Produk" class="w-full h-[450px] object-cover mb-3" />
            </div>
            <div class="w-full md:w-1/3 flex flex-col flex-shrink-0 items-start justify-start text-left">
                <img src="<?= base_url('public/images/home/5.jpg') ?>" alt="Produk" class="w-full h-[450px] object-cover mb-3" />
            </div>
        <?php endfor; ?>
    </div>
</section>
<div class="w-full h-full mb-6">
    <div class="grid grid-cols-8 gap-4">
        <div class="col-span-8 md:col-span-4">
            <img src="<?= base_url('public/images/home/4.png') ?>" alt="gambar bamboo" class="w-full h-[400px] object-cover">
        </div>
        <div class="col-span-4 md:col-span-2">
            <img src="<?= base_url('public/images/home/3.jpg') ?>" alt="gambar bamboo" class="w-full h-[400px] object-cover">
        </div>
        <div class="col-span-4 md:col-span-2">
            <img src="<?= base_url('public/images/home/5.jpg') ?>" alt="gambar bamboo" class="w-full h-[400px] object-cover">
        </div>
    </div>
</div>
<section class="py-8 px-[1rem] md:px-[3rem] bg-white flex flex-col gap-4">
    <div class="mb-4 flex items-start justify-center w-full">
        <h2 class="text-4xl">Bamboo Laminated Solutions for Every Project</h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-gray-800">
        <p class="w-full md:w-[80%]">
            Discover the versatility and strength
            of bamboo laminated products from
            Arti Kraft Indonesia. Engineered for
            a wide range of applications, our
            bamboo panels are the ideal choice
            for everything from elegant table
            tops and home decor to heavy-duty
            industrial uses like container floors
            and deck panels.
        </p>
        <p class="w-full md:w-[80%]">
            Designed to withstand any weather
            conditions, our bamboo laminates
            are perfect for both indoor and
            outdoor projects. They offer not only
            durability but also a beautiful,
            natural aesthetic that elevates any
            space.
        </p>
        <p class="w-full md:w-[80%]">
            Choose bamboo — a sustainable,
            renewable resource — and
            experience the unmatched quality
            and reliability of Arti Kraft Indonesia.
        </p>
    </div>
</section>
<?= $this->include('template/v_footer') ?>