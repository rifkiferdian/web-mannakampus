<!-- Sidebar Container Start -->
<style>
/* ================= RESET PAKSA — melawan CSS theme lama ================= */
.sidebar .widget,
.sidebar .widget ul,
.sidebar .widget ul li,
.sidebar .widget ul li a{
    list-style: none !important;
    list-style-image: none !important;
    list-style-type: none !important;
}
.sidebar .widget ul li a::before,
.sidebar .widget ul li a::after,
.sidebar .widget ul li::before,
.sidebar .widget ul li::after,
.sidebar .widget ul li a::marker,
.sidebar .widget ul li::marker{
    content: none !important;
    display: none !important;
}
.sidebar .widget ul li{
    border: none !important;
    border-bottom: none !important;
    background: none !important;
    padding-left: 0 !important;
    margin: 0 !important;
}

/* Matikan background/ribbon bawaan pada judul widget */
.sidebar .widget h4,
.sidebar .widget .widget-title{
    background: none !important;
    background-color: transparent !important;
    background-image: none !important;
    box-shadow: none !important;
    padding: 0 !important;
    margin: 0 0 6px !important;
}

/* ================= Card putih — dipakai Categories, Popular Posts, Latest News ================= */
.mk-card{
    background: #ffffff;
    border: 1px solid #EDE4D8;
    border-radius: 14px;
    padding: 22px;
    margin-bottom: 24px;
}

/* Judul + underline mengikuti lebar tulisan */
.mk-widget-title{
    display: inline-block;
    position: relative;
    font-size: 1.15rem;
    font-weight: 700;
    color: #2E2620 !important;
}
.mk-widget-title::after{
    content: "";
    display: block;
    width: 100%;
    height: 3px;
    background: #E8792E;
    border-radius: 2px;
    margin-top: 8px;
}
.mk-widget-head{ margin-bottom: 18px; }

