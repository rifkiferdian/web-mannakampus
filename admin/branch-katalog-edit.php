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

    $path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];
    $final_name = $data['photo'];

    if($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png' && $ext != 'gif') {
            $valid = 0;
            $error_message .= 'You must upload jpg, jpeg, gif or png file for photo<br>';
        }
    }

    if($valid == 1) {
        if($path != '') {
            $final_name = 'branch-katalog-' . $id . '.' . $ext;
            move_uploaded_file($path_tmp, '../assets/uploads/' . $final_name);
        }

        $statement = $pdo->prepare("UPDATE tbl_flyer SET id_cabang=?, photo=? WHERE id=?");
        $statement->execute(array(
            $_POST['id_cabang'],
            $final_name,
            $id
        ));

        $_SESSION['success_message'] = 'Branch katalog is updated successfully.';
        header('Location: branch-katalog.php');
        exit;
    }

    $data['cabang_id'] = $_POST['id_cabang'];
}

$statement = $pdo->prepare("SELECT id, nama_cabang FROM tbl_cabang ORDER BY nama_cabang ASC");
$statement->execute();
$cabang_list = $statement->fetchAll();
?>

<section class="content-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">
    <div class="content-header-left">
        <h1 style="margin:0;">Edit Branch Katalog</h1>
    </div>
        <a href="branch-katalog.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left" style="text-align: center;"></i> View All</a>
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
                                    <option value="<?php echo $cabang['id']; ?>" <?php echo ($data['cabang_id'] == $cabang['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cabang['nama_cabang']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Photo</label>
                            <div class="col-sm-6" style="padding-top:5px">
                                <input type="file" name="photo"> (Only jpg, jpeg, gif and png are allowed)
                                <?php if(!empty($data['photo'])): ?>
                                <div style="margin-top:8px;">
                                    <img src="../assets/uploads/<?php echo htmlspecialchars($data['photo']); ?>" alt="Current Photo" style="max-width:150px; max-height:100px; display:block; margin-bottom:6px;" />
                                    <p style="margin:0;">Current file: <?php echo htmlspecialchars($data['photo']); ?></p>
                                </div>
                                <?php endif; ?>
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