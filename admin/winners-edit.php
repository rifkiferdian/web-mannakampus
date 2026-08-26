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

$statement = $pdo->prepare("SELECT * FROM tbl_winners WHERE id = ?");
$statement->execute(array($id));
$data = $statement->fetch(PDO::FETCH_ASSOC);

if (!$data) {
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

    $path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = basename($path, "." . $ext);
        if($ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' && $ext!='webp') {
            $valid = 0;
            $error_message .= "You must have to upload jpg, jpeg, gif, webp or png file<br>";
        }
    }

    if($valid == 1) {
        $final_name = $data['photo'];

        if($path != '') {
            if(!empty($data['photo']) && file_exists('../assets/uploads/'.$data['photo'])) {
                unlink('../assets/uploads/'.$data['photo']);
            }
            $final_name = 'winner-'.$_POST['id_periode'].'-'.time().'.'.$ext;
            move_uploaded_file($path_tmp, '../assets/uploads/'.$final_name);
        }

        $statement = $pdo->prepare("UPDATE tbl_winners SET id_periode=?, id_reward=?, winners_name=?, photo=?, address=?, member_number=?, testimonial=?, description=? WHERE id=?");
        $statement->execute(array(
            $_POST['id_periode'],
            $_POST['id_reward'],
            $_POST['winners_name'],
            $final_name,
            $_POST['address'],
            $_POST['member_number'],
            $_POST['testimonial'],
            $_POST['description'],
            $id
        ));

        $_SESSION['success_message'] = 'Winner updated successfully.';
        header('Location: winners.php');
        exit;
    }

    $data['id_periode']    = $_POST['id_periode'];
    $data['id_reward']     = $_POST['id_reward'];
    $data['winners_name']  = $_POST['winners_name'];
    $data['address']       = $_POST['address'];
    $data['member_number'] = $_POST['member_number'];
    $data['testimonial']   = $_POST['testimonial'];
    $data['description']   = $_POST['description'];
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

<section class="content-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">
    <div class="content-header-left">
        <h1 style="margin:0;">Edit Winner</h1>
    </div>
        <a href="winners.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left" style="text-align: center;"></i> View All</a>
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
                                <select class="form-control" name="id_reward">
                                    <option value="">-- Select Reward --</option>
                                    <?php foreach($reward_list as $reward): ?>
                                    <option value="<?php echo $reward['id']; ?>" <?php echo ($data['id_reward'] == $reward['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($reward['prize_name']); ?>
                                    </option>
                                    <?php endforeach; ?>
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
                                <input type="file" name="photo">
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

<?php require_once('footer.php'); ?>