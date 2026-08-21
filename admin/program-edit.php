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
    margin-left: auto;
}
</style>

<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Ambil data program berdasarkan ID
$statement = $pdo->prepare("SELECT * FROM tbl_program WHERE id = ?");
$statement->execute(array($id));
$data = $statement->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    header('Location: program.php');
    exit;
}

$error_message = '';
$success_message = '';

if(isset($_POST['form1'])) {
    $valid = 1;

    if(empty($_POST['program_name'])) {
        $valid = 0;
        $error_message .= "Program name can not be empty<br>";
    }

    if(empty($_POST['year'])) {
        $valid = 0;
        $error_message .= "Year can not be empty<br>";
    }

    if(empty($_POST['start_date'])) {
        $valid = 0;
        $error_message .= "Start date can not be empty<br>";
    }

    if(empty($_POST['end_date'])) {
        $valid = 0;
        $error_message .= "End date can not be empty<br>";
    }

    if($valid == 1) {
        // Update data di database
        $statement = $pdo->prepare("UPDATE tbl_program SET program_name=?, year=?, start_date=?, end_date=? WHERE id=?");
        $statement->execute(array(
            $_POST['program_name'],
            $_POST['year'],
            $_POST['start_date'],
            $_POST['end_date'],
            $id
        ));

        $_SESSION['success_message'] = 'Program updated successfully.';
        header('Location: program.php');
        exit;
    }

    // Retain input jika validasi gagal
    $data['program_name'] = $_POST['program_name'];
    $data['year']         = $_POST['year'];
    $data['start_date']   = $_POST['start_date'];
    $data['end_date']     = $_POST['end_date'];
}
?>

<section class="content-header" style="display:flex; align-items:center; justify-space-between; flex-wrap:wrap;">
    <div class="content-header-left">
        <h1 style="margin:0;">Edit Program</h1>
    </div>
    <a href="program.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left" style="text-align: center;"></i> View All</a>
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

            <form class="form-horizontal" action="" method="post">

                <div class="box box-info">
                    <div class="box-body">

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Program Name <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="program_name" value="<?php echo htmlspecialchars($data['program_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: Belanja Luar Biasa Murah Spektakuler">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Year <span>*</span></label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" name="year" value="<?php echo htmlspecialchars($data['year'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="YYYY">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Start Date <span>*</span></label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="start_date" value="<?php echo htmlspecialchars($data['start_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">End Date <span>*</span></label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="end_date" value="<?php echo htmlspecialchars($data['end_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
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