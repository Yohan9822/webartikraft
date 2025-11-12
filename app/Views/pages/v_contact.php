<?= $this->include('template/v_header') ?>
<div class="w-full mb-5 h-[600px]">
    <img data-src="<?= base_url('public/images/home/16.jpg') ?>" alt="contact image" class="w-full h-full object-cover lazy">
</div>
<section class="flex flex-col items-center justify-center py-12 px-[1rem] md:px-[3rem]">
    <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        <div class="grid grid-cols-2 gap-3">
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
        <div class="grid grid-cols-2 gap-3">
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

    <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center bg-white border border-[#477524]/15 shadow-lg overflow-hidden mt-4">
        <div class="h-full">
            <img data-src="<?= base_url('public/images/home/15.jpg') ?>" alt="Inquiry Image" class="lazy w-full h-full object-cover">
        </div>

        <div class="p-6 md:p-8">
            <h2 class="text-xl font-semibold mb-4 text-[#477524]"><?= lang('Global.contact-send') ?></h2>
            <form action="<?= base_url('contact/send') ?>" method="post" class="grid grid-cols-1 gap-4">
                <div class="space-y-5">
                    <div>
                        <input type="text" name="name" required placeholder="<?= lang('Global.contact-placeholder-name') ?>"
                            class="w-full px-5 py-3 border border-gray-300 shadow-sm 
                       focus:outline-none focus:border-[#477524] focus:ring-1 focus:ring-[#477524] 
                       transition-all duration-300 placeholder-gray-500">
                    </div>

                    <div>
                        <input type="email" name="email" required placeholder="<?= lang('Global.contact-placeholder-email') ?>"
                            class="w-full px-5 py-3 border border-gray-300 shadow-sm 
                       focus:outline-none focus:border-[#477524] focus:ring-1 focus:ring-[#477524] 
                       transition-all duration-300 placeholder-gray-500">
                    </div>

                    <div>
                        <input type="text" name="subject" required placeholder="<?= lang('Global.contact-placeholder-subject') ?>"
                            class="w-full px-5 py-3 border border-gray-300 shadow-sm 
                       focus:outline-none focus:border-[#477524] focus:ring-1 focus:ring-[#477524] 
                       transition-all duration-300 placeholder-gray-500">
                    </div>

                    <div>
                        <textarea name="message" rows="5" required placeholder="<?= lang('Global.contact-placeholder-message') ?>"
                            class="w-full px-5 py-3 border border-gray-300 shadow-sm 
                       focus:outline-none focus:border-[#477524] focus:ring-1 focus:ring-[#477524] 
                       transition-all duration-300 placeholder-gray-500"></textarea>
                    </div>

                    <div class="pt-3">
                        <button type="submit"
                            class="px-8 py-3 bg-[#477524] w-full cursor-pointer text-white font-semibold 
                       shadow-md hover:bg-[#365d1b] active:bg-[#2c4b16] transition-all 
                       duration-300 flex gap-3 uppercase justify-center items-center 
                       tracking-wider">
                            <i class="bx bx-paper-plane text-lg"></i>
                            <?= lang('Global.contact-button') ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?= $this->include('template/v_footer') ?>