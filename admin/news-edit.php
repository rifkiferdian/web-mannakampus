<?php require_once('header.php'); ?>
<?php require_once('image-upload-utils.php'); ?>

<style>
.no-plus-icon::before {
    display: none !important;
}

.no-plus-icon {
    text-align: center;
}

.content-header{
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}
.content-header h1{
    margin: 0;
}
.content-header-right{
    margin-left: auto; /* jaga-jaga kalau parent belum flex */
}
</style>
<?php
if(isset($_POST['form1'])) {
	$valid = 1;

	if(empty($_POST['news_title'])) {
		$valid = 0;
		$error_message .= 'News title can not be empty<br>';
	} else {
		// Duplicate Category checking
    	// current news title that is in the database
    	$statement = $pdo->prepare("SELECT * FROM tbl_news WHERE news_id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$current_news_title = $row['news_title'];
		}

		$statement = $pdo->prepare("SELECT * FROM tbl_news WHERE news_title=? and news_title!=?");
    	$statement->execute(array($_POST['news_title'],$current_news_title));
    	$total = $statement->rowCount();							
    	if($total) {
    		$valid = 0;
        	$error_message .= 'News title already exists<br>';
    	}
	}

	if(empty($_POST['news_content'])) {
		$valid = 0;
		$error_message .= 'News content can not be empty<br>';
	}

	if(empty($_POST['news_content_short'])) {
		$valid = 0;
		$error_message .= 'News content (short) can not be empty<br>';
	}

	if(empty($_POST['news_date'])) {
		$valid = 0;
		$error_message .= 'News publish date can not be empty<br>';
	}

	if(empty($_POST['category_id'])) {
		$valid = 0;
		$error_message .= 'You must have to select a category<br>';
	}

	if($_POST['publisher'] == '') {
		$publisher = $_SESSION['user']['full_name'];
	} else {
		$publisher = $_POST['publisher'];	
	}

	// Upload gambar bersifat OPSIONAL saat edit.
	// Cek apakah user benar-benar memilih file baru (bukan dikosongkan)
	$has_new_image = isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE;
	$previous_photo = isset($_POST['previous_photo']) ? $_POST['previous_photo'] : '';

	if($has_new_image) {
		$image_valid = image_upload_validate($_FILES['photo']);
		if($image_valid === false) {
			$valid = 0;
			$error_message .= 'Unggah gambar JPG atau PNG yang valid dengan ukuran maksimal 3 MB.<br>';
		}
	}

	if($valid == 1) {

		if($_POST['news_slug'] == '') {
    		// generate slug
    		$temp_string = strtolower($_POST['news_title']);
    		$news_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string);;
    	} else {
    		$temp_string = strtolower($_POST['news_slug']);
    		$news_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string);
    	}

    	// if slug already exists, then rename it
		$statement = $pdo->prepare("SELECT * FROM tbl_news WHERE news_slug=? AND news_title!=?");
		$statement->execute(array($news_slug,$current_news_title));
		$total = $statement->rowCount();
		if($total) {
			$news_slug = $news_slug.'-1';
		}

		$final_name = $previous_photo; // default: pertahankan foto lama

		if($has_new_image) {
			$final_name = image_upload_save_as_webp(
				$_FILES['photo'],
				'news-'.$_REQUEST['id'],
				__DIR__.'/../assets/uploads/'
			);

			if($final_name === false) {
				$valid = 0;
				$error_message .= 'Gambar tidak dapat diunggah.<br>';
			}
		}

		if($valid == 1) {
			// Simpan perubahan ke database
			$statement = $pdo->prepare("UPDATE tbl_news SET news_title=?, news_slug=?, news_content=?, news_content_short=?, news_date=?, photo=?, category_id=?, publisher=?, meta_title=?, meta_keyword=?, meta_description=? WHERE news_id=?");
			$statement->execute(array($_POST['news_title'],$news_slug,$_POST['news_content'],$_POST['news_content_short'],$_POST['news_date'],$final_name,$_POST['category_id'],$publisher,$_POST['meta_title'],$_POST['meta_keyword'],$_POST['meta_description'],$_REQUEST['id']));

			// Hapus foto lama HANYA kalau ada foto baru & namanya beda dari yang lama
			if($has_new_image && $previous_photo !== '' && $previous_photo !== $final_name) {
				$old_photo_path = __DIR__.'/../assets/uploads/'.$previous_photo;
				if(is_file($old_photo_path)) {
					unlink($old_photo_path);
				}
			}

			$_SESSION['success_message'] = 'News is updated successfully!';
			header('Location: news.php');
			exit;
		}
	}
}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_news WHERE news_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Edit News</h1>
	</div>
	<a href="news.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left" style="text-align: center;"></i> View All</a>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_news WHERE news_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$news_title         = $row['news_title'];
	$news_slug          = $row['news_slug'];
	$news_content       = $row['news_content'];
	$news_content_short = $row['news_content_short'];
	$news_date          = $row['news_date'];
	$photo              = $row['photo'];
	$category_id        = $row['category_id'];
	$publisher          = $row['publisher'];
	$meta_title         = $row['meta_title'];
	$meta_keyword       = $row['meta_keyword'];
	$meta_description   = $row['meta_description'];
}
?>

