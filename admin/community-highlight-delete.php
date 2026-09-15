<?php require_once('header.php'); ?>

<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    // Ambil gambar dulu, biar file lama bisa dihapus juga (opsional tapi rapi)
    $stmt = $pdo->prepare("SELECT image FROM sorotan_komunitas WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("DELETE FROM sorotan_komunitas WHERE id = ?");
    $stmt->execute([$id]);

    // Hapus file gambar dari server (opsional, aman kalau file tidak ada)
    if ($row && !empty($row['image'])) {
        $filePath = __DIR__ . '/../assets/uploads/' . basename($row['image']);
        if (file_exists($filePath)) {
            @unlink($filePath);
        }
    }

    $_SESSION['success_message'] = 'Highlight berhasil dihapus.';
} else {
    $_SESSION['success_message'] = 'ID tidak valid.';
}

header('Location: community-highlight.php');
exit;
