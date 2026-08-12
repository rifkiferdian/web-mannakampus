<?php 
require_once('header.php');

// =========================================================================
// 1. PENGAMBILAN DATA DATABASE 
// =========================================================================

// A. Tangkap ID cabang dari URL (default = 1)
$selected_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// B. Query mengambil detail cabang terpilih dari tbl_cabang
$stmt_detail = $pdo->prepare("SELECT * FROM tbl_cabang WHERE id = :id LIMIT 1");
$stmt_detail->execute([':id' => $selected_id]);
$current_cabang = $stmt_detail->fetch(PDO::FETCH_ASSOC);

// Fallback jika ID tidak ditemukan/tidak valid
if (!$current_cabang) {
    $stmt_fallback = $pdo->query("SELECT * FROM tbl_cabang ORDER BY id ASC LIMIT 1");
    $current_cabang = $stmt_fallback->fetch(PDO::FETCH_ASSOC);
}

$nama_cabang_tampil = !empty($current_cabang['nama_cabang']) ? $current_cabang['nama_cabang'] : 'Cabang';

// C. Pagination Setup
$per_page = 20; // Jumlah foto per halaman
$current_page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($current_page - 1) * $per_page;

// D. Hitung total foto galeri untuk cabang ini
$stmt_count = $pdo->prepare("SELECT COUNT(*) FROM tbl_cabang_galeri WHERE id_cabang = ?");
$stmt_count->execute([$current_cabang['id']]);
$total_foto = (int)$stmt_count->fetchColumn();
$total_pages = max(1, (int)ceil($total_foto / $per_page));

// Jaga-jaga jika current_page melebihi total_pages
if ($current_page > $total_pages) {
    $current_page = $total_pages;
    $offset = ($current_page - 1) * $per_page;
}

// E. Query mengambil foto galeri sesuai halaman aktif
$stmt_galeri = $pdo->prepare("SELECT foto FROM tbl_cabang_galeri WHERE id_cabang = ? ORDER BY id ASC LIMIT ? OFFSET ?");
$stmt_galeri->bindValue(1, $current_cabang['id'], PDO::PARAM_INT);
$stmt_galeri->bindValue(2, $per_page, PDO::PARAM_INT);
$stmt_galeri->bindValue(3, $offset, PDO::PARAM_INT);
$stmt_galeri->execute();
$result_galeri = $stmt_galeri->fetchAll(PDO::FETCH_COLUMN);
?>

