<?php require_once('header.php'); ?>
<?php require_once('image-upload-utils.php'); ?>

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

	$image_valid = isset($_FILES['photo']) ? image_upload_validate($_FILES['photo']) : false;
	if($image_valid === false) {
		$valid = 0;
		$error_message .= 'Unggah gambar JPG atau PNG yang valid untuk featured photo, dengan ukuran maksimal 3 MB.<br>';
	}

	$banner_valid = isset($_FILES['banner']) ? image_upload_validate($_FILES['banner']) : false;
	if($banner_valid === false) {
		$valid = 0;
		$error_message .= 'Unggah gambar JPG atau PNG yang valid untuk banner, dengan ukuran maksimal 3 MB.<br>';
	}

	if($valid == 1) {

		// getting auto increment id
		$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_service'");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row) {
			$ai_id=$row[10];
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
		$statement = $pdo->prepare("SELECT * FROM tbl_service WHERE slug=?");
		$statement->execute(array($slug));
		$total = $statement->rowCount();
		if($total) {
			$slug = $slug.'-1';
		}

		$final_name = image_upload_save_as_webp(
			$_FILES['photo'],
			'service-'.$ai_id,
			__DIR__.'/../assets/uploads/'
		);

		$final_name1 = image_upload_save_as_webp(
			$_FILES['banner'],
			'service-banner-'.$ai_id,
			__DIR__.'/../assets/uploads/'
		);

		if($final_name === false || $final_name1 === false) {
			$error_message .= 'Gambar tidak dapat diunggah.<br>';
		} else {

			$statement = $pdo->prepare("INSERT INTO tbl_service (name,slug,description,short_description,photo,banner,meta_title,meta_keyword,meta_description) VALUES (?,?,?,?,?,?,?,?,?)");
			$statement->execute(array($_POST['name'],$slug,$_POST['description'],$_POST['short_description'],$final_name,$final_name1,$_POST['meta_title'],$_POST['meta_keyword'],$_POST['meta_description']));

			$success_message = 'Service is added successfully!';

			unset($_POST['name']);
			unset($_POST['slug']);
			unset($_POST['description']);
			unset($_POST['short_description']);
			unset($_POST['meta_title']);
			unset($_POST['meta_keyword']);
			unset($_POST['meta_description']);
		}
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Service</h1>
	</div>
	<div class="content-header-right">
		<a href="service.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


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
							<label for="" class="col-sm-2 control-label">Name <span>*</span></label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="name" value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Slug </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="slug" value="<?php if(isset($_POST['slug'])){echo $_POST['slug'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Description <span>*</span></label>
							<div class="col-sm-9">
								<textarea class="form-control editor" name="description"><?php if(isset($_POST['description'])){echo $_POST['description'];} ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Short Description <span>*</span></label>
							<div class="col-sm-9">
								<textarea class="form-control" name="short_description" style="height:140px;"><?php if(isset($_POST['short_description'])){echo $_POST['short_description'];} ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Featured Photo <span>*</span></label>
							<div class="col-sm-9" style="padding-top:5px">
								<input type="file" name="photo">(Only JPG or PNG, max 3 MB)
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Banner Photo <span>*</span></label>
							<div class="col-sm-9" style="padding-top:5px">
								<input type="file" name="banner">(Only JPG or PNG, max 3 MB)
							</div>
						</div>
						<h3 class="seo-info">SEO Information</h3>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Meta Title </label>
							<div class="col-sm-9">
								<input type="text" autocomplete="off" class="form-control" name="meta_title" value="<?php if(isset($_POST['meta_title'])){echo $_POST['meta_title'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Meta Keywords </label>
							<div class="col-sm-9">
								<input type="text" autocomplete="off" class="form-control" name="meta_keyword" value="<?php if(isset($_POST['meta_keyword'])){echo $_POST['meta_keyword'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Meta Description </label>
							<div class="col-sm-9">
								<textarea class="form-control" name="meta_description" style="height:140px;"><?php if(isset($_POST['meta_description'])){echo $_POST['meta_description'];} ?></textarea>
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