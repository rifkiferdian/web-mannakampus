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

.mk-highlights-grid{ display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:16px; align-items:stretch; }
.mk-highlight-card{ position:relative; display:flex; flex-direction:column; height:100%; min-width:0; overflow:hidden; background:#fff; border-radius:10px; box-shadow:0 5px 18px rgba(46,38,32,.10); color:inherit; text-decoration:none; transition:transform .2s ease, box-shadow .2s ease; }
.mk-highlight-card:hover{ transform:translateY(-4px); box-shadow:0 10px 24px rgba(46,38,32,.16); }
.mk-highlight-card{ border:0; padding:0; text-align:left; width:100%; cursor:pointer; }
.mk-highlight-media{ position:relative; aspect-ratio:4/3; overflow:hidden; background:#f3eee9; }
.mk-highlight-content{ flex:1; }
.mk-highlight-media img{ width:100%; height:100%; object-fit:cover; display:block; transition:transform .3s ease; }
.mk-highlight-media.no-image{ display:flex; flex-direction:column; align-items:center; justify-content:center; gap:10px; background:linear-gradient(135deg,#f3eee9,#ded2c8); color:#765b49; font-size:42px; text-align:center; }
.mk-highlight-media.no-image small{ font-size:15px; font-weight:700; letter-spacing:.3px; }
.mk-highlight-card:hover .mk-highlight-media img{ transform:scale(1.04); }
.mk-highlight-platform{ position:absolute; top:12px; left:12px; display:grid; place-items:center; width:36px; height:36px; border-radius:50%; background:rgba(0,0,0,.72); color:#fff; font-size:18px; }
.mk-highlight-play{ position:absolute; inset:0; display:grid; place-items:center; color:#fff; font-size:32px; text-shadow:0 2px 8px rgba(0,0,0,.45); }
.mk-highlight-content{ padding:14px 16px 16px; }
.mk-highlight-title{ margin:0 0 6px; font-size:1.05rem; font-weight:700; }
.mk-highlight-author{ margin:0; color:var(--mk-muted); font-size:.92rem; }
.mk-highlights-grid .mk-highlights-main,.mk-highlights-grid .mk-highlights-side,.mk-highlights-side-top,.mk-highlights-side-bottom{ display:contents; }
.mk-highlights-main img{ width:100%; height:100%; object-fit:cover; border-radius:10px; display:block; }
.mk-highlights-side{ display:grid; grid-template-rows:1fr 1fr; gap:16px; }
.mk-highlights-side-top img{ width:100%; height:100%; object-fit:cover; border-radius:10px; display:block; }
.mk-highlights-side-bottom{ display:grid; grid-template-columns:1fr 1fr; gap:16px; }
.mk-highlights-side-bottom img{ width:100%; height:100%; object-fit:cover; border-radius:10px; display:block; }

.mk-video-modal{position:fixed;inset:0;display:none;align-items:center;justify-content:center;z-index:9999;}
.mk-video-modal.is-open{display:flex;}
.mk-video-modal-backdrop{position:absolute;inset:0;background:rgba(0,0,0,.75);}
.mk-video-modal-box{position:relative;background:#fff;border-radius:12px;padding:18px;max-width:720px;width:92%;max-height:90vh;z-index:1;overflow:auto;}
.mk-video-modal-frame{position:relative;width:100%;padding-top:75%;}
.mk-video-modal-frame.is-video{padding-top:120%;max-width:440px;margin:0 auto;}
.mk-video-modal-frame iframe,.mk-video-modal-frame img{position:absolute;inset:0;width:100%;height:100%;border:0;border-radius:8px;object-fit:contain;background:#f3f3f3;}
.mk-video-modal-original{display:flex;align-items:center;justify-content:center;gap:8px;margin-top:16px;padding:12px 18px;border:1px solid #da5c2a;border-radius:8px;background:#da5c2a;color:#fff;font-weight:700;text-decoration:none;transition:background .2s ease;}
.mk-video-modal-original:hover{background:#b9471e;color:#fff;}
.mk-video-modal-close{position:absolute;top:8px;right:12px;background:none;border:0;font-size:24px;cursor:pointer;}
.mk-highlight-video-trigger{cursor:pointer;background:none;border:0;padding:0;text-align:left;width:100%;}

@media (max-width:768px){
	.mk-highlights-grid{ grid-template-columns:1fr; }
}
@media (max-width:560px){ .mk-highlights-grid{ grid-template-columns:1fr; } }

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
			<div class="mk-connect-icon instagram"><i class="fab fa-instagram"></i></div>
			<p class="mk-connect-name">Instagram</p>
			<p class="mk-connect-handle">@mannakampus</p>
			<a href="https://www.instagram.com/mannakampus" class="mk-connect-follow instagram">Follow</a>
		</div>

		<div class="mk-connect-card">
			<div class="mk-connect-icon facebook"><i class="fab fa-facebook"></i></div>
			<p class="mk-connect-name">Facebook</p>
			<p class="mk-connect-handle">@mannakampus</p>
			<a href="#" class="mk-connect-follow facebook">Follow</a>
		</div>

		<div class="mk-connect-card">
			<div class="mk-connect-icon twitter"><i class="fab fa-twitter"></i></div>
			<p class="mk-connect-name">X (Twitter)</p>
			<p class="mk-connect-handle">@mannakampus</p>
			<a href="#" class="mk-connect-follow twitter">Follow</a>
		</div>

		<div class="mk-connect-card">
			<div class="mk-connect-icon youtube"><i class="fab fa-youtube-play"></i></div>
			<p class="mk-connect-name">YouTube</p>
			<p class="mk-connect-handle">@mannakampus</p>
			<a href="https://www.youtube.com/@MannaKampus" class="mk-connect-follow youtube">Follow</a>
		</div>

		<div class="mk-connect-card">
			<div class="mk-connect-icon tiktok"><i class="fab fa-tiktok"></i></div>
			<p class="mk-connect-name">TikTok</p>
			<p class="mk-connect-handle">@mannakampus</p>
			<a href="https://www.tiktok.com/@mannakampus" class="mk-connect-follow tiktok">Follow</a>
		</div>

	</div>
</section>
<!-- Connect Section End -->

<!-- Community Highlights Start -->
<?php

$stmt = $pdo->query(
    "SELECT title, platform, image, url, author, type 
     FROM sorotan_komunitas 
     WHERE is_active = 1 
     ORDER BY sort_order ASC, id DESC 
     LIMIT 8"
);
$social_highlights = $stmt->fetchAll(PDO::FETCH_ASSOC);

function mk_normalize_social_url($url) {
    $url = trim(html_entity_decode($url, ENT_QUOTES, 'UTF-8'));
    if (preg_match('#(?:href|cite|data-instgrm-permalink)=["\']([^"\']+)["\']#i', $url, $m)) {
        $url = $m[1];
    }
    $url = strtok($url, '?');
    return rtrim($url, '/');
}

function mk_get_embed_url($platform, $url) {
    $url = mk_normalize_social_url($url);
    switch ($platform) {
        case 'youtube':
            if (preg_match('#(?:shorts/|v=|youtu\.be/)([A-Za-z0-9_-]{6,})#', $url, $m)) {
                return 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=1';
            }
            break;
        case 'tiktok':
            if (preg_match('#/video/(\d+)#', $url, $m)) {
                return 'https://www.tiktok.com/embed/v2/' . $m[1];
            }
            break;
        case 'facebook':
            return 'https://www.facebook.com/plugins/video.php?href=' . urlencode($url) . '&show_text=false&autoplay=true';
        case 'instagram':
            return $url . '/embed';
    }
    return $url;
}
?>
<section class="mk-highlights">
	<div class="mk-highlights-wrap">
		<div class="mk-highlights-head">
			<div>
				<h2 class="mk-highlights-title">Sorotan Komunitas</h2>
				<p class="mk-highlights-sub">Lihat apa yang terjadi di Rumah Belanja Terpercaya Anda.</p>
			</div>
		</div>

		<div class="mk-highlights-grid">
			<?php foreach ($social_highlights as $highlight):
				$is_video = $highlight['type'] === 'video';
				$post_url = mk_normalize_social_url($highlight['url']);
				$embed_url = mk_get_embed_url($highlight['platform'], $post_url);
			?>
			<button type="button" class="mk-highlight-card mk-highlight-video-trigger"
				data-embed="<?php echo htmlspecialchars($embed_url, ENT_QUOTES, 'UTF-8'); ?>"
				data-title="<?php echo htmlspecialchars($highlight['title'], ENT_QUOTES, 'UTF-8'); ?>"
				data-url="<?php echo htmlspecialchars($post_url, ENT_QUOTES, 'UTF-8'); ?>"
				data-platform="<?php echo htmlspecialchars($highlight['platform'], ENT_QUOTES, 'UTF-8'); ?>"
				data-image="<?php echo BASE_URL . 'assets/uploads/' . htmlspecialchars($highlight['image'], ENT_QUOTES, 'UTF-8'); ?>"
			data-type="<?php echo htmlspecialchars($highlight['type'], ENT_QUOTES, 'UTF-8'); ?>">

				<div class="mk-highlight-media">
					<?php if (!empty($highlight['image'])): ?>
					<img src="<?php echo BASE_URL . 'assets/uploads/' . htmlspecialchars($highlight['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($highlight['title'], ENT_QUOTES, 'UTF-8'); ?>">
					<?php else: ?><div class="mk-highlight-media no-image"><i class="fa-brands fa-<?php echo htmlspecialchars($highlight['platform'], ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i><small>Lihat postingan <?php echo ucfirst(htmlspecialchars($highlight['platform'], ENT_QUOTES, 'UTF-8')); ?></small></div><?php endif; ?>
					<span class="mk-highlight-platform"><i class="fa-brands fa-<?php echo htmlspecialchars($highlight['platform'], ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i></span>
					<?php if ($is_video): ?><span class="mk-highlight-play"><i class="fa-solid fa-play" aria-hidden="true"></i></span><?php endif; ?>
				</div>
				<div class="mk-highlight-content">
					<h3 class="mk-highlight-title"><?php echo htmlspecialchars($highlight['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
					<p class="mk-highlight-author"><?php echo htmlspecialchars($highlight['author'], ENT_QUOTES, 'UTF-8'); ?></p>
				</div>

			</button>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Modal untuk pemutaran video -->
<div class="mk-video-modal" id="mkVideoModal" aria-hidden="true">
	<div class="mk-video-modal-backdrop" data-mk-close></div>
	<div class="mk-video-modal-box">
		<button type="button" class="mk-video-modal-close" data-mk-close aria-label="Tutup">&times;</button>
		<h4 class="mk-video-modal-title"></h4>
		<div class="mk-video-modal-frame"></div>
		<a class="mk-video-modal-original" href="#" target="_blank" rel="noopener noreferrer">Buka postingan asli</a>
	</div>
</div>

<script async src="https://www.instagram.com/embed.js"></script>
<script async src="https://www.tiktok.com/embed.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
	var modal = document.getElementById('mkVideoModal');
	var frame = modal.querySelector('.mk-video-modal-frame');
	var titleEl = modal.querySelector('.mk-video-modal-title');
	var originalEl = modal.querySelector('.mk-video-modal-original');

	function processSocialEmbed(platform) {
		var process = function () {
			if (platform === 'instagram' && window.instgrm && window.instgrm.Embeds) {
				window.instgrm.Embeds.process();
			} else if (platform === 'tiktok' && window.tiktokEmbed && window.tiktokEmbed.lib) {
				window.tiktokEmbed.lib.render();
			}
		};
		process();
		setTimeout(process, 300);
		setTimeout(process, 1000);
		setTimeout(process, 2500);
	}

	document.querySelectorAll('.mk-highlight-video-trigger').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var src = btn.getAttribute('data-embed');
			var title = btn.getAttribute('data-title');
			var url = btn.getAttribute('data-url');
			var type = btn.getAttribute('data-type');
			var platform = btn.getAttribute('data-platform');
			titleEl.textContent = title;
			originalEl.href = url;
			frame.classList.toggle('is-video', type === 'video' || platform === 'instagram' || platform === 'tiktok');
			frame.innerHTML = '';
			if (platform === 'instagram' || platform === 'tiktok') {
				var quote = document.createElement('blockquote');
				quote.className = platform === 'instagram' ? 'instagram-media' : 'tiktok-embed';
				quote.setAttribute(platform === 'instagram' ? 'data-instgrm-permalink' : 'cite', url.split('?')[0]);
				if (platform === 'tiktok') quote.setAttribute('data-video-id', (url.match(/\/video\/(\d+)/) || [])[1] || '');
				frame.appendChild(quote);
				processSocialEmbed(platform);
			} else if (type !== 'video') {
				var image = document.createElement('img');
				image.src = btn.getAttribute('data-image');
				image.alt = title;
				frame.appendChild(image);
			} else {
				var iframe = document.createElement('iframe');
				iframe.src = src;
				iframe.allow = 'autoplay; encrypted-media; picture-in-picture';
				iframe.allowFullscreen = true;
				frame.appendChild(iframe);
			}
			modal.classList.add('is-open');
		});
	});

	modal.querySelectorAll('[data-mk-close]').forEach(function (el) {
		el.addEventListener('click', function () {
			modal.classList.remove('is-open');
			frame.innerHTML = '';
		});
	});
});
</script>
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
