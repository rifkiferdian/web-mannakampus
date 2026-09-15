<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php'; // hasil dari composer require

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact-us.php');
    exit;
}

$nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
$alamat_email = trim($_POST['alamat_email'] ?? '');
$subjek       = trim($_POST['subjek'] ?? '');
$cabang       = trim($_POST['cabang'] ?? '');
$pesan_anda   = trim($_POST['pesan_anda'] ?? '');

// Jika subjek "Lainnya", pakai isian custom sebagai subjek final
if ($subjek === 'Lainnya' && !empty($_POST['subjek_lainnya'])) {
    $subjek = trim($_POST['subjek_lainnya']);
}

// Validasi sederhana
if ($nama_lengkap === '' || $alamat_email === '' || $pesan_anda === '') {
    $_SESSION['contact_form_message'] = 'Mohon lengkapi semua field yang wajib diisi.';
    header('Location: contact-us.php');
    exit;
}

if (!filter_var($alamat_email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['contact_form_message'] = 'Format email tidak valid.';
    header('Location: contact-us.php');
    exit;
}

// ================== KONFIGURASI SMTP (ISI SESUAI CPANEL) ==================
$smtp_host     = 'mail.mannakampus.com';       // ganti sesuai domain kamu
$smtp_username = 'noreply@mannakampus.com';    // email pengirim dari cPanel
$smtp_password = 'ISI_PASSWORD_EMAIL_DI_SINI'; // password email tsb
$smtp_port     = 465;                          // 465 (SSL) atau 587 (TLS)
$smtp_secure   = PHPMailer::ENCRYPTION_SMTPS;  // pakai SMTPS untuk port 465, atau STARTTLS untuk 587
$email_tujuan  = 'info@mannakampus.com';       // email admin penerima pesan
// ============================================================================

$mail = new PHPMailer(true);

try {
    // Konfigurasi server SMTP
    $mail->isSMTP();
    $mail->Host       = $smtp_host;
    $mail->SMTPAuth   = true;
    $mail->Username   = $smtp_username;
    $mail->Password   = $smtp_password;
    $mail->SMTPSecure = $smtp_secure;
    $mail->Port       = $smtp_port;

    // Pengirim & penerima
    $mail->setFrom($smtp_username, 'Website Manna Kampus');
    $mail->addAddress($email_tujuan);
    $mail->addReplyTo($alamat_email, $nama_lengkap); // biar admin bisa langsung reply ke pengirim

    // Konten email
    $mail->isHTML(true);
    $mail->Subject = 'Pesan Baru dari Website: ' . $subjek;
    $mail->Body    = "
        <h3>Pesan Baru dari Form Kontak</h3>
        <p><strong>Nama:</strong> " . htmlspecialchars($nama_lengkap) . "</p>
        <p><strong>Email:</strong> " . htmlspecialchars($alamat_email) . "</p>
        <p><strong>Subjek:</strong> " . htmlspecialchars($subjek) . "</p>
        <p><strong>Manna Kampus:</strong> " . htmlspecialchars($cabang) . "</p>
        <p><strong>Pesan:</strong><br>" . nl2br(htmlspecialchars($pesan_anda)) . "</p>
    ";
    $mail->AltBody = "Nama: $nama_lengkap\nEmail: $alamat_email\nSubjek: $subjek\nManna Kampus: $cabang\nPesan: $pesan_anda";

    $mail->send();
    $_SESSION['contact_form_message'] = 'Terima kasih, pesan Anda telah berhasil dikirim. Tim kami akan segera menghubungi Anda.';
} catch (Exception $e) {
    $_SESSION['contact_form_message'] = 'Maaf, pesan gagal dikirim. Silakan coba lagi nanti.';
    // Untuk debugging saat development, boleh sementara aktifkan baris ini:
    // error_log('Mail Error: ' . $mail->ErrorInfo);
}

header('Location: contact-us.php');
exit;
