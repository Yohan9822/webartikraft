<?= $this->include('template/v_header') ?>
<div class="w-full mb-5 h-[600px]">
    <img src="<?= base_url('public/images/home/16.jpg') ?>" alt="contact image" class="w-full h-full object-cover" loading="lazy">
</div>
<section class="flex flex-col items-center justify-center py-12 px-[1rem] md:px-[3rem]">
    <div class="w-full grid grid-cols-2 md:grid-cols-2 gap-8 mb-12">
        <div class="flex align-start gap-4">
            <div>
                <iframe class="w-full" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3967.095967836249!2d106.71031470967893!3d-6.117782659965215!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6a02c81426db8f%3A0x1802307bf44ad07c!2sJl.%20Menceng%20Raya%20No.32%2C%20RT.3%2FRW.11%2C%20Tegal%20Alur%2C%20Kec.%20Kalideres%2C%20Kota%20Jakarta%20Barat%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2011820!5e0!3m2!1sen!2sid!4v1756950599910!5m2!1sen!2sid" class="w-[250px] h-[250px] lg:w-[350px] lg:h-[350px]" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="flex flex-col gap-0">
                <span class="font-semibold">HEAD OFFICE/SHOWROOM</span>
                <span>Jln. Raya Menceng No. 32 <br>
                    Tegal Alur, Kalideres Jakarta 11820</span>
                <span class="text-gray-600">P : +62 21 559 5252 7</span>
                <span class="text-gray-600">E : sales@artikraft.id</span>
            </div>
        </div>
        <div class="flex align-start gap-2">
            <div>
                <iframe class="w-full" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.040468640477!2d108.18731770969563!3d-7.236224171037191!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f51d5494715a3%3A0x487936abeb7bf9b6!2sPT.%20Arti%20Kraft%20Indonesia!5e0!3m2!1sen!2sid!4v1756950890901!5m2!1sen!2sid" class="w-[250px] h-[250px] lg:w-[350px] lg:h-[350px]" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="flex flex-col gap-0">
                <span class="font-semibold">FACTORY</span>
                <span>Jalan Raya Rajapolah RT 002 RW 003 <br>
                    Desa Dewagung, Kecamatan Rajapolah <br>
                    Tasikmalaya, Jawa Barat</span>
                <span class="text-gray-600">P : +62 265 757 0083</span>
            </div>
        </div>
    </div>

    <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center bg-white shadow-lg overflow-hidden mt-4">
        <div class="h-full">
            <img src="<?= base_url('public/images/home/15.jpg') ?>" alt="Inquiry Image" class="w-full h-full object-cover">
        </div>

        <div class="p-6 md:p-8">
            <h2 class="text-xl font-semibold mb-4 text-[#477524]">Send Us an Inquiry</h2>
            <form action="<?= base_url('contact/send') ?>" method="post" class="grid grid-cols-1 gap-4">
                <div>
                    <input type="text" name="name" required placeholder="Your Name"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-[#477524]">
                </div>
                <div>
                    <input type="email" name="email" required placeholder="Your Email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-[#477524]">
                </div>
                <div>
                    <input type="text" name="subject" required placeholder="Subject"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-[#477524]">
                </div>
                <div>
                    <textarea name="message" rows="5" required placeholder="Your Message"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-[#477524]"></textarea>
                </div>
                <div class="text-right">
                    <button type="submit"
                        class="px-6 py-2 bg-[#477524] w-full cursor-pointer text-white rounded-md hover:bg-[#365d1b] transition-all flex gap-2 uppercase justify-center items-center">
                        <i class="bx bx-paper-plane"></i>
                        Send
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<?= $this->include('template/v_footer') ?>