<?php 
require_once('header.php');

// Query mengambil data dari tabel tbl_cabang
$statement = $pdo->prepare("SELECT * FROM tbl_cabang ORDER BY id ASC");
$statement->execute();
$result_cabang = $statement->fetchAll(PDO::FETCH_ASSOC);

// Ambil lokasi map untuk cabang pertama sebagai lokasi awal map
$first_map_location = !empty($result_cabang[0]['alamat']) ? $result_cabang[0]['alamat'] : 'Manna Kampus Yogyakarta';
?>

<style>
.mk-blog-list{ --mk-orange:#E8792E; --mk-orange-dark:#C9611F; --mk-text:#2E2620; --mk-muted:#8A7F73; --mk-border:#EDE4D8; }
.mk-blog-list a{ text-decoration:none; }

/* ---------------- Hero Section ---------------- */
.mk-blog-hero{ position:relative; background-size:cover; background-position:center; background-repeat:no-repeat; padding:140px 24px 120px; text-align:left; min-height:360px; display:flex; align-items:center; }
.mk-blog-hero::before{ content:""; position:absolute; inset:0; background:rgba(20,20,20,0.45); }
.mk-blog-hero .container{ position:relative; z-index:2; max-width:1240px; margin:0 auto; padding:0 32px; width:100%; }
.mk-blog-hero-title{ font-size:3.25rem; font-weight:800; color:#FFFFFF; margin:0 0 14px; text-shadow:0 2px 8px rgba(0,0,0,0.25); }
.mk-blog-hero-title span{ color:#E8792E; }
.mk-blog-hero-sub{ font-size:1.25rem; color:#F1EEEA; max-width:650px; margin:0 0 32px; line-height:1.6; }

/* ---------------- Search Bar Box ---------------- */
.mk-search-box{ background:#ffffff; border-radius:12px; padding:8px 10px 8px 20px; display:flex; align-items:center; max-width:680px; box-shadow:0 8px 24px rgba(0,0,0,0.2); }
.mk-search-input-wrapper{ display:flex; align-items:center; flex:1; gap:12px; padding-right:12px; }
.mk-search-input-wrapper i{ color:#E8792E; font-size:1.1rem; }
.mk-search-input{ border:none; outline:none; width:100%; font-size:1.05rem; color:#2E2620; background:transparent; }
.mk-search-input::placeholder{ color:#8A7F73; }
.mk-search-btn{ background:#E8792E !important; color:#FFFFFF !important; border:none; border-radius:8px; padding:14px 28px; font-size:1rem; font-weight:700; cursor:pointer; white-space:nowrap; transition:background .2s ease; }
.mk-search-btn:hover{ background:#C9611F !important; }

/* responsive hero & search */
@media (max-width:768px){ .mk-search-box{ flex-direction:column; gap:12px; padding:12px; } .mk-search-input-wrapper{ width:100%; padding-right:0; } .mk-search-btn{ width:100%; } }
@media (max-width:576px){ .mk-blog-hero{ padding:90px 20px 80px; text-align:left; min-height:320px; } .mk-blog-hero .container{ padding:0 12px; } .mk-blog-hero-title{ font-size:2rem; } .mk-blog-hero-sub{ font-size:1rem; margin:0 0 24px; } }

/* ---------------- Member Loyalty Section ---------------- */
.mk-member-section{ background:#FDF6EF; padding:60px 24px; }
.mk-member-wrap{ max-width:1100px; margin:0 auto; }
.mk-member-card{ background:#E8792E; border-radius:20px; padding:60px 50px; display:flex; align-items:center; justify-content:space-between; gap:40px; position:relative; overflow:hidden; box-shadow:0 10px 25px rgba(232,121,46,0.25); }
.mk-member-content{ flex:1; max-width:520px; color:#FFFFFF; }
.mk-member-title{ font-size:2.5rem; font-weight:800; line-height:1.25; margin:0 0 16px; color:#FFFFFF; }
.mk-member-desc{ font-size:1.5rem; line-height:1.6; margin:0 0 32px; color:rgba(255,255,255,0.9); }
.mk-member-actions{ display:flex; gap:16px; flex-wrap:wrap; }
.mk-member-btn-primary{ background:#FFFFFF; color:#2E2620 !important; font-weight:700; font-size:1.25rem; padding:14px 28px; border-radius:8px; text-decoration:none; transition:all 0.2s ease; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
.mk-member-btn-primary:hover{ background:#F5F5F5; transform:translateY(-2px); }
.mk-member-btn-outline{ background:transparent; color:#FFFFFF !important; font-weight:700; font-size:1.25rem; padding:14px 28px; border-radius:8px; border:1.5px solid rgba(255,255,255,0.8); text-decoration:none; transition:all 0.2s ease; }
.mk-member-btn-outline:hover{ background:rgba(255,255,255,0.1); border-color:#FFFFFF; }
.mk-member-card-graphic{ position:relative; flex-shrink:0; }
.mk-loyalty-card{ width:320px; height:190px; background:linear-gradient(135deg, #7A3B0D 0%, #3D1C04 100%); border-radius:16px; padding:20px 24px; box-sizing:border-box; display:flex; flex-direction:column; justify-content:space-between; box-shadow:0 12px 28px rgba(0,0,0,0.35); border:1px solid rgba(255,255,255,0.15); color:#FFFFFF; position:relative; }
.mk-loyalty-header{ display:flex; justify-content:space-between; align-items:center; }
.mk-loyalty-title{ font-size:1.15rem; font-weight:800; letter-spacing:1.5px; text-transform:uppercase; }
.mk-loyalty-contactless{ font-size:1.25rem; opacity:0.9; }
.mk-loyalty-body{ margin-top:10px; }
.mk-loyalty-label{ font-size:1.0rem; text-transform:uppercase; letter-spacing:1px; opacity:0.7; margin-bottom:2px; }
.mk-loyalty-name{ font-size:1.05rem; font-weight:800; letter-spacing:1px; }
.mk-loyalty-footer{ display:flex; justify-content:space-between; align-items:flex-end; }
.mk-loyalty-valid{ font-size:1.0rem; font-weight:600; opacity:0.85; }
.mk-loyalty-circles{ display:flex; }
.mk-loyalty-circle{ width:24px; height:24px; border-radius:50%; background:rgba(255,255,255,0.25); }
.mk-loyalty-circle:last-child{ margin-left:-10px; background:rgba(255,255,255,0.15); }
@media (max-width: 868px){ .mk-member-card{ flex-direction:column; padding:40px 24px; text-align:center; } .mk-member-actions{ justify-content:center; } .mk-member-btn-primary, .mk-member-btn-outline{ width:100%; text-align:center; } .mk-loyalty-card{ width:280px; height:165px; margin:0 auto; } }

/* ---------------- Section: Cari Gerai Kami ---------------- */
.mk-store-section{ padding:70px 24px; text-align:center; background:#F7F5F1; }
.mk-store-section .container{ max-width:1180px; margin:0 auto; }
.mk-store-box{ display:grid; grid-template-columns:380px 1fr; background:#FFFFFF; border:1px solid var(--mk-border,#EDE4D8); border-radius:16px; overflow:hidden; box-shadow:0 4px 16px rgba(0,0,0,0.05); text-align:left; }

/* Kolom Kiri: Daftar Cabang Gambar/Card Style */
.mk-store-list{ border-right:1px solid var(--mk-border,#EDE4D8); max-height:580px; overflow-y:auto; background-color:#FAFAFA; padding:16px; box-sizing:border-box; }
.mk-store-list-header{ margin-bottom:16px; }
.mk-store-list-title{ font-size:2rem; font-weight:800; color:#7A3B0D; margin:0 0 4px; display:flex; align-items:center; gap:8px; }
.mk-store-list-sub{ font-size:1.25rem; color:var(--mk-muted,#8A7F73); margin:0; }

/* Card Item Cabang */
.mk-store-card{ background:#FFFFFF; border:1px solid #EAEAEA; border-radius:12px; padding:12px; margin-bottom:16px; box-shadow:0 2px 6px rgba(0,0,0,0.04); transition:transform 0.2s, box-shadow 0.2s; cursor:pointer; }
.mk-store-card:hover, .mk-store-card.active{ transform:translateY(-2px); box-shadow:0 6px 16px rgba(0,0,0,0.08); border-color:#E8792E; }

/* Gambar & Badge */
.mk-store-card-image{ position:relative; width:100%; height:140px; border-radius:8px; overflow:hidden; margin-bottom:12px; }
.mk-store-card-image img{ width:100%; height:100%; object-fit:cover; }

/* Badge Dinamis: SUPERMARKET (Oren) vs MINIMARKET (Biru) */
.mk-store-badge{ position:absolute; top:8px; right:8px; color:#FFFFFF; font-size:1rem; font-weight:800; letter-spacing:0.5px; padding:4px 8px; border-radius:4px; text-transform:uppercase; }
.mk-store-badge.supermarket{ background:#E8792E; }
.mk-store-badge.minimarket{ background:#1E88E5; }

/* Informasi Detail */
.mk-store-card-name{ font-size:1.5rem; font-weight:800; color:#1A1A1A; margin:0 0 8px; }
/* Style Link Judul Cabang */
.mk-store-title-link{ color:#1A1A1A; text-decoration:none; transition:color 0.2s ease; display:inline-flex; align-items:center; gap:6px; }
.mk-store-title-link:hover{ color:#E8792E; text-decoration:underline; }

.mk-store-card-address{ font-size:1.25rem; color:#666666; margin:0 0 12px; line-height:1.4; display:flex; align-items:flex-start; gap:6px; }
.mk-store-card-address i{ color:#C9611F; margin-top:3px; font-size:1.1rem; flex-shrink:0; }

/* Footer Card */
.mk-store-card-footer{ display:flex; justify-content:space-between; align-items:center; padding-top:8px; border-top:1px dashed #EAEAEA; font-size:1.1rem; }
.mk-store-card-hours{ color:#7A3B0D; display:flex; align-items:center; gap:6px; }
.mk-store-card-link{ color:#C9611F; font-weight:700; text-decoration:none; display:flex; align-items:center; gap:4px; }
.mk-store-card-link:hover{ text-decoration:underline; }

/* Kolom Kanan: Map */
.mk-store-map{ min-height:580px; }
.mk-store-map iframe{ width:100%; height:100%; min-height:580px; border:0; display:block; }

@media (max-width:768px){ .mk-store-box{ grid-template-columns:1fr; } .mk-store-list{ border-right:none; border-bottom:1px solid var(--mk-border,#EDE4D8); max-height:450px; } .mk-store-map, .mk-store-map iframe{ min-height:350px; } }
</style>

<!-- Hero Start -->
<section class="mk-blog-hero" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads/mannakampus.png);">
    <div class="container">
        <h1 class="mk-blog-hero-title">Temukan Lokasi Manna Kampus Terdekat</h1>
        <p class="mk-blog-hero-sub">
            Rumah belanja terpercaya yang siap melayani kebutuhan harian Anda dengan layanan ramah dan produk berkualitas.
        </p>
        
        <!-- Search Form Start -->
        <form action="" method="GET" class="mk-search-box">
            <div class="mk-search-input-wrapper">
                <i class="fa fa-search"></i>
                <input type="text" name="q" class="mk-search-input" placeholder="Cari nama outlet atau lokasi..." autocomplete="off">
            </div>
            <button type="submit" class="mk-search-btn">Cari Sekarang</button>
        </form>
        <!-- Search Form End -->
    </div>
</section>
<!-- Hero End -->

<!-- Store Locator Start -->
<section class="mk-store-section">
    <div class="container">
        <div class="mk-store-box">
            <!-- Kolom Kiri: Daftar Cabang Dinamis Dari tbl_cabang -->
            <div class="mk-store-list">
                <div class="mk-store-list-header">
                    <h3 class="mk-store-list-title">
                        <i class="fa fa-store"></i> Daftar Cabang
                    </h3>
                    <p class="mk-store-list-sub">Menampilkan semua lokasi Manna Kampus</p>
                </div>

                <?php 
                $i = 0;
                if(!empty($result_cabang)):
                    foreach($result_cabang as $row): 
                        $i++;
                        $active_class = ($i == 1) ? 'active' : '';
                        
                        // Default Fallback Data
                        $foto_cabang = !empty($row['foto']) ? $row['foto'] : 'default.jpg';
                        $badge_tipe = !empty($row['badge_tipe']) ? strtoupper($row['badge_tipe']) : 'SUPERMARKET';
                        $badge_class = (strtoupper($badge_tipe) == 'MINIMARKET') ? 'minimarket' : 'supermarket';
                        
                        $jam_op = !empty($row['jam_operasional']) ? $row['jam_operasional'] : 'Buka · 08.00 - 21.30';
                        $alamat_cabang = !empty($row['alamat']) ? $row['alamat'] : $row['nama_cabang'];
                        $link_maps = !empty($row['link_maps']) ? $row['link_maps'] : 'https://maps.google.com/?q='.urlencode($row['nama_cabang']);
                        
                        // Link menuju Halaman Explor berdasarkan ID Cabang
                        $link_detail = BASE_URL . 'explor.php?id=' . $row['id'];
                ?>
                    <div class="mk-store-card <?php echo $active_class; ?>" onclick="changeMapLocation('<?php echo addslashes($alamat_cabang); ?>', this)">
                        <div class="mk-store-card-image">
                            <img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $foto_cabang; ?>" alt="<?php echo htmlspecialchars($row['nama_cabang']); ?>">
                            <span class="mk-store-badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($badge_tipe); ?></span>
                        </div>
                        
                        <!-- Judul Cabang Sebagai Link Ke Halaman Explor -->
                        <h4 class="mk-store-card-name">
                            <a href="<?php echo $link_detail; ?>" class="mk-store-title-link" onclick="event.stopPropagation();">
                                <?php echo htmlspecialchars($row['nama_cabang']); ?> 
                                <i class="fa fa-external-link-alt" style="font-size:0.8rem;"></i>
                            </a>
                        </h4>

                        <p class="mk-store-card-address">
                            <i class="fa fa-map-marker-alt"></i>
                            <span><?php echo htmlspecialchars($alamat_cabang); ?></span>
                        </p>
                        <div class="mk-store-card-footer">
                            <span class="mk-store-card-hours"><i class="fa-regular fa-clock"></i> <?php echo htmlspecialchars($jam_op); ?></span>
                            <a href="<?php echo htmlspecialchars($link_maps); ?>" target="_blank" class="mk-store-card-link" onclick="event.stopPropagation();">Lihat Peta &rarr;</a>
                        </div>
                    </div>
                <?php 
                    endforeach; 
                else:
                ?>
                    <p style="text-align:center; color:#8A7F73; padding: 20px 0;">Belum ada data cabang.</p>
                <?php endif; ?>
            </div>

            <!-- Kolom Kanan: Maps -->
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

<!-- Script agar Peta Berubah saat Cabang Diklik -->
<script>
function changeMapLocation(searchQuery, element) {
    // Ubah tampilan card aktif
    const cards = document.querySelectorAll('.mk-store-card');
    cards.forEach(card => card.classList.remove('active'));
    element.classList.add('active');

    // Ubah URL Iframe Google Maps menggunakan Alamat yang Presisi
    const iframe = document.getElementById('storeMapIframe');
    iframe.src = `https://maps.google.com/maps?q=${encodeURIComponent(searchQuery)}&t=&z=16&ie=UTF8&iwloc=&output=embed`;
}
</script>

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

<?php require_once('footer.php'); ?>