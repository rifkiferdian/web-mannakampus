<?php require_once('header.php'); ?>
<style>
	.promo-event-carousel .promo-event-visual {
	cursor: grab;
	touch-action: pan-y; /* biar swipe horizontal gak konflik sama scroll vertikal HP */
}
.promo-event-carousel .promo-event-visual:active {
	cursor: grabbing;
}

/* hint animasi kecil biar user sadar bisa digeser, muncul sekali lalu hilang */
.promo-event-carousel.promo-event-instant .promo-event-visual::after {
	content: "";
	position: absolute;
	inset: 0;
	pointer-events: none;
}
.promo-event-carousel .promo-event-visual img {
	-webkit-user-drag: none;
	user-drag: none;
	-webkit-user-select: none;
	user-select: none;
	pointer-events: none; /* biar event mouse "tembus" ke parent <a>, gak ke-capture sama <img>-nya sendiri */
}
/* News section - perkecil title & deskripsi */
.news-v1 .thumb + .text h3,
.news-v1 .text h3 {
	font-size: 16px !important;
	line-height: 1.4;
}
.news-v1 .text p,
.news-v1 .text {
	font-size: 13px !important;
	line-height: 1.6;
	color: #6c757d;
}

</style>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$total_recent_news_home_page = $row['total_recent_news_home_page'];
	$home_title_service          = $row['home_title_service'];
	$home_subtitle_service       = $row['home_subtitle_service'];
	$home_status_service         = $row['home_status_service'];
	$home_title_team_member      = $row['home_title_team_member'];
	$home_subtitle_team_member   = $row['home_subtitle_team_member'];
	$home_status_team_member     = $row['home_status_team_member'];
	$home_title_testimonial      = $row['home_title_testimonial'];
	$home_subtitle_testimonial   = $row['home_subtitle_testimonial'];
	$home_photo_testimonial      = $row['home_photo_testimonial'];
	$home_status_testimonial     = $row['home_status_testimonial'];
	$home_title_news             = $row['home_title_news'];
	$home_subtitle_news          = $row['home_subtitle_news'];
	$home_status_news            = $row['home_status_news'];
	$home_title_partner          = $row['home_title_partner'];
	$home_subtitle_partner       = $row['home_subtitle_partner'];
	$home_status_partner         = $row['home_status_partner'];
	$counter_1_title             = $row['counter_1_title'];
    $counter_1_value             = $row['counter_1_value'];
    $counter_2_title             = $row['counter_2_title'];
    $counter_2_value             = $row['counter_2_value'];
    $counter_3_title             = $row['counter_3_title'];
    $counter_3_value             = $row['counter_3_value'];
    $counter_4_title             = $row['counter_4_title'];
    $counter_4_value             = $row['counter_4_value'];
    $counter_photo               = $row['counter_photo'];
    $counter_status              = $row['counter_status'];
}

