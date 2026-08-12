<?php 
require_once('header.php');

$cabangList = [];
$stmtCabangAll = $pdo->query("SELECT id, nama_cabang FROM tbl_cabang ORDER BY nama_cabang ASC");
$cabangList = $stmtCabangAll->fetchAll(PDO::FETCH_ASSOC);
 
// Cabang default yang tampil pertama kali (cabang pertama di list)
$defaultCabangId = isset($cabangList[0]) ? $cabangList[0]['id'] : 0;
$defaultCabangNama = isset($cabangList[0]) ? $cabangList[0]['nama_cabang'] : '';
?>

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

/* ---------------- Flyer Promo Section ---------------- */
.mk-catalog-section{ background:#FFFFFF; padding:70px 24px; text-align:center; }
.mk-catalog-section .container{ max-width:1180px; margin:0 auto; }
.mk-catalog-title{ font-size:2.25rem; font-weight:800; color:var(--mk-text,#2E2620); margin:0 0 6px; }
.mk-catalog-sub{ font-size:1.3rem; color:var(--mk-muted,#8A7F73); margin:0 0 20px; }
.mk-catalog-divider{ width:60px; height:3px; background:var(--mk-orange,#E8792E); margin:0 auto 30px; border-radius:2px; }
 
/* Dropdown cabang */
.mk-catalog-select-wrap{ max-width:340px; margin:0 auto 36px; position:relative; }
.mk-catalog-select-label{ position:absolute; width:1px; height:1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; }

.mk-catalog-select-pin{ position:absolute; left:20px; top:50%; transform:translateY(-50%); color:var(--mk-orange,#E8792E); font-size:1.25rem; pointer-events:none; z-index:2; }
.mk-catalog-select-chevron{ position:absolute; right:20px; top:50%; transform:translateY(-50%); color:var(--mk-text,#2E2620); font-size:0.95rem; pointer-events:none; z-index:2; }

.mk-catalog-select{
    width:100%; padding:16px 46px; border:2px solid var(--mk-border,#EDE4D8); border-radius:999px;
    font-size:1.15rem; font-weight:700; font-family:inherit; color:var(--mk-text,#2E2620);
    background:#FFFFFF; cursor:pointer; box-sizing:border-box;
    appearance:none; -webkit-appearance:none; -moz-appearance:none;
    box-shadow:0 2px 8px rgba(0,0,0,0.04);
    transition:border-color .2s ease, box-shadow .2s ease;
}
.mk-catalog-select:focus{ outline:none; border-color:var(--mk-orange,#E8792E); box-shadow:0 0 0 3px rgba(232,121,46,0.15); }
.mk-catalog-select::-ms-expand{ display:none; }

.mk-catalog-carousel{ position:relative; max-width:920px; margin:0 auto; padding:20px 64px; }

.mk-catalog-modal{ position:fixed; inset:0; background:rgba(0,0,0,0.85); display:flex; align-items:center; justify-content:center; z-index:9999; padding:12px; opacity:0; visibility:hidden; pointer-events:none; transition:opacity .3s ease, visibility .3s ease; }
.mk-catalog-modal.active{ opacity:1; visibility:visible; pointer-events:auto; }
.mk-catalog-modal img{ max-width:100vw; max-height:100vh; width:auto; height:75vh; border-radius:10px; box-shadow:0 25px 70px rgba(0,0,0,0.5); display:block; transform:scale(0.9); transition:transform .3s ease; }
.mk-catalog-modal.active img{ transform:scale(1); }
.mk-catalog-modal-close{ position:fixed; top:24px; right:24px; width:48px; height:48px; border-radius:50%; background:var(--mk-orange,#E8792E); color:#FFFFFF; border:none; font-size:1.4rem; display:flex; align-items:center; justify-content:center; cursor:pointer; z-index:10000; opacity:0; transform:scale(0.8); transition:opacity .3s ease, transform .3s ease, background .2s ease; pointer-events:none; }
.mk-catalog-modal.active .mk-catalog-modal-close{ opacity:1; transform:scale(1); pointer-events:auto; }
.mk-catalog-modal-close:hover{ background:var(--mk-orange-dark,#C9611F); }
.mk-catalog-viewport{ overflow:hidden; width:100%; }

.mk-catalog-track{ display:flex; align-items:center; gap:24px; transition:transform .35s ease; will-change:transform; }

.mk-catalog-card{ flex-shrink:0; width:220px; border-radius:14px; overflow:hidden; box-shadow:0 8px 20px rgba(0,0,0,0.08); filter:blur(3px) brightness(0.85); opacity:0.55; transform:scale(0.85); transition:all .35s ease; cursor:pointer; }
.mk-catalog-card img{ width:100%; height:auto; display:block; }
.mk-catalog-card.active{ width:320px; filter:none; opacity:1; transform:scale(1); box-shadow:0 14px 34px rgba(0,0,0,0.18); cursor:default; }

.mk-catalog-arrow{ position:absolute; top:50%; transform:translateY(-50%); width:44px; height:44px; border-radius:50%; background:var(--mk-orange,#E8792E); color:#FFFFFF; border:none; display:flex; align-items:center; justify-content:center; font-size:1.2rem; cursor:pointer; z-index:5; transition:background .2s ease; }
.mk-catalog-arrow:hover{ background:var(--mk-orange-dark,#C9611F); }
.mk-catalog-arrow:disabled{ opacity:0.4; cursor:not-allowed; }
.mk-catalog-arrow-prev{ left:0; }
.mk-catalog-arrow-next{ right:0; }

.mk-catalog-actions{ display:flex; gap:14px; justify-content:center; margin-top:30px; }
.mk-catalog-btn{ display:inline-flex; align-items:center; gap:8px; font-weight:700; font-size:1.1rem; padding:12px 22px; border-radius:8px; border:none; cursor:pointer; text-decoration:none; }
.mk-catalog-btn-download{ background:var(--mk-orange,#E8792E); color:#FFFFFF !important; }
.mk-catalog-btn-download:hover{ background:var(--mk-orange-dark,#C9611F); }
.mk-catalog-btn-print{ background:var(--mk-orange,#E8792E); color:#FFFFFF !important; }
.mk-catalog-btn-print:hover{ background:var(--mk-orange-dark,#C9611F); }
 
.mk-catalog-empty, .mk-catalog-loading{ color:var(--mk-muted,#8A7F73); font-size:1.2rem; padding:40px 0; }
 

@media (max-width:768px){
    .mk-catalog-carousel{ padding:16px 44px; max-width:100%; }
    .mk-catalog-card{ width:110px; }
    .mk-catalog-card.active{ width:200px; }
    .mk-catalog-arrow{ width:36px; height:36px; font-size:1rem; }
    .mk-catalog-title{ font-size:1.5rem; padding:0 16px; }
    .mk-catalog-sub{ font-size:1.1rem; padding:0 16px; }
    .mk-catalog-select-wrap{ padding:0 16px; }
}

@media (max-width:600px){
    .mk-catalog-modal{ padding:16px 12px; }
    .mk-catalog-modal img{ max-width:100%; max-height:50vh; }
    .mk-catalog-modal-close{ top:12px; right:12px; width:40px; height:40px; font-size:1.1rem; }
}

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

<!-- Katalog Cabang Start -->
<section class="mk-catalog-section">
    <div class="container">
        <h2 class="mk-catalog-title" id="mkCatalogTitle">Katalog Cabang  <?php echo htmlspecialchars($defaultCabangNama); ?></h2>
        <p class="mk-catalog-sub" id="mkCatalogSub">Hanya berlaku di <?php echo htmlspecialchars($defaultCabangNama); ?></p>
        <div class="mk-catalog-divider"></div>
 
        <div class="mk-catalog-select-wrap">
            <i class="fa fa-map-marker-alt mk-catalog-select-pin"></i>
            <select id="mkCabangSelect" class="mk-catalog-select" aria-label="Pilih Cabang">
                <?php foreach ($cabangList as $c): ?>
                    <option value="<?php echo $c['id']; ?>" <?php echo ($c['id'] == $defaultCabangId) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($c['nama_cabang']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <i class="fa fa-chevron-down mk-catalog-select-chevron"></i>
        </div>
        
        <div id="mkCatalogBody">
            <p class="mk-catalog-loading">Memuat katalog...</p>
        </div>
        <!-- Modal Preview Katalog -->
<div class="mk-catalog-modal" id="mkCatalogModal">
    <button class="mk-catalog-modal-close" id="mkCatalogModalClose" aria-label="Tutup"><i class="fa fa-times"></i></button>
    <img src="" alt="Katalog besar" id="mkCatalogModalImg">
</div>
    </div>
</section>
<!-- Katalog Cabang End -->

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

<script>
(function(){
    // TODO: sesuaikan path endpoint & folder foto jika berbeda
    const AJAX_URL       = '<?php echo BASE_URL; ?>flyers.php';
    const FLYER_BASE_PATH = '<?php echo BASE_URL; ?>assets/uploads/';
 
    const select  = document.getElementById('mkCabangSelect');
    const titleEl = document.getElementById('mkCatalogTitle');
    const subEl   = document.getElementById('mkCatalogSub');
    const bodyEl  = document.getElementById('mkCatalogBody');
 
    const modal      = document.getElementById('mkCatalogModal');
    const modalImg   = document.getElementById('mkCatalogModalImg');
    const modalClose = document.getElementById('mkCatalogModalClose');

    function openModal(src){
        modalImg.setAttribute('src', src);
        modal.classList.add('active');
        document.body.classList.add('mk-no-scroll');
    }

    function closeModal(){
        modal.classList.remove('active');
        document.body.classList.remove('mk-no-scroll');
        modalImg.setAttribute('src', '');
    }

    modalClose.addEventListener('click', closeModal);

    // Tutup kalau klik area gelap di luar gambar (bukan gambarnya sendiri)
    modal.addEventListener('click', function(e){
        if (e.target === modal) closeModal();
    });

    // Tutup juga dengan tombol Escape (opsional tapi umum untuk lightbox)
    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape') closeModal();
    });

    function updateTitle(namaCabang){
        titleEl.textContent = 'Katalog Cabang  ' + namaCabang;
        subEl.textContent   = 'Hanya berlaku di  ' + namaCabang;
    }
 
    function loadKatalog(idCabang, namaCabang){
        bodyEl.innerHTML = '<p class="mk-catalog-loading">Memuat katalog...</p>';
        updateTitle(namaCabang);
 
        fetch(AJAX_URL + '?id_cabang=' + encodeURIComponent(idCabang))
            .then(res => res.json())
            .then(data => {
                // ajax-katalog.php mengembalikan array polos nama file,
                // atau {error: "..."} jika terjadi kegagalan query
                if (data && data.error) {
                    bodyEl.innerHTML = '<p class="mk-catalog-empty">Gagal memuat katalog.</p>';
                    return;
                }
 
                if (!Array.isArray(data) || data.length === 0) {
                    bodyEl.innerHTML = '<p class="mk-catalog-empty">Belum ada katalog untuk cabang ini.</p>';
                    return;
                }
 
                const flyers = data.map(function(filename){
                    return FLYER_BASE_PATH + filename;
                });
 
                renderCarousel(flyers);
            })
            .catch(() => {
                bodyEl.innerHTML = '<p class="mk-catalog-empty">Terjadi kesalahan saat memuat katalog.</p>';
            });
    }
 
    function renderCarousel(flyerUrls){
    let cardsHtml = '';
    flyerUrls.forEach((src, idx) => {
        cardsHtml += '<div class="mk-catalog-card" data-index="' + idx + '" data-src="' + src + '">' +
                        '<img src="' + src + '" alt="Katalog promo ' + (idx + 1) + '">' +
                     '</div>';
    });

    bodyEl.innerHTML =
        '<div class="mk-catalog-carousel">' +
            '<button class="mk-catalog-arrow mk-catalog-arrow-prev" id="mkCatalogPrev" aria-label="Sebelumnya"><i class="fa fa-chevron-left"></i></button>' +
            '<div class="mk-catalog-viewport" id="mkCatalogViewport">' +
                '<div class="mk-catalog-track" id="mkCatalogTrack">' + cardsHtml + '</div>' +
            '</div>' +
            '<button class="mk-catalog-arrow mk-catalog-arrow-next" id="mkCatalogNext" aria-label="Berikutnya"><i class="fa fa-chevron-right"></i></button>' +
        '</div>' +
        '<div class="mk-catalog-actions">' +
            '<a href="#" id="mkCatalogDownload" class="mk-catalog-btn mk-catalog-btn-download" download><i class="fa fa-download"></i> Download</a>' +
            '<button type="button" id="mkCatalogPrint" class="mk-catalog-btn mk-catalog-btn-print"><i class="fa fa-print"></i> Print</button>' +
        '</div>';

    initCarousel();
}

function initCarousel(){
    const viewport = document.getElementById('mkCatalogViewport');
    const track   = document.getElementById('mkCatalogTrack');
    const cards   = Array.from(track.querySelectorAll('.mk-catalog-card'));
    const prevBtn = document.getElementById('mkCatalogPrev');
    const nextBtn = document.getElementById('mkCatalogNext');
    const downloadBtn = document.getElementById('mkCatalogDownload');
    const printBtn = document.getElementById('mkCatalogPrint');

    let current = 0;

    function centerActiveCard(){
    const activeCard = cards[current];
    if (!activeCard) return;

    const viewportRect = viewport.getBoundingClientRect();
    const cardRect = activeCard.getBoundingClientRect();

    const cardCenter = cardRect.left + cardRect.width / 2;
    const viewportCenter = viewportRect.left + viewportRect.width / 2;
    const delta = cardCenter - viewportCenter;

    const currentStyle = window.getComputedStyle(track);
    const matrix = (currentStyle.transform && currentStyle.transform !== 'none')
        ? new DOMMatrixReadOnly(currentStyle.transform)
        : new DOMMatrixReadOnly();
    const currentTranslateX = matrix.m41;

    const newTranslateX = currentTranslateX - delta;
    track.style.transform = 'translateX(' + newTranslateX + 'px)';
}

    function render(){
        cards.forEach((card, idx) => card.classList.toggle('active', idx === current));
        prevBtn.disabled = current === 0;
        nextBtn.disabled = current === cards.length - 1;

        const activeSrc = cards[current].dataset.src;
        downloadBtn.setAttribute('href', activeSrc);
        downloadBtn.setAttribute('download', activeSrc.split('/').pop());

        centerActiveCard();
    }

    // Hitung ulang posisi tengah TEPAT saat animasi lebar kartu aktif selesai
    track.addEventListener('transitionend', function(e){
        if (e.propertyName === 'width') {
            centerActiveCard();
        }
    });

    prevBtn.addEventListener('click', () => { if (current > 0){ current--; render(); } });
    nextBtn.addEventListener('click', () => { if (current < cards.length - 1){ current++; render(); } });
    cards.forEach((card, idx) => {
        card.addEventListener('click', () => {
            if (idx === current) {
                openModal(card.dataset.src);
            } else {
                current = idx;
                render();
            }
        });
    });
    printBtn.addEventListener('click', () => {
        const src = cards[current].dataset.src;
        const printWindow = window.open('', '_blank');
        printWindow.document.write(
            '<html><head><title>Print Katalog</title></head>' +
            '<body style="margin:0;display:flex;justify-content:center;align-items:center;">' +
            '<img src="' + src + '" style="max-width:100%;" onload="window.print();window.close();">' +
            '</body></html>'
        );
        printWindow.document.close();
    });

    window.addEventListener('resize', centerActiveCard);

    render();
}
 
    // Ganti katalog saat dropdown dipilih -> ambil nama cabang dari teks opsi yang dipilih
    select.addEventListener('change', function(){
        const namaCabang = this.options[this.selectedIndex].text;
        loadKatalog(this.value, namaCabang);
    });
 
    // Load katalog cabang default saat halaman pertama kali dibuka
    <?php if ($defaultCabangId): ?>
        loadKatalog(<?php echo $defaultCabangId; ?>, <?php echo json_encode($defaultCabangNama); ?>);
    <?php else: ?>
        bodyEl.innerHTML = '<p class="mk-catalog-empty">Belum ada data cabang.</p>';
    <?php endif; ?>
})();
</script>