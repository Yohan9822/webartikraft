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
<?php if (!empty($row->content)) : ?>
    <section class="h-max px-[1rem] md:px-[3rem] my-6">
        <?= $row->content; ?>
    </section>
<?php else: ?>
    <section class="h-max p-6 flex items-center justify-center my-6">
        <div class="w-full text-center px-6 flex flex-col gap-5">
            <p class="text-lg leading-relaxed text-black italic">
                <?= lang('Global.paragraph-1-home') ?>
            </p>
            <p class="text-gray-800">
                <?= lang('Global.company-1') ?>
            </p>
        </div>
    </section>
    <section class="py-6">
        <div class="px-[1rem] md:px-[3rem]">
            <div class="mb-8 flex items-start justify-between w-full">
                <h2 class="text-4xl uppercase"><?= lang('Global.company-title-1') ?></h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <p class="text-gray-800">
                    <span class="italic font-semibold"><?= lang('Global.parap-company-1') ?></span>
                    <br>
                    <br>
                    <?= lang('Global.parap-company-2') ?>
                    <br>
                    <br>
                    <?= lang('Global.parap-company-3') ?>
                    <br>
                    <br>
                    <?= lang('Global.parap-company-4') ?>
                </p>
                <p class="text-gray-800">
                    <span class="italic font-semibold"><?= lang('Global.company-title-2') ?></span>
                    <br>
                    <br>
                    <?= lang('Global.parap-company-5') ?>
                    <br>
                    <br>
                    <span class="italic font-semibold"><?= lang('Global.company-title-3') ?></span>
                    <br>
                    <br>
                    <?= lang('Global.parap-company-6') ?>
                    <br>
                    <br>
                    <?= lang('Global.parap-company-7') ?>
                </p>
            </div>
        </div>
        <div class="my-8">
            <img data-src="<?= base_url('public/images/home/8.jpg') ?>" alt="gambar company" class="lazy w-full h-[650px] object-cover">
        </div>
    </section>
    <section class="pb-[4rem] px-[1rem] md:px-[3rem]">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="flex flex-col gap-5">
                <div class="mb-8 flex items-start justify-between w-full">
                    <h2 class="text-4xl uppercase"><?= lang('Global.our-vision') ?></h2>
                </div>
                <p class="text-gray-800">
                    <?= lang('Global.parap-vision') ?>
                </p>
            </div>
            <div class="flex flex-col gap-5">
                <div class="mb-8 flex items-start justify-between w-full">
                    <h2 class="text-4xl uppercase"><?= lang('Global.our-value') ?></h2>
                </div>
                <p class="text-gray-800">
                    <?= lang('Global.parap-value-1') ?>
                    <br>
                    <br>
                    <?= lang('Global.parap-value-2') ?>
                    <br>
                    <br>
                    <?= lang('Global.parap-value-3') ?>
                </p>
            </div>
        </div>
    </section>
<?php endif; ?>
<section class="py-12 px-[1rem] md:px-[3rem] bg-white text-center">
    <div class="mb-8 flex items-start justify-between w-full">
        <h2 class="text-4xl uppercase"><?= lang('Global.updates') ?></h2>
    </div>
    <div class="flex flex-nowrap overflow-x-auto gap-4 py-4">
        <?php if (!empty($updates)): ?>
            <?php foreach ($updates as $up): ?>
                <div class="w-full md:w-1/3 flex flex-col flex-shrink-0 items-start justify-start transition-all duration-300 cursor-pointer hover:brightness-80 text-left" onclick="toPage('<?= getURL('updates/detail/' . $up['id']) ?>')">
                    <img data-src="<?= $up['image'] ?>" alt="Updates" class="lazy w-full h-[450px] object-cover mb-3" />
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