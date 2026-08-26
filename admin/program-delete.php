<?php require_once('header.php'); ?>

<?php
// Mencegah akses langsung jika tidak ada parameter ID
if (!isset($_GET['id'])) {
    header('Location: program.php');
    exit;
}

$id = (int) $_GET['id'];

// Cek apakah data dengan ID tersebut ada di database
$statement = $pdo->prepare("SELECT * FROM tbl_program WHERE id = ?");
$statement->execute(array($id));
$total = $statement->rowCount();

if ($total == 0) {
    header('Location: program.php');
    exit;
}

// Proses Hapus Data
$statement = $pdo->prepare("DELETE FROM tbl_program WHERE id = ?");
$statement->execute(array($id));

$_SESSION['success_message'] = 'Program is deleted successfully.';
header('Location: program.php');
exit;
?>