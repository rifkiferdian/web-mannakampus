<?php require_once('header.php'); ?>

<?php
// Ambil id periode dari URL, default ke periode pertama jika tidak ada
$periodeId = isset($_GET['periode']) ? (int)$_GET['periode'] : 0;

if ($periodeId === 0) {
    $stmt = $pdo->query("SELECT id FROM tbl_periode ORDER BY id ASC LIMIT 1");
    $first = $stmt->fetch(PDO::FETCH_ASSOC);
    $periodeId = $first ? $first['id'] : 0;
}

// Data periode aktif + nama program
$stmt = $pdo->prepare("
    SELECT tp.id, tp.periode_name, tp.draw_date, tpg.program_name, tpg.year
    FROM tbl_periode tp
    JOIN tbl_program tpg ON tpg.id = tp.id_program
    WHERE tp.id = ?
    LIMIT 1
");
$stmt->execute([$periodeId]);
$periode = $stmt->fetch(PDO::FETCH_ASSOC);

// [REVISI] Ambil SEMUA daftar periode untuk 3 tombol navigasi
$stmt = $pdo->query("SELECT id, periode_name FROM tbl_periode ORDER BY id ASC LIMIT 3");
$allPeriodes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Grand prize untuk periode aktif
$stmt = $pdo->prepare("SELECT prize_name, img, description FROM tbl_reward WHERE id_periode = ? AND grand_prize = 1 LIMIT 1");
$stmt->execute([$periodeId]);
$grandPrize = $stmt->fetch(PDO::FETCH_ASSOC);

// Semua hadiah untuk periode aktif, KECUALI grand prize (sudah tampil di hero)
$stmt = $pdo->prepare("SELECT * FROM tbl_reward WHERE id_periode = ? AND grand_prize = 0 ORDER BY id ASC");
$stmt->execute([$periodeId]);
$rewardList = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Path folder gambar reward, sesuaikan dengan lokasi upload sebenarnya
$rewardImgPath = BASE_URL . 'assets/uploads/';
$defaultRewardImg = BASE_URL . 'assets/images/reward-placeholder.png';
?>

<?php
$bulanIndonesia = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
];

$drawDate = '';

if (!empty($periode['draw_date'])) {
    $timestamp = strtotime($periode['draw_date']);

    $drawDate =
        date('d', $timestamp) . ' ' .
        $bulanIndonesia[(int)date('m', $timestamp)] . ' ' .
        date('Y', $timestamp);
}
?>

