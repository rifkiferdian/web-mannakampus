<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$bulan = [
    '01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun',
    '07'=>'Jul','08'=>'Agu','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des'
];

$labels = [];
$values = [];

for ($i = 6; $i >= 0; $i--) {
    $date = date('d-m', strtotime("-$i days"));
    [$day, $month] = explode('-', $date);
    $labels[] = $day . ' ' . $bulan[$month];
    $values[] = rand(50, 300);
}

echo json_encode([
    'success' => true,
    'labels'  => $labels,
    'values'  => $values,
]);