<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
    $valid = 1;

    if(empty($_POST['id_cabang'])) {
        $valid = 0;
        $error_message .= "Branch can not be empty<br>";
    }

    $path = $_FILES['foto']['name'];
    $path_tmp = $_FILES['foto']['tmp_name'];

    if($path == '') {
        $valid = 0;
        $error_message .= "You must have to select a photo<br>";
    } else {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {

        // getting auto increment id for renaming
        $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_cabang_galeri'");
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row) {
            $ai_id=$row[10];
        }

        $final_name = 'branch-gallery-'.$ai_id.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

        $statement = $pdo->prepare("INSERT INTO tbl_cabang_galeri (id_cabang, foto) VALUES (?,?)");
        $statement->execute(array($_POST['id_cabang'],$final_name));

        $_SESSION['success_message'] = 'Branch gallery is added successfully.';
        header('Location: branch-galleries.php');
        exit;
    }
}

$statement = $pdo->prepare("SELECT id, nama_cabang FROM tbl_cabang ORDER BY nama_cabang ASC");
$statement->execute();
$cabang_list = $statement->fetchAll();
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Branch Gallery</h1>
    </div>
    <div class="content-header-right">
        <a href="branch-galleries.php" class="btn btn-primary btn-sm">View All</a>
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
                                    <option value="<?php echo $cabang['id']; ?>" <?php echo (isset($_POST['id_cabang']) && $_POST['id_cabang'] == $cabang['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cabang['nama_cabang']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Upload Photo <span>*</span></label>
                            <div class="col-sm-4" style="padding-top:6px;">
                                <input type="file" name="foto">
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
