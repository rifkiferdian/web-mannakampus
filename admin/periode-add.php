<?php require_once('header.php'); ?>

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

    if(empty($_POST['periode_name'])) {
        $valid = 0;
        $error_message .= "Periode name can not be empty<br>";
    }

    if(empty($_POST['draw_date'])) {
        $valid = 0;
        $error_message .= "Draw date can not be empty<br>";
    }

    if($valid == 1) {
        $statement = $pdo->prepare("INSERT INTO tbl_periode (id_program, periode_name, draw_date) VALUES (?,?,?)");
        $statement->execute(array(
            $_POST['id_program'],
            $_POST['periode_name'],
            $_POST['draw_date']
        ));

        $_SESSION['success_message'] = 'Periode is added successfully.';
        header('Location: periode.php');
        exit;
    }
}

// Ambil list program untuk dropdown
$statement = $pdo->prepare("SELECT id, program_name, year FROM tbl_program ORDER BY year DESC, id DESC");
$statement->execute();
$program_list = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Periode</h1>
    </div>
    <div class="content-header-right">
        <a href="periode.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left"></i> View All</a>
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

            <form class="form-horizontal" action="" method="post">

                <div class="box box-info">
                    <div class="box-body">

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Program <span>*</span></label>
                            <div class="col-sm-4">
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
                            <label for="" class="col-sm-2 control-label">Periode Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="periode_name" value="<?php echo htmlspecialchars($_POST['periode_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: Periode I">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Draw Date <span>*</span></label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="draw_date" value="<?php echo htmlspecialchars($_POST['draw_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
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