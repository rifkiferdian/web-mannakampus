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
        // Insert data ke database tbl_program
        $statement = $pdo->prepare("INSERT INTO tbl_program (program_name, year, start_date, end_date) VALUES (?,?,?,?)");
        $statement->execute(array(
            $_POST['program_name'],
            $_POST['year'],
            $_POST['start_date'],
            $_POST['end_date']
        ));

        $_SESSION['success_message'] = 'Program is added successfully.';
        header('Location: program.php');
        exit;
    }
}
?>

<section class="content-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">
    <div class="content-header-left">
        <h1 style="margin:0;">Add Program</h1>
    </div>
    <div class="content-header-right">
        <a href="program.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left"></i> View All</a>
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
                            <label for="" class="col-sm-2 control-label">Program Name <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="program_name" value="<?php echo htmlspecialchars($_POST['program_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: Belanja Luar Biasa Murah Spektakuler">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Year <span>*</span></label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" name="year" value="<?php echo htmlspecialchars($_POST['year'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="YYYY">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Start Date <span>*</span></label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="start_date" value="<?php echo htmlspecialchars($_POST['start_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">End Date <span>*</span></label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="end_date" value="<?php echo htmlspecialchars($_POST['end_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
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

<?php require_once('footer.php'); ?><?php require_once('header.php'); ?>

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
        // Insert data ke database tbl_program
        $statement = $pdo->prepare("INSERT INTO tbl_program (program_name, year, start_date, end_date) VALUES (?,?,?,?)");
        $statement->execute(array(
            $_POST['program_name'],
            $_POST['year'],
            $_POST['start_date'],
            $_POST['end_date']
        ));

        $_SESSION['success_message'] = 'Program is added successfully.';
        header('Location: program.php');
        exit;
    }
}
?>

<section class="content-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">
    <div class="content-header-left">
        <h1 style="margin:0;">Add Program</h1>
    </div>
    <div class="content-header-right">
        <a href="program.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left"></i> View All</a>
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
                            <label for="" class="col-sm-2 control-label">Program Name <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="program_name" value="<?php echo htmlspecialchars($_POST['program_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: Belanja Luar Biasa Murah Spektakuler">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Year <span>*</span></label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" name="year" value="<?php echo htmlspecialchars($_POST['year'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="YYYY">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Start Date <span>*</span></label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="start_date" value="<?php echo htmlspecialchars($_POST['start_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">End Date <span>*</span></label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="end_date" value="<?php echo htmlspecialchars($_POST['end_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
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