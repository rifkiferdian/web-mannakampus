<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    $statement = $pdo->prepare("SELECT * FROM tbl_cabang_promo WHERE id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    if($total == 0) {
        header('location: logout.php');
        exit;
    }
}

$statement = $pdo->prepare("SELECT * FROM tbl_cabang_promo WHERE id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $foto = $row['foto'];
}

if($foto != '' && $foto != 'default-product.jpg' && file_exists('../assets/uploads/'.$foto)) {
    unlink('../assets/uploads/'.$foto);
}

$statement = $pdo->prepare("DELETE FROM tbl_cabang_promo WHERE id=?");
$statement->execute(array($_REQUEST['id']));

header('location: branch-promo.php');
?>