<?= $this->include('template/v_header') ?>
<section class="py-8 px-[1rem] md:px-[3rem] bg-white">
    <div class="mb-8 flex items-start justify-between w-full">
        <h2 class="text-4xl uppercase"><?= lang('Global.updates') ?></h2>
    </div>

    <div class="w-full overflow-x-auto scroll-smooth">
        <div class="flex flex-nowrap gap-6" style="scroll-snap-type: x mandatory;">
            <?php if (!empty($updates)): ?>
                <?php
                $chunks = array_chunk($updates, 3);
                foreach ($chunks as $chunk):
                ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 flex-shrink-0 w-full scroll-snap-align-start h-max">
                        <?php foreach ($chunk as $up): ?>
                            <div class="flex flex-col items-start justify-start text-left cursor-pointer transition-all duration-300 hover:brightness-80" onclick="toPage('<?= getURL('updates/detail/' . $up['id']) ?>')">
                                <img data-src="<?= $up['image'] ?>"
                                    alt="Updates"
                                    class="lazy w-full h-[300px] object-cover mb-3" />
                                <span class="text-xs text-gray-800"><?= $up['date'] ?></span>
                                <span class="font-medium text-base text-gray-800 tracking-[0px]">
                                    <?= $up['caption'] ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="w-full flex flex-col items-center justify-center">
                    <i>There is no updates</i>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= $this->include('template/v_footer') ?>