<style>
/* ---------------- Styling Utama ---------------- */
.mk-galeri-full-page { font-family: inherit; background: #fafafa; }
.mk-galeri-full-container { max-width: 1240px; margin: 0 auto; padding: 0 20px 70px; }

/* Header Halaman */
.mk-galeri-full-hero { position:relative; background-size:cover; background-position:center; padding:70px 24px 60px; text-align:left; min-height:220px; display:flex; align-items:center; }
.mk-galeri-full-hero::before { content:""; position:absolute; inset:0; background:rgba(20,20,20,0.55); }
.mk-galeri-full-hero .mk-galeri-full-container { position:relative; z-index:2; }
.mk-galeri-full-hero-title { font-size:3.25rem; font-weight:800; color:#FFFFFF; margin:0 0 10px; text-shadow:0 2px 8px rgba(0,0,0,0.3); line-height:1.15; text-align:center; }
.mk-galeri-full-hero-title span { color:#E8792E; }
.mk-galeri-full-hero-sub { font-size:1.5rem; color:#F1EEEA; margin:0; text-align:center;}

/* Toolbar: Tombol Kembali + Info Jumlah */
.mk-galeri-toolbar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; margin:40px 0 30px; }
.mk-galeri-back-btn { display:inline-flex; align-items:center; gap:8px; background:#FFFFFF; border:1px solid #EAEAEA; color:#2E2620 !important; text-decoration:none; font-weight:700; font-size:1.15rem; padding:10px 20px; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.04); transition: all 0.2s ease; }
.mk-galeri-back-btn:hover { border-color:#E8792E; color:#E8792E !important; transform: translateX(-3px); }
.mk-galeri-count { font-size:1.25rem; color:#8A7F73; font-weight:600; }
.mk-galeri-count strong { color:#2E2620; }

/* Grid Foto */
.mk-galeri-full-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 18px; padding-bottom: 20px; }
.mk-galeri-full-card { overflow: hidden; border-radius: 12px; position: relative; cursor: zoom-in; background: #f8f9fa; box-shadow: 0 4px 12px rgba(0,0,0,0.06); transition: transform 0.3s ease, box-shadow 0.3s ease; display: block; }
.mk-galeri-full-card img { width: 100%; height: 200px; display: block; object-fit: cover; transition: transform 0.4s ease; }
.mk-galeri-full-card:hover { transform: translateY(-6px); box-shadow: 0 14px 28px rgba(0,0,0,0.12); }
.mk-galeri-full-card:hover img { transform: scale(1.05); }

/* Empty State */
.mk-galeri-empty { text-align:center; color:#8A7F73; padding: 80px 20px; }
.mk-galeri-empty i { font-size: 2.5rem; color:#E8792E; margin-bottom: 16px; display:block; }

/* Pagination */
.mk-galeri-pagination { display:flex; justify-content:center; align-items:center; gap:8px; margin: 40px 0 70px; flex-wrap: wrap; }
.mk-page-btn { display:inline-flex; align-items:center; justify-content:center; min-width:42px; height:42px; padding:0 14px; border-radius:8px; border:1px solid #EAEAEA; background:#FFFFFF; color:#2E2620; font-weight:700; font-size:1.25rem; text-decoration:none; transition: all 0.2s ease; }
.mk-page-btn:hover { border-color:#E8792E; color:#E8792E; }
.mk-page-btn.active { background:#E8792E; border-color:#E8792E; color:#FFFFFF !important; }
.mk-page-btn.disabled { opacity:0.4; pointer-events:none; }
.mk-page-dots { color:#8A7F73; padding: 0 4px; }

/* Responsive */
@media (max-width: 1100px) { .mk-galeri-full-grid { grid-template-columns: repeat(4, 1fr); } }
@media (max-width: 900px) { .mk-galeri-full-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 640px) { .mk-galeri-full-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; } .mk-galeri-full-hero-title { font-size: 1.85rem; } }
@media (max-width: 420px) { .mk-galeri-full-grid { grid-template-columns: 1fr; } }

/* Modal Popup (sama seperti explor.php) */
#imageModal { animation: fadeIn 0.25s ease-in-out; }
#imageModalImg { animation: zoomIn 0.25s ease-in-out; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes zoomIn { from { transform: scale(0.8); } to { transform: scale(1); } }
</style>

<div class="mk-galeri-full-page">

    <!-- Hero Header -->
    <section class="mk-galeri-full-hero" style="background-image:url('<?php echo BASE_URL; ?>assets/uploads/kemitraan.png');">
        <div class="mk-galeri-full-container">
            <h1 class="mk-galeri-full-hero-title">
                Galeri <span><?php echo htmlspecialchars($nama_cabang_tampil, ENT_QUOTES, 'UTF-8'); ?></span>
            </h1>
            <p class="mk-galeri-full-hero-sub">
                Dokumentasi lengkap suasana dan fasilitas di cabang ini.
            </p>
        </div>
    </section>

    <div class="mk-galeri-full-container">

        <!-- Toolbar -->
        <div class="mk-galeri-toolbar">
            <a href="explor.php?id=<?php echo $current_cabang['id']; ?>" class="mk-galeri-back-btn">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Halaman Cabang
            </a>
            <?php if ($total_foto > 0): ?>
                <span class="mk-galeri-count">
                    Menampilkan <strong><?php echo count($result_galeri); ?></strong> dari <strong><?php echo $total_foto; ?></strong> foto
                </span>
            <?php endif; ?>
        </div>

        <!-- Grid Foto -->
        <?php if (!empty($result_galeri)): ?>
            <div class="mk-galeri-full-grid">
                <?php foreach ($result_galeri as $foto): 
                    $foto_url = BASE_URL . 'assets/uploads/' . htmlspecialchars($foto, ENT_QUOTES, 'UTF-8');
                ?>
                    <div class="mk-galeri-full-card" onclick="openImageModal('<?php echo $foto_url; ?>')">
                        <img src="<?php echo $foto_url; ?>" alt="Galeri <?php echo htmlspecialchars($nama_cabang_tampil, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="mk-galeri-pagination">
                    <!-- Tombol Prev -->
                    <a href="?id=<?php echo $current_cabang['id']; ?>&page=<?php echo max(1, $current_page - 1); ?>" 
                       class="mk-page-btn <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>

                    <?php
                        // Logika nomor halaman ditampilkan (maks 5 nomor + ellipsis)
                        $window = 2;
                        for ($i = 1; $i <= $total_pages; $i++):
                            $tampilkan = ($i == 1 || $i == $total_pages || ($i >= $current_page - $window && $i <= $current_page + $window));
                            if ($tampilkan):
                    ?>
                        <a href="?id=<?php echo $current_cabang['id']; ?>&page=<?php echo $i; ?>" 
                           class="mk-page-btn <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php 
                            elseif ($i == $current_page - $window - 1 || $i == $current_page + $window + 1): 
                    ?>
                        <span class="mk-page-dots">...</span>
                    <?php 
                            endif;
                        endfor; 
                    ?>

                    <!-- Tombol Next -->
                    <a href="?id=<?php echo $current_cabang['id']; ?>&page=<?php echo min($total_pages, $current_page + 1); ?>" 
                       class="mk-page-btn <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="mk-galeri-empty">
                <i class="fa-solid fa-images"></i>
                <p>Belum ada dokumentasi galeri untuk cabang ini.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- ========================================== -->
<!-- HTML MODAL POP-UP (Perbesar & Silang Oranye) -->
<!-- ========================================== -->
<div id="imageModal" style="display:none; position:fixed; z-index:9999999; left:0; top:0; width:100vw; height:100vh; background-color:rgba(0,0,0,0.88); justify-content:center; align-items:center;" onclick="closeImageModal(event)">
    
    <span style="position:absolute; top:25px; right:30px; background-color:#D65A18; color:#fff; width:45px; height:45px; border-radius:50%; font-size:24px; font-weight:bold; cursor:pointer; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(0,0,0,0.3); z-index:10000001;" onclick="closeImageModal(event)">&times;</span>
    
    <img id="imageModalImg" style="max-width:95vw; max-height:95vh; width:auto; height:75vh; margin:auto; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.5); object-fit:contain;" onclick="event.stopPropagation()">
</div>

<script>
function openImageModal(src) {
    document.getElementById('imageModalImg').src = src;
    document.getElementById('imageModal').style.display = 'flex';
}

function closeImageModal() {
    document.getElementById('imageModal').style.display = 'none';
}
</script>

<?php require_once('footer.php'); ?>