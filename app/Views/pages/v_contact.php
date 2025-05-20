<?= $this->include('template/v_header') ?>

<div class="min-h-screen flex items-center justify-center bg-[#f5f3e7] py-12 px-6">
    <div class="w-full max-w-7xl bg-white rounded-lg shadow-lg overflow-hidden flex flex-col">
        <div class="w-full h-72 md:h-96">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.0404686404568!2d108.18731771029648!3d-7.236224171038433!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f51d5494715a3%3A0x487936abeb7bf9b6!2sPT.%20Arti%20Kraft%20Indonesia!5e0!3m2!1sen!2sid!4v1747733237870!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="w-full p-8 flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-[#477524] mb-6 text-center">Contact Us</h2>
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
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                    <input type="text" name="subject" id="subject" placeholder="Subject" class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-[#477524] focus:ring-[#477524] focus:outline-none transition">
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                    <textarea name="message" id="message" rows="4" required placeholder="Type your message here..." class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-[#477524] focus:ring-[#477524] focus:outline-none transition"></textarea>
                </div>
                <div>
                    <button type="submit" class="cursor-pointer w-full py-2 px-4 bg-[#477524] text-white font-semibold rounded-lg shadow border-2 border-[#477524] relative overflow-hidden group transition-all duration-300 hover:bg-transparent hover:text-[#477524] hover:border-[#477524]">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('template/v_footer') ?>