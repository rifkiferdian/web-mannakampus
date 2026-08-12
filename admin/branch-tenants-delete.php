<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    $statement = $pdo->prepare("SELECT * FROM tbl_cabang_stand WHERE id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    if( $total == 0 ) {
        header('location: logout.php');
        exit;
    }
}

$statement = $pdo->prepare("DELETE FROM tbl_cabang_stand WHERE id=?");
$statement->execute(array($_REQUEST['id']));

header('location: branch-tenants.php');
?>
