<?php
function promo_event_escape($value) {
	return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function promo_event_make_slug($value) {
	$value = trim($value);
	if(function_exists('iconv')) {
		$converted = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
		if($converted !== false) {
			$value = $converted;
		}
	}
	$value = strtolower($value);
	$value = preg_replace('/[^a-z0-9]+/', '-', $value);
	$value = trim($value, '-');
	return $value !== '' ? $value : 'promo-event';
}

function promo_event_valid_date($value) {
	$date = DateTime::createFromFormat('Y-m-d', $value);
	return $date && $date->format('Y-m-d') === $value;
}

function promo_event_allowed_types() {
	return array('Promo', 'Store Opening', 'Gebyar Undian');
}

function promo_event_allowed_statuses() {
	return array('Active', 'Inactive');
}

function promo_event_upload_extension($file) {
	if(
		!isset($file['error'], $file['tmp_name'], $file['size']) ||
		(int)$file['error'] !== UPLOAD_ERR_OK ||
		$file['tmp_name'] === '' ||
		!is_uploaded_file($file['tmp_name']) ||
		(int)$file['size'] <= 0 ||
		(int)$file['size'] > 8 * 1024 * 1024
	) {
		return false;
	}

	$image_info = getimagesize($file['tmp_name']);
	if($image_info === false || !isset($image_info[2])) {
		return false;
	}

	$extensions = array(
		IMAGETYPE_JPEG => 'jpg',
		IMAGETYPE_PNG => 'png',
		IMAGETYPE_GIF => 'gif'
	);
	if(defined('IMAGETYPE_WEBP')) {
		$extensions[IMAGETYPE_WEBP] = 'webp';
	}

	return isset($extensions[$image_info[2]]) ? $extensions[$image_info[2]] : false;
}

function promo_event_image_name($slug, $extension) {
	try {
		$suffix = bin2hex(random_bytes(4));
	} catch(Exception $exception) {
		$suffix = (string)mt_rand(100000, 999999);
	}
	return 'promo-event-'.$slug.'-'.date('YmdHis').'-'.$suffix.'.'.$extension;
}
?>
