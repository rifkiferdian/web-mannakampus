<?php require_once('header.php'); ?>

<?php
$about_growth_stmt = $pdo->prepare(
    "SELECT news_title, news_slug, news_date, photo, news_content_short
     FROM tbl_news
     WHERE category_id = 1
       AND (
           news_title LIKE '%Cabang Manna Kampus%'
           OR news_title LIKE '%Mini MK%'
       )
     ORDER BY STR_TO_DATE(news_date, '%d-%m-%Y') ASC
     LIMIT 9"
);
$about_growth_stmt->execute();
$about_growth_news = $about_growth_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    /* ==========================================================================
       GENERAL & UTILITIES (REVISED)
       ========================================================================== */
    .section-padding { padding: 76px 0; }
    .bg-light-gray { background-color: #f8f9fa; }
    .pb-0 { padding-bottom: 0 !important; }
    
    
.section-title,
    h2.section-title,
    .journey-header .section-title {
        font-size: 40px !important;
        font-weight: 800 !important;
        line-height: 1.2 !important;
        margin-bottom: 18px !important;
        color: #1a1a1a !important;
        letter-spacing: -0.3px !important;
    }
    .section-subtitle,
    p.section-subtitle,
    .journey-header .section-subtitle {
        font-size: 18px !important;
        color: #666 !important;
        line-height: 1.7 !important;
    }
    .about-hero .container-custom p,
    .about-hero .container-custom h1,
    .about-hero .container-custom a,
    .cta-banner p,
    .cta-banner h2,
    .cta-actions .btn {
        font-size: inherit;
    }

    /* Memastikan container tidak menabrak batas layar (selaras dengan pola index.php) */
    .container-custom {
        width: 100% !important;
        max-width: 1180px !important;
        margin-left: auto !important;
        margin-right: auto !important;
        padding-left: 28px !important;
        padding-right: 28px !important;
    }

    /* Force Flexbox Row untuk mengatasi float issues di Bootstrap lawas */
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

    /* ==========================================================================
       HERO SECTION
       ========================================================================== */
    .about-hero {
        position: relative !important;
        min-height: 520px !important;
        display: flex !important;
        align-items: center !important;
        background-color: #111 !important;
        color: #fff !important;
        overflow: hidden !important;
    }
    .about-hero::before {
        content: '' !important;
        position: absolute !important;
        inset: 0 !important;
        background: rgba(0, 0, 0, 0.45) !important;
        z-index: 1 !important;
    }
    .about-hero-bg {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        opacity: 1 !important;
    }
    .about-hero .container-custom {
        position: relative !important;
        z-index: 2 !important;
        width: 100% !important;
        max-width: 1200px !important;
        margin: 0 auto !important;
        padding: 80px 24px !important;
    }
    .about-hero .hero-badge {
        display: inline-block !important;
        background: #e87817 !important;
        color: #fff !important;
        font-size: 1.2rem !important;
        font-weight: 600 !important;
        letter-spacing: normal !important;
        text-transform: none !important;
        padding: 6px 16px !important;
        border-radius: 20px !important;
        margin-bottom: 16px !important;
    }
    .about-hero h1 {
        font-size: 3.25rem !important;
        font-weight: 800 !important;
        line-height: 1.2 !important;
        margin: 0 0 16px !important;
        color: #fff !important;
        letter-spacing: normal !important;
    }
    .about-hero p {
        font-size: 1.5rem !important;
        max-width: 580px !important;
        margin: 0 0 28px !important;
        line-height: 1.6 !important;
        color: rgba(255,255,255,0.95) !important;
    }
    .hero-actions {
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 12px !important;
    }
    .btn-brand-orange,
    .btn-glass {
        padding: 12px 24px !important;
        font-size: 1.25rem !important;
        font-weight: 600 !important;
        border-radius: 6px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-decoration: none !important;
        transition: all 0.25s ease !important;
    }
    .btn-brand-orange {
        background: #e87817 !important;
        color: #fff !important;
        border: 1px solid #e87817 !important;
        box-shadow: 0 4px 15px rgba(232, 120, 23, 0.25) !important;
    }
    .btn-brand-orange:hover {
        background: #d0650c !important;
        transform: translateY(-2px) !important;
    }
    .btn-glass {
        background: rgba(255, 255, 255, 0.12) !important;
        color: #fff !important;
        border: 1px solid rgba(255,255,255,0.45) !important;
        backdrop-filter: blur(4px) !important;
    }
    .btn-glass:hover {
        background: rgba(255, 255, 255, 0.22) !important;
        border-color: rgba(255,255,255,0.9) !important;
    }

    /* ==========================================================================
       HERITAGE SECTION (PERBAIKAN TAMPILAN GAMBAR)
       ========================================================================== */
    #legacy .eyebrow {
    color: #ff7a00;
    text-transform: uppercase;
    letter-spacing: 3px;
    font-size: 15px;
    font-weight: 800;
    margin-bottom: 16px;
    display: block;
}
    .heritage-text-col { 
        padding-right: 50px; 
        justify-content: center;
    }
    .heritage-section p.desc { 
        margin-bottom: 24px; 
        font-size: 16px;
        color: #555;
    }
    
    .stats-row {
        display: flex;
        gap: 20px;
        margin-top: 30px;
    }
    .stats-box {
        flex: 1;
        border: 1px solid #eaeaea;
        padding: 24px 20px;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }
    .stats-box h3 {
        color: #ff7a00; font-weight: 800;
        margin: 0 0 8px 0;
        font-size: 32px;
        line-height: 1;
    }
    .stats-box p {
        font-size: 12px; text-transform: uppercase;
        color: #888; margin: 0; font-weight: 700;
        letter-spacing: 0.5px;
    }

    .image-split-container {
        position: relative; 
        height: 450px;
        width: 100%;
        border-radius: 12px; 
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .image-split-container img {
        width: 100%; height: 100%; object-fit: cover;
    }
    .year-label {
        position: absolute; bottom: 20px; color: #fff;
        font-weight: 700; font-size: 22px;
        text-shadow: 1px 1px 5px rgba(0,0,0,0.8);
    }
    .year-left { left: 20px; }
    .year-right { right: 20px; }
    
    .quote-box {
        position: absolute; bottom: -24px; right: -24px;
        background: #fff; padding: 26px 28px;
        border-left: 4px solid #ff7a00;
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        border-radius: 8px; max-width: 300px;
        font-style: italic; z-index: 3;
        color: #555; font-size: 15px; line-height: 1.7;
    }

    /* ==========================================================================
       CORE VALUES SECTION (BENTO GRID)
       ========================================================================== */
    .bento-row {
        margin-bottom: 24px;
    }
    .bento-card {
        border-radius: 16px;
        padding: 40px;
        height: 100%; 
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        transition: transform 0.3s ease;
    }
    .bento-card:hover {
        transform: translateY(-5px);
    }
    .bento-card i {
        font-size: 32px;
        margin-bottom: 24px;
    }
    .bento-card h3 {
        font-size: 24px;
        font-weight: 800;
        margin-top: 0;
        margin-bottom: 16px;
    }
    .bento-card p {
        font-size: 16px; line-height: 1.7; margin: 0;
    }
    
    /* Variants */
    .card-orange {
        background: linear-gradient(135deg, #ff8c00 0%, #e65c00 100%);
        color: #fff;
    }
    .card-orange i { color: #fff; }
    .card-orange h3 { color: #fff !important; }
    .card-orange p { color: rgba(255,255,255,0.9); }
    .card-orange:has(.bento-img) {
        padding-right: 45%;
    }
    .card-orange .bento-img {
        position: absolute;
        top: 24px; bottom: 24px; right: 24px;
        width: 38%;
        height: calc(100% - 48px);
        border-radius: 12px;
        object-fit: cover;
        box-shadow: -5px 0 20px rgba(0,0,0,0.2);
    }
    
    .card-white {
        background: #fff; border: 1px solid #f0f0f0; color: #222;
    }
    .card-white i { color: #ff7a00; }
    .card-white p { color: #666; }

    .card-dark {
        background: #3a3937; color: #fff;
        padding-right: 45%; 
    }
    .card-dark i { color: #fff; }
    .card-dark h3 { color: #fff !important; }
    .card-dark p { color: #dcdcdc; }
    .card-dark .bento-img {
        position: absolute;
        top: 24px; bottom: 24px; right: 24px;
        width: 38%;
        height: calc(100% - 48px);
        border-radius: 12px;
        object-fit: cover;
        box-shadow: -5px 0 20px rgba(0,0,0,0.2);
    }

    /* ======================================================================
       VISION & MISSION
       ====================================================================== */
    .vision-mission-section {
        background: #fff8f2;
    }
    .vision-mission-label {
        display: inline-block;
        margin-bottom: 10px;
        color: #d95f00;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 1.2px;
        text-transform: uppercase;
    }
    .vision-mission-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin: 0 -12px;
    }
    .vision-mission-col {
        width: 50%;
        padding: 0 12px;
        display: flex;
    }
    .vision-mission-card {
        width: 100%;
        min-height: 260px;
        padding: 42px 36px;
        border: 1px solid rgba(217,95,0,0.10);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 12px 28px rgba(58,57,55,0.08);
        text-align: center;
    }
    .vision-mission-icon {
        display: inline-flex;
        width: 54px;
        height: 54px;
        align-items: center;
        justify-content: center;
        margin-bottom: 22px;
        border-radius: 12px;
        background: #ff7a00;
        color: #fff;
        font-size: 23px;
    }
    .vision-mission-card.mission .vision-mission-icon {
        background: #3a3937;
    }
    .vision-mission-card h3 {
        margin: 0 0 14px;
        color: #222;
        font-size: 24px;
        font-weight: 800;
    }
    .vision-mission-card p {
        max-width: 420px;
        margin: 0 auto;
        color: #5e5e5e;
        font-size: 16px;
        line-height: 1.75;
    }

/* ==========================================================================
       JOURNEY OF GROWTH SECTION
       ========================================================================== */
    .journey-header {
        display: flex; justify-content: space-between; align-items: flex-end;
        margin-bottom: 30px;
    }
    .journey-slider {
        overflow: hidden;
        position: relative;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }
    .journey-track {
        display: flex;
        gap: 20px;
        flex-wrap: nowrap;
        align-items: stretch;
        transition: transform 0.35s ease;
        will-change: transform;
    }
    .journey-nav button {
        background: #fff; border: 1px solid #e0e0e0;
        width: 52px; height: 52px; border-radius: 50%;
        font-size: 24px; color: #333; margin-left: 14px;
        transition: 0.3s;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .journey-nav button:hover {
        border-color: #ff7a00; color: #fff; background: #ff7a00;
    }
    
    .milestone-card {
        background: transparent;
        padding: 0;
        border-radius: 22px;
        border: none;
        box-shadow: none;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: transform 0.2s ease;
    }
    .milestone-card:hover {
        transform: translateY(-2px);
    }
    .milestone-card .milestone-year-label {
        display: inline-flex;
        flex-direction: column;
        align-items: flex-start;
        margin: 18px 18px 10px;
    }
    .milestone-card .milestone-year-label span {
        font-size: 18px;
        font-weight: 800;
        color: #c26713;
        letter-spacing: 0.2px;
    }
    .milestone-card .milestone-year-label::after {
        content: '';
        display: block;
        width: 48px;
        height: 3px;
        margin-top: 8px;
        background: #ff8c00;
        border-radius: 2px;
    }
    .milestone-card .milestone-img-wrap {
        position: relative;
        height: 205px;
        border-radius: 20px;
        overflow: hidden;
        margin: 0 0 12px;
    }
    .milestone-card .milestone-img-wrap img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .milestone-card:hover .milestone-img-wrap img {
        transform: scale(1.05);
    }
    .milestone-card .milestone-body {
        padding: 0 18px 22px;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        flex: 1;
        background: transparent;
    }
    .milestone-card h4 {
        font-size: 20px;
        font-weight: 800;
        margin: 0 0 10px;
        color: #222;
        line-height: 1.3;
    }
    .milestone-card p {
        font-size: 15px;
        color: #5e5e5e;
        line-height: 1.75;
        margin: 0;
    }
    .milestone-col {
        flex: 0 0 calc(25% - 15px);
        max-width: calc(25% - 15px);
        min-width: 0;
        display: flex;
        box-sizing: border-box;
    }
    .milestone-link {
        display: block;
        color: inherit;
        text-decoration: none;
    }
    .milestone-link:hover {
        color: inherit;
        text-decoration: none;
    }

    /* ==========================================================================
       EXECUTIVE LEADERSHIP
       ========================================================================== */
    .leader-card { 
        margin-bottom: 40px; text-align: center; 
    }
    .leader-img-wrapper {
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 20px;
        position: relative;
    }
    .leader-card img {
        width: 100%; aspect-ratio: 4/5; object-fit: cover;
        filter: grayscale(100%); transition: filter 0.4s ease, transform 0.4s ease;
        display: block;
    }
    .leader-card:hover img { 
        filter: grayscale(0%);
        transform: scale(1.05);
    }
    .leader-card h4 {
        font-size: 20px; font-weight: 800; margin-bottom: 6px; color: #222;
    }
    .leader-card p { font-size: 15px; color: #ff7a00; margin: 0; font-weight: 600;}

    /* ==========================================================================
       CTA SECTION
       ========================================================================== */
    .cta-banner {
        background-color: #d96a00;
        background-image:
            radial-gradient(circle, rgba(255,255,255,0.10) 1.5px, transparent 1.5px),
            linear-gradient(135deg, #c05c00 0%, #ff7a00 100%);
        background-size: 30px 30px, auto;
        border-radius: 24px;
        padding: 70px 40px;
        text-align: center;
        color: #fff;
        margin-bottom: 80px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(255, 122, 0, 0.2);
    }
    .cta-banner::before {
        content: ''; position: absolute;
        top: -50%; left: -50%; width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 60%);
        z-index: 1; pointer-events: none;
    }
    .cta-banner-content { position: relative; z-index: 2; }
    .cta-banner h2 { font-size: 36px; font-weight: 800; margin-bottom: 16px; color: #fff;}
    .cta-banner p { font-size: 18px; margin-bottom: 32px; color: rgba(255,255,255,0.9); max-width: 600px; margin-left: auto; margin-right: auto;}
    .cta-actions { display: flex; justify-content: center; gap: 16px; flex-wrap: wrap; }
    
    .cta-actions .btn {
        padding: 14px 32px; font-weight: 700; border-radius: 6px; font-size: 16px;
        transition: 0.3s; border: none; text-decoration: none;
    }
    .btn-white { background: #fff; color: #d95f00 !important; }
    .btn-white:hover { background: #f8f8f8; transform: translateY(-2px); }
    .btn-orange-outline { 
        background: transparent; color: #fff !important; 
        border: 2px solid #fff !important; 
    }
    .btn-orange-outline:hover { background: #fff; color: #d95f00 !important; transform: translateY(-2px); }

    /* CTA Section: dekatkan jarak dengan section di atasnya */
    .cta-section.section-padding { padding-top: 60px; }

    /* ==========================================================================
       RESPONSIVE ADJUSTMENTS
       ========================================================================== */
    @media only screen and (max-width: 991px) {
        .section-padding { padding: 58px 0; }
        .heritage-text-col { padding-right: 15px; margin-bottom: 50px; }
        .image-split-container { height: 400px; }
        .quote-box { right: 20px; bottom: -20px; width: 250px; }
        
        .card-dark,
        .card-orange:has(.bento-img) { padding-right: 40px; }
        .card-dark .bento-img,
        .card-orange .bento-img { display: none; }
        
        .bento-card { margin-bottom: 24px; }
        
        .journey-header { flex-direction: column; align-items: flex-start; }
        .journey-nav { margin-top: 20px; }
        .milestone-col { margin-bottom: 30px; }
        .journey-track { flex-wrap: wrap; }
        .milestone-col { flex: 0 0 calc(50% - 10px); max-width: calc(50% - 10px); }
    }

    @media only screen and (max-width: 767px) {
        .section-padding { padding: 70px 0; }
        .about-hero { min-height: 400px !important; }
        .about-hero .container-custom { padding: 40px 20px !important; }
        .about-hero h1 { font-size: 2.1rem !important; }
        .hero-actions { flex-direction: column; width: 100%; }
        .btn-brand-orange, .btn-glass { width: 100%; }
        
        .stats-row { flex-direction: column; gap: 15px; }
        .image-split-container { height: 350px; margin-top: 20px; }
        .quote-box { position: static; width: 100%; margin-top: 20px; box-shadow: none; border: 1px solid #eee; border-left: 5px solid #ff7a00; }
        
        .flex-col-custom { width: 100%; }

        .vision-mission-col { width: 100%; margin-bottom: 24px; }
        .vision-mission-col:last-child { margin-bottom: 0; }
        .vision-mission-card { min-height: 0; padding: 36px 24px; }
        
        .cta-banner { padding: 50px 20px; }
        .cta-actions .btn { width: 100%; }
    }
</style>

<!-- Hero Section -->
<section class="about-hero">
    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop" class="about-hero-bg" alt="Hero Background">
    <div class="container container-custom">
        <span class="hero-badge">Tentang Manna Kampus</span>
        <h1 class="wow fadeInUp">Rumah Belanja Terpercaya</h1>
        <p class="wow fadeInUp" data-wow-delay="0.15s">Membangun warisan retail Indonesia melalui kepercayaan, kualitas, dan komitmen melayani setiap keluarga sejak toko pertama kami dibuka.</p>
        <div class="hero-actions wow fadeInUp" data-wow-delay="0.3s">
            <a href="#legacy" class="btn-brand-orange">Jejak Kami</a>
            <a href="#vision" class="btn-glass">Visi & Misi</a>
        </div>
    </div>
</section>

<!-- Heritage Section -->
<section id="legacy" class="section-padding bg-white">
    <div class="container container-custom">
        <!-- Ditambahkan align-items: center agar kolom mengikuti tinggi gambar, tidak memanjang ke bawah -->
        <div class="flex-row-custom" style="align-items: center;">
            
            <!-- Left Text -->
            <div class="col-md-6 col-sm-12 flex-col-custom heritage-text-col wow fadeInLeft">
                <span class="eyebrow">Tentang Perusahaan</span>
                <h2 class="section-title">Sejarah Manna Kampus</h2>
                <p class="section-subtitle desc">
                Perjalanan kami dimulai pada tahun <strong>1980</strong>, saat <strong>Bapak Siswanto Hendro Sutikno</strong> selaku pemilik sekaligus Direktur Utama mendirikan sebuah rumah makan bernama 
                <strong>Mirota Nayan</strong> di Jl. Solo Km 8, Yogyakarta. Nama <strong>"Mirota"</strong> sendiri menyimpan akronim yang unik yaitu <strong>Mi</strong>numan, <strong>Ro</strong>ti, dan 
                <strong>Ta</strong>rt — sebuah identitas awal yang menjadi cikal bakal tumbuh kembang usaha kami.</p>

                <p class="section-subtitle desc">
                Seiring tingginya kepercayaan pelanggan, lokasi usaha kemudian berpindah ke kawasan yang lebih strategis di Jl. Solo Km 7, Babarsari, Caturtunggal, Sleman, Yogyakarta. Di tempat baru ini, 
                Mirota Nayan terus bertransformasi tidak hanya menyajikan aneka makanan dan minuman, tetapi juga melengkapi kebutuhan masyarakat dengan menyediakan alat tulis. Dari sinilah semangat untuk terus 
                melayani dan berkembang menjadi <strong>"Rumah Belanja Terpercaya"</strong> mulai diukir.
                </p>
                <div class="stats-row">
                    <div class="stats-box">
                        <h3>46+</h3>
                        <p>Years of Service</p>
                    </div>
                    <div class="stats-box">
                        <h3>120k+</h3>
                        <p>Pelanggan Harian</p>
                    </div>
                </div>
            </div>
            
            <!-- Right Image Split -->
            <div class="col-md-6 col-sm-12 flex-col-custom wow fadeInRight">
                <div style="position: relative;">
                    <div class="image-split-container">
                        <img src="https://images.unsplash.com/photo-1604719312566-8912e9227c6a?q=80&w=1974&auto=format&fit=crop" alt="Manna Kampus History">
                        <!-- <div class="year-label year-left">1980</div> -->
                        <!-- <div class="year-label year-right">2026</div> -->
                    </div>
                    <div class="quote-box">
                        "Berakar dari Tradisi, Bertumbuh Menuju Masa Depan Ritel."
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Vision & Mission Section -->
<section id="vision" class="section-padding vision-mission-section">
    <div class="container container-custom">
        <div class="text-center" style="margin-bottom: 42px;">
            <span class="vision-mission-label wow fadeInUp">Prinsip Utama</span>
            <h2 class="section-title wow fadeInUp" data-wow-delay="0.1s">Visi &amp; Misi</h2>
        </div>

        <div class="vision-mission-grid">
            <div class="vision-mission-col wow fadeInUp" data-wow-delay="0.15s">
                <article class="vision-mission-card">
                    <div class="vision-mission-icon"><i class="fa-solid fa-compass" aria-hidden="true"></i></div>
                    <h3>Visi Kami</h3>
                    <p>Menjadikan Manna Kampus sebagai rumah belanja yang bernuansa kekeluargaan, dengan memberikan layanan yang ramah, cepat dan tepat, produk yang berkualitas,
                    harga yang murah, dan fasilitas yang nyaman serta aman sehingga Manna Kampus mempunyai nilai lebih dan dapat dipercaya oleh masyarakat Yogyakarta.</p>
                </article>
            </div>
            <div class="vision-mission-col wow fadeInUp" data-wow-delay="0.25s">
                <article class="vision-mission-card mission">
                    <div class="vision-mission-icon"><i class="fa fa-rocket" aria-hidden="true"></i></div>
                    <h3>Misi Kami</h3>
                    <p>Meningkatkan Kualitas Layanan secara Internal dan Eksternal untuk mencapai kepuasan konsumen.</p>
                </article>
            </div>
        </div>
    </div>
</section>

<!-- Core Values Section (Bento Grid) -->
<section id="core-values" class="section-padding bg-light-gray">
    <div class="container container-custom">
        
        <div class="text-center" style="margin-bottom: 60px;">
            <h2 class="section-title wow fadeInUp">Core Value Manna Kampus</h2>
            <p class="section-subtitle wow fadeInUp" data-wow-delay="0.15s" style="max-width: 650px; margin: 0 auto;">Prinsip yang mendorong pertumbuhan kami dan membentuk identitas kami sebagai Rumah Belanja Terpercaya.</p>
        </div>

        <!-- Row 1 -->
        <div class="flex-row-custom bento-row">
            <div class="col-md-8 col-sm-12 flex-col-custom">
                <div class="bento-card card-orange wow fadeInUp">
                    <i class="fa-solid fa-heart"></i>
                    <h3>Caring</h3>
                    <p>Kepedulian terhadap suatu keadaan / kondisi / peristiwa yang membutuhkan tindakan yang berdasarkan empati dan kepekaan.</p>
                    <img src="<?php echo BASE_URL; ?>assets/uploads/cheaper.jpg" class="bento-img" alt="Community">
                </div>
            </div>
            <div class="col-md-4 col-sm-12 flex-col-custom">
                <div class="bento-card card-white wow fadeInUp" data-wow-delay="0.2s">
                    <i class="fa-solid fa-scale-balanced"></i>
                    <h3>Human Integrity</h3>
                    <p>Karakter yang dimiliki dan diwujudkan oleh seluruh individu dalam bentuk konsistensi antara perkataan dan perbuatan, sikap dan perilaku.</p>
                </div>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="flex-row-custom bento-row">
            <div class="col-md-4 col-sm-12 flex-col-custom">
                <div class="bento-card card-white wow fadeInUp" data-wow-delay="0.15s">
                    <i class="fa fa-users"></i>
                    <h3>Ethical Communication</h3>
                    <p>Komunikasi yang didasarkan pada sikap dan nilai tertentu (etika) seperti jujur, menghargai, dan bertanggungjawab.</p>
                </div>
            </div>
            <div class="col-md-8 col-sm-12 flex-col-custom">
                <div class="bento-card card-dark wow fadeInUp" data-wow-delay="0.3s">
                    <i class="fa-solid fa-briefcase"></i>
                    <h3>Adaptive</h3>
                    <p>Suatu tindakan positif sebagai respon penyesauian diri terhadap perubahan situasi (lingkungan, ekonomi, busaya, politik, kesehatan, 
                        sosial, dan keamanan), perkembangan teknologi dan isu - isu global lainnya.</p>
                    <img src="<?php echo BASE_URL; ?>assets/uploads/cheaper.jpg" class="bento-img" alt="Community">
                </div>
            </div>
        </div>

            <!-- Row 3 -->
        <div class="flex-row-custom bento-row">
            <div class="col-md-8 col-sm-12 flex-col-custom">
                <div class="bento-card card-orange wow fadeInUp">
                    <i class="fa fa-eye"></i>
                    <h3>Profesional</h3>
                    <p>Menjalankan tugas dengan mengerahkan semua kompetensi (softskill dan hardskill) yang dimiliki. Bertahan terhadap situasi yang tidak sesuai 
                        harapan, dan mampu bangkit kembali (resilien)
                    </p>
                    <img src="<?php echo BASE_URL; ?>assets/uploads/cheaper.jpg" class="bento-img" alt="Community">
                </div>
            </div>
            <div class="col-md-4 col-sm-12 flex-col-custom">
                <div class="bento-card card-white wow fadeInUp" data-wow-delay="0.2s">
                    <i class="fa-solid fa-award"></i>
                    <h3>Excellent Service</h3>
                    <p>Upaya memberikan layanan terbaik yangberorientasi pada kepuasan konsumen (internal dan eksternal).</p>
                </div>
            </div>
        </div>

        <!-- Row 4 -->
        <div class="flex-row-custom bento-row">
            <div class="col-md-12 col-sm-12 flex-col-custom">
                <div class="bento-card card-white wow fadeInUp" data-wow-delay="0.15s">
                    <i class="fa-solid fa-arrow-trend-up""></i>
                    <h3>Reputable & Profitability</h3>
                    <p>Suatu upaya yang dilakukan secara berkesinambungan oleh perusahaan untuk menciptakan pandangan positif masyarakat
                        atau stakeholder sehingga dapat mewujudkan pertumbuhan usaha dan laba yang optimal.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Executive Leadership Section -->
<section class="section-padding bg-white pb-0">
    <div class="container container-custom text-center">
        
        <h2 class="section-title wow fadeInUp">Kepemimpinan Eksekutif Kami</h2>
        <p class="section-subtitle mb-5 wow fadeInUp" data-wow-delay="0.15s" style="max-width: 650px; margin: 0 auto 60px;">Dipimpin oleh para pemimpin berpengalaman dengan semangat keunggulan dan pemahaman mendalam tentang lanskap konsumen Indonesia.</p>

        <div class="flex-row-custom">
            <!-- Leader 1 -->
            <div class="col-md-3 col-sm-6 flex-col-custom wow fadeInUp">
                <div class="leader-card">
                    <div class="leader-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=400&auto=format&fit=crop" alt="Bambang Setiawan">
                    </div>
                    <h4>Bambang Setiawan</h4>
                    <p>Direktur Utama</p>
                </div>
            </div>
            <!-- Leader 2 -->
            <div class="col-md-3 col-sm-6 flex-col-custom wow fadeInUp" data-wow-delay="0.15s">
                <div class="leader-card">
                    <div class="leader-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=400&auto=format&fit=crop" alt="Lina Kusuma">
                    </div>
                    <h4>Lina Kusuma</h4>
                    <p>Direktur Operasional</p>
                </div>
            </div>
            <!-- Leader 3 -->
            <div class="col-md-3 col-sm-6 flex-col-custom wow fadeInUp" data-wow-delay="0.3s">
                <div class="leader-card">
                    <div class="leader-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=400&auto=format&fit=crop" alt="Andi Wijaya">
                    </div>
                    <h4>Andi Wijaya</h4>
                    <p>Direktur Teknologi</p>
                </div>
            </div>
            <!-- Leader 4 -->
            <div class="col-md-3 col-sm-6 flex-col-custom wow fadeInUp" data-wow-delay="0.45s">
                <div class="leader-card">
                    <div class="leader-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=400&auto=format&fit=crop" alt="Sari Rahayu">
                    </div>
                    <h4>Sari Rahayu</h4>
                    <p>Direktur Pemasaran</p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- A Journey of Growth Section -->
<section class="section-padding bg-light-gray">
    <div class="container container-custom">
        
        <div class="journey-header">
            <div>
                <h2 class="section-title wow fadeInUp">Perjalanan Kami</h2>
                <p class="section-subtitle mb-0 wow fadeInUp" data-wow-delay="0.15s">Momen dan pencapaian penting yang membentuk kami dari tahun 1980 hingga saat ini.</p>
            </div>
        </div>

        <div class="flex-row-custom">
            <!-- Item 1 -->
            <div class="col-md-3 col-sm-6 flex-col-custom milestone-col wow fadeInUp">
                <div class="milestone-card">
                    <div class="milestone-img-wrap">
                        <img src="https://images.unsplash.com/photo-1534723452862-4c874018d66d?q=80&w=600&auto=format&fit=crop" alt="1989">
                        <span class="milestone-year-badge">1980</span>
                    </div>
                    <div class="milestone-body">
                        <h4>Awal Mula Pendirian</h4>
                        <p>Pada tahun <strong>1980</strong>, <strong>Bapak Siswanto Hendro Sutikno</strong> mendirikan rumah makan <strong>Mirota Nayan</strong> di Jl. Solo Km 8, Yogyakarta. 
                            Usaha ini kemudian berpindah ke Jl. Solo Km 7 Babarsari dan merambah penjualan makanan, minuman, serta alat tulis.</p>
                    </div>
                </div>
            </div>
            <!-- Item 2 -->
            <div class="col-md-3 col-sm-6 flex-col-custom milestone-col wow fadeInUp" data-wow-delay="0.15s">
                <div class="milestone-card">
                    <div class="milestone-img-wrap">
                        <img src="https://images.unsplash.com/photo-1553413077-190dd305871c?q=80&w=600&auto=format&fit=crop" alt="1998">
                        <span class="milestone-year-badge">1983</span>
                    </div>
                    <div class="milestone-body">
                        <h4>Pengesahan Badan Hukum</h4>
                        <p>Langkah profesional dimulai pada tahun <strong>1983</strong> dengan disahkannya badan hukum <strong>"PT. Mirota Nayan"</strong> oleh Notaris RM. Soeryanto 
                            Partaningrat, SH, yang dipimpin oleh <strong>Bapak Siswanto HS</strong> sebagai Direktur Utama dan <strong>Bapak Nico Sukandar</strong> sebagai General Manager.</p>
                    </div>
                </div>
            </div>
            <!-- Item 3 -->
            <div class="col-md-3 col-sm-6 flex-col-custom milestone-col wow fadeInUp" data-wow-delay="0.3s">
                <div class="milestone-card">
                    <div class="milestone-img-wrap">
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?q=80&w=600&auto=format&fit=crop" alt="2012">
                        <span class="milestone-year-badge">1985</span>
                    </div>
                    <div class="milestone-body">
                        <h4>Kiprah Awal Mirota Kampus</h4>
                        <p>Pada <strong>13 Mei 1985</strong>, PT. Mirota Nayan membuka toko buku dan alat tulis di Jl. C. Simanjuntak No. 64C dengan nama Mirota Kampus. 
                            Nama <strong>"Mirota"</strong> merupakan akronim <strong>Mi</strong>numan, <strong>Ro</strong>ti, dan <strong>Ta</strong>rt, sedangkan "Kampus" dipilih karena lokasinya yang berdekatan dengan UGM. 
                            Tanggal ini pun resmi menjadi momen berdirinya Mirota Kampus.</p>
                    </div>
                </div>
            </div>
            <!-- Item 4 -->
            <div class="col-md-3 col-sm-6 flex-col-custom milestone-col wow fadeInUp" data-wow-delay="0.45s">
                <div class="milestone-card">
                    <div class="milestone-img-wrap">
                        <img src="https://images.unsplash.com/photo-1601599561096-f87c95fff1e9?q=80&w=600&auto=format&fit=crop" alt="Present">
                        <span class="milestone-year-badge">2021 - Present</span>
                    </div>
                    <div class="milestone-body">
                        <h4>Era Baru Manna Kampus</h4>
                        <p>Mirota Kampus resmi bertransformasi menjadi <strong>Manna Kampus</strong> sebagai bentuk semangat inovasi dan peningkatan kualitas layanan. Hingga saat ini, 
                            Manna Kampus terus berkembang dengan <strong>10 outlet</strong> di Yogyakarta, Sleman, dan Bantul sebagai <strong>"Rumah Belanja Terpercaya"</strong>.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- CTA Section -->
<section class="section-padding bg-light-gray cta-section">
    <div class="container container-custom">
        <div class="cta-banner wow fadeInUp">
            <div class="cta-banner-content">
                <h2 class="wow fadeInUp" data-wow-delay="0.1s">Ingin menjadi bagian dari kisah kami?</h2>
                <p class="wow fadeInUp" data-wow-delay="0.2s">Jelajahi peluang karier dan kemitraan korporat bersama retailer paling dipercaya di Indonesia.</p>
                <div class="cta-actions wow fadeInUp" data-wow-delay="0.3s">
                    <a href="#" class="btn btn-white">Gabung Tim Kami</a>
                    <a href="#" class="btn btn-orange-outline">Hubungi Korporat</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
/* Fallback gambar: jika gambar Unsplash gagal dimuat, ganti dengan placeholder andal */
(function () {
    var FALLBACKS = {
        'milestone-card': 'https://images.unsplash.com/photo-1556740738-b6a63e27c4df?q=80&w=600&auto=format&fit=crop',
        'leader-img-wrapper': 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=400&auto=format&fit=crop',
        'image-split-container': 'https://images.unsplash.com/photo-1556740738-b6a63e27c4df?q=80&w=1200&auto=format&fit=crop'
    };
    document.addEventListener('error', function (e) {
        var target = e.target;
        if (target.tagName !== 'IMG') return;
        var card = target.closest('.milestone-card, .leader-img-wrapper, .image-split-container');
        var fallback = card ? FALLBACKS[card.className.split(' ')[0]] : null;
        if (!fallback) fallback = 'https://images.unsplash.com/photo-1556740738-b6a63e27c4df?q=80&w=600&auto=format&fit=crop';
        if (target.src !== fallback) {
            target.src = fallback;
        }
    }, true);

    var heroSectionLinks = document.querySelectorAll('.hero-actions a[href^="#"]');
    for (var linkIndex = 0; linkIndex < heroSectionLinks.length; linkIndex++) {
        heroSectionLinks[linkIndex].addEventListener('click', function (event) {
            var target = document.querySelector(this.getAttribute('href'));
            if (!target) return;

            event.preventDefault();
            var header = document.querySelector('.mk-header');
            var headerHeight = header ? header.offsetHeight : 0;
            var targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;

            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
            window.history.replaceState(null, '', this.getAttribute('href'));
        });
    }

    var journeySlider = document.getElementById('journeySlider');
    if (journeySlider) {
        var track = journeySlider.querySelector('.journey-track');
        var prevBtn = document.querySelector('.journey-scroll-prev');
        var nextBtn = document.querySelector('.journey-scroll-next');

        if (track) {
            var scrollStep = function (direction) {
                var firstCard = track.querySelector('.milestone-col');
                if (!firstCard) return;
                var trackStyles = window.getComputedStyle(track);
                var gap = parseFloat(trackStyles.gap || trackStyles.columnGap || 20);
                var cardWidth = firstCard.getBoundingClientRect().width + gap;
                var visibleCards = 4;
                var currentTranslate = parseFloat(track.dataset.currentTranslate || 0);
                var nextTranslate = currentTranslate + (direction * cardWidth * visibleCards);
                var maxTranslate = Math.max(0, track.scrollWidth - journeySlider.clientWidth);
                nextTranslate = Math.max(0, Math.min(nextTranslate, maxTranslate));
                track.style.transform = 'translateX(-' + nextTranslate + 'px)';
                track.dataset.currentTranslate = nextTranslate;
            };

            var updateNavVisibility = function () {
                var maxTranslate = Math.max(0, track.scrollWidth - journeySlider.clientWidth);
                if (prevBtn) prevBtn.style.display = maxTranslate > 0 ? 'inline-flex' : 'none';
                if (nextBtn) nextBtn.style.display = maxTranslate > 0 ? 'inline-flex' : 'none';
            };

            updateNavVisibility();
            window.addEventListener('resize', updateNavVisibility);

            if (prevBtn) {
                prevBtn.addEventListener('click', function () {
                    scrollStep(-1);
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', function () {
                    scrollStep(1);
                });
            }
        }
    }
})();
</script>

<!-- Memanggil Footer -->
<?php require_once('footer.php'); ?>
