<?php
require_once('header.php');

if(!isset($_REQUEST['id'])) {
    header('Location: branch-galleries.php');
    exit;
} else {
    $id = $_REQUEST['id'];
}

$statement = $pdo->prepare("SELECT foto FROM tbl_cabang_galeri WHERE id = ?");
$statement->execute(array($id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row) {
    $foto = $row['foto'];
}

if($foto != '' && file_exists('../assets/uploads/'.$foto)){
    @unlink('../assets/uploads/'.$foto);
}

$statement = $pdo->prepare("DELETE FROM tbl_cabang_galeri WHERE id = ?");
$statement->execute(array($id));

$_SESSION['success_message'] = 'Branch gallery is deleted successfully.';
header('Location: branch-galleries.php');
exit;

?>
