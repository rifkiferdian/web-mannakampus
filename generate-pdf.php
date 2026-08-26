<?php
require_once('vendor/autoload.php'); // load DOMPDF
require_once('admin/config.php'); // file koneksi database (berisi $pdo)

use Dompdf\Dompdf;
use Dompdf\Options;

/* ---------------------------------------------------------------------
 * Helper: kalau ada masalah, jangan die() polos -> redirect balik ke
 * winners.php sambil bawa pesan error, supaya user nggak ninggalin
 * halaman winners sama sekali (ditangkap sebagai notifikasi di sana).
 * ------------------------------------------------------------------- */
function redirect_dengan_error($periode, $pesan)
{
    $url = 'winners.php?periode=' . (int) $periode . '&pdf_error=' . urlencode($pesan);
    header('Location: ' . $url);
    exit;
}

/* ---------------------------------------------------------------------
 * 1. Ambil parameter periode dari URL
 * ------------------------------------------------------------------- */
$periode_aktif = isset($_GET['periode']) ? (int) $_GET['periode'] : 0;

if ($periode_aktif <= 0) {
    header('Location: winners.php?pdf_error=' . urlencode('Periode tidak valid.'));
    exit;
}

/* ---------------------------------------------------------------------
 * 2. Ambil info periode & program (buat judul PDF)
 * ------------------------------------------------------------------- */
$info_periode = null;
try {
    $stmt_info = $pdo->prepare("
        SELECT tp.periode_name, p.program_name, p.year
        FROM tbl_periode tp
        JOIN tbl_program p ON tp.id_program = p.id
        WHERE tp.id = ?
    ");
    $stmt_info->execute([$periode_aktif]);
    $info_periode = $stmt_info->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    redirect_dengan_error($periode_aktif, 'Gagal mengambil data periode.');
}

if (!$info_periode) {
    redirect_dengan_error($periode_aktif, 'Data periode tidak ditemukan.');
}

/* ---------------------------------------------------------------------
 * 3. Ambil semua data pemenang untuk periode ini
 * ------------------------------------------------------------------- */
$daftar_pemenang = [];
try {
    $sql_win = "SELECT
                w.winners_name,
                w.address,
                w.member_number,
                r.prize_name,
                r.grand_prize
            FROM tbl_winners w
            INNER JOIN tbl_reward r ON w.id_reward = r.id
            WHERE w.id_periode = :periode
            ORDER BY r.grand_prize DESC, r.id ASC, w.id ASC";

    $stmt_win = $pdo->prepare($sql_win);
    $stmt_win->execute([':periode' => $periode_aktif]);
    $daftar_pemenang = $stmt_win->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    redirect_dengan_error($periode_aktif, 'Gagal mengambil data pemenang.');
}

if (empty($daftar_pemenang)) {
    redirect_dengan_error($periode_aktif, 'Belum ada data pemenang PDF untuk periode ini.');
}

/* ---------------------------------------------------------------------
 * 4. Fungsi mask nomor member (sama seperti di winners.php)
 * ------------------------------------------------------------------- */
function maskMemberNumber($number)
{
    $number = (string) $number;
    $len = strlen($number);
    if ($len <= 7) {
        return str_repeat('*', max(0, $len - 2)) . substr($number, -2);
    }
    $depan    = substr($number, 0, 4);
    $belakang = substr($number, -3);
    return $depan . '****' . $belakang;
}

/* ---------------------------------------------------------------------
 * 5. Susun HTML untuk PDF
 * ------------------------------------------------------------------- */
$judul_pdf = 'Daftar Pemenang ' . htmlspecialchars($info_periode['program_name'])
           . ' Tahun ' . htmlspecialchars($info_periode['year'])
           . ' - ' . htmlspecialchars($info_periode['periode_name']);

$html = '
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h1 { font-size: 16px; text-align: center; color: #f47716; margin-bottom: 4px; }
        p.subtitle { text-align: center; color: #666; margin-top: 0; margin-bottom: 20px; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        th { background: #f47716; color: #fff; font-size: 11px; }
        tr:nth-child(even) { background: #faf5f0; }
        .grand { background: #fff3e0; font-weight: bold; }
        .footer-note { margin-top: 20px; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <h1>' . $judul_pdf . '</h1>
    <p class="subtitle">Dicetak pada ' . date('d F Y, H:i') . ' WIB</p>

    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 24%;">Nama Pemenang</th>
                <th style="width: 30%;">Alamat</th>
                <th style="width: 18%;">Nomor Member</th>
                <th style="width: 24%;">Hadiah</th>
            </tr>
        </thead>
        <tbody>';

$no = 1;
foreach ($daftar_pemenang as $w) {
    $rowClass = ((int) $w['grand_prize'] === 1) ? 'grand' : '';
    $html .= '
            <tr class="' . $rowClass . '">
                <td>' . $no++ . '</td>
                <td>' . htmlspecialchars($w['winners_name']) . '</td>
                <td>' . htmlspecialchars($w['address']) . '</td>
                <td>' . htmlspecialchars(maskMemberNumber($w['member_number'])) . '</td>
                <td>' . htmlspecialchars($w['prize_name']) . '</td>
            </tr>';
}

$html .= '
        </tbody>
    </table>

    <p class="footer-note">Dokumen ini dibuat otomatis oleh sistem Manna Kampus.</p>
</body>
</html>';

/* ---------------------------------------------------------------------
 * 6. Generate PDF dengan DOMPDF
 * ------------------------------------------------------------------- */
$options = new Options();
$options->set('isRemoteEnabled', true); // supaya bisa load gambar/logo dari URL kalau perlu nanti

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$nama_file = 'pemenang-' . preg_replace('/[^a-z0-9]+/i', '-', $info_periode['periode_name']) . '.pdf';

// Stream langsung ke browser (auto download)
$dompdf->stream($nama_file, ['Attachment' => true]);