<?php 
require_once('header.php');

$cabangList = [];
$stmtCabangAll = $pdo->query("SELECT * FROM tbl_cabang ORDER BY id ASC");
$cabangList = $stmtCabangAll->fetchAll(PDO::FETCH_ASSOC);

// 1. Tentukan id cabang dari URL (?cabang=ID)
$selected_cabang_id = isset($_GET['cabang']) ? (int) $_GET['cabang'] : 0;
$current_cabang = null;

// 2. Cari data cabang sesuai ID yang dipilih
if ($selected_cabang_id > 0) {
    foreach ($cabangList as $cabang) {
        if ($cabang['id'] == $selected_cabang_id) {
            $current_cabang = $cabang;
            break;
        }
    }
}

// 3. Jika ID tidak valid atau tidak ada di URL, gunakan cabang pertama sebagai default
if (!$current_cabang && count($cabangList) > 0) {
    $current_cabang = $cabangList[0];
    $selected_cabang_id = $current_cabang['id'];
}

$first_map_location = !empty($current_cabang['alamat']) ? $current_cabang['alamat'] : 'Manna Kampus Yogyakarta';

// 4. Query mengambil daftar produk promo eksklusif milik cabang yang sedang diakses
$result_promos = [];
if ($current_cabang) {
    $stmt_promo = $pdo->prepare("SELECT * FROM tbl_cabang_promo WHERE id_cabang = ? ORDER BY id DESC LIMIT 8");
    $stmt_promo->execute([$current_cabang['id']]);
    $result_promos = $stmt_promo->fetchAll(PDO::FETCH_ASSOC);
}
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

