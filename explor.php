<?php 
require_once('header.php');

// =========================================================================
// 1. PENGAMBILAN DATA DATABASE 
// =========================================================================

// A. Tangkap ID cabang dari URL (default = 1)
$selected_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// B. Query mengambil detail cabang terpilih dari tbl_cabang
$query_detail = "SELECT * FROM tbl_cabang WHERE id = :id LIMIT 1";
$stmt_detail = $pdo->prepare($query_detail);
$stmt_detail->execute([':id' => $selected_id]);
$current_cabang = $stmt_detail->fetch(PDO::FETCH_ASSOC);

// Fallback jika ID tidak ditemukan/tidak valid
if (!$current_cabang) {
    $stmt_fallback = $pdo->query("SELECT * FROM tbl_cabang ORDER BY id ASC LIMIT 1");
    $current_cabang = $stmt_fallback->fetch(PDO::FETCH_ASSOC);
}

// C. Query daftar seluruh cabang untuk dropdown switcher
$stmt_all = $pdo->query("SELECT id, nama_cabang FROM tbl_cabang ORDER BY id ASC");
$all_cabang = $stmt_all->fetchAll(PDO::FETCH_ASSOC);

// D. Query mengambil semua video milik cabang ini
$stmt_video = $pdo->prepare("SELECT * FROM tbl_cabang_video WHERE id_cabang = ? ORDER BY id ASC");
$stmt_video->execute([$current_cabang['id']]);
$result_videos = $stmt_video->fetchAll(PDO::FETCH_ASSOC);

// Menyiapkan Data Video Master / Default
$video_first   = !empty($result_videos[0]) ? $result_videos[0] : null;
$video_master  = $video_first ? $video_first['link_video'] : '';
$title_master  = $video_first ? $video_first['judul_video'] : 'Tur Cabang';
$desc_master   = ($video_first && !empty($video_first['deskripsi_video'])) 
    ? $video_first['deskripsi_video'] 
    : 'Menjelajahi kenyamanan dan fasilitas berbelanja.';
$foto_cabang   = !empty($current_cabang['foto']) ? $current_cabang['foto'] : 'default.jpg';

// E. Query mengambil semua stand & kios milik cabang ini
$stmt_stand = $pdo->prepare("SELECT * FROM tbl_cabang_stand WHERE id_cabang = ? ORDER BY id ASC");
$stmt_stand->execute([$current_cabang['id']]);
$result_stands = $stmt_stand->fetchAll(PDO::FETCH_ASSOC);

$nama_cabang_pilihan = !empty($current_cabang['nama_cabang']) ? $current_cabang['nama_cabang'] : 'Ini';

// F. Query mengambil daftar produk promo milik cabang yang sedang diakses
$stmt_promo = $pdo->prepare("SELECT * FROM tbl_cabang_promo WHERE id_cabang = ? ORDER BY id DESC LIMIT 8");
$stmt_promo->execute([$current_cabang['id']]);
$result_promos = $stmt_promo->fetchAll(PDO::FETCH_ASSOC);

// G. Query Flyer
$stmt_flyer = $pdo->prepare("SELECT * FROM tbl_flyer WHERE id_cabang = ? ORDER BY id ASC");
$stmt_flyer->execute([$current_cabang['id']]);
$result_flyers = $stmt_flyer->fetchAll(PDO::FETCH_ASSOC);

// H. Query Fasilitas
$stmt_fac = $pdo->prepare("SELECT * FROM tbl_cabang_fasilitas WHERE id_cabang = ? ORDER BY id ASC");
$stmt_fac->execute([$current_cabang['id']]);
$facilities = $stmt_fac->fetchAll(PDO::FETCH_ASSOC);

// I. Query Galeri
$stmt_galeri = $pdo->prepare("SELECT foto FROM tbl_cabang_galeri WHERE id_cabang = ? ORDER BY id ASC LIMIT 5");
$stmt_galeri->execute([$current_cabang['id']]);
$result_galeri = $stmt_galeri->fetchAll(PDO::FETCH_COLUMN);
?>

<style>
/* ---------------- Styling Utama ---------------- */
.mk-explor-page { font-family: inherit; }
.mk-container { max-width: 1240px; margin: 0 auto; padding: 0 20px; }

