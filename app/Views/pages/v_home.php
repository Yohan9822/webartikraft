<?= $this->include('template/v_header') ?>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<div
    x-data="slider()"
    x-init="init()"
    class="relative w-full h-[550px] overflow-hidden">
    <template x-for="(slide, i) in slides" :key="i">
        <div
            x-show="active === i"
            x-transition:enter="transition duration-700"
            x-transition:enter-start="scale-110 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transition duration-700"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-90 opacity-0"
            class="absolute inset-0 w-full h-full"
            :style="`background: url('${slide.image}') center center / cover no-repeat;`">
            <div class="absolute inset-0 bg-black/30"></div>
            <div
                class="absolute w-full h-full flex"
                :class="slide.position === 'left' ? 'items-end justify-start' : (slide.position === 'center' ? 'items-center justify-center' : 'items-start justify-end')">
                <div
                    class="p-10"
                    :class="slide.position === 'left' ? 'text-left' : (slide.position === 'center' ? 'text-center' : 'text-right')">
                    <div class="text-white text-3xl md:text-4xl font-medium max-w-xl mb-6" x-text="slide.text"></div>
                    <button class="mt-2 px-6 py-2 bg-white text-black rounded-full text-sm font-semibold shadow hover:bg-[#477524] hover:text-white transition" x-text="slide.button"></button>
                </div>
            </div>
        </div>
    </template>
    <div class="absolute right-8 bottom-6 flex gap-2 z-10">
        <template x-for="(slide, i) in slides" :key="i">
            <button
                class="w-3 h-3 rounded-full border border-white bg-white/40"
                :class="active === i ? 'bg-white' : 'bg-white/40'"
                @click="goTo(i)"></button>
        </template>
    </div>
</div>
<section class="h-max p-6 bg-[#f0e2c6] flex items-center justify-between">
    <div class="w-1/2 flex justify-center">
        <img src="<?= base_url('public/images/5.png') ?>" alt="Lab setup" class="max-h-[80vh] object-contain rounded-lg" />
    </div>

    <div class="w-1/2 text-center px-8">
        <p class="text-lg leading-relaxed text-black">
            Established in 2016, <strong class="text-[#477524]">Arti Kraft Indonesia</strong> focuses on designing, manufacturing, and selling handicrafts, home furnishings, lifestyle accessories, and furniture to embrace the creativity and quality of our local products that can drive the living standards of artisans in a better direction
        </p>
    </div>
</section>
<section class="bg-[#EAE8E0] px-10 py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
    <div class="group">
        <div class="overflow-hidden">
            <img src="<?= base_url('public/images/products/kitchen/1.jpg') ?>" alt="KITCHEN" loading="lazy" class="w-full h-[350px] object-cover rounded-lg shadow-lg" />
        </div>
        <div class="mt-4">
            <button class="w-full bg-[#c7b76c] cursor-pointer text-grey px-6 py-2 rounded-full transform transition-transform duration-300 group-hover:scale-105 hover:bg-[#477524] hover:text-white">
                KITCHEN
            </button>
        </div>
    </div>

    <div class="group">
        <div class="overflow-hidden">
            <img src="<?= base_url('public/images/products/storage/1.png') ?>" alt="STORAGE" loading="lazy" class="w-full h-[350px] object-cover rounded-lg shadow-lg" />
        </div>
        <div class="mt-4">
            <button class="w-full bg-[#c7b76c] cursor-pointer text-grey px-6 py-2 rounded-full transform transition-transform duration-300 group-hover:scale-105 hover:bg-[#477524] hover:text-white">
                STORAGE
            </button>
        </div>
    </div>

    <div class="group">
        <div class="overflow-hidden">
            <img src="<?= base_url('public/images/products/bags/1.jpg') ?>" alt="BAGS" loading="lazy" class="w-full h-[350px] object-cover rounded-lg shadow-lg" />
        </div>
        <div class="mt-4">
            <button class="w-full bg-[#c7b76c] cursor-pointer text-grey px-6 py-2 rounded-full transform transition-transform duration-300 group-hover:scale-105 hover:bg-[#477524] hover:text-white">
                BAGS
            </button>
        </div>
    </div>

    <div class="group">
        <div class="overflow-hidden">
            <img src="<?= base_url('public/images/products/basket/1.png') ?>" alt="BASKET" loading="lazy" class="w-full h-[350px] object-cover rounded-lg shadow-lg" />
        </div>
        <div class="mt-4">
            <button class="w-full bg-[#c7b76c] cursor-pointer text-grey px-6 py-2 rounded-full transform transition-transform duration-300 group-hover:scale-105 hover:bg-[#477524] hover:text-white">
                BASKET
            </button>
        </div>
    </div>
