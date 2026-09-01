<?php require_once('header.php'); ?>
<?php require_once('image-upload-utils.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;


	if(empty($_POST['name'])) {
		$valid = 0;
		$error_message .= 'Name can not be empty<br>';
	}

    if(empty($_POST['designation_id'])) {
		$valid = 0;
		$error_message .= 'You must have to select a designation<br>';
	}

	// ══ Validasi foto (photo) ══
	$has_photo = isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE;
	if($has_photo) {
		$photo_valid = image_upload_validate($_FILES['photo']);
		if($photo_valid === false) {
			$valid = 0;
			$error_message .= 'Unggah gambar JPG atau PNG yang valid (maks 3 MB) untuk foto penghargaan<br>';
		}
	} else {
		$valid = 0;
		$error_message .= 'You must have to select a photo for team member photo<br>';
	}

	// ══ Validasi banner ══
	$has_banner = isset($_FILES['banner']) && $_FILES['banner']['error'] !== UPLOAD_ERR_NO_FILE;
	if($has_banner) {
		$banner_valid = image_upload_validate($_FILES['banner']);
		if($banner_valid === false) {
			$valid = 0;
			$error_message .= 'Unggah gambar JPG atau PNG yang valid (maks 3 MB) untuk banner<br>';
		}
	} else {
		$valid = 0;
		$error_message .= 'You must have to select a photo for banner<br>';
	}

	if($valid == 1) {

		// getting auto increment id
		$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_team_member'");
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
		$statement = $pdo->prepare("SELECT * FROM tbl_team_member WHERE slug=?");
		$statement->execute(array($slug));
		$total = $statement->rowCount();
		if($total) {
			$slug = $slug.'-1';
		}

		// ══ Simpan foto sebagai WebP ══
		$final_name = image_upload_save_as_webp(
			$_FILES['photo'],
			'team-member-'.$ai_id,
			__DIR__.'/../assets/uploads/'
		);
		if($final_name === false) {
			$valid = 0;
			$error_message .= 'Gambar foto tidak dapat diunggah.<br>';
		}

		// ══ Simpan banner sebagai WebP ══
		$final_name1 = image_upload_save_as_webp(
			$_FILES['banner'],
			'team-member-banner-'.$ai_id,
			__DIR__.'/../assets/uploads/'
		);
		if($final_name1 === false) {
			$valid = 0;
			$error_message .= 'Gambar banner tidak dapat diunggah.<br>';
		}

		if($valid == 1) {
			$statement = $pdo->prepare("INSERT INTO tbl_team_member (name,slug,designation_id,photo,banner,degree,detail,facebook,twitter,linkedin,youtube,google_plus,instagram,flickr,address,practice_location,phone,email,website,status,meta_title,meta_keyword,meta_description) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$statement->execute(array($_POST['name'],$slug,$_POST['designation_id'],$final_name,$final_name1,$_POST['degree'],$_POST['detail'],$_POST['facebook'],$_POST['twitter'],$_POST['linkedin'],$_POST['youtube'],$_POST['google_plus'],$_POST['instagram'],$_POST['flickr'],$_POST['address'],$_POST['practice_location'],$_POST['phone'],$_POST['email'],$_POST['website'],$_POST['status'],$_POST['meta_title'],$_POST['meta_keyword'],$_POST['meta_description']));

			$success_message = 'Penghargaan berhasil ditambahkan!';

			unset($_POST['name']);
			unset($_POST['slug']);
			unset($_POST['degree']);
			unset($_POST['detail']);
			unset($_POST['facebook']);
			unset($_POST['twitter']);
			unset($_POST['linkedin']);
			unset($_POST['youtube']);
			unset($_POST['google_plus']);
			unset($_POST['instagram']);
			unset($_POST['flickr']);
			unset($_POST['address']);
			unset($_POST['practice_location']);
			unset($_POST['phone']);
			unset($_POST['email']);
			unset($_POST['website']);
			unset($_POST['meta_title']);
			unset($_POST['meta_keyword']);
			unset($_POST['meta_description']);
		}
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Tambah Penghargaan MannaKampus</h1>
	</div>
	<div class="content-header-right">
		<a href="team-member.php" class="btn btn-primary btn-sm">View All</a>
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
							<label for="" class="col-sm-2 control-label">Nama Penghargaan <span>*</span></label>
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
					            <label for="" class="col-sm-2 control-label">Kategori Penghargaan <span>*</span></label>
				            <div class="col-sm-3">
				            	<select class="form-control select2" name="designation_id" style="width:300px;">
					            		<option value="">Pilih kategori</option>
				            		<?php
						            	$i=0;
						            	$statement = $pdo->prepare("SELECT * FROM tbl_designation ORDER BY designation_name ASC");
						            	$statement->execute();
						            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
						            	foreach ($result as $row) {
						            		?>
											<option value="<?php echo $row['designation_id']; ?>"><?php echo $row['designation_name']; ?></option>
						            		<?php
						            	}
					            	?>
				            	</select>
				            </div>
				        </div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Gambar Penghargaan <span>*</span></label>
							<div class="col-sm-9" style="padding-top:5px">
								<input type="file" name="photo">(Only jpg and png are allowed, max 3 MB)
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Banner <span>*</span></label>
							<div class="col-sm-9" style="padding-top:5px">
								<input type="file" name="banner">(Only jpg and png are allowed, max 3 MB)
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Tahun / Keterangan Singkat </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="degree" value="<?php if(isset($_POST['degree'])){echo $_POST['degree'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Detail Penghargaan </label>
							<div class="col-sm-9">
								<textarea class="form-control editor" name="detail"><?php if(isset($_POST['detail'])){echo $_POST['detail'];} ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Facebook </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="facebook" value="<?php if(isset($_POST['facebook'])){echo $_POST['facebook'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Twitter </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="twitter" value="<?php if(isset($_POST['twitter'])){echo $_POST['twitter'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">LinkedIn </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="linkedin" value="<?php if(isset($_POST['linkedin'])){echo $_POST['linkedin'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">YouTube </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="youtube" value="<?php if(isset($_POST['youtube'])){echo $_POST['youtube'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Google Plus </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="google_plus" value="<?php if(isset($_POST['google_plus'])){echo $_POST['google_plus'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Instagram </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="instagram" value="<?php if(isset($_POST['instagram'])){echo $_POST['instagram'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Flickr </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="flickr" value="<?php if(isset($_POST['flickr'])){echo $_POST['flickr'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Address </label>
							<div class="col-sm-6">
								<textarea class="form-control" name="address" style="height: 140px"><?php if(isset($_POST['address'])){echo $_POST['address'];} ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Practice Location </label>
							<div class="col-sm-6">
								<textarea class="form-control" name="practice_location" style="height: 140px"><?php if(isset($_POST['practice_location'])){echo $_POST['practice_location'];} ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Phone </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="phone" value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Email Address </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Website </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="website" value="<?php if(isset($_POST['website'])){echo $_POST['website'];} ?>">
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