<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php if($error_message): ?>
			<div class="callout callout-danger">
			
			<p>
			<?php echo $error_message; ?>
			</p>
			</div>
			<?php endif; ?>

			<?php if($success_message): ?>
			<div class="callout callout-success">
			
			<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">News Title <span>*</span></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="news_title" value="<?php echo $news_title; ?>">
							</div>
						</div>
						<div class="form-group">
		                    <label for="" class="col-sm-3 control-label">News Slug</label>
		                    <div class="col-sm-6">
		                        <input type="text" class="form-control" name="news_slug" value="<?php echo $news_slug; ?>">
		                    </div>
		                </div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">News Content <span>*</span></label>
							<div class="col-sm-8">
								<textarea class="form-control editor" name="news_content"><?php echo $news_content; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">News Content (Short) <span>*</span></label>
							<div class="col-sm-8">
								<textarea class="form-control" name="news_content_short" style="height:100px;"><?php echo $news_content_short; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">News Publish Date <span>*</span></label>
							<div class="col-sm-2">
								<input type="text" class="form-control" name="news_date" id="datepicker" value="<?php echo $news_date; ?>">(Format: dd-mm-yy)
							</div>
						</div>
						<div class="form-group">
				            <label for="" class="col-sm-3 control-label">Existing Featured Photo</label>
				            <div class="col-sm-6" style="padding-top:6px;">
				            	<?php
				            	if($photo == '') {
				            		echo 'No photo found';
				            	} else {
				            		echo '<img src="../assets/uploads/'.$photo.'" class="existing-photo" style="width:200px;">';	
				            	}
				            	?>
				                <input type="hidden" name="previous_photo" value="<?php echo $photo; ?>">
				            </div>
				        </div>
						<div class="form-group">
				            <label for="" class="col-sm-3 control-label">Change Featured Photo</label>
				            <div class="col-sm-6" style="padding-top:6px;">
				                <input type="file" name="photo" accept="image/jpeg, image/png">
				                <br><small>JPG atau PNG, maksimal 3 MB. Kosongkan jika tidak ingin mengganti foto.</small>
				            </div>
				        </div>
						<div class="form-group">
				            <label for="" class="col-sm-3 control-label">Categories <span>*</span></label>
				            <div class="col-sm-3">
				            	<select class="form-control select2" name="category_id">
								<?php
				            	$i=0;
				            	$statement = $pdo->prepare("SELECT * FROM tbl_category ORDER BY category_name ASC");
				            	$statement->execute();
				            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
				            	foreach ($result as $row) {
									?>
									<option value="<?php echo $row['category_id']; ?>" <?php if($row['category_id']==$category_id){echo 'selected';} ?>><?php echo $row['category_name']; ?></option>
	                                <?php
								}
								?>
								</select>
				            </div>
				        </div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Publisher </label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="publisher" value="<?php echo $publisher; ?>"> (If you keep this blank, logged user will be treated as the publisher)
							</div>
						</div>
						<h3 class="seo-info">SEO Information</h3>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Meta Title </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="meta_title" value="<?php echo $meta_title; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Meta Keywords </label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="meta_keyword" value="<?php echo $meta_keyword; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Meta Description </label>
							<div class="col-sm-8">
								<textarea class="form-control" name="meta_description" style="height:200px;"><?php echo $meta_description; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>