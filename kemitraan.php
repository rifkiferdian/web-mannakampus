<?php require_once('header.php');?>

<style>
.mk-mitra-hero { position: relative; width: 100%; min-height: 520px; display: flex; align-items: center; background-image: url('<?php echo BASE_URL; ?>assets/uploads/kemitraan.png'); background-size: cover; background-position: center; background-repeat: no-repeat; overflow: hidden; }
.mk-mitra-hero::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.45); z-index: 1; }
.mk-mitra-hero-wrap { position: relative; z-index: 2; max-width: 1200px; width: 100%; margin: 0 auto; padding: 80px 24px; display: flex; align-items: center; }
.mk-mitra-hero-content { max-width: 580px; }
.mk-mitra-hero-badge { display: inline-block; background: #e87817; color: #ffffff; font-weight: 600; font-size: 1.2rem; padding: 6px 16px; border-radius: 20px; margin-bottom: 16px; }
.mk-mitra-hero-title { font-size: 3.25rem; font-weight: 800; color: #ffffff; line-height: 1.2; margin: 0 0 16px; }
.mk-mitra-hero-title span { color: #ffffff; display: block; }
.mk-mitra-hero-desc { color: #ffffff; font-size: 1.5rem; line-height: 1.6; margin: 0 0 28px; font-weight: 400; opacity: 0.95; }
.mk-mitra-hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
.mk-mitra-btn-primary { display: inline-flex; align-items: center; justify-content: center; background: #e87817; color: #ffffff !important; font-weight: 600; font-size: 1.25rem; padding: 12px 24px; border-radius: 6px; text-decoration: none; transition: background .2s ease; }
.mk-mitra-btn-primary:hover { background: #d0650c; }
.mk-mitra-btn-outline { display: inline-flex; align-items: center; justify-content: center; background: rgba(255, 255, 255, 0.2); color: #ffffff !important; font-weight: 600; font-size: 1.25rem; padding: 12px 24px; border-radius: 6px; border: 1px solid rgba(255, 255, 255, 0.4); text-decoration: none; backdrop-filter: blur(4px); transition: all .2s ease; }
.mk-mitra-btn-outline:hover { background: rgba(255, 255, 255, 0.3); border-color: #ffffff; }

@media (max-width: 768px) { .mk-mitra-hero { min-height: 400px; } .mk-mitra-hero-wrap { padding: 40px 20px; } .mk-mitra-hero-title { font-size: 2.1rem; } }

/* Section Features / Why Choose Us */
.mk-why-section { background: #F7F5F1;; padding: 80px 24px; text-align: center; }
.mk-why-container { max-width: 1200px; margin: 0 auto; }
.mk-why-title { font-size: 2.5rem; font-weight: 700; color: #1c1c1c; margin-bottom: 12px; }
.mk-why-divider { width: 48px; height: 4px; background: #e87817; margin: 0 auto 50px; border-radius: 2px; }
.mk-why-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
.mk-why-card { background: #ffffff; border: 1px solid #eef0f2; border-radius: 12px; padding: 36px 28px; text-align: left; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02); transition: transform 0.2s ease, box-shadow 0.2s ease; }
.mk-why-card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06); }
.mk-why-icon { width: 48px; height: 48px; background: #fdeee0; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; color: #e87817; }
.mk-why-card-title { font-size: 1.45rem; font-weight: 700; color: #1c1c1c; margin: 0 0 12px; }
.mk-why-card-desc { font-size: 1.25rem; color: #666666; line-height: 1.6; margin: 0; }

@media (max-width: 992px) { .mk-why-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 640px) { .mk-why-grid { grid-template-columns: 1fr; } .mk-why-section { padding: 50px 20px; } .mk-why-title { font-size: 1.75rem; } }

/* Section Wrapper */
.mk-jalur-section { background: #fffefe; padding: 80px 24px; }
.mk-jalur-container { max-width: 1100px; margin: 0 auto; }
.mk-jalur-header { text-align: center; margin-bottom: 48px; }
.mk-jalur-title { font-size: 2.5rem; font-weight: 800; color: #1c1c1c; margin: 0 0 10px; }
.mk-jalur-subtitle { font-size: 1.5rem; color: #666666; margin: 0; }
.mk-jalur-list { display: flex; flex-direction: column; gap: 32px; }
.mk-jalur-card { background: #ffffff; border-radius: 16px; overflow: hidden; display: flex; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04); border: 1px solid #edf2f7; transition: transform 0.2s ease, box-shadow 0.2s ease; }
.mk-jalur-card:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08); }
.mk-jalur-card.reverse { flex-direction: row-reverse; }
.mk-jalur-media { flex: 1; min-width: 40%; position: relative; }
.mk-jalur-media img { width: 100%; height: 100%; min-height: 280px; object-fit: cover; display: block; }
.mk-jalur-body { flex: 1.2; padding: 40px; display: flex; flex-direction: column; justify-content: center; }
.mk-jalur-badge { display: inline-flex; align-items: center; gap: 8px; font-size: 1.25rem; font-weight: 700; color: #b86200; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px; }
.mk-jalur-card-title { font-size: 2.25rem; font-weight: 800; color: #1c1c1c; margin: 0 0 12px; line-height: 1.3; }
.mk-jalur-card-desc { font-size: 1.25rem; color: #666666; line-height: 1.6; margin: 0 0 24px; }
.mk-jalur-features { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px 16px; margin-bottom: 28px; }
.mk-jalur-feature-item { display: flex; align-items: center; gap: 8px; font-size: 1.25rem; font-weight: 600; color: #4a5568; }
.mk-jalur-feature-item svg { color: #b86200; flex-shrink: 0; }
.mk-jalur-btn { display: inline-flex; align-items: center; justify-content: center; align-self: flex-start; padding: 10px 22px; border: 1.5px solid #b86200; border-radius: 8px; background: transparent; color: #b86200 !important; font-weight: 600; font-size: 1.25rem; text-decoration: none; transition: all 0.2s ease; }
.mk-jalur-btn:hover { background: #b86200; color: #ffffff !important; }
@media (max-width: 868px) { .mk-jalur-card, .mk-jalur-card.reverse { flex-direction: column; } .mk-jalur-media { width: 100%; } .mk-jalur-media img { height: 220px; min-height: auto; } .mk-jalur-body { padding: 28px 24px; } .mk-jalur-features { grid-template-columns: 1fr; } }

/* Form Section Container */
.mk-form-section { background: #F7F5F1; padding: 80px 24px; }
.mk-form-container { max-width: 1000px; margin: 0 auto; background: #ffffff; border-radius: 16px; display: flex; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); border: 1px solid #edf2f7; }

/* Left Side (Info Box) */
.mk-form-info { flex: 1; background: #a84b00; color: #ffffff; padding: 48px; display: flex; flex-direction: column; justify-content: center; }
.mk-form-info-title { font-size: 2.5rem; font-weight: 800; color: #ffffff; line-height: 1.25; margin: 0 0 16px; }
.mk-form-info-desc { font-size: 1.5rem; color: rgba(255, 255, 255, 0.9); line-height: 1.6; margin: 0 0 36px; }
.mk-form-contact-list { display: flex; flex-direction: column; gap: 20px; }
.mk-form-contact-item { display: flex; align-items: flex-start; gap: 16px; }
.mk-form-contact-icon { width: 40px; height: 40px; background: rgba(255, 255, 255, 0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #ffffff; }
.mk-form-contact-label { font-size: 1.1rem; color: rgba(255, 255, 255, 0.75); text-transform: uppercase; font-weight: 600; margin-bottom: 2px; }
.mk-form-contact-val { font-size: 1.1rem; font-weight: 700; color: #ffffff; }

/* Right Side (Form Fields) */
.mk-form-body { flex: 1.2; padding: 48px; background: #ffffff; }
.mk-form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px; }
.mk-form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
.mk-form-group.full { grid-column: span 2; margin-bottom: 0; }
.mk-form-label { font-size: 1.2rem; font-weight: 600; color: #4a5568; }
.mk-form-input, .mk-form-select, .mk-form-textarea { width: 100%; padding: 12px 16px; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 1.2rem; color: #1c1c1c; outline: none; transition: border-color 0.2s ease, background 0.2s ease; box-sizing: border-box; }
.mk-form-input:focus, .mk-form-select:focus, .mk-form-textarea:focus { border-color: #f27a1a; background: #ffffff; }
.mk-form-textarea { resize: vertical; min-height: 100px; font-family: inherit; }
.mk-form-submit { width: 100%; padding: 14px; background: #f27a1a; color: #ffffff; border: none; border-radius: 8px; font-size: 1.2rem; font-weight: 700; cursor: pointer; transition: background 0.2s ease; }
.mk-form-submit:hover { background: #d9660c; }

/* Responsive Media Queries */
@media (max-width: 868px) { .mk-form-container { flex-direction: column; } .mk-form-info, .mk-form-body { padding: 32px 24px; } .mk-form-grid { grid-template-columns: 1fr; } .mk-form-group.full { grid-column: span 1; } }

</style>

<!-- Mitra Hero Start -->
<section class="mk-mitra-hero">
    <div class="mk-mitra-hero-wrap">
        <div class="mk-mitra-hero-content">
            <span class="mk-mitra-hero-badge">Program Kemitraan</span>
            <h1 class="mk-mitra-hero-title">Tumbuh Bersama <span>Manna Kampus</span></h1>
            <p class="mk-mitra-hero-desc">Membangun ekosistem ritel yang terpercaya dan berkelanjutan. Mari jalin kerjasama strategis untuk memperluas jangkauan pasar Anda.</p>
            <div class="mk-mitra-hero-actions">
                <a href= " # " class="mk-mitra-btn-primary">Mulai Kemitraan</a>
                <a href=" # " class="mk-mitra-btn-outline">Pelajari Lebih Lanjut</a>
            </div>
        </div>
    </div>
</section>
<!-- Mitra Hero End -->

<!-- Why Choose Us Section Start -->
<section class="mk-why-section">
    <div class="mk-why-container">
        <h2 class="mk-why-title">Mengapa Bermitra dengan Kami?</h2>
        <div class="mk-why-divider"></div>
        
        <div class="mk-why-grid">
            <!-- Card 1 -->
            <div class="mk-why-card">
                <div class="mk-why-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 11 12 14 22 4"></polyline></svg>
                </div>
                <h3 class="mk-why-card-title">Jaringan Terpercaya</h3>
                <p class="mk-why-card-desc">Manna Kampus telah dikenal selama puluhan tahun sebagai "Rumah Belanja Terpercaya" dengan jutaan pelanggan setia di seluruh wilayah.</p>
            </div>

            <!-- Card 2 -->
            <div class="mk-why-card">
                <div class="mk-why-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                </div>
                <h3 class="mk-why-card-title">Distribusi Luas</h3>
                <p class="mk-why-card-desc">Akses ke lokasi strategis di pusat keramaian dan mahasiswa, memastikan produk atau layanan Anda dilihat oleh audiens yang tepat.</p>
            </div>

            <!-- Card 3 -->
            <div class="mk-why-card">
                <div class="mk-why-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                </div>
                <h3 class="mk-why-card-title">Manajemen Profesional</h3>
                <p class="mk-why-card-desc">Sistem operasional modern dan dukungan pemasaran terpadu untuk membantu pertumbuhan bisnis mitra secara berkelanjutan.</p>
            </div>
        </div>
    </div>
</section>
<!-- Why Choose Us Section End -->

<!-- Pilihan Jalur Kemitraan Start -->
<section class="mk-jalur-section">
    <div class="mk-jalur-container">
        
        <!-- Section Header -->
        <div class="mk-jalur-header">
            <h2 class="mk-jalur-title">Pilihan Jalur Kemitraan</h2>
            <p class="mk-jalur-subtitle">Sesuaikan kolaborasi dengan model bisnis Anda</p>
        </div>

        <!-- Cards List -->
        <div class="mk-jalur-list">
            
            <!-- Card 1: Mitra Supplier -->
            <div class="mk-jalur-card">
                <div class="mk-jalur-media">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/mitra-1.png" alt="Mitra Supplier">
                </div>
                <div class="mk-jalur-body">
                    <div class="mk-jalur-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        01. MITRA SUPPLIER
                    </div>
                    <h3 class="mk-jalur-card-title">Penyedia Barang & Produk Lokal</h3>
                    <p class="mk-jalur-card-desc">Kami membuka pintu bagi produsen, UKM, dan pemilik merek untuk mendistribusikan produk berkualitas mereka di rak-rak Manna Kampus. Dapatkan akses ke sistem inventory modern dan pembayaran tepat waktu.</p>
                    <div class="mk-jalur-features">
                        <div class="mk-jalur-feature-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Akses Pasar Mahasiswa & Umum
                        </div>
                        <div class="mk-jalur-feature-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Sistem Konsinyasi Transparan
                        </div>
                    </div>
                    <a href="#" class="mk-jalur-btn">Daftar Supplier</a>
                </div>
            </div>

            <!-- Card 2: Sewa Tenant (Posisi Gambar Kanan) -->
            <div class="mk-jalur-card reverse">
                <div class="mk-jalur-media">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/mitra-2.png" alt="Sewa Tenant">
                </div>
                <div class="mk-jalur-body">
                    <div class="mk-jalur-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        02. SEWA TENANT
                    </div>
                    <h3 class="mk-jalur-card-title">Ruang Usaha & Food Stall</h3>
                    <p class="mk-jalur-card-desc">Manfaatkan trafik tinggi di lokasi-lokasi Manna Kampus. Tersedia berbagai pilihan luas ruang untuk tenant F&B, jasa, atau retail kecil dengan fasilitas penunjang yang lengkap.</p>
                    <div class="mk-jalur-features">
                        <div class="mk-jalur-feature-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Lokasi Strategis di Area Kampus
                        </div>
                        <div class="mk-jalur-feature-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Fasilitas Kebersihan & Keamanan
                        </div>
                    </div>
                    <a href="#" class="mk-jalur-btn">Cek Lokasi Tersedia</a>
                </div>
            </div>

            <!-- Card 3: Investasi -->
            <div class="mk-jalur-card">
                <div class="mk-jalur-media">
                    <img src="<?php echo BASE_URL; ?>assets/uploads/mitra-3.png" alt="Peluang Investasi">
                </div>
                <div class="mk-jalur-body">
                    <div class="mk-jalur-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                        03. INVESTASI
                    </div>
                    <h3 class="mk-jalur-card-title">Peluang Investasi Strategis</h3>
                    <p class="mk-jalur-card-desc">Bergabunglah dalam ekspansi bisnis Manna Kampus. Kami menawarkan peluang investasi yang aman dan transparan bagi mitra yang ingin berpartisipasi dalam pertumbuhan ritel modern kami.</p>
                    <div class="mk-jalur-features">
                        <div class="mk-jalur-feature-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Profit Sharing yang Kompetitif
                        </div>
                        <div class="mk-jalur-feature-item">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Laporan Kinerja Berkala
                        </div>
                    </div>
                    <a href="#" class="mk-jalur-btn">Hubungi Tim Investasi</a>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Pilihan Jalur Kemitraan End -->


<!-- Form Section Start -->
<section class="mk-form-section">
    <div class="mk-form-container">
        
        <!-- Left Side: Informasi Kontak -->
        <div class="mk-form-info">
            <h2 class="mk-form-info-title">Siap untuk Melangkah Maju?</h2>
            <p class="mk-form-info-desc">Isi formulir berikut dan tim kemitraan kami akan menghubungi Anda dalam waktu 2×24 jam untuk diskusi lebih lanjut.</p>
            
            <div class="mk-form-contact-list">
                <div class="mk-form-contact-item">
                    <div class="mk-form-contact-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    </div>
                    <div>
                        <div class="mk-form-contact-label">Email Kemitraan</div>
                        <div class="mk-form-contact-val">partnership@mannakampus.com</div>
                    </div>
                </div>

                <div class="mk-form-contact-item">
                    <div class="mk-form-contact-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    </div>
                    <div>
                        <div class="mk-form-contact-label">Hubungi Kami</div>
                        <div class="mk-form-contact-val">(0274) 123-4567</div>
                    </div>
                </div>

                <div class="mk-form-contact-item">
                    <div class="mk-form-contact-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    </div>
                    <div>
                        <div class="mk-form-contact-label">Kantor Pusat</div>
                        <div class="mk-form-contact-val">Yogyakarta, Indonesia</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Form Input -->
        <div class="mk-form-body">
            <form action="#" method="POST">
                <div class="mk-form-grid">
                    <div class="mk-form-group">
                        <label class="mk-form-label">Nama Lengkap</label>
                        <input type="text" class="mk-form-input" placeholder="John Doe" required>
                    </div>
                    <div class="mk-form-group">
                        <label class="mk-form-label">Nama Perusahaan / Brand</label>
                        <input type="text" class="mk-form-input" placeholder="PT. Sukses Mandiri" required>
                    </div>
                </div>

                <div class="mk-form-group">
                    <label class="mk-form-label">Tipe Kemitraan</label>
                    <select class="mk-form-select" required>
                        <option value="" disabled selected>Pilih Jalur Kemitraan</option>
                        <option value="supplier">Mitra Supplier</option>
                        <option value="tenant">Sewa Tenant</option>
                        <option value="investasi">Investasi Strategis</option>
                    </select>
                </div>

                <div class="mk-form-group">
                    <label class="mk-form-label">Pesan atau Keterangan Singkat</label>
                    <textarea class="mk-form-textarea" placeholder="Jelaskan secara singkat mengenai profil bisnis atau rencana kerjasama Anda..."></textarea>
                </div>

                <button type="submit" class="mk-form-submit">Kirim Formulir Kemitraan</button>
            </form>
        </div>

    </div>
</section>
<!-- Form Section End -->

<?php require_once('footer.php'); ?>