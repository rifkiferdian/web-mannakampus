<?php require_once('header.php'); ?>
		
<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['slug']))
{
	header('location: '.BASE_URL);
	exit;
}

// Getting the news detailed data from the news id
$statement = $pdo->prepare("SELECT
							t1.news_title,
							t1.news_slug,
							t1.news_content,
							t1.news_date,
							t1.publisher,
							t1.photo,
							t1.category_id,
							
							t2.category_id,
							t2.category_name,
							t2.category_slug

                           	FROM tbl_news t1
                           	JOIN tbl_category t2
                           	ON t1.category_id = t2.category_id
                           	WHERE t1.news_slug=?");
$statement->execute(array($_REQUEST['slug']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$news_title    = $row['news_title'];
	$news_content  = $row['news_content'];
	$news_date     = $row['news_date'];
	$publisher     = $row['publisher'];
	$photo         = $row['photo'];
	$category_id   = $row['category_id'];
	$category_slug = $row['category_slug'];
	$category_name = $row['category_name'];
}

// Update data for view count for this news page
// Getting current view count
$statement = $pdo->prepare("SELECT * FROM tbl_news WHERE news_slug=?");
$statement->execute(array($_REQUEST['slug']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) 
{
	$current_total_view = $row['total_view'];
}
$updated_total_view = $current_total_view+1;

// Updating database for view count
$statement = $pdo->prepare("UPDATE tbl_news SET total_view=? WHERE news_slug=?");
$statement->execute(array($updated_total_view,$_REQUEST['slug']));
?>

<!-- Style tambahan hanya untuk halaman ini, agar sesuai gambar referensi -->
<style>

.blog .status{list-style:none;display:flex;gap:22px;padding:0;margin:0 0 12px;font-size:14px;font-weight:500;color:#6b7280;}
.blog .status li i{color:#f5821f;margin-right:6px;font-size:14px;}
.blog .status a{color:#6b7280;font-weight:500;}
.blog .status a:hover{color:#f5821f;}
.blog .post-item h3.post-title{font-size:28px;line-height:1.3;font-weight:700;margin:0 0 20px;}
.blog .image-holder-single{border-radius:10px;overflow:hidden;margin-bottom:24px;}
.blog .text-single{font-size:15px;color:#3d4451;}
.blog .text-single h3{margin-top:32px;margin-bottom:14px;font-size:20px;}
.blog .text-single p{margin-bottom:18px;}
.blog .text-single blockquote{border-left:4px solid #f5821f;background:#fff7ef;margin:24px 0;padding:16px 22px;font-style:italic;color:#22262e;border-radius:0 6px 6px 0;}
.blog .post-share{margin-top:32px;padding-top:20px;border-top:1px solid #e6e8eb;display:flex;align-items:center;gap:14px;font-size:14px;color:#6b7280;}
.blog .post-share .share-icon{width:32px;height:32px;border:1px solid #e6e8eb;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;color:#22262e;text-decoration:none;transition:all .2s;}
.blog .post-share .share-icon:hover{background:#f5821f;border-color:#f5821f;color:#fff;}
</style>

<!-- Blog Start -->
<section class="blog">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				
				<!-- Blog Classic Start -->
				<div class="blog-grid">
					<div class="row">
						<div class="col-md-12">							

							<!-- Post Item Start -->
							<div class="post-item">

								<ul class="status">
									<li><i class="fa fa-tag"></i><?php echo CATEGORY_COLON; ?> <a href="<?php echo BASE_URL.URL_CATEGORY.$category_slug; ?>" style="font-size:1.25rem"><?php echo $category_name; ?></a></li>
									<li><i class="fa fa-calendar"></i><?php echo DATE; ?> <?php echo $news_date; ?></li>
								</ul>

								<h3 class="post-title"><?php echo $news_title; ?></h3>

								<div class="image-holder image-holder-single">
									<img class="img-responsive" src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $photo ?>" alt="<?php echo $news_title; ?>">
								</div>

								<div class="text text-single">
									<?php echo $news_content; ?>
								</div>

								<div class="post-share">
									<span>Bagikan:</span>
									<a href="#" class="share-icon"><i class="fa fa-share-alt"></i></a>
									<a href="#" class="share-icon"><i class="fa fa-bookmark-o"></i></a>
								</div>

							</div>
							<!-- Post Item End -->

						</div>

					</div>
				</div>
				<!-- Blog Classic End -->
				

			</div>
			<div class="col-md-3">
				<?php require_once('sidebar.php'); ?>
			</div>

		</div>
	</div>
</section>
<!-- Blog End -->

<?php require_once('footer.php'); ?>