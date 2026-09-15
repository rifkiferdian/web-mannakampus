<?php require_once('header.php'); ?>
<style>
.gallery-item { position: relative; display: inline-block; margin: 6px; border: 1px solid #ddd; border-radius: 4px; padding: 4px; background: #fff; }
.gallery-item img { width: 100px; height: 100px; object-fit: cover; display: block; }
</style>
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

    if(empty($_POST['nama_fasilitas'])) {
        $valid = 0;
        $error_message .= "Facility name can not be empty<br>";
    }

    $uploaded_files = [];
    if (!empty($_FILES['gambar']['name'][0])) {
        foreach ($_FILES['gambar']['name'] as $key => $filename) {
            if ($_FILES['gambar']['error'][$key] === UPLOAD_ERR_NO_FILE) {
                continue;
            }
            if ($_FILES['gambar']['error'][$key] !== UPLOAD_ERR_OK) {
                $valid = 0;
                $error_message .= "Gagal upload file: " . htmlspecialchars($filename) . "<br>";
                continue;
            }

            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed_ext)) {
                $valid = 0;
                $error_message .= "Format file tidak didukung: " . htmlspecialchars($filename) . " (hanya jpg, jpeg, png, webp)<br>";
                continue;
            }

            if ($_FILES['gambar']['size'][$key] > $max_size) {
                $valid = 0;
                $error_message .= "Ukuran file terlalu besar: " . htmlspecialchars($filename) . " (maks 2MB)<br>";
                continue;
            }

            $uploaded_files[] = [
                'tmp_name' => $_FILES['gambar']['tmp_name'][$key],
                'ext' => $ext,
            ];
        }
    }

    if($valid == 1) {
        $statement = $pdo->prepare("INSERT INTO tbl_cabang_fasilitas (id_cabang, nama_fasilitas, deskripsi, icon) VALUES (?,?,?,?)");
        $statement->execute(array(
            $_POST['id_cabang'],
            $_POST['nama_fasilitas'],
            $_POST['deskripsi'],
            $_POST['icon']
        ));

        $new_id = $pdo->lastInsertId();

        if (!empty($uploaded_files)) {
            $insert_gambar = $pdo->prepare("INSERT INTO tbl_cabang_fasilitas_gambar (id_fasilitas, gambar) VALUES (?, ?)");

            foreach ($uploaded_files as $file) {
                $new_filename = 'fasilitas-' . $new_id . '-' . time() . '-' . uniqid() . '.' . $file['ext'];
                $destination = $upload_dir . $new_filename;

                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $insert_gambar->execute(array($new_id, $new_filename));
                }
            }
        }

        $_SESSION['success_message'] ='Branch facility is added successfully.';
        header('Location: branch-facilities.php');
        exit;
    }
}

$statement = $pdo->prepare("SELECT id, nama_cabang FROM tbl_cabang ORDER BY nama_cabang ASC");
$statement->execute();
$cabang_list = $statement->fetchAll();

$icon_options = [
    'fa-solid fa-store' => 'Store / Retail',
    'fa-solid fa-shopping-bag' => 'Shopping / Retail',
    'fa-solid fa-coffee' => 'Coffee / Cafe',
    'fa-solid fa-mug-hot' => 'Beverage / Cafe',
    'fa-solid fa-utensils' => 'Food / Restaurant',
    'fa-solid fa-tshirt' => 'Fashion / Clothing',
    'fa-solid fa-shirt' => 'Apparel / Fashion',
    'fa-solid fa-laptop' => 'Electronics / IT',
    'fa-solid fa-mobile-screen-button' => 'Mobile / Service',
    'fa-solid fa-heart' => 'Health / Beauty',
    'fa-solid fa-spa' => 'Wellness / Beauty',
    'fa-solid fa-graduation-cap' => 'Education',
    'fa-solid fa-bolt' => 'Service / Utility',
    'fa-solid fa-wrench' => 'Repair / Workshop',
    'fa-solid fa-book' => 'Books / Stationery',
    'fa-solid fa-box-open' => 'Retail / Package',
    'fa-solid fa-medkit' => 'Medical / Pharmacy',
    'fa-solid fa-credit-card' => 'Bank / Finance',
    'fa-solid fa-building-o' => 'Office / Corporate',
    'fa-solid fa-restroom' => 'Restroom / Facility',
    'fa-solid fa-parking' => 'Parking / Facility',
    'fa-solid fa-cutlery' => 'Dining / Restaurant',
    'fa-solid fa-mosque' => 'Mushola / Ibadah',
];
?>

<section class="content-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">
    <div class="content-header-left">
        <h1 style="margin:0;">Add Branch Facility</h1>
    </div>
    <div class="content-header-right">
        <a href="branch-facilities.php" class="btn btn-primary btn-sm">View All</a>
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
                            <label for="" class="col-sm-2 control-label">Facility <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="nama_fasilitas" value="<?php echo htmlspecialchars($_POST['nama_fasilitas'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: Parking Lot">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="deskripsi" rows="3" placeholder="Optional description"><?php echo htmlspecialchars($_POST['deskripsi'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Icon</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="icon" id="branch-facility-icon-select">
                                    <option value="">-- Select Icon --</option>
                                    <?php foreach($icon_options as $icon_class => $icon_label): ?>
                                    <option value="<?php echo $icon_class; ?>" <?php echo (isset($_POST['icon']) && $_POST['icon'] == $icon_class) ? 'selected' : ''; ?>><?php echo htmlspecialchars($icon_label); ?> (<?php echo htmlspecialchars($icon_class); ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="help-block">Pilih icon untuk facility. Jika ingin mengganti, pilih salah satu opsi yang tersedia.</p>
                                <div id="branch-facility-icon-preview" style="margin-top:8px;">
                                    <strong style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Preview:</strong>
                                    <div style="display:flex; flex-wrap:wrap; align-items:center; gap:10px;">
                                        <span class="icon-preview-box" style="display:inline-flex; align-items:center; justify-content:center; width:24px; height:24px; border:1px solid #ddd; border-radius:4px; background:#fff;"></span>
                                        <span class="icon-preview-text" style="color:#777; font-size:12px;"><?php echo !empty($_POST['icon']) ? '<i class="'.htmlspecialchars($_POST['icon'], ENT_QUOTES, 'UTF-8').'" style="font-size:16px;"></i>' : 'No icon selected'; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Gambar / Logo</label>
                            <div class="col-sm-6">
                                <input type="file" name="gambar[]" multiple accept=".jpg,.jpeg,.png,.webp">
                                <p class="help-block">Bisa pilih lebih dari satu file sekaligus. Format: jpg, jpeg, png, webp. Maks 2MB per file.</p>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    var iconSelect = document.getElementById('branch-facility-icon-select');
    var previewBox = document.querySelector('#branch-facility-icon-preview .icon-preview-box');
    var previewText = document.querySelector('#branch-facility-icon-preview .icon-preview-text');
    if (!iconSelect || !previewBox || !previewText) return;

    function updatePreview() {
        var iconClass = iconSelect.value;
        if (!previewBox || !previewText) return;

        if (iconClass) {
            previewBox.innerHTML = '<i class="' + iconClass + '" style="font-size:16px;"></i>';
            previewText.textContent = iconClass.replace('fa-solid ', '');
        } else {
            previewBox.innerHTML = '';
            previewText.textContent = 'No icon selected';
        }
    }

    iconSelect.addEventListener('change', updatePreview);
    updatePreview();
});
</script>

<?php require_once('footer.php'); ?>