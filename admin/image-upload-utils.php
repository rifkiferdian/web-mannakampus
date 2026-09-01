<?php

/**
 * Validasi file upload gambar & kembalikan ekstensi asli (berdasar isi file, bukan nama).
 * Return: string ekstensi ('jpg', 'png', 'gif', 'webp') atau false kalau tidak valid.
 */
function image_upload_validate($file, $maxSizeBytes = 3 * 1024 * 1024) {
	if(
		!isset($file['error'], $file['tmp_name'], $file['size']) ||
		(int)$file['error'] !== UPLOAD_ERR_OK ||
		$file['tmp_name'] === '' ||
		!is_uploaded_file($file['tmp_name']) ||
		(int)$file['size'] <= 0 ||
		(int)$file['size'] > $maxSizeBytes
	) {
		return false;
	}

	$image_info = getimagesize($file['tmp_name']);
	if($image_info === false || !isset($image_info[2])) {
		return false;
	}

	$extensions = array(
		IMAGETYPE_JPEG => 'jpg',
		IMAGETYPE_PNG => 'png'
	);
	if(defined('IMAGETYPE_WEBP')) {
		$extensions[IMAGETYPE_WEBP] = 'webp';
	}

	return isset($extensions[$image_info[2]]) ? $extensions[$image_info[2]] : false;
}

/**
 * Generate nama file unik untuk gambar yang disimpan.
 * $prefix bisa diisi sesuai konteks menu, misal 'promo-event', 'produk', 'galeri'.
 */
function image_upload_generate_name($prefix, $extension) {
	try {
		$suffix = bin2hex(random_bytes(4));
	} catch(Exception $exception) {
		$suffix = (string)mt_rand(100000, 999999);
	}
	$prefix = preg_replace('/[^a-z0-9\-]+/', '-', strtolower($prefix));
	return $prefix.'-'.date('YmdHis').'-'.$suffix.'.'.$extension;
}

/**
 * Validasi + convert gambar ke WEBP + simpan ke folder tujuan.
 * Return: nama file baru (string) kalau berhasil, false kalau gagal.
 */
function image_upload_save_as_webp($file, $prefix, $uploadDir, $maxWidth = 1200, $quality = 80) {
	$image_info = getimagesize($file['tmp_name']);
	if($image_info === false) {
		return false;
	}

	switch($image_info[2]) {
		case IMAGETYPE_JPEG:
			$source = imagecreatefromjpeg($file['tmp_name']);
			break;
		case IMAGETYPE_PNG:
			$source = imagecreatefrompng($file['tmp_name']);
			imagepalettetotruecolor($source);
			imagealphablending($source, true);
			imagesavealpha($source, true);
			break;
		case IMAGETYPE_WEBP:
			$source = imagecreatefromwebp($file['tmp_name']);
			break;
		default:
			return false;
	}

	if($source === false) {
		return false;
	}

	$origWidth = imagesx($source);
	$origHeight = imagesy($source);

	if($origWidth > $maxWidth) {
		$newWidth = $maxWidth;
		$newHeight = intval($origHeight * ($maxWidth / $origWidth));
		$resized = imagecreatetruecolor($newWidth, $newHeight);
		imagealphablending($resized, false);
		imagesavealpha($resized, true);
		imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
		imagedestroy($source);
		$source = $resized;
	}

	$image_name = image_upload_generate_name($prefix, 'webp');
	$destination = rtrim($uploadDir, '/').'/'.$image_name;

	$saved = imagewebp($source, $destination, $quality);
	imagedestroy($source);

	return $saved ? $image_name : false;
}