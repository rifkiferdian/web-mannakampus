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

$statement = $pdo->prepare("SELECT * FROM tbl_winners WHERE id = ?");
$statement->execute(array($id));
$data = $statement->fetch(PDO::FETCH_ASSOC);

if(!$data) {
    header('Location: winners.php');
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

    if(empty($_POST['id_reward'])) {
        $valid = 0;
        $error_message .= "Reward can not be empty<br>";
    }

    if(empty($_POST['winners_name'])) {
        $valid = 0;
        $error_message .= "Winner name can not be empty<br>";
    }

    // Cek reward harus sesuai dengan periode yang dipilih
    if(!empty($_POST['id_periode']) && !empty($_POST['id_reward'])) {
        $statement = $pdo->prepare("SELECT COUNT(*) FROM tbl_reward WHERE id = ? AND id_periode = ?");
        $statement->execute(array($_POST['id_reward'], $_POST['id_periode']));

        if($statement->fetchColumn() == 0) {
            $valid = 0;
            $error_message .= "Reward tidak sesuai dengan periode yang dipilih.<br>";
        }
    }

    // Cek apakah user upload foto baru
    $has_new_photo = isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE;

    if($has_new_photo) {
        $photo_valid = image_upload_validate($_FILES['photo']);

        if($photo_valid === false) {
            $valid = 0;
            $error_message .= "Unggah gambar JPG atau PNG yang valid dengan ukuran maksimal 3 MB.<br>";
        }
    }

    if($valid == 1) {
        $final_name = $data['photo'];

        // Simpan foto baru sebagai WebP
        if($has_new_photo) {
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
            $statement = $pdo->prepare("UPDATE tbl_winners SET id_periode=?, id_reward=?, winners_name=?, photo=?, address=?, member_number=?, testimonial=?, description=? WHERE id=?");
            $statement->execute(array(
                $_POST['id_periode'],
                $_POST['id_reward'],
                $_POST['winners_name'],
                $final_name,
                $_POST['address'] ?? '',
                $_POST['member_number'] ?? '',
                $_POST['testimonial'] ?? '',
                $_POST['description'] ?? '',
                $id
            ));

            // Hapus foto lama jika ada foto baru
            if($has_new_photo && $data['photo'] !== $final_name) {
                $old_path = __DIR__.'/../assets/uploads/'.basename($data['photo']);

                if(!empty($data['photo']) && is_file($old_path)) {
                    unlink($old_path);
                }
            }

            $_SESSION['success_message'] = 'Winner updated successfully.';
            header('Location: winners.php');
            exit;
        }
    }

    // Jika validasi gagal, simpan input agar tidak reset
    $data['id_periode'] = $_POST['id_periode'] ?? '';
    $data['id_reward'] = $_POST['id_reward'] ?? '';
    $data['winners_name'] = $_POST['winners_name'] ?? '';
    $data['address'] = $_POST['address'] ?? '';
    $data['member_number'] = $_POST['member_number'] ?? '';
    $data['testimonial'] = $_POST['testimonial'] ?? '';
    $data['description'] = $_POST['description'] ?? '';
}

// Option list Periode & Program
$statement = $pdo->prepare("SELECT p.id, p.periode_name, pr.program_name, pr.year 
                            FROM tbl_periode p 
                            LEFT JOIN tbl_program pr ON p.id_program = pr.id 
                            ORDER BY p.id ASC");
$statement->execute();
$periode_list = $statement->fetchAll(PDO::FETCH_ASSOC);

// Option list Reward
$statement = $pdo->prepare("SELECT id, id_periode, prize_name FROM tbl_reward ORDER BY id ASC");
$statement->execute();
$reward_list = $statement->fetchAll(PDO::FETCH_ASSOC);

$selected_reward = (int)($data['id_reward'] ?? 0);
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Edit Winner</h1>
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
                                <select class="form-control" name="id_periode" id="id_periode">
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
                            <label for="" class="col-sm-2 control-label">Reward <span>*</span></label>
                            <div class="col-sm-5">
                                <select class="form-control" name="id_reward" id="id_reward">
                                    <option value="">-- Select Reward --</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Winner Name <span>*</span></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="winners_name" value="<?php echo htmlspecialchars($data['winners_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: Budi Santoso">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Member Number</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="member_number" value="<?php echo htmlspecialchars($data['member_number'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: 001707931669">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Existing Photo</label>
                            <div class="col-sm-4">
                                <?php if(!empty($data['photo']) && file_exists('../assets/uploads/'.$data['photo'])): ?>
                                    <img src="../assets/uploads/<?php echo htmlspecialchars($data['photo']); ?>" alt="" style="width:100px;">
                                <?php else: ?>
                                    <p class="help-block">No photo uploaded.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Change Photo</label>
                            <div class="col-sm-4">
                                <input type="file" name="photo">(Only jpg and png are allowed, max 3 MB)
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($data['address'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: Sleman, DI Yogyakarta">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Testimonial</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="testimonial" rows="3" placeholder="Optional testimonial"><?php echo htmlspecialchars($data['testimonial'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const periodeSelect = document.getElementById('id_periode');
    const rewardSelect = document.getElementById('id_reward');

    const rewards = <?php echo json_encode($reward_list, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
    let selectedReward = <?php echo (int)$selected_reward; ?>;

    function loadRewards(keepSelected = true) {
        const periodeId = periodeSelect.value;

        rewardSelect.innerHTML = '<option value="">-- Select Reward --</option>';

        if(!periodeId) {
            return;
        }

        rewards.forEach(function(reward) {
            if(String(reward.id_periode) === String(periodeId)) {
                const option = document.createElement('option');

                option.value = reward.id;
                option.textContent = reward.prize_name;

                if(keepSelected && String(reward.id) === String(selectedReward)) {
                    option.selected = true;
                }

                rewardSelect.appendChild(option);
            }
        });
    }

    loadRewards(true);

    periodeSelect.addEventListener('change', function() {
        selectedReward = 0;
        loadRewards(false);
    });
});
</script>

<?php require_once('footer.php'); ?>