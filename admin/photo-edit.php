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

	if(empty($_POST['photo_caption'])) {
        $valid = 0;
        $error_message .= "Photo Caption Name can not be empty<br>";
    }

    // Cek apakah user mengunggah file foto baru
    $has_new_image = isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE;

    if($has_new_image) {
        $image_valid = image_upload_validate($_FILES['photo']);
        if($image_valid === false) {
            $valid = 0;
            $error_message .= 'Unggah gambar JPG atau PNG yang valid dengan ukuran maksimal 3 MB.<br>';
        }
    }
       
    if($valid == 1) {

    	if(!$has_new_image) {
    		// updating into the database (no new photo uploaded)
			$statement = $pdo->prepare("UPDATE tbl_photo SET photo_caption=?, p_category_id=? WHERE photo_id=?");
			$statement->execute(array($_POST['photo_caption'],$_POST['p_category_id'],$_REQUEST['id']));

			$success_message = 'Photo is updated successfully.';
    	} else {

    		$final_name = image_upload_save_as_webp(
    			$_FILES['photo'],
    			'photo-'.$_REQUEST['id'],
    			__DIR__.'/../assets/uploads/'
    		);

    		if($final_name === false) {
    			$error_message .= 'Gambar tidak dapat diunggah.<br>';
    		} else {
	        	// updating into the database (with new photo)
				$statement = $pdo->prepare("UPDATE tbl_photo SET photo_caption=?, photo_name=?, p_category_id=? WHERE photo_id=?");
				$statement->execute(array($_POST['photo_caption'],$final_name,$_POST['p_category_id'],$_REQUEST['id']));

				// Hapus foto lama SETELAH update berhasil & namanya beda
				if($_POST['previous_photo'] !== $final_name) {
					$old_path = __DIR__.'/../assets/uploads/'.basename($_POST['previous_photo']);
					if(is_file($old_path)) {
						unlink($old_path);
					}
				}

				$success_message = 'Photo is updated successfully.';
    		}
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
	$statement = $pdo->prepare("SELECT * FROM tbl_photo WHERE photo_id=?");
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
		<h1>Edit Photo</h1>
	</div>
			<a href="photo.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left" style="text-align: center;"></i> View All</a>
</section>

<?php							
foreach ($result as $row) {
	$photo_caption = $row['photo_caption'];
	$photo_name = $row['photo_name'];
	$p_category_id = $row['p_category_id'];
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
							<label for="" class="col-sm-2 control-label">Photo Caption <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="photo_caption" value="<?php echo $photo_caption ?>">
							</div>
						</div>
						<div class="form-group">
				            <label for="" class="col-sm-2 control-label">Existing Photo</label>
				            <div class="col-sm-6" style="padding-top:6px;">
				                <img src="../assets/uploads/<?php echo $photo_name; ?>" class="existing-photo" style="width:300px;">

				                <input type="hidden" name="previous_photo" value="<?php echo $photo_name; ?>">
				            </div>
				        </div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Upload New Photo</label>
							<div class="col-sm-4" style="padding-top:6px;">
								<input type="file" name="photo"> (Only JPG or PNG, max 3 MB)
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Photo Category <span>*</span></label>
							<div class="col-sm-4">
								<select class="form-control" name="p_category_id">
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_category_photo ORDER BY p_category_name ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
									foreach ($result as $row) {
										if($row['p_category_id'] == $p_category_id) {
											$selected = 'selected';
										} else {
											$selected = '';
										}
										echo '<option value="'.$row['p_category_id'].'" '.$selected.'>'.$row['p_category_name'].'</option>';
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