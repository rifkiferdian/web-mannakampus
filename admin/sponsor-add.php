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
$error_message = '';
$success_message = '';

if(isset($_POST['form1'])) {
    $valid = 1;

    if(empty($_POST['id_program'])) {
        $valid = 0;
        $error_message .= "Program can not be empty<br>";
    }

    if(empty($_POST['sponsor_name'])) {
        $valid = 0;
        $error_message .= "Sponsor name can not be empty<br>";
    }

    // ══ Logo/gambar wajib diisi ══
    $has_image = isset($_FILES['img']) && $_FILES['img']['error'] !== UPLOAD_ERR_NO_FILE;

    if($has_image) {
        $image_valid = image_upload_validate($_FILES['img']);
        if($image_valid === false) {
            $valid = 0;
            $error_message .= "Unggah gambar JPG atau PNG yang valid dengan ukuran maksimal 3 MB.<br>";
        }
    } else {
        $valid = 0;
        $error_message .= "Sponsor logo/image can not be empty<br>";
    }

    if($valid == 1) {
        $final_name = image_upload_save_as_webp(
            $_FILES['img'],
            'sponsor-'.$_POST['id_program'].'-'.time(),
            __DIR__.'/../assets/uploads/'
        );
        if($final_name === false) {
            $valid = 0;
            $error_message .= 'Gambar tidak dapat diunggah.<br>';
        }

        if($valid == 1) {
            $statement = $pdo->prepare("INSERT INTO tbl_sponsor (id_program, sponsor_name, img) VALUES (?,?,?)");
            $statement->execute(array(
                $_POST['id_program'],
                $_POST['sponsor_name'],
                $final_name
            ));

            $_SESSION['success_message'] = 'Sponsor is added successfully.';
            header('Location: sponsor.php');
            exit;
        }
    }
}

// Option list Program (Urutan ASC)
$statement = $pdo->prepare("SELECT id, program_name, year FROM tbl_program ORDER BY id ASC");
$statement->execute();
$program_list = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Sponsor</h1>
    </div>
    <div class="content-header-right">
        <a href="sponsor.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left"></i> View All</a>
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

            <?php if(!empty($success_message)): ?>
            <div class="callout callout-success">
                <p><?php echo $success_message; ?></p>
            </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                <div class="box box-info">
                    <div class="box-body">

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Program <span>*</span></label>
                            <div class="col-sm-5">
                                <select class="form-control" name="id_program">
                                    <option value="">-- Select Program --</option>
                                    <?php foreach($program_list as $program): ?>
                                    <option value="<?php echo $program['id']; ?>" <?php echo (isset($_POST['id_program']) && $_POST['id_program'] == $program['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($program['program_name'] . ' (' . $program['year'] . ')'); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Sponsor Name <span>*</span></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="sponsor_name" value="<?php echo htmlspecialchars($_POST['sponsor_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: Bank BRI">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Logo / Image <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="file" name="img">(Only jpg and png are allowed, max 3 MB)
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

<?php require_once('footer.php'); ?>