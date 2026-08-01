<?php require_once('header.php'); ?>

<?php

function format_tanggal_indo($date) {
	$bulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli',
				   'Agustus','September','Oktober','November','Desember');
	$ts = strtotime($date);
	return date('d', $ts).' '.$bulan[(int)date('n', $ts)].' '.date('Y', $ts);
}

// Palet warna ribbon/badge kategori, berputar berdasarkan category_id
$category_palette = array('#E8792E', '#5C8C5E', '#D9663F', '#5A4634', '#3E7C8C');

$keyword  = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$cat_slug = isset($_GET['cat']) ? trim($_GET['cat']) : '';

// Ambil daftar kategori untuk pill filter
$categories = $pdo->query("SELECT category_id, category_name, category_slug FROM tbl_category ORDER BY category_name ASC")->fetchAll(PDO::FETCH_ASSOC);

$where  = "";
$params = array();
$conditions = array();

if ($keyword !== '') {
	$conditions[] = "t1.news_title LIKE ?";
	$params[]     = '%'.$keyword.'%';
}
if ($cat_slug !== '') {
	$conditions[] = "t2.category_slug = ?";
	$params[]     = $cat_slug;
}
if (!empty($conditions)) {
	$where = "WHERE ".implode(' AND ', $conditions);
}

/* ---------------------------------------------------------------------
   Pagination
--------------------------------------------------------------------- */
$per_page = 6;
$page     = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset   = ($page - 1) * $per_page;

$count_sql = "SELECT COUNT(*) FROM tbl_news t1 JOIN tbl_category t2 ON t1.category_id = t2.category_id $where";
$statement = $pdo->prepare($count_sql);
$statement->execute($params);
$total_news  = (int)$statement->fetchColumn();
$total_pages = max(1, (int)ceil($total_news / $per_page));

/* CATATAN:
   Kolom valid_until dan catalog_pdf di bawah bersifat OPSIONAL.
   Jika kolom ini belum ada di tabel tbl_news, hapus dari SELECT
   dan kode akan otomatis fallback (lihat bagian render kartu di bawah). */
$list_sql = "SELECT t1.news_id, t1.news_title, t1.news_slug, t1.news_content,
					t1.news_date, t1.photo, t1.category_id, t1.total_view,
					t2.category_name, t2.category_slug
			 FROM tbl_news t1
			 JOIN tbl_category t2 ON t1.category_id = t2.category_id
			 $where
			 ORDER BY t1.news_date DESC
			 LIMIT $per_page OFFSET $offset";
$statement = $pdo->prepare($list_sql);
$statement->execute($params);
$news_list = $statement->fetchAll(PDO::FETCH_ASSOC);

// Helper untuk mempertahankan query string saat pindah halaman pagination
function mk_page_url($p, $keyword, $cat_slug) {
	$qs = 'page='.$p;
	if ($keyword !== '')  { $qs .= '&keyword='.urlencode($keyword); }
	if ($cat_slug !== '') { $qs .= '&cat='.urlencode($cat_slug); }
	return '?'.$qs;
}
?>

