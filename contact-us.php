<?php
$contact_hotline = $contact_hotline ?? '(0274) 555-123';
$contact_email = $contact_email ?? 'care@mannakampus.co.id';
$contact_jam_operasional = $contact_jam_operasional ?? 'Senin - Minggu, 08:00 - 21:00 WIB';
$contact_form_message = $contact_form_message ?? '';

require_once('header.php');
?>

<style>
.mk-blog-list{ --mk-orange:#E8792E; --mk-orange-dark:#C9611F; --mk-text:#2E2620; --mk-muted:#8A7F73; --mk-border:#EDE4D8; }
.mk-blog-list a{ text-decoration:none; }

/* ---------------- Hero Section ---------------- */
.mk-blog-hero{ position:relative; background-size:cover; background-position:center; background-repeat:no-repeat; padding:140px 24px 120px; text-align:left; min-height:240px; display:flex; align-items:center; }
.mk-blog-hero::before{ content:""; position:absolute; inset:0; background:rgba(20,20,20,0.45); }
.mk-blog-hero .container{ position:relative; z-index:2; max-width:1240px; margin:0 auto; padding:0 32px; }
.mk-blog-hero-title{ font-size:3.25rem; font-weight:800; color:#FFFFFF; margin:0 0 14px; text-shadow:0 2px 8px rgba(0,0,0,0.25); }
.mk-blog-hero-title span{ color:#E8792E; }
.mk-blog-hero-sub{ font-size:1.5rem; color:#F1EEEA; max-width:560px; margin:0; line-height:1.7; }

@media (max-width:576px){
	.mk-blog-hero{ padding:90px 20px 80px; text-align:center; min-height:320px; }
	.mk-blog-hero .container{ padding:0 12px; }
	.mk-blog-hero-title{ font-size:1.8rem; }
	.mk-blog-hero-sub{ font-size:1rem; margin:0 auto; }
}

/* ---------------- Container list blog ---------------- */
.mk-blog-list .container{ max-width:1240px; margin:0 auto; padding:48px 32px; }

/* ---------------- Contact Section ---------------- */
.mk-contact-section{ background: #ffffff; padding:60px 24px; }
.mk-contact-section .container{ max-width:1180px; margin:0 auto; }
.mk-contact-grid{ display:grid; grid-template-columns:1fr 1.8fr; gap:24px; align-items:start; }
.mk-contact-left{ display:flex; flex-direction:column; gap:24px; }

.mk-card{ background:#FFFFFF; border:1px solid var(--mk-border,#EDE4D8); border-radius:12px; padding:28px; box-shadow:0 2px 8px rgba(0,0,0,0.04); }
.mk-card-title{ font-size:1.5rem; font-weight:700; color:var(--mk-orange,#E8792E); margin:0 0 20px; }

.mk-contact-item{ display:flex; align-items:flex-start; gap:14px; margin-bottom:20px; }
.mk-contact-item:last-child{ margin-bottom:0; }
.mk-contact-icon{ width:40px; height:40px; flex-shrink:0; border-radius:50%; background:#FDEDE0; color:var(--mk-orange,#E8792E); display:flex; align-items:center; justify-content:center; font-size:1rem; }
.mk-contact-label{ margin:0; font-size:1.2rem; color:var(--mk-muted,#8A7F73); text-transform:uppercase; letter-spacing:0.3px; }
.mk-contact-value{ margin:2px 0 0; font-weight:700; color:var(--mk-text,#2E2620); }
.mk-contact-value a{ color:var(--mk-text,#2E2620); }

.mk-livechat{ text-align:center;}
.mk-livechat-icon{ width:48px; height:48px; margin:0 auto 14px; border-radius:50%; background:#FDEDE0; color:var(--mk-orange,#E8792E); display:flex; align-items:center; justify-content:center; font-size:1.2rem; }
.mk-livechat h4{ margin:0 0 8px; font-size:1.5rem; font-weight:700; color:var(--mk-text,#2E2620); }
.mk-livechat p{ margin:0 0 18px; font-size:1.25rem; color:var(--mk-muted,#8A7F73); line-height:1.5; }
.mk-btn-outline{ display:inline-block; width:100%; padding:10px 20px; border:1px solid var(--mk-orange,#E8792E); color:var(--mk-orange,#E8792E); border-radius:8px; font-weight:600; text-align:center; transition:0.2s; }
.mk-btn-outline:hover{ background:var(--mk-orange,#E8792E); color:#fff; }

.mk-form-row{ display:grid; grid-template-columns:1fr 1fr; gap:16px; }
.mk-field{ margin-bottom:27px; }
.mk-field label{ display:block; margin-bottom:6px; font-size:1.2rem; font-weight:600; color:var(--mk-text,#2E2620); }
.mk-field input, .mk-field select, .mk-field textarea{ width:100%; padding:12px 14px; border:1px solid var(--mk-border,#EDE4D8); border-radius:8px; font-size:1.25rem; color:var(--mk-text,#2E2620); background:#FAFAF8; box-sizing:border-box; font-family:inherit; }
.mk-field textarea{ min-height:110px; resize:vertical; }
.mk-field input:focus, .mk-field select:focus, .mk-field textarea:focus{ outline:none; border-color:var(--mk-orange,#E8792E); background:#fff; }
.mk-submit-btn{ width:100%; padding:14px 20px; background:var(--mk-orange,#E8792E); color:#fff; border:none; border-radius:8px; font-weight:700; font-size:1.2rem; cursor:pointer; transition:0.2s; }
.mk-submit-btn:hover{ background:var(--mk-orange-dark,#C9611F); }
.mk-form-alert{ padding:12px 16px; border-radius:8px; margin-bottom:18px; font-size:0.9rem; }
.mk-form-alert.success{ background:#E7F6EA; color:#227A3E; border:1px solid #B7E4C2; }

@media (max-width:768px){
	.mk-contact-grid{ grid-template-columns:1fr; }
	.mk-form-row{ grid-template-columns:1fr; }
}
/* ---------------- Section: Cari Gerai Kami ---------------- */
.mk-store-section{ padding:70px 24px; text-align:center; background: #F7F5F1; }
.mk-store-section .container{ max-width:1180px; margin:0 auto; }
.mk-store-title{ font-size:2.5rem; font-weight:800; color:var(--mk-text,#2E2620); margin:0 0 10px; }
.mk-store-sub{ font-size:1.5rem; color:var(--mk-muted,#8A7F73); max-width:520px; margin:0 auto 36px; line-height:1.6; }

.mk-store-box{ display:grid; grid-template-columns:360px 1fr; background:#FFFFFF; border:1px solid var(--mk-border,#EDE4D8); border-radius:16px; overflow:hidden; box-shadow:0 4px 16px rgba(0,0,0,0.05); text-align:left; }

/* Kolom kiri: search + list toko */
.mk-store-list{ border-right:1px solid var(--mk-border,#EDE4D8); max-height:420px; overflow-y:auto; }
.mk-store-search{ padding:16px; border-bottom:1px solid var(--mk-border,#EDE4D8); }
.mk-store-search input{ width:100%; padding:10px 14px; border:1px solid var(--mk-border,#EDE4D8); border-radius:8px; font-size:1.2rem; box-sizing:border-box; font-family:inherit; }
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

/* ---------------- Section: Tetap Terhubung dengan Kami ---------------- */
.mk-newsletter-section{ background:#241F1A; padding:70px 24px; text-align:center; }
.mk-newsletter-section .container{ max-width:560px; margin:0 auto; }
.mk-newsletter-title{ font-size:2.5rem; font-weight:800; color:#FFFFFF; margin:0 0 10px; }
.mk-newsletter-sub{ font-size:1.5rem; color:#C9C1B8; margin:0 0 28px; line-height:1.6; }

.mk-newsletter-form{ display:flex; gap:10px; }
.mk-newsletter-form input{ flex:1; padding:13px 16px; border:1px solid #4A423A; border-radius:8px; background:#2E2822; color:#FFFFFF; font-size:1.2rem; font-family:inherit; }
.mk-newsletter-form input::placeholder{ color:#8A7F73; }
.mk-newsletter-form input:focus{ outline:none; border-color:var(--mk-orange,#E8792E); }
.mk-newsletter-form button{ padding:13px 24px; background:var(--mk-orange,#E8792E); color:#fff; border:none; border-radius:8px; font-weight:700; font-size:1.2rem; cursor:pointer; white-space:nowrap; transition:0.2s; }
.mk-newsletter-form button:hover{ background:var(--mk-orange-dark,#C9611F); }

@media (max-width:576px){
	.mk-newsletter-form{ flex-direction:column; }
}
</style>

<!-- Hero Start  -->
<section class="mk-blog-hero" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads/manna_kampus.png);">
	<div class="container">
		<h1 class="mk-blog-hero-title">Kami Siap Melayani Anda</h1>
		<p class="mk-blog-hero-sub">Rumah belanja terpercaya hadir untuk memberikan layanan terbaik. Hubungi tim kami untuk pertanyaan, masukan, atau bantuan lebih lanjut.</p>
	</div>
</section>
<!-- Hero End -->

<!-- Contact Content Start -->
<div class="mk-contact-section">
	<div class="container">
		<div class="mk-contact-grid">

			<!-- Left column: contact info + live chat -->
			<div class="mk-contact-left">
				<div class="mk-card">
					<h3 class="mk-card-title">Layanan Pelanggan</h3>

					<div class="mk-contact-item">
						<div class="mk-contact-icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
						<div>
							<p class="mk-contact-label">Hotline 24/7</p>
							<p class="mk-contact-value"><?php echo htmlspecialchars($contact_hotline, ENT_QUOTES, 'UTF-8'); ?></p>
						</div>
					</div>

					<div class="mk-contact-item">
						<div class="mk-contact-icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
						<div>
							<p class="mk-contact-label">Email Kami</p>
							<p class="mk-contact-value"><a href="mailto:<?php echo htmlspecialchars($contact_email, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($contact_email, ENT_QUOTES, 'UTF-8'); ?></a></p>
						</div>
					</div>

					<div class="mk-contact-item">
						<div class="mk-contact-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
						<div>
							<p class="mk-contact-label">Jam Operasional Kantor</p>
							<p class="mk-contact-value"><?php echo htmlspecialchars($contact_jam_operasional, ENT_QUOTES, 'UTF-8'); ?></p>
						</div>
					</div>
				</div>

				<div class="mk-card mk-livechat">
					<div class="mk-livechat-icon"><i class="fa fa-comment" aria-hidden="true"></i></div>
					<h4>Live Chat</h4>
					<p>Dapatkan jawaban instan melalui layanan pesan singkat kami.</p>
					<a href="#" class="mk-btn-outline">Mulai Chat</a>
				</div>
			</div>

			<!-- Right column: contact form -->
			<div class="mk-card">
				<h3 class="mk-card-title">Kirim Pesan</h3>

				<?php if($contact_form_message !== ''): ?>
				<div class="mk-form-alert success"><?php echo htmlspecialchars($contact_form_message, ENT_QUOTES, 'UTF-8'); ?></div>
				<?php endif; ?>

				<form action="proses_kontak.php" method="post">
					<div class="mk-form-row">
						<div class="mk-field">
							<label for="nama_lengkap">Nama Lengkap</label>
							<input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama Anda" required>
						</div>
						<div class="mk-field">
							<label for="alamat_email">Alamat Email</label>
							<input type="email" id="alamat_email" name="alamat_email" placeholder="email@contoh.com" required>
						</div>
					</div>

					<div class="mk-field">
						<label for="subjek">Subjek</label>
						<select id="subjek" name="subjek">
							<option value="Saran Pelayanan">Saran Pelayanan</option>
							<option value="Keluhan">Keluhan</option>
							<option value="Kemitraan">Kemitraan</option>
							<option value="Lainnya">Lainnya</option>
						</select>
					</div>

					<div class="mk-field">
						<label for="pesan_anda">Pesan Anda</label>
						<textarea id="pesan_anda" name="pesan_anda" placeholder="Tuliskan pesan Anda di sini..." required></textarea>
					</div>

					<button type="submit" class="mk-submit-btn">Kirim Pesan Sekarang</button>
				</form>
			</div>

		</div>
	</div>
</div>
<!-- Contact Content End -->

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

<!-- Newsletter Start -->
<section class="mk-newsletter-section">
	<div class="container">
		<h2 class="mk-newsletter-title">Tetap Terhubung dengan Kami</h2>
		<p class="mk-newsletter-sub">Dapatkan penawaran eksklusif dan berita terbaru dari Manna Kampus langsung di inbox Anda.</p>

		<form action="proses_subscribe.php" method="post" class="mk-newsletter-form">
			<input type="email" name="email_subscribe" placeholder="Alamat email Anda" required>
			<button type="submit">Berlangganan</button>
		</form>
	</div>
</section>
<!-- Newsletter End -->

<?php require_once('footer.php'); ?>