<footer class="w-full mt-auto pt-6 md:pt-16 pb-16 text-white" style="background: url('<?= base_url('public/images/footer-bg.png') ?>') center center / cover no-repeat;">
    <div class="px-[1rem] md:px-[3rem] mx-auto grid grid-cols-1 md:grid-cols-3 gap-12">
        <div>
            <h3 class="font-bold text-lg mb-2"><?= lang('Global.footer-title') ?></h3>
            <div class="w-8 h-1 bg-white mb-4"></div>
            <ul class="space-y-2 text-sm">
                <li>
                    <a class="cursor-pointer hover:text-[#477524] capitalize" href="<?= base_url('company') ?>">
                        <span class="mr-2">›</span> <?= lang('Global.nav-company') ?>
                    </a>
                </li>
                <li>
                    <a class="cursor-pointer hover:text-[#477524] capitalize" href="<?= base_url('furnishing') ?>">
                        <span class="mr-2">›</span> <?= lang('Global.nav-furnishing') ?>
                    </a>
                </li>
                <li>
                    <a class="cursor-pointer hover:text-[#477524] capitalize" href="<?= base_url('bamboo') ?>">
                        <span class="mr-2">›</span> <?= lang('Global.nav-bamboo') ?>
                    </a>
                </li>
                <li>
                    <a class="cursor-pointer hover:text-[#477524] capitalize" href="<?= base_url('contact') ?>">
                        <span class="mr-2">›</span> <?= lang('Global.nav-contact') ?>
                    </a>
                </li>
            </ul>
        </div>
        <div>
            <h3 class="font-bold text-lg mb-2"><?= lang('Global.footer-title-2') ?></h3>
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
            <h3 class="font-bold text-lg mb-2"><?= lang('Global.footer-title-3') ?></h3>
            <div class="w-8 h-1 bg-white mb-4"></div>
            <div class="flex gap-4 mb-6 text-xl">
                <a href="https://instagram.com/artikraftid" class="hover:text-[#477524]"><i class="fab fa-instagram"></i></a>
                <a href="https://www.artikraft.id" class="hover:text-[#477524]"><i class="fas fa-globe"></i></a>
            </div>

            <h3 class="font-bold text-lg mb-2"><?= lang('Global.footer-title-4') ?></h3>
            <div class="w-8 h-1 bg-white mb-4"></div>
            <input
                type="email"
                placeholder="<?= lang('Global.placeholder-email') ?>"
                class="w-full px-4 py-2 rounded-none text-white focus:outline-none mb-2 border-b-2"
                style="border-color: #477524;" />

            <button class="group relative w-full overflow-hidden px-4 py-2 mt-4 text-[#477524] border border-[#477524] transition-colors duration-500 hover:text-white cursor-pointer">
                <span class="z-10 relative uppercase font-semibold"><?= lang('Global.buttonEmail') ?></span>
                <span class="absolute top-0 left-0 w-full h-full bg-[#477524] transform -translate-x-full transition-transform duration-500 group-hover:translate-x-0"></span>
            </button>
            <div class="text-xs mt-2"><?= lang('Global.notesFooter') ?></div>
        </div>
    </div>
    <div class="fixed right-8 bottom-8 z-50 flex flex-col items-center gap-4">
        <button
            id="liveChatBtn"
            aria-label="Live Chat"
            class="flex items-center justify-center w-12 h-12 rounded-full bg-[#477524] text-white shadow-lg transition-all cursor-pointer hover:bg-[#2d2217]">
            <i class='bx bxs-message-dots !text-2xl'></i>
        </button>
        <button
            id="toTopBtn"
            aria-label="Back to top"
            class="flex items-center justify-center w-12 h-12 rounded-full bg-[#2d2217] text-white shadow-lg transition-all cursor-pointer hover:bg-[#477524]">
            <i class="bx bx-chevron-up !text-2xl"></i>
        </button>
    </div>
</footer>
<script src="<?= base_url('public/js/notyf.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/js/splide.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-grid@0.4.1/dist/js/splide-extension-grid.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

        // Navbar Event
        const mobileMenuBtn = $('#mobile-menu-btn');
        const mobileMenu = $('#mobile-menu');

        mobileMenuBtn.click(function() {
            mobileMenu.slideToggle();
        })

        const langBtn = $('#lang-btn');
        const langMenu = $('#lang-menu');
        const langOptions = $('.lang-option');
        const currentLangFlag = $('#current-lang-flag');
        const currentLangText = $('#current-lang-text');
        const navLinks = $('.nav-link');

        const updatePageContent = (lang) => {
            navLinks.each(function() {
                const translation = $(this).data(lang);
                if (translation) {
                    $(this).text(translation);
                }
            });
        };

        const updateLangButtonUI = (lang, text, flagSrc, flagAlt) => {
            currentLangFlag.attr('src', flagSrc);
            currentLangFlag.attr('alt', flagAlt);
            currentLangText.text(text);
            langBtn.data('lang', lang);
        };

        const setLanguageServerSide = (lang) => {
            $.ajax({
                url: '<?= base_url('setlanguage') ?>' + '?lang=' + lang,
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        window.location.reload();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error(thrownError);
                }
            });
        };

        const storedLang = localStorage.getItem('lang');
        if (storedLang) {
            const storedLangOption = $(`.lang-option[data-lang="${storedLang}"]`);
            if (storedLangOption.length) {
                const storedText = storedLangOption.text().trim();
                const storedFlag = storedLangOption.find('img').attr('src');
                const storedAlt = storedLangOption.find('img').attr('alt');

                updatePageContent(storedLang);
                updateLangButtonUI(storedLang, storedText, storedFlag, storedAlt);
            }
        } else {
            updatePageContent('en');
        }

        langBtn.on('click', function(e) {
            e.stopPropagation();
            langMenu.toggleClass('hidden');
        });

        langOptions.on('click', function() {
            const selectedLang = $(this).data('lang');
            const currentSelectedLang = langBtn.data('lang');

            if (selectedLang !== currentSelectedLang) {
                localStorage.setItem('lang', selectedLang);
                setLanguageServerSide(selectedLang);
            }

            langMenu.addClass('hidden');
        });

        $(document).on('click', function(e) {
            if (!langBtn.is(e.target) && !langMenu.is(e.target) && !langMenu.has(e.target).length) {
                langMenu.addClass('hidden');
            }
        });
    });
</script>
</body>

</html>