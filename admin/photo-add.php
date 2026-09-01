<?php require_once('header.php'); ?>
<?php require_once('image-upload-utils.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['photo_caption'])) {
        $valid = 0;
        $error_message .= "Photo Caption Name can not be empty<br>";
    }

    $image_valid = isset($_FILES['photo']) ? image_upload_validate($_FILES['photo']) : false;
    if($image_valid === false) {
        $valid = 0;
        $error_message .= 'Unggah gambar JPG atau PNG yang valid dengan ukuran maksimal 3 MB.<br>';
    }

    if(empty($_POST['p_category_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a photo category<br>";
    }
    
    if($valid == 1) {

    	// getting auto increment id for photo renaming
		$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_photo'");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row) {
			$ai_id=$row[10];
		}

		// uploading the photo, converting to webp, and giving it a final name
		$final_name = image_upload_save_as_webp(
			$_FILES['photo'],
			'photo-'.$ai_id,
			__DIR__.'/../assets/uploads/'
		);

		if($final_name === false) {
			$error_message .= 'Gambar tidak dapat diunggah.<br>';
		} else {
			// saving into the database
			$statement = $pdo->prepare("INSERT INTO tbl_photo (photo_caption,photo_name,p_category_id) VALUES (?,?,?)");
			$statement->execute(array($_POST['photo_caption'],$final_name,$_POST['p_category_id']));

			$success_message = 'Photo is added successfully.';
		}
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Photo</h1>
	</div>
	<div class="content-header-right">
		<a href="photo.php" class="btn btn-primary btn-sm">View All</a>
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
							<label for="" class="col-sm-2 control-label">Photo Caption <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="photo_caption">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Upload Photo <span>*</span></label>
							<div class="col-sm-4" style="padding-top:6px;">
								<input type="file" name="photo"> (Only JPG or PNG, max 3 MB)
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Photo Category <span>*</span></label>
							<div class="col-sm-4">
								<select class="form-control" name="p_category_id">
									<option value="">Select a photo category</option>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_category_photo ORDER BY p_category_name ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
									foreach ($result as $row) {
										echo '<option value="'.$row['p_category_id'].'">'.$row['p_category_name'].'</option>';
									}
									?>
								</select>
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