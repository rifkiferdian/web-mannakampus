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
if(!isset($_REQUEST['id'])) {
    header('Location: branch-galleries.php');
    exit;
} else {
    $id = $_REQUEST['id'];
}

if(isset($_POST['form1'])) {
    $valid = 1;

    if(empty($_POST['id_cabang'])) {
        $valid = 0;
        $error_message .= "Branch can not be empty<br>";
    }

    $path = $_FILES['foto']['name'];
    $path_tmp = $_FILES['foto']['tmp_name'];

    if($path != '') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if($valid == 1) {
        if($path == '') {
            $statement = $pdo->prepare("UPDATE tbl_cabang_galeri SET id_cabang = ? WHERE id = ?");
            $statement->execute(array($_POST['id_cabang'],$id));
        } else {
            // get old photo name
            $statement = $pdo->prepare("SELECT foto FROM tbl_cabang_galeri WHERE id = ?");
            $statement->execute(array($id));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row) {
                $old_photo = $row['foto'];
            }

            // generate new name
            $ext = pathinfo( $path, PATHINFO_EXTENSION );
            $final_name = 'branch-gallery-'.$id.'.'.$ext;

            // upload new
            move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

            // delete old
            if($old_photo != '' && file_exists('../assets/uploads/'.$old_photo)){
                @unlink('../assets/uploads/'.$old_photo);
            }

            $statement = $pdo->prepare("UPDATE tbl_cabang_galeri SET id_cabang = ?, foto = ? WHERE id = ?");
            $statement->execute(array($_POST['id_cabang'],$final_name,$id));
        }

        $_SESSION['success_message'] = 'Branch gallery is updated successfully.';
        header('Location: branch-galleries.php');
        exit;
    }
}

$statement = $pdo->prepare("SELECT * FROM tbl_cabang_galeri WHERE id = ?");
$statement->execute(array($id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) {
    $id_cabang_db = $row['id_cabang'];
    $foto_db = $row['foto'];
}

$statement = $pdo->prepare("SELECT id, nama_cabang FROM tbl_cabang ORDER BY nama_cabang ASC");
$statement->execute();
$cabang_list = $statement->fetchAll();
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Branch Gallery</h1>
    </div>
		<a href="branch-galleries.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left" style="text-align: center;"></i> View All</a>
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
                                    <option value="<?php echo $cabang['id']; ?>" <?php echo ($id_cabang_db == $cabang['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cabang['nama_cabang']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Current Photo</label>
                            <div class="col-sm-4" style="padding-top:6px;">
                                <?php if($foto_db != ''): ?>
                                    <img src="../assets/uploads/<?php echo htmlspecialchars($foto_db); ?>" style="max-width:150px;" class="img-thumbnail">
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Replace Photo</label>
                            <div class="col-sm-4" style="padding-top:6px;">
                                <input type="file" name="foto">
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
