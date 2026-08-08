<?php
// Panggil file config koneksi database
require_once('admin/config.php'); 

header('Content-Type: application/json');

// Jika id_cabang tidak dikirim di URL, berikan default value 1 (Cabang 1)
$id_cabang = isset($_GET['id_cabang']) && intval($_GET['id_cabang']) > 0 ? intval($_GET['id_cabang']) : 1;

try {
    // Jalankan query penarikan flyer
    $statement = $pdo->prepare("SELECT photo FROM tbl_flyer WHERE id_cabang = ? ORDER BY urutan ASC");
    $statement->execute(array($id_cabang));
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