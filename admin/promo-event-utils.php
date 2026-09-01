<?php
require_once(__DIR__.'/image-upload-utils.php');

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
	return array('Promo', 'Store Opening', 'Gebyar Undian', 'Promo Pembayaran');
}

function promo_event_allowed_statuses() {
	return array('Active', 'Inactive');
}
?>