/* Hero Banner */
.mk-blog-hero { position:relative; background-size:cover; background-position:center; padding:100px 24px 90px; text-align:left; min-height:340px; display:flex; align-items:center; }
.mk-blog-hero::before { content:""; position:absolute; inset:0; background:rgba(20,20,20,0.5); }
.mk-blog-hero .container { position:relative; z-index:2; max-width:1240px; margin:0 auto; padding:0 20px; width:100%; }
.mk-blog-hero-title { font-size:3.25rem; font-weight:800; color:#FFFFFF; margin:0 0 14px; text-shadow:0 2px 8px rgba(0,0,0,0.3); line-height:1.1; }
.mk-blog-hero-title span { color:#E8792E; display:block; }
.mk-blog-hero-sub { font-size:1.5rem; color:#F1EEEA; max-width:620px; margin:0 0 20px; line-height:1.6; }

/* ---------------- SECTION 1: MAPS & INFO CABANG (Background Putih) ---------------- */
.mk-sec-info { background-color: #ffffff; padding: 50px 0; border-bottom: 1px solid #EAEAEA; }
.mk-detail-grid { display: grid; grid-template-columns: 1.35fr 1fr; gap: 28px; align-items: stretch; }

/* Card Map (Kiri) */
.mk-maps-card { position: relative; border-radius: 16px; overflow: hidden; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08); background: #e5e3df; min-height: 380px; display: flex; flex-direction: column; justify-content: space-between; }
.mk-maps-card iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; z-index: 1; }
.mk-badge-location { position: absolute; top: 18px; left: 18px; background: #ffffff; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; color: #2E2620; box-shadow: 0 2px 10px rgba(0,0,0,0.15); z-index: 2; display: flex; align-items: center; gap: 8px; }
.mk-badge-location i { color: #E8792E; }

/* ---------------- CARD DETAIL CABANG (SEJAJAR & RAPI) ---------------- */
.mk-info-card { background: #FAFAFA; border: 1px solid #EAEAEA; border-radius: 16px; padding: 28px 24px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.03); display: flex; flex-direction: column; }
.mk-info-card h3 { font-size: 1.75rem; font-weight: 800; color: #2E2620; margin: 0 0 24px 0; border-bottom: 1px solid #f0f0f0; padding-bottom: 12px; }
.mk-info-item { display: flex !important; align-items: flex-start !important; gap: 14px !important; margin-bottom: 20px !important; }
.mk-info-icon { font-size: 1.45rem !important; color: #E8792E !important; width: 24px !important; text-align: center !important; flex-shrink: 0 !important; margin-top: 2px !important; }
.mk-info-content { display: flex !important; flex-direction: column !important; text-align: left !important; }
.mk-info-content label { font-size: 1.45rem !important; font-weight: 800 !important; color: #2E2620 !important; display: block !important; margin: 0 0 4px 0 !important; }
.mk-info-content p { font-size: 1.25rem !important; color: #666666 !important; margin: 0 !important; line-height: 1.5 !important; }
.mk-btn-direction { margin-top: auto; display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; background: #A04000; color: #ffffff !important; text-align: center; padding: 14px; border-radius: 8px; font-weight: 700; font-size: 1.25rem; text-decoration: none; transition: background 0.2s ease; box-shadow: 0 4px 12px rgba(160, 64, 0, 0.25); }
.mk-btn-direction:hover { background: #803300; }

/* ---------------- SECTION 2: VIDEO TUR (Background Abu-Abu Terang) ---------------- */
.mk-video-section-wrapper { max-width: 1240px !important; margin: 80px auto !important; padding: 0 20px !important; box-sizing: border-box; }
.mk-video-main-container { display: grid !important; grid-template-columns: 350px 1fr !important; gap: 20px !important; align-items: stretch !important; width: 100% !important; margin-top: 0 !important; margin-bottom: 0 !important; }

/* Kotak Sisi Kiri (Koleksi Video) Menyesuaikan Tinggi Kanan Secara Penuh */
.mk-video-sidebar { background: #FFFFFF; border: 1px solid #EAEAEA; border-radius: 14px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex !important; flex-direction: column !important; height: 100% !important; box-sizing: border-box !important; }
.mk-video-sidebar-title { font-size: 1.75rem; font-weight: 700; color: #2E2620; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #F0E6DA; padding-bottom: 10px; flex-shrink: 0; }
.mk-video-item-list { display: flex; flex-direction: column; gap: 10px; overflow-y: auto; flex-grow: 1; }
.mk-video-list-card { background: #FAFAFA; border: 1px solid #EFEFEF; border-radius: 10px; padding: 12px 14px; cursor: pointer; transition: all 0.25s ease; text-align: left; }
.mk-video-list-card:hover { background: #FFF4ED; border-color: #E8792E; transform: translateX(4px); }
.mk-video-list-card.active { background: #FFF1E6; border-color: #E8792E; box-shadow: 0 4px 10px rgba(232,121,46,0.1); }
.mk-video-card-heading { font-size: 1.25rem; font-weight: 700; color: #2E2620; margin: 0 0 4px 0; display: flex; align-items: center; gap: 8px; }
.mk-video-card-heading i { color: #E8792E; font-size: 0.85rem; }
.mk-video-card-desc { font-size: 1.05rem; color: #8A7F73; margin: 0; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }

/* Kotak Pemutar Video Utama di Kanan */
.mk-video-player-box { background: #FFFFFF; border: 1px solid #EAEAEA; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.03); width: 100%; height: 100% !important; min-height: 100% !important; display: flex; align-items: center; justify-content: center; background-color: #000; box-sizing: border-box !important; }
.mk-video-player-box iframe, .mk-video-player-box video { width: 100% !important; height: 100% !important; min-height: 340px !important; object-fit: cover; border: none; }

@media (max-width: 992px) { .mk-video-main-container { grid-template-columns: 1fr !important; } .mk-video-sidebar { height: auto !important; } }

/* ---------------- SECTION 3: STAND & KIOS (Background Krem Hangat) ---------------- */
.mk-sec-stand { background-color: #FDFBF8; padding: 60px 0; }
.mk-stand-header { margin-bottom: 36px; text-align: center; }
.mk-stand-title { font-size: 1.75rem; font-weight: 800; color: #2E2620; margin: 0 0 12px; }
.mk-stand-divider { width: 70px; height: 4px; background: #E8792E; margin: 0 auto; border-radius: 2px; }
.mk-stand-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
.mk-stand-card { background: #FFFFFF; border: 1px solid #EAEAEA; border-radius: 16px; padding: 30px 16px; text-align: center; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03); transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease; display: flex; flex-direction: column; align-items: center; }
.mk-stand-card:hover { transform: translateY(-6px); box-shadow: 0 10px 24px rgba(232, 121, 46, 0.15); border-color: #E8792E; }
.mk-stand-icon { width: 65px; height: 65px; margin-bottom: 20px; background: #FDF6EF; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #E8792E; font-size: 2rem; transition: background 0.25s, color 0.25s; }
.mk-stand-card:hover .mk-stand-icon { background: #E8792E; color: #FFFFFF; }
.mk-stand-card-title { font-size: 1.25rem; font-weight: 800; color: #C9611F; margin: 0 0 10px; line-height: 1.35; text-transform: uppercase; letter-spacing: 0.5px; }
.mk-stand-card-desc { font-size: 1.05rem; color: #8A7F73; margin: 0; line-height: 1.4; }

/* Responsive Adjustments */
@media (max-width: 992px) {
    .mk-detail-grid { grid-template-columns: 1fr; }
    .mk-video-section { flex-direction: column; }
    .mk-video-wrapper { order: -1; min-height: 380px; width: 100%; } 
    .mk-video-collection-box { width: 100%; }
    .mk-maps-card { min-height: 320px; }
    .mk-blog-hero-title { font-size: 2.25rem; }
    .mk-video-grid { grid-template-columns: repeat(2, 1fr); max-height: none; } 
}
@media (max-width: 576px) {
    .mk-video-grid { grid-template-columns: 1fr; }
    .mk-video-wrapper { min-height: 250px; }
    .mk-stand-grid { grid-template-columns: 1fr; }
}

/* ---------------- SECTION 4: PROMO EKSKLUSIF (Single-Line) ---------------- */
.mk-sec-promo { background-color: #FFFFFF; padding: 60px 0; }
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

/* ---------------- SECTION 5 : FLYER CAROUSEL ---------------- */
.mk-flyer-section { padding: 50px 24px; background: #FDFBF8; text-align: left !important; border-top: none !important; }
.mk-flyer-wrap { max-width: 1240px !important; margin: 0 auto !important; padding: 0 20px !important; box-sizing: border-box; text-align: left !important; }

/* Judul dan Subjudul diubah menjadi Rata Kiri */
.mk-flyer-header { text-align: left !important; margin-bottom: 30px !important; width: 100%; }
.mk-flyer-header h2 { margin: 0 0 6px 0 !important; font-size: 1.75rem; font-weight: 700; color: #2E2620; text-align: center; !important; }
.mk-flyer-header p { color: #8A7F73 !important; margin: 0 !important; font-size: 1.25rem; text-align: center; !important; }
.mk-flyer-underline { width: 60px; height: 3px; background-color: #E8792E; margin: 20px auto; border-radius: 2px; }
/* Memperbesar Lebar Kontainer Karusel Supaya Gambar Terlihat Lebih Besar */
.mk-flyer-carousel-container { position: relative; max-width: 1100px !important; margin: 0 auto 20px !important; padding: 0 60px !important; box-sizing: border-box; overflow: hidden !important; }
.mk-flyer-slick-slider { display: block; width: 100%; }
.mk-flyer-slick-slider .slick-list { overflow: visible !important; padding: 30px 0 !important; }

/* Memperbesar Maksimal Tinggi Gambar Flyer */
.mk-flyer-slick-slider .slick-slide { padding: 0 15px !important; outline: none; transition: all 0.4s ease; transform: scale(0.85); opacity: 0.4; filter: blur(3px); }
.mk-flyer-slick-slider .slick-slide img { width: 100%; height: auto; max-height: 560px !important; object-fit: contain; border-radius: 14px; box-shadow: 0 6px 20px rgba(0,0,0,0.1); display: block; margin: 0 auto; cursor: pointer; }

/* Ukuran Gambar Utama di Tengah yang Lebih Besar & Jelas */
.mk-flyer-slick-slider .slick-center { transform: scale(1.05) !important; opacity: 1 !important; filter: blur(0px) !important; z-index: 10; }
.mk-flyer-slick-slider .slick-center img { box-shadow: 0 15px 40px rgba(0,0,0,0.25); }

/* Posisi Tombol Panah Navigasi */
.mk-arrow-btn { position: absolute !important; top: 50% !important; transform: translateY(-50%) !important; z-index: 99 !important; width: 50px !important; height: 50px !important; background-color: #E8792E !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; border: none !important; cursor: pointer !important; transition: all 0.25s ease !important; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
.mk-arrow-btn i { color: #FFFFFF !important; font-size: 1.3rem !important; }
.mk-arrow-btn:hover { background-color: #C9611F !important; transform: translateY(-50%) scale(1.1) !important; }
.mk-arrow-left { left: 0px !important; }
.mk-arrow-right { right: 0px !important; }

.mk-flyer-actions { display: flex; justify-content: center; gap: 16px; margin-top: 25px; }
.mk-flyer-btn { display: inline-flex; align-items: center; gap: 8px; background: #E8792E; color: #FFFFFF !important; font-weight: 700; font-size: 1rem; padding: 10px 24px; border-radius: 6px; border: none; cursor: pointer; text-transform: uppercase; text-decoration: none; transition: background .2s ease; }
.mk-flyer-btn:hover { background: #C9611F; }

/* Animasi halus saat modal muncul */
#imageModal { animation: fadeIn 0.25s ease-in-out; }
#imageModalImg { animation: zoomIn 0.25s ease-in-out; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes zoomIn { from { transform: scale(0.8); } to { transform: scale(1); } }
@media (max-width: 768px) { .mk-flyer-carousel-container { padding: 0 10px; max-width: 100%; } .mk-flyer-slick-slider .slick-slide { transform: scale(0.95); opacity: 0.3; filter: none; } .mk-arrow-btn { width: 38px !important; height: 38px !important; } .mk-arrow-left { left: 5px !important; } .mk-arrow-right { right: 5px !important; } }

/* ---------------- SECTION 6 FASILITAS & KENYAMANAN ---------------- */
.mk-facility-section { padding: 60px 24px; background: #ffffff; text-align: center; width: 100%; box-sizing: border-box; }
.mk-facility-wrap { max-width: 1240px !important; margin: 0 auto !important; padding: 0 20px !important; box-sizing: border-box; }
.mk-facility-header { text-align: center !important; margin-bottom: 35px !important; width: 100%; }
.mk-facility-header h2 { margin: 0 0 10px 0 !important; font-size: 1.75rem; font-weight: 700; color: #2E2620; }
.mk-facility-underline { width: 60px; height: 3px; background-color: #E8792E; margin: 0 auto; border-radius: 2px; }
.mk-facility-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; width: 100%; }
.mk-facility-card { background: #FFFFFF; border: 1px solid #EAEAEA; border-radius: 12px; padding: 30px 20px; text-align: center; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
.mk-facility-card:hover { transform: translateY(-50px); box-shadow: 0 8px 25px rgba(232,121,46,0.12); border-color: #F0E6DA; }
.mk-facility-icon { font-size: 2rem; color: #E8792E; margin-bottom: 15px; display: flex; align-items: center; justify-content: center; height: 50px; }
.mk-facility-name { font-size: 1.25rem; font-weight: 700; color: #2E2620; margin: 0 0 6px 0; }
.mk-facility-desc { font-size: 1.05rem; color: #8A7F73; margin: 0; }
@media (max-width: 768px) { .mk-facility-grid { grid-template-columns: repeat(2, 1fr); } }

/* ---------------- SECTION 7 GALERI FOTO CABANG ---------------- */
.mk-gallery-section { padding: 80px 0; background: #fff; }
.mk-gallery-section .container { max-width: 1180px; margin: 0 auto; padding: 0 24px; }
.mk-gallery-header-center { text-align: center; margin-bottom: 40px; position: relative; min-height: 50px; }
.mk-gallery-header-center h2 { font-size: 1.75rem; font-weight: 800; color: #2E2620; margin: 0 0 12px; }
.mk-gallery-header-center h2 span { color: #E8792E; }
.mk-gallery-underline { width: 70px; height: 4px; background: #E8792E; margin: 0 auto; border-radius: 2px; }
.mk-gallery-link-all { font-size: 1.05rem; font-weight: 700; color: #E8792E; text-decoration: none; display: flex; align-items: center; gap: 6px; transition: color 0.2s; position: absolute; right: 0; bottom: 0; }
.mk-gallery-link-all:hover { color: #A04000; }
.mk-gallery-grid-clean { display: grid; grid-template-columns: repeat(5, 1fr); gap: 20px; }
.mk-gallery-card { overflow: hidden; border-radius: 12px; position: relative; cursor: zoom-in; background: #f8f9fa; box-shadow: 0 4px 12px rgba(0,0,0,0.06); transition: transform 0.3s ease, box-shadow 0.3s ease; display: block; }
.mk-gallery-card img { width： 100%; height: 200px; display: block; object-fit: cover; transition: transform 0.4s ease; }
.mk-gallery-card:hover { transform: translateY(-8px); box-shadow: 0 16px 30px rgba(0,0,0,0.12); }
.mk-gallery-card:hover img { transform: scale(1.05); }
@media (max-width: 991px) { .mk-gallery-grid-clean { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .mk-gallery-grid-clean { grid-template-columns: 1fr; } }
</style>

<div class="mk-explor-page">

    <!-- Hero Banner Start -->
    <section class="mk-blog-hero" style="background-image:url('<?php echo BASE_URL; ?>assets/uploads/kemitraan.png');">
        <div class="container">
            <h1 class="mk-blog-hero-title">
                Eksplorasi Outlet <br>
                <span>Manna Kampus</span>
            </h1>
            <p class="mk-blog-hero-sub">
                Rasakan pengalaman belanja terpercaya dengan standar pelayanan terbaik di setiap sudut kota. Pilih cabang favorit Anda untuk melihat tur virtual dan penawaran spesial.
            </p>
        </div>
    </section>
    <!-- Hero Banner End -->

    <?php if ($current_cabang): ?>
        
        <!-- SECTION 1: MAPS & DETAIL CABANG -->
        <section class="mk-sec-info">
            <div class="mk-container">
                <div class="mk-detail-grid">
                    
                    <!-- Kiri: Peta & Overlay Nama Cabang -->
                    <div class="mk-maps-card">
                        
                        <?php 
                            $query_pencarian = urlencode(trim($current_cabang['nama_cabang'] . ' ' . $current_cabang['alamat']));
                            $embed_iframe_url = "https://maps.google.com/maps?q={$query_pencarian}&t=&z=16&ie=UTF8&iwloc=&output=embed";
                            $direction_link = !empty($current_cabang['link_maps']) 
                                ? $current_cabang['link_maps'] 
                                : "https://www.google.com/maps/search/?api=1&query={$query_pencarian}";
                        ?>
                        
                        <iframe src="<?php echo htmlspecialchars($embed_iframe_url, ENT_QUOTES, 'UTF-8'); ?>" allowfullscreen="" loading="lazy"></iframe>
                    </div>

                    <!-- Kanan: Detail Informasi Cabang -->
                    <div class="mk-info-card">
                        <h3>Detail Cabang</h3>

                        <!-- Jam Operasional -->
                        <div class="mk-info-item">
                            <div class="mk-info-icon"><i class="fa-regular fa-clock"></i></div>
                            <div class="mk-info-content">
                                <label>Jam Operasional</label>
                                <p>Buka <?php echo htmlspecialchars($current_cabang['jam_operasional'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <span style="color:#888; font-size: 1.15rem;">(Buka Setiap Hari)</span>
                            </div>
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="mk-info-item">
                            <div class="mk-info-icon"><i class="fa-solid fa-location-dot"></i></div>
                            <div class="mk-info-content">
                                <label>Alamat Lengkap</label>
                                <p><?php echo htmlspecialchars($current_cabang['alamat'], ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                        </div>

                        <!-- Kontak -->
                        <?php if (!empty($current_cabang['kontak'])): ?>
                            <?php 
                                $no_kontak = $current_cabang['kontak'];
                                $telepon_clean = preg_replace('/[^0-9+]/', '', $no_kontak);
                            ?>
                            <div class="mk-info-item">
                                <div class="mk-info-icon"><i class="fa-solid fa-phone"></i></div>
                                <div class="mk-info-content">
                                    <label>Kontak</label>
                                    <p>
                                        <?php if (!empty($telepon_clean)): ?>
                                            <a href="tel:<?php echo $telepon_clean; ?>" style="color:#2E2620; text-decoration:none;">
                                                <?php echo htmlspecialchars($no_kontak, ENT_QUOTES, 'UTF-8'); ?>
                                            </a>
                                        <?php else: ?>
                                            <?php echo htmlspecialchars($no_kontak, ENT_QUOTES, 'UTF-8'); ?>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Tombol Petunjuk Arah -->
                        <a href="<?php echo htmlspecialchars($direction_link, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" class="mk-btn-direction">
                            <i class="fa-solid fa-map-location-dot"></i> Dapatkan Petunjuk Arah
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <!-- SECTION 2: KOLEKSI VIDEO TUR -->
                <section class="mk-video-section-wrapper">
            <div class="mk-video-main-container">
                
                <!-- Sisi Kiri: Daftar Judul Video -->
                <div class="mk-video-sidebar">
                    <div class="mk-video-sidebar-title">
                        <i class="fa fa-video-camera"></i> Koleksi Video Tur
                    </div>
                    
                    <div class="mk-video-item-list">
                        <?php
                            $stmt_vid = $pdo->prepare("SELECT * FROM tbl_cabang_video WHERE id_cabang = ? ORDER BY id ASC");
                            $stmt_vid->execute([$current_cabang['id']]);
                            $videos = $stmt_vid->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <?php if (!empty($videos)): ?>
                            <?php foreach ($videos as $index => $vid): 
                                $active_class = ($index === 0) ? 'active' : '';
                                $video_source = isset($vid['link_video']) ? $vid['link_video'] : (isset($vid['url']) ? $vid['url'] : '');
                            ?>
                                <div class="mk-video-list-card <?php echo $active_class; ?>" onclick="changeActiveVideo('<?php echo $video_source; ?>', this)">
                                    <h4 class="mk-video-card-heading">
                                        <i class="fa fa-play-circle"></i> <?php echo htmlspecialchars($vid['judul_video'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                    </h4>
                                    <p class="mk-video-card-desc"><?php echo htmlspecialchars($vid['deskripsi'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="text-align: center; color: #8A7F73; font-size: 0.9rem; padding: 20px 0;">Belum ada video untuk cabang ini.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Sisi Kanan: Pemutar Video Utama -->
                <div class="mk-video-player-box">
                    <?php 
                        // Ambil video pertama sebagai default player
                        $default_video = !empty($videos[0]['link_video']) ? $videos[0]['link_video'] : (!empty($videos[0]['url']) ? $videos[0]['url'] : '');
                    ?>
                    <iframe id="mainVideoPlayer" src="<?php echo $default_video; ?>" allowfullscreen></iframe>
                </div>

            </div>
        </section>

        <!-- SECTION 3: DAFTAR STAND & KIOS -->
        <section class="mk-sec-stand">
            <div class="mk-container">
                <div class="mk-stand-header">
                    <h2 class="mk-stand-title">
                        Tersedia di <?php echo htmlspecialchars($nama_cabang_pilihan, ENT_QUOTES, 'UTF-8'); ?>
                    </h2>
                    <div class="mk-stand-divider"></div>
                </div>

                <div class="mk-stand-grid">
                    <?php if (!empty($result_stands)): ?>
                        <?php foreach ($result_stands as $s): 
                            $icon = !empty($s['icon']) ? $s['icon'] : 'fa-store';
                            $nama = $s['nama_stand'];
                            $desc = !empty($s['deskripsi']) ? $s['deskripsi'] : '-';
                        ?>
                            <!-- Card Item Stand/Kios -->
                            <div class="mk-stand-card">
                                <div class="mk-stand-icon">
                                    <i class="fa-solid <?php echo htmlspecialchars($icon, ENT_QUOTES, 'UTF-8'); ?>"></i>
                                </div>
                                <h4 class="mk-stand-card-title"><?php echo htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'); ?></h4>
                                <p class="mk-stand-card-desc"><?php echo htmlspecialchars($desc, ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="grid-column: 1 / -1; text-align:center; color:#8A7F73; padding: 20px 0;">
                            <p>Belum ada fasilitas stand atau kios khusus yang terdaftar untuk cabang ini.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- SECTION 4: PROMO EKSKLUSIF CABANG -->
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

                                    <button class="mk-btn-cart">
                                        Tambah ke Keranjang
                                    </button>
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

        <!-- SECTION 5 : PROMO FLYER CAROUSEL -->
        <section class="mk-flyer-section">
            <div class="mk-flyer-wrap">
                
                <!-- Bagian Judul Katalog Cabang Dinamis -->
                    <div class="mk-flyer-header">
                        <h2>Katalog Cabang <?php echo htmlspecialchars($current_cabang['nama_cabang'], ENT_QUOTES, 'UTF-8'); ?></h2>
                        <p>Hanya berlaku di <?php echo htmlspecialchars($current_cabang['nama_cabang'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <div class="mk-flyer-underline"></div>
                    </div>

                <!-- Carousel Container -->
                <div class="mk-flyer-carousel-container">
                    <div id="flyerSlidesWrapper" class="mk-flyer-slick-slider">
                        <?php
                            // Ambil data flyer dari database berdasarkan cabang aktif
                            $stmt_flyer = $pdo->prepare("SELECT * FROM tbl_flyer WHERE id_cabang = ? ORDER BY id ASC");
                            $stmt_flyer->execute([$current_cabang['id']]);
                            $result_flyers = $stmt_flyer->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <?php if (!empty($result_flyers)): ?>
                            <?php foreach ($result_flyers as $flyer): 
                                // Deteksi nama kolom gambar secara dinamis
                                $nama_file_foto = '';
                                if (!empty($flyer['foto'])) {
                                    $nama_file_foto = $flyer['foto'];
                                } elseif (!empty($flyer['gambar'])) {
                                    $nama_file_foto = $flyer['gambar'];
                                } elseif (!empty($flyer['file'])) {
                                    $nama_file_foto = $flyer['file'];
                                } else {
                                    $values = array_values($flyer);
                                    $nama_file_foto = isset($values[2]) ? $values[2] : 'default.jpg';
                                }

                                $foto_flyer = BASE_URL . 'assets/uploads/' . $nama_file_foto;
                            ?>
                            <div class="flyer-slide-item">
                            <img src="<?php echo $foto_flyer; ?>" 
                                alt="Promo Flyer Manna Kampus" 
                                onclick="openImageModal(this.src)" 
                                style="cursor: pointer;">
                        </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="flyer-slide-item">
                                <p style="padding: 40px; color:#8A7F73;">Belum ada brosur promo untuk cabang ini.</p>
                            </div>
                        <?php endif; ?>
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
                    <button onclick="window.print()" class="mk-flyer-btn">
                        <i class="fa fa-print"></i> Print
                    </button>
                </div>

            </div>
        </section>


        
        <!-- SECTION 6 : FASILITAS & KENYAMANAN -->
        <section class="mk-facility-section">
            <div class="mk-facility-wrap">
                
                <div class="mk-facility-header">
                    <h2>Fasilitas & Kenyamanan <?php echo htmlspecialchars($current_cabang['nama_cabang'], ENT_QUOTES, 'UTF-8'); ?></h2>
                    <div class="mk-facility-underline"></div>
                </div>

                <div class="mk-facility-grid">
                    <?php
                        // Mengambil data fasilitas berdasarkan cabang yang sedang aktif dari tbl_cabang_fasilitas
                        $stmt_fac = $pdo->prepare("SELECT * FROM tbl_cabang_fasilitas WHERE id_cabang = ? ORDER BY id ASC");
                        $stmt_fac->execute([$current_cabang['id']]);
                        $facilities = $stmt_fac->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <?php if (!empty($facilities)): ?>
                        <?php foreach ($facilities as $fac): ?>
                            <div class="mk-facility-card">
                                <div class="mk-facility-icon">
                                    <i class="fa <?php echo htmlspecialchars($fac['icon'] ?? 'fa-check', ENT_QUOTES, 'UTF-8'); ?>"></i>
                                </div>
                                <h4 class="mk-facility-name"><?php echo htmlspecialchars($fac['nama_fasilitas'], ENT_QUOTES, 'UTF-8'); ?></h4>
                                <p class="mk-facility-desc"><?php echo htmlspecialchars($fac['deskripsi'], ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="grid-column: 1 / -1; text-align: center; color: #8A7F73;">Belum ada informasi fasilitas untuk cabang ini.</p>
                    <?php endif; ?>
                </div>

            </div>
        </section>

        <!-- SECTION 7 : GALERI CLEAN GRID -->
        <section class="mk-gallery-section">
            <div class="container">
                
                <div class="mk-gallery-header-center">
                    <h2>Galeri <?php echo htmlspecialchars($current_cabang['nama_cabang'], ENT_QUOTES, 'UTF-8'); ?></h2>
                    <div class="mk-gallery-underline"></div>
                    <a href="gallery-all.php?id=<?php echo $current_cabang['id']; ?>" class="mk-gallery-link-all">
                        Lihat Semua <i class="fa fa-angle-right"></i>
                    </a>
                </div>
                
                <?php if (!empty($result_galeri)): ?>
                    <div class="mk-gallery-grid-clean">
                        <?php foreach ($result_galeri as $foto): 
                            $foto_url = BASE_URL . 'assets/uploads/' . htmlspecialchars($foto, ENT_QUOTES, 'UTF-8');
                        ?>
                            <div class="mk-gallery-card" onclick="openImageModal('<?php echo $foto_url; ?>')">
                                <img src="<?php echo $foto_url; ?>" alt="Galeri Manna Kampus">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="text-align: center; color: #8A7F73; padding: 30px;">Belum ada dokumentasi galeri untuk cabang ini.</p>
                <?php endif; ?>
            </div>
        </section>

    <?php else: ?>
        <section class="mk-sec-info">
            <div class="mk-container">
                <p style="text-align:center; color:#888; padding: 40px 0;">Cabang yang dipilih tidak ditemukan. Silakan pilih cabang lain.</p>
            </div>
        </section>
    <?php endif; ?>

<!-- ========================================== -->
<!-- 1. HTML MODAL POP-UP (Perbesar & Silang Oranye) -->
<!-- ========================================== -->
<div id="imageModal" style="display:none; position:fixed; z-index:9999999; left:0; top:0; width:100vw; height:100vh; background-color:rgba(0,0,0,0.88); justify-content:center; align-items:center;" onclick="closeImageModal(event)">
    
    <span style="position:absolute; top:25px; right:30px; background-color:#D65A18; color:#fff; width:45px; height:45px; border-radius:50%; font-size:24px; font-weight:bold; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(0,0,0,0.3); z-index:10000001;" onclick="closeImageModal(event)">&times;</span>
    
    <img id="imageModalImg" style="max-width:95vw; max-height:95vh; width:auto; height:75vh; margin:auto; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.5); object-fit:contain;" onclick="event.stopPropagation()">
</div>

<!-- ========================================== -->
<!-- 2. SCRIPT JAVASCRIPT LENGKAP               -->
<!-- ========================================== -->
<script>
// Fungsi untuk Membuka & Menutup Modal Perbesar Gambar
function openImageModal(src) {
    document.getElementById('imageModalImg').src = src;
    document.getElementById('imageModal').style.display = 'flex';
}

function closeImageModal() {
    document.getElementById('imageModal').style.display = 'none';
}

// Update link download sesuai flyer yang sedang aktif di tengah carousel
function updateDownloadLink() {
    var $centerSlide = $('.mk-flyer-slick-slider .slick-center img');
    var $downloadBtn = $('#downloadFlyerBtn');

    if ($centerSlide.length > 0 && $downloadBtn.length > 0) {
        var imgSrc = $centerSlide.attr('src');
        $downloadBtn.attr('href', imgSrc);

        // Ambil nama file asli dari URL untuk nama file download
        var fileName = imgSrc.substring(imgSrc.lastIndexOf('/') + 1);
        $downloadBtn.attr('download', fileName);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const videoPreview = document.getElementById('videoPreview');
    const videoTitle = document.getElementById('videoTitle');
    const videoDesc = document.getElementById('videoDesc');
    const playBtn = document.getElementById('playBtn');
    const iframeContainer = document.getElementById('iframeContainer');
    const gridCards = document.querySelectorAll('.mk-grid-card');

    let activeVideoUrl = "<?php echo $video_master; ?>";

    // Play Video Utama
    if (playBtn) {
        playBtn.addEventListener('click', function() {
            if(activeVideoUrl) {
                iframeContainer.innerHTML = `<iframe src="${activeVideoUrl}?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
                iframeContainer.style.display = 'block';
                playBtn.style.display = 'none';
            }
        });
    }
});

// Change Active Video
function changeActiveVideo(videoUrl, element) {
    $('.mk-video-list-card').removeClass('active');
    $(element).addClass('active');

    var $player = $('#mainVideoPlayer');
    if($player.length > 0) {
        $player.attr('src', videoUrl);
    }
}
</script>

<script type="text/javascript">
(function($) {
    $(window).on('load', function() {
        var $slider = $('#flyerSlidesWrapper');
        
        if ($slider.length > 0) {
            if ($slider.hasClass('slick-initialized')) {
                $slider.slick('unslick');
            }

            $slider.slick({
                centerMode: true,
                centerPadding: '0px',
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
                speed: 400,
                arrows: true,
                prevArrow: $('#flyerPrevBtn'),
                nextArrow: $('#flyerNextBtn'),
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            centerPadding: '0px',
                            centerMode: true
                        }
                    }
                ]
            });

            // Set link download awal setelah slider siap
            setTimeout(updateDownloadLink, 100);

            // Update link download tiap kali slide berubah (klik panah/geser)
            $slider.on('afterChange', function(event, slick, currentSlide) {
                updateDownloadLink();
            });
        }
    });

    // Switcher Cabang
    $(document).on('change', '#branchFlyerSelect', function() {
        var selectedId = $(this).val();
        window.location.href = "?id=" + selectedId;
    });
})(jQuery);
</script>

<?php require_once('footer.php'); ?>