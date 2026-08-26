<?php require_once('header.php'); ?>

<?php

function format_tanggal_indo($date) {
	$bulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli',
				   'Agustus','September','Oktober','November','Desember');
	$ts = strtotime($date);
	return date('d', $ts).' '.$bulan[(int)date('n', $ts)].' '.date('Y', $ts);
}

$keyword  = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$cat_slug = isset($_GET['cat']) ? trim($_GET['cat']) : '';

// Ambil daftar kategori untuk pill filter
$categories = $pdo->query("SELECT category_id, category_name, category_slug FROM tbl_category ORDER BY category_name ASC")->fetchAll(PDO::FETCH_ASSOC);

$category_palette = array('#E87817', '#D45745', '#2B4C6F', '#5A8247', '#388697', '#B5653D', '#805A75', '#63707E');
$category_colors = array();
foreach ($categories as $index => $category) {
	$category_colors[$category['category_id']] = $category_palette[$index % count($category_palette)];
}

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
.mk-blog-list{ --mk-orange:#E8792E; --mk-orange-dark:#C9611F; --mk-text:#2E2620; --mk-muted:#8A7F73; --mk-border:#EDE4D8; }
.mk-blog-list a{ text-decoration:none; }

/* ---------------- Hero Section (pengganti banner gradient) ---------------- */
.mk-blog-hero{ background:#F7F5F1; padding:90px 24px 70px; text-align:center; }
.mk-blog-hero-title{ font-size:3.25rem; font-weight:800; color:#2E2620; margin:0 0 14px; }
.mk-blog-hero-title span{ color:#E8792E; }
.mk-blog-hero-sub{ font-size:1.5rem; color:#7A6F63; max-width:640px; margin:0 auto 28px; line-height:1.6; }

.mk-blog-search{ max-width:560px; margin:0 auto 22px; display:flex; align-items:center; background:#fff; border-radius:999px; box-shadow:0 6px 18px rgba(74,53,39,0.08); padding:6px 6px 6px 22px; }
.mk-blog-search input[type="text"]{ flex:1; border:none; outline:none; font-size:0.95rem; color:#2E2620; background:transparent; padding:10px 0; }
.mk-blog-search input[type="text"]::placeholder{ color:#B5AA9C; }
.mk-blog-search button{ background:#E8792E; color:#fff; border:none; border-radius:999px; padding:10px 26px; font-weight:600; font-size:0.95rem; cursor:pointer; transition:background .2s ease; }
.mk-blog-search button:hover{ background:#C9611F; }

.mk-blog-filter{ display:flex; flex-wrap:wrap; justify-content:center; gap:10px; }
.mk-filter-pill{ display:inline-block; padding:9px 20px; border-radius:999px; font-size:0.9rem; font-weight:600; border:1px solid #E3DACC; color:#5A4E42; background:#fff; transition:all .2s ease; }
.mk-filter-pill:hover{ border-color:#E8792E; color:#E8792E; }
.mk-filter-pill.active{ background:#E8792E; border-color:#E8792E; color:#fff; }

@media (max-width:576px){
	.mk-blog-hero-title{ font-size:1.6rem; }
	.mk-blog-search{ flex-direction:column; border-radius:16px; padding:14px; gap:10px; }
	.mk-blog-search input[type="text"]{ width:100%; text-align:center; }
	.mk-blog-search button{ width:100%; }
}

/* ---------------- Container list blog ---------------- */
.mk-blog-list .container{
	max-width: 1240px;
	margin: 0 auto;
	padding: 48px 32px;
}

.mk-blog-list-grid{ display:grid; grid-template-columns:1fr 1fr; gap:28px; margin-bottom:40px; }
@media (max-width:767px){ .mk-blog-list-grid{ grid-template-columns:1fr; } }

.mk-news-card{ background:#fff; border:1px solid var(--mk-border); border-radius:14px; overflow:hidden; display:flex; flex-direction:column; transition:box-shadow .2s ease, transform .2s ease; }
.mk-news-card:hover{ box-shadow:0 12px 28px rgba(74,53,39,0.12); transform:translateY(-3px); }
.mk-news-card-img{ position:relative; aspect-ratio: 4 / 3; background-size:cover; background-position:center; background-color:#f2ede6; }
.mk-news-card-badge{ position:absolute; top:12px; left:12px; color:#fff; font-size:1.2rem; font-weight:600; padding:5px 12px; border-radius:999px; letter-spacing:.02em; }
.mk-news-card-body{ padding:20px; display:flex; flex-direction:column; flex:1; }
.mk-news-card-date{ font-size:1.2rem; color:var(--mk-muted); margin-bottom:8px; }
.mk-news-card-title{ font-size:1.05rem; font-weight:700; line-height:1.4; margin:0 0 10px; color:var(--mk-text); }
.mk-news-card-title a{ color:inherit; }
.mk-news-card-title a:hover{ color:var(--mk-orange); }
.mk-news-card-excerpt{ font-size:0.9rem; color:var(--mk-muted); line-height:1.6; margin:0 0 16px; flex:1; }
.mk-news-card-more{ color:var(--mk-orange); font-weight:600; font-size:1.2rem; display:inline-flex; align-items:center; gap:6px; }
.mk-news-card-more:hover{ color:var(--mk-orange-dark); }

.mk-blog-empty{ grid-column:1/-1; text-align:center; padding:60px 20px; color:var(--mk-muted); border:1px dashed var(--mk-border); border-radius:14px; }

.mk-blog-pagination{ display:flex; justify-content:center; gap:8px; }
.mk-blog-pagination a, .mk-blog-pagination span{ width:38px; height:38px; display:flex; align-items:center; justify-content:center; border-radius:999px; font-size:0.9rem; color:var(--mk-text); border:1px solid var(--mk-border); }
.mk-blog-pagination a:hover{ border-color:var(--mk-orange); color:var(--mk-orange); }
.mk-blog-pagination .active{ background:var(--mk-orange); border-color:var(--mk-orange); color:#fff; font-weight:600; }
</style>

<!-- Hero Start (pengganti page-banner) -->
<section class="mk-blog-hero">
	<div class="container">
		<h1 class="mk-blog-hero-title">Jendela Informasi &amp; <span>Tips Belanja Manna Kampus</span></h1>
		<p class="mk-blog-hero-sub">Temukan tips belanja cerdas, inspirasi hidup sehat, dan update terbaru dari<br> Rumah Belanja Terpercaya Anda.</p>
	</div>
</section>
<!-- Hero End -->

<!-- Blog Start -->
<section class="blog mk-blog-list">
	<div class="container">
		<div class="row">
			<div class="col-md-9">

				<div class="mk-blog-list-grid">
					<?php if ($news_list): ?>
						<?php foreach ($news_list as $news): ?>
						<?php
						$badge_color = isset($category_colors[$news['category_id']]) ? $category_colors[$news['category_id']] : '#E8792E';
						$excerpt = strip_tags($news['news_content']);
						$excerpt = mb_strlen($excerpt) > 130 ? mb_substr($excerpt, 0, 130).'...' : $excerpt;
						?>
						<article class="mk-news-card">
							<div class="mk-news-card-img" style="background-image:url('<?php echo htmlspecialchars(BASE_URL.'assets/uploads/'.$news['photo'], ENT_QUOTES, 'UTF-8'); ?>');">
								<span class="mk-news-card-badge" style="background:<?php echo $badge_color; ?>;"><?php echo htmlspecialchars($news['category_name'], ENT_QUOTES, 'UTF-8'); ?></span>
							</div>
							<div class="mk-news-card-body">
								<div class="mk-news-card-date"><i class="fa fa-calendar"></i> <?php echo format_tanggal_indo($news['news_date']); ?></div>
								<h3 class="mk-news-card-title">
									<a href="<?php echo htmlspecialchars(BASE_URL.'news.php?slug='.$news['news_slug'], ENT_QUOTES, 'UTF-8'); ?>">
										<?php echo htmlspecialchars($news['news_title'], ENT_QUOTES, 'UTF-8'); ?>
									</a>
								</h3>
								<p class="mk-news-card-excerpt"><?php echo htmlspecialchars($excerpt, ENT_QUOTES, 'UTF-8'); ?></p>
								<a class="mk-news-card-more" href="<?php echo htmlspecialchars(BASE_URL.'news.php?slug='.$news['news_slug'], ENT_QUOTES, 'UTF-8'); ?>">Read More &rarr;</a>
							</div>
						</article>
						<?php endforeach; ?>
					<?php else: ?>
						<div class="mk-blog-empty">Belum ada artikel yang ditemukan.</div>
					<?php endif; ?>
				</div>

				<?php if ($total_pages > 1): ?>
				<div class="mk-blog-pagination">
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
			<div class="col-md-3">
				<?php require_once('sidebar.php'); ?>
			</div>
		</div>
	</div>
</section>
<!-- Blog End -->

<?php require_once('footer.php'); ?>
