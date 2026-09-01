<?php require_once('header.php'); ?>
<?php require_once('image-upload-utils.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

	// ══ Foto wajib diisi ══
	$has_photo = isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE;

	if($has_photo) {
		$photo_valid = image_upload_validate($_FILES['photo']);
		if($photo_valid === false) {
			$valid = 0;
			$error_message .= 'Unggah gambar JPG atau PNG yang valid dengan ukuran maksimal 3 MB.<br>';
		}
	} else {
		$valid = 0;
		$error_message .= 'You must have to select a photo<br>';
	}

	if($valid == 1) {

		// getting auto increment id
		$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_slider'");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row) {
			$ai_id=$row[10];
		}

		// ══ Simpan foto sebagai WebP ══
		$final_name = image_upload_save_as_webp(
			$_FILES['photo'],
			'slider-'.$ai_id,
			__DIR__.'/../assets/uploads/'
		);
		if($final_name === false) {
			$valid = 0;
			$error_message .= 'Gambar tidak dapat diunggah.<br>';
		}

		if($valid == 1) {
			$statement = $pdo->prepare("INSERT INTO tbl_slider (photo,heading,content,button_text,button_url,position,status) VALUES (?,?,?,?,?,?,?)");
			$statement->execute(array($final_name,$_POST['heading'],$_POST['content'],$_POST['button_text'],$_POST['button_url'],$_POST['position'],$_POST['status']));

			$success_message = 'Slider is added successfully!';

			unset($_POST['heading']);
			unset($_POST['content']);
			unset($_POST['button_text']);
			unset($_POST['button_url']);
		}
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Slider</h1>
	</div>
	<div class="content-header-right">
		<a href="slider.php" class="btn btn-primary btn-sm">View All</a>
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
							<label for="" class="col-sm-2 control-label">Photo <span>*</span></label>
							<div class="col-sm-9" style="padding-top:5px">
								<input type="file" name="photo">(Only jpg and png are allowed, max 3 MB)
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Heading </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="heading" value="<?php if(isset($_POST['heading'])){echo $_POST['heading'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Content </label>
							<div class="col-sm-6">
								<textarea class="form-control" name="content" style="height:140px;"><?php if(isset($_POST['content'])){echo $_POST['content'];} ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Button Text </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="button_text" value="<?php if(isset($_POST['button_text'])){echo $_POST['button_text'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Button URL </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="button_url" value="<?php if(isset($_POST['button_url'])){echo $_POST['button_url'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Position </label>
							<div class="col-sm-6">
								<select name="position" class="form-control">
									<option value="Left">Left</option>
									<option value="Center">Center</option>
									<option value="Right">Right</option>
								</select>
							</div>
						</div>
				        <div class="form-group">
				            <label for="" class="col-sm-2 control-label">Active </label>
				            <div class="col-sm-6">
				                <label class="radio-inline">
				                    <input type="radio" name="status" value="Active" checked>Yes
				                </label>
				                <label class="radio-inline">
				                    <input type="radio" name="status" value="Inactive">No
				                </label>
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