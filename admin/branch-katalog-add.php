<?php require_once('header.php'); ?>
<?php require_once('image-upload-utils.php'); ?>

<?php
if(isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if(empty($_POST['id_cabang'])) {
        $valid = 0;
        $error_message .= "Branch can not be empty<br>";
    }

    $image_valid = isset($_FILES['photo']) ? image_upload_validate($_FILES['photo']) : false;
    if($image_valid === false) {
        $valid = 0;
        $error_message .= 'Unggah gambar JPG atau PNG yang valid dengan ukuran maksimal 3 MB.<br>';
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

    if($valid == 1) {

        $statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_flyer'");
        $statement->execute();
        $result = $statement->fetchAll();

        foreach($result as $row) {
            $ai_id = $row[10];
        }

        $final_name = image_upload_save_as_webp(
            $_FILES['photo'],
            'branch-katalog-'.$ai_id,
            __DIR__.'/../assets/uploads/'
        );

        if($final_name === false) {
            $error_message .= 'Gambar tidak dapat diunggah.<br>';
        } else {
            $statement = $pdo->prepare("
                INSERT INTO tbl_flyer 
                (id_cabang, photo, start_date, end_date) 
                VALUES (?,?,?,?)
            ");

            $statement->execute(array(
                $_POST['id_cabang'],
                $final_name,
                $_POST['start_date'],
                $_POST['end_date']
            ));

            $_SESSION['success_message'] = 'Branch katalog is added successfully.';

            header('Location: branch-katalog.php');
            exit;
        }
    }
}

$statement = $pdo->prepare("SELECT id, nama_cabang FROM tbl_cabang ORDER BY nama_cabang ASC");
$statement->execute();
$cabang_list = $statement->fetchAll();
?>

<section class="content-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">
    <div class="content-header-left">
        <h1 style="margin:0;">Add Branch Katalog</h1>
    </div>

    <div class="content-header-right">
        <a href="branch-katalog.php" class="btn btn-primary btn-sm">View All</a>
    </div>
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
                                        <?php echo (isset($_POST['id_cabang']) && $_POST['id_cabang'] == $cabang['id']) ? 'selected' : ''; ?>
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
                                Photo <span>*</span>
                            </label>

                            <div class="col-sm-6" style="padding-top:5px">

                                <input type="file" name="photo">

                                (Only JPG or PNG, max 3 MB)

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
                                    value="<?php echo isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : ''; ?>"
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
                                    value="<?php echo isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : ''; ?>"
                                >

                            </div>
                        </div>


                        <!-- Submit -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>

                            <div class="col-sm-6">

                                <button 
                                    type="submit" 
                                    class="btn btn-success pull-left" 
                                    name="form1"
                                >
                                    Submit
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