<style>
.mk-catalog-list{ --mk-orange:#E8792E; --mk-orange-dark:#C9611F; --mk-text:#2E2620; --mk-muted:#8A7F73; --mk-border:#EDE4D8; }
.mk-catalog-list a{ text-decoration:none; }

/* ---------------- Hero Section ---------------- */
.mk-catalog-hero{ background:#F7F5F1; padding:60px 24px 70px; text-align:left; }
.mk-catalog-hero .container{ max-width:1240px; margin:0 auto; padding:0 8px; }
.mk-catalog-hero-tag{ display:inline-block; background:#E8792E; color: #050505; font-size:1.0rem; font-weight:700; letter-spacing:.04em; text-transform:uppercase; padding:6px 14px; border-radius:10px; margin-bottom:18px; }
.mk-catalog-hero-title{ font-size:2.4rem; font-weight:800; color:#1F1B17; margin:0 0 16px; line-height:1.3; max-width:640px; }
.mk-catalog-hero-title span{ color:#E8792E; }
.mk-catalog-hero-sub{ font-size:1rem; color:#7A6F63; max-width:560px; margin:0; line-height:1.65; }

.mk-catalog-hero-title{ font-size:3.25rem; font-weight:800; color:#1F1B17; margin:0 0 16px; line-height:1.3; max-width:640px; }
.mk-catalog-hero-title span{ color:#E8792E; }
.mk-catalog-hero-sub{ font-size:1.5rem; color:#7A6F63; max-width:560px; margin:0; line-height:1.65; }atalog-hero-sub{ font-size:2.0rem; color:#7A6F63; max-width:640px; margin:0 auto; line-height:1.6; }

/* ---------------- Kotak "Pilih Cabang Terdekat" ---------------- */
.mk-branch-box{
	max-width: 1100px;
	margin: -46px auto 0;
	background:#fff;
	border-radius:14px;
	box-shadow:0 14px 34px rgba(74,53,39,0.1);
	padding:22px 30px;
	display:flex;
	align-items:center;
	justify-content:space-between;
	gap:20px;
	flex-wrap:wrap;
	position:relative;
	z-index:2;
}
.mk-branch-box-left{ display:flex; align-items:center; gap:14px; }
.mk-branch-box-icon{
	width:44px; height:44px; flex-shrink:0;
	background:var(--mk-orange); color:#fff;
	border-radius:10px;
	display:flex; align-items:center; justify-content:center;
	font-size:1.1rem;
}
.mk-branch-box-title{ font-weight:700; color:var(--mk-text); font-size:1rem; margin:0 0 2px; }
.mk-branch-box-sub{ font-size:.85rem; color:var(--mk-muted); margin:0; }
.mk-branch-box select{
	min-width:220px;
	padding:11px 16px;
	border-radius:8px;
	border:1px solid var(--mk-border);
	color:var(--mk-text);
	font-size:.9rem;
	background:#fff;
}
@media (max-width:576px){
	.mk-branch-box{ flex-direction:column; align-items:stretch; text-align:center; margin-top:-30px; }
	.mk-branch-box-left{ flex-direction:column; text-align:center; }
	.mk-branch-box select{ width:100%; }
}

/* ---------------- Container list katalog ---------------- */
.mk-catalog-list .container{
	max-width: 1240px;
	margin: 0 auto;
	padding: 56px 32px;
}

.mk-catalog-header{ display:flex; align-items:baseline; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:10px; }
.mk-catalog-heading{ font-size:1.6rem; font-weight:800; color:var(--mk-text); margin:0; }
.mk-catalog-archive{ font-size:.9rem; font-weight:600; color:var(--mk-orange); }
.mk-catalog-archive:hover{ color:var(--mk-orange-dark); }

.mk-catalog-grid{ display:grid; grid-template-columns:repeat(3, 1fr); gap:26px; margin-bottom:40px; }
@media (max-width:991px){ .mk-catalog-grid{ grid-template-columns:1fr 1fr; } }
@media (max-width:576px){ .mk-catalog-grid{ grid-template-columns:1fr; } }

.mk-news-card{ background:#fff; border:1px solid var(--mk-border); border-radius:14px; overflow:hidden; display:flex; flex-direction:column; transition:box-shadow .2s ease, transform .2s ease; }
.mk-news-card:hover{ box-shadow:0 12px 28px rgba(74,53,39,0.12); transform:translateY(-3px); }

.mk-news-card-img{ position:relative; aspect-ratio: 3 / 4; background-size:cover; background-position:center; background-color:#f2ede6; }

/* Badge kategori bentuk ribbon/pita, menempel di pojok kiri atas gambar */
.mk-news-card-badge{
	position:absolute; top:14px; left:-6px;
	color:#fff; font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.03em;
	padding:6px 16px 6px 20px;
	clip-path: polygon(0 0, 100% 0, 92% 50%, 100% 100%, 0 100%);
	box-shadow:0 2px 6px rgba(0,0,0,0.15);
}

.mk-news-card-body{ padding:18px 20px 20px; display:flex; flex-direction:column; flex:1; }
.mk-news-card-title{ font-size:1.02rem; font-weight:700; line-height:1.4; margin:0 0 10px; color:var(--mk-text); }
.mk-news-card-title a{ color:inherit; }
.mk-news-card-title a:hover{ color:var(--mk-orange); }

.mk-news-card-period{ font-size:.82rem; color:var(--mk-muted); margin:0 0 16px; display:flex; align-items:center; gap:6px; }
.mk-news-card-period i{ color:var(--mk-orange); }

.mk-news-card-actions{ display:flex; gap:10px; margin-top:auto; }
.mk-btn-catalog, .mk-btn-pdf{
	flex:1; text-align:center; font-size:.85rem; font-weight:600;
	padding:10px 12px; border-radius:8px; transition:all .2s ease;
	display:inline-flex; align-items:center; justify-content:center; gap:6px;
}
.mk-btn-catalog{ background:var(--mk-orange); color:#fff; border:1px solid var(--mk-orange); }
.mk-btn-catalog:hover{ background:var(--mk-orange-dark); border-color:var(--mk-orange-dark); color:#fff; }
.mk-btn-pdf{ background:#fff; color:var(--mk-text); border:1px solid var(--mk-border); }
.mk-btn-pdf:hover{ border-color:var(--mk-orange); color:var(--mk-orange); }

.mk-catalog-empty{ grid-column:1/-1; text-align:center; padding:60px 20px; color:var(--mk-muted); border:1px dashed var(--mk-border); border-radius:14px; }

.mk-catalog-pagination{ display:flex; justify-content:center; gap:8px; }
.mk-catalog-pagination a, .mk-catalog-pagination span{ width:38px; height:38px; display:flex; align-items:center; justify-content:center; border-radius:999px; font-size:0.9rem; color:var(--mk-text); border:1px solid var(--mk-border); }
.mk-catalog-pagination a:hover{ border-color:var(--mk-orange); color:var(--mk-orange); }
.mk-catalog-pagination .active{ background:var(--mk-orange); border-color:var(--mk-orange); color:#fff; font-weight:600; }
</style>

<!-- Catalog Start -->
<section class="mk-catalog-hero">
	<div class="container">
		<span class="mk-catalog-hero-tag">Promo Terbaru</span>
		<h1 class="mk-catalog-hero-title">Katalog Mingguan <span>Manna Kampus</span></h1>
		<p class="mk-catalog-hero-sub">Temukan penawaran terbaik dan harga special di cabang terdekat Anda. Hemat lebih banyak untuk kebutuhan harian keluarga.</p>
	</div>
</section>

<div class="mk-branch-box">
	<div class="mk-branch-box-left">
		<div class="mk-branch-box-icon"><i class="fa fa-map-marker"></i></div>
		<div>
			<p class="mk-branch-box-title">Pilih Cabang Terdekat</p>
			<p class="mk-branch-box-sub">Sesuaikan katalog dengan stok di lokasi Anda</p>
		</div>
	</div>
	<form method="get" action="">
		<select name="branch" onchange="this.form.submit()">
			<option value="">Pilih Kota / Cabang</option>
			<?php
			// Ganti query ini sesuai tabel cabang yang kamu punya, contoh: tbl_branch
			// $branches = $pdo->query("SELECT branch_id, branch_name FROM tbl_branch ORDER BY branch_name ASC")->fetchAll(PDO::FETCH_ASSOC);
			// foreach ($branches as $b) {
			//     $selected = (isset($_GET['branch']) && $_GET['branch'] == $b['branch_id']) ? 'selected' : '';
			//     echo '<option value="'.$b['branch_id'].'" '.$selected.'>'.htmlspecialchars($b['branch_name']).'</option>';
			// }
			?>
		</select>
	</form>
</div>

<section class="catalog mk-catalog-list">
	<div class="container">

		<div class="mk-catalog-header">
			<h2 class="mk-catalog-heading">Daftar Katalog Aktif</h2>
			<a class="mk-catalog-archive" href="<?php echo htmlspecialchars(BASE_URL.'katalog-arsip.php', ENT_QUOTES, 'UTF-8'); ?>">Lihat Semua Arsip &rarr;</a>
		</div>

		<div class="mk-catalog-grid">
			<?php if ($news_list): ?>
				<?php foreach ($news_list as $news): ?>
				<?php
				$badge_color = $category_palette[$news['category_id'] % count($category_palette)];

				// Field opsional: sediakan valid_from / valid_until / catalog_pdf di tabel
				// jika ingin menampilkan rentang tanggal berlaku & tombol unduh PDF secara akurat.
				$valid_from  = isset($news['valid_from']) ? $news['valid_from'] : $news['news_date'];
				$valid_until = isset($news['valid_until']) ? $news['valid_until'] : null;
				$catalog_pdf = isset($news['catalog_pdf']) ? $news['catalog_pdf'] : null;
				?>
				<article class="mk-news-card">
					<div class="mk-news-card-img" style="background-image:url('<?php echo htmlspecialchars(BASE_URL.'assets/uploads/'.$news['photo'], ENT_QUOTES, 'UTF-8'); ?>');">
						<span class="mk-news-card-badge" style="background:<?php echo $badge_color; ?>;"><?php echo htmlspecialchars($news['category_name'], ENT_QUOTES, 'UTF-8'); ?></span>
					</div>
					<div class="mk-news-card-body">
						<h3 class="mk-news-card-title">
							<a href="<?php echo htmlspecialchars(BASE_URL.'news.php?slug='.$news['news_slug'], ENT_QUOTES, 'UTF-8'); ?>">
								<?php echo htmlspecialchars($news['news_title'], ENT_QUOTES, 'UTF-8'); ?>
							</a>
						</h3>
						<p class="mk-news-card-period">
							<i class="fa fa-calendar"></i>
							Berlaku: <?php echo format_tanggal_indo($valid_from); ?><?php echo $valid_until ? ' - '.format_tanggal_indo($valid_until) : ''; ?>
						</p>
						<div class="mk-news-card-actions">
							<a class="mk-btn-catalog" href="<?php echo htmlspecialchars(BASE_URL.'news.php?slug='.$news['news_slug'], ENT_QUOTES, 'UTF-8'); ?>">
								<i class="fa fa-eye"></i> Lihat Katalog
							</a>
							<?php if ($catalog_pdf): ?>
							<a class="mk-btn-pdf" href="<?php echo htmlspecialchars(BASE_URL.'assets/uploads/'.$catalog_pdf, ENT_QUOTES, 'UTF-8'); ?>" target="_blank">
								<i class="fa fa-download"></i> Unduh PDF
							</a>
							<?php endif; ?>
						</div>
					</div>
				</article>
				<?php endforeach; ?>
			<?php else: ?>
				<div class="mk-catalog-empty">Belum ada katalog yang ditemukan.</div>
			<?php endif; ?>
		</div>

		<?php if ($total_pages > 1): ?>
		<div class="mk-catalog-pagination">
			<?php if ($page > 1): ?>
				<a href="<?php echo mk_page_url($page-1, $keyword, $cat_slug); ?>">&lsaquo;</a>
			<?php endif; ?>
			<?php for ($i = 1; $i <= $total_pages; $i++): ?>
				<?php if ($i == $page): ?>
					<span class="active"><?php echo $i; ?></span>
				<?php else: ?>
					<a href="<?php echo mk_page_url($i, $keyword, $cat_slug); ?>"><?php echo $i; ?></a>
				<?php endif; ?>
			<?php endfor; ?>
			<?php if ($page < $total_pages): ?>
				<a href="<?php echo mk_page_url($page+1, $keyword, $cat_slug); ?>">&rsaquo;</a>
			<?php endif; ?>
		</div>
		<?php endif; ?>

	</div>
</section>
<!-- Catalog End -->

<?php require_once('footer.php'); ?>