/* ===== Search — tanpa kotak/card, bentuk pill melengkung ===== */
.mk-search-wrap{ margin-bottom: 24px; }
.mk-search-form{
    display: flex;
    align-items: center;
    background: #F9F6F1;
    border: 1px solid #EDE4D8;
    border-radius: 999px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(74,53,39,0.05);
}
.mk-search-form input{
    flex: 1;
    border: none;
    outline: none;
    background: transparent;
    padding: 12px 18px;
    font-size: 0.9rem;
    color: #2E2620;
}
.mk-search-form input::placeholder{ color: #8A7F73; }
.mk-search-form button{
    border: none;
    background: #E8792E;
    color: #ffffff;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    margin: 3px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.mk-search-form button:hover{ background: #C9611F; }

/* ===== Categories — jarak antar item dipersempit + warna default hitam ===== */
.mk-category-list{ margin:0; padding:0; }
.mk-category-list li a{
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 3px 0;
    line-height: 1.4;
    color: #2E2620 !important;
    text-decoration: none;
    font-size: 0.95rem;
    transition: color .15s ease;
}
.mk-category-list li a:hover,
.mk-category-list li a:active,
.mk-category-list li a:focus{
    color: #E8792E !important;
}
.mk-cat-count{
    background: #ff8636;
    color: #fdfdfd;
    font-size: 1.0rem;
    font-weight: 600;
    width: 26px;
    height: 26px;
    padding: 0;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}


/* ===== Popular Posts — gambar di samping (kiri), teks di kanan — DIPERKUAT ===== */
.sidebar .mk-pop-list{ margin:0 !important; padding:0 !important; }
.sidebar .mk-pop-list li.mk-pop-item{
    display: flex !important;
    flex-direction: row !important;
    flex-wrap: nowrap !important;
    align-items: flex-start !important;
    gap: 14px !important;
    padding: 14px 0 !important;
    width: 100% !important;
}
.sidebar .mk-pop-item .mk-pop-thumb{
    width: 70px !important;
    height: 70px !important;
    min-width: 70px !important;
    max-width: 70px !important;
    border-radius: 10px !important;
    background-size: cover !important;
    background-position: center !important;
    background-color: #f2f2f2 !important;
    flex-shrink: 0 !important;
    flex-grow: 0 !important;
    margin: 0 !important;
}
.sidebar .mk-pop-item .mk-pop-text{
    flex: 1 1 auto !important;
    min-width: 0 !important;
    width: auto !important;
}
.sidebar .mk-pop-item .mk-pop-title{ font-size:1.0rem; font-weight:700; line-height:1.35; margin:0 0 8px !important; }
.sidebar .mk-pop-item .mk-pop-title a{ color:#2E2620 !important; text-decoration:none; }
.sidebar .mk-pop-item .mk-pop-title a:hover{ color:#E8792E !important; }
.sidebar .mk-pop-item .mk-pop-views{ font-size:1.2rem; color:#E8792E; font-weight:600; }

/* ===== Latest News — kotak oranye rata, tanpa ribbon terpisah ===== */
.widget-latest-news{
    background: #f9a04c !important;
    border-radius: 14px;
    padding: 22px;
    margin-bottom: 24px;
}
.widget-latest-news .mk-widget-title{ color: #ffffff !important; }
.widget-latest-news .mk-widget-title::after{ background: #ffffff; }
.mk-latest-list{ margin:0; padding:0; }
.mk-latest-list li{ margin-bottom:12px; }
.mk-latest-list li:last-child{ margin-bottom:0; }
.mk-latest-list li a{ color:#ffffff !important; font-weight:600; font-size:0.92rem; line-height:1.4; text-decoration:none; }
.mk-latest-list li a:hover{ text-decoration: underline; }
.mk-subscribe-btn{
    display:block; width:100%; text-align:center;
    background:#ffffff; color:#f9a04c !important; font-weight:700; font-size:0.85rem;
    letter-spacing:.03em; padding:12px; border-radius:8px; border:none;
    margin-top:18px; cursor:pointer; text-decoration:none;
}
.mk-subscribe-btn:hover{ background:#f4f4f4; }
</style>

<div class="sidebar">

	<!-- Search  -->
	<div class="widget mk-search-wrap">
		<form class="mk-search-form" action="<?php echo BASE_URL.URL_SEARCH; ?>" method="post">
			<input type="text" style="font-size: 1.5rem" name="search_string" placeholder="<?php echo SEARCH; ?>">
			<button type="submit"><i class="fa fa-search"></i></button>
		</form>
	</div>

	<?php
	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$total_recent_news_sidebar = $row['total_recent_news_sidebar'];
		$total_popular_news_sidebar = $row['total_popular_news_sidebar'];
	}
	?>

	<!-- Categories -->
	<div class="widget mk-card">
		<div class="mk-widget-head">
			<h4 class="mk-widget-title"><?php echo CATEGORIES; ?></h4>
		</div>
		<ul class="mk-category-list">
			<?php
			$statement = $pdo->prepare(
				"SELECT t2.category_id, t2.category_name, t2.category_slug,
					COUNT(t1.news_id) AS total_news
				FROM tbl_category t2
				LEFT JOIN tbl_news t1 ON t1.category_id = t2.category_id
				GROUP BY t2.category_id, t2.category_name, t2.category_slug
				ORDER BY t2.category_name ASC"
			);
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result as $row) {
			?>
			<li>
				<a href="<?php echo BASE_URL.URL_CATEGORY.$row['category_slug']; ?>">
					<span><?php echo $row['category_name']; ?></span>
					<span class="mk-cat-count"><?php echo $row['total_news']; ?></span>
				</a>
			</li>
			<?php
			}
			?>
		</ul>
	</div>

	<!-- Popular Posts -->
<div class="widget mk-card">
	<div class="mk-widget-head">
		<h4 class="mk-widget-title"><?php echo POPULAR_NEWS; ?></h4>
	</div>
	<ul class="mk-pop-list">
		<?php
		$i=0;
		$statement = $pdo->prepare("SELECT * FROM tbl_news ORDER BY total_view DESC");
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) {
			$i++;
			if($i>$total_popular_news_sidebar) {break;}

			$views = $row['total_view'];
			$views_label = $views >= 1000 ? number_format($views/1000, 1).'k' : $views;
			?>
			<li class="mk-pop-item">
				<div class="mk-pop-thumb" style="background-image:url('<?php echo htmlspecialchars(BASE_URL.'assets/uploads/'.$row['photo'], ENT_QUOTES, 'UTF-8'); ?>');"></div>
				<div class="mk-pop-text">
					<h6 class="mk-pop-title">
						<a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>"><?php echo $row['news_title']; ?></a>
					</h6>
					<span class="mk-pop-views"><?php echo $views_label; ?> views</span>
				</div>
			</li>
			<?php
		}
		?>
	</ul>
</div>

	<!-- Latest News -->
	<div class="widget widget-latest-news">
		<div class="mk-widget-head">
			<h4 class="mk-widget-title"><?php echo LATEST_NEWS; ?></h4>
		</div>
		<ul class="mk-latest-list">
			<?php
			$i=0;
			$statement = $pdo->prepare("SELECT * FROM tbl_news ORDER BY news_id DESC");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) {
				$i++;
				if($i>$total_recent_news_sidebar) {break;}
				?>
				<li><a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>"><?php echo $row['news_title']; ?></a></li>
				<?php
			}
			?>
		</ul>
		<a href="<?php echo BASE_URL.URL_SEARCH; ?>" class="mk-subscribe-btn" style="font-size: 1.2rem;">SUBSCRIBE TO NEWS</a>
	</div>
</div>
<!-- Sidebar Container End -->