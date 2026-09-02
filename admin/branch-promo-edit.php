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
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$statement = $pdo->prepare("SELECT * FROM tbl_cabang_promo WHERE id = ?");
$statement->execute(array($id));
$data = $statement->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    header('Location: branch-promo.php');
    exit;
}

if(isset($_POST['form1'])) {
    $valid = 1;

    if(empty($_POST['id_cabang'])) {
        $valid = 0;
        $error_message .= "Branch can not be empty<br>";
    }

    if(empty($_POST['nama_produk'])) {
        $valid = 0;
        $error_message .= "Product Name can not be empty<br>";
    }

    if(empty($_POST['harga_promo'])) {
        $valid = 0;
        $error_message .= "Promo Price can not be empty<br>";
    }

    // Cek apakah user mengunggah file foto baru
    $has_new_image = isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE;
    $original_image = $data['foto'];
    $final_name = $original_image;

    if($has_new_image) {
        $image_valid = image_upload_validate($_FILES['foto']);
        if($image_valid === false) {
            $valid = 0;
            $error_message .= 'Unggah gambar JPG atau PNG yang valid dengan ukuran maksimal 3 MB.<br>';
        }
    }

    if($valid == 1) {
        if($has_new_image) {
            $final_name = image_upload_save_as_webp(
                $_FILES['foto'],
                'branch-promo-'.$id,
                __DIR__.'/../assets/uploads/'
            );

            if($final_name === false) {
                $valid = 0;
                $error_message .= 'Gambar tidak dapat diunggah.<br>';
            }
        }

        if($valid == 1) {
            $statement = $pdo->prepare("UPDATE tbl_cabang_promo SET id_cabang=?, badge=?, kategori=?, nama_produk=?, harga_coret=?, harga_promo=?, foto=? WHERE id=?");
            $statement->execute(array(
                $_POST['id_cabang'],
                $_POST['badge'],
                $_POST['kategori'],
                $_POST['nama_produk'],
                $_POST['harga_coret'] != '' ? $_POST['harga_coret'] : null,
                $_POST['harga_promo'],
                $final_name,
                $id
            ));

            // Hapus file lama SETELAH update berhasil, kalau bukan gambar default & namanya beda
            if($has_new_image && $original_image !== 'default-product.jpg' && $original_image !== $final_name) {
                $old_path = __DIR__.'/../assets/uploads/'.basename($original_image);
                if(is_file($old_path)) {
                    unlink($old_path);
                }
            }

            $_SESSION['success_message'] = 'Branch promo is updated successfully.';
            header('Location: branch-promo.php');
            exit;
        }
    }

    $data['id_cabang'] = $_POST['id_cabang'];
    $data['badge'] = $_POST['badge'];
    $data['kategori'] = $_POST['kategori'];
    $data['nama_produk'] = $_POST['nama_produk'];
    $data['harga_coret'] = $_POST['harga_coret'];
    $data['harga_promo'] = $_POST['harga_promo'];
}

$statement = $pdo->prepare("SELECT id, nama_cabang FROM tbl_cabang ORDER BY nama_cabang ASC");
$statement->execute();
$cabang_list = $statement->fetchAll();
?>

<section class="content-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">
    <div class="content-header-left">
        <h1 style="margin:0;">Edit Branch Promo</h1>
    </div>
        <a href="branch-promo.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left" style="text-align: center;"></i> View All</a>
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
                            <label for="" class="col-sm-2 control-label">Badge</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="badge" value="<?php echo htmlspecialchars($data['badge'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: Hemat 15%">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="kategori" value="<?php echo htmlspecialchars($data['kategori'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: Minyak Goreng Sawit">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Product Name <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="nama_produk" value="<?php echo htmlspecialchars($data['nama_produk'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: Minyak Sunco 2 Liter">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Regular Price</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="harga_coret" value="<?php echo htmlspecialchars($data['harga_coret'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: 38500">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Promo Price <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="harga_promo" value="<?php echo htmlspecialchars($data['harga_promo'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: 32900">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Existing Photo</label>
                            <div class="col-sm-9">
                                <?php if(!empty($data['foto'])): ?>
                                    <img src="../assets/uploads/<?php echo htmlspecialchars($data['foto']); ?>" alt="Existing Photo" style="max-width:150px; display:block; margin-bottom:8px;">
                                <?php else: ?>
                                    <p class="text-muted">No photo uploaded</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Photo</label>
                            <div class="col-sm-9" style="padding-top:5px">
                                <input type="file" name="foto"> (Only JPG or PNG, max 3 MB)
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