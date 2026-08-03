<?php require_once('header.php');?>

<style>
.mk-blog-list{ --mk-orange:#E8792E; --mk-orange-dark:#C9611F; --mk-text:#2E2620; --mk-muted:#8A7F73; --mk-border:#EDE4D8; }
.mk-blog-list a{ text-decoration:none; }

/* ---------------- Hero Section ---------------- */
.mk-blog-hero{ position:relative; background-size:cover; background-position:center; background-repeat:no-repeat; padding:140px 24px 120px; text-align:left; min-height:240px; display:flex; align-items:center; }
.mk-blog-hero::before{ content:""; position:absolute; inset:0; background:rgba(20,20,20,0.45); }
.mk-blog-hero .container{ position:relative; z-index:2; max-width:1240px; margin:0 auto; padding:0 32px; }
.mk-blog-hero-title{ font-size:3.25rem; font-weight:800; color:#FFFFFF; margin:0 0 14px; text-shadow:0 2px 8px rgba(0,0,0,0.25); }
.mk-blog-hero-title span{ color:#E8792E; }
.mk-blog-hero-sub{ font-size:1.5rem; color:#F1EEEA; max-width:560px; margin:0 0 28px; line-height:1.7; }
.mk-blog-hero-btn{
	display:inline-flex !important;
	align-items:center;
	gap:10px;
	background: #E8792E !important;
	color:#FFFFFF !important;
	font-weight:700;
	font-size:1.2rem;
	padding:12px 24px;
	border-radius:50px !important;
	box-shadow:0 4px 12px rgba(232,121,46,0.35);
	transition:background .2s ease;
	border:none;
}
.mk-blog-hero-btn:hover{
	background:#C9611F !important;
	color:#FFFFFF !important;
}
.mk-blog-hero-btn i{
	font-size:0.85rem;
	color:#FFFFFF !important;
}

@media (max-width:576px){
	.mk-blog-hero{ padding:90px 20px 80px; text-align:center; min-height:320px; }
	.mk-blog-hero .container{ padding:0 12px; }
	.mk-blog-hero-title{ font-size:1.8rem; }
	.mk-blog-hero-sub{ font-size:1rem; margin:0 auto 24px; }
}

/* ---------------- Connect Section ---------------- */
.mk-connect{ background: #F7F5F1; padding:80px 24px; text-align:center; }
.mk-connect-title{ font-size:2.5rem; font-weight:800; color:var(--mk-text,#2E2620); margin:0 0 10px; }
.mk-connect-divider{ width:60px; height:3px; background:var(--mk-orange); margin:0 auto 18px; border-radius:2px; }
.mk-connect-sub{ color:var(--mk-orange); font-size:1.5rem; margin:0 0 44px; }

.mk-connect-grid{ display:flex; flex-wrap:wrap; justify-content:center; gap:20px; max-width:1200px; margin:0 auto; }
.mk-connect-card{ background:#FFFFFF; border:1px solid var(--mk-border); border-radius:10px; padding:28px 24px; width:200px; box-shadow:0 2px 6px rgba(0,0,0,0.04); }
.mk-connect-icon{ width:52px; height:52px; border-radius:12px; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; font-size:1.3rem; }
.mk-connect-icon.instagram{ background:#FCE4EC; color:#E1306C; }
.mk-connect-icon.facebook{ background:#E3F2FD; color:#1877F2; }
.mk-connect-icon.twitter{ background:#EFEFEF; color:#111111; }
.mk-connect-icon.youtube{ background:#FDECEC; color:#FF0000; }
.mk-connect-icon.tiktok{ background:#EFEFEF; color:#111111; }

.mk-connect-name{ font-weight:700; color:var(--mk-text); margin:0 0 4px; font-size:1.45rem; }
.mk-connect-handle{ color:var(--mk-muted); font-size:1.2rem; margin:0 0 16px; }
.mk-connect-follow{ display:inline-block; width:100%; padding:8px 0; border-radius:6px; border:1.5px solid; font-weight:700; font-size:1.2rem; background:#FFFFFF; transition:all .2s ease; }
.mk-connect-follow.instagram{ border-color:#E1306C; color:#E1306C; }
.mk-connect-follow.instagram:hover{ background:#E1306C; color:#FFFFFF; }
.mk-connect-follow.facebook{ border-color:#1877F2; color:#1877F2; }
.mk-connect-follow.facebook:hover{ background:#1877F2; color:#FFFFFF; }
.mk-connect-follow.twitter{ border-color:#111111; color:#111111; }
.mk-connect-follow.twitter:hover{ background:#111111; color:#FFFFFF; }
.mk-connect-follow.youtube{ border-color:#FF0000; color:#FF0000; }
.mk-connect-follow.youtube:hover{ background:#FF0000; color:#FFFFFF; }
.mk-connect-follow.tiktok{ border-color:#111111; color:#111111; }
.mk-connect-follow.tiktok:hover{ background:#111111; color:#FFFFFF; }

@media (max-width:576px){
	.mk-connect{ padding:60px 16px; }
	.mk-connect-title{ font-size:1.5rem; }
	.mk-connect-card{ width:100%; max-width:280px; }
}

/* ---------------- Community Highlights ---------------- */
.mk-highlights{ background: #ffffff; padding:70px 24px; }
.mk-highlights-wrap{ max-width:1180px; margin:0 auto; }
.mk-highlights-head{ display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:32px; }
.mk-highlights-title{ font-size:2.5rem; font-weight:800; color:var(--mk-text,#2E2620); margin:0 0 10px; }
.mk-highlights-sub{ color:var(--mk-muted); font-size:1.5rem; margin:0; }
.mk-highlights-sub a{ color:var(--mk-orange); font-weight:700; }
.mk-highlights-link{ display:inline-flex; align-items:center; gap:6px; color: #da5c2a; font-weight:700; font-size:1.25rem; white-space:nowrap; }
.mk-highlights-link i{ font-size:1.25rem; }

.mk-highlights-grid{ display:grid; grid-template-columns:1.4fr 1fr; gap:16px; }
.mk-highlights-main img{ width:100%; height:100%; object-fit:cover; border-radius:10px; display:block; }
.mk-highlights-side{ display:grid; grid-template-rows:1fr 1fr; gap:16px; }
.mk-highlights-side-top img{ width:100%; height:100%; object-fit:cover; border-radius:10px; display:block; }
.mk-highlights-side-bottom{ display:grid; grid-template-columns:1fr 1fr; gap:16px; }
.mk-highlights-side-bottom img{ width:100%; height:100%; object-fit:cover; border-radius:10px; display:block; }

@media (max-width:768px){
	.mk-highlights-grid{ grid-template-columns:1fr; }
	.mk-highlights-main{ height:260px; }
	.mk-highlights-side{ height:auto; }
}

/* ---------------- Newsletter Section ---------------- */
.mk-newsletter{ background: #F7F5F1; padding:70px 24px 70px; }
.mk-newsletter-wrap{ max-width:1180px; margin:0 auto; background: #E8792E; border-radius:16px; padding:48px 56px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:32px; }
.mk-newsletter-title{ font-size:2.5rem; font-weight:800; color:#FFFFFF; margin:0 0 12px; }
.mk-newsletter-text{ color:#FBE7D9; font-size:1.5rem; line-height:1.6; max-width:420px; margin:0; }

.mk-newsletter-form{ display:flex; flex-direction:column; gap:10px; min-width:380px; }
.mk-newsletter-fields{ display:flex; gap:10px; }
.mk-newsletter-input{ flex:1; border:none; border-radius:8px; padding:13px 16px; font-size:1.2rem; outline:none; }
.mk-newsletter-btn{ background:#1C1C1C; color:#FFFFFF; border:none; border-radius:8px; padding:13px 22px; font-weight:700; font-size:1.2rem; white-space:nowrap; cursor:pointer; transition:background .2s ease; }
.mk-newsletter-btn:hover{ background:#000000; }
.mk-newsletter-note{ color:#FBE7D9; font-size:1.2rem; margin:0; }
.mk-newsletter-note a{ color:#FFFFFF; font-weight:700; text-decoration:underline; }

@media (max-width:768px){
	.mk-newsletter-wrap{ padding:36px 24px; flex-direction:column; align-items:flex-start; }
	.mk-newsletter-form{ min-width:0; width:100%; }
	.mk-newsletter-fields{ flex-direction:column; }
	.mk-newsletter-text{ max-width:none; }
}
</style>

<!-- Hero Start  -->
<section class="mk-blog-hero" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads/community.png);">
	<div class="container">
		<h1 class="mk-blog-hero-title">Bergabunglah dengan Komunitas Kami</h1>
		<p class="mk-blog-hero-sub">Dapatkan informasi terkini, resep-resep baru, dan tips belanja eksklusif. Bergabunglah dengan kami dan jangan lewatkan pengalaman terbaik dari Rumah Belanja Terpercaya.</p>
		<a href="#" class="mk-blog-hero-btn">Mulai Sekarang <i class="fa fa-arrow-right"></i></a>
	</div>
</section>
<!-- Hero End -->

<!-- Connect Section Start -->
<section class="mk-connect">
	<h2 class="mk-connect-title">Terhubung Dengan Kami</h2>
	<div class="mk-connect-divider"></div>
	<p class="mk-connect-sub">Ikuti kami di semua platform untuk update harian.</p>

	<div class="mk-connect-grid">

		<div class="mk-connect-card">
			<div class="mk-connect-icon instagram"><i class="fa fa-instagram"></i></div>
			<p class="mk-connect-name">Instagram</p>
			<p class="mk-connect-handle">@mannakampus</p>
			<a href="#" class="mk-connect-follow instagram">Follow</a>
		</div>

		<div class="mk-connect-card">
			<div class="mk-connect-icon facebook"><i class="fa fa-facebook"></i></div>
			<p class="mk-connect-name">Facebook</p>
			<p class="mk-connect-handle">@mannakampus</p>
			<a href="#" class="mk-connect-follow facebook">Follow</a>
		</div>

		<div class="mk-connect-card">
			<div class="mk-connect-icon twitter"><i class="fa fa-twitter"></i></div>
			<p class="mk-connect-name">X (Twitter)</p>
			<p class="mk-connect-handle">@mannakampus</p>
			<a href="#" class="mk-connect-follow twitter">Follow</a>
		</div>

		<div class="mk-connect-card">
			<div class="mk-connect-icon youtube"><i class="fa fa-youtube-play"></i></div>
			<p class="mk-connect-name">YouTube</p>
			<p class="mk-connect-handle">@mannakampus</p>
			<a href="#" class="mk-connect-follow youtube">Follow</a>
		</div>

		<div class="mk-connect-card">
			<div class="mk-connect-icon tiktok"><i class="fa fa-music"></i></div>
			<p class="mk-connect-name">TikTok</p>
			<p class="mk-connect-handle">@mannakampus</p>
			<a href="#" class="mk-connect-follow tiktok">Follow</a>
		</div>

	</div>
</section>
<!-- Connect Section End -->

<!-- Community Highlights Start -->
<section class="mk-highlights">
	<div class="mk-highlights-wrap">
		<div class="mk-highlights-head">
			<div>
				<h2 class="mk-highlights-title">Sorotan Komunitas</h2>
				<p class="mk-highlights-sub">Lihat apa yang terjadi di Rumah Belanja Terpercaya Anda.</p>
			</div>
			<a href="#" class="mk-highlights-link">Lihat Galeri <i class="fa fa-external-link"></i></a>
		</div>

		<div class="mk-highlights-grid">
			<div class="mk-highlights-main">
				<img src="<?php echo BASE_URL; ?>assets/uploads/service-convenience.png" alt="Suasana toko Manna Kampus">
			</div>
			<div class="mk-highlights-side">
				<div class="mk-highlights-side-top">
					<img src="<?php echo BASE_URL; ?>assets/uploads/service-premium-quality.png" alt="Chef sedang memasak">
				</div>
				<div class="mk-highlights-side-bottom">
					<img src="<?php echo BASE_URL; ?>assets/uploads/slider-13.png" alt="Keluarga belanja bersama">
					<img src="<?php echo BASE_URL; ?>assets/uploads/promo-dairy-delights.png" alt="Roti dan keju">
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Community Highlights End -->

<!-- Newsletter Section Start -->
<section class="mk-newsletter">
	<div class="mk-newsletter-wrap">
		<div>
			<h2 class="mk-newsletter-title">Tetap Terhubung</h2>
			<p class="mk-newsletter-text">Berlangganan newsletter kami untuk penawaran eksklusif, resep pilihan, dan info terbaru dari Manna Kampus langsung ke inbox Anda.</p>
		</div>

		<form class="mk-newsletter-form" action="#" method="post">
			<div class="mk-newsletter-fields">
				<input type="email" name="newsletter_email" class="mk-newsletter-input" placeholder="Masukkan alamat email Anda" required>
				<button type="submit" class="mk-newsletter-btn">Berlangganan</button>
			</div>
			<p class="mk-newsletter-note">Dengan berlangganan, Anda menyetujui <a href="#">Kebijakan Privasi</a> dan <a href="#">Syarat Layanan</a> kami.</p>
		</form>
	</div>
</section>
<!-- Newsletter Section End -->

<?php require_once('footer.php'); ?>