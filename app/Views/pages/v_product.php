<?= $this->include('template/v_header') ?>
<div class="w-full mt-8 pb-12">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row gap-8">
        <aside class="md:w-1/4 w-full mb-6 md:mb-0">
            <div class="bg-[#f5f3e7] rounded-xl p-4 shadow-sm">
                <h2 class="font-bold text-lg mb-6 text-center md:text-left">Category</h2>
                <ul class="space-y-4">
                    <li><button class="w-full text-left px-5 py-3 rounded-lg bg-[#e0dcc2] hover:bg-[#477524] hover:text-white transition-colors duration-300 cursor-pointer category-btn active:bg-[#477524] active:text-white focus:bg-[#477524] focus:text-white">KITCHEN</button></li>
                    <li><button class="w-full text-left px-5 py-3 rounded-lg bg-[#e0dcc2] hover:bg-[#477524] hover:text-white transition-colors duration-300 cursor-pointer category-btn active:bg-[#477524] active:text-white focus:bg-[#477524] focus:text-white">STORAGE</button></li>
                    <li><button class="w-full text-left px-5 py-3 rounded-lg bg-[#e0dcc2] hover:bg-[#477524] hover:text-white transition-colors duration-300 cursor-pointer category-btn active:bg-[#477524] active:text-white focus:bg-[#477524] focus:text-white">BAMBOO GLUEBOARD</button></li>
                    <li><button class="w-full text-left px-5 py-3 rounded-lg bg-[#e0dcc2] hover:bg-[#477524] hover:text-white transition-colors duration-300 cursor-pointer category-btn active:bg-[#477524] active:text-white focus:bg-[#477524] focus:text-white">SMALL FURNITURE</button></li>
                    <li><button class="w-full text-left px-5 py-3 rounded-lg bg-[#e0dcc2] hover:bg-[#477524] hover:text-white transition-colors duration-300 cursor-pointer category-btn active:bg-[#477524] active:text-white focus:bg-[#477524] focus:text-white">BAGS</button></li>
                    <li><button class="w-full text-left px-5 py-3 rounded-lg bg-[#e0dcc2] hover:bg-[#477524] hover:text-white transition-colors duration-300 cursor-pointer category-btn active:bg-[#477524] active:text-white focus:bg-[#477524] focus:text-white">BASKET</button></li>
                </ul>
            </div>
        </aside>
        <section class="md:w-3/4 w-full">
            <div class="relative flex justify-center items-center" style="height: 100px;">
                <h2 class="absolute top-0 left-1/2 -translate-x-1/2 text-center font-bold text-xl tracking-widest text-[#477524] z-10 w-full">PRODUCT OVERVIEW</h2>
                <img src="<?= base_url('public/images/border_curl.png') ?>" alt="curl border" class="absolute bottom-0 left-0 w-full h-[100px] object-contain z-0" />
            </div>
            <div id="product-list-loading" class="w-full flex text-center justify-center items-center py-12 hidden">
                <i class='bx bx-loader-alt bx-spin !text-[45px] text-[#477524]'></i>
            </div>
            <div id="product-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="product-card flex flex-col items-center p-4 rounded-lg transition-shadow duration-300 cursor-pointer group hidden hover:shadow-[0_2px_10px_0_#477524]">
                    <img src="" alt="" loading="lazy" class="product-img h-32 object-contain mb-2 group-hover:scale-105 transition-transform duration-300" />
                    <div class="product-name font-bold mt-2"></div>
                    <div class="product-desc text-sm text-center"></div>
                    <div class="product-size text-sm text-center"></div>
                    <div class="product-material text-xs text-[#7a6e4a] mt-1"></div>
                    <div class="product-colors flex gap-2 mt-2"></div>
                </div>
            </div>
            <div class="flex justify-between items-center mt-8 px-2">
                <div id="pagination-info" class="text-sm text-gray-600"></div>
                <div class="flex items-center gap-2">
                    <button id="prev-page" class="cursor-pointer px-4 py-2 rounded bg-[#e0dcc2] hover:bg-[#477524] hover:text-white transition-colors duration-300">Previous</button>
                    <div id="page-buttons" class="flex gap-1"></div>
                    <button id="next-page" class="cursor-pointer px-4 py-2 rounded bg-[#e0dcc2] hover:bg-[#477524] hover:text-white transition-colors duration-300">Next</button>
                </div>
            </div>
        </section>
    </div>
</div>
<?= $this->include('template/v_footer') ?>
<script>
    function showProductLoading(show) {
        if (show) {
            $('#product-list').hide();
            $('#product-list-loading').show();
        } else {
            $('#product-list-loading').hide();
            $('#product-list').show();
        }
    }
    $(document).ready(function() {
        $('.category-btn').on('click', function() {
            $('.category-btn').removeClass('!bg-[#477524] !text-white');
            $(this).addClass('!bg-[#477524] !text-white');
        });

        // Dummy product data, bisa ditambah sesuai kebutuhan
        const products = [{
                name: 'Product 1',
                desc: 'Kitchen 1',
                size: '41 Dia x 60 (cm)',
                material: 'Bamboo',
                img: '<?= base_url('public/images/products/kitchen/3.png') ?>',
                colors: ['#2d2217', '#b6b08a', '#e0dcc2']
            },
            {
                name: 'Product 2',
                desc: 'Kitchen 2',
                size: '41 Dia x 60 (cm)',
                material: 'Bamboo',
                img: '<?= base_url('public/images/products/kitchen/4.png') ?>',
                colors: ['#2d2217', '#b6b08a', '#e0dcc2']
            },
            {
                name: 'Product 3',
                desc: 'Storage 1',
                size: '41 Dia x 60 (cm)',
                material: 'Bamboo',
                img: '<?= base_url('public/images/products/storage/3.png') ?>',
                colors: ['#2d2217', '#e0dcc2']
            },
            {
                name: 'Product 4',
                desc: 'Storage 2',
                size: '41 Dia x 60 (cm)',
                material: 'Bamboo',
                img: '<?= base_url('public/images/products/storage/4.png') ?>',
                colors: []
            },
            {
                name: 'Product 5',
                desc: 'Bags 1',
                size: '41 Dia x 60 (cm)',
                material: 'Bamboo',
                img: '<?= base_url('public/images/products/bags/3.png') ?>',
                colors: []
            },
            {
                name: 'Product 6',
                desc: 'Bags 2',
                size: '41 Dia x 60 (cm)',
                material: 'Bamboo',
                img: '<?= base_url('public/images/products/bags/4.png') ?>',
                colors: []
            },
            {
                name: 'Product 7',
                desc: 'Basket 1',
                size: '41 Dia x 60 (cm)',
                material: 'Bamboo',
                img: '<?= base_url('public/images/products/basket/3.png') ?>',
                colors: []
            },
            {
                name: 'Product 8',
                desc: 'Basket 2',
                size: '41 Dia x 60 (cm)',
                material: 'Bamboo',
                img: '<?= base_url('public/images/products/basket/4.png') ?>',
                colors: ['#2d2217', '#e0dcc2']
            },
            {
                name: 'Product 9',
                desc: 'Kitchen 3',
                size: '41 Dia x 60 (cm)',
                material: 'Bamboo',
                img: '<?= base_url('public/images/products/kitchen/2.png') ?>',
                colors: ['#2d2217', '#e0dcc2']
            },
            {
                name: 'Product 10',
                desc: 'Storage 3',
                size: '41 Dia x 60 (cm)',
                material: 'Bamboo',
                img: '<?= base_url('public/images/products/storage/2.png') ?>',
                colors: ['#2d2217']
            },
            {
                name: 'Product 11',
                desc: 'Bags 3',
                size: '41 Dia x 60 (cm)',
                material: 'Bamboo',
                img: '<?= base_url('public/images/products/bags/2.png') ?>',
                colors: []
            },
            {
                name: 'Product 12',
                desc: 'Basket 3',
                size: '41 Dia x 60 (cm)',
                material: 'Bamboo',
                img: '<?= base_url('public/images/products/basket/2.png') ?>',
                colors: ['#2d2217', '#e0dcc2']
            },
        ];
        const perPage = 10;
        let currentPage = 1;
        const totalData = products.length;
        const totalPages = Math.ceil(totalData / perPage);

        function renderProducts(page) {
            showProductLoading(true);
            setTimeout(function() {
                const start = (page - 1) * perPage;
                const end = Math.min(start + perPage, totalData);
                const $list = $('#product-list');
                $list.find('.product-card:not(.hidden)').remove();
                for (let i = start; i < end; i++) {
                    const p = products[i];
                    const $card = $list.find('.product-card.hidden').clone().removeClass('hidden');
                    $card.find('.product-img').attr('src', p.img).attr('alt', p.name);
                    $card.find('.product-name').text(p.name);
                    $card.find('.product-desc').text(p.desc);
                    $card.find('.product-size').text(p.size);
                    $card.find('.product-material').text(p.material);
                    const $colors = $card.find('.product-colors').empty();
                    p.colors.forEach(c => {
                        $colors.append(`<span class="w-4 h-4 rounded-full" style="background:${c};display:inline-block;"></span>`);
                    });
                    $list.append($card);
                }
                $('#pagination-info').text(`Show ${end} of ${totalData} Total Data`);
                $('#prev-page').prop('disabled', page === 1);
                $('#next-page').prop('disabled', page === totalPages);
                renderPageButtons(page);
                showProductLoading(false);
            }, 500);
        }

        function renderPageButtons(page) {
            const $container = $('#page-buttons').empty();
            let startPage = 1;
            let endPage = totalPages;
            if (totalPages > 3) {
                if (page <= 2) {
                    startPage = 1;
                    endPage = 3;
                } else if (page >= totalPages - 1) {
                    startPage = totalPages - 2;
                    endPage = totalPages;
                } else {
                    startPage = page - 1;
                    endPage = page + 1;
                }
            }
            for (let i = startPage; i <= endPage; i++) {
                const $btn = $(`<button class="cursor-pointer px-3 py-1 rounded ${i === page ? 'bg-[#477524] text-white' : 'bg-[#e0dcc2] hover:bg-[#477524] hover:text-white'} transition-colors duration-300">${i}</button>`);
                if (i === page) $btn.attr('disabled', true);
                $btn.on('click', function() {
                    currentPage = i;
                    renderProducts(currentPage);
                });
                $container.append($btn);
            }
        }

        $('#prev-page').on('click', function() {
            if (currentPage > 1) {
                currentPage--;
                renderProducts(currentPage);
            }
        });
        $('#next-page').on('click', function() {
            if (currentPage < totalPages) {
                currentPage++;
                renderProducts(currentPage);
            }
        });

        $('#product-list').on('click', '.product-card', function() {
            toPage('products/detail/1');
        });

        renderProducts(currentPage);
    });
</script>