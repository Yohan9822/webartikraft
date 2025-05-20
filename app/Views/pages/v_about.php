<?= $this->include('template/v_header') ?>
<div class="w-full pt-12 pb-16">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-2xl md:text-3xl font-normal text-center mb-2 tracking-wide">Our Story</h1>
        <div class="flex justify-center mb-4">
            <div class="w-40 h-0.5 bg-black"></div>
        </div>
        <p class="text-center text-sm md:text-base max-w-2xl mx-auto mb-12">
            Established in 2016, Arti Kraft Indonesia focuses on designing, manufacturing, and selling handicrafts, home furnishings, lifestyle accessories, and furniture to embrace the creativity and quality of our local products that can drive the living standards of artisans in a better direction.
        </p>
        <div class="flex flex-col md:flex-row md:items-start gap-8 mb-16">
            <div class="md:w-1/2 w-full">
                <h2 class="text-2xl font-normal mb-4 tracking-wide">History</h2>
                <p class="text-sm md:text-base leading-relaxed mb-2">
                    Arti Kraft Indonesia has a manufacturing facility, enhanced with cutting-edge technologies and machines to process production. Our factory, located in Tasikmalaya - West Java, is the heart of our operations.
                </p>
                <p class="text-sm md:text-base leading-relaxed mb-2">
                    Artikraft is our trademark for our product line. Arti derives from a Sanskrit word which means "meaning", while Kraft derives from the English word "craft" which means "handmade".
                </p>
                <p class="text-sm md:text-base leading-relaxed">
                    In every piece of "Artikraft" product, there is a meaning that defines the product's purpose, and there is a story that conveys the artisanal workmanship going into each product.
                </p>
            </div>
            <div class="md:w-1/2 w-full flex justify-center">
                <img src="<?= base_url('public/images/home/1.jpg') ?>" alt="Our Story" class="w-full max-w-xl rounded object-cover" style="min-height:320px;max-height:340px;" />
            </div>
        </div>
    </div>
</div>
<div class="w-full flex flex-col md:flex-row mb-16" style="margin-left:0;margin-right:0;">
    <div class="md:w-1/2 w-full">
        <img src="<?= base_url('public/images/4.png') ?>" alt="Arti Kraft Box" class="w-full h-full object-cover" style="min-height:220px;max-height:260px;" />
    </div>
    <div class="md:w-1/2 w-full flex flex-col justify-center items-center bg-[#f5f3e7] py-8">
        <div class="mb-8">
            <h3 class="text-lg font-normal text-center mb-2 tracking-wide">Arti (Ar - tee)</h3>
            <p class="text-sm text-center">From Sanskrit, meaning "meaning" or "purpose"</p>
        </div>
        <div>
            <h3 class="text-lg font-normal text-center mb-2 tracking-wide">Kraft (Kraft)</h3>
            <p class="text-sm text-center">From English, meaning "craft" or "handmade"</p>
        </div>
    </div>
</div>
<div class="w-full pt-0 pb-0">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-start gap-8 mb-16">
            <div class="md:w-1/2 w-full">
                <h2 class="text-2xl font-normal mb-4 tracking-wide">Brand Philosophy</h2>
                <p class="text-sm md:text-base leading-relaxed mb-2">
                    <span class="text-[#477524]">Arti Kraft Indonesia</span> furnishes your space with an aesthetic look of Indonesia cultural heritage and comfort at the same time. To meet the expectations of every need, style, and preference, Arti Kraft Indonesia has a comprehensive choice of handicraft and furnishing with a wide variety of design and high-quality raw material.
                </p>
                <p class="text-sm md:text-base leading-relaxed">
                    We believe in applying EFFICIENT ECO-FRIENDLY production method to manufacture excellent quality product. All of our products are produced using all-natural process to ensure they are SAFE and suitable for use, and they do not harm our environment.
                </p>
            </div>
            <div class="md:w-1/2 w-full flex justify-center">
                <img src="<?= base_url('public/images/3.png') ?>" alt="Brand Philosophy" class="w-full max-w-xl rounded object-cover" style="min-height:320px;max-height:340px;" />
            </div>
        </div>
    </div>
</div>
<div class="w-full bg-[#f5f3e7] py-8 mb-12" style="margin-left:0;margin-right:0;">
    <div class="max-w-3xl mx-auto text-center">
        <p class="italic text-base md:text-lg font-medium mb-2">
            "In every piece of Artikraft product, there is a meaning that defines the product's purpose, and there is a story that conveys the artisanal workmanship going into each product."
        </p>
        <div class="text-sm md:text-base font-semibold mt-2 text-[#477524]">– Arti Kraft Indonesia</div>
    </div>
</div>
<div class="text-center mb-8">
    <p class="text-base md:text-lg max-w-2xl mx-auto mb-8">
        We offer a wide range of handicrafts and furnishings, featuring everything from home decor to furniture. With a focus on quality and design, we ensure prompt delivery to your doorstep, wherever you are in the world.
    </p>
    <div class="flex flex-col md:flex-row justify-center gap-8">
        <img src="<?= base_url('public/images/products/basket/1.png') ?>" alt="Product 1" class="w-60 h-48 object-cover rounded" />
        <img src="<?= base_url('public/images/products/kitchen/1.jpg') ?>" alt="Product 2" class="w-60 h-48 object-cover rounded" />
        <img src="<?= base_url('public/images/slider/2.png') ?>" alt="Product 3" class="w-60 h-48 object-cover rounded" />
    </div>
</div>
<?= $this->include('template/v_footer') ?>