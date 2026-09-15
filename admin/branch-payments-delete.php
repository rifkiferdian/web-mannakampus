<?php require_once('header.php'); ?>
<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    $statement = $pdo->prepare("SELECT logo FROM tbl_cabang_pembayaran WHERE id = ?");
    $statement->execute(array($id));
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        if (!empty($row['logo'])) {
            $file_path = '../assets/uploads/' . $row['logo'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $statement = $pdo->prepare("DELETE FROM tbl_cabang_pembayaran WHERE id = ?");
        $statement->execute(array($id));

        $_SESSION['success_message'] = 'Payment method berhasil dihapus.';
    }
}

header('Location: branch-payments.php');
exit;