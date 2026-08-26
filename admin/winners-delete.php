<?php require_once('header.php'); ?>

<?php
if (!isset($_GET['id'])) {
    header('Location: winners.php');
    exit;
}

$id = (int) $_GET['id'];

$statement = $pdo->prepare("SELECT * FROM tbl_winners WHERE id = ?");
$statement->execute(array($id));
$data = $statement->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    header('Location: winners.php');
    exit;
}

// Hapus berkas foto pemenang dari folder uploads jika ada
if (!empty($data['photo']) && file_exists('../assets/uploads/' . $data['photo'])) {
    unlink('../assets/uploads/' . $data['photo']);
}

// Hapus data dari database
$statement = $pdo->prepare("DELETE FROM tbl_winners WHERE id = ?");
$statement->execute(array($id));

$_SESSION['success_message'] = 'Winner is deleted successfully.';
header('Location: winners.php');
exit;
?>