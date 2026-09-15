<?php require_once('header.php'); ?>
<style>
.current-logo-box { display:inline-flex; align-items:center; justify-content:center; width:80px; height:80px; border:1px solid #ddd; border-radius:6px; background:#fff; padding:6px; margin-bottom:10px; }
.current-logo-box img { max-width:100%; max-height:100%; object-fit:contain; }
</style>
<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$statement = $pdo->prepare("SELECT * FROM tbl_cabang_pembayaran WHERE id = ?");
$statement->execute(array($id));
$data = $statement->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    header('Location: branch-payments.php');
    exit;
}

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

    $new_logo_filename = null;
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
            $new_logo_filename = 'payment-' . $id . '-' . time() . '-' . uniqid() . '.' . $ext;
        }
    }

    if($valid == 1) {
        $logo_to_save = $data['logo']; // default: pakai logo lama

        if ($new_logo_filename && !empty($_FILES['logo']['tmp_name'])) {
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $upload_dir . $new_logo_filename)) {
                // Hapus logo lama kalau ada, supaya tidak menumpuk file tak terpakai
                if (!empty($data['logo']) && file_exists($upload_dir . $data['logo'])) {
                    unlink($upload_dir . $data['logo']);
                }
                $logo_to_save = $new_logo_filename;
            }
        }

        $statement = $pdo->prepare("UPDATE tbl_cabang_pembayaran SET id_cabang=?, nama_pembayaran=?, keterangan=?, logo=? WHERE id=?");
        $statement->execute(array(
            $_POST['id_cabang'],
            $_POST['nama_pembayaran'],
            $_POST['keterangan'],
            $logo_to_save,
            $id
        ));

        $_SESSION['success_message'] = 'Payment method is updated successfully.';
        header('Location: branch-payments.php');
        exit;
    }

    $data['id_cabang'] = $_POST['id_cabang'];
    $data['nama_pembayaran'] = $_POST['nama_pembayaran'];
    $data['keterangan'] = $_POST['keterangan'];
}

$statement = $pdo->prepare("SELECT id, nama_cabang FROM tbl_cabang ORDER BY nama_cabang ASC");
$statement->execute();
$cabang_list = $statement->fetchAll();
?>

<section class="content-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">
    <div class="content-header-left">
        <h1 style="margin:0;">Edit Branch Payment Method</h1>
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
                                    <option value="<?php echo $cabang['id']; ?>" <?php echo ($data['id_cabang'] == $cabang['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cabang['nama_cabang']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Payment Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="nama_pembayaran" value="<?php echo htmlspecialchars($data['nama_pembayaran'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Keterangan</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="keterangan" value="<?php echo htmlspecialchars($data['keterangan'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Logo</label>
                            <div class="col-sm-4">
                                <?php if (!empty($data['logo'])): ?>
                                <div class="current-logo-box">
                                    <img src="../assets/uploads/<?php echo htmlspecialchars($data['logo']); ?>" alt="">
                                </div>
                                <p class="help-block">Logo saat ini. Upload file baru untuk mengganti.</p>
                                <?php endif; ?>
                                <input type="file" name="logo" accept=".jpg,.jpeg,.png,.webp">
                                <p class="help-block">Format: jpg, jpeg, png, webp. Maks 2MB.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
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