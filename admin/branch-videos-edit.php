<?php require_once('header.php'); ?>

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
// Helper: kalau user paste kode <iframe ...> lengkap, ambil URL dari atribut src-nya.
// Kalau yang dipaste sudah berupa URL polos, langsung dipakai apa adanya.
function extract_video_url($input) {
	$input = trim($input);
	if (stripos($input, '<iframe') !== false) {
		if (preg_match('/src=["\']([^"\']+)["\']/i', $input, $matches)) {
			return trim($matches[1]);
		}
	}
	return $input;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// ambil data video yang mau diedit
$statement = $pdo->prepare("SELECT * FROM tbl_cabang_video WHERE id = ?");
$statement->execute(array($id));
$data = $statement->fetch(PDO::FETCH_ASSOC);

if (!$data) {
	header('Location: branch-videos.php');
	exit;
}

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

	// Thumbnail opsional — hanya divalidasi kalau ada file baru yang diupload
	$path = $_FILES['thumbnail']['name'];
	$path_tmp = $_FILES['thumbnail']['tmp_name'];
	$final_name = $data['thumbnail']; // default: pertahankan thumbnail lama

	if($path != '') {
		$ext = pathinfo( $path, PATHINFO_EXTENSION );
		if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
			$valid = 0;
			$error_message .= 'You must have to upload jpg, jpeg, gif or png file for thumbnail<br>';
		}
	}


	if($valid == 1) {

		// handle thumbnail upload baru kalau ada
		if($path != '') {
			$final_name = 'video-thumbnail-'.$id.'.'.$ext;
			move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );
		}

		// update ke database
		$statement = $pdo->prepare("UPDATE tbl_cabang_video SET id_cabang=?, judul_video=?, deskripsi_video=?, link_video=?, thumbnail=? WHERE id=?");
		$statement->execute(array(
			$_POST['id_cabang'],
			$_POST['judul_video'],
			$_POST['deskripsi_video'],
			$clean_link_video,
			$final_name,
			$id
		));

		$_SESSION['success_message'] = 'Branch video is updated successfully.';
		header('Location: branch-videos.php');
		exit;
	}

	// kalau gagal validasi, tampilkan ulang form dengan data yang baru diketik user
	$data['id_cabang'] = $_POST['id_cabang'];
	$data['judul_video'] = $_POST['judul_video'];
	$data['deskripsi_video'] = $_POST['deskripsi_video'];
	$data['link_video'] = $clean_link_video;
}

// fetch branch list for the dropdown
$statement = $pdo->prepare("SELECT id, nama_cabang FROM tbl_cabang ORDER BY nama_cabang ASC");
$statement->execute();
$cabang_list = $statement->fetchAll();
?>

<section class="content-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">
	<div class="content-header-left">
		<h1 style="margin:0;">Edit Branch Video</h1>
	</div>
		<a href="branch-videos.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left" style="text-align: center;"></i> View All</a>
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
									<option value="<?php echo $cabang['id']; ?>" <?php echo ($data['id_cabang'] == $cabang['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cabang['nama_cabang']); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Video Title <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="judul_video" value="<?php echo htmlspecialchars($data['judul_video'] ?? ''); ?>" placeholder="Example: Video Profile Manna Kampus">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Video Description</label>
							<div class="col-sm-6">
								<textarea class="form-control" name="deskripsi_video" rows="3" placeholder="Optional description"><?php echo htmlspecialchars($data['deskripsi_video'] ?? ''); ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Video Link <span>*</span></label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="link_video" value="<?php echo htmlspecialchars($data['link_video'] ?? ''); ?>" placeholder="Example: https://www.youtube.com/embed/xxxxxxxxxxx">
								<p class="help-block">Boleh paste URL langsung, atau kode &lt;iframe&gt; lengkap — otomatis diambil URL-nya saja saat disimpan.</p>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Existing Thumbnail</label>
							<div class="col-sm-9">
								<?php if(!empty($data['thumbnail'])): ?>
									<img src="../assets/uploads/<?php echo htmlspecialchars($data['thumbnail']); ?>" alt="thumbnail" style="max-width:150px; display:block; margin-bottom:8px;">
								<?php else: ?>
									<p class="text-muted">No thumbnail uploaded</p>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Thumbnail</label>
							<div class="col-sm-9" style="padding-top:5px">
								<input type="file" name="thumbnail">(Only jpg, jpeg, gif and png are allowed — leave empty to keep the current thumbnail)
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
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