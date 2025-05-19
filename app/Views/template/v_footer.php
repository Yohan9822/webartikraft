<footer class="w-full mt-auto pt-16 pb-10 text-white" style="background: url('<?= base_url('public/images/footer-bg.png') ?>') center center / cover no-repeat;">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12">
        <div>
            <h3 class="font-bold text-lg mb-2">Practical Informations</h3>
            <div class="w-8 h-1 bg-white mb-4"></div>
            <ul class="space-y-2 text-sm">
                <li><span class="mr-2">›</span> Inquiry</li>
                <li><span class="mr-2">›</span> Product Catalog</li>
                <li><span class="mr-2">›</span> FAQ</li>
                <li><span class="mr-2">›</span> Contact us</li>
            </ul>
        </div>
        <div>
            <h3 class="font-bold text-lg mb-2">Contact</h3>
            <div class="w-8 h-1 bg-white mb-4"></div>
            <div class="mb-2">Artikraft Indonesia</div>
            <div class="flex items-start gap-2 mb-2">
                <i class="fas fa-map-marker-alt mt-1"></i>
                <span>
                    Jalan Raya Rajapolah RT 002 RW 003 <br>
                    Desa Dewagung, Kecamatan Rajapolah
                    Tasikmalaya, Jawa Barat
                </span>
            </div>
            <div class="flex items-start gap-2 mb-2">
                <i class="fas fa-phone mt-1"></i>
                <span>P : +62 265 757 0083</span>
            </div>
            <div class="flex items-start gap-2 mb-2">
                <i class="fas fa-envelope mt-1"></i>
                <span>E : sales@artikraft.id</span>
            </div>
        </div>
        <div>
            <h3 class="font-bold text-lg mb-2">Follow us</h3>
            <div class="w-8 h-1 bg-white mb-4"></div>
            <div class="flex gap-4 mb-6 text-xl">
                <a href="https://instagram.com/artikraftid" class="hover:text-[#477524]"><i class="fab fa-instagram"></i></a>
                <a href="https://www.artikraft.id" class="hover:text-[#477524]"><i class="fas fa-globe"></i></a>
            </div>
            <h3 class="font-bold text-lg mb-2">Newsletter</h3>
            <div class="w-8 h-1 bg-white mb-4"></div>
            <input
                type="email"
                placeholder="Your email address"
                class="w-full px-4 py-2 rounded-none text-white focus:outline-none mb-2 border-b-2"
                style="border-color: #477524;" />
            <div class="text-xs mt-2">Check your spam in case you do not see the confirmation email. You may unsubscribe anytime.</div>
        </div>
    </div>
    <div class="fixed right-8 bottom-8 z-50 flex flex-col items-center gap-4">
        <button id="liveChatBtn" class="w-[50px] h-[50px] bg-[#477524] hover:bg-[#2d2217] text-white p-3 rounded-full shadow-lg transition-all cursor-pointer flex items-center justify-center" aria-label="Live Chat">
            <i class="bx bx-comment !text-[25px]"></i>
        </button>
        <button id="toTopBtn" class="w-[50px] h-[50px] bg-[#2d2217] hover:bg-[#477524] text-white p-3 rounded shadow-lg transition-all cursor-pointer flex items-center justify-center" aria-label="Back to top">
            <i class="bx bx-chevron-up !text-[25px]"></i>
        </button>
    </div>
</footer>
<script src="<?= base_url('public/js/notyf.js') ?>"></script>
<script>
    var notyf = new Notyf({
        position: {
            x: 'right',
            y: 'top',
        }
    });

    function showSuccess(msg) {
        notyf.success(msg);
    }

    function showError(msg) {
        notyf.error(msg);
    }

    function toPage(url, blank = null) {
        if (blank != null) {
            window.open(url, '_blank');
        } else {
            window.location.href = url;
        }
    }

    $(document).ready(function() {
        $('#toTopBtn').click(function() {
            $('html, body').animate({
                scrollTop: 0
            }, 1000);
        });


        $('#liveChatBtn').click(function() {
            showError('Live chat feature coming soon!');
        })

        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('#toTopBtn').fadeIn();
            } else {
                $('#toTopBtn').fadeOut();
            }
        });

        $('#toTopBtn').hide();
    });
</script>
</body>

</html>