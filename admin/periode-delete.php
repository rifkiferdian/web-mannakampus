<?php require_once('header.php'); ?>

<?php
if (!isset($_GET['id'])) {
    header('Location: periode.php');
    exit;
}

$id = (int) $_GET['id'];

$statement = $pdo->prepare("SELECT * FROM tbl_periode WHERE id = ?");
$statement->execute(array($id));
$total = $statement->rowCount();

if ($total == 0) {
    header('Location: periode.php');
    exit;
}

$statement = $pdo->prepare("DELETE FROM tbl_periode WHERE id = ?");
$statement->execute(array($id));

$_SESSION['success_message'] = 'Periode is deleted successfully.';
header('Location: periode.php');
exit;
?>