/* ---------------- Flyer Carousel Section ---------------- */
.mk-flyer-section{ background-image: url('assets/uploads/promo-banner2.png'); padding:70px 24px 100px; background-size: cover; background-position: top center; }
.mk-flyer-header{ max-width:1200px; margin:0 auto 40px; text-align:center; }
.mk-flyer-header h2{ font-size:2.25rem; font-weight:800; color:#1C1C1C; margin:0 0 10px; }
.mk-flyer-header p{ color:#8A7F73; font-size:1.5rem; margin:0; }

.mk-flyer-branch-picker{ margin-top:20px; display:flex; justify-content:center; }
.mk-flyer-branch-picker select{
    appearance:none;
    -webkit-appearance:none;
    background:#fff url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23E8792E"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 14px center;
    background-size:16px;
    border:1.5px solid #f59220;
    color:#2E2620;
    font-weight:700;
    font-size:1.15rem;
    padding:12px 44px 12px 18px;
    border-radius:8px;
    min-width:280px;
    cursor:pointer;
    text-align:left;
    box-shadow:0 4px 10px rgba(0,0,0,.04);
}
.mk-flyer-branch-picker select:focus{
    outline:none;
    border-color:#E8792E;
}

.mk-flyer-wrap{ max-width:800px; margin:0 auto; position:relative; padding:0 60px; }
.mk-flyer-slider{ margin:0 -12px; }
.mk-flyer-slide{ padding:0 12px; }
.mk-flyer-slide-inner{ background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 8px 24px rgba(0,0,0,.08); }
.mk-flyer-slide img{
    width:100%;
    display:block;
    aspect-ratio:3/4;
    object-fit:cover;
    border-radius:14px;
    opacity:.45;
    transform:scale(.86);
    box-shadow:0 10px 28px rgba(0,0,0,.10);
    transition:transform .35s ease, opacity .35s ease, box-shadow .35s ease;
    cursor:pointer;
}
.mk-flyer-slider .slick-center img{
    opacity:1;
    transform:scale(1);
    box-shadow:0 22px 48px rgba(0,0,0,.20);
}
.mk-flyer-slider .slick-slide{ transition:all .35s ease; }

.mk-flyer-arrow{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    width:48px; height:48px;
    border-radius:50%;
    background:#fff;
    border:1px solid #EDE4D8;
    color:#E8792E;
    font-size:1.15rem;
    display:flex; align-items:center; justify-content:center;
    cursor:pointer;
    box-shadow:0 8px 20px rgba(0,0,0,.12);
    z-index:5;
    transition:background .2s ease, color .2s ease;
}
.mk-flyer-arrow-prev{ left:0; }
.mk-flyer-arrow-next{ right:0; }
.mk-flyer-arrow:hover{ background:#E8792E; color:#fff; }

.mk-flyer-actions{ display:flex; justify-content:center; gap:16px; margin-top:44px; }
.mk-flyer-btn{ display:inline-flex; align-items:center; gap:8px; padding:13px 30px; border-radius:8px; font-weight:700; font-size:1.05rem; text-decoration:none; border:1.5px solid transparent; transition:background .2s ease,color .2s ease; }
.mk-flyer-btn-primary{ background:#E8792E; color:#fff !important; }
.mk-flyer-btn-primary:hover{ background:#C9611F; }
.mk-flyer-btn-outline{ background:#fff; color:#2E2620 !important; border-color:#2E2620; }
.mk-flyer-btn-outline:hover{ background:#2E2620; color:#fff !important; }

.mk-flyer-empty{ text-align:center; color:#8A7F73; font-size:1.05rem; padding:40px 0; }

@media (max-width:768px){
    .mk-flyer-wrap{ padding:0 44px; }
    .mk-flyer-arrow{ width:40px; height:40px; font-size:1rem; }
    .mk-flyer-header h2{ font-size:1.6rem; }
}
.mfp-wrap img,
.mfp-content img,
.mfp-figure img{
    max-height: 75vh !important;  /* disamakan persis dengan explor.php */
}.mfp-close{ position: fixed !important; top: 24px !important;right: 24px !important;left: auto !important; width: 44px !important;height: 44px !important;line-height: 44px !important;font-size: 26px !important;background: #E8792E !important; !important;color: #fff !important;border-radius: 50% !important;opacity: 1 !important;z-index: 2000 !important;text-align: center !important;}
.mfp-close:hover{background: #E8792E !important;}
.mfp-arrow:before, .mfp-arrow:after{ border:none !important; }
.mfp-arrow{ background:#fff; border-radius:50%; width:44px !important; height:44px !important; opacity:1 !important; }
.mfp-arrow-left{ background-image:none; }
.mfp-arrow:after{ content:""; }
.mk-flyer-slider .slick-current .mk-flyer-slide-inner{ cursor:zoom-in; }


/* ---------------- SECTION 4: PROMO EKSKLUSIF (Single-Line) ---------------- */
/* Container Pembungkus Promo */
.mk-container { 
    max-width: 1200px; 
    margin: 0 auto; 
    padding: 0 24px; 
    width: 100%;
}

.mk-promo-header {
    width: 100%; /* Pastikan header membentang penuh di dalam container */
}
.mk-sec-promo { background-image: url('assets/uploads/promo-banner.png'); padding: 60px 0; background-size: cover;background-position: top center;}
.mk-promo-header { display: flex; flex-direction: column; align-items: center; text-align: center; margin-bottom: 30px; position: relative; min-height: 50px; }
.mk-promo-title-box h2 { font-size: 1.75rem; font-weight: 800; color: #2E2620; margin: 0 0 6px 0; }
.mk-promo-title-box p { font-size: 1.25rem; color: #8A7F73; margin: 0; }
.mk-promo-link-all { font-size: 1.05rem; font-weight: 700; color: #E8792E; text-decoration: none; display: flex; align-items: center; gap: 6px; transition: color 0.2s; position: absolute; right: 0; bottom: 0; }
.mk-promo-link-all:hover { color: #A04000; }
.mk-promo-underline { width: 60px; height: 3px; background-color: #E8792E; margin: 20px auto; border-radius: 2px; }

/* Product Grid & Card */
.mk-promo-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
.mk-product-card { background: #FFFFFF; border: 1px solid #EAEAEA; border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03); transition: transform 0.25s ease, box-shadow 0.25s ease; }
.mk-product-card:hover { transform: translateY(-6px); box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08); }

/* Thumbnail & Badge */
.mk-product-thumb { position: relative; width: 100%; height: 200px; background: #F8F8F8; overflow: hidden; }
.mk-product-thumb img { width: 100%; height: 100%; object-fit: cover; }
.mk-product-badge { position: absolute; top: 12px; left: 12px; background: #D9381E; color: #FFFFFF; font-size: 1rem; font-weight: 800; padding: 4px 10px; border-radius: 6px; text-transform: uppercase; box-shadow: 0 2px 6px rgba(0,0,0,0.2); }

/* Product Details & Price */
.mk-product-info { padding: 18px 16px; display: flex; flex-direction: column; flex: 1; }
.mk-product-cat { font-size: 1.25rem; color: #8A7F73; margin-bottom: 4px; font-weight: 600; }
.mk-product-title { font-size: 1.45rem; font-weight: 800; color: #2E2620; margin: 0 0 12px 0; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.6em; }
.mk-product-price-box { margin-top: auto; margin-bottom: 14px; }
.mk-price-old { font-size: 1.25rem; color: #999999; text-decoration: line-through; display: block; margin-bottom: 2px; }
.mk-price-now { font-size: 1.45rem; font-weight: 800; color: #2E2620; }

/* Button */
.mk-btn-cart { width: 100%; background: #E8792E; color: #FFFFFF; border: none; padding: 10px; border-radius: 8px; font-weight: 700; font-size: 1.25rem; cursor: pointer; transition: background 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; }
.mk-btn-cart:hover { background: #A04000; }

/* Responsive Media Queries */
@media (max-width: 1024px) { .mk-promo-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px) { .mk-promo-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .mk-promo-grid { grid-template-columns: 1fr; } }

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
</style>

<!-- Hero Shop Start -->
<section class="mk-shop-hero">
    <div class="mk-shop-hero-wrap">
        <div class="mk-shop-hero-content">
            <span class="mk-shop-hero-badge">Hanya Untuk Waktu Terbatas</span>
            <h1 class="mk-shop-hero-title">Pesta Promo <span>Paling Hemat!</span></h1>
            <p class="mk-shop-hero-desc">Dapatkan penawaran terbaik minggu ini hanya di Manna Kampus Rumah Belanja Terpercaya. Dari produk segar hingga kebutuhan rumah tangga, semuanya dengan harga istimewa.</p>
        </div>

        <div class="mk-shop-hero-media">
            <img src="<?php echo BASE_URL; ?>assets/uploads/promo.png" alt="Belanja kebutuhan harian Manna Kampus">
        </div>
    </div>
</section>
<!-- Hero Shop End -->

<?php
// Ambil flyer sesuai cabang terpilih dan tanggal aktif
if ($selected_cabang_id > 0) {

    $statement = $pdo->prepare("
        SELECT *
        FROM tbl_flyer
        WHERE id_cabang = ?
          AND start_date <= CURDATE()
          AND end_date >= CURDATE()
        ORDER BY id ASC
    ");

    $statement->execute([$selected_cabang_id]);

} else {

    $statement = $pdo->prepare("
        SELECT *
        FROM tbl_flyer
        WHERE start_date <= CURDATE()
          AND end_date >= CURDATE()
        ORDER BY id ASC
    ");

    $statement->execute();
}

// Simpan hasil query ke variabel $flyers
$flyers = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Flyer Carousel Start -->
<section class="mk-flyer-section" id="mk-flyer-section">
    <div class="mk-flyer-header">
        <h2>Katalog Promo Minggu Ini</h2>
        <p>Geser untuk melihat semua flyer promo dari Manna Kampus</p>

        <?php if (count($cabangList) > 0): ?>
        <div class="mk-flyer-branch-picker">
            <select id="mk-flyer-branch-select" onchange="window.location.href='promo.php?cabang='+this.value+'#mk-flyer-section'">
                <?php foreach ($cabangList as $cabang): ?>
                    <option value="<?php echo $cabang['id']; ?>" <?php echo ($cabang['id'] == $selected_cabang_id) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cabang['nama_cabang'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>
    </div>

    <?php if (count($flyers) > 0): ?>
        <div class="mk-flyer-wrap">
            <button type="button" class="mk-flyer-arrow mk-flyer-arrow-prev" id="mk-flyer-prev"><i class="fa fa-chevron-left"></i></button>
            <button type="button" class="mk-flyer-arrow mk-flyer-arrow-next" id="mk-flyer-next"><i class="fa fa-chevron-right"></i></button>

            <div class="mk-flyer-slider">
                <?php foreach ($flyers as $flyer): ?>
                    <?php $photoFile = htmlspecialchars($flyer['photo'], ENT_QUOTES, 'UTF-8'); ?>
                    <div class="mk-flyer-slide">
                        <div class="mk-flyer-slide-inner">
                            <img
                                src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $photoFile; ?>"
                                data-photo="<?php echo $photoFile; ?>"
                                alt="Flyer Promo Manna Kampus">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="mk-flyer-actions">
            <a href="#" id="mk-flyer-download" class="mk-flyer-btn mk-flyer-btn-primary" download>
                <i class="fa fa-download"></i> Download
            </a>
            <a href="#" id="mk-flyer-print" class="mk-flyer-btn mk-flyer-btn-outline">
                <i class="fa fa-print"></i> Print
            </a>
        </div>
    <?php else: ?>
        <p class="mk-flyer-empty">Belum ada flyer promo untuk cabang ini.</p>
    <?php endif; ?>
</section>
<!-- Flyer Carousel End -->

<!-- Promo Eksklusif -->
        <section class="mk-sec-promo">
            <div class="mk-container">
                
                <div class="mk-promo-header">
                    <div class="mk-promo-title-box">
                        <h2>Promo Exclusive Cabang <?php echo htmlspecialchars($current_cabang['nama_cabang'], ENT_QUOTES, 'UTF-8'); ?></h2>
                        <p>Hanya berlaku di <?php echo htmlspecialchars($current_cabang['nama_cabang'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <div class="mk-promo-underline"></div>
                    </div>
                    <a href="promo.php?cabang=<?php echo $current_cabang['id']; ?>" class="mk-promo-link-all">
                        Lihat Semua <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </div>

                <div class="mk-promo-grid">
                    <?php if (!empty($result_promos)): ?>
                        <?php foreach ($result_promos as $p): 
                            $foto_produk = !empty($p['foto']) 
                                ? BASE_URL . 'assets/uploads/' . $p['foto'] 
                                : BASE_URL . 'assets/uploads/default-product.jpg';
                        ?>
                            <!-- Product Card Item -->
                            <div class="mk-product-card">
                                <div class="mk-product-thumb">
                                    <?php if (!empty($p['badge'])): ?>
                                        <span class="mk-product-badge"><?php echo htmlspecialchars($p['badge'], ENT_QUOTES, 'UTF-8'); ?></span>
                                    <?php endif; ?>
                                    <img src="<?php echo $foto_produk; ?>" alt="<?php echo htmlspecialchars($p['nama_produk'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>

                                <div class="mk-product-info">
                                    <span class="mk-product-cat"><?php echo htmlspecialchars(!empty($p['kategori']) ? $p['kategori'] : 'Promo Spesial', ENT_QUOTES, 'UTF-8'); ?></span>
                                    <h4 class="mk-product-title"><?php echo htmlspecialchars($p['nama_produk'], ENT_QUOTES, 'UTF-8'); ?></h4>

                                    <div class="mk-product-price-box">
                                        <?php if (!empty($p['harga_coret']) && $p['harga_coret'] > $p['harga_promo']): ?>
                                            <span class="mk-price-old">Rp <?php echo number_format($p['harga_coret'], 0, ',', '.'); ?></span>
                                        <?php endif; ?>
                                        <span class="mk-price-now">Rp <?php echo number_format($p['harga_promo'], 0, ',', '.'); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="grid-column: 1 / -1; text-align:center; color:#8A7F73; padding: 40px 0;">
                            <p>Saat ini belum ada promo khusus untuk cabang ini.</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </section>
<!-- Promo Eksklusif End -->

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
                    <a href="member.php" class="mk-member-btn-outline">Pelajari Keuntungan</a>
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

				<?php if (!empty($cabangList)): ?>
					<?php foreach ($cabangList as $index => $row): ?>
						<?php
						$active_class = ($index === 0) ? 'active' : '';
						$alamat_cabang = !empty($row['alamat']) ? $row['alamat'] : $row['nama_cabang'];
						$jam_op = !empty($row['jam_operasional']) ? $row['jam_operasional'] : 'Buka 08:00 - 21:00';
						$nama_cabang = !empty($row['nama_cabang']) ? $row['nama_cabang'] : 'Manna Kampus';
						$escaped_address = addslashes($alamat_cabang);
						$display_status = 'BUKA';
						if (!empty($row['jam_operasional'])) {
							$display_status .= ' (' . htmlspecialchars($jam_op) . ')';
						} else {
							$display_status .= ' (Tutup 21:00)';
						}
						?>
						<div class="mk-store-item <?php echo $active_class; ?>" onclick="changeMapLocation('<?php echo $escaped_address; ?>', this)">
							<div>
								<p class="mk-store-name"><?php echo htmlspecialchars($nama_cabang); ?></p>
								<p class="mk-store-address"><?php echo htmlspecialchars($alamat_cabang); ?></p>
								<p class="mk-store-status"><?php echo htmlspecialchars($display_status); ?></p>
							</div>
							<span class="mk-store-pin"><i class="fa fa-map-marker"></i></span>
						</div>
					<?php endforeach; ?>
				<?php else: ?>
					<p class="mk-catalog-empty">Belum ada data cabang.</p>
				<?php endif; ?>
			</div>

			<div class="mk-store-map">
				<iframe
					id="storeMapIframe"
					src="https://maps.google.com/maps?q=<?php echo urlencode($first_map_location); ?>&t=&z=16&ie=UTF8&iwloc=&output=embed"
					allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
				</iframe>
			</div>
		</div>
	</div>
</section>
<!-- Store Locator End -->

<?php if (count($flyers) > 0): ?>
<script>
window.addEventListener('load', function () {
    if (typeof jQuery === 'undefined') {
        console.error('MK Flyer Carousel: jQuery tidak ditemukan.');
        return;
    }
    var $ = jQuery;

    if (typeof $.fn.slick === 'undefined') {
        console.error('MK Flyer Carousel: Slick plugin tidak ter-load.');
        return;
    }

    var $slider = $('.mk-flyer-slider');
    if ($slider.hasClass('slick-initialized')) {
        $slider.slick('unslick');
    }

    // Data semua flyer untuk gallery lightbox, urutannya sama dengan slide
    var flyerItems = [
        { src: 'http://localhost/web-mannakampus/assets/uploads/promo-1.jpg' },
        { src: 'http://localhost/web-mannakampus/assets/uploads/promo-2.jpg' },
        { src: 'http://localhost/web-mannakampus/assets/uploads/promo-3.jpg' },
        { src: 'http://localhost/web-mannakampus/assets/uploads/promo-1.jpg' }
    ];

    $slider.slick({
        centerMode: true,
        centerPadding: '140px',
        slidesToShow: 1,
        arrows: false,
        dots: false,
        infinite: true,
        speed: 400,
        autoplay: true,
        autoplaySpeed: 4000,
        responsive: [
            { breakpoint: 992, settings: { centerPadding: '80px' } },
            { breakpoint: 576, settings: { centerPadding: '30px' } }
        ]
    });

    $('#mk-flyer-prev').on('click', function () { $slider.slick('slickPrev'); });
    $('#mk-flyer-next').on('click', function () { $slider.slick('slickNext'); });

    // Klik gambar: kalau bukan slide tengah -> geser ke situ. Kalau slide tengah -> buka lightbox.
    $slider.on('click', '.mk-flyer-slide-inner', function () {
        var $slide = $(this).closest('.slick-slide');

        if ($slide.hasClass('slick-current')) {
            var clickedSrc = $(this).find('img').attr('src');
            openImageModal(clickedSrc);
        } else {
            $slider.slick('slickGoTo', $slide.data('slick-index'));
        }
    });

    function updateFlyerActions() {
        var $activeImg = $slider.find('.slick-current img');
        if (!$activeImg.length) return;
        var url = $activeImg.attr('src');
        var filename = $activeImg.data('photo');
        $('#mk-flyer-download').attr('href', url).attr('download', filename);
        $('#mk-flyer-print').attr('href', url);
    }
    updateFlyerActions();
    $slider.on('afterChange', updateFlyerActions);

    $('#mk-flyer-print').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var printWindow = window.open('', '_blank');
        printWindow.document.write(
            '<html><head><title>Print Flyer</title></head><body style="margin:0;text-align:center;">' +
            '<img src="' + url + '" style="width:100%;max-width:800px;">' +
            '</body></html>'
        );
        printWindow.document.close();
        printWindow.onload = function () {
            printWindow.focus();
            printWindow.print();
        };
    });
});
</script>

<?php endif; ?>
<div id="imageModal" style="display:none; position:fixed; z-index:9999999; left:0; top:0; width:100vw; height:100vh; background-color:rgba(0,0,0,0.88); justify-content:center; align-items:center;" onclick="closeImageModal(event)">
    <span style="position:absolute; top:25px; right:30px; background-color:#E8792E; color:#fff; width:45px; height:45px; border-radius:50%; font-size:24px; font-weight:bold; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(0,0,0,0.3); z-index:10000001;" onclick="closeImageModal(event)">&times;</span>
    <img id="imageModalImg" style="max-width:95vw; max-height:75vh; width:auto; height:75vh; margin:auto; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.5); object-fit:contain;" onclick="event.stopPropagation()">
</div>

<script>
function openImageModal(src) {
    document.getElementById('imageModalImg').src = src;
    document.getElementById('imageModal').style.display = 'flex';
}
function closeImageModal() {
    document.getElementById('imageModal').style.display = 'none';
}
</script>
<?php require_once('footer.php'); ?>