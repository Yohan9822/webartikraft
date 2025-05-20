<?= $this->include('template/v_header') ?>

<style>
    .group:hover .group-hover\:bg-transparent {
        background: transparent !important;
    }

    .group:hover .group-hover\:opacity-100 {
        opacity: 1 !important;
    }

    .group:hover .group-hover\:bg-transparent {
        animation: bgWipeLeftToRight 0.5s forwards;
    }

    @keyframes bgWipeLeftToRight {
        0% {
            background: #477524;
        }

        100% {
            background: transparent;
        }
    }
</style>
<div class="min-h-screen flex items-center justify-center bg-[#f5f3e7] py-12 px-6">
    <div class="w-full max-w-7xl bg-white rounded-lg shadow-lg flex overflow-hidden">
        <!-- Left: Image -->
        <div class="hidden md:block md:w-1/2 bg-[#e0dcc2] flex items-center justify-center">
            <img src="<?= base_url('public/images/3.png') ?>" alt="Inquiry" class="object-cover w-full h-full" onerror="this.style.display='none'">
        </div>
        <!-- Right: Form -->
        <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-[#477524] mb-6 text-center">Inquiry Form</h2>
            <form method="post" class="space-y-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" required placeholder="Your Name" class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-[#477524] focus:ring-[#477524] focus:outline-none transition">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" required placeholder="you@email.com" class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-[#477524] focus:ring-[#477524] focus:outline-none transition">
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" id="phone" placeholder="08xxxxxxxxxx" class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-[#477524] focus:ring-[#477524] focus:outline-none transition">
                </div>
                <div>
                    <label for="product" class="block text-sm font-medium text-gray-700 mb-1">Product Interested</label>
                    <input type="text" name="product" id="product" placeholder="Product Name / Code" class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-[#477524] focus:ring-[#477524] focus:outline-none transition">
                </div>
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                    <input type="number" name="quantity" id="quantity" min="1" placeholder="e.g. 100" class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-[#477524] focus:ring-[#477524] focus:outline-none transition">
                </div>
                <div>
                    <label for="details" class="block text-sm font-medium text-gray-700 mb-1">Details / Request</label>
                    <textarea name="details" id="details" rows="4" required placeholder="Type your request or details here..." class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-[#477524] focus:ring-[#477524] focus:outline-none transition"></textarea>
                </div>
                <div>
                    <button type="submit" class="cursor-pointer w-full py-2 px-4 bg-[#477524] text-white font-semibold rounded-lg shadow border-2 border-[#477524] relative overflow-hidden group transition-all duration-300 hover:bg-transparent hover:text-[#477524] hover:border-[#477524]">
                        Send Inquiry
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->include('template/v_footer') ?>