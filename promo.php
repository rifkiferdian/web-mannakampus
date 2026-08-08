<?php require_once('header.php');?>

<style>
.mk-blog-list{ --mk-orange:#E8792E; --mk-orange-dark:#C9611F; --mk-text:#2E2620; --mk-muted:#8A7F73; --mk-border:#EDE4D8; }
.mk-blog-list a{ text-decoration:none; }

/* ---------------- Hero Section ---------------- */
.mk-shop-hero{ background:#FDF6EF; padding:90px 24px; }
.mk-shop-hero-wrap{ max-width:1200px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; gap:48px; flex-wrap:wrap; }
.mk-shop-hero-content{ flex:1; min-width:320px; }
.mk-shop-hero-badge{ display:inline-block; background:#FBE4CC; color:#C9611F; font-weight:700; font-size:1.2rem; padding:6px 16px; border-radius:20px; margin-bottom:20px; }
.mk-shop-hero-title{ font-size:3.25rem; font-weight:800; color: #1C1C1C; line-height:1.5; margin:0 0 18px; }
.mk-shop-hero-title span{ color:#E8792E; display:block; }
.mk-shop-hero-desc{ color:#6B6058; font-size:1.5rem; line-height:1.7; max-width:460px; margin:0 0 32px; }
.mk-shop-hero-actions{ display:flex; gap:16px; flex-wrap:wrap; }
.mk-shop-hero-btn-primary{ display:inline-flex; align-items:center; gap:8px; background:#E8792E; color:#FFFFFF !important; font-weight:700; font-size:1.25rem; padding:16px 28px; border-radius:8px; text-decoration:none; box-shadow:0 4px 12px rgba(232,121,46,0.3); transition:background .2s ease; }
.mk-shop-hero-btn-primary:hover{ background:#C9611F; }
.mk-shop-hero-btn-outline{ display:inline-flex; align-items:center; background:#FFFFFF; color:#2E2620 !important; font-weight:700; font-size:1.25rem; padding:16px 28px; border-radius:8px; border:1.5px solid #2E2620; text-decoration:none; transition:all .2s ease; }
.mk-shop-hero-btn-outline:hover{ background:#2E2620; color:#FFFFFF !important; }
.mk-shop-hero-media{ flex:1; position:relative; margin-left:auto; }
.mk-shop-hero-media img{ width:100%; object-fit:cover; border-radius:16px; display:block; box-shadow:0 12px 30px rgba(0,0,0,0.12); }
.mk-shop-hero-card{ position:absolute; left:24px; bottom:-28px; background:#FFFFFF; border-radius:12px; padding:16px 20px; display:flex; align-items:center; gap:14px; box-shadow:0 8px 24px rgba(0,0,0,0.12); max-width:280px; }
.mk-shop-hero-card-icon{ width:44px; height:44px; border-radius:50%; background:#FDECEC; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:#E8792E; font-size:1.5rem; }
.mk-shop-hero-card-title{ font-weight:700; color:#1C1C1C; font-size:1.25rem; margin:0; }
.mk-shop-hero-card-sub{ color:#8A7F73; font-size:1.25rem; margin:2px 0 0; }

@media (max-width:768px){
    .mk-shop-hero{ padding:60px 20px 90px; }
    .mk-shop-hero-wrap{ flex-direction:column; }
    .mk-shop-hero-title{ font-size:2rem; }
    .mk-shop-hero-card{ position:static; margin-top:20px; max-width:none; }
}

/* ---------------- Section: Promo Flyer ---------------- */
.mk-flyer-section { padding: 40px 24px; background: #ffffff; text-align: center; }
.mk-flyer-wrap { max-width: 1200px; margin: 0 auto; }
.mk-flyer-select-wrap { margin-bottom: 24px; display: inline-block; position: relative; }
.mk-select-box { position: relative; display: flex; align-items: center; background: #FFFFFF; border: 2px solid #F0E6DA; border-radius: 10px; padding: 0 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.06); transition: all 0.3s ease; }
.mk-select-box:hover, .mk-select-box:focus-within { border-color: #E8792E; box-shadow: 0 6px 20px rgba(232, 121, 46, 0.2); }
.mk-select-icon { color: #E8792E; font-size: 1.1rem; margin-right: 10px; pointer-events: none; }
.mk-select-arrow { color: #8A7F73; font-size: 0.85rem; margin-left: 10px; pointer-events: none; }
.mk-flyer-select { appearance: none; -webkit-appearance: none; -moz-appearance: none; border: none; background: transparent; padding: 12px 10px 12px 0; font-size: 1.3rem; font-weight: 700; color: #2E2620; cursor: pointer; outline: none; min-width: 240px; text-align: left; }
.mk-flyer-select option { font-weight: 600; color: #2E2620; background: #FFFFFF; padding: 10px; }

/* Pembatas Container Carousel agar tidak melebar & pas memuat 3 item */
.mk-flyer-carousel-container { position: relative; max-width: 900px; margin: 0 auto 20px; padding: 0 50px; overflow: hidden; }
.mk-flyer-slick-slider { display: block; width: 100%; }
.mk-flyer-slick-slider .slick-list { overflow: visible !important; padding-top: 25px !important; padding-bottom: 25px !important; }

/* Ukuran slide samping (blur & kecil) */
.mk-flyer-slick-slider .slick-slide { padding: 10px !important; outline: none; transition: all 0.4s ease; transform: scale(0.8); opacity: 0.35; filter: blur(3px); }
.mk-flyer-slick-slider .slick-slide img { width: 100%; max-width: 320px; height: auto; border-radius: 14px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); display: block; margin: 0 auto; cursor: zoom-in; }

/* Ukuran slide tengah (utama & jelas) */
.mk-flyer-slick-slider .slick-center { transform: scale(1.05); opacity: 1; filter: blur(0px); z-index: 10; }
.mk-flyer-slick-slider .slick-center img { box-shadow: 0 12px 36px rgba(0,0,0,0.22); }

.mk-arrow-btn { position: absolute !important; top: 50% !important; transform: translateY(-50%) !important; z-index: 99 !important; width: 46px !important; height: 46px !important; background-color: #E8792E !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; box-shadow: none !important; filter: none !important; outline: none !important; border: none !important; cursor: pointer !important; transition: all 0.25s ease !important; }
.mk-arrow-btn i { color: #FFFFFF !important; font-size: 1.2rem !important; line-height: 1 !important; margin: 0 !important; }
.mk-arrow-btn:hover { background-color: #C9611F !important; transform: translateY(-50%) scale(1.1) !important; }
.mk-arrow-left { left: 0px !important; }
.mk-arrow-right { right: 0px !important; }
.mk-flyer-actions { display: flex; justify-content: center; gap: 16px; margin-top: 24px; }
.mk-flyer-btn { display: inline-flex; align-items: center; gap: 8px; background: #E8792E; color: #FFFFFF !important; font-weight: 700; font-size: 1rem; padding: 10px 24px; border-radius: 6px; border: none; cursor: pointer; text-transform: uppercase; box-shadow: 0 4px 10px rgba(232,121,46,0.3); transition: background .2s ease; text-decoration: none; }
.mk-flyer-btn:hover { background: #C9611F; }
.mk-overlay-container { display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.88); z-index: 99999; justify-content: center; align-items: center; backdrop-filter: blur(6px); }
.mk-overlay-container.active { display: flex !important; }
.mk-overlay-content { width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; padding: 10px; box-sizing: border-box; }
.mk-overlay-content img { height: 96vh !important; width: auto !important; max-width: 90vw !important; object-fit: contain; border-radius: 8px; box-shadow: 0 10px 40px rgba(0,0,0,0.8); display: block; margin: 0 auto; }
.mk-overlay-close { position: absolute; top: 15px; right: 25px; background: rgba(232, 121, 46, 0.8); border: none; color: #FFFFFF; font-size: 2rem; width: 44px; height: 44px; border-radius: 50%; cursor: pointer; z-index: 100000; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.3); }
.mk-overlay-close:hover { background: #C9611F; transform: scale(1.1); }
.mk-overlay-nav { position: absolute; top: 50%; transform: translateY(-50%); background: #E8792E; color: #FFFFFF; border: none; width: 50px; height: 50px; border-radius: 50%; font-size: 1.3rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; z-index: 100000; box-shadow: 0 4px 12px rgba(0,0,0,0.4); }
.mk-overlay-nav:hover { background: #C9611F; transform: translateY(-50%) scale(1.1); }
.mk-overlay-prev { left: 30px; }
.mk-overlay-next { right: 30px; }
@media (max-width: 768px) { .mk-overlay-content img { height: auto !important; max-height: 90vh !important; width: 95vw !important; } .mk-overlay-prev { left: 10px; } .mk-overlay-next { right: 10px; } }
@media (max-width: 768px) { .mk-flyer-carousel-container { padding: 0 10px; max-width: 100%; overflow: visible; } .mk-flyer-slick-slider .slick-slide { transform: scale(0.95); opacity: 0.3; } }

/* ---------------- Member Loyalty Section ---------------- */
.mk-member-section { background: #FDF6EF; padding: 60px 24px; }
.mk-member-wrap { max-width: 1100px; margin: 0 auto; }
.mk-member-card { background: #E8792E; border-radius: 20px; padding: 60px 50px; display: flex; align-items: center; justify-content: space-between; gap: 40px; position: relative; overflow: hidden; box-shadow: 0 10px 25px rgba(232, 121, 46, 0.25); }
.mk-member-content { flex: 1; max-width: 520px; color: #FFFFFF; }
.mk-member-title { font-size: 2.5rem; font-weight: 800; line-height: 1.25; margin: 0 0 16px; color: #FFFFFF; }
.mk-member-desc { font-size: 1.5rem; line-height: 1.6; margin: 0 0 32px; color: rgba(255, 255, 255, 0.9); }
.mk-member-actions { display: flex; gap: 16px; flex-wrap: wrap; }
.mk-member-btn-primary { background: #FFFFFF; color: #2E2620 !important; font-weight: 700; font-size: 1.25rem; padding: 14px 28px; border-radius: 8px; text-decoration: none; transition: all 0.2s ease; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
.mk-member-btn-primary:hover { background: #F5F5F5; transform: translateY(-2px); }
.mk-member-btn-outline { background: transparent; color: #FFFFFF !important; font-weight: 700; font-size: 1.25rem; padding: 14px 28px; border-radius: 8px; border: 1.5px solid rgba(255, 255, 255, 0.8); text-decoration: none; transition: all 0.2s ease; }
.mk-member-btn-outline:hover { background: rgba(255, 255, 255, 0.1); border-color: #FFFFFF; }
.mk-member-card-graphic { position: relative; flex-shrink: 0; }
.mk-loyalty-card { width: 320px; height: 190px; background: linear-gradient(135deg, #7A3B0D 0%, #3D1C04 100%); border-radius: 16px; padding: 20px 24px; box-sizing: border-box; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 12px 28px rgba(0, 0, 0, 0.35); border: 1px solid rgba(255, 255, 255, 0.15); color: #FFFFFF; position: relative; }
.mk-loyalty-header { display: flex; justify-content: space-between; align-items: center; }
.mk-loyalty-title { font-size: 1.15rem; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; }
.mk-loyalty-contactless { font-size: 1.25rem; opacity: 0.9; }
.mk-loyalty-body { margin-top: 10px; }
.mk-loyalty-label { font-size: 1.0rem; text-transform: uppercase; letter-spacing: 1px; opacity: 0.7; margin-bottom: 2px; }
.mk-loyalty-name { font-size: 1.05rem; font-weight: 800; letter-spacing: 1px; }
.mk-loyalty-footer { display: flex; justify-content: space-between; align-items: flex-end; }
.mk-loyalty-valid { font-size: 1.0rem; font-weight: 600; opacity: 0.85; }
.mk-loyalty-circles { display: flex; }
.mk-loyalty-circle { width: 24px; height: 24px; border-radius: 50%; background: rgba(255, 255, 255, 0.25); }
.mk-loyalty-circle:last-child { margin-left: -10px; background: rgba(255, 255, 255, 0.15); }
@media (max-width: 868px) { .mk-member-card { flex-direction: column; padding: 40px 24px; text-align: center; } .mk-member-actions { justify-content: center; } .mk-member-btn-primary, .mk-member-btn-outline { width: 100%; text-align: center; } .mk-loyalty-card { width: 280px; height: 165px; margin: 0 auto; } }

/* ---------------- Section: Cari Gerai Kami ---------------- */
.mk-store-section{ padding:70px 24px; text-align:center; background: #F8F9FA; }
.mk-store-section .container{ max-width:1180px; margin:0 auto; }
.mk-store-title{ font-size:2.5rem; font-weight:800; color:var(--mk-text,#2E2620); margin:0 0 10px; }
.mk-store-sub{ font-size:1.5rem; color:var(--mk-muted,#8A7F73); max-width:520px; margin:0 auto 36px; line-height:1.6; }

.mk-store-box{ display:grid; grid-template-columns:360px 1fr; background:#FFFFFF; border:1px solid var(--mk-border,#EDE4D8); border-radius:16px; overflow:hidden; box-shadow:0 4px 16px rgba(0,0,0,0.05); text-align:left; }

/* Kolom kiri: search + list toko */
.mk-store-list{ border-right:1px solid var(--mk-border,#EDE4D8); max-height:420px; overflow-y:auto; }
.mk-store-search{ padding:16px; border-bottom:1px solid var(--mk-border,#EDE4D8); }
.mk-store-search input{ width:100%; padding:10px 14px; border:1px solid var(--mk-border,#EDE4D8); border-radius:8px; font-size:1.3rem; box-sizing:border-box; font-family:inherit; }
.mk-store-search input:focus{ outline:none; border-color:var(--mk-orange, #E8792E); }

.mk-store-item{ display:flex; justify-content:space-between; align-items:flex-start; gap:10px; padding:16px; border-bottom:1px solid var(--mk-border, #EDE4D8); cursor:pointer; transition:0.2s; }
.mk-store-item:last-child{ border-bottom:none; }
.mk-store-item:hover{ background: #fad3a3; }
.mk-store-item.active{ background: #ffc596;  }
.mk-store-name{ font-weight:700; font-size:1.45rem; color:var(--mk-text, #2E2620); margin:0 0 4px; }
.mk-store-address{ font-size:1.2rem; color:var(--mk-muted, #8A7F73); margin:0 0 6px; }
.mk-store-status{ font-size:1.2rem; font-weight:600; color: #227A3E; }
.mk-store-pin{ color:var(--mk-orange, #E8792E); font-size:1.1rem; flex-shrink:0; }

/* Kolom kanan: map */
.mk-store-map{ min-height:420px; }
.mk-store-map iframe{ width:100%; height:100%; min-height:420px; border:0; display:block; }

@media (max-width:768px){
	.mk-store-box{ grid-template-columns:1fr; }
	.mk-store-list{ border-right:none; border-bottom:1px solid var(--mk-border,#EDE4D8); max-height:300px; }
}

/* Kunci scroll dengan aman tanpa reset posisi halaman */
body.mk-no-scroll {
    overflow: hidden !important;
}
</style>

<!-- Hero Shop Start -->
<section class="mk-shop-hero">
    <div class="mk-shop-hero-wrap">
        <div class="mk-shop-hero-content">
            <span class="mk-shop-hero-badge">Hanya Untuk Waktu Terbatas</span>
            <h1 class="mk-shop-hero-title">Pesta Promo <span>Paling Hemat!</span></h1>
            <p class="mk-shop-hero-desc">Dapatkan penawaran terbaik minggu ini hanya di Manna Kampus Rumah Belanja Terpercaya. Dari produk segar hingga kebutuhan rumah tangga, semuanya dengan harga istimewa.</p>
            <div class="mk-shop-hero-actions">
                <a href="#" class="mk-shop-hero-btn-primary"> Lihat Katalog </a>
                <a href="#" class="mk-shop-hero-btn-outline"> Member Deals </a>
            </div>
        </div>

        <div class="mk-shop-hero-media">
            <img src="<?php echo BASE_URL; ?>assets/uploads/promo.png" alt="Belanja kebutuhan harian Manna Kampus">
        </div>
    </div>
</section>
<!-- Hero Shop End -->

<!-- Promo Flyer Section Start -->
<section class="mk-flyer-section">
    <div class="mk-flyer-wrap">
        
        <!-- Dropdown Cabang (Otomatis dari Database) -->
        <div class="mk-flyer-select-wrap">
            <div class="mk-select-box">
                <i class="fa fa-map-marker mk-select-icon"></i>
                <select class="mk-flyer-select" id="branchFlyerSelect">
                    <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_cabang ORDER BY id ASC");
                    $statement->execute();
                    $cabang_list = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($cabang_list as $cabang) {
                        echo '<option value="' . $cabang['id'] . '">' . htmlspecialchars($cabang['nama_cabang'], ENT_QUOTES, 'UTF-8') . '</option>';
                    }
                    ?>
                </select>
                <i class="fa fa-chevron-down mk-select-arrow"></i>
            </div>
        </div>

        <!-- Carousel Container -->
                <div class="mk-flyer-carousel-container">
                    <div id="flyerSlidesWrapper" class="mk-flyer-slick-slider">
                        <!-- Gambar promo akan dimuat oleh AJAX di sini -->
                    </div>
                    <!-- Tombol Navigasi Kiri & Kanan -->
                    <button class="mk-arrow-btn mk-arrow-left" id="flyerPrevBtn"><i class="fa fa-chevron-left"></i></button>
                    <button class="mk-arrow-btn mk-arrow-right" id="flyerNextBtn"><i class="fa fa-chevron-right"></i></button>
                </div>

        <!-- Tombol Download & Print -->
        <div class="mk-flyer-actions">
            <a id="downloadFlyerBtn" href="#" download class="mk-flyer-btn">
                <i class="fa fa-download"></i> Download
            </a>
            <button onclick="printFlyer()" class="mk-flyer-btn">
                <i class="fa fa-print"></i> Print
            </button>
        </div>

    </div>
</section>
<!-- Promo Flyer Section End -->

<!-- Member Loyalty Section Start -->
<section class="mk-member-section">
    <div class="mk-member-wrap">
        <div class="mk-member-card">
            <!-- Left Text Content -->
            <div class="mk-member-content">
                <h2 class="mk-member-title">Member Manna Kampus Lebih Beruntung!</h2>
                <p class="mk-member-desc">
                    Dapatkan poin belanja, diskon khusus ulang tahun, dan akses eksklusif ke flash sale member-only. Daftar sekarang dan mulai menabung!
                </p>
                <div class="mk-member-actions">
                    <a href="#" class="mk-member-btn-primary">Daftar Member Gratis</a>
                    <a href="#" class="mk-member-btn-outline">Pelajari Keuntungan</a>
                </div>
            </div>

            <!-- Right Card Graphic -->
            <div class="mk-member-card-graphic">
                <div class="mk-loyalty-card">
                    <div class="mk-loyalty-header">
                        <span class="mk-loyalty-title">LOYALTY CARD</span>
                        <i class="fa-solid fa-wifi mk-loyalty-contactless"></i>
                    </div>
                    <div class="mk-loyalty-body">
                        <div class="mk-loyalty-label">MEMBER NAME</div>
                        <div class="mk-loyalty-name">MAULANA MALIK</div>
                    </div>
                    <div class="mk-loyalty-footer">
                        <span class="mk-loyalty-valid">Valid Thru 12/28</span>
                        <div class="mk-loyalty-circles">
                            <div class="mk-loyalty-circle"></div>
                            <div class="mk-loyalty-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Member Loyalty Section End -->

<!-- Store Locator Start -->
<section class="mk-store-section">
	<div class="container">
		<h2 class="mk-store-title">Cari Gerai Kami</h2>
		<p class="mk-store-sub">Temukan lokasi Manna Kampus terdekat di kota Anda untuk pengalaman belanja terbaik.</p>

		<div class="mk-store-box">
			<div class="mk-store-list">
				<div class="mk-store-search">
					<input type="text" placeholder="Cari cabang...">
				</div>

				<div class="mk-store-item active">
					<div>
						<p class="mk-store-name">Manna Kampus - C. Simanjuntak</p>
						<p class="mk-store-address">Jl. C. Simanjuntak No.70, Terban, Yogyakarta</p>
						<p class="mk-store-status">BUKA (Tutup 22:00)</p>
					</div>
					<span class="mk-store-pin"><i class="fa fa-map-marker"></i></span>
				</div>

				<div class="mk-store-item">
					<div>
						<p class="mk-store-name">Manna Kampus - Godean</p>
						<p class="mk-store-address">Jl. Godean KM.5, Kokoban, Sleman</p>
						<p class="mk-store-status">BUKA (Tutup 21:00)</p>
					</div>
					<span class="mk-store-pin"><i class="fa fa-map-marker"></i></span>
				</div>

				<div class="mk-store-item">
					<div>
						<p class="mk-store-name">Manna Kampus - Palagan</p>
						<p class="mk-store-address">Jl. Palagan Tentara Pelajar No.77, Sleman</p>
						<p class="mk-store-status">BUKA (Tutup 22:00)</p>
					</div>
					<span class="mk-store-pin"><i class="fa fa-map-marker"></i></span>
				</div>

				<div class="mk-store-item">
					<div>
						<p class="mk-store-name">Manna Kampus - Seturan</p>
						<p class="mk-store-address">Jl. Seturan Raya No.4, Depok, Sleman</p>
						<p class="mk-store-status">BUKA (Tutup 21:00)</p>
					</div>
					<span class="mk-store-pin"><i class="fa fa-map-marker"></i></span>
				</div>
			</div>

			<div class="mk-store-map">
				<iframe
					src="https://maps.google.com/maps?q=Manna%20Kampus%20Yogyakarta&t=&z=14&ie=UTF8&iwloc=&output=embed"
					allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
				</iframe>
			</div>
		</div>
	</div>
</section>
<!-- Store Locator End -->



<?php require_once('footer.php'); ?>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

<!-- Style Overlay Lightbox -->
<div id="mkOverlay" class="mk-overlay-container">
    <button class="mk-overlay-close" id="closeOverlayBtn">&times;</button>
    <button class="mk-overlay-nav mk-overlay-prev" id="overlayPrevBtn"><i class="fa fa-chevron-left"></i></button>
    
    <div class="mk-overlay-content">
        <img id="mkOverlayImage" src="" alt="Zoom Promo Fullscreen">
    </div>
    
    <button class="mk-overlay-nav mk-overlay-next" id="overlayNextBtn"><i class="fa fa-chevron-right"></i></button>
</div>

<!-- Script Pemanggil JS Flyer Promo -->
<script>
    window.baseUrl = "<?php echo BASE_URL; ?>assets/uploads/";
</script>
<script src="<?php echo BASE_URL; ?>assets/js/flyers-promo.js"></script>