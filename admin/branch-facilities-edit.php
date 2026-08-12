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
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$statement = $pdo->prepare("SELECT * FROM tbl_cabang_fasilitas WHERE id = ?");
$statement->execute(array($id));
$data = $statement->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    header('Location: branch-facilities.php');
    exit;
}

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

    if($valid == 1) {
        $statement = $pdo->prepare("UPDATE tbl_cabang_fasilitas SET id_cabang=?, nama_fasilitas=?, deskripsi=?, icon=? WHERE id=?");
        $statement->execute(array(
            $_POST['id_cabang'],
            $_POST['nama_fasilitas'],
            $_POST['deskripsi'],
            $_POST['icon'],
            $id
        ));

        $_SESSION['success_message'] = 'Branch facility is updated successfully.';
        header('Location: branch-facilities.php');
        exit;
    }

    $data['id_cabang'] = $_POST['id_cabang'];
    $data['nama_fasilitas'] = $_POST['nama_fasilitas'];
    $data['deskripsi'] = $_POST['deskripsi'];
    $data['icon'] = $_POST['icon'];
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
];
?>

<section class="content-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">
    <div class="content-header-left">
        <h1 style="margin:0;">Edit Branch Facility</h1>
    </div>
        <a href="branch-facilities.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left" style="text-align: center;"></i> View All</a>
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

            <form class="form-horizontal" action="" method="post">

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
                            <label for="" class="col-sm-2 control-label">Facility <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="nama_fasilitas" value="<?php echo htmlspecialchars($data['nama_fasilitas'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: Parking Lot">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="deskripsi" rows="3" placeholder="Optional description"><?php echo htmlspecialchars($data['deskripsi'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Icon</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="icon" id="branch-facility-icon-select">
                                    <option value="">-- Select Icon --</option>
                                    <?php foreach($icon_options as $icon_class => $icon_label): ?>
                                    <option value="<?php echo $icon_class; ?>" <?php echo (isset($data['icon']) && $data['icon'] == $icon_class) ? 'selected' : ''; ?>><?php echo htmlspecialchars($icon_label); ?> (<?php echo htmlspecialchars($icon_class); ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="help-block">Pilih icon untuk facility dari opsi.</p>
                                <div id="branch-facility-icon-preview" style="margin-top:8px;">
                                    <strong style="font-size:13px; font-weight:600; display:block; margin-bottom:4px;">Preview:</strong>
                                    <div style="display:flex; flex-wrap:wrap; align-items:center; gap:10px;">
                                        <span class="icon-preview-box" style="display:inline-flex; align-items:center; justify-content:center; width:24px; height:24px; border:1px solid #ddd; border-radius:4px; background:#fff;"></span>
                                        <span class="icon-preview-text" style="color:#777; font-size:12px;"><?php echo !empty($data['icon']) ? '<i class="'.htmlspecialchars($data['icon'], ENT_QUOTES, 'UTF-8').'" style="font-size:16px;"></i>' : 'No icon selected'; ?></span>
                                    </div>
                                </div>
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