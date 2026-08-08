<?php require_once('header.php'); ?>

<style>
    /* ==========================================================================
       GENERAL & UTILITIES
       ========================================================================== */
    .section-padding { padding: 100px 0; }
    .bg-light-gray { background-color: #f4f5f7; }

    body, h1, h2, h3, h4, h5, h6, p, a, span, div {
        font-family: "Open Sans", sans-serif;
    }
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Roboto', sans-serif;
    }
    
    .section-title {
        font-family: 'Roboto', sans-serif;
        font-size: clamp(28px, 3vw, 36px);
        font-weight: 800;
        line-height: 1.3;
        margin-bottom: 24px;
        color: #1a1a1a;
        letter-spacing: -0.5px;
    }
    .section-subtitle {
        font-size: 16px;
        color: #555;
        line-height: 1.8;
    }

    .container-custom {
        width: 100% !important;
        max-width: 1200px !important;
        margin-left: auto !important;
        margin-right: auto !important;
        padding-left: 30px !important;
        padding-right: 30px !important;
    }

    .flex-row-custom {
        display: flex;
        flex-wrap: wrap;
        margin-left: -15px;
        margin-right: -15px;
    }
    .flex-col-custom {
        padding-left: 15px;
        padding-right: 15px;
        display: flex;
        flex-direction: column;
    }

    /* Highlight Underline Text */
    .highlight-underline {
        position: relative;
        display: inline-block;
    }
    .highlight-underline::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 2px;
        width: 100%;
        height: 4px;
        background-color: #ff7a00;
        border-radius: 2px;
    }

    /* ==========================================================================
       HERO SECTION (KLAIM HADIAH)
       ========================================================================== */
    .claim-hero {
        position: relative;
        padding: 120px 0 100px;
        background-color: #a85716; 
        color: #fff;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .hero-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.15);
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        font-size: 28px;
    }
    .claim-hero h1 {
        font-size: clamp(36px, 5vw, 48px);
        font-weight: 800;
        margin: 0 0 16px;
        color: #fff;
    }
    .claim-hero p {
        font-size: clamp(16px, 2vw, 20px);
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.95);
    }

    /* ==========================================================================
       PROSEDUR KLAIM SECTION (BENTO GRID)
       ========================================================================== */
    .prosedur-row {
        margin-bottom: 30px;
    }
    .step-card {
        background: #fff;
        border: 1px solid #eaeaea;
        border-radius: 16px;
        padding: 32px;
        height: 100%;
        box-shadow: 0 8px 24px rgba(0,0,0,0.03);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .step-card-orange {
        background: #ff7a00;
        color: #fff;
        border: none;
    }
    .step-number {
        width: 40px;
        height: 40px;
        background: #fff0e6;
        color: #ff7a00;
        font-size: 20px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .step-card-orange .step-number {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
    }
    .step-card h3 {
        font-size: 20px;
        font-weight: 800;
        margin-top: 0;
        margin-bottom: 12px;
    }
    .step-card-orange h3 {
        color: #fff;
    }
    .step-card p {
        font-size: 15px;
        line-height: 1.7;
        color: #666;
        margin: 0;
    }
    .step-card-orange p {
        color: rgba(255, 255, 255, 0.9);
    }

    /* Spesifik Card 2 (Dengan Gambar) */
    .card-with-img {
        display: flex;
        flex-direction: row;
        gap: 24px;
        padding: 24px;
    }
    .card-with-img .step-img {
        width: 40%;
        border-radius: 12px;
        object-fit: cover;
    }
    .card-with-img .step-content {
        width: 60%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Spesifik Card 3 (Info Pajak) */
    .tax-alert {
        background: #fff4e5;
        border-left: 4px solid #ff7a00;
        padding: 16px 20px;
        border-radius: 0 8px 8px 0;
        margin: 20px 0;
    }
    .tax-alert p {
        color: #b35500 !important;
        font-weight: 600;
        font-size: 14.5px;
    }

    .card-icon-bg {
        position: absolute;
        bottom: -10px;
        right: 10px;
        font-size: 80px;
        opacity: 0.1;
        color: #fff;
        transform: rotate(-15deg);
    }

    /* ==========================================================================
       DOKUMEN & KEAMANAN SECTION
       ========================================================================== */
    .doc-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .doc-item {
        background: #fff;
        border: 1px solid #eaeaea;
        padding: 20px;
        border-radius: 12px;
        display: flex;
        gap: 16px;
        align-items: flex-start;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    .doc-item i {
        color: #d32f2f;
        font-size: 24px;
        margin-top: 2px;
    }
    .doc-item h4 {
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 6px;
        color: #222;
    }
    .doc-item p {
        font-size: 14px;
        color: #666;
        margin: 0;
        line-height: 1.6;
    }

    /* Security Card */
    .security-card {
        background: #fff;
        border-radius: 16px;
        padding: 32px;
        border: 1px solid #eaeaea;
        box-shadow: 0 8px 24px rgba(0,0,0,0.04);
        position: relative;
        overflow: hidden;
        height: 100%;
    }
    .security-card .shield-bg {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 100px;
        color: #f0f0f0;
        z-index: 1;
    }
    .security-content {
        position: relative;
        z-index: 2;
    }
    .security-card h3 {
        color: #d32f2f;
        font-size: 22px;
        font-weight: 800;
        margin-top: 0;
        margin-bottom: 16px;
    }
    .security-card > p {
        font-size: 15px;
        color: #555;
        margin-bottom: 24px;
    }
    .warning-list {
        list-style: none;
        padding: 0;
        margin: 0 0 24px;
    }
    .warning-list li {
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
        font-size: 14px;
        color: #d32f2f;
        font-weight: 600;
        line-height: 1.5;
    }
    .warning-list li i {
        font-size: 18px;
        margin-top: 2px;
    }
    .contact-box {
        background: #f8f9fa;
        padding: 16px;
        border-radius: 8px;
        border: 1px solid #eaeaea;
    }
    .contact-box p {
        margin: 0;
        font-size: 13px;
        color: #666;
    }
    .contact-box strong {
        display: block;
        color: #222;
        font-size: 18px;
        margin: 4px 0;
    }

    /* ==========================================================================
       FAQ SECTION
       ========================================================================== */
    .faq-card {
        background: #fff;
        border: 1px solid #eaeaea;
        padding: 24px;
        border-radius: 12px;
        height: 100%;
        margin-bottom: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    .faq-card h4 {
        color: #c0392b;
        font-size: 16px;
        font-weight: 700;
        margin-top: 0;
        margin-bottom: 12px;
        line-height: 1.5;
    }
    .faq-card p {
        font-size: 14.5px;
        color: #555;
        margin: 0;
        line-height: 1.6;
    }

/* ==========================================================================
       CTA BANNER (BOTTOM)
       ========================================================================== */
.cta-banner-img {
        background: linear-gradient(rgba(168, 87, 22, 0.55), rgba(168, 87, 22, 0.55)), url('<?php echo BASE_URL; ?>assets/images/klaimhadiah.png') center/cover no-repeat;
        border-radius: 20px;
        padding: 60px 40px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        gap: 30px;
        box-shadow: 0 15px 30px rgba(168, 87, 22, 0.2);
    }
    .cta-banner-text h2 {
        color: #fff;
        font-size: clamp(28px, 3vw, 36px);
        font-weight: 800;
        margin: 0 0 10px;
    }
    .cta-banner-text p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 16px;
        margin: 0;
    }
    .btn-white {
        background: #fff;
        color: #a85716 !important;
        padding: 14px 32px;
        font-size: 16px;
        font-weight: 700;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        white-space: nowrap;
        transition: 0.3s;
    }
    .btn-white:hover {
        background: #f1f1f1;
        transform: translateY(-2px);
    }

    /* ==========================================================================
       RESPONSIVE ADJUSTMENTS
       ========================================================================== */
    @media only screen and (max-width: 991px) {
        .card-with-img { flex-direction: column; }
        .card-with-img .step-img, .card-with-img .step-content { width: 100%; }
        
.cta-banner-img {
            flex-direction: column;
            text-align: center;
            align-items: center;
            padding: 50px 20px;
        }
        .prosedur-row { gap: 24px; margin-bottom: 24px; }
        .mb-resp-40 { margin-bottom: 40px; }
    }

    @media only screen and (max-width: 767px) {
        .section-padding { padding: 60px 0; }
        .claim-hero { padding: 100px 0 60px; }
        
        .flex-col-custom { width: 100%; margin-bottom: 20px; }
        .prosedur-row { margin-bottom: 0; }
        
        .doc-item { flex-direction: column; gap: 12px; }
    }

    /* ==========================================================================
       SCROLL REVEAL ANIMATIONS
       ========================================================================== */
    .mk-reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.8s cubic-bezier(0.22, 1, 0.36, 1),
                    transform 0.8s cubic-bezier(0.22, 1, 0.36, 1);
        will-change: opacity, transform;
    }
    .mk-reveal.mk-visible {
        opacity: 1;
        transform: translateY(0);
    }
    .mk-delay-1 { transition-delay: 0.15s; }
    .mk-delay-2 { transition-delay: 0.3s; }
    .mk-delay-3 { transition-delay: 0.45s; }
    .mk-delay-4 { transition-delay: 0.6s; }

    /* Hero content fade-down on load */
    .claim-hero .hero-icon,
    .claim-hero h1,
    .claim-hero p {
        opacity: 0;
        animation: mkFadeDown 0.9s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }
    .claim-hero h1 { animation-delay: 0.15s; }
    .claim-hero p  { animation-delay: 0.3s; }

@keyframes mkFadeDown {
        from { opacity: 0; transform: translateY(-26px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Continuous up-down bounce for the trophy icon (after fade-in) */
    .claim-hero .hero-icon {
        animation: mkFadeDown 0.9s cubic-bezier(0.22, 1, 0.36, 1) both,
                   mkFloat 2.2s ease-in-out 0.9s infinite;
    }
    @keyframes mkFloat {
        0%, 100% { transform: translateY(0); }
        50%      { transform: translateY(-14px); }
    }

    @media (prefers-reduced-motion: reduce) {
        .mk-reveal {
            opacity: 1;
            transform: none;
            transition: none;
        }
        .claim-hero .hero-icon,
        .claim-hero h1,
        .claim-hero p {
            opacity: 1;
            animation: none;
        }
    }
</style>

<!-- Hero Section -->
<section class="claim-hero">
<div class="container container-custom">
<div class="hero-icon">
            <i class="fa fa-gift"></i>
        </div>
        <h1>Selamat!</h1>
        <p>Berikut adalah informasi Alur Klaim Hadiah. Manna Kampus bangga dapat menjadi bagian dari kebahagiaan para pemenang utama.</p>
    </div>
</section>

<!-- Prosedur Klaim Hadiah -->
<section class="section-padding bg-white">
    <div class="container container-custom">
        
        <div class="text-center mk-reveal" style="margin-bottom: 50px;">
            <h2 class="section-title">Prosedur <span class="highlight-underline">Klaim</span> Hadiah</h2>
        </div>

        <!-- Row 1 -->
        <div class="flex-row-custom prosedur-row">
            <!-- Step 1 -->
            <div class="col-md-5 col-sm-12 flex-col-custom mk-reveal">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3>Pemberitahuan Pemenang</h3>
                    <p>Pemenang akan dihubungi secara langsung dan resmi oleh tim Humas atau Customer Service Manna Kampus.</p>
                </div>
            </div>
            <!-- Step 2 -->
            <div class="col-md-7 col-sm-12 flex-col-custom mk-reveal mk-delay-1">
                <div class="step-card card-with-img p-0">
<img src="<?php echo BASE_URL; ?>assets/images/penyerahandokumen.png" class="step-img" alt="Penyerahan Dokumen">
                    <div class="step-content p-4">
                        <div class="step-number">2</div>
                        <h3>Penyerahan Dokumen</h3>
                        <p>Pemenang akan diinfokan mengenai berkas yang harus diserahkan untuk keperluan klaim, yang meliputi fotokopi KTP, fotokopi KK, serta print atau screenshot MKMC/MKMCD.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="flex-row-custom">
            <!-- Step 3 -->
            <div class="col-md-7 col-sm-12 flex-col-custom mk-reveal">
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3>Penyelesaian Pajak</h3>
                    <div class="tax-alert">
                        <p>Pajak hadiah sebesar 25% dari harga hadiah wajib dilunasi oleh pemenang undian.</p>
                    </div>
                    <p>Pembayaran pajak hadiah dapat dilakukan secara tunai (cash) atau melalui metode transfer ke nomor rekening resmi yang telah disediakan oleh panitia.</p>
                </div>
            </div>
            <!-- Step 4 -->
            <div class="col-md-5 col-sm-12 flex-col-custom mk-reveal mk-delay-1">
                <div class="step-card step-card-orange">
                    <div class="step-number">4</div>
                    <h3>Pengambilan Hadiah</h3>
<p>Proses pengambilan hadiah hanya dilayani di Manna Kampus cabang Godean. Pemenang wajib menunjukkan identitas asli saat serah terima.</p>
<i class="fa fa-gift card-icon-bg"></i>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Dokumen yang Wajib Dibawa & Peringatan -->
<section class="section-padding bg-light-gray">
    <div class="container container-custom">
        <div class="flex-row-custom">
            
            <!-- Dokumen Wajib -->
            <div class="col-md-7 col-sm-12 flex-col-custom mb-resp-40">
                <h2 class="section-title mk-reveal">Dokumen yang Wajib Dibawa</h2>
                <div class="doc-list">
<div class="doc-item mk-reveal">
                        <i class="fa fa-check-circle-o"></i>
                        <div>
                            <h4>Fotokopi KTP & KK</h4>
                            <p>Salinan fotokopi Kartu Tanda Penduduk (KTP) dan fotokopi Kartu Keluarga (KK) pemenang yang masih berlaku.</p>
                        </div>
                    </div>
<div class="doc-item mk-reveal mk-delay-1">
                        <i class="fa fa-check-circle-o"></i>
                        <div>
                            <h4>Bukti MKMC / MKMCD</h4>
                            <p>Bukti keanggotaan berupa hasil cetak (print) atau tangkapan layar (screenshot) dari MKMC/MKMCD.</p>
                        </div>
                    </div>
<div class="doc-item mk-reveal mk-delay-2">
                        <i class="fa fa-check-circle-o"></i>
                        <div>
                            <h4>Identitas Asli</h4>
                            <p>Identitas diri asli (KTP asli) wajib dibawa dan ditunjukkan secara langsung saat proses pengambilan hadiah.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Peringatan Keamanan -->
<div class="col-md-5 col-sm-12 flex-col-custom mk-reveal mk-delay-1">
                <div class="security-card">
<i class="fa fa-shield shield-bg"></i>
                    <div class="security-content">
                        <h3>Peringatan Keamanan</h3>
                        <p>Waspadai penipuan yang mengatasnamakan Manna Kampus.</p>
                        <ul class="warning-list">
<li>
                                <i class="fa fa-ban"></i>
                                Kami TIDAK PERNAH meminta pulsa atau uang melalui telepon.
                            </li>
                            <li>
                                <i class="fa fa-ban"></i>
                                Kami TIDAK PERNAH meminta kode OTP atau data perbankan pribadi.
                            </li>
                        </ul>
                        <div class="contact-box">
                            <p>Hubungi Panitia Resmi:</p>
                            <strong>(0274) 555978</strong>
                            <p>Senin - Sabtu | 08.00 - 16.00 WIB</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="section-padding bg-white">
    <div class="container container-custom">
        
        <div class="text-center" style="margin-bottom: 40px;">
            <h2 class="section-title">Pertanyaan Sering Diajukan (FAQ)</h2>
        </div>

        <div class="flex-row-custom">
            <div class="col-md-6 col-sm-12 flex-col-custom mk-reveal">
                <div class="faq-card">
                    <h4>Di mana lokasi pengambilan hadiah dilakukan?</h4>
                    <p>Pengambilan hadiah secara eksklusif hanya dilayani di lokasi Manna Kampus cabang Godean.</p>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 flex-col-custom mk-reveal mk-delay-1">
                <div class="faq-card">
                    <h4>Bagaimana ketentuan pembayaran pajak 25%?</h4>
                    <p>Pelunasan pajak sebesar 25% dari harga hadiah dapat dilakukan dengan pembayaran tunai (cash) langsung atau melalui transfer ke nomor rekening yang telah disediakan oleh panitia.</p>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 flex-col-custom mk-reveal">
                <div class="faq-card">
                    <h4>Bagaimana apabila identitas atau kartu MKMC hilang?</h4>
                    <p>Apabila kartu MKMC atau kartu identitas hilang, pemenang diwajibkan untuk mengurus dan menyerahkan Surat Keterangan Kehilangan resmi dari kepolisian.</p>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 flex-col-custom mk-reveal mk-delay-1">
                <div class="faq-card">
                    <h4>Apakah bukti identitas asli harus dibawa?</h4>
                    <p>Ya, pemenang wajib hadir dengan membawa serta menunjukkan bukti identitas asli pada saat melakukan proses pengambilan hadiah di lokasi cabang Godean.</p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- CTA Bottom Section -->
<section class="section-padding bg-light-gray" style="padding-top: 40px;">
    <div class="container container-custom">
        <div class="cta-banner-img mk-reveal">
            <div class="cta-banner-text">
                <h2>Masih Memiliki Pertanyaan?</h2>
                <p>Tim layanan pelanggan siap membantu menyelesaikan proses klaim hadiah agar berjalan dengan lancar dan nyaman.</p>
            </div>
            <a href="#" class="btn-white">Hubungi Customer Service</a>
        </div>
    </div>
</section>

<!-- Script: Scroll Reveal Animation -->
<script>
(function() {
    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduceMotion || !('IntersectionObserver' in window)) {
        var all = document.querySelectorAll('.mk-reveal');
        for (var i = 0; i < all.length; i++) {
            all[i].classList.add('mk-visible');
        }
        return;
    }
    var revealEls = document.querySelectorAll('.mk-reveal');
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('mk-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(function(el) {
        observer.observe(el);
    });
})();
</script>

<!-- Memanggil Footer -->
<?php require_once('footer.php'); ?>
