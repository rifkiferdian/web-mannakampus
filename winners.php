<?php require_once('header.php');?>

<?php if (!empty($_GET['pdf_error'])):?>
<div class="mk-pdf-notif" id="mkPdfNotif">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="12" y1="8" x2="12" y2="12"></line>
        <line x1="12" y1="16" x2="12.01" y2="16"></line>
    </svg>
    <span><?php echo htmlspecialchars($_GET['pdf_error']); ?></span>
    <button type="button" onclick="document.getElementById('mkPdfNotif').remove()" aria-label="Tutup">&times;</button>
</div>
<?php endif; ?>
<script>
setTimeout(function () {
    var notif = document.getElementById('mkPdfNotif');
    if (notif) notif.remove();
}, 5000); // hilang otomatis setelah 5 detik
</script>
<?php
define('WINNER_PHOTO_PATH', 'assets/uploads/');

/* ---------------------------------------------------------------------
 * 1. Tangkap Parameter dari URL (Bisa ?periode=id ATAU ?tahun=yyyy)
 * ------------------------------------------------------------------- */
$get_periode = isset($_GET['periode']) ? (int) $_GET['periode'] : 0;
$get_tahun   = isset($_GET['tahun']) ? (int) $_GET['tahun'] : 0;

if ($get_tahun > 0) {
    $tahun_aktif = $get_tahun;
} elseif ($get_periode > 0) {
    try {
        $stmt_t = $pdo->prepare("SELECT p.year FROM tbl_periode tp JOIN tbl_program p ON tp.id_program = p.id WHERE tp.id = ?");
        $stmt_t->execute([$get_periode]);
        $res_t = $stmt_t->fetch(PDO::FETCH_ASSOC);
        $tahun_aktif = $res_t ? (int)$res_t['year'] : date('Y');
    } catch (PDOException $e) {
        $tahun_aktif = date('Y');
    }
} else {
    try {
        $stmt_def = $pdo->query("SELECT year FROM tbl_program ORDER BY year DESC LIMIT 1");
        $res_def = $stmt_def->fetch(PDO::FETCH_ASSOC);
        $tahun_aktif = $res_def ? (int)$res_def['year'] : date('Y');
    } catch (PDOException $e) {
        $tahun_aktif = date('Y');
    }
}
/* ---------------------------------------------------------------------
 * Ambil Nama Program yang Aktif Berdasarkan Tahun
 * ------------------------------------------------------------------- */
$nama_program_aktif = "Belanja Luar Biasa Murah Spektakuler"; // Default fallback
try {
    $stmt_prog = $pdo->prepare("SELECT program_name FROM tbl_program WHERE year = ? LIMIT 1");
    $stmt_prog->execute([$tahun_aktif]);
    $res_prog = $stmt_prog->fetch(PDO::FETCH_ASSOC);
    if ($res_prog && !empty($res_prog['program_name'])) {
        // Membersihkan teks jika di database ada tambahan kurung, atau dipakai apa adanya
        $nama_program_aktif = $res_prog['program_name'];
    }
} catch (PDOException $e) {
    // Biarkan default jika error
}
/* ---------------------------------------------------------------------
 * 2. Ambil daftar periode HANYA untuk tahun aktif tersebut
 * --------------------------------------------------------------------- */
$daftar_periode = [];
try {
    $sql_p = "SELECT tp.id, tp.periode_name, tp.draw_date 
              FROM tbl_periode tp 
              JOIN tbl_program p ON tp.id_program = p.id 
              WHERE p.year = :tahun 
              ORDER BY tp.id ASC";
    $stmt_p = $pdo->prepare($sql_p);
    $stmt_p->execute([':tahun' => $tahun_aktif]);
    $daftar_periode = $stmt_p->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $daftar_periode = [];
}

/* ---------------------------------------------------------------------
 * 3. Tentukan Periode Aktif untuk Query Pemenang
 * ------------------------------------------------------------------- */
if ($get_periode > 0) {
    $periode_aktif = $get_periode;
} else {
    $periode_aktif = !empty($daftar_periode) ? $daftar_periode[0]['id'] : 0;
}
$daftar_pemenang_raw = [];
try {
    $sql_win = "SELECT
                w.id          AS winner_id,
                w.winners_name,
                w.photo       AS winner_photo,
                w.address,
                w.member_number,
                w.testimonial,
                w.description   AS winner_description,
                r.id          AS reward_id,
                r.prize_name,
                r.grand_prize
            FROM tbl_winners w
            INNER JOIN tbl_reward r ON w.id_reward = r.id
            WHERE w.id_periode = :periode
            ORDER BY r.grand_prize DESC, r.id ASC, w.id ASC";

    $stmt_win = $pdo->prepare($sql_win);
    $stmt_win->execute([':periode' => $periode_aktif]);
    $daftar_pemenang_raw = $stmt_win->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $daftar_pemenang_raw = [];
}
/* ---------------------------------------------------------------------
 * 4. Kelompokkan pemenang berdasarkan nama hadiah (prize_name)
 *    supaya tampilan lebih rapi: "Sepeda Motor" -> daftar pemenangnya, dst
 * ------------------------------------------------------------------- */
$pemenang_by_reward = [];
$dedup_index        = []; // reward_id => [ 'nama|alamat' => index di array winners ]

foreach ($daftar_pemenang_raw as $row) {
    $key = $row['reward_id'];
    if (!isset($pemenang_by_reward[$key])) {
        $pemenang_by_reward[$key] = [
            'prize_name'   => $row['prize_name'],
            'grand_prize'  => $row['grand_prize'],
            'winners'      => [],
        ];
        $dedup_index[$key] = [];
    }

    // Kunci unik per pemenang: nama + alamat (di-normalisasi lowercase & trim)
    // Ini untuk menangani data yang kebetulan terduplikasi di tabel tbl_winners
    $nama_key = strtolower(trim($row['winners_name'])) . '|' . strtolower(trim($row['address']));

    if (isset($dedup_index[$key][$nama_key])) {
        // Ditemukan duplikat -> gabungkan, utamakan field yang lebih lengkap
        // (misal salah satu baris punya member_number, yang satunya kosong)
        $existing_idx = $dedup_index[$key][$nama_key];
        $existing     = $pemenang_by_reward[$key]['winners'][$existing_idx];

        foreach (['member_number', 'testimonial', 'winner_description', 'winner_photo'] as $field) {
            if (empty($existing[$field]) && !empty($row[$field])) {
                $existing[$field] = $row[$field];
            }
        }

        $pemenang_by_reward[$key]['winners'][$existing_idx] = $existing;
        continue; // baris duplikat tidak ditambahkan sebagai entri baru
    }

    $dedup_index[$key][$nama_key] = count($pemenang_by_reward[$key]['winners']);
    $pemenang_by_reward[$key]['winners'][] = $row;
}

