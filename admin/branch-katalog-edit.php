<?php require_once('header.php'); ?>
<?php require_once('image-upload-utils.php'); ?>

<style>
.no-plus-icon::before {
    display: none !important;
}

.no-plus-icon {
    text-align: center;
}

.content-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}

.content-header h1 {
    margin: 0;
}

.content-header-right {
    margin-left: auto;
}
</style>

<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$error_message = '';

$statement = $pdo->prepare("SELECT * FROM tbl_flyer WHERE id = ?");
$statement->execute(array($id));
$data = $statement->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    header('Location: branch-katalog.php');
    exit;
}

if(isset($_POST['form1'])) {
    $valid = 1;

    if(empty($_POST['id_cabang'])) {
        $valid = 0;
        $error_message .= "Branch can not be empty<br>";
    }

    if(empty($_POST['start_date'])) {
        $valid = 0;
        $error_message .= "Start date can not be empty<br>";
    }

    if(empty($_POST['end_date'])) {
        $valid = 0;
        $error_message .= "End date can not be empty<br>";
    }

    if(!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
        if($_POST['start_date'] > $_POST['end_date']) {
            $valid = 0;
            $error_message .= "End date can not be earlier than start date<br>";
        }
    }

    // Cek apakah user mengunggah file foto baru
    $has_new_image = isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE;
    $original_image = $data['photo'];
    $final_name = $original_image;

    if($has_new_image) {
        $image_valid = image_upload_validate($_FILES['photo']);
        if($image_valid === false) {
            $valid = 0;
            $error_message .= 'Unggah gambar JPG atau PNG yang valid dengan ukuran maksimal 3 MB.<br>';
        }
    }

    if($valid == 1) {

        if($has_new_image) {
            $final_name = image_upload_save_as_webp(
                $_FILES['photo'],
                'branch-katalog-'.$id,
                __DIR__.'/../assets/uploads/'
            );

            if($final_name === false) {
                $valid = 0;
                $error_message .= 'Gambar tidak dapat diunggah.<br>';
            }
        }

        if($valid == 1) {
            $statement = $pdo->prepare("
                UPDATE tbl_flyer 
                SET id_cabang=?, photo=?, start_date=?, end_date=? 
                WHERE id=?
            ");

            $statement->execute(array(
                $_POST['id_cabang'],
                $final_name,
                $_POST['start_date'],
                $_POST['end_date'],
                $id
            ));

            // Hapus file lama SETELAH update berhasil, kalau namanya beda
            if($has_new_image && !empty($original_image) && $original_image !== $final_name) {
                $old_path = __DIR__.'/../assets/uploads/'.basename($original_image);
                if(is_file($old_path)) {
                    unlink($old_path);
                }
            }

            $_SESSION['success_message'] = 'Branch katalog is updated successfully.';

            header('Location: branch-katalog.php');
            exit;
        }
    }

    $data['id_cabang'] = $_POST['id_cabang'];
    $data['start_date'] = $_POST['start_date'];
    $data['end_date'] = $_POST['end_date'];
}

$statement = $pdo->prepare("SELECT id, nama_cabang FROM tbl_cabang ORDER BY nama_cabang ASC");
$statement->execute();
$cabang_list = $statement->fetchAll();
?>

<section class="content-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">

    <div class="content-header-left">
        <h1 style="margin:0;">Edit Branch Katalog</h1>
    </div>

    <a href="branch-katalog.php" class="btn btn-primary btn-sm no-plus-icon">
        <i class="fa fa-arrow-left" style="text-align: center;"></i> View All
    </a>

</section>

<section class="content">

    <div class="row">

        <div class="col-md-12">

            <?php if(!empty($error_message)): ?>
            <div class="callout callout-danger">
                <p><?php echo $error_message; ?></p>
            </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                <div class="box box-info">

                    <div class="box-body">

                        <!-- Branch -->
                        <div class="form-group">

                            <label class="col-sm-2 control-label">
                                Branch <span>*</span>
                            </label>

                            <div class="col-sm-4">

                                <select class="form-control" name="id_cabang">

                                    <option value="">-- Select Branch --</option>

                                    <?php foreach($cabang_list as $cabang): ?>

                                    <option 
                                        value="<?php echo $cabang['id']; ?>"
                                        <?php echo ($data['id_cabang'] == $cabang['id']) ? 'selected' : ''; ?>
                                    >
                                        <?php echo htmlspecialchars($cabang['nama_cabang']); ?>
                                    </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                        </div>


                        <!-- Photo -->
                        <div class="form-group">

                            <label class="col-sm-2 control-label">
                                Photo
                            </label>

                            <div class="col-sm-6" style="padding-top:5px">

                                <input type="file" name="photo">

                                (Only JPG or PNG, max 3 MB)

                                <?php if(!empty($data['photo'])): ?>

                                <div style="margin-top:8px;">

                                    <img 
                                        src="../assets/uploads/<?php echo htmlspecialchars($data['photo']); ?>" 
                                        alt="Current Photo" 
                                        style="width:180px; height:220px; object-fit:contain; display:block; margin-bottom:6px;" 
                                    />

                                    <p style="margin:0;">
                                        Current file: <?php echo htmlspecialchars($data['photo']); ?>
                                    </p>

                                </div>

                                <?php endif; ?>

                            </div>

                        </div>


                        <!-- Start Date -->
                        <div class="form-group">

                            <label class="col-sm-2 control-label">
                                Start Date <span>*</span>
                            </label>

                            <div class="col-sm-4">

                                <input 
                                    type="date" 
                                    name="start_date" 
                                    class="form-control"
                                    value="<?php echo !empty($data['start_date']) ? htmlspecialchars($data['start_date']) : ''; ?>"
                                >

                            </div>

                        </div>


                        <!-- End Date -->
                        <div class="form-group">

                            <label class="col-sm-2 control-label">
                                End Date <span>*</span>
                            </label>

                            <div class="col-sm-4">

                                <input 
                                    type="date" 
                                    name="end_date" 
                                    class="form-control"
                                    value="<?php echo !empty($data['end_date']) ? htmlspecialchars($data['end_date']) : ''; ?>"
                                >

                            </div>

                        </div>


                        <!-- Update -->
                        <div class="form-group">

                            <label class="col-sm-2 control-label"></label>

                            <div class="col-sm-6">

                                <button 
                                    type="submit" 
                                    class="btn btn-success pull-left" 
                                    name="form1"
                                >
                                    Update
                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</section>

<?php require_once('footer.php'); ?>