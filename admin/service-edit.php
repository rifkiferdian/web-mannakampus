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
    margin-left: auto;
}
</style>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

	if(empty($_POST['name'])) {
		$valid = 0;
		$error_message .= 'Name can not be empty<br>';
	}

	if(empty($_POST['description'])) {
		$valid = 0;
		$error_message .= 'Description can not be empty<br>';
	}

	if(empty($_POST['short_description'])) {
		$valid = 0;
		$error_message .= 'Short Description can not be empty<br>';
	}

	// Cek apakah user mengunggah file baru untuk masing-masing field
	$has_new_photo = isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE;
	$has_new_banner = isset($_FILES['banner']) && $_FILES['banner']['error'] !== UPLOAD_ERR_NO_FILE;

	if($has_new_photo) {
		$photo_valid = image_upload_validate($_FILES['photo']);
		if($photo_valid === false) {
			$valid = 0;
			$error_message .= 'Unggah gambar JPG atau PNG yang valid untuk Featured Photo, dengan ukuran maksimal 3 MB.<br>';
		}
	}

	if($has_new_banner) {
		$banner_valid = image_upload_validate($_FILES['banner']);
		if($banner_valid === false) {
			$valid = 0;
			$error_message .= 'Unggah gambar JPG atau PNG yang valid untuk Banner, dengan ukuran maksimal 3 MB.<br>';
		}
	}

	if($valid == 1) {

		$statement = $pdo->prepare("SELECT * FROM tbl_service WHERE id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$current_name = $row['name'];
		}

		if($_POST['slug'] == '') {
    		// generate slug
    		$temp_string = strtolower($_POST['name']);
    		$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string);
    	} else {
    		$temp_string = strtolower($_POST['slug']);
    		$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string);
    	}

    	// if slug already exists, then rename it
		$statement = $pdo->prepare("SELECT * FROM tbl_service WHERE slug=? AND name!=?");
		$statement->execute(array($slug,$current_name));
		$total = $statement->rowCount();
		if($total) {
			$slug = $slug.'-1';
		}

		$final_name = $_POST['current_photo'];   // default: tetap pakai yang lama
		$final_name1 = $_POST['current_banner']; // default: tetap pakai yang lama
		$save_failed = false;

		if($has_new_photo) {
			$final_name = image_upload_save_as_webp(
				$_FILES['photo'],
				'service-'.$_REQUEST['id'],
				__DIR__.'/../assets/uploads/'
			);
			if($final_name === false) {
				$save_failed = true;
			}
		}

		if($has_new_banner) {
			$final_name1 = image_upload_save_as_webp(
				$_FILES['banner'],
				'service-banner-'.$_REQUEST['id'],
				__DIR__.'/../assets/uploads/'
			);
			if($final_name1 === false) {
				$save_failed = true;
			}
		}

		if($save_failed) {
			$error_message .= 'Gambar tidak dapat diunggah.<br>';
		} else {

			$statement = $pdo->prepare("UPDATE tbl_service SET name=?, slug=?, description=?, short_description=?, photo=?, banner=?, meta_title=?, meta_keyword=?, meta_description=? WHERE id=?");
			$statement->execute(array($_POST['name'],$slug,$_POST['description'],$_POST['short_description'],$final_name,$final_name1,$_POST['meta_title'],$_POST['meta_keyword'],$_POST['meta_description'],$_REQUEST['id']));

			// Hapus file lama SETELAH update berhasil & namanya beda
			if($has_new_photo && $_POST['current_photo'] !== $final_name) {
				$old_path = __DIR__.'/../assets/uploads/'.basename($_POST['current_photo']);
				if(is_file($old_path)) {
					unlink($old_path);
				}
			}
			if($has_new_banner && $_POST['current_banner'] !== $final_name1) {
				$old_path1 = __DIR__.'/../assets/uploads/'.basename($_POST['current_banner']);
				if(is_file($old_path1)) {
					unlink($old_path1);
				}
			}

			$success_message = 'Service is updated successfully!';
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
	$statement = $pdo->prepare("SELECT * FROM tbl_service WHERE id=?");
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
		<h1>Edit Service</h1>
	</div>
			<a href="service.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left" style="text-align: center;"></i> View All</a>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_service WHERE id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$name              = $row['name'];
	$slug              = $row['slug'];
	$description       = $row['description'];
	$short_description = $row['short_description'];
	$photo             = $row['photo'];
	$banner            = $row['banner'];
	$meta_title        = $row['meta_title'];
	$meta_keyword      = $row['meta_keyword'];
	$meta_description  = $row['meta_description'];
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
				<input type="hidden" name="current_photo" value="<?php echo $photo; ?>">
				<input type="hidden" name="current_banner" value="<?php echo $banner; ?>">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Name <span>*</span></label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="name" value="<?php echo $name; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Slug </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="slug" value="<?php echo $slug; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Description <span>*</span></label>
							<div class="col-sm-9">
								<textarea class="form-control editor" name="description"><?php echo $description; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Short Description <span>*</span></label>
							<div class="col-sm-9">
								<textarea class="form-control" name="short_description" style="height:140px;"><?php echo $short_description; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Existing Photo</label>
							<div class="col-sm-9" style="padding-top:5px">
								<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $photo; ?>" alt="Service Photo" style="width:400px;">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Photo </label>
							<div class="col-sm-6" style="padding-top:5px">
								<input type="file" name="photo">(Only JPG or PNG, max 3 MB)
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Existing Banner</label>
							<div class="col-sm-9" style="padding-top:5px">
								<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $banner; ?>" alt="Service Banner Photo" style="width:400px;">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Banner </label>
							<div class="col-sm-6" style="padding-top:5px">
								<input type="file" name="banner">(Only JPG or PNG, max 3 MB)
							</div>
						</div>
						<h3 class="seo-info">SEO Information</h3>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Meta Title </label>
							<div class="col-sm-9">
								<input type="text" autocomplete="off" class="form-control" name="meta_title" value="<?php echo $meta_title; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Meta Keywords </label>
							<div class="col-sm-9">
								<input type="text" autocomplete="off" class="form-control" name="meta_keyword" value="<?php echo $meta_keyword; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Meta Description </label>
							<div class="col-sm-9">
								<textarea class="form-control" name="meta_description" style="height:140px;"><?php echo $meta_description; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>