<style>
    /* (CSS SAMA SEPERTI SEBELUMNYA, TIDAK ADA PERUBAHAN) */
    .mk-reward-hero{
        --mk-reward-orange: #f47716;
        --mk-reward-text: #34343b;
        padding:52px 24px 64px;
        background:#fffdfb;
        position:relative;
        overflow:hidden;
    }
    .mk-reward-hero:before{
        content:"";
        position:absolute;
        inset:0;
        pointer-events:none;
        opacity:.55;
        background-image:radial-gradient( #d46e20 1px, transparent 1px);
        background-size:16px 16px;
    }
    .mk-reward-hero-wrap{
        position:relative;
        z-index:1;
        max-width:1160px;
        margin:0 auto;
        display:grid;
        grid-template-columns:minmax(0, .95fr) minmax(360px, 1.05fr);
        align-items:center;
        gap:52px;
    }
    .mk-reward-badge{
        display:inline-block;
        padding:6px 12px;
        border-radius:20px;
        color:#b45012;
        background:#ffe7d6;
        font-size:11px;
        font-weight:700;
        letter-spacing:.45px;
        text-transform:uppercase;
    }
    .mk-reward-title{
        margin:18px 0 15px;
        color:var(--mk-reward-text);
        font-size:38px;
        font-weight:800;
        line-height:1.15;
    }
    .mk-reward-title span{ color:var(--mk-reward-orange); }
    .mk-reward-desc{
        max-width:505px;
        margin:0;
        color:#5d6571;
        font-size:15px;
        line-height:1.75;
    }
    .mk-reward-actions{
        display:flex;
        flex-wrap:wrap;
        gap:16px;
        margin-top:27px;
    }
    .mk-reward-button{
        min-width:160px;
        padding:14px 20px;
        border:1.5px solid var(--mk-reward-orange);
        border-radius:7px;
        box-sizing:border-box;
        text-align:center;
        font-size:13px;
        font-weight:700;
        text-decoration:none !important;
        transition:transform .2s ease, box-shadow .2s ease, background .2s ease;
    }
    .mk-reward-button:hover{ transform:translateY(-2px); box-shadow:0 8px 18px rgba(244,119,22,.18); }
    .mk-reward-button-primary{ color:#fff !important; background:var(--mk-reward-orange); }
    .mk-reward-button-outline{ color:#be570f !important; background:rgba(255,255,255,.75); }
    .mk-reward-button-outline:hover{ background:#fff1e5; }
    .mk-reward-visual{ position:relative; }
    .mk-reward-image{
        display:block;
        width:100%;
        border-radius:9px;
        aspect-ratio:16/9;
        object-fit:cover;
        box-shadow:0 5px 14px rgba(34,28,22,.25);
    }
    .mk-reward-prize{
        position:absolute;
        right:-18px;
        bottom:-14px;
        width:112px;
        min-height:82px;
        padding:17px 12px;
        border-radius:12px;
        box-sizing:border-box;
        background:var(--mk-reward-orange);
        color:#fff;
        font-size:12px;
        font-weight:800;
        line-height:1.45;
        text-align:center;
        text-transform:uppercase;
        box-shadow:0 8px 18px rgba(244,119,22,.28);
    }
    @media (max-width:800px){
        .mk-reward-hero{ padding:40px 20px 55px; }
        .mk-reward-hero-wrap{ grid-template-columns:1fr; gap:34px; }
        .mk-reward-content{ text-align:center; }
        .mk-reward-desc{ margin-left:auto; margin-right:auto; }
        .mk-reward-actions{ justify-content:center; }
        .mk-reward-visual{ max-width:620px; width:calc(100% - 14px); margin:0 auto; }
    }
    @media (max-width:480px){
        .mk-reward-title{ font-size:31px; }
        .mk-reward-button{ width:100%; }
        .mk-reward-prize{ right:-10px; bottom:-12px; width:99px; min-height:74px; font-size:11px; }
    }

    .mk-draw-date { display: inline-flex; align-items: center; gap: 12px; margin-top: 22px; padding: 11px 16px; background: #fff; border: 1px solid #f5c9a8; border-radius: 8px; box-shadow: 0 3px 10px rgba(244,119,22,.08); }
.mk-draw-date-icon { width: 36px; height: 36px; border-radius: 7px; background: #fff1e5; display: flex; align-items: center; justify-content: center; color: #f47716; flex-shrink: 0; }
.mk-draw-date-icon svg { width: 20px; height: 20px; stroke: currentColor; }
.mk-draw-date-info { display: flex; flex-direction: column; gap: 2px; }
.mk-draw-date-label { font-size: 11px; color: #777; font-weight: 600; line-height: 1.2; }
.mk-draw-date-value { font-size: 15px; color: #f47716; font-weight: 800; line-height: 1.3; }

@media (max-width: 480px) { .mk-draw-date { width: 100%; box-sizing: border-box; justify-content: flex-start; } .mk-draw-date-value { font-size: 14px; } }

    /* ===================== Prize List Section (Carousel) ================== */
    .mk-prize-section { padding: 60px 24px 80px; background: #fcfcfc; }
    .mk-prize-container { max-width: 1160px; margin: 0 auto; }
    .mk-prize-header { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 48px; flex-wrap: wrap; gap: 16px; }
    .mk-prize-header-text { text-align: left; }
    .mk-prize-title { font-size: 32px; font-weight: 800; color: var(--mk-reward-text, #34343b); margin: 0 0 12px; }
    .mk-prize-title-line { width: 48px; height: 4px; background: var(--mk-reward-orange, #f47716); border-radius: 2px; }

    /* Navigasi panah */
    .mk-prize-nav-btn { width: 38px; height: 38px; border-radius: 50%; border: 3px solid #f3791b; background: #fff8f2; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 8px rgba(244, 119, 22, 0.08); transition: background .2s ease, border-color .2s ease, box-shadow .2s ease, transform .2s ease; }
    .mk-prize-nav-btn:hover { background: var(--mk-reward-orange, #f47716); border-color: var(--mk-reward-orange, #f47716); box-shadow: 0 6px 16px rgba(244, 119, 22, 0.25); transform: translateY(-2px); }
    .mk-prize-nav-btn:hover svg { stroke: #fff; }
    .mk-prize-nav-btn svg { width: 20px; height: 20px; stroke: var(--mk-reward-orange, #f47716); stroke-width: 2.5; transition: stroke .2s ease; }
    .mk-prize-nav-btn:disabled { opacity: .4; cursor: not-allowed; box-shadow: none; }
    .mk-prize-nav-btn:disabled:hover { background: #fff8f2; border-color: #f0d6c2; transform: none; }
    .mk-prize-nav-btn:disabled:hover svg { stroke: var(--mk-reward-orange, #f47716); }

    /* Viewport carousel */
    .mk-prize-viewport { overflow: hidden; width: 100%; }
    .mk-prize-track { display: flex; gap: 24px; transition: transform .4s ease; }
    .mk-prize-card { flex: 0 0 calc((100% - 3 * 24px) / 4); background: #ffffff; border-radius: 12px; padding: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); border: 1px solid #f0f0f0; display: flex; flex-direction: column; justify-content: space-between; box-sizing: border-box; }
    .mk-prize-image-wrap { width: 100%; aspect-ratio: 1 / 1; border-radius: 8px; overflow: hidden; margin-bottom: 20px; background: #f8f8f8; }
    .mk-prize-image-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .mk-prize-content-body { flex-grow: 1; }
    .mk-prize-category { font-size: 12px; font-weight: 700; color: #f0824f; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
    .mk-prize-name { font-size: 20px; font-weight: 800; color: var(--mk-reward-text, #34343b); margin: 0 0 6px; line-height: 1.25; }
    .mk-prize-sub { font-size: 13px; color: #666666; margin: 0 0 20px; line-height: 1.4; }
    .mk-prize-footer { padding-top: 14px; border-top: 1px dashed #eaeaea; }
    .mk-prize-pill { display: inline-block; padding: 4px 12px; border-radius: 14px; background: #ff9456; color: #ffffff; font-size: 12.5px; font-weight: 700; }
    .mk-prize-pill-highlight { background: #ffe7d6; color: #b45012; }

    @media (max-width: 1024px) { .mk-prize-card { flex: 0 0 calc((100% - 1 * 24px) / 2); } }
    @media (max-width: 576px) { .mk-prize-card { flex: 0 0 100%; } .mk-prize-title { font-size: 26px; } .mk-prize-header { justify-content: center; text-align: center; } .mk-prize-header-text { text-align: center; width: 100%; } }

     /* ===================== Section Cara Ikutan ================== */
    .mk-steps-section { padding: 60px 24px 80px; background: #fff8f2; }
    .mk-steps-container { max-width: 1160px; margin: 0 auto; }
    .mk-steps-header { text-align: center; margin-bottom: 40px; }
    .mk-steps-title { font-size: 30px; font-weight: 800; color: var(--mk-reward-text, #34343b); margin: 0 0 10px; }
    .mk-steps-desc { font-size: 15px; color: #5d6571; margin: 0; }
    .mk-steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
    .mk-steps-card { background: #ffffff; border-radius: 12px; padding: 32px 24px; text-align: center; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04); }
    .mk-steps-icon-wrap { width: 64px; height: 64px; margin: 0 auto 20px; border-radius: 14px; background: #ffe7d6; display: flex; align-items: center; justify-content: center; }
    .mk-steps-icon-wrap svg { width: 28px; height: 28px; stroke: var(--mk-reward-orange, #f47716); }
    .mk-steps-label { font-size: 13px; font-weight: 700; color: var(--mk-reward-orange, #f47716); text-transform: uppercase; letter-spacing: .4px; margin-bottom: 8px; }
    .mk-steps-title-card { font-size: 18px; font-weight: 800; color: var(--mk-reward-text, #34343b); margin: 0 0 12px; }
    .mk-steps-text { font-size: 14px; color: #5d6571; line-height: 1.6; margin: 0; }
    @media (max-width: 800px) { .mk-steps-grid { grid-template-columns: 1fr; } .mk-steps-title { font-size: 26px; } }

    /* ===================== Term and CTA (CSS SAMA) ================== */
    .mk-terms-section { padding: 40px 24px 80px; background: #fcfcfc; }
    .mk-terms-card { max-width: 1160px; margin: 0 auto; background: #ffffff; border-radius: 16px; padding: 40px; border: 1px solid #eaeaea; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); }
    .mk-terms-header { display: flex; align-items: center; gap: 12px; margin-bottom: 32px; }
    .mk-terms-icon { width: 20px; height: 20px; color: var(--mk-reward-orange, #f47716); flex-shrink: 0; }
    .mk-terms-title { font-size: 22px; font-weight: 800; color: var(--mk-reward-text, #34343b); margin: 0; }
    .mk-terms-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 48px; padding-bottom: 32px; border-bottom: 1px solid #f0f0f0; }
    .mk-terms-group-title { font-size: 13px; font-weight: 800; color: var(--mk-reward-text, #34343b); text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 16px; }
    .mk-terms-list { margin: 0; padding-left: 18px; color: #5d6571; font-size: 14px; line-height: 1.7; }
    .mk-terms-list li { margin-bottom: 10px; }
    .mk-terms-list li::marker { color: #888888; }
    .mk-terms-footer { display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-top: 24px; flex-wrap: wrap; }
    .mk-terms-note { font-size: 13px; font-style: italic; color: #717d8d; margin: 0; }
    .mk-terms-download { display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: #b45012; text-decoration: none !important; transition: opacity 0.2s ease; }
    .mk-terms-download:hover { opacity: 0.8; }
    @media (max-width: 768px) { .mk-terms-card { padding: 28px 20px; } .mk-terms-grid { grid-template-columns: 1fr; gap: 24px; } .mk-terms-footer { flex-direction: column; align-items: flex-start; } }

    .mk-cta-section { padding: 40px 24px 80px; background: #f4f4f5; }
    .mk-cta-card { max-width: 1160px; margin: 0 auto; background: var(--mk-reward-orange, #f47716); border-radius: 20px; padding: 60px 32px; text-align: center; position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(244, 119, 22, 0.25); }
    .mk-cta-icon-bg { position: absolute; right: 40px; top: 50%; transform: translateY(-50%); width: 120px; height: 120px; background: rgba(0, 0, 0, 0.12); border-radius: 50%; display: flex; align-items: center; justify-content: center; pointer-events: none; }
    .mk-cta-star { width: 64px; height: 64px; fill: rgba(255, 255, 255, 0.25); }
    .mk-cta-content { position: relative; z-index: 1; max-width: 680px; margin: 0 auto; }
    .mk-cta-title { font-size: 26px; font-weight: 800; color: #ffffff; margin: 0 0 16px; }
    .mk-cta-desc { font-size: 15px; color: rgba(255, 255, 255, 0.92); margin: 0 0 32px; line-height: 1.6; }
    .mk-cta-actions { display: flex; justify-content: center; align-items: center; gap: 16px; flex-wrap: wrap; }
    .mk-cta-btn { min-width: 180px; padding: 14px 24px; border-radius: 8px; font-size: 14px; font-weight: 700; text-decoration: none !important; transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease; display: inline-block; text-align: center; border: none; }
    .mk-cta-btn:hover { transform: translateY(-2px); }
    .mk-cta-btn-white { background: #ffffff; color: var(--mk-reward-orange, #f47716) !important; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
    .mk-cta-btn-white:hover { background: #fffdfb; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15); }
    .mk-cta-btn-dark { background: #5c2700; color: #ffffff !important; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); }
    .mk-cta-btn-dark:hover { background: #4a1f00; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2); }
    @media (max-width: 768px) { .mk-cta-card { padding: 44px 20px; } .mk-cta-title { font-size: 22px; } .mk-cta-desc { font-size: 14px; } .mk-cta-icon-bg { opacity: 0.15; right: -20px; } }
    @media (max-width: 480px) { .mk-cta-btn { width: 100%; } }
</style>

<!-- ===================== Section Grand Prize ================== -->
<section class="mk-reward-hero">
    <div class="mk-reward-hero-wrap">
        <div class="mk-reward-content">
            <span class="mk-reward-badge">Event Tahunan Terbesar</span>
            <h1 class="mk-reward-title">
                <?php echo htmlspecialchars($periode['program_name'] ?? 'Manna Kampus'); ?>
                <span><?php echo htmlspecialchars($periode['periode_name'] ?? ''); ?></span>
            </h1>
                <p class="mk-reward-desc">
                    Belanja lebih banyak, raih kesempatan memenangkan Grand Prize sebuah unit Rumah Type 48 serta SUV mewah dan 
                    ratusan hadiah menarik lainnya sebagai bentuk apresiasi kami bagi Anda pelanggan setia.
                </p>

                <?php if (!empty($periode['draw_date'])): ?>
                    <div class="mk-draw-date">
                        
                        <div class="mk-draw-date-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                                <circle cx="12" cy="15" r="1"></circle>
                            </svg>
                        </div>

                            <div class="mk-draw-date-info">
                                <span class="mk-draw-date-label">Tanggal Diundi</span>
                                <span class="mk-draw-date-value">
                                    <?php echo htmlspecialchars($drawDate); ?>
                                </span>
                            </div>

                        </div>
                    <?php endif; ?>
                    
            <div class="mk-reward-actions">
                <!-- [REVISI] Tampilkan ke-3 tombol. Jika id-nya sama dengan periode aktif, beri kelas 'primary'. Jika tidak, beri kelas 'outline'. -->
                <?php foreach ($allPeriodes as $p): ?>
                    <a class="mk-reward-button <?php echo $p['id'] == $periodeId ? 'mk-reward-button-primary' : 'mk-reward-button-outline'; ?>"
                       href="?periode=<?php echo $p['id']; ?>">
                        <?php echo htmlspecialchars($p['periode_name']); ?>
                    </a>
                <?php endforeach; ?>
            </div>

        </div>
        <div class="mk-reward-visual">
            <img class="mk-reward-image"
                 src="<?php echo !empty($grandPrize['img']) ? $rewardImgPath . htmlspecialchars($grandPrize['img']) : $defaultRewardImg; ?>"
                 alt="Grand prize <?php echo htmlspecialchars($grandPrize['prize_name'] ?? ''); ?>">
            <div class="mk-reward-prize">Grand Prize<br><?php echo htmlspecialchars($grandPrize['prize_name'] ?? '-'); ?></div>
        </div>
    </div>
</section>

<!-- ===================== Section Daftar Hadiah Pesta (Carousel) ================== -->
<section class="mk-prize-section">
    <div class="mk-prize-container">

        <div class="mk-prize-header">
            <div class="mk-prize-header-text">
                <h2 class="mk-prize-title">Daftar Hadiah Pesta</h2>
                <div class="mk-prize-title-line"></div>
            </div>
            <div class="mk-prize-nav">
                <button type="button" class="mk-prize-nav-btn" id="mkPrizePrev" aria-label="Sebelumnya">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                <button type="button" class="mk-prize-nav-btn" id="mkPrizeNext" aria-label="Berikutnya">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            </div>
        </div>

        <?php if (empty($rewardList)): ?>
            <p style="text-align:center; color:#888;">Belum ada data hadiah lainnya untuk periode ini.</p>
        <?php else: ?>
            <div class="mk-prize-viewport">
                <div class="mk-prize-track" id="mkPrizeTrack">
                    <?php $rank = 1; ?>
                    <?php foreach ($rewardList as $reward): ?>
                        <?php
                            $imgSrc = !empty($reward['img']) ? $rewardImgPath . htmlspecialchars($reward['img']) : $defaultRewardImg;
                        ?>
                        <div class="mk-prize-card">
                            <div>
                                <div class="mk-prize-image-wrap">
                                    <img src="<?php echo $imgSrc; ?>"
                                         alt="<?php echo htmlspecialchars($reward['prize_name']); ?>"
                                         onerror="this.onerror=null;this.src='<?php echo $defaultRewardImg; ?>';">
                                </div>
                                <div class="mk-prize-content-body">
                                    <div class="mk-prize-category">Hadiah Ke-<?php echo $rank; ?></div>
                                    <h3 class="mk-prize-name">
                                        <?php echo $reward['qty'] > 1 ? $reward['qty'] . ' ' : ''; ?><?php echo htmlspecialchars($reward['prize_name']); ?>
                                    </h3>
                                    <p class="mk-prize-sub"><?php echo htmlspecialchars($reward['description']); ?></p>
                                </div>
                            </div>
                            <div class="mk-prize-footer">
                                <span class="mk-prize-pill"><?php echo $reward['qty']; ?> Pemenang</span>
                            </div>
                        </div>
                        <?php $rank++; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- ===================== Section Cara Ikutan Pesta Hadiah ================== -->
<section class="mk-steps-section">
    <div class="mk-steps-container">

        <div class="mk-steps-header">
            <h2 class="mk-steps-title">Cara Ikutan Pesta Hadiah</h2>
            <p class="mk-steps-desc">Hanya dengan 3 langkah mudah, Anda berpeluang membawa pulang hadiah impian.</p>
        </div>

        <div class="mk-steps-grid">

            <!-- Langkah 1 -->
            <div class="mk-steps-card">
                <div class="mk-steps-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </div>
                <div class="mk-steps-label">Langkah 1</div>
                <h3 class="mk-steps-title-card">Belanja Minimal 100rb</h3>
                <p class="mk-steps-text">Belanja produk apa saja di seluruh gerai Manna Kampus dengan nominal minimal Rp 100.000 dalam satu struk.</p>
            </div>

            <!-- Langkah 2 -->
            <div class="mk-steps-card">
                <div class="mk-steps-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </div>
                <div class="mk-steps-label">Langkah 2</div>
                <h3 class="mk-steps-title-card">Dapatkan Kode Kupon</h3>
                <p class="mk-steps-text">Periksa bagian bawah struk belanja Anda untuk menemukan kode kupon unik yang dicetak secara otomatis oleh sistem.</p>
            </div>

            <!-- Langkah 3 -->
            <div class="mk-steps-card">
                <div class="mk-steps-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                </div>
                <div class="mk-steps-label">Langkah 3</div>
                <h3 class="mk-steps-title-card">Registrasi Kupon</h3>
                <p class="mk-steps-text">Masukkan kode kupon melalui website atau aplikasi Manna Kampus untuk mengaktifkan nomor undian Anda.</p>
            </div>

        </div>
    </div>
</section>

<!-- ===================== Section Syarat & Ketentuan ================== -->
<section class="mk-terms-section">
    <div class="mk-terms-card">
        
        <div class="mk-terms-header">
            <svg class="mk-terms-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <h3 class="mk-terms-title">Syarat & Ketentuan</h3>
        </div>

        <div class="mk-terms-grid">
            
            <!-- Kolom Kiri -->
            <div class="mk-terms-col">
                <h4 class="mk-terms-group-title">PERIODE PROGRAM</h4>
                <ul class="mk-terms-list">
                    <li>Program berlangsung mulai 1 Januari 2024 hingga 31 Desember 2024.</li>
                    <li>Batas akhir registrasi kupon adalah 5 Januari 2025 pukul 23:59 WIB.</li>
                    <li>Pengundian akan dilakukan secara live pada 15 Januari 2025.</li>
                </ul>
            </div>

            <!-- Kolom Kanan -->
            <div class="mk-terms-col">
                <h4 class="mk-terms-group-title">KELAYAKAN PESERTA</h4>
                <ul class="mk-terms-list">
                    <li>Terbuka untuk seluruh Warga Negara Indonesia (WNI) yang memiliki KTP/SIM.</li>
                    <li>Bukan merupakan karyawan atau keluarga inti dari Manna Kampus Group.</li>
                    <li>Setiap peserta diperbolehkan mendaftarkan lebih dari satu kupon.</li>
                </ul>
            </div>

        </div>

        <div class="mk-terms-footer">
            <p class="mk-terms-note">Keputusan panitia bersifat mutlak dan tidak dapat diganggu gugat. Hati-hati terhadap penipuan!</p>
            <a href="document-syarat-ketentuan.pdf" class="mk-terms-download" target="_blank">
                Unduh Dokumen Lengkap (PDF)
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
            </a>
        </div>

    </div>
</section>

<!-- ===================== Section CTA Pemenang ================== -->
<section class="mk-cta-section">
    <div class="mk-cta-card">
        
        <!-- Watermark/Icon Bintang di Kanan -->
        <div class="mk-cta-icon-bg">
            <svg class="mk-cta-star" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
        </div>

        <div class="mk-cta-content">
            <h3 class="mk-cta-title">Siap Jadi Pemenang Berikutnya?</h3>
            <p class="mk-cta-desc">Jangan lewatkan kesempatan emas ini. Setiap struk belanja Anda adalah pintu menuju hadiah impian.</p>
            
            <div class="mk-cta-actions">
                <a href="lokasi-outlet.php" class="mk-cta-btn mk-cta-btn-white">Cari Gerai Terdekat</a>
                <a href="belanja-online.php" class="mk-cta-btn mk-cta-btn-dark">Unduh Aplikasi</a>
            </div>
        </div>

    </div>
</section>

<script>
(function () {
    const track = document.getElementById('mkPrizeTrack');
    if (!track) return; // tidak ada data, skip

    const prevBtn = document.getElementById('mkPrizePrev');
    const nextBtn = document.getElementById('mkPrizeNext');
    const cards = track.children;
    const totalCards = cards.length;

    function getVisibleCount() {
        const w = window.innerWidth;
        if (w <= 576) return 1;
        if (w <= 1024) return 2;
        return 4;
    }

    let currentIndex = 0;

    function update() {
        const visibleCount = getVisibleCount();
        const maxIndex = Math.max(0, totalCards - visibleCount);
        if (currentIndex > maxIndex) currentIndex = maxIndex;

        const cardWidth = cards[0].getBoundingClientRect().width;
        const gap = 24;
        const offset = currentIndex * (cardWidth + gap);
        track.style.transform = `translateX(-${offset}px)`;

        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex >= maxIndex;
    }

    prevBtn.addEventListener('click', function () {
        currentIndex = Math.max(0, currentIndex - 1);
        update();
    });

    nextBtn.addEventListener('click', function () {
        const visibleCount = getVisibleCount();
        const maxIndex = Math.max(0, totalCards - visibleCount);
        currentIndex = Math.min(maxIndex, currentIndex + 1);
        update();
    });

    window.addEventListener('resize', update);
    update();
})();
</script>

<?php require_once('footer.php'); ?>