</section>
<section class="bg-[#f0e2c6] ">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-1">
        <div>
            <img src="<?= base_url('public/images/home/1.jpg') ?>" alt="Produk 1" class="w-full h-[300px] object-cover" />
        </div>

        <div>
            <img src="<?= base_url('public/images/home/2.jpg') ?>" alt="Produk 2" class="w-full h-[300px] object-cover" />
        </div>

        <div>
            <img src="<?= base_url('public/images/home/3.jpg') ?>" alt="Produk 3" class="w-full h-[300px] object-cover" />
        </div>
    </div>
</section>
<section class="py-16 bg-white text-center">
    <h2 class="text-[#477524] font-semibold text-sm uppercase tracking-wide">List of Clients</h2>
    <div class="w-20 h-1 bg-[#477524] mx-auto mt-2 mb-10 rounded"></div>

    <div class="flex flex-wrap justify-center items-center gap-12 px-6">
        <img src="<?= base_url('public/images/clients/3.png') ?>" alt="IKEA" class="h-16 object-contain">
        <img src="<?= base_url('public/images/clients/2.png') ?>" alt="H&M" class="h-16 object-contain">
        <img src="<?= base_url('public/images/clients/1.png') ?>" alt="Edelman" class="h-16 object-contain">
    </div>
</section>
<section class="py-16 px-4 bg-white">
    <h2 class="text-[#473328] font-semibold text-center uppercase text-sm tracking-widest mb-2">Product Overview</h2>
    <div class="w-20 h-1 bg-[#473328] mx-auto mb-10 rounded"></div>

    <?php
    $products = [
        [
            'productname' => 'Product 1',
            'description' => 'Kitchen Basket',
            'category' => 'Kitchen',
            'size' => '41 Dia x 60 (cm)',
            'colors' => ['#5B3E2C', '#CDB398'],
            'image' => base_url('public/images/products/kitchen/2.png'),
        ],
        [
            'productname' => 'Product 2',
            'description' => 'Product Storage',
            'category' => 'Storage',
            'size' => '36 Dia x 56 (cm)',
            'colors' => ['#5B3E2C', '#CDB398'],
            'image' => base_url('public/images/products/storage/2.png'),
        ],
        [
            'productname' => 'Product 3',
            'description' => 'Product Bags',
            'category' => 'Bags',
            'size' => '40 Dia x 41.5 (cm), 35 Dia x 37 (cm)',
            'colors' => [],
            'image' => base_url('public/images/products/bags/2.png'),
        ],
        [
            'productname' => 'Product 4',
            'description' => 'Product Basket',
            'category' => 'Basket',
            'size' => '36 Dia x 33 (cm)',
            'colors' => [],
            'image' => base_url('public/images/products/basket/2.png'),
        ],
    ];
    ?>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-8" id="load-datas">
        <?php foreach ($products as $product): ?>
            <div class="text-center">
                <img src="<?= $product['image'] ?>" alt="<?= $product['productname'] ?> Basket" class="mx-auto h-45 object-contain">
                <h3 class="font-bold text-sm mt-4"><?= $product['productname'] ?></h3>
                <p class="text-xs">
                    <?= $product['description'] ?><br>
                    <?= $product['size'] ?><br>
                    <?= $product['category'] ?>
                </p>
                <?php if (!empty($product['colors'])): ?>
                    <div class="flex justify-center gap-1 mt-2">
                        <?php foreach ($product['colors'] as $color): ?>
                            <div class="w-3 h-3 rounded-full" style="background: <?= $color ?>;"></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?= $this->include('template/v_footer') ?>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('slider', () => ({
            active: 0,
            slides: [{
                    image: '<?= base_url('public/images/slider/1.jpg') ?>',
                    text: 'A new and inspirational collection, offering products that embody both timeless elegance and captivating beauty.',
                    button: 'NEW ARRIVALS',
                    position: 'left'
                },
                {
                    image: '<?= base_url('public/images/slider/2.png') ?>',
                    text: 'Discover our curated selection for your unique lifestyle.',
                    button: 'DISCOVER',
                    position: 'center'
                },
                {
                    image: '<?= base_url('public/images/slider/3.jpg') ?>',
                    text: 'Experience the art of living with our exclusive pieces.',
                    button: 'EXPLORE',
                    position: 'right'
                }
            ],
            interval: null,
            start() {
                this.interval = setInterval(() => {
                    this.next();
                }, 5000);
            },
            stop() {
                clearInterval(this.interval);
            },
            next() {
                this.active = (this.active + 1) % this.slides.length;
            },
            goTo(i) {
                this.active = i;
            },
            init() {
                this.start();
            }
        }));
    });
</script>