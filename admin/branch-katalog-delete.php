<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
    header('location: branch-katalog.php');
    exit;
}

$id = (int) $_REQUEST['id'];
$statement = $pdo->prepare("SELECT * FROM tbl_flyer WHERE id = ?");
$statement->execute(array($id));
$data = $statement->fetch(PDO::FETCH_ASSOC);

if($data) {
    if(!empty($data['photo'])) {
        $file_path = '../assets/uploads/' . $data['photo'];
        if(file_exists($file_path)) {
            @unlink($file_path);
        }
    }
    $statement = $pdo->prepare("DELETE FROM tbl_flyer WHERE id=?");
    $statement->execute(array($id));
}

header('location: branch-katalog.php');
exit;
?>