// Ambil nama & tahun periode aktif (tahun diambil dari draw_date, dipakai di badge "GRAND PRIZE WINNER 20XX")
$nama_periode_aktif  = '';
$tahun_periode_aktif = date('Y');
foreach ($daftar_periode as $p) {
    if ($p['id'] == $periode_aktif) {
        $nama_periode_aktif = $p['periode_name'];
        if (!empty($p['draw_date'])) {
            $tahun_periode_aktif = date('Y', strtotime($p['draw_date']));
        }
        break;
    }
}

/* ---------------------------------------------------------------------
 * 5. Pisahkan pemenang Grand Prize (untuk ditampilkan sebagai slider
 *    khusus di bagian atas) dari pemenang reguler (tampil di grid biasa)
 * ------------------------------------------------------------------- */
$grand_prize_winners = [];   // flat list, tiap item = 1 pemenang grand prize
$reward_groups_biasa = [];   // grup hadiah non-grand-prize

foreach ($pemenang_by_reward as $group) {
    if ((int) $group['grand_prize'] === 1) {
        foreach ($group['winners'] as $w) {
            $w['prize_name'] = $group['prize_name']; // dibawa serta untuk label ribbon
            $grand_prize_winners[] = $w;
        }
    } else {
        $reward_groups_biasa[] = $group;
    }
}

/**
 * Menyamarkan nomor member untuk privasi.
 * Contoh: "001707931669" -> "0017****669"
 * (4 digit depan tetap terlihat, 3 digit belakang tetap terlihat, sisanya disembunyikan)
 */
function maskMemberNumber($number)
{
    $number = (string) $number;
    $len = strlen($number);

    // Kalau nomornya terlalu pendek untuk disamarkan secara aman, sembunyikan semua kecuali 2 digit terakhir
    if ($len <= 7) {
        return str_repeat('*', max(0, $len - 2)) . substr($number, -2);
    }

    $depan    = substr($number, 0, 4);
    $belakang = substr($number, -3);
    return $depan . '****' . $belakang;
}

/**
 * Menggabungkan array nama kategori jadi kalimat gaya Indonesia.
 * Contoh: ["Motor", "Smartphone", "Logam Mulia"] -> "Motor, Smartphone, dan Logam Mulia"
 */
function implodeDanIndonesia(array $items)
{
    $items = array_values(array_unique($items));
    $count = count($items);

    if ($count === 0) return '';
    if ($count === 1) return $items[0];

    $terakhir = array_pop($items);
    return implode(', ', $items) . ', dan ' . $terakhir;
}

/**
 * Merender 1 kartu pemenang (selain grand prize) sesuai desain:
 * foto pemenang + label kategori hadiah di atas, nama, alamat,
 * nomor undian (disamarkan), dan testimoni singkat di bawahnya.
 */
