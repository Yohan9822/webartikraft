<div class="sticky top-0 bg-white z-[999] shadow-lg px-4 lg:px-[3rem]">
    <nav class="w-full bg-white">
        <div id="top-bar" class="w-full lg:max-w-7xl mx-auto flex items-center justify-end py-2 text-sm">
            <div class="relative flex items-center gap-2">
                <!-- Search -->
                <div id="search-wrapper" class="relative">
                    <button id="search-btn" class="flex items-center justify-center w-8 h-8 rounded-md hover:bg-gray-50 text-[#545454]">
                        <i class='bx bx-search text-lg'></i>
                    </button>
                    <input
                        type="text"
                        id="search-input"
                        placeholder="Search..."
                        class="hidden px-3 py-1 h-8 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-[#477524] w-40">
                </div>

                <!-- Language -->
                <div class="relative">
                    <button id="lang-btn" class="flex items-center gap-2 cursor-pointer px-3 py-1 rounded-md hover:bg-gray-50 focus:border-none">
                        <img src="https://flagcdn.com/w20/gb.png" alt="English" class="w-5 h-3 object-cover" id="current-lang-flag">
                        <span class="text-[#545454] text-small" id="current-lang-text">English</span>
                        <i class="bx bx-chevron-down text-[#477524]"></i>
                    </button>
                    <div id="lang-menu" class="hidden absolute z-[9] right-0 mt-1 w-40 bg-white rounded-md border border-gray-300 shadow-lg">
                        <button class="lang-option flex items-center gap-2 text-small text-[#545454] w-full px-3 py-2 hover:bg-[#477524]/30 text-left rounded cursor-pointer" data-lang="en">
                            <img src="https://flagcdn.com/w20/gb.png" alt="English" class="w-5 h-3 object-cover">
                            <?= lang('Global.langopt-en') ?>
                        </button>
                        <button class="lang-option flex items-center gap-2 text-small text-[#545454] w-full px-3 py-2 hover:bg-[#477524]/30 text-left rounded cursor-pointer" data-lang="id">
                            <img src="https://flagcdn.com/w20/id.png" alt="Indonesia" class="w-5 h-3 object-cover">
                            <?= lang('Global.langopt-id') ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Logo + Desktop Menu -->
    <div class="flex justify-between items-center lg:justify-center lg:items-end pb-4 gap-6">
        <div class="text-center">
            <img src="<?= base_url('public/logo_crop.png') ?>" alt="Logo Artikraft" class="w-32 lg:w-42">
        </div>

        <!-- Mobile button -->
        <button id="mobile-menu-btn" class="lg:hidden text-2xl text-[#545454] focus:outline-none">
            <i class='bx bx-menu'></i>
        </button>

        <!-- Desktop menu -->
        <div id="desktop-menu" class="hidden lg:flex justify-center items-end gap-10">
            <a href="<?= base_url('home') ?>" class="relative px-2 py-1 nav-link font-normal tracking-[1px] uppercase text-sm text-[#545454] hover:text-[#477524] group transition-all duration-300">
                <?= lang('Global.nav-home') ?>
                <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-[#477524] transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="<?= base_url('company') ?>" class="relative px-2 py-1 nav-link font-normal tracking-[1px] uppercase text-sm text-[#545454] hover:text-[#477524] group transition-all duration-300">
                <?= lang('Global.nav-company') ?>
                <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-[#477524] transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="<?= base_url('furnishing') ?>" class="relative px-2 py-1 nav-link font-normal tracking-[1px] uppercase text-sm text-[#545454] hover:text-[#477524] group transition-all duration-300">
                <?= lang('Global.nav-furnishing') ?>
                <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-[#477524] transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="<?= base_url('bamboo') ?>" class="relative px-2 py-1 nav-link font-normal tracking-[1px] uppercase text-sm text-[#545454] hover:text-[#477524] group transition-all duration-300">
                <?= lang('Global.nav-bamboo') ?>
                <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-[#477524] transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="javascript:void(0)" class="relative px-2 py-1 nav-link font-normal tracking-[1px] uppercase text-sm text-[#545454] hover:text-[#477524] group transition-all duration-300">
                <?= lang('Global.nav-updates') ?>
                <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-[#477524] transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="<?= base_url('contact') ?>" class="relative px-2 py-1 nav-link font-normal tracking-[1px] uppercase text-sm text-[#545454] hover:text-[#477524] group transition-all duration-300">
                <?= lang('Global.nav-contact') ?>
                <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-[#477524] transition-all duration-300 group-hover:w-full"></span>
            </a>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden w-full py-4 text-left border-t border-gray-200">
        <a href="<?= base_url('home') ?>" class="block py-2 text-sm text-[#545454] hover:text-[#477524] uppercase border-b border-gray-200 nav-link"><?= lang('Global.nav-home') ?></a>
        <a href="<?= base_url('company') ?>" class="block py-2 text-sm text-[#545454] hover:text-[#477524] uppercase border-b border-gray-200 nav-link"><?= lang('Global.nav-company') ?></a>
        <a href="<?= base_url('furnishing') ?>" class="block py-2 text-sm text-[#545454] hover:text-[#477524] uppercase border-b border-gray-200 nav-link"><?= lang('Global.nav-furnishing') ?></a>
        <a href="<?= base_url('bamboo') ?>" class="block py-2 text-sm text-[#545454] hover:text-[#477524] uppercase border-b border-gray-200 nav-link"><?= lang('Global.nav-bamboo') ?></a>
        <a href="javascript:void(0)" class="block py-2 text-sm text-[#545454] hover:text-[#477524] uppercase border-b border-gray-200 nav-link"><?= lang('Global.nav-updates') ?></a>
        <a href="<?= base_url('contact') ?>" class="block py-2 text-sm text-[#545454] hover:text-[#477524] uppercase nav-link"><?= lang('Global.nav-contact') ?></a>
    </div>
</div>

<script>
    $(document).ready(function() {
        const $searchBtn = $("#search-btn");
        const $searchInput = $("#search-input");

        $searchBtn.on("click", function() {
            $searchBtn.addClass("hidden");
            $searchInput.removeClass("hidden").focus();
        });

        $searchInput.on("blur", function() {
            $searchInput.addClass("hidden").val("");
            $searchBtn.removeClass("hidden");
        });

        const currentUrl = window.location.href;
        $(".nav-link").each(function() {
            const href = $(this).attr("href");
            if (href && currentUrl.includes(href)) {
                $(this).addClass("active");
            }
        });
    });
</script>

<style>
    .nav-link.active {
        font-weight: bold;
        color: #2F5D50 !important;
    }
</style>