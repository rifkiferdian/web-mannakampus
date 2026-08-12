<?php require_once('header.php'); ?>

<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$statement = $pdo->prepare("DELETE FROM tbl_cabang_fasilitas WHERE id = ?");
$statement->execute(array($id));

$_SESSION['success_message'] = 'Branch facility is deleted successfully.';
header('Location: branch-facilities.php');
exit;
?>