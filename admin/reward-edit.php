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

$statement = $pdo->prepare("SELECT * FROM tbl_reward WHERE id = ?");
$statement->execute(array($id));
$data = $statement->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    header('Location: reward.php');
    exit;
}

$error_message = '';
$success_message = '';

if(isset($_POST['form1'])) {
    $valid = 1;

    if(empty($_POST['id_periode'])) {
        $valid = 0;
        $error_message .= "Periode can not be empty<br>";
    }

    if(empty($_POST['prize_name'])) {
        $valid = 0;
        $error_message .= "Prize name can not be empty<br>";
    }

    // ══ Cek apakah user upload file baru ══
    $has_new_image = isset($_FILES['img']) && $_FILES['img']['error'] !== UPLOAD_ERR_NO_FILE;

    // ══ Validasi HANYA kalau ada file baru ══
    if($has_new_image) {
        $image_valid = image_upload_validate($_FILES['img']);
        if($image_valid === false) {
            $valid = 0;
            $error_message .= "Unggah gambar JPG atau PNG yang valid dengan ukuran maksimal 3 MB.<br>";
        }
    }

    if($valid == 1) {
        $final_name = $data['img']; // default: tetap pakai yang lama

        if($has_new_image) {
            $final_name = image_upload_save_as_webp(
                $_FILES['img'],
                'reward-'.$_POST['id_periode'].'-'.time(),
                __DIR__.'/../assets/uploads/'
            );
            if($final_name === false) {
                $valid = 0;
                $error_message .= 'Gambar tidak dapat diunggah.<br>';
            }
        }

        if($valid == 1) {
            $grand_prize = isset($_POST['grand_prize']) ? (int)$_POST['grand_prize'] : 0;

            $statement = $pdo->prepare("UPDATE tbl_reward SET id_periode=?, prize_name=?, grand_prize=?, img=?, qty=?, description=? WHERE id=?");
            $statement->execute(array(
                $_POST['id_periode'],
                $_POST['prize_name'],
                $grand_prize,
                $final_name,
                $_POST['qty'],
                $_POST['description'],
                $id
            ));

            // ══ Hapus file lama SETELAH update berhasil & namanya beda ══
            if($has_new_image && $data['img'] !== $final_name) {
                $old_path = __DIR__.'/../assets/uploads/'.basename($data['img']);
                if(!empty($data['img']) && is_file($old_path)) {
                    unlink($old_path);
                }
            }

            $_SESSION['success_message'] = 'Reward updated successfully.';
            header('Location: reward.php');
            exit;
        }
    }

    $data['id_periode']  = $_POST['id_periode'];
    $data['prize_name']  = $_POST['prize_name'];
    $data['grand_prize'] = $_POST['grand_prize'];
    $data['qty']         = $_POST['qty'];
    $data['description'] = $_POST['description'];
}

// Option list periode beserta nama program terkait (Urutan ASC)
$statement = $pdo->prepare("SELECT p.id, p.periode_name, pr.program_name, pr.year 
                            FROM tbl_periode p 
                            LEFT JOIN tbl_program pr ON p.id_program = pr.id 
                            ORDER BY p.id ASC");
$statement->execute();
$periode_list = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Reward</h1>
    </div>
        <a href="reward.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left"></i> View All</a>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">

            <?php if(!empty($error_message)): ?>
            <div class="callout callout-danger">
                <p><?php echo $error_message; ?></p>
            </div>
            <?php endif; ?>

            <?php if(!empty($success_message)): ?>
            <div class="callout callout-success">
                <p><?php echo $success_message; ?></p>
            </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                <div class="box box-info">
                    <div class="box-body">

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Periode & Program <span>*</span></label>
                            <div class="col-sm-5">
                                <select class="form-control" name="id_periode">
                                    <option value="">-- Select Periode --</option>
                                    <?php foreach($periode_list as $periode): ?>
                                    <option value="<?php echo $periode['id']; ?>" <?php echo ($data['id_periode'] == $periode['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars(($periode['program_name'] ?? 'No Program') . ' (' . ($periode['year'] ?? '-') . ') - ' . $periode['periode_name']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Prize Name <span>*</span></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="prize_name" value="<?php echo htmlspecialchars($data['prize_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: Sepeda Motor Scoopy">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Grand Prize?</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="grand_prize">
                                    <option value="0" <?php echo ($data['grand_prize'] == 0) ? 'selected' : ''; ?>>No</option>
                                    <option value="1" <?php echo ($data['grand_prize'] == 1) ? 'selected' : ''; ?>>Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Quantity</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" name="qty" value="<?php echo htmlspecialchars($data['qty'] ?? '1', ENT_QUOTES, 'UTF-8'); ?>" min="1">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Existing Image</label>
                            <div class="col-sm-4">
                                <?php if(!empty($data['img']) && file_exists('../assets/uploads/'.$data['img'])): ?>
                                    <img src="../assets/uploads/<?php echo htmlspecialchars($data['img']); ?>" alt="" style="width:120px;">
                                <?php else: ?>
                                    <p class="help-block">No image uploaded.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Change Image</label>
                            <div class="col-sm-4">
                                <input type="file" name="img">(Only jpg and png are allowed, max 3 MB)
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="description" rows="3" placeholder="Optional description"><?php echo htmlspecialchars($data['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
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