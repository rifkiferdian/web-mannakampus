<?php 
require_once('header.php');

// Query mengambil data dari tabel tbl_cabang
$statement = $pdo->prepare("SELECT * FROM tbl_cabang ORDER BY id ASC");
$statement->execute();
$result_cabang = $statement->fetchAll(PDO::FETCH_ASSOC);

// Ambil lokasi map untuk cabang pertama sebagai lokasi awal map
$first_map_location = !empty($result_cabang[0]['alamat']) ? $result_cabang[0]['alamat'] : 'Manna Kampus Yogyakarta';

// Pisahkan supermarket dan minimarket
$supermarkets = [];
$minimarkets = [];
foreach ($result_cabang as $row) {
    $badge_tipe = !empty($row['badge_tipe']) ? strtoupper(trim($row['badge_tipe'])) : 'SUPERMARKET';
    if ($badge_tipe === 'MINIMARKET') {
        $minimarkets[] = $row;
    } else {
        $supermarkets[] = $row;
    }
}
?>

<style>
/* ---------------- Hero Section ---------------- */
.mk-blog-hero{ position:relative; background-size:cover; background-position:center; background-repeat:no-repeat; padding:140px 24px 120px; text-align:left; min-height:360px; display:flex; align-items:center; }
.mk-blog-hero::before{ content:""; position:absolute; inset:0; background:rgba(20,20,20,0.45); }
.mk-blog-hero .container{ position:relative; z-index:2; max-width:1240px; margin:0 auto; padding:0 32px; width:100%; }
.mk-blog-hero-title{ font-size:3.5rem; font-weight:800; color:#FFFFFF; margin:0 0 14px; text-shadow:0 2px 8px rgba(0,0,0,0.25); }
.mk-blog-hero-title span{ color:#E8792E; }
.mk-blog-hero-sub{ font-size:1.5rem; color:#F1EEEA; max-width:650px; margin:0 0 32px; line-height:1.6; }

/* ---------------- Search Bar Section ---------------- */
.mk-search-box{ background:#ffffff; border-radius:12px; padding:8px 10px 8px 20px; display:flex; align-items:center; max-width:680px; box-shadow:0 8px 24px rgba(0,0,0,0.2); }
.mk-search-input-wrapper{ display:flex; align-items:center; flex:1; gap:12px; padding-right:12px; }
.mk-search-input-wrapper i{ color:#E8792E; font-size:1.25rem; }
.mk-search-input{ border:none; outline:none; width:100%; font-size:1.25rem; color:#2E2620; background:transparent; }
.mk-search-input::placeholder{ color:#8A7F73; }
.mk-search-btn{ background:#E8792E !important; color:#FFFFFF !important; border:none; border-radius:8px; padding:14px 28px; font-size:1.25rem; font-weight:700; cursor:pointer; white-space:nowrap; transition:background .2s ease; }
.mk-search-btn:hover{ background:#C9611F !important; }

@media (max-width:768px){ .mk-search-box{ flex-direction:column; gap:12px; padding:12px; } .mk-search-input-wrapper{ width:100%; padding-right:0; } .mk-search-btn{ width:100%; } }
@media (max-width:576px){ .mk-blog-hero{ padding:90px 20px 80px; text-align:left; min-height:320px; } .mk-blog-hero .container{ padding:0 12px; } .mk-blog-hero-title{ font-size:2rem; } .mk-blog-hero-sub{ font-size:1rem; margin:0 0 24px; } }

/* ---------------- Map Section ---------------- */
.mk-store-section{ padding:70px 24px; text-align:center; background:#F8F9FA; }
.mk-store-section .container{ max-width:1180px; margin:0 auto; }
.mk-store-title{ font-size:2.5rem; font-weight:800; color:#2E2620; margin:0 0 10px; }
.mk-store-sub{ font-size:1.5rem; color:#8A7F73; max-width:520px; margin:0 auto 36px; line-height:1.6; }
.mk-store-box{ display:grid; grid-template-columns:360px 1fr; background:#FFFFFF; border:1px solid #EDE4D8; border-radius:16px; overflow:hidden; box-shadow:0 4px 16px rgba(0,0,0,0.05); text-align:left; }
.mk-store-list{ border-right:1px solid #EDE4D8; max-height:420px; overflow-y:auto; }
.mk-store-search{ padding:16px; border-bottom:1px solid #EDE4D8; }
.mk-store-search input{ width:100%; padding:10px 14px; border:1px solid #EDE4D8; border-radius:8px; font-size:1.3rem; box-sizing:border-box; font-family:inherit; }
.mk-store-search input:focus{ outline:none; border-color:#E8792E; }
.mk-store-item{ display:flex; justify-content:space-between; align-items:flex-start; gap:10px; padding:16px; border-bottom:1px solid #EDE4D8; cursor:pointer; transition:0.2s; }
.mk-store-item:last-child{ border-bottom:none; }
.mk-store-item:hover{ background:#fad3a3; }
.mk-store-item.active{ background:#ffc596; }
.mk-store-name{ font-weight:700; font-size:1.45rem; color:#2E2620; margin:0 0 4px; }
.mk-store-address{ font-size:1.2rem; color:#8A7F73; margin:0 0 6px; }
.mk-store-status{ font-size:1.2rem; font-weight:600; color:#227A3E; }
.mk-store-pin{ color:#E8792E; font-size:1.1rem; flex-shrink:0; }
.mk-store-map{ min-height:420px; }
.mk-store-map iframe{ width:100%; height:100%; min-height:420px; border:0; display:block; }

@media (max-width:768px){
    .mk-store-box{ grid-template-columns:1fr; }
    .mk-store-list{ border-right:none; border-bottom:1px solid #EDE4D8; max-height:300px; }
}

/* ---------------- Section Heading ---------------- */
.mk-section-heading{ text-align:center; max-width:1240px; margin:0 auto 40px; }
.mk-section-label{ display:inline-block; color:#E8792E; font-weight:700; letter-spacing:0.2em; text-transform:uppercase; margin-bottom:16px; }
.mk-section-title{ font-size:2.5rem; font-weight:800; color:#1A1A1A; margin:0 0 16px; }
.mk-section-desc{ color:#7A3B0D; font-size:1.5rem; line-height:1.8; margin:0; }

/* ---------------- Retail Section ---------------- */
.mk-retail-section{ padding:70px 24px; background: #FBF5ED; }
.mk-retail-section .container{ max-width:1180px; margin:0 auto; }
.mk-retail-section:nth-of-type(even){ background: #ffffff; }
.mk-retail-grid{ display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:24px; justify-content:center; }
.mk-retail-grid--center{ display:grid; grid-template-columns:repeat(auto-fit,minmax(250px, 280px)); gap:24px; justify-content:center; align-items:stretch; }
.mk-retail-card{ background:#ffffff; border:1px solid rgba(232,121,46,0.14); border-radius:28px; overflow:hidden; box-shadow:0 18px 40px rgba(0,0,0,0.06); cursor:pointer; transition:transform .25s ease, box-shadow .25s ease, border-color .25s ease; display:flex; flex-direction:column; min-height:420px; }
.mk-retail-card:hover{ transform:translateY(-6px); box-shadow:0 24px 50px rgba(0,0,0,0.12); border-color:#E8792E; }
.mk-retail-card-image{ position:relative; width:100%; aspect-ratio:4/3; overflow:hidden; background:#F7F3EE; }
.mk-retail-card-image img{ width:100%; height:100%; object-fit:cover; display:block; transition:transform .35s ease; }
.mk-retail-card:hover .mk-retail-card-image img{ transform:scale(1.04); }
.mk-retail-badge{ position:absolute; top:16px; left:16px; background:rgba(232,121,46,0.95); color:#fff; text-transform:uppercase; padding:8px 14px; border-radius:999px; font-size:1rem; font-weight:700; letter-spacing:.07em; }
.mk-retail-card-content{ padding:28px 26px; display:flex; flex-direction:column; flex:1; }
.mk-retail-card-title{ font-size:1.45rem; font-weight:800; margin:0 0 10px; color:#1A1A1A; line-height:1.2; }
.mk-retail-card-address{ display:flex; align-items:flex-start; gap:10px; color:#6B5A4D; font-size:1.25rem; line-height:1.7; margin:0; }
.mk-retail-card-address i{ margin-top:5px; flex-shrink:0; display:inline-flex; align-items:flex-start; justify-content:center; }
.mk-retail-card-meta{ margin:18px 0 0; flex:1; }
.mk-retail-card-hours{ display:flex; align-items:center; gap:10px; color:#7A3B0D; font-weight:700; margin:16px 0 0; }
.mk-retail-card-footer{ display:flex; align-items:center; justify-content:space-between; gap:12px; margin-top:24px; flex-wrap:wrap; }
.mk-retail-card-type{ background:#FCE9D4; color:#E8792E; padding:10px 16px; border-radius:999px; font-size:1rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; }
.mk-retail-card-actions{ display:flex; gap:12px; flex-wrap:wrap; }
.mk-retail-card-link, .mk-retail-card-map{ display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:12px 18px; border-radius:999px; font-size:1.25rem; font-weight:700; text-decoration:none; transition:all .2s ease; }
.mk-retail-card-map{ background:#E8792E; color:#fff; }
.mk-retail-card-link{ background:#F6F0E7; color:#7A3B0D; }
.mk-retail-card-link:hover, .mk-retail-card-map:hover{ transform:translateY(-2px); }

/* ---------------- Responsive Section ---------------- */
@media (max-width:1200px){ .mk-retail-grid{ grid-template-columns:repeat(3,minmax(0,1fr)); } }
@media (max-width:900px){ .mk-retail-grid{ grid-template-columns:repeat(2,minmax(0,1fr)); } }
@media (max-width:768px){ .mk-retail-grid{ grid-template-columns:1fr; } .mk-retail-grid--center{ grid-template-columns:1fr; } .mk-full-map-frame{ min-height:420px; } }

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
</style>

<!-- Hero Start -->
<section class="mk-blog-hero" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads/mannakampus.png);">
    <div class="container">
        <h1 class="mk-blog-hero-title">Temukan Lokasi Manna Kampus Terdekat</h1>
        <p class="mk-blog-hero-sub">Rumah belanja terpercaya yang siap melayani kebutuhan harian Anda dengan layanan ramah dan produk berkualitas.</p>
        <form action="" method="GET" class="mk-search-box">
            <div class="mk-search-input-wrapper">
                <i class="fa fa-search"></i>
                <input type="text" name="q" class="mk-search-input" placeholder="Cari nama outlet atau lokasi..." autocomplete="off">
            </div>
            <button type="submit" class="mk-search-btn">Cari Sekarang</button>
        </form>
    </div>
</section>
<!-- Hero End -->

<!-- Store Locator Start -->
<section class="mk-store-section">
    <div class="container">
        <h2 class="mk-store-title">Cari Gerai Kami</h2>
        <p class="mk-store-sub">Temukan lokasi Manna Kampus terdekat di kota Anda untuk pengalaman belanja terbaik.</p>

        <div class="mk-store-box">
            <div class="mk-store-list">
                <div class="mk-store-search">
                    <input id="mkStoreSearchInput" type="text" placeholder="Cari cabang...">
                </div>

                <?php if (!empty($result_cabang)): ?>
                    <?php foreach ($result_cabang as $index => $row): ?>
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
                        <div class="mk-store-item <?php echo $active_class; ?>" data-name="<?php echo htmlspecialchars($nama_cabang); ?>" data-address="<?php echo htmlspecialchars($alamat_cabang); ?>" onclick="changeMapLocation('<?php echo $escaped_address; ?>', this)">
                            <div>
                                <p class="mk-store-name"><?php echo htmlspecialchars($nama_cabang); ?></p>
                                <p class="mk-store-address"><?php echo htmlspecialchars($alamat_cabang); ?></p>
                                <p class="mk-store-status"><?php echo htmlspecialchars($display_status); ?></p>
                            </div>
                            <span class="mk-store-pin"><i class="fa fa-map-marker"></i></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="mk-catalog-empty" style="padding:18px 16px; margin:0; color:#8A7F73;">Belum ada data cabang.</p>
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

<!-- Supermarket Section Start -->
<section class="mk-retail-section">
    <div class="container">
        <div class="mk-section-heading">
            <h2 class="mk-section-title">Manna Kampus Supermarket</h2>
            <p class="mk-section-desc">Temukan cabang supermarket kami dengan fasilitas lengkap dan lokasi strategis di area Yogyakarta.</p>
        </div>
        <?php if(!empty($supermarkets)): ?>
            <div class="mk-retail-grid">
                <?php foreach($supermarkets as $row): ?>
                    <?php
                        $foto_cabang = !empty($row['foto']) ? $row['foto'] : 'default.jpg';
                        $badge_tipe = !empty($row['badge_tipe']) ? strtoupper($row['badge_tipe']) : 'SUPERMARKET';
                        $jam_op = !empty($row['jam_operasional']) ? $row['jam_operasional'] : 'Buka · 08.00 - 21.30';
                        $alamat_cabang = !empty($row['alamat']) ? $row['alamat'] : $row['nama_cabang'];
                        $link_maps = !empty($row['link_maps']) ? $row['link_maps'] : 'https://maps.google.com/?q='.urlencode($row['nama_cabang']);
                        $detail_link = BASE_URL . 'explor.php?id=' . $row['id'];
                    ?>
                    <article class="mk-retail-card" onclick="changeMapLocation('<?php echo addslashes($alamat_cabang); ?>')">
                        <div class="mk-retail-card-image">
                            <img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $foto_cabang; ?>" alt="<?php echo htmlspecialchars($row['nama_cabang']); ?>">
                            <span class="mk-retail-badge"><?php echo htmlspecialchars($badge_tipe); ?></span>
                        </div>
                        <div class="mk-retail-card-content">
                            <h3 class="mk-retail-card-title"><?php echo htmlspecialchars($row['nama_cabang']); ?></h3>
                            <div class="mk-retail-card-meta">
                                <p class="mk-retail-card-address"><i class="fa fa-map-marker-alt"></i> <?php echo htmlspecialchars($alamat_cabang); ?></p>
                                <div class="mk-retail-card-hours"><i class="fa-regular fa-clock"></i> <?php echo htmlspecialchars($jam_op); ?></div>
                            </div>
                            <div class="mk-retail-card-footer">
                                <div class="mk-retail-card-actions">
                                    <a href="<?php echo htmlspecialchars($link_maps); ?>" target="_blank" class="mk-retail-card-link">Lihat Peta</a>
                                    <a href="<?php echo $detail_link; ?>" class="mk-retail-card-map">Detail Outlet</a>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="text-align:center; color:#7A3B0D;">Belum ada data supermarket.</p>
        <?php endif; ?>
    </div>
</section>
<!-- Supermarket Section End -->

<!-- Minimarket Section Start -->
<section class="mk-retail-section">
    <div class="container">
        <div class="mk-section-heading">
            <h2 class="mk-section-title">Manna Kampus Minimarket</h2>
            <p class="mk-section-desc">Cabang minimarket kami hadir dengan konsep cepat dan mudah untuk kebutuhan sehari-hari Anda.</p>
        </div>
        <?php if(!empty($minimarkets)): ?>
            <div class="mk-retail-grid mk-retail-grid--center">
                <?php foreach($minimarkets as $row): ?>
                    <?php
                        $foto_cabang = !empty($row['foto']) ? $row['foto'] : 'default.jpg';
                        $badge_tipe = !empty($row['badge_tipe']) ? strtoupper($row['badge_tipe']) : 'MINIMARKET';
                        $jam_op = !empty($row['jam_operasional']) ? $row['jam_operasional'] : 'Buka · 08.00 - 21.30';
                        $alamat_cabang = !empty($row['alamat']) ? $row['alamat'] : $row['nama_cabang'];
                        $link_maps = !empty($row['link_maps']) ? $row['link_maps'] : 'https://maps.google.com/?q='.urlencode($row['nama_cabang']);
                        $detail_link = BASE_URL . 'explor.php?id=' . $row['id'];
                    ?>
                    <article class="mk-retail-card" onclick="changeMapLocation('<?php echo addslashes($alamat_cabang); ?>')">
                        <div class="mk-retail-card-image">
                            <img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $foto_cabang; ?>" alt="<?php echo htmlspecialchars($row['nama_cabang']); ?>">
                            <span class="mk-retail-badge"><?php echo htmlspecialchars($badge_tipe); ?></span>
                        </div>
                        <div class="mk-retail-card-content">
                            <h3 class="mk-retail-card-title"><?php echo htmlspecialchars($row['nama_cabang']); ?></h3>
                            <div class="mk-retail-card-meta">
                                <p class="mk-retail-card-address"><i class="fa fa-map-marker-alt"></i> <?php echo htmlspecialchars($alamat_cabang); ?></p>
                                <div class="mk-retail-card-hours"><i class="fa-regular fa-clock"></i> <?php echo htmlspecialchars($jam_op); ?></div>
                            </div>
                            <div class="mk-retail-card-footer">
                                <div class="mk-retail-card-actions">
                                    <a href="<?php echo htmlspecialchars($link_maps); ?>" target="_blank" class="mk-retail-card-link">Lihat Peta</a>
                                    <a href="<?php echo $detail_link; ?>" class="mk-retail-card-map">Detail Outlet</a>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="text-align:center; color:#7A3B0D;">Belum ada data minimarket.</p>
        <?php endif; ?>
    </div>
</section>
<!-- Minimarket Section End -->

<!-- Member Loyalty Section Start -->
<section class="mk-member-section">
    <div class="mk-member-wrap">
        <div class="mk-member-card">
            <div class="mk-member-content">
                <h2 class="mk-member-title">Member Manna Kampus Lebih Beruntung!</h2>
                <p class="mk-member-desc">Dapatkan poin belanja, diskon khusus ulang tahun, dan akses eksklusif ke flash sale member-only. Daftar sekarang dan mulai menabung!</p>
                <div class="mk-member-actions">
                    <a href="#" class="mk-member-btn-primary">Daftar Member Gratis</a>
                    <a href="#" class="mk-member-btn-outline">Pelajari Keuntungan</a>
                </div>
            </div>
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

<script>
function changeMapLocation(searchQuery, element) {
    const cards = document.querySelectorAll('.mk-store-item');
    cards.forEach(card => card.classList.remove('active'));
    if (element) {
        element.classList.add('active');
    }

    const iframe = document.getElementById('storeMapIframe');
    if (iframe) {
        iframe.src = `https://maps.google.com/maps?q=${encodeURIComponent(searchQuery)}&t=&z=16&ie=UTF8&iwloc=&output=embed`;
    }
}

const storeSearchInput = document.getElementById('mkStoreSearchInput');
if (storeSearchInput) {
    storeSearchInput.addEventListener('input', function () {
        const keyword = this.value.toLowerCase().trim();
        const cards = document.querySelectorAll('.mk-store-item');
        let foundActive = false;

        cards.forEach((card) => {
            const name = (card.dataset.name || '').toLowerCase();
            const address = (card.dataset.address || '').toLowerCase();
            const visible = !keyword || name.includes(keyword) || address.includes(keyword);
            card.style.display = visible ? '' : 'none';

            if (visible && !foundActive && card.classList.contains('active')) {
                foundActive = true;
            }
        });

        if (!keyword) {
            const firstVisible = document.querySelector('.mk-store-item:not([style*="display: none"])');
            if (firstVisible) {
                firstVisible.classList.add('active');
                const firstAddress = firstVisible.dataset.address || firstVisible.querySelector('.mk-store-address')?.textContent || '';
                changeMapLocation(firstAddress, firstVisible);
            }
        }
    });
}
</script>
