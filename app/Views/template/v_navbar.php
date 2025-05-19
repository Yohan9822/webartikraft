<nav class="w-full bg-white shadow-lg border-b border-gray-200">
    <div id="top-bar" class="max-w-7xl mx-auto px-6 flex items-center justify-between px-[4rem] py-2 text-sm transition-all duration-300 ease-in-out max-h-[100px]">
        <div class="flex items-center gap-4">
            <a href="https://www.artikraft.id" class="hover:text-gray-700"><i class="bx bx-globe"></i></a>
            <a href="https://instagram.com/artikraftid" class="hover:text-gray-700"><i class="bx bxl-instagram"></i></a>
            <span class="mx-4 border-l h-4 border-gray-300"></span>
            <a href="#" class="hover:text-gray-700">Contact us</a>
        </div>
        <div>
            <select class="border-none bg-transparent text-sm focus:ring-0 focus:outline-none cursor-pointer flex items-center gap-2">
                <option value="en" class="flex items-center" selected>🇬🇧 English</option>
                <option value="id" class="flex items-center">🇮🇩 Indonesia</option>
            </select>
        </div>
    </div>
</nav>
<div class="sticky top-0 bg-white z-[999] shadow-lg">
    <div class="flex items-center justify-center px-8 py-6">
        <div class="text-center">
            <img src="<?= base_url('public/logo_crop.png') ?>" alt="" class="w-32">
        </div>
    </div>
    <div class="flex justify-center gap-10 pb-4">
        <a href="<?= base_url('home') ?>" class="relative px-2 py-1 font-medium tracking-widest text-base text-gray-900 hover:text-[#477524] group transition-all duration-300">
            OVERVIEW
            <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-[#477524] transition-all duration-300 group-hover:w-full"></span>
        </a>
        <a href="<?= base_url('products') ?>" class="relative px-2 py-1 font-medium tracking-widest text-base text-gray-900 hover:text-[#477524] group transition-all duration-300">
            OUR COLLECTION
            <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-[#477524] transition-all duration-300 group-hover:w-full"></span>
        </a>
        <a href="<?= base_url('about') ?>" class="relative px-2 py-1 font-medium tracking-widest text-base text-gray-900 hover:text-[#477524] group transition-all duration-300">
            WHO WE ARE
            <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-[#477524] transition-all duration-300 group-hover:w-full"></span>
        </a>
        <a href="<?= base_url('inquiry') ?>" class="relative px-2 py-1 font-medium tracking-widest text-base text-gray-900 hover:text-[#477524] group transition-all duration-300">
            INQUIRY
            <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-[#477524] transition-all duration-300 group-hover:w-full"></span>
        </a>
        <a href="<?= base_url('contact') ?>" class="relative px-2 py-1 font-medium tracking-widest text-base text-gray-900 hover:text-[#477524] group transition-all duration-300">
            CONTACT INFORMATION
            <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-[#477524] transition-all duration-300 group-hover:w-full"></span>
        </a>
    </div>
</div>