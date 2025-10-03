<?= $this->include('template/v_header') ?>

<div class="w-full h-full pb-10 flex flex-col gap-8">
    <section class="pt-8 pb-16 px-[1rem] md:px-[3rem] bg-white">

        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-1">
                <?= $row->productname ?>
            </h1>
            <span class="text-sm text-gray-500"><?= $row->categoryname ?></span>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">

            <div class="w-full lg:w-2/5 flex flex-col gap-4">
                <div id="zoom-container"
                    class="border rounded-lg overflow-hidden shadow-lg bg-gray-50 relative"
                    style="width: 500px; height: 500px; position: relative; overflow: hidden;">
                    <img id="main-image"
                        src="<?= is_array($row->payload->logo) ? $row->payload->logo[0] : $row->payload->logo ?>"
                        alt="<?= $row->productname ?>"
                        class="w-full h-full object-contain transition-transform duration-300 ease-in-out"
                        style="object-position: center center;" />
                </div>

                <div class="flex gap-3 overflow-x-auto">
                    <?php if (!empty($row->additionalimages)) : ?>
                        <?php foreach (json_decode($row->additionalimages) as $index => $image) : ?>
                            <div class="w-20 h-20 border <?= $index === 0 ? 'border-[#2F5D50]' : 'border-gray-300' ?> rounded-md p-1 cursor-pointer hover:border-[#2F5D50] transition-colors bg-gray-50"
                                onclick="document.getElementById('main-image').src='<?= getURL("public/uploads/products/$image") ?>'">
                                <img src="<?= getURL("public/uploads/products/$image") ?>"
                                    alt="Thumbnail <?= $index + 1 ?>"
                                    class="w-full h-full object-cover rounded" />
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="w-full lg:w-3/5">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Description</h2>

                <p class="text-gray-700 mb-6"><?= $row->description ?? '-' ?></p>

                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-bold mb-2">Material</h3>
                        <div class="flex items-center text-gray-600">
                            <span class="text-green-600 mr-2 mt-1">✓</span>
                            <span><?= $row->materialname ?></span>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold mb-2">Size</h3>
                        <?php if (isJson($row->dimension)) : ?>
                            <?php $dimensionData = json_decode($row->dimension, true); ?>
                            <?php foreach ($dimensionData as $key => $item) : ?>
                                <div class="flex items-start mb-4">
                                    <span class="text-green-600 mr-2 mt-1">✓</span>
                                    <div class="text-gray-600">
                                        <span class="font-semibold"><?= ucfirst($key) ?>:</span> <?= $item['size'] ?>
                                        <ul class="text-sm list-disc pl-5 mt-1 space-y-0.5">
                                            <li>Weight: <?= (!empty($item['weight']) ? $item['weight'] . ' KG' : '-') ?></li>
                                            <li>Color: <?= !empty($item['color']) ? $item['color'] : '-' ?></li>
                                        </ul>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="flex items-center text-gray-600">
                                <span class="text-green-600 mr-2 mt-1">✓</span>
                                <p class="text-gray-700"><?= $row->dimension ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        const $container = $('#zoom-container');
        const $image = $('#main-image');

        $container.on('mousemove', function(e) {
            const rect = $container[0].getBoundingClientRect();

            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;

            $image.css({
                'transform-origin': `${x}% ${y}%`,
                'transform': 'scale(2)'
            });
        });

        $container.on('mouseleave', function() {
            $image.css({
                'transform-origin': 'center center',
                'transform': 'scale(1)'
            });
        });
    });
</script>

<?= $this->include('template/v_footer') ?>