function render_winner_card($prize_name, array $winner)
{
    ob_start();
    ?>
    <div class="mk-prize-card">
        <div class="mk-prize-photo">
            <img src="<?php echo WINNER_PHOTO_PATH . htmlspecialchars($winner['winner_photo']); ?>"
                 alt="<?php echo htmlspecialchars($winner['winners_name']); ?>"
                 onerror="this.src='assets/img/no-avatar.png'">
            <span class="mk-prize-tag"><?php echo htmlspecialchars($prize_name); ?></span>
        </div>
        <div class="mk-prize-body">
            <div class="mk-prize-name"><?php echo htmlspecialchars($winner['winners_name']); ?></div>
            <div class="mk-prize-address"><?php echo htmlspecialchars($winner['address']); ?></div>

            <?php if (!empty($winner['member_number'])): ?>
                <div class="mk-prize-member">No. Undian: <?php echo htmlspecialchars(maskMemberNumber($winner['member_number'])); ?></div>
            <?php endif; ?>

            <?php if (!empty($winner['testimonial'])): ?>
                <div class="mk-prize-quote">"<?php echo htmlspecialchars($winner['testimonial']); ?>"</div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/* ---------------------------------------------------------------------
 * 6. Siapkan data untuk section "Pemenang Utama Lainnya":
 *    - $preview_cards          -> 1 kartu wakil per kategori hadiah (tampil default)
 *    - $semua_winner_lainnya   -> seluruh pemenang non-grand-prize (tampil saat "Lihat Semua Nama")
 *    - $kategori_lainnya_text  -> teks kategori untuk subjudul, dibuat otomatis dari data
 * ------------------------------------------------------------------- */
$preview_cards        = [];
$semua_winner_lainnya = [];
$daftar_kategori      = [];

foreach ($reward_groups_biasa as $group) {
    if (empty($group['winners'])) continue;

    $daftar_kategori[] = $group['prize_name'];

    // Kartu wakil (preview) -> ambil pemenang pertama dari tiap kategori hadiah
    $preview_cards[] = [
        'prize_name' => $group['prize_name'],
        'winner'     => $group['winners'][0],
    ];

    // Kumpulan lengkap semua pemenang non-grand-prize
    foreach ($group['winners'] as $w) {
        $semua_winner_lainnya[] = [
            'prize_name' => $group['prize_name'],
            'winner'     => $w,
        ];
    }
}

$kategori_lainnya_text = implodeDanIndonesia($daftar_kategori);


/* ---------------------------------------------------------------------
 * 7. Ambil Data Arsip Pemenang (Dinamis dari Database)
 * ------------------------------------------------------------------- */
$data_arsip = [];
try {
    $sql_arsip = "
        SELECT 
            prog.year, 
            COUNT(w.id) AS total_pemenang,
            (SELECT w2.photo FROM tbl_winners w2 
             JOIN tbl_periode per2 ON w2.id_periode = per2.id 
             WHERE per2.id_program = prog.id 
             LIMIT 1) AS sample_photo
        FROM tbl_program prog
        LEFT JOIN tbl_periode per ON prog.id = per.id_program
        LEFT JOIN tbl_winners w ON per.id = w.id_periode
        WHERE prog.year != :tahun_aktif
        GROUP BY prog.year
        ORDER BY prog.year DESC
        LIMIT 3
    ";
    $stmt_arsip = $pdo->prepare($sql_arsip);
    $stmt_arsip->execute([':tahun_aktif' => $tahun_aktif]);
    $data_arsip = $stmt_arsip->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $data_arsip = [];
}

/* ---------------------------------------------------------------------
 * 8. Ambil Data Galeri Pemenang Berdasarkan Kategori BLBMS (p_category_id = 5)
 * ------------------------------------------------------------------- */
$data_galeri_pemenang = [];
try {
    $sql_galeri = "SELECT photo_name, photo_caption FROM tbl_photo WHERE p_category_id = 5 ORDER BY photo_id ASC LIMIT 8";
    $stmt_galeri = $pdo->query($sql_galeri);
    $data_galeri_pemenang = $stmt_galeri->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $data_galeri_pemenang = [];
}

/* ---------------------------------------------------------------------
 * 9. Ambil Data Sponsor Berdasarkan Program Aktif
 * ------------------------------------------------------------------- */
$data_sponsor = [];
try {
    $sql_sponsor = "SELECT s.sponsor_name, s.img 
                    FROM tbl_sponsor s
                    JOIN tbl_program p ON s.id_program = p.id
                    WHERE p.year = :tahun
                    ORDER BY s.id ASC";
    $stmt_sponsor = $pdo->prepare($sql_sponsor);
    $stmt_sponsor->execute([':tahun' => $tahun_aktif]);
    $data_sponsor = $stmt_sponsor->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $data_sponsor = [];
}
?>

<style>
    /* ===================== Winner Hero Section ================== */
    .mk-winner-hero {
        padding: 52px 24px 64px;
        background: #fffdfb;
        position: relative;
        overflow: hidden;
        text-align: center;
    }
    .mk-winner-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        opacity: .55;
        background-image: radial-gradient( #d87b34 1px, transparent 1px);
        background-size: 16px 16px;
    }
    .mk-winner-hero-wrap {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 0 auto;
    }

    @keyframes mkFloatBounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }
    .mk-winner-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 20px;
        color: #fff;
        background: var(--mk-reward-orange, #f47716);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .45px;
        text-transform: uppercase;
        box-shadow: 0 4px 12px rgba(244, 119, 22, 0.25);
        animation: mkFloatBounce 2.5s ease-in-out infinite;
    }

    .mk-winner-title {
        margin: 18px 0 15px;
        color: var(--mk-reward-text, #34343b);
        font-size: 38px;
        font-weight: 800;
        line-height: 1.15;
    }
    .mk-winner-desc {
        max-width: 560px;
        margin: 0 auto;
        color: #5d6571;
        font-size: 15px;
        line-height: 1.75;
    }

    /* ===================== Filter Periode Bar ================== */
    .mk-filter-section {
        background: #ffffff;
        padding: 20px 24px;
        border-bottom: 1px solid #eaeaea;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        position: sticky;
        top: 0;
        z-index: 20;
    }
    .mk-filter-wrap {
        max-width: 1160px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }
    .mk-filter-group {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .mk-filter-label {
        font-size: 14px;
        font-weight: 700;
        color: var(--mk-reward-text, #34343b);
    }
    .mk-filter-buttons {
        display: flex;
        background: #f1f1f3;
        padding: 4px;
        border-radius: 10px;
        gap: 4px;
    }
    .mk-periode-btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #666666;
        background: transparent;
        border: none;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .mk-periode-btn:hover {
        color: var(--mk-reward-orange, #f47716);
    }
    .mk-periode-btn.active {
        background: var(--mk-reward-orange, #f47716);
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(244, 119, 22, 0.3);
    }
    .mk-pdf-download {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #b45012;
        text-decoration: none !important;
        transition: opacity 0.2s ease;
    }
    .mk-pdf-download:hover { opacity: 0.8; }

    /* ===================== Section Pemenang Utama Lainnya ================== */
    .bg-khusus {
    background-color: #fff;
    padding-top: 40px;
    }
    .mk-other-winners-section {
        max-width: 1160px;
        margin: 56px auto 0;
        padding: 0 24px 100px;
    }
    .mk-other-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 28px;
    }
    .mk-other-title {
        font-size: 20px;
        font-weight: 800;
        color: var(--mk-reward-text, #34343b);
        margin: 0 0 6px;
    }
    .mk-other-subtitle {
        font-size: 14px;
        color: #6b7280;
        margin: 0;
        max-width: 520px;
        line-height: 1.6;
    }
    .mk-other-seeall {
        padding: 10px 22px;
        border-radius: 999px;
        border: 1.5px solid var(--mk-reward-orange, #f47716);
        background: #fff;
        color: var(--mk-reward-orange, #f47716);
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
        transition: background .2s ease, color .2s ease;
    }
    .mk-other-seeall:hover {
        background: var(--mk-reward-orange, #f47716);
        color: #fff;
    }

    .mk-other-header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .mk-prize-nav {
        display: flex;
        gap: 8px;
    }
    /* Navigasi panah */
    .mk-prize-nav-btn { width: 38px; height: 38px; border-radius: 50%; border: 3px solid #f3791b; background: #fff8f2; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(244, 119, 22, 0.08); transition: background .2s ease, border-color .2s ease, box-shadow .2s ease, transform .2s ease; }
    .mk-prize-nav-btn:hover { background: var(--mk-reward-orange, #f47716); border-color: var(--mk-reward-orange, #f47716); box-shadow: 0 6px 16px rgba(244, 119, 22, 0.25); transform: translateY(-2px); }
    .mk-prize-nav-btn:hover svg { stroke: #fff; }
    .mk-prize-nav-btn svg { width: 20px; height: 20px; stroke: var(--mk-reward-orange, #f47716); stroke-width: 2.5; transition: stroke .2s ease; }
    .mk-prize-nav-btn:disabled { opacity: .4; cursor: not-allowed; box-shadow: none; }
    .mk-prize-nav-btn:disabled:hover { background: #fff8f2; border-color: #f0d6c2; transform: none; }
    .mk-prize-nav-btn:disabled:hover svg { stroke: var(--mk-reward-orange, #f47716); }


    .mk-prize-viewport {
        overflow: hidden;
    }
    .mk-prize-track {
        display: flex;
        gap: 24px;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        padding-bottom: 32px; /* Memberi ruang di bawah agar shadow tidak terpotong */
        padding-top: 12px;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .mk-prize-track::-webkit-scrollbar {
        display: none;
    }
    .mk-prize-card {
        flex: 0 0 260px;
        scroll-snap-align: start;
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .mk-prize-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(0,0,0,0.08);
    }
    .mk-prize-photo {
        position: relative;
        aspect-ratio: 4 / 3;
        background: #f3f3f3;
    }
    .mk-prize-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .mk-prize-tag {
        position: absolute;
        top: 12px;
        left: 12px;
        background: rgba(20,20,25,0.72);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 5px 10px;
        border-radius: 6px;
    }
    .mk-prize-body {
        padding: 16px 18px 18px;
    }
    .mk-prize-name {
        font-size: 15px;
        font-weight: 800;
        color: var(--mk-reward-text, #34343b);
        margin-bottom: 2px;
    }
    .mk-prize-address {
        font-size: 12.5px;
        font-weight: 700;
        color: #c1660f;
        margin-bottom: 10px;
    }
    .mk-prize-member {
        display: inline-block;
        font-size: 11px;
        font-weight: 700;
        color: #b45012;
        background: #fdf1e7;
        padding: 3px 9px;
        border-radius: 6px;
        margin-bottom: 10px;
    }
    .mk-prize-quote {
        font-size: 12.5px;
        font-style: italic;
        color: #6b7280;
        line-height: 1.6;
        border-left: 2px solid #f1d8c5;
        padding-left: 10px;
    }

    .mk-winners-empty {
        text-align: center;
        padding: 60px 20px;
        color: #8a8f98;
        font-size: 14px;
    }

    /* ===================== Grand Prize Slider ================== */
    .mk-gp-section {
        max-width: 1160px;
        margin: 48px auto 0;
        padding: 0 24px 40px;
    }
    .mk-gp-heading {
        font-size: 16px;
        font-weight: 800;
        letter-spacing: .5px;
        text-transform: uppercase;
        color: var(--mk-reward-orange, #f47716);
        margin-bottom: 16px;
    }
    .mk-gp-viewport {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        background: #fff;
        border: 1px solid #f1e5da;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    }
    .mk-gp-track {
        display: flex;
        transition: transform .45s cubic-bezier(.4,0,.2,1);
    }
    .mk-gp-slide {
        flex: 0 0 100%;
        max-width: 100%;
        display: grid;
        grid-template-columns: 540px 1fr;
        gap: 44px;
        align-items: center;
        padding: 40px;
        box-sizing: border-box;
    }

    /* Foto ala polaroid + ribbon hadiah */
    .mk-gp-photo-wrap {
        position: relative;
    }
    .mk-gp-photo-frame {
        border: 6px solid #fff;
        outline: 2px solid var(--mk-reward-orange, #f47716);
        outline-offset: -2px;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 12px 28px rgba(0,0,0,0.12);
        aspect-ratio: 4 / 3;
    }
    .mk-gp-photo-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .mk-gp-ribbon {
        position: absolute;
        right: -14px;
        bottom: -16px;
        background: var(--mk-reward-orange, #f47716);
        color: #fff;
        padding: 10px 18px;
        border-radius: 10px;
        box-shadow: 0 8px 18px rgba(244, 119, 22, 0.35);
        max-width: 80%;
    }
    .mk-gp-ribbon-label {
        display: block;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .5px;
        opacity: .9;
    }
    .mk-gp-ribbon-prize {
        display: block;
        font-size: 14px;
        font-weight: 800;
        text-transform: uppercase;
        line-height: 1.25;
    }

    /* Info sisi kanan */
    .mk-gp-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .4px;
        text-transform: uppercase;
        color: var(--mk-reward-orange, #f47716);
        margin-bottom: 12px;
    }
    .mk-gp-badge svg { flex-shrink: 0; }
    .mk-gp-name {
        font-size: 28px;
        font-weight: 800;
        color: var(--mk-reward-text, #34343b);
        margin: 0 0 20px;
    }
    .mk-gp-row {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f8f8f9;
        border-radius: 10px;
        padding: 12px 14px;
        margin-bottom: 12px;
    }
    .mk-gp-row-icon {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #fff;
        border: 1px solid #f1d8c5;
        color: var(--mk-reward-orange, #f47716);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .mk-gp-row-label {
        display: block;
        font-size: 11px;
        color: #8a8f98;
        font-weight: 700;
        margin-bottom: 2px;
    }
    .mk-gp-row-value {
        display: block;
        font-size: 14px;
        font-weight: 700;
        color: var(--mk-reward-text, #34343b);
    }
    .mk-gp-quote {
        margin: 18px 0 0;
        padding-left: 16px;
        border-left: 3px solid var(--mk-reward-orange, #f47716);
        font-size: 14px;
        font-style: italic;
        line-height: 1.7;
        color: #5d6571;
    }

    /* Navigasi slider */
    .mk-gp-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1px solid #eee;
        background: #fff;
        color: var(--mk-reward-text, #34343b);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        z-index: 5;
        transition: background .2s ease, color .2s ease;
    }
    .mk-gp-nav-btn:hover {
        background: var(--mk-reward-orange, #f47716);
        color: #fff;
        border-color: var(--mk-reward-orange, #f47716);
    }
    .mk-gp-nav-prev { left: 14px; }
    .mk-gp-nav-next { right: 14px; }

    .mk-gp-dots {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 18px;
    }
    .mk-gp-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #e2c9b6;
        border: none;
        cursor: pointer;
        padding: 0;
        transition: background .2s ease, width .2s ease;
    }
    .mk-gp-dot.active {
        background: var(--mk-reward-orange, #f47716);
        width: 22px;
        border-radius: 5px;
    }

    /* Responsive Breakpoints */
    @media (max-width: 768px) {
        .mk-winner-hero { padding: 40px 20px 50px; }
        .mk-winner-title { font-size: 28px; }
        .mk-filter-wrap { flex-direction: column; align-items: flex-start; }
        .mk-filter-buttons { width: 100%; display: grid; grid-template-columns: repeat(3, 1fr); text-align: center; }
        .mk-prize-card { flex-basis: 220px; }
        .mk-other-header { align-items: stretch; }
        .mk-other-header-actions { justify-content: space-between; }

        .mk-gp-slide {
            grid-template-columns: 1fr;
            padding: 24px;
            gap: 24px;
        }
        .mk-gp-photo-frame { max-width: 260px; margin: 0 auto; }
        .mk-gp-ribbon { right: 50%; transform: translateX(50%); bottom: -18px; text-align: center; }
        .mk-gp-nav-btn { width: 34px; height: 34px; }
    }

    /* ===================== Section Arsip Pemenang ================== */
    .mk-archive-section {
        max-width: 1160px;
        margin: 0 auto;
        padding: 80px 24px 80px;
    }
    .mk-archive-header {
        margin-bottom: 24px;
    }
    .mk-archive-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--mk-reward-text, #34343b);
        margin: 0;
    }
    .mk-archive-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
    .mk-archive-card {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        aspect-ratio: 1 / 1; /* Membuat kotak proporsional persegi */
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        text-decoration: none !important;
        box-shadow: 0 4px 14px rgba(0,0,0,0.04);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .mk-archive-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(0,0,0,0.1);
    }
    
    /* Gambar Background Card */
    .mk-archive-img {
        position: absolute;
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .mk-archive-card:hover .mk-archive-img {
        transform: scale(1.08); /* Efek zoom tipis saat di-hover */
    }
    
    /* Gradien Gelap di Bawah Teks */
    .mk-archive-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.2) 50%, rgba(0,0,0,0) 100%);
        z-index: 1;
    }
    
    /* Info Teks (Tahun & Jumlah) */
    .mk-archive-info {
        position: relative;
        z-index: 2;
        padding: 20px;
        color: #ffffff;
    }
    .mk-archive-year {
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 4px;
        line-height: 1;
    }
    .mk-archive-count {
        font-size: 13px;
        font-weight: 500;
        color: #e5e7eb;
    }

    /* Action Card Khusus: Lihat Arsip Lainnya */
    .mk-archive-more {
        background: #f4f4f5;
        border: 2px dashed #d4d4d8;
        box-shadow: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #5d6571;
        text-align: center;
        padding: 20px;
    }
    .mk-archive-more:hover {
        background: #fff8f2;
        border-color: var(--mk-reward-orange, #f47716);
        color: var(--mk-reward-orange, #f47716);
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(244, 119, 22, 0.12);
    }
    .mk-archive-more svg {
        width: 32px;
        height: 32px;
        margin-bottom: 14px;
        stroke: currentColor;
    }
    .mk-archive-more span {
        font-size: 14px;
        font-weight: 600;
    }

    /* Responsive Breakpoints */
    @media (max-width: 900px) {
        .mk-archive-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 480px) {
        .mk-archive-grid { grid-template-columns: 1fr; }
    }

    /* ===================== Section Galeri Serah Terima Hadiah ================== */
    .mk-winner-gallery-section {
        background-color: #18181b; 
        padding: 70px 24px 90px;
        color: #ffffff;
        margin-top: 60px;
    }
    .mk-winner-gallery-container {
        max-width: 1160px;
        margin: 0 auto;
    }
    .mk-winner-gallery-header {
        text-align: center;
        margin-bottom: 45px;
    }
    .mk-winner-gallery-title {
        font-size: 24px;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 10px;
    }
    .mk-winner-gallery-subtitle {
        font-size: 14.5px;
        color: #a1a1aa;
        max-width: 540px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Layout Grid Asimetris */
    .mk-winner-gallery-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-auto-rows: 220px;
    gap: 16px;
    grid-auto-flow: dense;
}
    .mk-winner-gallery-item {
        border-radius: 14px;
        overflow: hidden;
        position: relative;
        background: #27272a;
        box-shadow: 0 4px 16px rgba(0,0,0,0.2);
        cursor: pointer;
    }
    .mk-winner-gallery-item:nth-child(2) {
        grid-column: span 2;
        grid-row: span 2;
    }
    .mk-winner-gallery-item:nth-child(5) {
        grid-column: span 2;
    }
    
    .mk-winner-gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }
    .mk-winner-gallery-item:hover img {
        transform: scale(1.06);
    }
    .mk-winner-gallery-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 60%);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: flex-end;
        padding: 16px;
    }
    .mk-winner-gallery-item:hover .mk-winner-gallery-overlay {
        opacity: 1;
    }
    .mk-winner-gallery-caption {
        font-size: 13px;
        font-weight: 600;
        color: #fff;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .mk-winner-gallery-grid {
            grid-template-columns: repeat(2, 1fr);
            grid-auto-rows: 200px;
        }
        .mk-winner-gallery-item:nth-child(2),
        .mk-winner-gallery-item:nth-child(5) {
            grid-column: span 2;
            grid-row: span 1;
        }
    }
    @media (max-width: 480px) {
        .mk-winner-gallery-grid {
            grid-template-columns: 1fr;
        }
        .mk-winner-gallery-item:nth-child(2),
        .mk-winner-gallery-item:nth-child(5) {
            grid-column: span 1;
        }
    }

    /* ===================== Modal Preview Foto Galeri ================== */
    .mk-photo-modal {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 999999;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.25s ease;
        padding: 24px;
        box-sizing: border-box;
    }
    .mk-photo-modal.active {
        opacity: 1;
        visibility: visible;
    }
    .mk-photo-modal-inner {
        max-width: 900px;
        max-height: 90vh;
        width: 100%;
        text-align: center;
    }
    .mk-photo-modal-inner img {
        width: 100%;
        max-height: 80vh;
        object-fit: contain;
        border-radius: 10px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    }
    .mk-photo-modal-caption {
        color: #fff;
        font-size: 14px;
        margin-top: 14px;
        opacity: 0.85;
    }
    .mk-photo-modal-close {
        position: fixed;
        top: 24px;
        right: 24px;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: var(--mk-reward-orange, #f47716);
        border: none;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(0,0,0,0.3);
        transition: transform 0.2s ease, background 0.2s ease;
        z-index: 1000000;
    }
    .mk-photo-modal-close:hover {
        background: #d9600f;
        transform: scale(1.08);
    }

    @media (max-width: 600px) {
        .mk-photo-modal-close { top: 16px; right: 16px; width: 38px; height: 38px; }
    }

/* ===================== Notifikasi PDF Error ================== */
.mk-pdf-notif {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: #fff3f0;
    border: 1px solid #ffcdc0;
    color: #b91c1c;
    padding: 12px 18px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13.5px;
    font-weight: 600;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    z-index: 1000001; /* di atas modal foto juga */
    max-width: 90%;
    animation: mkNotifSlideDown 0.3s ease;
}
.mk-pdf-notif svg {
    flex-shrink: 0;
    color: #dc2626;
}
.mk-pdf-notif button {
    background: none;
    border: none;
    color: #b91c1c;
    font-size: 18px;
    line-height: 1;
    cursor: pointer;
    padding: 0 0 0 6px;
    opacity: 0.6;
}
.mk-pdf-notif button:hover {
    opacity: 1;
}
@keyframes mkNotifSlideDown {
    from { opacity: 0; transform: translate(-50%, -12px); }
    to { opacity: 1; transform: translate(-50%, 0); }
}

/* ===================== Section Sponsor / Partners ================== */
.mk-sponsor-section {
    background-color: #fdfbf7; /* Latar belakang cream soft sesuai gambar */
    padding: 60px 24px;
    text-align: center;
}
.mk-sponsor-container {
    max-width: 1160px;
    margin: 0 auto;
}
.mk-sponsor-title {
    font-size: 28px;
    font-weight: 800;
    color: #f47716; /* Warna oranye */
    margin: 0 0 10px;
}
.mk-sponsor-line {
    width: 40px;
    height: 3px;
    background-color: #f47716;
    margin: 0 auto 16px;
    border-radius: 2px;
}
.mk-sponsor-subtitle {
    font-size: 14px;
    color: #6c757d;
    margin: 0 0 40px;
}
.mk-sponsor-grid {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}
.mk-sponsor-card {
    background: #ffffff;
    border-radius: 10px;
    width: 180px;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 15px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-decoration: none;
    box-sizing: border-box;
}
.mk-sponsor-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
}
.mk-sponsor-card img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    filter: grayscale(20%);
    transition: filter 0.3s ease;
}
.mk-sponsor-card:hover img {
    filter: grayscale(0%);
}

@media (max-width: 600px) {
    .mk-sponsor-card {
        width: 140px;
        height: 80px;
        padding: 10px;
    }
}
</style>

<!-- ===================== Section Hero Pemenang ================== -->
<section class="mk-winner-hero">
    <div class="mk-winner-hero-wrap">
        <div class="mk-winner-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Selamat Kepada Para Pemenang
        </div>
        
        <!-- Judul Dinamis sesuai permintaan -->
        <h1 class="mk-winner-title">
            Daftar Pemenang <?php echo htmlspecialchars($nama_program_aktif); ?> Tahun <?php echo htmlspecialchars($tahun_aktif); ?> <?php echo htmlspecialchars($nama_periode_aktif); ?>
        </h1>
        
        <p class="mk-winner-desc">
            Apresiasi setulus hati bagi pelanggan setia Manna Kampus. Temukan nama Anda di antara pemenang beruntung pada periode ini.
        </p>
    </div>
</section>

<!-- ===================== Bar Filter Periode & Tombol Unduh PDF ================== -->
<div class="mk-filter-section">
    <div class="mk-filter-wrap">

        <!-- Tombol Periode dibuat otomatis dari tabel tbl_periode -->
        <div class="mk-filter-group">
            <span class="mk-filter-label">Periode:</span>
            <div class="mk-filter-buttons">
                <?php foreach ($daftar_periode as $p): ?>
                    <a href="?periode=<?php echo (int) $p['id']; ?>"
                       class="mk-periode-btn <?php echo ($periode_aktif == $p['id']) ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars($p['periode_name']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tombol akan muncul JIKA tahun aktif yang sedang dibuka < tahun sekarang (2026) -->
<?php if ($tahun_aktif < date('Y')): ?>
    <a href="winners.php" class="mk-reset-archive-btn" style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:700; color:#f47716; text-decoration:none; background:#fff8f2; padding:6px 12px; border-radius:8px; border:1px solid #f1d8c5;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
        Lihat Pemenang Terbaru (<?php echo date('Y'); ?>)
    </a>
<?php endif; ?>

        <!-- Tombol Unduh PDF Lengkap -->
   <a href="generate-pdf.php?periode=<?php echo (int) $periode_aktif; ?>" ...>            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            Unduh PDF Lengkap
        </a>

    </div>
</div>

<!-- ===================== Section Grand Prize Winner (Slider) ================== -->
<?php if (!empty($grand_prize_winners)): ?>
<section class="mk-gp-section">
    <div class="mk-gp-heading">🏆 Pemenang Grand Prize</div>

    <div class="mk-gp-viewport">

        <?php if (count($grand_prize_winners) > 1): ?>
            <button type="button" class="mk-gp-nav-btn mk-gp-nav-prev" id="gpPrev" aria-label="Sebelumnya">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <button type="button" class="mk-gp-nav-btn mk-gp-nav-next" id="gpNext" aria-label="Selanjutnya">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
        <?php endif; ?>

        <div class="mk-gp-track" id="gpTrack">
            <?php foreach ($grand_prize_winners as $gw): ?>
                <div class="mk-gp-slide">

                    <div class="mk-gp-photo-wrap">
                        <div class="mk-gp-photo-frame">
                            <img src="<?php echo WINNER_PHOTO_PATH . htmlspecialchars($gw['winner_photo']); ?>"
                                 alt="<?php echo htmlspecialchars($gw['winners_name']); ?>"
                                 onerror="this.src='assets/img/no-avatar.png'">
                        </div>
                        <div class="mk-gp-ribbon">
                            <span class="mk-gp-ribbon-label">HADIAH UTAMA</span>
                            <span class="mk-gp-ribbon-prize"><?php echo htmlspecialchars($gw['prize_name']); ?></span>
                        </div>
                    </div>

                    <div class="mk-gp-info">
                        <div class="mk-gp-badge">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            Grand Prize Winner <?php echo htmlspecialchars($tahun_periode_aktif); ?>
                        </div>

                        <h2 class="mk-gp-name"><?php echo htmlspecialchars($gw['winners_name']); ?></h2>

                        <div class="mk-gp-row">
                            <div class="mk-gp-row-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            </div>
                            <div>
                                <span class="mk-gp-row-label">Asal Kota</span>
                                <span class="mk-gp-row-value"><?php echo htmlspecialchars($gw['address']); ?></span>
                            </div>
                        </div>

                        <?php if (!empty($gw['member_number'])): ?>
                        <div class="mk-gp-row">
                            <div class="mk-gp-row-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                            </div>
                            <div>
                                <span class="mk-gp-row-label">Nomor Member</span>
                                <span class="mk-gp-row-value"><?php echo htmlspecialchars(maskMemberNumber($gw['member_number'])); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($gw['testimonial'])): ?>
                            <blockquote class="mk-gp-quote">"<?php echo htmlspecialchars($gw['testimonial']); ?>"</blockquote>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <?php if (count($grand_prize_winners) > 1): ?>
        <div class="mk-gp-dots" id="gpDots">
            <?php foreach ($grand_prize_winners as $idx => $gw): ?>
                <button type="button" class="mk-gp-dot <?php echo $idx === 0 ? 'active' : ''; ?>" data-index="<?php echo $idx; ?>" aria-label="Slide <?php echo $idx + 1; ?>"></button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<script>
(function () {
    var track = document.getElementById('gpTrack');
    if (!track) return;

    var slides = track.querySelectorAll('.mk-gp-slide');
    var dots   = document.querySelectorAll('.mk-gp-dot');
    var prevBtn = document.getElementById('gpPrev');
    var nextBtn = document.getElementById('gpNext');
    var current = 0;
    var total = slides.length;

    function goTo(index) {
        current = (index + total) % total;
        track.style.transform = 'translateX(-' + (current * 100) + '%)';
        dots.forEach(function (dot, i) {
            dot.classList.toggle('active', i === current);
        });
    }

    if (prevBtn) prevBtn.addEventListener('click', function () { goTo(current - 1); });
    if (nextBtn) nextBtn.addEventListener('click', function () { goTo(current + 1); });
    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            goTo(parseInt(dot.getAttribute('data-index'), 10));
        });
    });

    // Swipe untuk perangkat sentuh
    var startX = null;
    track.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
    track.addEventListener('touchend', function (e) {
        if (startX === null) return;
        var diff = e.changedTouches[0].clientX - startX;
        if (Math.abs(diff) > 40) {
            diff < 0 ? goTo(current + 1) : goTo(current - 1);
        }
        startX = null;
    });
})();
</script>
<?php endif; ?>

<!-- ===================== Section Pemenang Utama Lainnya (Non Grand Prize) ================== -->
<div class="bg-khusus">
<section class="mk-other-winners-section">

    <?php if (empty($reward_groups_biasa)): ?>

        <?php if (empty($grand_prize_winners)): ?>
            <div class="mk-winners-empty">
                Belum ada data pemenang untuk periode ini.
            </div>
        <?php endif; ?>

    <?php else: ?>

        <div class="mk-other-header">
            <div>
                <h3 class="mk-other-title">Pemenang Utama Lainnya</h3>
                <p class="mk-other-subtitle">
                    Berikut daftar pemenang kategori <?php echo htmlspecialchars($kategori_lainnya_text); ?>.
                </p>
            </div>

            <div class="mk-other-header-actions">
                <?php if (count($preview_cards) > 1): ?>
                    <div class="mk-prize-nav" id="mkPreviewNav">
                        <button type="button" class="mk-prize-nav-btn" id="mkPreviewPrev" aria-label="Sebelumnya">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button type="button" class="mk-prize-nav-btn" id="mkPreviewNext" aria-label="Selanjutnya">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                <?php endif; ?> 
            </div>
        </div>

        <!-- Kartu wakil per kategori hadiah (tampil default) — bisa digeser -->
        <div class="mk-prize-viewport">
            <div class="mk-prize-track" id="mkPreviewGrid">
                <?php foreach ($preview_cards as $card): ?>
                    <?php echo render_winner_card($card['prize_name'], $card['winner']); ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Seluruh pemenang non-grand-prize (tersembunyi, muncul saat "Lihat Semua Nama" diklik) — bisa digeser -->
        <div class="mk-prize-viewport" id="mkFullWrap" style="display:none;">
            <?php if (count($semua_winner_lainnya) > 1): ?>
                <div class="mk-prize-nav" id="mkFullNav" style="justify-content:flex-end; margin-bottom:14px;">
                    <button type="button" class="mk-prize-nav-btn" id="mkFullPrev" aria-label="Sebelumnya">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    </button>
                    <button type="button" class="mk-prize-nav-btn" id="mkFullNext" aria-label="Selanjutnya">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </button>
                </div>
            <?php endif; ?>

            <div class="mk-prize-track" id="mkFullGrid">
                <?php foreach ($semua_winner_lainnya as $item): ?>
                    <?php echo render_winner_card($item['prize_name'], $item['winner']); ?>
                <?php endforeach; ?>
            </div>
        </div>

        <script>
        (function () {
            // Slider generik: geser track sejauh ~1 kartu setiap klik panah,
            // tombol otomatis nonaktif di ujung kiri/kanan.
            function setupSlider(trackId, prevId, nextId) {
                var track = document.getElementById(trackId);
                var prev  = document.getElementById(prevId);
                var next  = document.getElementById(nextId);
                if (!track || !prev || !next) return;

                function scrollAmount() {
                    var card = track.querySelector('.mk-prize-card');
                    var cardWidth = card ? card.getBoundingClientRect().width : 260;
                    var gap = 24;
                    return (cardWidth + gap) * 2; // geser sekitar 2 kartu tiap klik
                }

                function updateButtons() {
                    var maxScroll = track.scrollWidth - track.clientWidth - 2;
                    prev.disabled = track.scrollLeft <= 0;
                    next.disabled = track.scrollLeft >= maxScroll;
                }

                prev.addEventListener('click', function () {
                    track.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
                });
                next.addEventListener('click', function () {
                    track.scrollBy({ left: scrollAmount(), behavior: 'smooth' });
                });
                track.addEventListener('scroll', updateButtons);
                window.addEventListener('resize', updateButtons);
                updateButtons();
            }

            setupSlider('mkPreviewGrid', 'mkPreviewPrev', 'mkPreviewNext');
            setupSlider('mkFullGrid', 'mkFullPrev', 'mkFullNext');

            // Toggle "Lihat Semua Nama"
            var btn         = document.getElementById('mkSeeAllBtn');
            var previewWrap = document.querySelector('#mkPreviewGrid').closest('.mk-prize-viewport');
            var previewNav  = document.getElementById('mkPreviewNav');
            var fullWrap    = document.getElementById('mkFullWrap');
            if (!btn) return;

            var expanded = false;
            btn.addEventListener('click', function () {
                expanded = !expanded;
                previewWrap.style.display = expanded ? 'none' : 'block';
                if (previewNav) previewNav.style.display = expanded ? 'none' : 'flex';
                fullWrap.style.display    = expanded ? 'block' : 'none';
                btn.textContent           = expanded ? 'Tampilkan Lebih Sedikit' : 'Lihat Semua Nama';
            });
        })();
        </script>

    <?php endif; ?>
</section>
</div>

<!-- ===================== Section Arsip Pemenang ================== -->
<section class="mk-archive-section">
    <div class="mk-archive-header">
        <h3 class="mk-archive-title">Arsip Pemenang</h3>
    </div>
    
    <div class="mk-archive-grid">
        
        <?php if (!empty($data_arsip)): ?>
            <?php foreach($data_arsip as $arsip): ?>
                <?php 
                    $tahun = $arsip['year'];
                    // Format angka ribuan (misal: 8500 jadi 8.500)
                    $jumlah_pemenang = number_format($arsip['total_pemenang'], 0, ',', '.');
                ?>
                <!-- Ubah href-nya menjadi seperti ini -->
                <a href="winners.php?tahun=<?php echo htmlspecialchars($tahun); ?>" class="mk-archive-card">
                    <img src="<?php echo WINNER_PHOTO_PATH . htmlspecialchars($arsip['sample_photo']); ?>" alt="Arsip Tahun <?php echo htmlspecialchars($tahun); ?>" class="mk-archive-img" onerror="this.src='https://placehold.co/400x400/eee/999?text=Arsip+<?php echo htmlspecialchars($tahun); ?>'">
                    <div class="mk-archive-overlay"></div>
                    <div class="mk-archive-info">
                        <div class="mk-archive-year"><?php echo htmlspecialchars($tahun); ?></div>
                        <div class="mk-archive-count"><?php echo $jumlah_pemenang; ?> Pemenang</div>
                    </div>
                </a>
                <?php endforeach; ?>
        <?php else: ?>
            <p style="color: #888;">Belum ada data arsip pemenang.</p>
        <?php endif; ?>

        <!-- Tombol Lihat Arsip Lebih Lama (Static/Tetap Ada) -->
        <a href="archive-all.php" class="mk-archive-card mk-archive-more">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                <path d="M3 3v5h5"></path>
                <path d="M12 7v5l4 2"></path>
            </svg>
            <span>Lihat Arsip Lebih Lama</span>
        </a>

    </div>
</section>

<!-- ===================== Section Gallery Pemenang ================== -->
<section class="mk-winner-gallery-section">
    <div class="mk-winner-gallery-container">
        <div class="mk-winner-gallery-header">
            <h3 class="mk-winner-gallery-title">Galeri Serah Terima Hadiah</h3>
            <p class="mk-winner-gallery-subtitle">Momen kebahagiaan saat para pemenang menerima apresiasi langsung di gerai Manna Kampus pilihan mereka.</p>
        </div>

        <div class="mk-winner-gallery-grid">
            <?php if (!empty($data_galeri_pemenang)): ?>
                <?php foreach ($data_galeri_pemenang as $galeri): ?>
                    <div class="mk-winner-gallery-item" onclick="openImageModal('<?php echo WINNER_PHOTO_PATH . htmlspecialchars($galeri['photo_name']); ?>', '<?php echo htmlspecialchars(addslashes($galeri['photo_caption'])); ?>')">
                        <img src="<?php echo WINNER_PHOTO_PATH . htmlspecialchars($galeri['photo_name']); ?>" 
                             alt="<?php echo htmlspecialchars($galeri['photo_caption']); ?>" 
                             onerror="this.src='https://placehold.co/600x400/333/666?text=Dokumentasi+Manna+Kampus'">
                        <?php if (!empty($galeri['photo_caption'])): ?>
                            <div class="mk-winner-gallery-overlay">
                                <span class="mk-winner-gallery-caption"><?php echo htmlspecialchars($galeri['photo_caption']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="mk-winners-empty" style="grid-column: span 4; color: #a1a1aa; text-align:center;">
                    Belum ada dokumentasi galeri untuk program ini.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ===================== Modal Preview Foto Galeri ==================
     PENTING: modal ini SENGAJA ditaruh di sini, di luar section manapun
     (langsung sebelum footer), supaya z-index-nya tidak terjebak di
     dalam stacking context section/header manapun. ================== -->
<div class="mk-photo-modal" id="mkPhotoModal">
    <button type="button" class="mk-photo-modal-close" id="mkPhotoModalClose" aria-label="Tutup">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
    <div class="mk-photo-modal-inner">
        <img src="" alt="" id="mkPhotoModalImg">
        <p class="mk-photo-modal-caption" id="mkPhotoModalCaption"></p>
    </div>
</div>

<!-- ===================== Section Sponsor / Our Partners ================== -->
<section class="mk-sponsor-section">
    <div class="mk-sponsor-container">
        <h3 class="mk-sponsor-title">Sponsor Kami</h3>
        <div class="mk-sponsor-line"></div>
        <p class="mk-sponsor-subtitle">Semua sponsor perusahaan kami tercantum di bawah ini.</p>

        <div class="mk-sponsor-grid">
            <?php if (!empty($data_sponsor)): ?>
                <?php foreach ($data_sponsor as $sponsor): ?>
                    <div class="mk-sponsor-card" title="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>">
                        <img src="assets/uploads/<?php echo htmlspecialchars($sponsor['img']); ?>" 
                             alt="<?php echo htmlspecialchars($sponsor['sponsor_name']); ?>"
                             onerror="this.src='https://placehold.co/150x60/fff/ccc?text=<?php echo urlencode($sponsor['sponsor_name']); ?>'">
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="color: #888; font-size: 14px;">Belum ada sponsor untuk periode ini.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
function openImageModal(src, caption) {
    var modal = document.getElementById('mkPhotoModal');
    var img = document.getElementById('mkPhotoModalImg');
    var cap = document.getElementById('mkPhotoModalCaption');

    img.src = src;
    cap.textContent = caption || '';
    modal.classList.add('active');
    document.body.style.overflow = 'hidden'; // cegah scroll di belakang modal
}

function closeImageModal() {
    var modal = document.getElementById('mkPhotoModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

document.getElementById('mkPhotoModalClose').addEventListener('click', closeImageModal);

// Klik area gelap di luar foto juga menutup modal
document.getElementById('mkPhotoModal').addEventListener('click', function (e) {
    if (e.target === this) closeImageModal();
});

// Tombol ESC menutup modal
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeImageModal();
});
</script>

<?php require_once('footer.php'); ?>