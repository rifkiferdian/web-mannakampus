<?php require_once('header.php'); ?>
<style>
/* ===================== Galeri Penghargaan ===================== */
:root{ --pgh-orange:#f6871f; --pgh-navy:#0d1a35; --pgh-navy-2:#142544; --pgh-text:#1f2430; --pgh-muted:#6b7280; }

/* ---- Hero ---- */
.pgh-hero{
	position:relative;
	background:radial-gradient(120% 160% at 80% 20%, rgba(246,135,31,.12) 0%, rgba(246,135,31,0) 55%), linear-gradient(160deg, var(--pgh-navy) 0%, var(--pgh-navy-2) 100%);
	padding:70px 24px;
	text-align:center;
	color:#fff;
	overflow:hidden;
}
.pgh-hero h1{
	font-size:38px;
	font-weight:700;
	margin:0 0 16px;
	line-height:1.25;
	color: #fff;
}
.pgh-hero h1 span{ color:var(--pgh-orange); }
.pgh-hero p{
	font-size:15.5px;
	line-height:1.7;
	color:rgba(255,255,255,.75);
	max-width:640px;
	margin:0 auto;
}

/* ---- Section wrapper ---- */
.pgh-section{
	background:#faf5ef;
	padding:60px 24px 80px;
}
.pgh-container{
	max-width:1280px;
	margin:0 auto;
}

/* ---- Head: eyebrow / title / desc + controls ---- */
.pgh-head{
	display:flex;
	flex-wrap:wrap;
	gap:24px;
	justify-content:space-between;
	align-items:flex-end;
	margin-bottom:28px;
}
.pgh-eyebrow{
	display:inline-flex;
	align-items:center;
	gap:8px;
	font-size:12px;
	font-weight:700;
	letter-spacing:.12em;
	text-transform:uppercase;
	color:var(--pgh-orange);
	margin-bottom:12px;
}
.pgh-head-title{
	font-size:28px;
	font-weight:700;
	color:var(--pgh-navy);
	margin:0 0 10px;
}
.pgh-head-desc{
	font-size:14.5px;
	line-height:1.7;
	color:var(--pgh-muted);
	max-width:560px;
	margin:0;
}

.pgh-controls{
	display:flex;
	align-items:center;
	gap:12px;
	flex-wrap:wrap;
}
.pgh-search{
	position:relative;
	display:flex;
	align-items:center;
}
.pgh-search i{
	position:absolute;
	left:16px;
	color:var(--pgh-muted);
	font-size:13px;
	pointer-events:none;
}
.pgh-search input{
	width:230px;
	padding:11px 16px 11px 38px;
	border-radius:999px;
	border:1px solid #e4dfd7;
	background:#fff;
	font-size:13.5px;
	color:var(--pgh-text);
	outline:none;
	transition:border-color .2s ease, box-shadow .2s ease;
}
.pgh-search input:focus{
	border-color:var(--pgh-orange);
	box-shadow:0 0 0 3px rgba(246,135,31,.12);
}
.pgh-select{
	padding:11px 36px 11px 16px;
	border-radius:999px;
	border:1px solid #e4dfd7;
	background:#fff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='10' height='6'><path d='M0 0l5 6 5-6z' fill='%236b7280'/></svg>") no-repeat right 16px center;
	appearance:none;
	-webkit-appearance:none;
	font-size:13.5px;
	color:var(--pgh-text);
	cursor:pointer;
	outline:none;
}
.pgh-view-toggle{
	display:flex;
	gap:8px;
}
.pgh-view-btn{
	width:42px;
	height:42px;
	border-radius:10px;
	border:1px solid #e4dfd7;
	background:#fff;
	color:var(--pgh-muted);
	display:inline-flex;
	align-items:center;
	justify-content:center;
	cursor:pointer;
	font-size:15px;
	transition:background .2s ease, color .2s ease, border-color .2s ease;
}
.pgh-view-btn.active{
	background:var(--pgh-orange);
	border-color:var(--pgh-orange);
	color:#fff;
}

/* ---- Filter pills ---- */
.pgh-filters{
	display:flex;
	flex-wrap:wrap;
	gap:10px;
	margin-bottom:32px;
}
.pgh-pill{
	display:inline-flex;
	align-items:center;
	gap:8px;
	padding:10px 18px;
	border-radius:999px;
	border:1px solid #e4dfd7;
	background:#fff;
	color:var(--pgh-text);
	font-size:13.5px;
	font-weight:600;
	cursor:pointer;
	transition:background .2s ease, color .2s ease, border-color .2s ease;
}
.pgh-pill i{ font-size:12px; }
.pgh-pill:hover{ border-color:var(--pgh-orange); }
.pgh-pill.active{
	background:var(--pgh-orange);
	border-color:var(--pgh-orange);
	color:#fff;
}

/* ---- Grid ---- */
.pgh-grid{
	display:grid;
	grid-template-columns:repeat(4, 1fr);
	gap:24px;
}
.pgh-grid.pgh-view-list{
	grid-template-columns:1fr;
}

.pgh-card{
	background:#fff;
	border-radius:16px;
	overflow:hidden;
	border:1px solid #efe9e0;
	transition:transform .2s ease, box-shadow .2s ease;
	display:flex;
	flex-direction:column;
}
.pgh-card:hover{
	transform:translateY(-4px);
	box-shadow:0 16px 30px rgba(20,20,20,.08);
}
.pgh-card-media{
	position:relative;
	aspect-ratio:4/5;
	overflow:hidden;
}
.pgh-card-media img{
	width:100%;
	height:100%;
	object-fit:cover;
	display:block;
}
.pgh-card-year{
	position:absolute;
	top:12px;
	left:12px;
	background:var(--pgh-orange);
	color:#fff;
	font-size:12px;
	font-weight:700;
	padding:5px 12px;
	border-radius:999px;
}
.pgh-card-fav{
	position:absolute;
	top:12px;
	right:12px;
	width:32px;
	height:32px;
	border-radius:50%;
	background:rgba(255,255,255,.85);
	display:inline-flex;
	align-items:center;
	justify-content:center;
	color:var(--pgh-muted);
	font-size:14px;
	border:none;
	cursor:pointer;
}
.pgh-card-fav.active{ color:var(--pgh-orange); }
.pgh-card-body{
	padding:18px 18px 20px;
	display:flex;
	flex-direction:column;
	gap:4px;
	flex:1;
}
.pgh-card-cat{
	font-size:12.5px;
	font-weight:700;
	color:var(--pgh-orange);
}
.pgh-card-title{
	font-size:16px;
	font-weight:700;
	color:var(--pgh-navy);
	margin:0;
	line-height:1.35;
}
.pgh-card-desc{
	font-size:13px;
	line-height:1.6;
	color:var(--pgh-muted);
	margin:2px 0 10px;
}
.pgh-card-link{
	margin-top:auto;
	display:inline-flex;
	align-items:center;
	gap:8px;
	font-size:13.5px;
	font-weight:700;
	color:var(--pgh-orange);
	text-decoration:none;
	transition:gap .2s ease;
}
.pgh-card-link:hover{ gap:12px; color:var(--pgh-orange); text-decoration:none; }

/* ---- List view layout ---- */
.pgh-grid.pgh-view-list .pgh-card{
	flex-direction:row;
	align-items:stretch;
}
.pgh-grid.pgh-view-list .pgh-card-media{
	width:200px;
	flex:0 0 auto;
	aspect-ratio:auto;
}
.pgh-grid.pgh-view-list .pgh-card-body{
	flex-direction:row;
	align-items:center;
	flex-wrap:wrap;
	gap:6px 24px;
}
.pgh-grid.pgh-view-list .pgh-card-body .pgh-card-text{
	flex:1 1 260px;
}
.pgh-grid.pgh-view-list .pgh-card-link{ margin-top:0; }

/* ---- Empty state ---- */
.pgh-empty{
	display:none;
	text-align:center;
	padding:60px 20px;
	color:var(--pgh-muted);
	font-size:14.5px;
}
.pgh-empty i{
	display:block;
	font-size:32px;
	margin-bottom:14px;
	color:#e4dfd7;
}

/* ---- Pagination ---- */
.pgh-pagination{
	display:flex;
	justify-content:center;
	align-items:center;
	gap:8px;
	margin-top:40px;
}
.pgh-page-btn{
	min-width:38px;
	height:38px;
	padding:0 8px;
	border-radius:50%;
	border:1px solid #e4dfd7;
	background:#fff;
	color:var(--pgh-text);
	font-size:13.5px;
	font-weight:600;
	cursor:pointer;
	display:inline-flex;
	align-items:center;
	justify-content:center;
	transition:background .2s ease, color .2s ease, border-color .2s ease;
}
.pgh-page-btn:hover{ border-color:var(--pgh-orange); }
.pgh-page-btn.active{
	background:var(--pgh-orange);
	border-color:var(--pgh-orange);
	color:#fff;
}
.pgh-page-btn[disabled]{
	opacity:.4;
	cursor:not-allowed;
}
.pgh-page-btn[disabled]:hover{ border-color:#e4dfd7; }

/* ---- Responsive ---- */
@media (max-width:1199px){
	.pgh-grid{ grid-template-columns:repeat(3, 1fr); }
}
@media (max-width:900px){
	.pgh-grid{ grid-template-columns:repeat(2, 1fr); }
	.pgh-head{ align-items:flex-start; }
}
@media (max-width:600px){
	.pgh-hero{ padding:50px 20px; }
	.pgh-hero h1{ font-size:26px; }
	.pgh-grid{ grid-template-columns:1fr; }
	.pgh-controls{ width:100%; }
	.pgh-search{ flex:1 1 100%; }
	.pgh-search input{ width:100%; }
	.pgh-grid.pgh-view-list .pgh-card{ flex-direction:column; }
	.pgh-grid.pgh-view-list .pgh-card-media{ width:100%; aspect-ratio:16/9; }
}
</style>

<?php
// ------------------------------------------------------------------
// Ambil data penghargaan dari tabel yang sama dengan section
// "Penghargaan MannaKampus" di homepage (tbl_team_member + tbl_designation)
// ------------------------------------------------------------------
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
							ORDER BY t1.id DESC");
$statement->execute(array('Active'));
$pgh_rows = $statement->fetchAll(PDO::FETCH_ASSOC);

function pgh_slugify($text) {
	$text = strtolower(trim($text));
	$text = preg_replace('/[^a-z0-9]+/', '-', $text);
	return trim($text, '-');
}

$pgh_list = array();
$pgh_categories = array(); // slug => label

foreach ($pgh_rows as $pgh_row) {

	// Tahun diambil dari bagian depan kolom "degree", mis. "2025 - Tingkat Nasional"
	$pgh_year = '';
	if (preg_match('/(\d{4})/', $pgh_row['degree'], $pgh_year_match)) {
		$pgh_year = $pgh_year_match[1];
	}

	// Gambar utama pakai "banner", fallback ke "photo"
	$pgh_image = !empty($pgh_row['banner']) ? $pgh_row['banner'] : $pgh_row['photo'];

	// Deskripsi singkat dari "detail" (strip HTML, potong karakter)
	$pgh_desc = trim(strip_tags($pgh_row['detail']));
	$pgh_desc = preg_replace('/\s+/', ' ', $pgh_desc);
	if (function_exists('mb_strlen') && mb_strlen($pgh_desc) > 130) {
		$pgh_desc = mb_substr($pgh_desc, 0, 130).'…';
	} elseif (strlen($pgh_desc) > 130) {
		$pgh_desc = substr($pgh_desc, 0, 130).'…';
	}

	$pgh_cat_label = $pgh_row['designation_name'];
	$pgh_cat_slug  = pgh_slugify($pgh_cat_label);
	if ($pgh_cat_slug !== '' && !isset($pgh_categories[$pgh_cat_slug])) {
		$pgh_categories[$pgh_cat_slug] = $pgh_cat_label;
	}

	$pgh_list[] = array(
		'title'     => $pgh_row['name'],
		'category'  => $pgh_cat_label,
		'cat_slug'  => $pgh_cat_slug,
		'year'      => $pgh_year,
		'image'     => BASE_URL.'assets/uploads/'.$pgh_image,
		'desc'      => $pgh_desc,
		'url'       => BASE_URL.URL_TEAM.$pgh_row['slug'],
	);
}

$pgh_total = count($pgh_list);
?>

<!-- Hero Start -->
<section class="pgh-hero">
	<div class="pgh-container">
		<h1>Galeri <span>Penghargaan</span></h1>
		<p>Dokumentasi lengkap penghargaan yang telah diraih Manna Kampus sebagai bukti komitmen dan dedikasi kami.</p>
	</div>
</section>
<!-- Hero End -->

<!-- List Section Start -->
<section class="pgh-section pgh-page">
	<div class="pgh-container">

		<div class="pgh-head">
			<div>
				<span class="pgh-eyebrow"><i class="fa fa-trophy"></i> Semua Penghargaan</span>
				<h2 class="pgh-head-title">Daftar Penghargaan Manna Kampus</h2>
				<p class="pgh-head-desc">Berikut adalah penghargaan yang telah kami raih dari berbagai pihak atas dedikasi dalam memberikan layanan terbaik dan menciptakan dampak positif bagi masyarakat.</p>
			</div>

			<div class="pgh-controls">
				<div class="pgh-search">
					<i class="fa fa-search"></i>
					<input type="text" id="pghSearchInput" placeholder="Cari penghargaan...">
				</div>

				<select class="pgh-select" id="pghCategorySelect">
					<option value="all">Kategori: Semua</option>
					<?php foreach ($pgh_categories as $pgh_slug => $pgh_label): ?>
					<option value="<?php echo htmlspecialchars($pgh_slug, ENT_QUOTES, 'UTF-8'); ?>">Kategori: <?php echo htmlspecialchars($pgh_label, ENT_QUOTES, 'UTF-8'); ?></option>
					<?php endforeach; ?>
				</select>

				<div class="pgh-view-toggle">
					<button type="button" class="pgh-view-btn active" id="pghViewGrid" aria-label="Tampilan grid"><i class="fa fa-th"></i></button>
					<button type="button" class="pgh-view-btn" id="pghViewList" aria-label="Tampilan list"><i class="fa fa-list"></i></button>
				</div>
			</div>
		</div>

		<div class="pgh-filters" id="pghFilters">
			<button type="button" class="pgh-pill active" data-cat="all">Semua</button>
			<?php foreach ($pgh_categories as $pgh_slug => $pgh_label): ?>
			<button type="button" class="pgh-pill" data-cat="<?php echo htmlspecialchars($pgh_slug, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($pgh_label, ENT_QUOTES, 'UTF-8'); ?></button>
			<?php endforeach; ?>
		</div>

		<div class="pgh-grid" id="pghGrid">
			<?php foreach ($pgh_list as $pgh_item): ?>
			<article class="pgh-card"
					 data-cat="<?php echo htmlspecialchars($pgh_item['cat_slug'], ENT_QUOTES, 'UTF-8'); ?>"
					 data-search="<?php echo htmlspecialchars(strtolower($pgh_item['title'].' '.$pgh_item['category'].' '.$pgh_item['desc']), ENT_QUOTES, 'UTF-8'); ?>">
				<div class="pgh-card-media">
					<?php if ($pgh_item['year'] !== ''): ?>
					<span class="pgh-card-year"><?php echo htmlspecialchars($pgh_item['year'], ENT_QUOTES, 'UTF-8'); ?></span>
					<?php endif; ?>
					<button type="button" class="pgh-card-fav" aria-label="Tandai favorit"><i class="fa fa-star-o"></i></button>
					<img src="<?php echo htmlspecialchars($pgh_item['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($pgh_item['title'], ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
				</div>
				<div class="pgh-card-body">
					<div class="pgh-card-text">
						<span class="pgh-card-cat"><?php echo htmlspecialchars($pgh_item['category'], ENT_QUOTES, 'UTF-8'); ?></span>
						<h3 class="pgh-card-title"><?php echo htmlspecialchars($pgh_item['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
						<p class="pgh-card-desc"><?php echo htmlspecialchars($pgh_item['desc'], ENT_QUOTES, 'UTF-8'); ?></p>
					</div>
				</div>
			</article>
			<?php endforeach; ?>
		</div>

		<div class="pgh-empty" id="pghEmpty">
			<i class="fa fa-search"></i>
			Tidak ada penghargaan yang cocok dengan pencarian/filter kamu.
		</div>

		<?php if ($pgh_total > 0): ?>
		<div class="pgh-pagination" id="pghPagination"></div>
		<?php endif; ?>

	</div>
</section>
<!-- List Section End -->

<script>
(function(){
	var ITEMS_PER_PAGE = 8;

	var grid        = document.getElementById('pghGrid');
	var cards        = Array.prototype.slice.call(grid.querySelectorAll('.pgh-card'));
	var emptyState   = document.getElementById('pghEmpty');
	var pagination   = document.getElementById('pghPagination');
	var searchInput  = document.getElementById('pghSearchInput');
	var categorySelect = document.getElementById('pghCategorySelect');
	var filterPills  = Array.prototype.slice.call(document.querySelectorAll('#pghFilters .pgh-pill'));
	var viewGridBtn  = document.getElementById('pghViewGrid');
	var viewListBtn  = document.getElementById('pghViewList');

	var state = {
		category: 'all',
		query: '',
		page: 1
	};

	function getFiltered(){
		return cards.filter(function(card){
			var matchesCategory = (state.category === 'all') || (card.getAttribute('data-cat') === state.category);
			var matchesQuery = state.query === '' || card.getAttribute('data-search').indexOf(state.query) !== -1;
			return matchesCategory && matchesQuery;
		});
	}

	function renderPagination(totalItems){
		pagination.innerHTML = '';
		var totalPages = Math.max(1, Math.ceil(totalItems / ITEMS_PER_PAGE));
		if (state.page > totalPages) { state.page = totalPages; }

		var prevBtn = document.createElement('button');
		prevBtn.type = 'button';
		prevBtn.className = 'pgh-page-btn';
		prevBtn.innerHTML = '<i class="fa fa-chevron-left"></i>';
		prevBtn.disabled = state.page <= 1;
		prevBtn.addEventListener('click', function(){
			if (state.page > 1) { state.page--; update(); }
		});
		pagination.appendChild(prevBtn);

		for (var i = 1; i <= totalPages; i++) {
			(function(pageNum){
				var btn = document.createElement('button');
				btn.type = 'button';
				btn.className = 'pgh-page-btn' + (pageNum === state.page ? ' active' : '');
				btn.textContent = pageNum;
				btn.addEventListener('click', function(){
					state.page = pageNum;
					update();
				});
				pagination.appendChild(btn);
			})(i);
		}

		var nextBtn = document.createElement('button');
		nextBtn.type = 'button';
		nextBtn.className = 'pgh-page-btn';
		nextBtn.innerHTML = '<i class="fa fa-chevron-right"></i>';
		nextBtn.disabled = state.page >= totalPages;
		nextBtn.addEventListener('click', function(){
			if (state.page < totalPages) { state.page++; update(); }
		});
		pagination.appendChild(nextBtn);
	}

	function update(){
		var filtered = getFiltered();

		// Sembunyikan semua kartu dulu
		cards.forEach(function(card){ card.style.display = 'none'; });

		if (filtered.length === 0) {
			emptyState.style.display = 'block';
			pagination.innerHTML = '';
			return;
		}
		emptyState.style.display = 'none';

		var start = (state.page - 1) * ITEMS_PER_PAGE;
		var end = start + ITEMS_PER_PAGE;
		filtered.slice(start, end).forEach(function(card){
			card.style.display = '';
		});

		renderPagination(filtered.length);

		// Scroll halus ke atas grid saat pindah halaman (bukan saat load pertama)
	}

	// ---- Search ----
	var searchTimeout;
	searchInput.addEventListener('input', function(){
		clearTimeout(searchTimeout);
		searchTimeout = setTimeout(function(){
			state.query = searchInput.value.trim().toLowerCase();
			state.page = 1;
			update();
		}, 200);
	});

	// ---- Filter pills ----
	filterPills.forEach(function(pill){
		pill.addEventListener('click', function(){
			var cat = pill.getAttribute('data-cat');
			state.category = cat;
			state.page = 1;

			filterPills.forEach(function(p){ p.classList.remove('active'); });
			pill.classList.add('active');
			categorySelect.value = cat;

			update();
		});
	});

	// ---- Dropdown kategori (sinkron dengan pill) ----
	categorySelect.addEventListener('change', function(){
		var cat = categorySelect.value;
		state.category = cat;
		state.page = 1;

		filterPills.forEach(function(p){
			p.classList.toggle('active', p.getAttribute('data-cat') === cat);
		});

		update();
	});

	// ---- Toggle grid / list ----
	viewGridBtn.addEventListener('click', function(){
		grid.classList.remove('pgh-view-list');
		viewGridBtn.classList.add('active');
		viewListBtn.classList.remove('active');
	});
	viewListBtn.addEventListener('click', function(){
		grid.classList.add('pgh-view-list');
		viewListBtn.classList.add('active');
		viewGridBtn.classList.remove('active');
	});

	// ---- Tombol favorit (visual saja) ----
	Array.prototype.slice.call(document.querySelectorAll('.pgh-card-fav')).forEach(function(btn){
		btn.addEventListener('click', function(e){
			e.preventDefault();
			btn.classList.toggle('active');
			var icon = btn.querySelector('i');
			icon.classList.toggle('fa-star-o');
			icon.classList.toggle('fa-star');
		});
	});

	update();
})();
</script>

<?php require_once('footer.php'); ?>