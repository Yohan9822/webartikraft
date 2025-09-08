<?= $this->include('template/v_header') ?>
<div
    x-data="slider()"
    x-init="init()"
    class="relative w-full h-[650px] overflow-hidden">
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
<section class="h-max p-6 flex items-center justify-center my-6">
    <div class="w-[80%] text-center">
        <p class="text-lg leading-relaxed text-black">
            <?= lang('Global.paragraph-1-home') ?>
        </p>
    </div>
</section>
<section class="pb-12 grid grid-cols-1 md:grid-cols-2 w-full">
    <div class="relative w-full h-[650px]">
        <img src="<?= base_url('public/images/home-left.jpg') ?>" alt="home left" class="w-full h-[650px] object-cover">
        <p class="absolute top-5 left-5 text-[17px] text-gray-800 font-medium leading-relaxed w-[75%]">
            <?= lang('Global.paragraph-2-home') ?> <a href="javascript:void(0)" class="text-gray font-semibold cursor-pointer italic hover:text-[#477524]"><?= lang('Global.clickMore') ?></a></p>
    </div>
    <div class="relative w-full h-[650px]">
        <img src="<?= base_url('public/images/home-right.png') ?>" alt="home right" class="w-full h-[650px] object-cover object-position-bottom">
        <p class="absolute bottom-5 left-5 text-[17px] text-gray-800 font-medium leading-relaxed w-[75%]">
            <?= lang('Global.paragraph-2-home') ?> <a href="javascript:void(0)" class="text-gray font-semibold cursor-pointer italic hover:text-[#477524]"><?= lang('Global.clickMore') ?></a></p>
    </div>
</section>
<section class="splide px-[1rem] md:px-[3rem]" aria-label="Image Slider">
    <div class="mb-8 flex md:flex-row flex-col items-start justify-between w-full">
        <h2 class="text-4xl uppercase"><?= lang('Global.inspiration') ?></h2>
        <div class="flex flex-col items-center justify-center text-[#545454] cursor-pointer hover:text-[#477524]">
            <span class="text-sm mb-1"><?= lang('Global.view-all') ?></span>
            <div class="bg-black w-full h-[1.5px]"></div>
        </div>
    </div>
    <div class="splide__track">
        <ul class="splide__list">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $pr): ?>
                    <li class="splide__slide flex flex-col">
                        <img src="<?= $pr['image'] ?>" alt="Produk" class="w-full h-[300px] md:h-[200px] object-cover mb-3 rounded shadow-lg" />
                        <span><?= $pr['productname'] ?></span>
                        <span class="text-gray-500"><?= $pr['category'] ?></span>
                        <span><?= 'Rp. ' . $pr['price'] ?></span>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="splide__slide flex flex-col">
                    <i>There is No Data Product</i>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</section>
<section class="py-16 px-[1rem] md:px-[3rem] bg-white text-center">
    <div class="mb-8 flex items-start justify-between w-full">
        <h2 class="text-4xl uppercase"><?= lang('Global.updates') ?></h2>
    </div>
    <div class="flex flex-nowrap overflow-x-auto gap-4 py-4">
        <?php if (!empty($updates)): ?>
            <?php foreach ($updates as $up): ?>
                <div class="w-full md:w-1/3 flex flex-col flex-shrink-0 items-start justify-start text-left">
                    <img src="<?= $up['image'] ?>" alt="Updates" class="w-full h-[450px] object-cover mb-3" />
                    <span class="text-xs text-gray-800"><?= $up['date'] ?></span>
                    <span class="font-medium text-base text-gray tracking-[0px]"><?= $up['caption'] ?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="w-full flex flex-col flex-shrink-0 items-center justify-center text-left">
                <i>There is no updates</i>
            </div>
        <?php endif; ?>
    </div>
</section>
<?= $this->include('template/v_footer') ?>
<script>
    $(window).on('load', function() {
        new Splide('.splide', {
            type: 'slide',
            perPage: 5,
            perMove: 1,
            gap: '1rem',
            pagination: false,
            arrows: true,
            breakpoints: {
                768: {
                    perPage: 1,
                },
            }
        }).mount();
    })

    document.addEventListener('alpine:init', () => {
        Alpine.data('slider', () => ({
            active: 0,
            slides: <?= json_encode($slides) ?>,
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