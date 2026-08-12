<?php require_once('header.php'); ?>
<?php
function extract_video_url($input) {
    $input = trim($input);

    if (stripos($input, '<iframe') !== false) {
        if (preg_match('/src=["\']([^"\']+)["\']/i', $input, $matches)) {
            return trim(html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8'));
        }
    }

    return $input;
}
?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

	if(empty($_POST['id_cabang'])) {
		$valid = 0;
		$error_message .= "Branch can not be empty<br>";
	}

	if(empty($_POST['judul_video'])) {
		$valid = 0;
		$error_message .= "Video Title can not be empty<br>";
	}

		$clean_link_video = extract_video_url($_POST['link_video']);

	if (empty($clean_link_video) || !filter_var($clean_link_video, FILTER_VALIDATE_URL)) {
		$valid = 0;
		$error_message .= "Video Link harus berupa URL yang valid<br>";
	}

	// Thumbnail is optional (nullable), so only validate the extension IF a file was uploaded
	$path = $_FILES['thumbnail']['name'];
	$path_tmp = $_FILES['thumbnail']['tmp_name'];
	$final_name = null;

	if($path != '') {
		$ext = pathinfo( $path, PATHINFO_EXTENSION );
		if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
			$valid = 0;
			$error_message .= 'You must have to upload jpg, jpeg, gif or png file for thumbnail<br>';
		}
	}

	if($valid == 1) {

		// handle thumbnail upload only if a file was provided
		if($path != '') {
			// getting auto increment id
			$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_cabang_video'");
			$statement->execute();
			$result = $statement->fetchAll();
			foreach($result as $row) {
				$ai_id = $row[10];
			}

			$final_name = 'video-thumbnail-'.$ai_id.'.'.$ext;
			move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );
		}

		// saving into the database
		$statement = $pdo->prepare("INSERT INTO tbl_cabang_video (id_cabang, judul_video, deskripsi_video, link_video, thumbnail) VALUES (?,?,?,?,?)");
		$statement->execute(array(
			$_POST['id_cabang'],
			$_POST['judul_video'],
			$_POST['deskripsi_video'],
			$clean_link_video,
			$final_name
		));

		$_SESSION['success_message'] ='Branch video is added successfully.';
		header('Location: branch-videos.php');
		exit;
	}
}

// fetch branch list for the dropdown
$statement = $pdo->prepare("SELECT id, nama_cabang FROM tbl_cabang ORDER BY nama_cabang ASC");
$statement->execute();
$cabang_list = $statement->fetchAll();
?>

<section class="content-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">
	<div class="content-header-left">
		<h1 style="margin:0;">Add Branch Video</h1>
	</div>
	<div class="content-header-right">
		<a href="branch-videos.php" class="btn btn-primary btn-sm">View All</a>
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
							<label for="" class="col-sm-2 control-label">Branch <span>*</span></label>
							<div class="col-sm-4">
								<select class="form-control" name="id_cabang">
									<option value="">-- Select Branch --</option>
									<?php foreach($cabang_list as $cabang): ?>
									<option value="<?php echo $cabang['id']; ?>"><?php echo htmlspecialchars($cabang['nama_cabang']); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Video Title <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="judul_video" placeholder="Example: Video Profile Manna Kampus">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Video Description</label>
							<div class="col-sm-6">
								<textarea class="form-control" name="deskripsi_video" rows="3" placeholder="Optional description"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Video Link <span>*</span></label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="link_video" placeholder="Example: https://www.youtube.com/embed/xxxxxxxxxxx">
								<p class="help-block">Boleh paste URL langsung, atau kode &lt;iframe&gt; lengkap — otomatis diambil URL-nya saja saat disimpan.</p>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Thumbnail</label>
							<div class="col-sm-9" style="padding-top:5px">
								<input type="file" name="thumbnail">(Only jpg, jpeg, gif and png are allowed — optional)
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