$statement = $pdo->prepare("SELECT photo, heading, content, button_text, button_url, position
							FROM tbl_slider
							WHERE status=?
							ORDER BY id ASC");
$statement->execute(array('Active'));
$home_sliders = $statement->fetchAll(PDO::FETCH_ASSOC);

if(!$home_sliders) {
	$home_sliders = array(
		array(
			'photo'       => 'manna-hero-market.png',
			'heading'     => 'Rumah Belanja Terpercaya',
			'content'     => 'Serving the community since 1985 with premium quality goods, professional service, and the warmest shopping experience in town.',
			'button_text' => 'Shop Now',
			'button_url'  => '#',
			'position'    => 'Left'
		)
	);
}

$statement = $pdo->prepare("SELECT *
							FROM tbl_promo_event
							WHERE status=? AND is_featured=1 AND end_date>=CURDATE() AND type<>?
							ORDER BY display_order ASC, start_date ASC, id DESC");
$statement->execute(array('Active', 'Promo Pembayaran'));
$home_promo_events = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $pdo->prepare("SELECT *
							FROM tbl_promo_event
							WHERE status=? AND is_featured=1 AND end_date>=CURDATE() AND type=?
							ORDER BY display_order ASC, start_date ASC, id DESC");
$statement->execute(array('Active', 'Promo Pembayaran'));
$home_payment_promos = $statement->fetchAll(PDO::FETCH_ASSOC);

// Ambil cabang pertama sebagai default untuk homepage
$stmt_default_cabang = $pdo->query("SELECT * FROM tbl_cabang ORDER BY id ASC LIMIT 1");
$default_cabang = $stmt_default_cabang->fetch(PDO::FETCH_ASSOC);

// Ambil 4 promo terbaru milik cabang tersebut
$weekly_promos = array();
if($default_cabang) {
	$stmt_weekly = $pdo->prepare("SELECT * FROM tbl_cabang_promo WHERE id_cabang = ? ORDER BY id DESC LIMIT 4");
	$stmt_weekly->execute([$default_cabang['id']]);
	$weekly_promos = $stmt_weekly->fetchAll(PDO::FETCH_ASSOC);
}

function home_promo_event_url($url, $slug) {
	$url = trim($url);
	if($url === '') {
		return BASE_URL.'promo-event/'.rawurlencode($slug);
	}
	if(preg_match('#^(?:https?:)?//#i', $url) || substr($url, 0, 1) === '#' || substr($url, 0, 1) === '/') {
		return $url;
	}
	return BASE_URL.ltrim($url, '/');
}

function home_promo_event_date($start_date, $end_date) {
	$months = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	$start = new DateTime($start_date);
	$end = new DateTime($end_date);
	if($start_date === $end_date) {
		return $start->format('j').' '.$months[(int)$start->format('n')].' '.$start->format('Y');
	}
	if($start->format('Y') === $end->format('Y')) {
		return $start->format('j').' '.$months[(int)$start->format('n')].' – '.$end->format('j').' '.$months[(int)$end->format('n')].' '.$end->format('Y');
	}
	return $start->format('j').' '.$months[(int)$start->format('n')].' '.$start->format('Y').' – '.$end->format('j').' '.$months[(int)$end->format('n')].' '.$end->format('Y');
}


?>

<!-- Hero Start -->
<div id="home-hero-slider" class="carousel slide carousel-fade mk-hero-carousel" data-ride="carousel" data-interval="6000">
	<?php if(count($home_sliders) > 1): ?>
	<ol class="carousel-indicators">
		<?php foreach ($home_sliders as $slider_index => $slider): ?>
		<li data-target="#home-hero-slider" data-slide-to="<?php echo $slider_index; ?>"<?php if($slider_index == 0) { echo ' class="active"'; } ?>></li>
		<?php endforeach; ?>
	</ol>
	<?php endif; ?>

	<div class="carousel-inner" role="listbox">
		<?php foreach ($home_sliders as $slider_index => $slider): ?>
		<?php
		$slider_position = in_array($slider['position'], array('Left', 'Center', 'Right')) ? strtolower($slider['position']) : 'left';
		$heading_words = preg_split('/\s+/u', trim($slider['heading']));
		$heading_highlight = '';
		if($heading_words && $heading_words[0] !== '') {
			$heading_highlight = array_pop($heading_words);
		}
		?>
		<section class="item hero-section mk-hero mk-hero-position-<?php echo $slider_position; ?><?php if($slider_index == 0) { echo ' active'; } ?>">
			<div class="hero-background" style="background-image:url('<?php echo htmlspecialchars(BASE_URL.'assets/uploads/'.$slider['photo'], ENT_QUOTES, 'UTF-8'); ?>');"></div>
			<div class="hero-overlay"></div>
			<div class="container">
				<div class="hero-content">
					<div class="hero-eyebrow">Dipercaya Secara Turun-Temurun</div>

					<?php if($heading_highlight !== ''): ?>
					<h1>
						<?php echo htmlspecialchars(implode(' ', $heading_words), ENT_QUOTES, 'UTF-8'); ?>
						<span><?php echo htmlspecialchars($heading_highlight, ENT_QUOTES, 'UTF-8'); ?></span>
					</h1>
					<?php endif; ?>

					<?php if(trim($slider['content']) !== ''): ?>
					<p><?php echo nl2br(htmlspecialchars($slider['content'], ENT_QUOTES, 'UTF-8')); ?></p>
					<?php endif; ?>

					<?php if(trim($slider['button_text']) !== ''): ?>
					<div class="hero-actions">
						<a href="<?php echo htmlspecialchars($slider['button_url'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-flat hero-btn-primary"><?php echo htmlspecialchars($slider['button_text'], ENT_QUOTES, 'UTF-8'); ?></a>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php endforeach; ?>
	</div>

	<?php if(count($home_sliders) > 1): ?>
	<a class="left carousel-control" href="#home-hero-slider" role="button" data-slide="prev">
		<i class="fa fa-angle-left" aria-hidden="true"></i>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#home-hero-slider" role="button" data-slide="next">
		<i class="fa fa-angle-right" aria-hidden="true"></i>
		<span class="sr-only">Next</span>
	</a>
	<?php endif; ?>
</div>
<!-- Hero End -->

<?php if($home_promo_events): ?>
<!-- Promo & Event Start -->
<section class="promo-events" id="promo-events">
	<img class="promo-event-decoration promo-event-decoration-left" src="<?php echo BASE_URL; ?>assets/images/promo-event-shopper-left.webp" alt="" aria-hidden="true">
	<img class="promo-event-decoration promo-event-decoration-right" src="<?php echo BASE_URL; ?>assets/images/promo-event-shopper-right.webp" alt="" aria-hidden="true">
	<!--<img class="promo-event-decoration promo-event-decoration-confetti" src="<?php echo BASE_URL; ?>assets/images/promo-event.png" alt="" aria-hidden="true">
	<img class="promo-event-decoration promo-event-decoration-confetti-confetti" src="<?php echo BASE_URL; ?>assets/images/promo-event2.png" alt="" aria-hidden="true">-->

	<div class="container">
		<div class="promo-events-head">
			<div>
				<span class="promo-events-eyebrow">Jangan Lewatkan</span>
				<h2>Promo &amp; Event Utama</h2>
				<p>Temukan program spesial dan kabar terbaru dari Manna Kampus.</p>
			</div>
		</div>

		<div id="promo-event-carousel" class="carousel promo-event-carousel promo-event-instant" data-ride="carousel" data-interval="9000">
			<div class="carousel-inner" role="listbox">
				<?php foreach($home_promo_events as $promo_index => $promo_event): ?>
				<?php $promo_url = home_promo_event_url($promo_event['button_url'], $promo_event['slug']); ?>
				<article class="item<?php if($promo_index === 0) { echo ' active'; } ?>">
					<div class="promo-event-card">
						<a href="<?php echo htmlspecialchars($promo_url, ENT_QUOTES, 'UTF-8'); ?>" class="promo-event-visual" aria-label="<?php echo htmlspecialchars($promo_event['title'], ENT_QUOTES, 'UTF-8'); ?>">
							<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo htmlspecialchars($promo_event['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($promo_event['title'], ENT_QUOTES, 'UTF-8'); ?>">
						</a>
						<div class="promo-event-info">
							<div class="promo-event-copy">
								<span class="promo-event-type"><?php echo htmlspecialchars($promo_event['type'], ENT_QUOTES, 'UTF-8'); ?></span>
								<h3><?php echo htmlspecialchars($promo_event['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
								<p><?php echo htmlspecialchars($promo_event['short_description'], ENT_QUOTES, 'UTF-8'); ?></p>
								<div class="promo-event-meta">
									<span><i class="fa fa-calendar"></i> <?php echo home_promo_event_date($promo_event['start_date'], $promo_event['end_date']); ?></span>
									<?php if(trim($promo_event['location']) !== ''): ?>
									<span><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($promo_event['location'], ENT_QUOTES, 'UTF-8'); ?></span>
									<?php endif; ?>
								</div>
							</div>
							<a href="<?php echo htmlspecialchars($promo_url, ENT_QUOTES, 'UTF-8'); ?>" class="promo-event-button">
								<?php echo htmlspecialchars($promo_event['button_text'], ENT_QUOTES, 'UTF-8'); ?> <i class="fa fa-arrow-right"></i>
							</a>
						</div>
					</div>
				</article>
				<?php endforeach; ?>
			</div>

			<?php if(count($home_promo_events) > 1): ?>
			<div class="promo-event-navigation">
				<div class="promo-event-progress">
					<div class="promo-event-counter">
						<strong class="promo-event-current">01</strong>
						<span>/</span>
						<span><?php echo str_pad(count($home_promo_events), 2, '0', STR_PAD_LEFT); ?></span>
					</div>
					<ol class="carousel-indicators">
						<?php foreach($home_promo_events as $promo_index => $promo_event): ?>
						<li data-target="#promo-event-carousel" data-slide-to="<?php echo $promo_index; ?>" aria-label="Tampilkan promo <?php echo $promo_index + 1; ?>"<?php if($promo_index === 0) { echo ' class="active"'; } ?>></li>
						<?php endforeach; ?>
					</ol>
				</div>
				<div class="promo-event-arrows">
					<a href="#promo-event-carousel" role="button" data-slide="prev" aria-label="Promo sebelumnya"><i class="fa fa-angle-left"></i></a>
					<a href="#promo-event-carousel" role="button" data-slide="next" aria-label="Promo berikutnya"><i class="fa fa-angle-right"></i></a>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<!-- Promo & Event End -->
<?php endif; ?>

<?php if($home_payment_promos): ?>
<!-- Payment Promo Start -->
<section class="payment-promos" id="payment-promos">
	<div class="container">
		<div class="payment-promos-head">
			<h2>Promo Pembayaran</h2>
		</div>

		<div class="payment-promo-carousel owl-carousel">
			<?php foreach($home_payment_promos as $payment_promo): ?>
			<article class="payment-promo-card">
				<a class="payment-promo-image payment-promo-image-popup" href="<?php echo BASE_URL; ?>assets/uploads/<?php echo htmlspecialchars($payment_promo['image'], ENT_QUOTES, 'UTF-8'); ?>" aria-label="Perbesar <?php echo htmlspecialchars($payment_promo['title'], ENT_QUOTES, 'UTF-8'); ?>">
					<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo htmlspecialchars($payment_promo['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($payment_promo['title'], ENT_QUOTES, 'UTF-8'); ?>">
					<span class="payment-promo-zoom"><i class="fa fa-search-plus"></i></span>
				</a>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<!-- Payment Promo End -->
<?php endif; ?>

<!-- Weekly Offers Start -->
<?php if(!empty($weekly_promos)): ?>
<!-- Weekly Offers Start -->
<section class="weekly-offers">
	<div class="container">
		<div class="weekly-offers-head">
			<div>
				<h2>Penawaran Spesial Mingguan</h2>
				<p>Jangan lewatkan produk pilihan terbaik dari <?php echo htmlspecialchars($default_cabang['nama_cabang'], ENT_QUOTES, 'UTF-8'); ?>.</p>
			</div>
			<a href="<?php echo BASE_URL; ?>explor.php?id=<?php echo $default_cabang['id']; ?>" class="weekly-offers-link">Lihat selengkapnya <i class="fa fa-arrow-right"></i></a>
		</div>

		<div class="weekly-offers-grid">
			<?php
				// Helper ambil url foto, fallback ke default kalau kosong
				function weekly_offer_photo($foto) {
					return !empty($foto) ? BASE_URL.'assets/uploads/'.$foto : BASE_URL.'assets/uploads/default-product.jpg';
				}
				$promo_url = BASE_URL.'explor.php?id='.$default_cabang['id'];
			?>

			<!-- Slot 1: Card besar kiri -->
			<?php if(isset($weekly_promos[0])): $p0 = $weekly_promos[0]; ?>
			<a href="<?php echo $promo_url; ?>" class="offer-card offer-card-featured" style="background-image:url(<?php echo weekly_offer_photo($p0['foto']); ?>);">
				<div class="offer-shade"></div>
				<div class="offer-copy">
					<?php if(!empty($p0['badge'])): ?>
					<span class="offer-badge"><?php echo htmlspecialchars($p0['badge'], ENT_QUOTES, 'UTF-8'); ?></span>
					<?php endif; ?>
					<h3><?php echo htmlspecialchars($p0['nama_produk'], ENT_QUOTES, 'UTF-8'); ?></h3>
					<p>Rp <?php echo number_format($p0['harga_promo'], 0, ',', '.'); ?><?php if(!empty($p0['harga_coret']) && $p0['harga_coret'] > $p0['harga_promo']): ?> <s>Rp <?php echo number_format($p0['harga_coret'], 0, ',', '.'); ?></s><?php endif; ?></p>
				</div>
			</a>
			<?php endif; ?>

			<div class="weekly-offers-side">
				<!-- Slot 2: Card lebar kanan atas -->
				<?php if(isset($weekly_promos[1])): $p1 = $weekly_promos[1]; ?>
				<a href="<?php echo $promo_url; ?>" class="offer-card offer-card-wide" style="background-image:url(<?php echo weekly_offer_photo($p1['foto']); ?>);">
					<div class="offer-copy offer-copy-dark">
						<h3><?php echo htmlspecialchars($p1['nama_produk'], ENT_QUOTES, 'UTF-8'); ?></h3>
						<p>Rp <?php echo number_format($p1['harga_promo'], 0, ',', '.'); ?></p>
					</div>
				</a>
				<?php endif; ?>

				<div class="weekly-offers-small">
					<!-- Slot 3: Card kecil dengan gambar (sama seperti slot 4) -->
					<?php if(isset($weekly_promos[2])): $p2 = $weekly_promos[2]; ?>
					<a href="<?php echo $promo_url; ?>" class="offer-card offer-card-small-image" style="background-image:url(<?php echo weekly_offer_photo($p2['foto']); ?>);">
						<span><?php echo htmlspecialchars($p2['nama_produk'], ENT_QUOTES, 'UTF-8'); ?></span>
					</a>
					<?php endif; ?>

					<!-- Slot 4: Card kecil dengan gambar -->
					<?php if(isset($weekly_promos[3])): $p3 = $weekly_promos[3]; ?>
					<a href="<?php echo $promo_url; ?>" class="offer-card offer-card-small-image" style="background-image:url(<?php echo weekly_offer_photo($p3['foto']); ?>);">
						<span><?php echo htmlspecialchars($p3['nama_produk'], ENT_QUOTES, 'UTF-8'); ?></span>
					</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Weekly Offers End -->
<?php endif; ?>

<?php if($home_status_team_member == 'Show'): ?>
<!-- Penghargaan MannaKampus Start -->
<?php
	// Ambil data penghargaan (masih dari tabel tbl_team_member, dipakai sebagai tabel penghargaan)
	$statement = $pdo->prepare("SELECT
									t1.id,
									t1.name,
									t1.slug,
									t1.photo,
									t1.banner,
									t1.degree,
									t1.detail,
									t2.designation_name
								FROM tbl_team_member t1
								JOIN tbl_designation t2 ON t1.designation_id = t2.designation_id
								WHERE t1.status = ?
								ORDER BY t1.id ASC");
	$statement->execute(array('Active'));
	$awd_rows = $statement->fetchAll(PDO::FETCH_ASSOC);

	$awd_list = array();
	foreach($awd_rows as $awd_row) {
		// Tahun diambil dari bagian depan kolom "degree", mis. "2025 - Tingkat Nasional"
		$awd_year = '';
		if(preg_match('/(\d{4})/', $awd_row['degree'], $awd_year_match)) {
			$awd_year = $awd_year_match[1];
		}

		// Gambar utama pakai "banner", fallback ke "photo"
		$awd_image = !empty($awd_row['banner']) ? $awd_row['banner'] : $awd_row['photo'];

		// Deskripsi singkat dari "detail" (strip HTML, potong karakter)
		$awd_desc = trim(strip_tags($awd_row['detail']));
		$awd_desc = preg_replace('/\s+/', ' ', $awd_desc);
		if(function_exists('mb_strlen') && mb_strlen($awd_desc) > 140) {
			$awd_desc = mb_substr($awd_desc, 0, 140).'…';
		} elseif(strlen($awd_desc) > 140) {
			$awd_desc = substr($awd_desc, 0, 140).'…';
		}

		$awd_list[] = array(
			'title'    => $awd_row['name'],
			'category' => $awd_row['designation_name'],
			'year'     => $awd_year,
			'image'    => BASE_URL.'assets/uploads/'.$awd_row['photo'],
			'banner'   => BASE_URL.'assets/uploads/'.$awd_image,
			'desc'     => $awd_desc,
			'url'      => BASE_URL.URL_TEAM.$awd_row['slug'],
		);
	}
?>
<?php if(!empty($awd_list)): ?>
<style>
.awd-section{
	position:relative;
	background:radial-gradient(120% 160% at 78% 35%, rgba(240,169,54,.10) 0%, rgba(240,169,54,0) 55%), radial-gradient(140% 160% at 10% 0%, #1a130c 0%, #100b07 45%, #0a0705 100%);
	padding:90px 200px;
	overflow:hidden;
	color:#f3efe9;
}
.awd-layout{
	display:grid;
	grid-template-columns:0.85fr 0.85fr 1fr 0.9fr;
	gap:34px;
	align-items:center;
	position:relative;
	z-index:1;
}

/* Kolom 1: intro & pagination */
.awd-eyebrow{
	display:flex;
	align-items:center;
	gap:10px;
	font-size:15px;
	font-weight:700;
	letter-spacing:.14em;
	text-transform:uppercase;
	color: #f0a936;
	margin-bottom:16px;
}
.awd-eyebrow::before{
	content:"";
	display:inline-block;
	width:20px;
	height:1px;
	background:#f0a936;
}
.awd-title{
	font-size:30px;
	font-weight:700;
	line-height:1.28;
	color:#fff;
	margin:0 0 16px;
}
.awd-desc{
	font-size:14.5px;
	line-height:1.75;
	color:rgba(243,239,233,.62);
	margin:0 0 30px;
	max-width:320px;
}
.awd-pager{
	display:flex;
	align-items:center;
	gap:18px;
}
.awd-pager-count{
	font-size:14px;
	font-weight:600;
	color:rgba(243,239,233,.55);
	letter-spacing:.03em;
}
.awd-pager-count #awdCurrentNum{
	color:#fff;
}
.awd-pager-btn{
	width:42px;
	height:42px;
	border-radius:50%;
	display:inline-flex;
	align-items:center;
	justify-content:center;
	border:1px solid rgba(243,239,233,.18);
	background:transparent;
	color:rgba(243,239,233,.5);
	cursor:pointer;
	transition:background .2s ease, border-color .2s ease, color .2s ease, transform .2s ease;
	flex:0 0 auto;
}
.awd-pager-btn:hover{
	border-color:rgba(240,169,54,.5);
	color:#f0a936;
}
.awd-pager-btn-active{
	background:#f0a936;
	border-color:#f0a936;
	color:#171008;
}
.awd-pager-btn-active:hover{
	background:#f0a936;
	color:#171008;
	transform:translateX(2px);
}

.awd-viewall{
	display:inline-flex;
	align-items:center;
	gap:10px;
	margin-top:22px;
	padding:12px 22px;
	border-radius:999px;
	border:1px solid rgba(243,239,233,.22);
	color:#f3efe9;
	font-weight:600;
	font-size:14px;
	text-decoration:none;
	transition:border-color .2s ease, background .2s ease, color .2s ease, gap .2s ease;
}
.awd-viewall:hover{
	border-color:#f0a936;
	background:rgba(240,169,54,.08);
	color:#fff;
	text-decoration:none;
	gap:14px;
}
.awd-viewall i{
	font-size:12px;
}

/* Kolom 2: media trophy */
.awd-visual{
	position:relative;
	display:flex;
	align-items:center;
	justify-content:center;
	min-height:230px;
}
.awd-visual-glow{
	position:absolute;
	inset:6%;
	border-radius:50%;
	background:radial-gradient(circle, rgba(240,169,54,.5) 0%, rgba(240,169,54,0) 70%);
	filter:blur(4px);
	pointer-events:none;
}
.awd-visual img{
	position:relative;
	max-width:100%;
	max-height:260px;
	object-fit:contain;
	filter:drop-shadow(0 18px 30px rgba(0,0,0,.55));
	transition:opacity .25s ease, transform .25s ease;
}

/* Kolom 3: detail penghargaan aktif */
.awd-detail-top{
	display:flex;
	align-items:center;
	gap:12px;
	margin-bottom:14px;
}
.awd-detail-category{
	display:flex;
	align-items:center;
	gap:10px;
	font-size:13px;
	font-weight:600;
	text-transform:uppercase;
	letter-spacing:.06em;
	color:#f0a936;
	margin-bottom:0; /* margin dipindah ke .awd-detail-top */
}
.awd-detail-year{
	display:inline-flex;
	align-items:center;
	gap:8px;
	font-size:13px;
	font-weight:600;
	color:#f0a936; /* WARNA TAHUN — ubah kode hex ini untuk ganti warna */
}
.awd-detail-year::before{
	content:"";
	display:inline-block;
	width:26px;
	height:1px;
	background:rgba(240,169,54,.6);
}
.awd-detail-title{
	font-size:26px;
	font-weight:700;
	line-height:1.25;
	color:#fff;
	margin:0 0 14px;
}
.awd-detail-desc{
	font-size:14.5px;
	line-height:1.75;
	color:rgba(243,239,233,.62);
	margin:0 0 26px;
	max-width:360px;
}
.awd-detail-btn{
	display:inline-flex;
	align-items:center;
	gap:10px;
	padding:12px 22px;
	border-radius:999px;
	border:1px solid rgba(243,239,233,.22);
	color: #f3efe9;
	font-weight:600;
	font-size:14px;
	text-decoration:none;
	transition:border-color .2s ease, background .2s ease, color .2s ease;
}
.awd-detail-btn:hover{
	border-color:#f0a936;
	background:rgba(240,169,54,.08);
	color:#fff;
	text-decoration:none;
}

/* Kolom 4: daftar penghargaan */
.awd-list{
	background:rgba(255,255,255,.035);
	border:1px solid rgba(255,255,255,.08);
	border-radius:20px;
	padding:10px;
}
.awd-list-item{
	display:flex;
	align-items:center;
	gap:14px;
	width:100%;
	background:transparent;
	border:none;
	border-radius:14px;
	padding:13px 12px;
	text-align:left;
	cursor:pointer;
	transition:background .2s ease;
}
.awd-list-item:hover{
	background:rgba(255,255,255,.04);
}
.awd-list-item + .awd-list-item{
	margin-top:2px;
}
.awd-list-num{
	flex:0 0 auto;
	font-size:13px;
	font-weight:700;
	color:rgba(243,239,233,.32);
	width:20px;
}
.awd-list-icon{
	flex:0 0 auto;
	width:30px;
	height:30px;
	border-radius:50%;
	display:inline-flex;
	align-items:center;
	justify-content:center;
	background:rgba(255,255,255,.06);
	color:rgba(243,239,233,.35);
	font-size:13px;
}
.awd-list-title{
	display:block;
	font-size:14px;
	font-weight:600;
	color:rgba(255,255,255,.85);
	margin-bottom:2px;
	line-height:1.3;
}
.awd-list-meta{
	display:block;
	font-size:11.5px;
	color:rgba(243,239,233,.45);
}
.awd-list-item.active .awd-list-num,
.awd-list-item.active .awd-list-icon{
	color:#f0a936;
}
.awd-list-item.active .awd-list-icon{
	background:rgba(240,169,54,.14);
}
.awd-list-item.active .awd-list-title{
	color:#fff;
}

@media (max-width:1199px){
	.awd-layout{grid-template-columns:1fr 1fr;grid-template-areas:"intro visual" "detail detail" "list list";row-gap:36px;}
	.awd-eyebrow, .awd-title, .awd-desc, .awd-pager{grid-column:auto;}
}
@media (max-width:767px){
	.awd-section{padding:64px 0;}
	.awd-layout{grid-template-columns:1fr;}
	.awd-desc{max-width:none;}
	.awd-detail-desc{max-width:none;}
}
</style>
<section class="awd-section" id="penghargaan">
	<div class="container">
		<div class="awd-layout">

			<!-- Kolom 1: judul section & navigasi -->
			<div class="awd-intro">
				<span class="awd-eyebrow">Apresiasi & Pencapaian</span>
				<h2 class="awd-title"><?php echo $home_title_team_member; ?></h2>
				<p class="awd-desc"><?php echo $home_subtitle_team_member; ?></p>
				<div class="awd-pager">
					<button type="button" class="awd-pager-btn" id="awdPrev" aria-label="Penghargaan sebelumnya"><i class="fa fa-arrow-left"></i></button>
					<span class="awd-pager-count"><span id="awdCurrentNum">01</span> / <span id="awdTotalNum"><?php echo str_pad(count($awd_list), 2, '0', STR_PAD_LEFT); ?></span></span>
					<button type="button" class="awd-pager-btn awd-pager-btn-active" id="awdNext" aria-label="Penghargaan berikutnya"><i class="fa fa-arrow-right"></i></button>
				</div>
				<a href="award-all.php" class="awd-viewall">Lihat Semua Penghargaan <i class="fa fa-arrow-right"></i></a>
			</div>

			<!-- Kolom 2: foto piala yang sedang disorot -->
			<div class="awd-visual">
				<div class="awd-visual-glow"></div>
				<img id="awdFeaturedImg" src="<?php echo htmlspecialchars($awd_list[0]['banner'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($awd_list[0]['title'], ENT_QUOTES, 'UTF-8'); ?>">
			</div>

			<!-- Kolom 3: detail penghargaan yang sedang disorot -->
			<div class="awd-detail">
				<div class="awd-detail-top">
					<span class="awd-detail-category" id="awdFeaturedCategory"><?php echo htmlspecialchars($awd_list[0]['category'], ENT_QUOTES, 'UTF-8'); ?></span>
					<span class="awd-detail-year" id="awdFeaturedYear"><?php echo htmlspecialchars($awd_list[0]['year'], ENT_QUOTES, 'UTF-8'); ?></span>
				</div>
				<h3 class="awd-detail-title" id="awdFeaturedTitle"><?php echo htmlspecialchars($awd_list[0]['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
				<p class="awd-detail-desc" id="awdFeaturedDesc"><?php echo htmlspecialchars($awd_list[0]['desc'], ENT_QUOTES, 'UTF-8'); ?></p>
				<!--<a href="<?php echo htmlspecialchars($awd_list[0]['url'], ENT_QUOTES, 'UTF-8'); ?>" class="awd-detail-btn" id="awdFeaturedLink">Selengkapnya <i class="fa fa-arrow-right"></i></a>-->
			</div>

			<!-- Kolom 4: daftar seluruh penghargaan -->
			<div class="awd-list" id="awdList">
				<?php foreach($awd_list as $awd_index => $awd_item): ?>
				<button type="button"
						class="awd-list-item<?php if($awd_index === 0) { echo ' active'; } ?>"
						data-index="<?php echo $awd_index; ?>"
						data-image="<?php echo htmlspecialchars($awd_item['banner'], ENT_QUOTES, 'UTF-8'); ?>"
						data-title="<?php echo htmlspecialchars($awd_item['title'], ENT_QUOTES, 'UTF-8'); ?>"
						data-category="<?php echo htmlspecialchars($awd_item['category'], ENT_QUOTES, 'UTF-8'); ?>"
						data-year="<?php echo htmlspecialchars($awd_item['year'], ENT_QUOTES, 'UTF-8'); ?>"
						data-desc="<?php echo htmlspecialchars($awd_item['desc'], ENT_QUOTES, 'UTF-8'); ?>"
						data-url="<?php echo htmlspecialchars($awd_item['url'], ENT_QUOTES, 'UTF-8'); ?>">
					<span class="awd-list-num"><?php echo str_pad($awd_index + 1, 2, '0', STR_PAD_LEFT); ?></span>
					<span class="awd-list-icon"><i class="fa fa-trophy"></i></span>
					<span>
						<span class="awd-list-title"><?php echo htmlspecialchars($awd_item['title'], ENT_QUOTES, 'UTF-8'); ?></span>
						<span class="awd-list-meta"><?php echo htmlspecialchars($awd_item['category'], ENT_QUOTES, 'UTF-8'); ?><?php if($awd_item['year'] !== ''): ?> &bull; <?php echo htmlspecialchars($awd_item['year'], ENT_QUOTES, 'UTF-8'); ?><?php endif; ?></span>
					</span>
				</button>
				<?php endforeach; ?>
			</div>

		</div>
	</div>
</section>
<script>
(function(){
	var listItems = Array.prototype.slice.call(document.querySelectorAll('#awdList .awd-list-item'));
	var featuredImg = document.getElementById('awdFeaturedImg');
	var featuredTitle = document.getElementById('awdFeaturedTitle');
	var featuredCategory = document.getElementById('awdFeaturedCategory');
	var featuredYear = document.getElementById('awdFeaturedYear');
	var featuredDesc = document.getElementById('awdFeaturedDesc');
	var currentNum = document.getElementById('awdCurrentNum');
	var prevBtn = document.getElementById('awdPrev');
	var nextBtn = document.getElementById('awdNext');
	var total = listItems.length;
	var current = 0;

	function pad(n){
		n = n + 1;
		return n < 10 ? '0' + n : '' + n;
	}

	function render(index){
		var item = listItems[index];
		if(!item){ return; }
		current = index;

		featuredImg.style.opacity = 0;
		setTimeout(function(){
			featuredImg.setAttribute('src', item.getAttribute('data-image'));
			featuredImg.setAttribute('alt', item.getAttribute('data-title'));
			featuredImg.style.opacity = 1;
		}, 120);

		featuredTitle.textContent = item.getAttribute('data-title');
		featuredCategory.textContent = item.getAttribute('data-category');
		featuredYear.textContent = item.getAttribute('data-year');
		featuredDesc.textContent = item.getAttribute('data-desc');
		currentNum.textContent = pad(index);

		listItems.forEach(function(el){ el.classList.remove('active'); });
		item.classList.add('active');
	}

	listItems.forEach(function(item, index){
		item.addEventListener('click', function(){ render(index); });
	});

	prevBtn.addEventListener('click', function(){
		render((current - 1 + total) % total);
	});
	nextBtn.addEventListener('click', function(){
		render((current + 1) % total);
	});
})();
</script>
<?php endif; ?>
<!-- Penghargaan MannaKampus End -->
<?php endif; ?>


<?php if($home_status_news == 'Show'): ?>
<!-- News Start -->
<section class="news-v1">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading wow fadeInUp">
					<h2><?php echo $home_title_news; ?></h2>
					<p><?php echo $home_subtitle_news; ?></p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				
				<!-- News Carousel Start -->
				<div class="news-carousel">

					<?php
					$i=0;
					$statement = $pdo->prepare("SELECT * FROM tbl_news ORDER BY news_id DESC");
					$statement->execute();
					$result = $statement->fetchAll();							
					foreach ($result as $row) {
						$i++;
						if($i>$total_recent_news_home_page) {break;}
						?>
						<div class="item wow fadeInUp">
							<div class="thumb">
								<div class="photo" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>);"></div>
							</div>
						<?php
							// Bersihkan HTML dan potong deskripsi biar tidak terlalu panjang
							$news_desc_plain = trim(strip_tags($row['news_content_short']));
							$news_desc_plain = preg_replace('/\s+/', ' ', $news_desc_plain);

							$news_desc_limit = 90; // ubah angka ini kalau mau lebih panjang/pendek
							if (function_exists('mb_strlen') && mb_strlen($news_desc_plain) > $news_desc_limit) {
								$news_desc_short = mb_substr($news_desc_plain, 0, $news_desc_limit) . '...';
							} elseif (strlen($news_desc_plain) > $news_desc_limit) {
								$news_desc_short = substr($news_desc_plain, 0, $news_desc_limit) . '...';
							} else {
								$news_desc_short = $news_desc_plain;
							}
						?>
						<div class="text">
							<h3><a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>"><?php echo $row['news_title']; ?></a></h3>
							<p><?php echo htmlspecialchars($news_desc_short, ENT_QUOTES, 'UTF-8'); ?></p>
						</div>
						</div>
						<?php
					}
					?>
					
				</div>
				<!-- News Carousel End -->

			</div>
		</div>
	</div>
</section>
<!-- News End -->
<?php endif; ?>





<?php if($home_status_testimonial == 'Show'): ?>
<!-- Testimonial Start -->
<section class="testimonial-v1" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads/<?php echo $home_photo_testimonial; ?>);">
	<div class="overlay"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading">
					<h2><?php echo $home_title_testimonial; ?></h2>
					<p><?php echo $home_subtitle_testimonial; ?></p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				
				<!-- Testimonial Carousel Start -->
				<div class="testimonial-carousel">
					<?php
					$statement = $pdo->prepare("SELECT * FROM tbl_testimonial ORDER BY id ASC");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
					foreach ($result as $row) {
						?>
						<div class="item">
							<div class="testimonial-wrapper">								
								<div class="content">									
									<div class="author">
										<div class="photo">
											<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['name']; ?>">
										</div>
										<div class="text">
											<h3><?php echo $row['name']; ?></h3>
											<h4><?php echo $row['designation']; ?> 
											<?php if($row['company']!=''): ?>
											<span>(<?php echo $row['company']; ?>)</span>
											<?php endif; ?>
											</h4>
										</div>
									</div>	
									<div class="comment">
										<p>
											<?php echo nl2br($row['comment']); ?>
										</p>
										<div class="icon"></div>
									</div>									
								</div>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<!-- Testimonial Carousel End -->

			</div>
		</div>
	</div>
</section>
<!-- Testimonial End -->
<?php endif; ?>


	


<?php if($home_status_partner == 'Show'): ?>
<!-- Partner Start -->
<section class="partner-v1">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading">
					<h2><?php echo $home_title_partner; ?></h2>
					<p><?php echo $home_subtitle_partner; ?></p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="partner-carousel">
					<?php
					$statement = $pdo->prepare("SELECT * FROM tbl_partner ORDER BY id ASC");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
					foreach ($result as $row) {
						?>
						<div class="item">
							<div class="inner">
								<?php if($row['url']==''): ?>
									<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['name']; ?>">
								<?php else: ?>
									<a href="<?php echo $row['url']; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['name']; ?>"></a>
								<?php endif; ?>
								
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Partner End -->
<?php endif; ?>

<?php require_once('footer.php'); ?>