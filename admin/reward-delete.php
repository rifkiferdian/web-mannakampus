<?php require_once('header.php'); ?>

<?php
if (!isset($_GET['id'])) {
    header('Location: reward.php');
    exit;
}

$id = (int) $_GET['id'];

$statement = $pdo->prepare("SELECT * FROM tbl_reward WHERE id = ?");
$statement->execute(array($id));
$data = $statement->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    header('Location: reward.php');
    exit;
}

// Hapus berkas gambar dari folder uploads jika ada
if (!empty($data['img']) && file_exists('../assets/uploads/' . $data['img'])) {
    unlink('../assets/uploads/' . $data['img']);
}

// Hapus data dari database
$statement = $pdo->prepare("DELETE FROM tbl_reward WHERE id = ?");
$statement->execute(array($id));

$_SESSION['success_message'] = 'Reward is deleted successfully.';
header('Location: reward.php');
exit;
?>