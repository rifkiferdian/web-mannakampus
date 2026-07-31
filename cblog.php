<?php require_once('header.php'); ?>

<?php
/* ==========================================================================
   BLOG LIST - MANNA KAMPUS
   Mengikuti skema tabel yang sama dengan news.php (halaman detail):

     tbl_news     : news_id, news_title, news_slug, news_content, news_date,
                    publisher, photo, category_id, total_view
     tbl_category : category_id, category_name, category_slug

   Sidebar memakai sidebar.php yang sudah ada di project (sama seperti
   yang dipakai di news.php), jadi tidak dibuat ulang di sini.
   ========================================================================== */

function format_tanggal_indo($date) {
	$bulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli',
				   'Agustus','September','Oktober','November','Desember');
	$ts = strtotime($date);
	return date('d', $ts).' '.$bulan[(int)date('n', $ts)].' '.date('Y', $ts);
}

// Palet warna badge kategori, berputar berdasarkan category_id
$category_palette = array('#E8792E', '#5C8C5E', '#D9663F', '#5A4634', '#3E7C8C');

/* ---------------------------------------------------------------------
   Pencarian sederhana (opsional). Sesuaikan nama field ini ('keyword')
   dengan nama input yang dipakai pada form pencarian di sidebar.php.
--------------------------------------------------------------------- */
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

$where  = "";
$params = array();
if ($keyword !== '') {
	$where   .= "WHERE t1.news_title LIKE ?";
	$params[] = '%'.$keyword.'%';
}

/* ---------------------------------------------------------------------
   Pagination
--------------------------------------------------------------------- */
$per_page = 6;
$page     = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset   = ($page - 1) * $per_page;

$count_sql = "SELECT COUNT(*) FROM tbl_news t1 $where";
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
function mk_page_url($p, $keyword) {
	$qs = 'page='.$p;
	if ($keyword !== '') { $qs .= '&keyword='.urlencode($keyword); }
	return '?'.$qs;
}
?>

<style>
.mk-blog-list{ --mk-orange:#E8792E; --mk-orange-dark:#C9611F; --mk-text:#2E2620; --mk-muted:#8A7F73; --mk-border:#EDE4D8; }
.mk-blog-list a{ text-decoration:none; }

/*.page-banner .banner-text p{
    font-size: 1.05rem;
    color: #FFFFFF;
}*/

.mk-blog-list-grid{ display:grid; grid-template-columns:1fr 1fr; gap:28px; margin-bottom:40px; }
@media (max-width:767px){ .mk-blog-list-grid{ grid-template-columns:1fr; } }

.mk-news-card{ background:#fff; border:1px solid var(--mk-border); border-radius:14px; overflow:hidden; display:flex; flex-direction:column; transition:box-shadow .2s ease, transform .2s ease; }
.mk-news-card:hover{ box-shadow:0 12px 28px rgba(74,53,39,0.12); transform:translateY(-3px); }
.mk-news-card-img{ position:relative; height:170px; background-size:cover; background-position:center; }
.mk-news-card-badge{ position:absolute; top:12px; left:12px; color:#fff; font-size:0.87rem; font-weight:600; padding:5px 12px; border-radius:999px; letter-spacing:.02em; }
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

<!-- Banner Start -->
<div class="page-banner" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="banner-text">
                    <h1>Blog Manna Kampus</h1>
                    <p style="font-size: 1.8rem; color: #FFFFFF;">Temukan tips belanja cerdas, inspirasi hidup sehat, dan update terbaru dari Rumah Belanja Terpercaya Anda.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner End -->

<!-- Blog Start -->
<section class="blog mk-blog-list">
	<div class="container">
		<div class="row">
			<div class="col-md-9">

				<div class="mk-blog-list-grid">
					<?php if ($news_list): ?>
						<?php foreach ($news_list as $news): ?>
						<?php
						$badge_color = $category_palette[$news['category_id'] % count($category_palette)];
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
						<a href="<?php echo mk_page_url($page-1, $keyword); ?>">&lsaquo;</a>
					<?php endif; ?>
					<?php for ($i = 1; $i <= $total_pages; $i++): ?>
						<?php if ($i == $page): ?>
							<span class="active"><?php echo $i; ?></span>
						<?php else: ?>
							<a href="<?php echo mk_page_url($i, $keyword); ?>"><?php echo $i; ?></a>
						<?php endif; ?>
					<?php endfor; ?>
					<?php if ($page < $total_pages): ?>
						<a href="<?php echo mk_page_url($page+1, $keyword); ?>">&rsaquo;</a>
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
