<?php require_once('header.php');

/* ---------------------------------------------------------------------
 * 1. Ambil Semua Data Archive
 * ------------------------------------------------------------------- */
$all_archives = [];
try {
    $sql_archive = "
        SELECT 
            prog.year, 
            COUNT(w.id) AS total_winners,
            (SELECT w2.photo FROM tbl_winners w2 
             JOIN tbl_periode per2 ON w2.id_periode = per2.id 
             WHERE per2.id_program = prog.id 
             LIMIT 1) AS sample_photo
        FROM tbl_program prog
        LEFT JOIN tbl_periode per ON prog.id = per.id_program
        LEFT JOIN tbl_winners w ON per.id = w.id_periode
        GROUP BY prog.year
        ORDER BY prog.year DESC
    ";
    $stmt = $pdo->query($sql_archive);
    $all_archives = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $all_archives = [];
}
?>

<style>
    /* ---------------- Styling Utama Archive ---------------- */
    .mk-archive-page { background: #fafafa; padding-bottom: 70px; }
    .mk-archive-container { max-width: 1160px; margin: 0 auto; padding: 0 24px; }
    
    /* Hero Banner disamakan persis seperti winners.php */
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

    /* Toolbar / Tombol Kembali */
    .mk-archive-toolbar { margin: 40px 0 24px; display: flex; align-items: center; }
    .mk-archive-back-btn { display:inline-flex; align-items:center; gap:8px; background:#FFFFFF; border:1px solid #EAEAEA; color:#34343b !important; font-weight:700; font-size: 14px; padding:10px 18px; border-radius:10px; text-decoration:none; box-shadow: 0 2px 8px rgba(0,0,0,0.02); transition: all 0.2s ease; }
    .mk-archive-back-btn:hover { border-color:var(--mk-reward-orange, #f47716); color:var(--mk-reward-orange, #f47716) !important; transform: translateX(-3px); }

    /* Grid Archive */
    .mk-archive-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
    .mk-archive-card { border-radius: 12px; overflow: hidden; position: relative; display: flex; flex-direction: column; justify-content: flex-end; aspect-ratio: 1 / 1; text-decoration: none !important; box-shadow: 0 4px 14px rgba(0,0,0,0.04); transition: transform 0.25s ease, box-shadow 0.25s ease; }
    .mk-archive-card:hover { transform: translateY(-4px); box-shadow: 0 10px 24px rgba(0,0,0,0.1); }
    .mk-archive-img { position: absolute; top:0; left:0; width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .mk-archive-card:hover .mk-archive-img { transform: scale(1.08); }
    .mk-archive-overlay { position: absolute; inset:0; background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.2) 50%, rgba(0,0,0,0) 100%); z-index: 1; }
    .mk-archive-info { position: relative; z-index: 2; padding: 20px; color: #ffffff; }
    .mk-archive-year { font-size: 20px; font-weight: 800; margin-bottom: 4px; line-height: 1; }
    .mk-archive-count { font-size: 13px; font-weight: 500; color: #e5e7eb; }

    /* Responsive */
    @media (max-width: 900px) { .mk-archive-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px) { .mk-archive-grid { grid-template-columns: 1fr; } .mk-winner-title { font-size: 28px; } }
</style>

<div class="mk-archive-page">
    
    <!-- Hero Banner disamakan dengan winners.php -->
    <section class="mk-winner-hero">
        <div class="mk-winner-hero-wrap">
            <div class="mk-winner-badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Arsip Pemenang
            </div>
            <h1 class="mk-winner-title">Riwayat Pemenang Pesta Hadiah</h1>
            <p class="mk-winner-desc">Dokumentasi dan daftar lengkap pemenang beruntung dari penyelenggaraan undian Manna Kampus tahun-tahun sebelumnya.</p>
        </div>
    </section>

    <div class="mk-archive-container">
        <div class="mk-archive-toolbar">
            <a href="winners.php" class="mk-archive-back-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                Kembali ke Daftar Pemenang Terbaru
            </a>
        </div>

        <div class="mk-archive-grid">
            <?php foreach ($all_archives as $archive): ?>
                <a href="winners.php?tahun=<?php echo $archive['year']; ?>" class="mk-archive-card">
                    <img src="<?php echo !empty($archive['sample_photo']) ? 'assets/uploads/'.$archive['sample_photo'] : 'assets/img/no-avatar.png'; ?>" 
                         class="mk-archive-img" alt="Arsip <?php echo $archive['year']; ?>"
                         onerror="this.src='https://placehold.co/400x400/eee/999?text=Arsip+<?php echo $archive['year']; ?>'">
                    <div class="mk-archive-overlay"></div>
                    <div class="mk-archive-info">
                        <div class="mk-archive-year">Tahun <?php echo $archive['year']; ?></div>
                        <div class="mk-archive-count"><?php echo number_format($archive['total_winners'],0,',','.'); ?> Pemenang</div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>