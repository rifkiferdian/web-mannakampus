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

	// ══ Cek apakah user upload file baru ══
	$has_new_photo = isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE;

	// ══ Validasi HANYA kalau ada file baru ══
	if($has_new_photo) {
		$photo_valid = image_upload_validate($_FILES['photo']);
		if($photo_valid === false) {
			$valid = 0;
			$error_message .= 'Unggah gambar JPG atau PNG yang valid dengan ukuran maksimal 3 MB.<br>';
		}
	}

	if($valid == 1) {

		$final_name = $_POST['current_photo']; // default: tetap pakai yang lama

		if($has_new_photo) {
			$final_name = image_upload_save_as_webp(
				$_FILES['photo'],
				'partner-'.$_REQUEST['id'],
				__DIR__.'/../assets/uploads/'
			);
			if($final_name === false) {
				$valid = 0;
				$error_message .= 'Gambar tidak dapat diunggah.<br>';
			}
		}

		if($valid == 1) {
			$statement = $pdo->prepare("UPDATE tbl_partner SET name=?, url=?, photo=? WHERE id=?");
			$statement->execute(array($_POST['name'],$_POST['url'],$final_name,$_REQUEST['id']));

			// ══ Hapus file lama SETELAH update berhasil & namanya beda ══
			if($has_new_photo && $_POST['current_photo'] !== $final_name) {
				$old_path = __DIR__.'/../assets/uploads/'.basename($_POST['current_photo']);
				if(!empty($_POST['current_photo']) && is_file($old_path)) {
					unlink($old_path);
				}
			}

		    $success_message = 'Partner is updated successfully!';
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
	$statement = $pdo->prepare("SELECT * FROM tbl_partner WHERE id=?");
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
		<h1>Edit Partner</h1>
	</div>
			<a href="partner.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left" style="text-align: center;"></i> View All</a>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_partner WHERE id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$name  = $row['name'];
	$url   = $row['url'];
	$photo = $row['photo'];
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
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Name <span>*</span></label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="name" value="<?php echo $name; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">URL </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="url" value="<?php echo $url; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Existing Photo </label>
							<div class="col-sm-9" style="padding-top:5px">
								<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $photo; ?>" alt="Slider Photo" style="width:180px;">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Photo </label>
							<div class="col-sm-6" style="padding-top:5px">
								<input type="file" name="photo">(Only jpg and png are allowed, max 3 MB)
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