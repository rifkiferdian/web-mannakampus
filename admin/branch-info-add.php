<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['nama_cabang'])) {
        $valid = 0;
        $error_message .= "Branch Name can not be empty<br>";
    } else {
    	// Duplicate Page checking
    	$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE nama_cabang=?");
    	$statement->execute(array($_POST['nama_cabang']));
    	$total = $statement->rowCount();
    	if($total) {
    		$valid = 0;
        	$error_message .= "Page Name already exists<br>";
    	}
    }

	if(empty($_POST['alamat'])) {
        $valid = 0;
        $error_message .= "Address can not be empty<br>";
    }

    $path = $_FILES['foto']['name'];
    $path_tmp = $_FILES['foto']['tmp_name'];

    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file for photo<br>';
        }
    } else {
    	$valid = 0;
        $error_message .= 'You must have to select a photo for photo<br>';
    }

    if($valid == 1) {

    	// getting auto increment id
		$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_cabang'");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row) {
			$ai_id=$row[10];
		}

		$final_name = 'cabang-foto-'.$ai_id.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );
    	
		// saving into the database
		$statement = $pdo->prepare("INSERT INTO tbl_cabang (nama_cabang, alamat, foto) VALUES (?,?,?)");
		$statement->execute(array($_POST['nama_cabang'], $_POST['alamat'], $final_name));

    	$success_message = 'Branch information is added successfully.';
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Branch</h1>
	</div>
	<div class="content-header-right">
		<a href="branch-info.php" class="btn btn-primary btn-sm">View All</a>
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
							<label for="" class="col-sm-2 control-label">Branch Name <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="nama_cabang" placeholder="Example: About Us">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Address <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="alamat" placeholder="Example: Jl. Merdeka No. 123">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Operating Hours <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="jam_operasional" placeholder="Example: 08:00 - 20:00">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Contact <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="kontak" placeholder="Example: +62 812 3456 7890">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Badge Type <span>*</span></label>
							<div class="col-sm-4">
								<select class="form-control" name="badge_tipe">
									<option value="SUPERMARKET">SUPERMARKET</option>
									<option value="MINIMARKET">MINIMARKET</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Branch Photo <span>*</span></label>
							<div class="col-sm-9" style="padding-top:5px">
								<input type="file" name="foto">(Only jpg, jpeg, gif and png are allowed)
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Link Maps <span>*</span></label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="link_maps" placeholder="Example: https://www.google.com/maps/">
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