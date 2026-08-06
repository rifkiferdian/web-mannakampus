<?php
// Panggil file config koneksi database
require_once('admin/config.php'); 

header('Content-Type: application/json');

// Jika cabang_id tidak dikirim di URL, berikan default value 1 (Cabang 1)
$cabang_id = isset($_GET['cabang_id']) && intval($_GET['cabang_id']) > 0 ? intval($_GET['cabang_id']) : 1;

try {
    // Jalankan query penarikan flyer
    $statement = $pdo->prepare("SELECT photo FROM tbl_flyer WHERE cabang_id = ? ORDER BY urutan ASC");
    $statement->execute(array($cabang_id));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $images = array();
    foreach ($result as $row) {
        $images[] = $row['photo'];
    }

    // Output JSON
    echo json_encode($images);

} catch (PDOException $e) {
    // Jika ada error pada koneksi/query, tampilkan pesan errornya
    echo json_encode(array("error" => $e->getMessage()));
}
?>