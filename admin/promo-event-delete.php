<?php require_once('header.php'); ?>

<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$statement = $pdo->prepare("SELECT image FROM tbl_promo_event WHERE id=?");
$statement->execute(array($id));
$promo_event = $statement->fetch(PDO::FETCH_ASSOC);

if(!$promo_event) {
	header('location: promo-event.php');
	exit;
}

$image_name = basename($promo_event['image']);
$image_path = __DIR__.'/../assets/uploads/'.$image_name;
if($image_name !== '' && is_file($image_path)) {
	unlink($image_path);
}

$statement = $pdo->prepare("DELETE FROM tbl_promo_event WHERE id=?");
$statement->execute(array($id));

header('location: promo-event.php?deleted=1');
exit;
?>
