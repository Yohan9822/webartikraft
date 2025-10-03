<?= $this->include('template/v_header') ?>

<div class="w-full h-full pb-10 flex flex-col gap-8">
    <img src="<?= base_url('public/images/home/9.jpg') ?>" alt="gambar furnishing" class="object-cover w-full h-[550px]" loading="lazy">

    <section class="splide py-16 px-[1rem] md:px-[3rem] bg-white text-center">
        <div class="mb-8 flex md:flex-row flex-col items-start justify-between w-full gap-4">
            <div class="flex items-center gap-3">
                <h2 class="text-4xl uppercase whitespace-nowrap"><?= lang('Global.products') ?></h2>
                <span class="text-[#2F5D50] font-semibold">(<span id="count-product">0</span> Products)</span>
            </div>
            <div class="flex flex-col md:flex-row gap-4 items-stretch md:items-center w-full md:w-auto">
                <select name="category" id="filter-category"
                    class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#477524] shadow-sm w-full md:w-auto">
                    <option value="">All Categories</option>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= strtolower($cat->typecode) ?>"><?= $cat->typename ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <div class="flex items-center border border-gray-300 rounded shadow-sm w-full md:w-auto">
                    <input type="text" name="search" id="search-key" placeholder="Search by name..."
                        class="p-2 w-full focus:outline-none focus:ring-0 rounded-l transition-all duration-300">
                </div>
            </div>
        </div>
        <div class="splide__track">
            <ul class="splide__list md:text-left text-center min-h-[200px]" id="product-list">
            </ul>
        </div>
    </section>
</div>

<?= $this->include('template/v_footer') ?>

<script>
    var productSplide = null;
    let imagesToLoadCount = 0;

    function handleImageLoading() {
        imagesToLoadCount--;

        if (imagesToLoadCount < 0) {
            imagesToLoadCount = 0;
        }

        if (imagesToLoadCount === 0) {
            $('.splide').removeClass('skeleton-mode');
        }
    }

    function createSkeletonHtml(count = 10) {
        let skeletonHtml = '';
        const skeletonItem = `
        <li class="splide__slide flex flex-col animate-pulse product-skeleton"> 
            <div class="w-full h-[200px] bg-gray-200 mb-3 rounded shadow-lg"></div>
            <div class="h-4 bg-gray-200 rounded w-3/4 mb-1"></div>
            <div class="h-3 bg-gray-200 rounded w-1/2 mb-1"></div>
            <div class="h-3 bg-gray-200 rounded w-1/4 text-xs"></div>
        </li>
    `;
        for (let i = 0; i < count; i++) {
            skeletonHtml += skeletonItem;
        }
        return skeletonHtml;
    }

    function loadProducts(search = '', category = null) {
        $.ajax({
            url: '<?= getURL('furnishing/getproducts') ?>',
            type: 'post',
            dataType: 'json',
            data: {
                search: search,
                category: category
            },

            beforeSend: function() {
                if (productSplide) {
                    productSplide.destroy(true);
                    productSplide = null;
                }
                imagesToLoadCount = 0;

                $('.splide').addClass('skeleton-mode');
                $('#product-list').empty().append(createSkeletonHtml(10));
            },

            success: function(response) {
                $('#product-list').empty();

                if (response.sukses == 1) {
                    var datas = response.data;

                    $('#count-product').text(datas.length);

                    if (datas && datas.length > 0) {
                        var html = '';
                        imagesToLoadCount = datas.length;

                        for (var i = 0; i < datas.length; i++) {
                            let dimensionDisplay = datas[i]['dimension'] || '';
                            if (isJson(dimensionDisplay)) {
                                let dimensionData = JSON.parse(dimensionDisplay);
                                let activeSizes = Object.values(dimensionData || {}).filter(d => d.isactive == "1");
                                dimensionDisplay = activeSizes.length > 0 ? activeSizes[0].size : '';
                            }

                            html += `
                        <li class="splide__slide flex flex-col product-item cursor-pointer transition-all duration-300 hover:brightness-80" style="opacity: 0;" onclick="detailProduct('${datas[i]['id']}')">
                            <img src="${datas[i]['image']}" 
                                 alt="Produk" 
                                 class="w-full h-[200px] object-cover mb-3 rounded shadow-lg" 
                                 loading="lazy"
                                 onload="this.parentNode.style.opacity=1; handleImageLoading();" />
                            <span class="product-name">${datas[i]['productname']}</span>
                            <span class="product-category text-gray-500">${datas[i]['category']}</span>
                            <span class="text-xs">${dimensionDisplay}</span>
                        </li>
                        `;
                        }
                        $('#product-list').append(html);
                        productSplide = loadSplide();

                    } else {
                        $('.splide').removeClass('skeleton-mode');
                        $('#product-list').html(`
                        <li class="splide__slide w-full col-span-5 text-gray-500" style="width: 100%;">
                            No products found.
                        </li>
                    `);
                    }
                } else {
                    $('.splide').removeClass('skeleton-mode');
                    showError(response.pesan);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $('.splide').removeClass('skeleton-mode');
                $('#product-list').empty().html(`
                <li class="splide__slide w-full col-span-5 text-red-500" style="width: 100%;">
                    Error loading products: ${thrownError}
                </li>
            `);
                showError(thrownError);
            }
        });
    }

    function detailProduct(productid) {
        window.location.href = '<?= getURL('furnishing/detail') ?>' + '/' + productid;
    }

    function loadSplide() {
        var splideInstance = new Splide('.splide', {
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
        });

        if (window.splide && window.splide.Extensions && window.splide.Extensions.Grid) {
            splideInstance.mount({
                Grid: window.splide.Extensions.Grid
            });
        } else {
            splideInstance.mount(window.splide.Extensions);
        }

        return splideInstance;
    }

    function isJson(str) {
        try {
            JSON.parse(str);
            return true;
        } catch (e) {
            return false;
        }
    }

    $(function() {
        loadProducts();
        let typingTimer;
        const doneTypingInterval = 500;

        const $searchKey = $('input[name="search"]');
        const $categorySelect = $('select[name="category"]');

        $searchKey.on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                loadProducts($searchKey.val(), $categorySelect.val());
            }, doneTypingInterval);
        });

        $categorySelect.on('change', function() {
            loadProducts($searchKey.val(), $categorySelect.val());
        });

        $('.search-btn').on('click', function() {
            loadProducts($searchKey.val(), $categorySelect.val());
        });
    })
</script>