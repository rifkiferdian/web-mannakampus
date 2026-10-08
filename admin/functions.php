<?php

// Write custom functions here

function get_social_url($value) {
    $value = trim(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
    if (preg_match('#(?:href|cite|data-instgrm-permalink)=["\']([^"\']+)["\']#i', $value, $m)) $value = $m[1];
    return strtok($value, '?');
}

function download_social_thumbnail($value, $destination_dir, $prefix = 'highlight') {
    $url = get_social_url($value);
    if (!filter_var($url, FILTER_VALIDATE_URL)) return null;
    $ch = curl_init($url);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER=>true, CURLOPT_FOLLOWLOCATION=>true, CURLOPT_TIMEOUT=>15, CURLOPT_USERAGENT=>'Mozilla/5.0']);
    $html = curl_exec($ch); curl_close($ch);
    if (!$html || !preg_match('#<meta[^>]+property=["\']og:image["\'][^>]+content=["\']([^"\']+)#i', $html, $m)) return null;
    $image_url = html_entity_decode($m[1], ENT_QUOTES, 'UTF-8');
    $ch = curl_init($image_url); curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER=>true, CURLOPT_FOLLOWLOCATION=>true, CURLOPT_TIMEOUT=>15, CURLOPT_USERAGENT=>'Mozilla/5.0']);
    $data = curl_exec($ch); $type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE); curl_close($ch);
    if (!$data || strpos((string)$type, 'image/') !== 0) return null;
    $ext = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'][$type] ?? 'jpg';
    $name = $prefix . '-' . time() . '-' . uniqid() . '.' . $ext;
    return file_put_contents($destination_dir . $name, $data) ? $name : null;
}
