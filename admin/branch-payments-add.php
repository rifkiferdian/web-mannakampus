<?php require_once('header.php'); ?>
<?php
$upload_dir = '../assets/uploads/';
$allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
$max_size = 2 * 1024 * 1024;

if(isset($_POST['form1'])) {
    $valid = 1;

    if(empty($_POST['id_cabang'])) {
        $valid = 0;
        $error_message .= "Branch can not be empty<br>";
    }

    if(empty($_POST['nama_pembayaran'])) {
        $valid = 0;
        $error_message .= "Payment name can not be empty<br>";
    }

    $logo_filename = null;
    if (!empty($_FILES['logo']['name'])) {
        $filename = $_FILES['logo']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if ($_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
            $valid = 0;
            $error_message .= "Gagal upload logo.<br>";
        } elseif (!in_array($ext, $allowed_ext)) {
            $valid = 0;
            $error_message .= "Format logo tidak didukung (hanya jpg, jpeg, png, webp)<br>";
        } elseif ($_FILES['logo']['size'] > $max_size) {
            $valid = 0;
            $error_message .= "Ukuran logo terlalu besar (maks 2MB)<br>";
        } else {
            $logo_filename = 'payment-' . time() . '-' . uniqid() . '.' . $ext;
        }
    }

    if($valid == 1) {
        if ($logo_filename && !empty($_FILES['logo']['tmp_name'])) {
            move_uploaded_file($_FILES['logo']['tmp_name'], $upload_dir . $logo_filename);
        }

        $statement = $pdo->prepare("INSERT INTO tbl_cabang_pembayaran (id_cabang, nama_pembayaran, keterangan, logo) VALUES (?,?,?,?)");
        $statement->execute(array(
            $_POST['id_cabang'],
            $_POST['nama_pembayaran'],
            $_POST['keterangan'],
            $logo_filename
        ));

        $_SESSION['success_message'] = 'Payment method is added successfully.';
        header('Location: branch-payments.php');
        exit;
    }
}

$statement = $pdo->prepare("SELECT id, nama_cabang FROM tbl_cabang ORDER BY nama_cabang ASC");
$statement->execute();
$cabang_list = $statement->fetchAll();
?>

<section class="content-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">
    <div class="content-header-left">
        <h1 style="margin:0;">Add Branch Payment Method</h1>
    </div>
    <div class="content-header-right">
        <a href="branch-payments.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if($error_message): ?>
            <div class="callout callout-danger">
            <p><?php echo $error_message; ?></p>
            </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Branch <span>*</span></label>
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
                            <label class="col-sm-2 control-label">Payment Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="nama_pembayaran" value="<?php echo htmlspecialchars($_POST['nama_pembayaran'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: BCA, GoPay, QRIS">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Keterangan</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="keterangan" value="<?php echo htmlspecialchars($_POST['keterangan'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Optional, contoh: Transfer Bank">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Logo</label>
                            <div class="col-sm-4">
                                <input type="file" name="logo" accept=".jpg,.jpeg,.png,.webp">
                                <p class="help-block">Format: jpg, jpeg, png, webp. Maks 2MB.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
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