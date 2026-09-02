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

    if(empty($_POST['id_periode'])) {
        $valid = 0;
        $error_message .= "Periode can not be empty<br>";
    }

    if(empty($_POST['id_reward'])) {
        $valid = 0;
        $error_message .= "Reward can not be empty<br>";
    }

    if(empty($_POST['winners_name'])) {
        $valid = 0;
        $error_message .= "Winner name can not be empty<br>";
    }

    // ══ Cek apakah ada file foto (opsional) ══
    $has_photo = isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE;

    if($has_photo) {
        $photo_valid = image_upload_validate($_FILES['photo']);
        if($photo_valid === false) {
            $valid = 0;
            $error_message .= "Unggah gambar JPG atau PNG yang valid dengan ukuran maksimal 3 MB.<br>";
        }
    }

    if($valid == 1) {
        $final_name = '';

        // ══ Simpan foto sebagai WebP (kalau ada) ══
        if($has_photo) {
            $final_name = image_upload_save_as_webp(
                $_FILES['photo'],
                'winner-'.$_POST['id_periode'].'-'.time(),
                __DIR__.'/../assets/uploads/'
            );
            if($final_name === false) {
                $valid = 0;
                $error_message .= 'Gambar tidak dapat diunggah.<br>';
            }
        }

        if($valid == 1) {
            $statement = $pdo->prepare("INSERT INTO tbl_winners (id_periode, id_reward, winners_name, photo, address, member_number, testimonial, description) VALUES (?,?,?,?,?,?,?,?)");
            $statement->execute(array(
                $_POST['id_periode'],
                $_POST['id_reward'],
                $_POST['winners_name'],
                $final_name,
                $_POST['address'],
                $_POST['member_number'],
                $_POST['testimonial'],
                $_POST['description']
            ));

            $_SESSION['success_message'] = 'Winner is added successfully.';
            header('Location: winners.php');
            exit;
        }
    }
}

// Option list Periode & Program (Urutan ASC)
$statement = $pdo->prepare("SELECT p.id, p.periode_name, pr.program_name, pr.year 
                            FROM tbl_periode p 
                            LEFT JOIN tbl_program pr ON p.id_program = pr.id 
                            ORDER BY p.id ASC");
$statement->execute();
$periode_list = $statement->fetchAll(PDO::FETCH_ASSOC);

// Option list Reward (Urutan ASC)
$statement = $pdo->prepare("SELECT id, prize_name FROM tbl_reward ORDER BY id ASC");
$statement->execute();
$reward_list = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Winner</h1>
    </div>
    <div class="content-header-right">
        <a href="winners.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left"></i> View All</a>
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
                            <label for="" class="col-sm-2 control-label">Periode & Program <span>*</span></label>
                            <div class="col-sm-5">
                                <select class="form-control" name="id_periode">
                                    <option value="">-- Select Periode --</option>
                                    <?php foreach($periode_list as $periode): ?>
                                    <option value="<?php echo $periode['id']; ?>" <?php echo (isset($_POST['id_periode']) && $_POST['id_periode'] == $periode['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars(($periode['program_name'] ?? 'No Program') . ' (' . ($periode['year'] ?? '-') . ') - ' . $periode['periode_name']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Reward <span>*</span></label>
                            <div class="col-sm-5">
                                <select class="form-control" name="id_reward">
                                    <option value="">-- Select Reward --</option>
                                    <?php foreach($reward_list as $reward): ?>
                                    <option value="<?php echo $reward['id']; ?>" <?php echo (isset($_POST['id_reward']) && $_POST['id_reward'] == $reward['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($reward['prize_name']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Winner Name <span>*</span></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="winners_name" value="<?php echo htmlspecialchars($_POST['winners_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: Budi Santoso">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Member Number</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="member_number" value="<?php echo htmlspecialchars($_POST['member_number'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: 001707931669">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Photo</label>
                            <div class="col-sm-4">
                                <input type="file" name="photo">(Only jpg and png are allowed, max 3 MB)
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($_POST['address'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: Sleman, DI Yogyakarta">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Testimonial</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="testimonial" rows="3" placeholder="Optional testimonial"><?php echo htmlspecialchars($_POST['testimonial'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="description" rows="3" placeholder="Optional description"><?php echo htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
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