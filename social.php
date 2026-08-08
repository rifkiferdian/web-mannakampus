<?php 
require_once('header.php'); 

// ==============================================================================
// 1. QUERY UNTUK BERITA & KEGIATAN TERBARU (KATEGORI SOCIAL)
// ==============================================================================
$statement_news = $pdo->prepare("
    SELECT t1.*, t2.category_name, t2.category_slug 
    FROM tbl_news t1 
    JOIN tbl_category t2 ON t1.category_id = t2.category_id 
    WHERE t2.category_name LIKE '%Social%' OR t2.category_name LIKE '%Sosial%' 
    ORDER BY t1.news_id DESC LIMIT 3
");
$statement_news->execute();
$news_social = $statement_news->fetchAll(PDO::FETCH_ASSOC);

// ==============================================================================
// 2. QUERY UNTUK GALERI DAMPAK NYATA (KATEGORI SOCIAL)
// ==============================================================================
$statement_gallery = $pdo->prepare("
    SELECT t1.* 
    FROM tbl_photo t1 
    JOIN tbl_category_photo t2 ON t1.p_category_id = t2.p_category_id 
    WHERE t2.p_category_name LIKE '%Social%' OR t2.p_category_name LIKE '%Sosial%' 
    GROUP BY t1.photo_name /* Menambahkan GROUP BY agar tidak ada nama file gambar yang ganda */
    ORDER BY t1.photo_id DESC LIMIT 8
");
$statement_gallery->execute();
$gallery_social = $statement_gallery->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    /* ==========================================================================
       GENERAL UTILITIES
       ========================================================================== */
    .social-page {
        font-family: "Open Sans", sans-serif;
        color: #171717;
        background: #fff;
        overflow-x: hidden;
        font-size: 16px;
        line-height: 1.7;
    }

    .social-page h1,
    .social-page h2,
    .social-page h3,
    .social-page p,
    .social-page a,
    .social-page span,
    .social-page strong {
        font-family: "Open Sans", sans-serif;
    }
    .social-page h1,
    .social-page h2,
    .social-page h3 {
        font-family: 'Roboto', sans-serif;
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
    .social-hero .social-kicker,
    .social-hero h1,
    .social-hero p,
    .social-hero .social-actions {
        opacity: 0;
        animation: mkFadeDown 0.9s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }
    .social-hero h1 { animation-delay: 0.15s; }
    .social-hero p  { animation-delay: 0.3s; }
    .social-hero .social-actions { animation-delay: 0.45s; }
    @keyframes mkFadeDown {
        from { opacity: 0; transform: translateY(-26px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Heartbeat / pulse animation for section badges */
    .mk-pulse {
        animation: mkPulse 2.4s ease-in-out infinite;
    }
    @keyframes mkPulse {
        0%, 100% { transform: scale(1); }
        50%      { transform: scale(1.08); }
    }

    @media (prefers-reduced-motion: reduce) {
        .mk-reveal {
            opacity: 1;
            transform: none;
            transition: none;
        }
        .social-hero .social-kicker,
        .social-hero h1,
        .social-hero p,
        .social-hero .social-actions {
            opacity: 1;
            animation: none;
        }
        .mk-pulse { animation: none; }
    }
    .social-container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        position: relative;
        z-index: 2;
    }

    /* ==========================================================================
       HERO SECTION (Diperbarui sesuai referensi)
       ========================================================================== */
    .social-hero {
        position: relative;
        min-height: 520px;
        display: flex;
        align-items: center;
        background-color: #fff;
        /* Menambahkan gradient putih di kiri agar teks terbaca, dan gambar di kanan */
        background-image: linear-gradient(to right, rgba(255, 255, 255, 1) 35%, rgba(255, 255, 255, 0.6) 60%, rgba(255, 255, 255, 0) 100%), url('assets/uploads/social6.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    .social-hero__content {
        max-width: 600px;
        padding: 80px 0;
    }
    .social-kicker {
        display: inline-block;
        background: rgba(230, 126, 34, 0.15);
        color: #e67e22;
        padding: 6px 14px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 20px;
    }
.social-hero h1 {
        font-size: clamp(28px, 3vw, 36px);
        font-weight: 800;
        margin: 0 0 20px;
        color: #111;
        line-height: 1.2;
        letter-spacing: -0.5px;
        max-width: 620px;
        width: 100%;
    }
    .social-hero p {
        font-size: clamp(16px, 2vw, 20px);
        color: #555;
        line-height: 1.6;
        margin: 0 0 35px;
    }
    .social-actions {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }
    .social-btn {
        padding: 12px 26px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 4px;
        text-decoration: none !important;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .social-btn--primary {
        background: #e67e22;
        color: #fff !important;
        border: 2px solid #e67e22;
    }
    .social-btn--primary:hover {
        background: #d35400;
        border-color: #d35400;
    }
    .social-btn--outline {
        background: transparent;
        color: #333 !important;
        border: 1px solid #ddd;
    }
    .social-btn--outline:hover {
        border-color: #ccc;
        background: #f9f9f9;
    }

    /* ==========================================================================
       STATS SECTION
       ========================================================================== */
    .social-stats {
        padding: 50px 0;
        background: #fff;
    }
    .social-stats__grid {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        text-align: center;
    }
    .social-stat {
        flex: 1;
        min-width: 200px;
        margin: 15px 0;
    }
    .social-stat strong {
        display: block;
        color: #e67e22;
        font-size: 38px;
        font-weight: 800;
        margin-bottom: 8px;
    }
    .social-stat span {
        display: block;
        color: #777;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* ==========================================================================
       NEWS SECTION
       ========================================================================== */
    .social-news {
        padding: 80px 0;
        background: #f9f9f9;
    }
    .social-section-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 40px;
    }
    .social-section-head h2 {
        font-size: clamp(28px, 3vw, 36px);
        font-weight: 800;
        margin: 0 0 8px;
        color: #111;
    }
    .social-section-head p {
        margin: 0;
        color: #666;
        font-size: 16px;
        line-height: 1.7;
    }
    .social-all-link {
        color: #e67e22 !important;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .social-all-link:hover { color: #d35400 !important; }
    
    .social-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    .social-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    .social-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
    .social-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .social-card__body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .social-card__label {
        color: #e67e22;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }
    .social-card__label i { margin-right: 6px; }
    .social-card h3 {
        font-size: 18px;
        font-weight: 700;
        color: #222;
        margin: 0 0 12px;
        line-height: 1.4;
    }
    .social-card p {
        font-size: 14px;
        color: #666;
        line-height: 1.6;
        margin-bottom: 24px;
        flex-grow: 1;
    }
    .social-card-link {
        color: #111 !important;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .social-card-link:hover { color: #e67e22 !important; }

/* ==========================================================================
       GALLERY SECTION (Diperbarui untuk layout masonry zigzag)
       ========================================================================== */
    .social-gallery {
        padding: 80px 0;
        background: #fff;
    }
    .title-accent-center {
        text-align: center;
        margin-bottom: 40px;
    }
    .title-accent-center h2 {
        font-size: clamp(28px, 3vw, 36px);
        font-weight: 800;
        color: #111;
        margin: 0;
    }
    .title-accent-center::after {
        content: '';
        display: block;
        width: 50px;
        height: 3px;
        background-color: #e67e22;
        margin: 16px auto 0;
        border-radius: 2px;
    }
    
    /* Custom Grid: 4 Kolom */
    .gallery-custom-layout {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        align-items: start;
    }
    .gallery-column {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .gallery-item {
        overflow: hidden;
        border-radius: 12px;
        position: relative;
        cursor: zoom-in;
        transition: transform 0.35s ease, box-shadow 0.35s ease;
    }
    .gallery-item img {
        width: 100%;
        border-radius: 12px;
        display: block;
        object-fit: cover;
        transition: transform 0.5s ease, filter 0.5s ease;
        will-change: transform, filter;
    }
    .gallery-item:hover {
        transform: translateY(-12px);
        box-shadow: 0 24px 42px rgba(0,0,0,0.18);
    }
    .gallery-item:hover img {
        transform: scale(1.06);
        filter: brightness(1.06);
    }
    .gallery-zoom-icon {
        position: absolute;
        right: 14px;
        bottom: 14px;
        display: flex;
        width: 38px;
        height: 38px;
        border: 1px solid rgba(255,255,255,0.75);
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        background: rgba(20,28,40,0.72);
        color: #fff;
        font-size: 17px;
        opacity: 0;
        transform: translateY(7px);
        transition: opacity 0.2s ease, transform 0.2s ease;
        pointer-events: none;
    }
    .gallery-item:hover .gallery-zoom-icon {
        opacity: 1;
        transform: translateY(0);
    }

    /* Efek Masonry: Mengatur tinggi gambar secara selang-seling */
    /* Kolom Ganjil (1 & 3): Gambar Atas Pendek, Bawah Tinggi */
    .gallery-column:nth-child(odd) .gallery-item:nth-child(1) img {
        height: 220px;
    }
    .gallery-column:nth-child(odd) .gallery-item:nth-child(2) img {
        height: 380px;
    }
    
    /* Kolom Genap (2 & 4): Gambar Atas Tinggi, Bawah Pendek */
    .gallery-column:nth-child(even) .gallery-item:nth-child(1) img {
        height: 380px;
    }
    .gallery-column:nth-child(even) .gallery-item:nth-child(2) img {
        height: 220px;
    }

    /* Penyesuaian Responsif di bagian bawah CSS utama Anda */
    @media (max-width: 991px) {
        .gallery-custom-layout { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 480px) {
        .gallery-custom-layout { grid-template-columns: 1fr; }
        .gallery-column:nth-child(n) .gallery-item:nth-child(n) img {
            height: 250px; /* Tinggi seragam untuk layar HP */
        }
    }

    /* ==========================================================================
       CTA SECTION (Diperbarui sesuai referensi)
       ========================================================================== */
    .social-cta {
        padding: 80px 0;
        background-color: #a45a2a; /* Cokelat solid sesuai desain */
        color: #fff;
        text-align: center;
    }
.social-cta h2 {
        font-size: clamp(28px, 3vw, 36px);
        font-weight: 800;
        margin-bottom: 16px;
        color: #fff;
    }
    .social-cta p {
        font-size: 15px;
        max-width: 650px;
        margin: 0 auto 32px;
        line-height: 1.6;
        color: rgba(255,255,255,0.95);
    }
    .cta-actions {
        display: flex;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
    }
    .btn-icon-white {
        background: #fff;
        color: #a45a2a !important;
        padding: 12px 30px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: 0.3s;
    }
    .btn-icon-outline {
        background: transparent;
        color: #fff !important;
        border: 1px solid rgba(255,255,255,0.6);
        padding: 12px 30px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: 0.3s;
    }
    .btn-icon-outline:hover {
        background: rgba(255,255,255,0.1);
        border-color: #fff;
    }

    /* ==========================================================================
       RESPONSIVE ADJUSTMENTS
       ========================================================================== */
    @media (max-width: 991px) {
        .social-cards { grid-template-columns: repeat(2, 1fr); }
        .gallery-custom-layout { grid-template-columns: repeat(2, 1fr); align-items: start; }
    }
    @media (max-width: 767px) {
        .social-hero { text-align: center; }
        .social-hero__content { margin: 0 auto; }
        .social-actions { justify-content: center; }
        .social-stats__grid { flex-direction: column; }
        .social-cards { grid-template-columns: 1fr; }
        .social-section-head { flex-direction: column; align-items: flex-start; gap: 16px; }
        .cta-actions .btn-icon-white, .cta-actions .btn-icon-outline { width: 100%; justify-content: center; }
    }
    @media (max-width: 480px) {
        .gallery-custom-layout { grid-template-columns: 1fr; }
    }
</style>

<main class="social-page">
    
    <!-- Hero Section -->
    <section class="social-hero">
        <div class="social-container">
            <div class="social-hero__content">
                <span class="social-kicker">Tanggung Jawab Sosial</span>
                <h1>Kepedulian Manna Kampus</h1>
                <p>Sejak awal berdiri, kami percaya bahwa kesuksesan sejati diukur dari seberapa besar manfaat yang kami berikan bagi sesama. Manna Kampus berkomitmen penuh untuk menjadi tetangga yang baik melalui berbagai inisiatif sosial berkelanjutan demi kesejahteraan masyarakat Indonesia.</p>
                <div class="social-actions">
                    <a href="#kegiatan" class="social-btn social-btn--primary">Pelajari Inisiatif Kami</a>
                    <a href="#galeri" class="social-btn social-btn--outline">Lihat Laporan Dampak</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="social-stats mk-reveal">
        <div class="social-container">
            <div class="social-stats__grid">
                <div class="social-stat mk-reveal">
                    <strong>500k+</strong>
                    <span>Penerima Manfaat</span>
                </div>
                <div class="social-stat mk-reveal mk-delay-1">
                    <strong>250+</strong>
                    <span>Komunitas Terbantu</span>
                </div>
                <div class="social-stat mk-reveal mk-delay-2">
                    <strong>50+</strong>
                    <span>Program Kesehatan</span>
                </div>
                <div class="social-stat mk-reveal mk-delay-3">
                    <strong>12jt</strong>
                    <span>Liter Nasi Dibagikan</span>
                </div>
            </div>
        </div>
    </section>

    <!-- News & Activities Section -->
    <section id="kegiatan" class="social-news">
        <div class="social-container">
            <div class="social-section-head mk-reveal">
                <div>
                    <h2>Berita & Kegiatan Terbaru</h2>
                    <p>Dokumentasi nyata aksi kemanusiaan kami di lapangan.</p>
                </div>
                <a href="<?php echo BASE_URL.URL_CATEGORY.'social'; ?>" class="social-all-link">Lihat Semua Berita <i class="fa fa-arrow-right"></i></a>
            </div>

            <div class="social-cards">
                <?php if(!empty($news_social)): ?>
                    <?php $card_i = 0; ?>
                    <?php foreach ($news_social as $news): ?>
                        <?php $card_i++; ?>
                        <article class="social-card mk-reveal mk-delay-<?php echo ((($card_i - 1) % 3) + 1); ?>">
                            <img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $news['photo']; ?>" alt="<?php echo $news['news_title']; ?>" onerror="this.src='https://via.placeholder.com/800x600?text=No+Image'">
                            <div class="social-card__body">
                                <div class="social-card__label">
                                    <i class="fa fa-tag"></i> <?php echo $news['category_name']; ?>
                                </div>
                                <h3><?php echo $news['news_title']; ?></h3>
                                <p><?php echo substr(strip_tags($news['news_content']), 0, 90); ?>...</p>
                                <a href="<?php echo BASE_URL.URL_NEWS.$news['news_slug']; ?>" class="social-card-link">Selengkapnya <i class="fa fa-angle-right"></i></a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Fallback Dummy Content Jika Database Kosong -->
                    <p>Tidak ada berita atau kegiatan terbaru yang tersedia saat ini.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

<!-- Gallery Section -->
    <section id="galeri" class="social-gallery">
        <div class="social-container">
            <div class="title-accent-center mk-reveal">
                <h2>Galeri Dampak Nyata</h2>
            </div>

            <!-- Layout Grid -->
            <div class="gallery-custom-layout">
                
                <!-- Kolom 1 -->
                <div class="gallery-column mk-reveal">
                    <div class="gallery-item">
                        <?php if(isset($gallery_social[0])): ?>
                            <a class="gallery-photo payment-promo-image-popup" href="<?php echo BASE_URL; ?>assets/uploads/<?php echo $gallery_social[0]['photo_name']; ?>" title="Dampak Nyata - Dokumentasi kegiatan sosial">
                                <img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $gallery_social[0]['photo_name']; ?>" alt="Galeri 1">
                                <span class="gallery-zoom-icon"><i class="fa fa-search-plus"></i></span>
                            </a>
                        <?php else: ?>
                            <a class="gallery-photo payment-promo-image-popup" href="assets/uploads/social1.png" title="Dampak Nyata - Dokumentasi kegiatan sosial">
                                <img src="assets/uploads/social1.png" alt="Galeri 1" onerror="this.src='https://via.placeholder.com/400x400?text=Gambar+1'">
                                <span class="gallery-zoom-icon"><i class="fa fa-search-plus"></i></span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="gallery-item">
                        <?php if(isset($gallery_social[1])): ?>
                            <a class="gallery-photo payment-promo-image-popup" href="<?php echo BASE_URL; ?>assets/uploads/<?php echo $gallery_social[1]['photo_name']; ?>" title="Dampak Nyata - Dokumentasi kegiatan sosial">
                                <img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $gallery_social[1]['photo_name']; ?>" alt="Galeri 2">
                                <span class="gallery-zoom-icon"><i class="fa fa-search-plus"></i></span>
                            </a>
                        <?php else: ?>
                            <a class="gallery-photo payment-promo-image-popup" href="assets/uploads/social2.png" title="Dampak Nyata - Dokumentasi kegiatan sosial">
                                <img src="assets/uploads/social2.png" alt="Galeri 2" onerror="this.src='https://via.placeholder.com/400x550?text=Gambar+2'">
                                <span class="gallery-zoom-icon"><i class="fa fa-search-plus"></i></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Kolom 2 -->
                <div class="gallery-column mk-reveal mk-delay-1">
                    <div class="gallery-item">
                        <?php if(isset($gallery_social[2])): ?>
                            <a class="gallery-photo payment-promo-image-popup" href="<?php echo BASE_URL; ?>assets/uploads/<?php echo $gallery_social[2]['photo_name']; ?>" title="Dampak Nyata - Dokumentasi kegiatan sosial">
                                <img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $gallery_social[2]['photo_name']; ?>" alt="Galeri 3">
                                <span class="gallery-zoom-icon"><i class="fa fa-search-plus"></i></span>
                            </a>
                        <?php else: ?>
                            <a class="gallery-photo payment-promo-image-popup" href="assets/uploads/social3.png" title="Dampak Nyata - Dokumentasi kegiatan sosial">
                                <img src="assets/uploads/social3.png" alt="Galeri 3" onerror="this.src='https://via.placeholder.com/400x550?text=Gambar+3'">
                                <span class="gallery-zoom-icon"><i class="fa fa-search-plus"></i></span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="gallery-item">
                        <?php if(isset($gallery_social[3])): ?>
                            <a class="gallery-photo payment-promo-image-popup" href="<?php echo BASE_URL; ?>assets/uploads/<?php echo $gallery_social[3]['photo_name']; ?>" title="Dampak Nyata - Dokumentasi kegiatan sosial">
                                <img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $gallery_social[3]['photo_name']; ?>" alt="Galeri 4">
                                <span class="gallery-zoom-icon"><i class="fa fa-search-plus"></i></span>
                            </a>
                        <?php else: ?>
                            <a class="gallery-photo payment-promo-image-popup" href="assets/uploads/social4.png" title="Dampak Nyata - Dokumentasi kegiatan sosial">
                                <img src="assets/uploads/social4.png" alt="Galeri 4" onerror="this.src='https://via.placeholder.com/400x250?text=Gambar+4'">
                                <span class="gallery-zoom-icon"><i class="fa fa-search-plus"></i></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Kolom 3 -->
                <div class="gallery-column mk-reveal mk-delay-2">
                    <div class="gallery-item">
                        <?php if(isset($gallery_social[4])): ?>
                            <a class="gallery-photo payment-promo-image-popup" href="<?php echo BASE_URL; ?>assets/uploads/<?php echo $gallery_social[4]['photo_name']; ?>" title="Dampak Nyata - Dokumentasi kegiatan sosial">
                                <img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $gallery_social[4]['photo_name']; ?>" alt="Galeri 5">
                                <span class="gallery-zoom-icon"><i class="fa fa-search-plus"></i></span>
                            </a>
                        <?php else: ?>
                            <a class="gallery-photo payment-promo-image-popup" href="assets/uploads/social5.png" title="Dampak Nyata - Dokumentasi kegiatan sosial">
                                <img src="assets/uploads/social5.png" alt="Galeri 5" onerror="this.src='https://via.placeholder.com/400x250?text=Gambar+5'">
                                <span class="gallery-zoom-icon"><i class="fa fa-search-plus"></i></span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="gallery-item">
                        <?php if(isset($gallery_social[5])): ?>
                            <a class="gallery-photo payment-promo-image-popup" href="<?php echo BASE_URL; ?>assets/uploads/<?php echo $gallery_social[5]['photo_name']; ?>" title="Dampak Nyata - Dokumentasi kegiatan sosial">
                                <img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $gallery_social[5]['photo_name']; ?>" alt="Galeri 6">
                                <span class="gallery-zoom-icon"><i class="fa fa-search-plus"></i></span>
                            </a>
                        <?php else: ?>
                            <a class="gallery-photo payment-promo-image-popup" href="assets/uploads/social6.png" title="Dampak Nyata - Dokumentasi kegiatan sosial">
                                <img src="assets/uploads/social6.png" alt="Galeri 6" onerror="this.src='https://via.placeholder.com/400x400?text=Gambar+6'">
                                <span class="gallery-zoom-icon"><i class="fa fa-search-plus"></i></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Kolom 4 -->
                <div class="gallery-column mk-reveal mk-delay-3">
                    <div class="gallery-item">
                        <?php if(isset($gallery_social[6])): ?>
                            <a class="gallery-photo payment-promo-image-popup" href="<?php echo BASE_URL; ?>assets/uploads/<?php echo $gallery_social[6]['photo_name']; ?>" title="Dampak Nyata - Dokumentasi kegiatan sosial">
                                <img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $gallery_social[6]['photo_name']; ?>" alt="Galeri 7">
                                <span class="gallery-zoom-icon"><i class="fa fa-search-plus"></i></span>
                            </a>
                        <?php else: ?>
                            <a class="gallery-photo payment-promo-image-popup" href="assets/uploads/social7.png" title="Dampak Nyata - Dokumentasi kegiatan sosial">
                                <img src="assets/uploads/social7.png" alt="Galeri 7" onerror="this.src='https://via.placeholder.com/400x400?text=Gambar+7'">
                                <span class="gallery-zoom-icon"><i class="fa fa-search-plus"></i></span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="gallery-item">
                        <?php if(isset($gallery_social[7])): ?>
                            <a class="gallery-photo payment-promo-image-popup" href="<?php echo BASE_URL; ?>assets/uploads/<?php echo $gallery_social[7]['photo_name']; ?>" title="Dampak Nyata - Dokumentasi kegiatan sosial">
                                <img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $gallery_social[7]['photo_name']; ?>" alt="Galeri 8">
                                <span class="gallery-zoom-icon"><i class="fa fa-search-plus"></i></span>
                            </a>
                        <?php else: ?>
                            <a class="gallery-photo payment-promo-image-popup" href="assets/uploads/social8.png" title="Dampak Nyata - Dokumentasi kegiatan sosial">
                                <img src="assets/uploads/social8.png" alt="Galeri 8" onerror="this.src='https://via.placeholder.com/400x400?text=Gambar+8'">
                                <span class="gallery-zoom-icon"><i class="fa fa-search-plus"></i></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <!-- CTA Bottom Section -->
    <section class="social-cta mk-reveal">
        <div class="social-container">
            <h2>Mari Berkolaborasi untuk Kebaikan</h2>
            <p>Punya ide untuk kegiatan sosial atau ingin berkolaborasi dalam program pemberdayaan masyarakat? Kami sangat terbuka untuk mendengar saran Anda.</p>
            <div class="cta-actions">
                <!-- Menggunakan fa-map-pin atau fas fa-map-marker-alt sebagai alternatif -->
                <a href="#" class="btn-icon-white"><i class="fa fa-lightbulb-o"></i> Usulkan Kegiatan</a>
                <a href="#" class="btn-icon-outline"><i class="fas fa-handshake"></i> Jadilah Mitra Sosial</a>
            </div>
        </div>
    </section>
    
</main>

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

<?php require_once('footer.php'); ?>
