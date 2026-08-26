<?php require_once('header.php'); ?>
<?php require_once('promo-event-utils.php'); ?>

<style>
.no-plus-icon::before {
    display: none !important;
}

.no-plus-icon {
    text-align: center;
}

.content-header{
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}
.content-header h1{
    margin: 0;
}
.content-header-right{
    margin-left: auto;
}
</style>

<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$statement = $pdo->prepare("SELECT * FROM tbl_promo_event WHERE id=?");
$statement->execute(array($id));
$form_data = $statement->fetch(PDO::FETCH_ASSOC);

if(!$form_data) {
	header('location: promo-event.php');
	exit;
}

$is_edit = true;

if(isset($_POST['form1'])) {
	$original_image = $form_data['image'];
	$original_slug = $form_data['slug'];
	$original_button_url = $form_data['button_url'];
	$posted_keys = array('title','slug','type','short_description','content','location','start_date','end_date','button_text','button_url','status');
	foreach($posted_keys as $key) {
		$form_data[$key] = isset($_POST[$key]) ? $_POST[$key] : '';
	}
	$form_data['is_featured'] = isset($_POST['is_featured']) ? 1 : 0;
	$form_data['display_order'] = isset($_POST['display_order']) ? max(0, (int)$_POST['display_order']) : 0;
	$form_data['slug'] = promo_event_make_slug($form_data['slug'] !== '' ? $form_data['slug'] : $form_data['title']);
	$form_data['image'] = $original_image;

	$valid = 1;
	if(trim($form_data['title']) === '') {
		$valid = 0;
		$error_message .= 'Title can not be empty.<br>';
	}
	if(trim($form_data['short_description']) === '' || trim($form_data['content']) === '') {
		$valid = 0;
		$error_message .= 'Short description and content can not be empty.<br>';
	}
	if(!promo_event_valid_date($form_data['start_date']) || !promo_event_valid_date($form_data['end_date'])) {
		$valid = 0;
		$error_message .= 'Event period is not valid.<br>';
	} elseif($form_data['end_date'] < $form_data['start_date']) {
		$valid = 0;
		$error_message .= 'End date must be after or equal to start date.<br>';
	}
	if(!in_array($form_data['type'], promo_event_allowed_types(), true)) {
		$valid = 0;
		$error_message .= 'Tipe promo atau event tidak valid.<br>';
	}
	if(!in_array($form_data['status'], promo_event_allowed_statuses(), true)) {
		$valid = 0;
		$error_message .= 'Status tidak valid.<br>';
	}

	$statement = $pdo->prepare("SELECT id FROM tbl_promo_event WHERE slug=? AND id!=?");
	$statement->execute(array($form_data['slug'], $id));
	if($statement->fetch()) {
		$valid = 0;
		$error_message .= 'Slug already exists.<br>';
	}

	$new_image_name = $form_data['image'];
	$has_new_image = isset($_FILES['image']['name']) && $_FILES['image']['name'] !== '';
	if($has_new_image) {
		$image_extension = promo_event_upload_extension($_FILES['image']);
		if($image_extension === false) {
			$valid = 0;
			$error_message .= 'Unggah gambar JPG, PNG, GIF, atau WebP yang valid dengan ukuran maksimal 8 MB.<br>';
		}
	}

	if($valid) {
		if($has_new_image) {
			$new_image_name = promo_event_image_name($form_data['slug'], $image_extension);
			if(!move_uploaded_file($_FILES['image']['tmp_name'], __DIR__.'/../assets/uploads/'.$new_image_name)) {
				$valid = 0;
				$error_message .= 'Gambar tidak dapat diunggah.<br>';
			}
		}

		if($valid) {
			$button_text = trim($form_data['button_text']) !== '' ? trim($form_data['button_text']) : 'Lihat Detail';
			$posted_button_url = trim($form_data['button_url']);
			$original_url_is_default = trim($original_button_url) === '' || trim($original_button_url) === 'promo-event/'.$original_slug;
			$button_url = $posted_button_url;
			if($posted_button_url === '' || ($original_url_is_default && $posted_button_url === trim($original_button_url))) {
				$button_url = 'promo-event/'.$form_data['slug'];
			}
			$statement = $pdo->prepare("UPDATE tbl_promo_event SET title=?,slug=?,type=?,short_description=?,content=?,image=?,location=?,start_date=?,end_date=?,button_text=?,button_url=?,is_featured=?,display_order=?,status=? WHERE id=?");
			$statement->execute(array(
				trim($form_data['title']), $form_data['slug'], $form_data['type'],
				trim($form_data['short_description']), $form_data['content'], $new_image_name,
				trim($form_data['location']), $form_data['start_date'], $form_data['end_date'],
				$button_text, $button_url, $form_data['is_featured'],
				$form_data['display_order'], $form_data['status'], $id
			));

			if($has_new_image && $original_image !== $new_image_name) {
				$old_image_path = __DIR__.'/../assets/uploads/'.basename($original_image);
				if(is_file($old_image_path)) {
					unlink($old_image_path);
				}
			}

			$_SESSION['success_message'] = 'Promo atau event berhasil diperbarui.';
			header('Location: promo-event.php');
			exit;
		}
	}
}
?>

<section class="content-header">
	<div class="content-header-left"><h1>Edit Promo &amp; Event Utama</h1></div>
		<a href="promo-event.php" class="btn btn-primary btn-sm no-plus-icon"><i class="fa fa-arrow-left" style="text-align: center;"></i> View All</a>
</section>

<?php require_once('promo-event-form.php'); ?>
<?php require_once('footer.php'); ?>
