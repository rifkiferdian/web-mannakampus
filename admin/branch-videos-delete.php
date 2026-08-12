<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_cabang_video WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}

// Getting photo ID to unlink from folder
$statement = $pdo->prepare("SELECT * FROM tbl_cabang_video WHERE id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$banner = $row['banner'];
}

// Unlink the banner
if($banner!='') {
	unlink('../assets/uploads/'.$banner);	
}
	
// Delete from tbl_cabang_video
$statement = $pdo->prepare("DELETE FROM tbl_cabang_video WHERE id=?");
$statement->execute(array($_REQUEST['id']));

header('location: branch-videos.php');
?>