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

$statement = $pdo->prepare("SELECT * FROM tbl_sponsor WHERE id = ?");
$statement->execute(array($id));
$data = $statement->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    header('Location: sponsor.php');
    exit;
}

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

    $path = $_FILES['img']['name'];
    $path_tmp = $_FILES['img']['tmp_name'];

    if($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = basename($path, "." . $ext);
        if($ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' && $ext!='webp') {
            $valid = 0;
            $error_message .= "You must have to upload jpg, jpeg, gif, webp or png file<br>";
        }
    }

    if($valid == 1) {
        $final_name = $data['img'];

        if($path != '') {
            if(!empty($data['img']) && file_exists('../assets/uploads/'.$data['img'])) {
                unlink('../assets/uploads/'.$data['img']);
            }
            $final_name = 'sponsor-'.$_POST['id_program'].'-'.time().'.'.$ext;
            move_uploaded_file($path_tmp, '../assets/uploads/'.$final_name);
        }

        $statement = $pdo->prepare("UPDATE tbl_sponsor SET id_program=?, sponsor_name=?, img=? WHERE id=?");
        $statement->execute(array(
            $_POST['id_program'],
            $_POST['sponsor_name'],
            $final_name,
            $id
        ));

        $_SESSION['success_message'] = 'Sponsor updated successfully.';
        header('Location: sponsor.php');
        exit;
    }

    $data['id_program']   = $_POST['id_program'];
    $data['sponsor_name'] = $_POST['sponsor_name'];
}

// Option list Program (Urutan ASC)
$statement = $pdo->prepare("SELECT id, program_name, year FROM tbl_program ORDER BY id ASC");
$statement->execute();
$program_list = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="content-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">
    <div class="content-header-left">
        <h1 style="margin:0;">Edit Sponsor</h1>
    </div>
        <a href="sponsor.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left" style="text-align: center;"></i> View All</a>
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
                                    <option value="<?php echo $program['id']; ?>" <?php echo ($data['id_program'] == $program['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($program['program_name'] . ' (' . $program['year'] . ')'); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Sponsor Name <span>*</span></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="sponsor_name" value="<?php echo htmlspecialchars($data['sponsor_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: Bank BRI">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Existing Logo</label>
                            <div class="col-sm-4">
                                <?php if(!empty($data['img']) && file_exists('../assets/uploads/'.$data['img'])): ?>
                                    <img src="../assets/uploads/<?php echo htmlspecialchars($data['img']); ?>" alt="" style="width:120px;">
                                <?php else: ?>
                                    <p class="help-block">No logo uploaded.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Change Logo</label>
                            <div class="col-sm-4">
                                <input type="file" name="img">
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