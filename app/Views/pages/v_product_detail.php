<?= $this->include('template/v_header') ?>
<div class="w-full mt-8 pb-12">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row gap-8">
        <div class="md:w-1/2 w-full flex flex-col">
            <div class="w-full flex justify-center mb-4">
                <div class="main-image-parent overflow-hidden rounded-lg border w-full h-120 flex items-center justify-center cursor-zoom-in">
                    <img id="main-image" src="<?= base_url('public/images/products/1.png') ?>" alt="Product Image" class="w-full h-full object-contain transition-transform duration-300" />
                </div>
            </div>
            <div class="flex gap-2 justify-left">
                <div class="thumb-parent overflow-hidden rounded border w-16 h-16 flex items-center justify-center cursor-zoom-in">
                    <img src="<?= base_url('public/images/products/1.png') ?>" class="thumb-img w-16 h-16 object-contain transition-transform duration-300 rounded" />
                </div>
                <div class="thumb-parent overflow-hidden rounded border w-16 h-16 flex items-center justify-center cursor-zoom-in">
                    <img src="<?= base_url('public/images/products/1.png') ?>" class="thumb-img w-16 h-16 object-contain transition-transform duration-300 rounded" />
                </div>
                <div class="thumb-parent overflow-hidden rounded border w-16 h-16 flex items-center justify-center cursor-zoom-in">
                    <img src="<?= base_url('public/images/6.jpg') ?>" class="thumb-img w-16 h-16 object-contain transition-transform duration-300 rounded" />
                </div>
            </div>
        </div>
        <div class="md:w-1/2 w-full flex flex-col gap-4">
            <h1 class="text-2xl font-bold text-[#477524]">Narawita</h1>
            <div class="text-gray-700 text-base">Basket with handle</div>
            <div class="text-sm text-gray-500">41 Dia x 60 (cm)</div>
            <div class="text-sm text-gray-500">Material: Bamboo</div>
            <div class="flex gap-2 items-center mt-2">
                <span class="text-sm">Color:</span>
                <span class="w-5 h-5 rounded-full inline-block" style="background:#2d2217"></span>
                <span class="w-5 h-5 rounded-full inline-block" style="background:#b6b08a"></span>
            </div>
            <!-- <div class="mt-4">
                <button class="px-6 py-3 rounded bg-[#1F2937] text-white font-bold hover:bg-[#36591a] transition">Add to Cart</button>
            </div> -->
            <div class="mt-6">
                <h2 class="font-semibold text-lg mb-2">Product Description</h2>
                <p class="text-gray-600">Narawita is a basket with handle, crafted from high quality bamboo. Perfect for home decor or storage. Size: 41 Dia x 60 (cm).</p>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var $mainImg = $('#main-image');
        var $mainParent = $('.main-image-parent');
        $mainParent.on('mousemove', function(e) {
            var parentOffset = $(this).offset();
            var x = e.pageX - parentOffset.left;
            var y = e.pageY - parentOffset.top;
            var w = $(this).width();
            var h = $(this).height();
            var px = ((x / w) * 100).toFixed(2);
            var py = ((y / h) * 100).toFixed(2);
            $mainImg.css({
                'transform': 'scale(1.5)',
                'transform-origin': px + '% ' + py + '%'
            });
        });
        $mainParent.on('mouseleave', function() {
            $mainImg.css({
                'transform': 'scale(1)',
                'transform-origin': '50% 50%'
            });
        });
        $('.thumb-parent').on('mouseenter', function() {
            $(this).find('.thumb-img').css('transform', 'scale(1.15)');
        }).on('mouseleave', function() {
            $(this).find('.thumb-img').css('transform', 'scale(1)');
        });
        $('.thumb-img').on('click', function() {
            var src = $(this).attr('src');
            $('#main-image').attr('src', src);
            $('.thumb-img').removeClass('ring-[#1F2937]').removeClass('ring-2');
            $(this).addClass('ring-2 ring-[#1F2937]');
        });
        $('.thumb-img').first().addClass('ring-2 ring-[#1F2937]');
    });
</script>
<?= $this->include('template/v_footer') ?>