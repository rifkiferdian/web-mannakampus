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

    if(empty($_POST['nama_cabang'])) {
        $valid = 0;
        $error_message .= "Nama Cabang can not be empty<br>";
    } else {
		// current nama_cabang that is in the database (for duplicate checking)
    	$statement = $pdo->prepare("SELECT * FROM tbl_cabang WHERE id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$current_nama_cabang = $row['nama_cabang'];
		}

		$statement = $pdo->prepare("SELECT * FROM tbl_cabang WHERE nama_cabang=? and nama_cabang!=?");
    	$statement->execute(array($_POST['nama_cabang'],$current_nama_cabang));
    	$total = $statement->rowCount();
    	if($total) {
    		$valid = 0;
        	$error_message .= 'Nama Cabang already exists<br>';
    	}
    }

    if(empty($_POST['alamat'])) {
        $valid = 0;
        $error_message .= "Alamat can not be empty<br>";
    }

    // Cek apakah user mengunggah file foto baru
    $has_new_image = isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE;

    if($has_new_image) {
        $image_valid = image_upload_validate($_FILES['foto']);
        if($image_valid === false) {
            $valid = 0;
            $error_message .= 'Unggah gambar JPG atau PNG yang valid dengan ukuran maksimal 3 MB.<br>';
        }
    }

    if($valid == 1) {

    	$final_name = $_POST['current_foto']; // default: tetap pakai yang lama

    	if($has_new_image) {
    		$final_name = image_upload_save_as_webp(
    			$_FILES['foto'],
    			'cabang-foto-'.$_REQUEST['id'],
    			__DIR__.'/../assets/uploads/'
    		);

    		if($final_name === false) {
    			$valid = 0;
    			$error_message .= 'Gambar tidak dapat diunggah.<br>';
    		}
    	}

    	if($valid == 1) {

    		if(!$has_new_image) {
				// updating into the database (no new photo uploaded)
				$statement = $pdo->prepare("UPDATE tbl_cabang SET nama_cabang=?, alamat=?, jam_operasional=?, kontak=?, badge_tipe=?, link_maps=? WHERE id=?");
				$statement->execute(array($_POST['nama_cabang'],$_POST['alamat'],$_POST['jam_operasional'],$_POST['kontak'],$_POST['badge_tipe'],$_POST['link_maps'],$_REQUEST['id']));
	   		} else {
				// updating into the database (with new photo)
				$statement = $pdo->prepare("UPDATE tbl_cabang SET nama_cabang=?, alamat=?, jam_operasional=?, kontak=?, badge_tipe=?, foto=?, link_maps=? WHERE id=?");
				$statement->execute(array($_POST['nama_cabang'],$_POST['alamat'],$_POST['jam_operasional'],$_POST['kontak'],$_POST['badge_tipe'],$final_name,$_POST['link_maps'],$_REQUEST['id']));

				// Hapus file lama SETELAH update berhasil, kalau bukan default & namanya beda
				if($_POST['current_foto']!='default.jpg' && $_POST['current_foto'] !== $final_name) {
					$old_path = __DIR__.'/../assets/uploads/'.basename($_POST['current_foto']);
					if(is_file($old_path)) {
						unlink($old_path);
					}
				}
	   		}

	    	$_SESSION['success_message'] = 'Branch info is updated successfully.';
	    	header('location: branch-info.php');
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
	$statement = $pdo->prepare("SELECT * FROM tbl_cabang WHERE id=?");
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
		<h1>Edit Branch Info</h1>
	</div>
	<a href="branch-info.php" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left" style="text-align: center;"></i> View All</a>
</section>


<?php
foreach ($result as $row) {
	$nama_cabang     = $row['nama_cabang'];
	$alamat          = $row['alamat'];
	$jam_operasional = $row['jam_operasional'];
	$kontak          = $row['kontak'];
	$badge_tipe      = $row['badge_tipe'];
	$foto            = $row['foto'];
	$link_maps       = $row['link_maps'];
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
		<input type="hidden" name="current_foto" value="<?php echo $foto; ?>">
        <div class="box box-info">

            <div class="box-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Nama Cabang <span>*</span></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="nama_cabang" value="<?php echo $nama_cabang; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Alamat <span>*</span></label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="alamat" style="height:80px;"><?php echo $alamat; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Jam Operasional</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="jam_operasional" value="<?php echo $jam_operasional; ?>" placeholder="Contoh: Buka - 08.30 - 21.30">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Kontak</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="kontak" value="<?php echo $kontak; ?>">
                    </div>
                </div>
                <div class="form-group">
					<label for="" class="col-sm-2 control-label">Badge Tipe</label>
					<div class="col-sm-2">
						<select class="form-control select2" name="badge_tipe" style="width:300px;">
							<option value="SUPERMARKET" <?php if($badge_tipe=='SUPERMARKET') {echo 'selected';} ?>>SUPERMARKET</option>
							<option value="MINIMARKET" <?php if($badge_tipe=='MINIMARKET') {echo 'selected';} ?>>MINIMARKET</option>
						</select>
					</div>
				</div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Link Maps</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="link_maps" value="<?php echo $link_maps; ?>">
                    </div>
                </div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">Existing Foto</label>
					<div class="col-sm-9" style="padding-top:5px">
						<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $foto; ?>" alt="Branch Photo" style="width:200px;">
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">Foto</label>
					<div class="col-sm-9" style="padding-top:5px">
						<input type="file" name="foto">(Only JPG or PNG, max 3 MB)
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

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>