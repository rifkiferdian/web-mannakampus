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

/* ---------------- Kategori Belanja ---------------- */
.mk-category{ background: #ffffff; padding:70px 24px; }
.mk-category-wrap{ max-width:1180px; margin:0 auto; }
.mk-category-head{ display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:32px; }
.mk-category-title{ font-size:2.5rem; font-weight:800; color:var(--mk-text,#2E2620); margin:0 0 8px; }
.mk-category-sub{ color:var(--mk-muted,#8A7F73); font-size:1.5rem; margin:0; }
.mk-category-link{ display:inline-flex; align-items:center; gap:6px; color:#da5c2a; font-weight:700; font-size:1.5rem; white-space:nowrap; text-decoration:none; }
.mk-category-link i{ font-size:1.5rem; }

.mk-category-grid{ display:grid; grid-template-columns:1.4fr 1fr; gap:16px; height:420px; }
.mk-category-main{ position:relative; border-radius:12px; overflow:hidden; height:100%; min-height:0; }
.mk-category-main img{ width:100% !important; height:100% !important; max-width:100% !important; object-fit:cover !important; display:block; margin:0; }
.mk-category-side{ display:grid; grid-template-rows:1fr 1fr; gap:16px; height:100%; min-height:0; }
.mk-category-side-top{ position:relative; border-radius:12px; overflow:hidden; height:100%; min-height:0; }
.mk-category-side-top img{ width:100% !important; height:100% !important; max-width:100% !important; object-fit:cover !important; display:block; margin:0; }
.mk-category-side-bottom{ display:grid; grid-template-columns:1fr 1fr; gap:16px; height:100%; min-height:0; }
.mk-category-side-bottom > div{ position:relative; border-radius:12px; overflow:hidden; height:100%; min-height:0; }
.mk-category-side-bottom img{ width:100% !important; height:100% !important; max-width:100% !important; object-fit:cover !important; display:block; margin:0; }

.mk-category-overlay{ position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.15) 45%, rgba(0,0,0,0) 70%); display:flex; flex-direction:column; justify-content:flex-end; padding:20px; }
.mk-category-overlay-title{ color:#FFFFFF; font-weight:700; font-size:1.5rem; margin:0 0 4px; }
.mk-category-overlay-desc{ color:#F1EEEA; font-size:1.25rem; margin:0; line-height:1.4; }
.mk-category-side-bottom .mk-category-overlay{ padding:14px; }
.mk-category-side-bottom .mk-category-overlay-title{ font-size:1.3rem; }
.mk-category-side-bottom .mk-category-overlay-desc{ display:none; }

@media (max-width:768px){
    .mk-category-grid{ grid-template-columns:1fr; height:auto; }
    .mk-category-main{ height:260px; }
    .mk-category-side-top{ height:200px; }
    .mk-category-side-bottom > div{ height:160px; }
}

/* ---------------- Download App ---------------- */
.mk-app{ background:#EDEBE8; padding:80px 24px; }
.mk-app-wrap{ max-width:1180px; margin:0 auto; display:flex; align-items:center; justify-content:center; gap:80px; flex-wrap:wrap; }

.mk-app-phone{ width:260px; height:520px; background:#111; border-radius:44px; padding:14px; box-shadow:0 20px 50px rgba(0,0,0,0.18); flex-shrink:0; }
.mk-app-screen{ background:#FFFFFF; width:100%; height:100%; border-radius:32px; overflow:hidden; display:flex; flex-direction:column; position:relative; }
.mk-app-notch{ position:absolute; top:0; left:50%; transform:translateX(-50%); width:90px; height:20px; background:#111; border-radius:0 0 14px 14px; z-index:2; }

/* PERBAIKAN PADA TOPBAR DAN LOGO */
.mk-app-topbar{ display:flex; align-items:center; justify-content:space-between; padding:24px 14px 10px; height:54px; box-sizing:border-box; }
.mk-app-topbar-icon{ color:#2E2620; font-size:1.1rem; flex-shrink:0; }
.mk-app-logo-img{ max-height:24px; max-width:60%; width:auto; height:auto; object-fit:contain; display:block; }

.mk-app-promo{ margin:6px 16px 16px; background:#FBE0C8; border-radius:10px; padding:12px 14px; }
.mk-app-promo-tag{ color:#C9611F; font-weight:700; font-size:1.0rem; letter-spacing:0.5px; margin:0 0 4px; }
.mk-app-promo-title{ color:#1C1C1C; font-weight:800; font-size:0.9rem; margin:0; }
.mk-app-blocks{ padding:0 16px; display:flex; flex-direction:column; gap:10px; flex:1; }
.mk-app-block-full{ background:#EDEAE5; border-radius:10px; height:64px; }
.mk-app-block-row{ display:grid; grid-template-columns:1fr 1fr; gap:10px; }
.mk-app-block-row > div{ background:#EDEAE5; border-radius:10px; height:64px; }

.mk-app-content{ flex:1; min-width:320px; max-width:520px; }
.mk-app-title{ font-size:2.25rem; font-weight:800; color:#1C1C1C; line-height:1.25; margin:0 0 20px; }
.mk-app-desc{ color:#6B6058; font-size:1.5rem; line-height:1.7; margin:0 0 28px; }
.mk-app-feature-list{ list-style:none; margin:0 0 32px; padding:0; display:flex; flex-direction:column; gap:18px; }
.mk-app-feature{ display:flex; align-items:center; gap:14px; }
.mk-app-feature-icon{ width:34px; height:34px; border-radius:50%; background:#E8792E; color:#FFFFFF; display:flex; align-items:center; justify-content:center; font-size:1.5rem; flex-shrink:0; }
.mk-app-feature-text{ color:#2E2620; font-weight:600; font-size:1.25rem; }
.mk-app-badges{ display:flex; gap:14px; flex-wrap:wrap; }
.mk-app-store-badge{ display:inline-flex; align-items:center; gap:10px; background:#000000; color:#FFFFFF !important; border-radius:8px; padding:8px 16px; text-decoration:none; border:1px solid #3A3A3A; }
.mk-app-store-badge-icon{ font-size:1.7rem; flex-shrink:0; line-height:1; display:flex; align-items:center; justify-content:center; width:26px; }
.mk-app-store-badge-icon .fa-google{ background:linear-gradient(135deg,#00D4FF 0%,#00D4FF 25%,#00E676 25%,#00E676 50%,#FFD600 50%,#FFD600 75%,#FF3D57 75%); -webkit-background-clip:text; background-clip:text; color:transparent; }
.mk-app-store-badge-text{ line-height:1.15; }
.mk-app-store-badge-eyebrow{ display:block; font-size:0.62rem; font-weight:400; text-transform:uppercase; letter-spacing:0.5px; color:#FFFFFF; margin:0; }
.mk-app-store-badge-main{ display:block; font-size:1.05rem; font-weight:700; margin:0; font-family:inherit; }

@media (max-width:900px){
    .mk-app-wrap{ flex-direction:column; text-align:center; }
    .mk-app-feature{ justify-content:center; }
    .mk-app-badges{ justify-content:center; }
}

</style>

<!-- Hero Shop Start -->
<section class="mk-shop-hero">
    <div class="mk-shop-hero-wrap">
        <div class="mk-shop-hero-content">
            <span class="mk-shop-hero-badge">#RumahBelanjaTerpercaya</span>
            <h1 class="mk-shop-hero-title">Belanja Lebih Mudah <span>Secara Online</span></h1>
            <p class="mk-shop-hero-desc">Nikmati pengalaman belanja kebutuhan harian tanpa keluar rumah. Segar, lengkap, dan diantar langsung ke depan pintu Anda.</p>
            <div class="mk-shop-hero-actions">
                <a href="#" class="mk-shop-hero-btn-primary">Masuk Toko Digital <i class="fa fa-arrow-right"></i></a>
                <a href="#" class="mk-shop-hero-btn-outline">Lihat Promo</a>
            </div>
        </div>

        <div class="mk-shop-hero-media">
            <img src="<?php echo BASE_URL; ?>assets/uploads/belanja-online1.png" alt="Belanja kebutuhan harian Manna Kampus">
            <div class="mk-shop-hero-card">
                <div class="mk-shop-hero-card-icon"><i class="fa fa-truck"></i></div>
                <div>
                    <p class="mk-shop-hero-card-title">Pengiriman Cepat</p>
                    <p class="mk-shop-hero-card-sub">Estimasi 30-60 menit</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Shop End -->

<!-- Kategori Belanja Start -->
<section class="mk-category">
    <div class="mk-category-wrap">
        <div class="mk-category-head">
            <div>
                <h2 class="mk-category-title">Kategori Belanja</h2>
                <p class="mk-category-sub">Temukan kebutuhan Anda berdasarkan kategori terlengkap</p>
            </div>
            <a href="#" class="mk-category-link">Lihat Semua Kategori <i class="fa fa-arrow-right"></i></a>
        </div>

        <div class="mk-category-grid">
            <!-- Main: Fresh Produce -->
            <div class="mk-category-main">
                <img src="<?php echo BASE_URL; ?>assets/uploads/kategori-belanja1.png" alt="Fresh Produce">
                <div class="mk-category-overlay">
                    <p class="mk-category-overlay-title">Fresh Produce</p>
                    <p class="mk-category-overlay-desc">Sayur & buah segar setiap hari dari petani lokal.</p>
                </div>
            </div>

            <div class="mk-category-side">
                <!-- Side Top: Grocery & Pantry -->
                <div class="mk-category-side-top">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/kategori-belanja2.png" alt="Grocery & Pantry">
                    <div class="mk-category-overlay">
                        <p class="mk-category-overlay-title">Grocery & Pantry</p>
                        <p class="mk-category-overlay-desc">Kebutuhan dapur lengkap dalam satu tempat.</p>
                    </div>
                </div>

                <!-- Side Bottom: Home Care & Personal Care -->
                <div class="mk-category-side-bottom">
                    <div>
                        <img src="<?php echo BASE_URL; ?>assets/uploads/kategori-belanja.png" alt="Home Care">
                        <div class="mk-category-overlay">
                            <p class="mk-category-overlay-title">Home Care</p>
                        </div>
                    </div>
                    <div>
                        <img src="<?php echo BASE_URL; ?>assets/uploads/kategori-belanja4.png" alt="Personal Care">
                        <div class="mk-category-overlay">
                            <p class="mk-category-overlay-title">Personal Care</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Kategori Belanja End -->

<!-- Download App Start -->
<section class="mk-app">
    <div class="mk-app-wrap">
        <div class="mk-app-phone">
            <div class="mk-app-screen">
                <div class="mk-app-notch"></div>
                
                <!-- TOPBAR YANG SUDAH DIPERBAIKI -->
                <div class="mk-app-topbar">
                    <i class="fa fa-bars mk-app-topbar-icon"></i>
                    <img src="<?php echo BASE_URL; ?>assets/uploads/logo.png" alt="Manna Kampus" class="mk-app-logo-img">
                    <i class="fa fa-bell mk-app-topbar-icon"></i>
                </div>
                
                <div class="mk-app-promo">
                    <p class="mk-app-promo-tag">DISKON APP EXCLUSIVE</p>
                    <p class="mk-app-promo-title">POTONGAN 50RB</p>
                </div>
                <div class="mk-app-blocks">
                    <div class="mk-app-block-full"></div>
                    <div class="mk-app-block-row">
                        <div></div>
                        <div></div>
                    </div>
                    <div class="mk-app-block-full"></div>
                </div>
            </div>
        </div>

        <div class="mk-app-content">
            <h2 class="mk-app-title">Download Aplikasi Manna Kampus</h2>
            <p class="mk-app-desc">Dapatkan pengalaman belanja yang lebih personal, promo eksklusif pengguna aplikasi, dan lacak pesanan Anda secara real-time. Belanja kini ada dalam genggaman Anda.</p>

            <ul class="mk-app-feature-list">
                <li class="mk-app-feature">
                    <span class="mk-app-feature-icon"><i class="fa fa-ticket"></i></span>
                    <span class="mk-app-feature-text">Voucher pengguna baru s/d Rp 100.000</span>
                </li>
                <li class="mk-app-feature">
                    <span class="mk-app-feature-icon"><i class="fa fa-location-arrow"></i></span>
                    <span class="mk-app-feature-text">Real-time Order Tracking</span>
                </li>
                <li class="mk-app-feature">
                    <span class="mk-app-feature-icon"><i class="fa fa-bolt"></i></span>
                    <span class="mk-app-feature-text">Akses ke Flash Sale Mingguan</span>
                </li>
            </ul>

            <div class="mk-app-badges">
                <a href="#" class="mk-app-store-badge">
                    <span class="mk-app-store-badge-icon"><i class="fa fa-apple"></i></span>
                    <span class="mk-app-store-badge-text">
                        <span class="mk-app-store-badge-eyebrow">Download on the</span>
                        <span class="mk-app-store-badge-main">App Store</span>
                    </span>
                </a>
                <a href="#" class="mk-app-store-badge">
                    <span class="mk-app-store-badge-icon"><i class="fa fa-google-play"></i></span>
                    <span class="mk-app-store-badge-text">
                        <span class="mk-app-store-badge-eyebrow">GET IT ON</span>
                        <span class="mk-app-store-badge-main">Google Play</span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- Download App End -->

<?php require_once('footer.php'); ?>