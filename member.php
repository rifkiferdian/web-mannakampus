<?php require_once('header.php'); ?>

<style>
/* Full hero + why-section styles copied from kemitraan.php for consistent look */
.mk-mitra-hero { position: relative; width: 100%; min-height: 520px; display: flex; align-items: center; background-image: url('<?php echo BASE_URL; ?>assets/uploads/kemitraan.png'); background-size: cover; background-position: center; background-repeat: no-repeat; overflow: hidden; }
.mk-mitra-hero::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.45); z-index: 1; }
.mk-mitra-hero-wrap { position: relative; z-index: 2; max-width: 1200px; width: 100%; margin: 0 auto; padding: 80px 24px; display: flex; align-items: center; }
.mk-mitra-hero-content { max-width: 680px; }
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

/* Member Privileges styles (match kemitraan 'why' section, icons centered) */
.mb-priv-section { background: #F7F5F1; padding: 80px 24px; text-align: center; }
.mb-priv-container { max-width: 1200px; margin: 0 auto; }
.mb-priv-small { text-transform: uppercase; color: #b86b2a; font-size: 1.5rem; letter-spacing: 1.6px; }
.mb-priv-title { font-size: 2.5rem; font-weight: 700; color: #1c1c1c; margin: 6px 0 0; }
.mb-priv-divider { width: 48px; height: 4px; background: #e87817; margin: 12px auto 0; border-radius: 2px; }
.mb-priv-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 28px; }
.mb-priv-card { background: #ffffff; border: 1px solid #eef0f2; border-radius: 12px; padding: 36px 28px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: transform .2s ease, box-shadow .2s ease; }
.mb-priv-card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(0,0,0,0.06); }
.mb-priv-icon { width: 64px; height: 64px; background: #fdeee0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; color: #e87817; }
.mb-priv-icon svg { width: 28px; height: 28px; }
.mb-priv-card-title { font-size: 1.45rem; font-weight: 700; color: #1c1c1c; margin: 0 0 12px; }
.mb-priv-card-desc { font-size: 1.25rem; color: #666666; line-height: 1.6; margin: 0; }
.mb-priv-card.span-2 { grid-column: span 2; }

@media (max-width: 992px) { .mb-priv-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 640px) { .mb-priv-grid { grid-template-columns: 1fr; } }

/* Event Spotlight styles */
.mb-event-section { background: #ffffff; padding: 40px 24px; }
.mb-event-card { max-width: 1200px; margin: 0 auto; background: #ffffff; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); padding: 20px; display: grid; grid-template-columns: 1.1fr 1fr; gap: 36px; align-items: center; }
.mb-event-media { border-radius: 14px; overflow: hidden; }
.mb-event-media a { display: block; line-height: 0; }
.mb-event-media img { width: 100%; height: auto; display: block; border-radius: 14px; }
/* Override any global styles inherited from .payment-promo-image / .payment-promo-image-popup
   (used elsewhere on the site) that add height, padding, or a background box here */
.mb-event-media a.payment-promo-image,
.mb-event-media a.payment-promo-image-popup {
    display: block !important;
    position: static !important;
    height: auto !important;
    min-height: 0 !important;
    max-height: none !important;
    padding: 0 !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    background: none !important;
    aspect-ratio: auto !important;
}
.mb-event-content { padding: 20px 20px 20px 0; }
.mb-event-badge { display: inline-flex; align-items: center; gap: 7px; background: #fdeee0; color: #d0650c; font-weight: 700; font-size: 1.25rem; letter-spacing: 0.02em; padding: 7px 14px; border-radius: 999px; margin-bottom: 18px; }
.mb-event-badge svg { flex-shrink: 0; }
.mb-event-title { font-size: 1.7rem; font-weight: 800; color: #1c1c1c; margin: 0 0 14px; line-height: 1.3; letter-spacing: -0.01em; }
.mb-event-desc { font-size: 1.25rem; color: #666666; line-height: 1.7; margin: 0 0 22px; }
.mb-event-checklist { display: grid; grid-template-columns: 1fr; gap: 11px; margin-bottom: 26px; }
.mb-event-check { display: flex; align-items: flex-start; gap: 9px; font-size: 1.25rem; color: #1c1c1c; font-weight: 500; line-height: 1.5; }
.mb-event-check svg { flex-shrink: 0; margin-top: 2px; color: #16a34a; }
.mb-event-actions { display: flex; gap: 12px; flex-wrap: wrap; }
.mb-event-cta { display: inline-flex; align-items: center; gap: 8px; background: #e87817; color: #ffffff; font-weight: 700; font-size: 1rem; text-decoration: none; padding: 12px 22px; border-radius: 8px; transition: background .2s ease, transform .2s ease; }
.mb-event-cta:hover { background: #d0650c; transform: translateY(-1px); }

@media (max-width: 768px) { .mb-event-card { grid-template-columns: 1fr; padding: 16px; } .mb-event-content { padding: 8px 4px 4px; } }

@media (max-width: 992px) { .mk-why-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 640px) { .mk-why-grid { grid-template-columns: 1fr; } .mk-why-section { padding: 50px 20px; } .mk-why-title { font-size: 1.75rem; } }

/* Member page card styles (kept if used elsewhere) */
.mb-cards-wrap { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; padding: 20px; }
.mb-card { background: #ffffff; border-radius: 12px; padding: 28px 22px; box-shadow: 0 6px 18px rgba(0,0,0,0.04); text-align: center; }
.mb-card-icon { width: 64px; height: 64px; margin: 0 auto 14px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: #fff4ee; color: #e87817; }
.mb-card-title { font-size: 1.05rem; font-weight: 700; color: #1c1c1c; margin: 0 0 8px; }
.mb-card-desc { color: #6b6b6b; font-size: 0.98rem; line-height: 1.5; margin: 0; }

@media (max-width: 992px) { .mb-cards-wrap { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 640px) { .mb-cards-wrap { grid-template-columns: 1fr; } .mk-mitra-hero-wrap { padding: 40px 16px; } }


/* Section Features / Why Choose Us (used for Cara Bergabung) */
.mk-why-section { background: #F7F5F1;; padding: 80px 24px; text-align: center; }
.mk-why-container { max-width: 1200px; margin: 0 auto; }
.mk-why-title { font-size: 2.5rem; font-weight: 700; color: #1c1c1c; margin-bottom: 12px; }
.mk-why-divider { width: 48px; height: 4px; background: #e87817; margin: 0 auto 50px; border-radius: 2px; }
.mk-why-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
.mk-why-card { background: #ffffff; border: 1px solid #eef0f2; border-radius: 12px; padding: 28px 24px; text-align: center; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02); transition: transform 0.2s ease, box-shadow 0.2s ease; }
.mk-why-card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06); }
.mk-why-icon { width: 64px; height: 64px; background: #fdeee0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; color: #e87817; }
.mk-why-icon svg { width: 28px; height: 28px; }
.mk-why-card-title { font-size: 1.45rem; font-weight: 700; color: #1c1c1c; margin: 0 0 8px; }
.mk-why-card-desc { font-size: 1.25rem; color: #666666; line-height: 1.6; margin: 0; }

/* Step badge */
.mk-step-badge { display: inline-block; background: #e87817; color: #ffffff; padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 1.25rem; margin-bottom: 10px; }

/* Magnific Popup tweaks for member page: slightly larger image and style close button */
.mfp-figure, .mfp-content { max-width: 1100px; }
.mfp-figure { max-width: 1100px; margin: 0 auto; }
.mfp-img { width: 100%; height: auto; }
@media (max-width: 1400px) { .mfp-figure { max-width: 980px; } }
@media (max-width: 1200px) { .mfp-figure { max-width: 820px; } }
@media (max-width: 768px) { .mfp-figure { max-width: 92%; } }

/* Circular orange close button (single ×) */
.mfp-close {
    right: 18px !important;
    top: 18px !important;
    width: 48px !important;
    height: 48px !important;
    background: #e87817 !important;
    border-radius: 999px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 22px !important;
    color: #ffffff !important;
    cursor: pointer !important;
    box-shadow: 0 6px 18px rgba(0,0,0,0.22) !important;
    opacity: 1 !important;
    z-index: 100001 !important;
    line-height: 48px !important;
    padding: 0 !important;
    border: none !important;
    text-shadow: none !important;
}
</style>

<!-- Hero (same structure as kemitraan.php) -->
<section class="mk-mitra-hero">
    <div class="mk-mitra-hero-wrap">
        <div class="mk-mitra-hero-content">
            <span class="mk-mitra-hero-badge">Membership</span>
            <h1 class="mk-mitra-hero-title">Gabung dan Nikmati Keuntungan <span>Manna Kampus</span></h1>
            <p class="mk-mitra-hero-desc">Daftar sebagai member untuk mendapatkan promo eksklusif, kumpulkan poin, dan nikmati layanan prioritas di seluruh cabang Manna Kampus.</p>
        </div>
    </div>
</section>

<!-- Member Privileges Section -->
<section class="mb-priv-section">
    <div class="mb-priv-container">
        <div style="text-align:center;margin-bottom:24px;">
            <div class="mb-priv-small">Member Privileges</div>
            <h2 class="mb-priv-title">Kenapa Harus Jadi Member?</h2>
            <div class="mb-priv-divider" style="margin:18px auto 0;"></div>
        </div>

        <div class="mb-priv-grid">
            <div class="mb-priv-card">
                <div class="mb-priv-icon" style="background:#fff4ee;color:#e87817;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10v6a2 2 0 0 1-2 2H9l-6-6V4a2 2 0 0 1 2-2h6"></path><path d="M7 7h.01"></path><path d="M17 7h.01"></path></svg>
                </div>
                <div>
                    <div class="mb-priv-card-title">Diskon Eksklusif</div>
                    <div class="mb-priv-card-desc">Potongan harga khusus member untuk ratusan produk pilihan setiap minggunya.</div>
                </div>
            </div>

            <div class="mb-priv-card">
                <div class="mb-priv-icon" style="background:#eef8f7;color:#0aa68a;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="7" width="18" height="13" rx="2"></rect><path d="M16 3l-4 4-4-4"></path></svg>
                </div>
                <div>
                    <div class="mb-priv-card-title">Kejutan Ulang Tahun</div>
                    <div class="mb-priv-card-desc">Rayakan hari spesial Anda dengan kado istimewa dan voucher belanja dari kami.</div>
                </div>
            </div>

            <div class="mb-priv-card">
                <div class="mb-priv-icon" style="background:#fff4ee;color:#e87817;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l2.09 4.26L19 7l-3.5 3.22L16.18 16 12 13.77 7.82 16l.68-5.78L5 7l4.91-.74L12 2z"></path></svg>
                </div>
                <div>
                    <div class="mb-priv-card-title">Poin Reward</div>
                    <div class="mb-priv-card-desc">Kumpulkan 1 poin setiap belanja Rp 10.000. Tukarkan dengan voucher atau produk menarik.</div>
                </div>
            </div>

            <div class="mb-priv-card">
                <div class="mb-priv-icon" style="background:#f0f4f6;color:#6b7280;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><path d="M16 8l6 3v5"></path><circle cx="5.5" cy="18.5" r="1.5"></circle><circle cx="18.5" cy="18.5" r="1.5"></circle></svg>
                </div>
                <div>
                    <div class="mb-priv-card-title">Gratis Ongkir</div>
                    <div class="mb-priv-card-desc">Nikmati layanan pengiriman gratis untuk belanja online dengan radius hingga 5km.</div>
                </div>
            </div>

            <div class="mb-priv-card">
                <div class="mb-priv-icon" style="background:#fff4ee;color:#e87817;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10v6a2 2 0 0 1-2 2H9l-6-6V4a2 2 0 0 1 2-2h6"></path><path d="M7 11l3 3 7-7"></path></svg>
                </div>
                <div>
                    <div class="mb-priv-card-title">Undian Berhadiah</div>
                    <div class="mb-priv-card-desc">Kesempatan mengikuti program undian berhadiah besar.</div>
                </div>
            </div>

            <div class="mb-priv-card">
                <div class="mb-priv-icon" style="background:#fffaf6;color:#8a4a0a;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><path d="M7 10h10v4H7z"></path></svg>
                </div>
                <div>
                    <div class="mb-priv-card-title">Akses Cepat e-Receipt</div>
                    <div class="mb-priv-card-desc">Pantau pengeluaran Anda dengan mudah. Riwayat transaksi tersimpan digital di aplikasi.</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Event Spotlight Section -->
<section class="mb-event-section">
    <div class="mb-event-card">

        <div class="mb-event-media">
            <a class="payment-promo-image payment-promo-image-popup" href="<?php echo BASE_URL; ?>assets/uploads/promo-event-gebyar-undian-2026.webp" aria-label="Perbesar Event Undian Spektakuler">
                <img src="<?php echo BASE_URL; ?>assets/uploads/promo-event-gebyar-undian-2026.webp" alt="Event Manna Kampus">
            </a>
        </div>

        <div class="mb-event-content">
            <span class="mb-event-badge">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6M2 7h20M12 22V7M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7zM12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>
                Event Tahunan Manna Kampus
            </span>

            <h3 class="mb-event-title">Undian Spektakuler Manna Kampus</h3>
            <p class="mb-event-desc">Kesempatan memenangkan Hadiah Utama berupa Rumah Siap Huni, Mobil Mewah, Motor, dan ribuan hadiah elektronik lainnya! Semakin sering belanja, semakin besar peluang Anda membawa pulang hadiah impian.</p>

            <div class="mb-event-checklist">
                <div class="mb-event-check">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Belanja minimal Rp 100.000 untuk mendapatkan 1 kupon undian.
                </div>
                <div class="mb-event-check">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Kupon otomatis tercatat melalui ID Member Anda.
                </div>
                <div class="mb-event-check">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Pantau jumlah kupon Anda di aplikasi Manna Kampus.
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Cara Bergabung Section (styled like kemitraan 'Mengapa Bermitra') -->
<section class="mk-why-section">
    <div class="mk-why-container">
        <h2 class="mk-why-title">Cara Bergabung Menjadi Member</h2>
        <div class="mk-why-divider"></div>

        <div class="mk-why-grid">
            <div class="mk-why-card">
                <div class="mk-step-badge">01</div>
                <h3 class="mk-why-card-title">Daftar di Kasir atau Online</h3>
                <p class="mk-why-card-desc">Kunjungi cabang Manna Kampus terdekat atau daftar melalui website dan aplikasi kami.</p>
            </div>

            <div class="mk-why-card">
                <div class="mk-step-badge">02</div>
                <h3 class="mk-why-card-title">Lengkapi Data Diri</h3>
                <p class="mk-why-card-desc">Isi informasi pribadi dan nomor telepon untuk aktivasi akun member yang aman.</p>
            </div>

            <div class="mk-why-card">
                <div class="mk-step-badge">03</div>
                <h3 class="mk-why-card-title">Mulai Kumpulkan Poin</h3>
                <p class="mk-why-card-desc">Gunakan ID member di setiap transaksi untuk mengumpulkan poin dan hadiah menarik.</p>
            </div>
        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>