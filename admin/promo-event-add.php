<?php require_once('header.php'); ?>
<?php require_once('promo-event-utils.php'); ?>

<?php
$is_edit = false;
$form_data = array(
	'title' => '',
	'slug' => '',
	'type' => 'Promo',
	'short_description' => '',
	'content' => '',
	'image' => '',
	'location' => '',
	'start_date' => date('Y-m-d'),
	'end_date' => date('Y-m-d'),
	'button_text' => 'Lihat Detail',
	'button_url' => '',
	'is_featured' => 1,
	'display_order' => 0,
	'status' => 'Active'
);

if(isset($_POST['form1'])) {
	foreach($form_data as $key => $value) {
		if(isset($_POST[$key])) {
			$form_data[$key] = $_POST[$key];
		}
	}
	$form_data['is_featured'] = isset($_POST['is_featured']) ? 1 : 0;
	$form_data['display_order'] = isset($_POST['display_order']) ? max(0, (int)$_POST['display_order']) : 0;
	$form_data['slug'] = promo_event_make_slug($form_data['slug'] !== '' ? $form_data['slug'] : $form_data['title']);

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

	$statement = $pdo->prepare("SELECT id FROM tbl_promo_event WHERE slug=?");
	$statement->execute(array($form_data['slug']));
	if($statement->fetch()) {
		$valid = 0;
		$error_message .= 'Slug already exists.<br>';
	}

	$image_valid = isset($_FILES['image']) ? image_upload_validate($_FILES['image']) : false;
	if($image_valid === false) {
		$valid = 0;
		$error_message .= 'Unggah gambar JPG atau PNG yang valid dengan ukuran max 3 MB.<br>';
	}

	if($valid) {
		$image_name = image_upload_save_as_webp(
			$_FILES['image'],
			'promo-event-'.$form_data['slug'],
			__DIR__.'/../assets/uploads/'
		);
		if($image_name === false) {
			$error_message .= 'Gambar tidak dapat diunggah.<br>';
		} else {
			$button_text = trim($form_data['button_text']) !== '' ? trim($form_data['button_text']) : 'Lihat Detail';
			$button_url = trim($form_data['button_url']) !== '' ? trim($form_data['button_url']) : 'promo-event/'.$form_data['slug'];
			$statement = $pdo->prepare("INSERT INTO tbl_promo_event (title,slug,type,short_description,content,image,location,start_date,end_date,button_text,button_url,is_featured,display_order,status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$statement->execute(array(
				trim($form_data['title']), $form_data['slug'], $form_data['type'],
				trim($form_data['short_description']), $form_data['content'], $image_name,
				trim($form_data['location']), $form_data['start_date'], $form_data['end_date'],
				$button_text, $button_url, $form_data['is_featured'],
				$form_data['display_order'], $form_data['status']
			));
			$_SESSION['success_message'] = 'Promo atau event berhasil ditambahkan.';
			header('Location: promo-event.php');
			exit;
		}
	}
}
?>

<section class="content-header">
	<div class="content-header-left"><h1>Tambah Promo &amp; Event Utama</h1></div>
	<div class="content-header-right"><a href="promo-event.php" class="btn btn-primary btn-sm">Lihat Semua</a></div>
</section>

<?php require_once('promo-event-form.php'); ?>
<?php require_once('footer.php'); ?>