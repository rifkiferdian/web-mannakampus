<?php require_once('header.php'); ?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Dashboard</h1>

        <div class="dashboard-welcome">
            <div class="dashboard-welcome-title">
                Selamat datang, Admin! 👋
            </div>
            <div class="dashboard-welcome-text">
                Kelola konten website Manna Kampus dengan mudah dan efisien.
            </div>
        </div>
    </div>
</section>

<style>
.dashboard-welcome {
    margin-top: 3px;
}

.dashboard-welcome-title {
    font-size: 18px;
    font-weight: 600;
    color: #222;
    line-height: 1.4;
}

.dashboard-welcome-text {
    margin-top: 2px;
    font-size: 14px;
    color: #777;
    line-height: 1.4;
}    
</style>

<?php 
$statement = $pdo->prepare("SELECT * FROM tbl_user");
$statement->execute();
$total_user = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_category");
$statement->execute();
$total_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_news");
$statement->execute();
$total_news = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_photo");
$statement->execute();
$total_photo = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_video");
$statement->execute();
$total_video = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_team_member");
$statement->execute();
$total_team_member = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_slider");
$statement->execute();
$total_slider = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_partner");
$statement->execute();
$total_partner = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_service");
$statement->execute();
$total_service = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_testimonial");
$statement->execute();
$total_testimonial = $statement->rowCount();

// Ambil 5 berita terbaru (JOIN pakai category_id, kolom nama kategori = category_name)
$statement = $pdo->prepare("
    SELECT tbl_news.*, tbl_category.category_name 
    FROM tbl_news 
    LEFT JOIN tbl_category ON tbl_news.category_id = tbl_category.category_id 
    ORDER BY tbl_news.news_date DESC 
    LIMIT 5
");
$statement->execute();
$news_list = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="content">

  <div class="row">
    <!-- Total Users -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div style="background:#fff; border-radius:10px; min-height:90px; margin-bottom:15px; padding:15px 20px; display:flex; align-items:center;">
            <div style="width:48px; height:48px; background:#ff7800; border-radius:8px; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(255,120,0,.25); margin-right:15px; flex-shrink:0;">
                <i class="fa fa-users" style="font-size:20px; color:#fff;"></i>
            </div>
            <div>
                <span style="display:block; color:#222; font-size:14px; font-weight:600;">
                    Total Users
                </span>
                <span style="display:block; color:#222; font-size:24px; font-weight:700; margin-top:2px;">
                    <?php echo $total_user; ?>
                </span>
            </div>
        </div>
    </div>


    <!-- Total Categories -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div style="background:#fff; border-radius:10px; min-height:90px; margin-bottom:15px; padding:15px 20px; display:flex; align-items:center;">
            <div style="width:48px; height:48px; background:#ff7800; border-radius:8px; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(255,120,0,.25); margin-right:15px; flex-shrink:0;">
                <i class="fa fa-folder" style="font-size:20px; color:#fff;"></i>
            </div>
            <div>
                <span style="display:block; color:#222; font-size:14px; font-weight:600;">
                    Total Categories
                </span>
                <span style="display:block; color:#222; font-size:24px; font-weight:700; margin-top:2px;">
                    <?php echo $total_category; ?>
                </span>
            </div>
        </div>
    </div>


    <!-- Total News -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div style="background:#fff; border-radius:10px; min-height:90px; margin-bottom:15px; padding:15px 20px; display:flex; align-items:center;">
            <div style="width:48px; height:48px; background:#ff7800; border-radius:8px; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(255,120,0,.25); margin-right:15px; flex-shrink:0;">
                <i class="fa fa-newspaper-o" style="font-size:20px; color:#fff;"></i>
            </div>
            <div>
                <span style="display:block; color:#222; font-size:14px; font-weight:600;">
                    Total News
                </span>
                <span style="display:block; color:#222; font-size:24px; font-weight:700; margin-top:2px;">
                    <?php echo $total_news; ?>
                </span>
            </div>
        </div>
    </div>


    <!-- Total Photos -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div style="background:#fff; border-radius:10px; min-height:90px; margin-bottom:15px; padding:15px 20px; display:flex; align-items:center;">
            <div style="width:48px; height:48px; background:#ff7800; border-radius:8px; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(255,120,0,.25); margin-right:15px; flex-shrink:0;">
                <i class="fa fa-image" style="font-size:20px; color:#fff;"></i>
            </div>
            <div>
                <span style="display:block; color:#222; font-size:14px; font-weight:600;">
                    Total Photos
                </span>
                <span style="display:block; color:#222; font-size:24px; font-weight:700; margin-top:2px;">
                    <?php echo $total_photo; ?>
                </span>
            </div>
        </div>
    </div>


    <!-- Total Videos -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div style="background:#fff; border-radius:10px; min-height:90px; margin-bottom:15px; padding:15px 20px; display:flex; align-items:center;">
            <div style="width:48px; height:48px; background:#ff7800; border-radius:8px; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(255,120,0,.25); margin-right:15px; flex-shrink:0;">
                <i class="fa fa-video-camera" style="font-size:20px; color:#fff;"></i>
            </div>
            <div>
                <span style="display:block; color:#222; font-size:14px; font-weight:600;">
                    Total Videos
                </span>
                <span style="display:block; color:#222; font-size:24px; font-weight:700; margin-top:2px;">
                    <?php echo $total_video; ?>
                </span>
            </div>
        </div>
    </div>


    <!-- Total Team Members -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div style="background:#fff; border-radius:10px; min-height:90px; margin-bottom:15px; padding:15px 20px; display:flex; align-items:center;">
            <div style="width:48px; height:48px; background:#ff7800; border-radius:8px; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(255,120,0,.25); margin-right:15px; flex-shrink:0;">
                <i class="fa fa-users" style="font-size:20px; color:#fff;"></i>
            </div>
            <div>
                <span style="display:block; color:#222; font-size:14px; font-weight:600;">
                    Total Team Members
                </span>
                <span style="display:block; color:#222; font-size:24px; font-weight:700; margin-top:2px;">
                    <?php echo $total_team_member; ?>
                </span>
            </div>
        </div>
    </div>


    <!-- Total Sliders -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div style="background:#fff; border-radius:10px; min-height:90px; margin-bottom:15px; padding:15px 20px; display:flex; align-items:center;">
            <div style="width:48px; height:48px; background:#ff7800; border-radius:8px; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(255,120,0,.25); margin-right:15px; flex-shrink:0;">
                <i class="fa fa-picture-o" style="font-size:20px; color:#fff;"></i>
            </div>
            <div>
                <span style="display:block; color:#222; font-size:14px; font-weight:600;">
                    Total Sliders
                </span>
                <span style="display:block; color:#222; font-size:24px; font-weight:700; margin-top:2px;">
                    <?php echo $total_slider; ?>
                </span>
            </div>
        </div>
    </div>


    <!-- Total Partners -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div style="background:#fff; border-radius:10px; min-height:90px; margin-bottom:15px; padding:15px 20px; display:flex; align-items:center;">
            <div style="width:48px; height:48px; background:#ff7800; border-radius:8px; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(255,120,0,.25); margin-right:15px; flex-shrink:0;">
                <i class="fa fa-handshake-o" style="font-size:20px; color:#fff;"></i>
            </div>
            <div>
                <span style="display:block; color:#222; font-size:14px; font-weight:600;">
                    Total Partners
                </span>
                <span style="display:block; color:#222; font-size:24px; font-weight:700; margin-top:2px;">
                    <?php echo $total_partner; ?>
                </span>
            </div>
        </div>
    </div>


    <!-- Total Services -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div style="background:#fff; border-radius:10px; min-height:90px; margin-bottom:15px; padding:15px 20px; display:flex; align-items:center;">
            <div style="width:48px; height:48px; background:#ff7800; border-radius:8px; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(255,120,0,.25); margin-right:15px; flex-shrink:0;">
                <i class="fa fa-cogs" style="font-size:20px; color:#fff;"></i>
            </div>
            <div>
                <span style="display:block; color:#222; font-size:14px; font-weight:600;">
                    Total Services
                </span>
                <span style="display:block; color:#222; font-size:24px; font-weight:700; margin-top:2px;">
                    <?php echo $total_service; ?>
                </span>
            </div>
        </div>
    </div>


    <!-- Total Testimonials -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div style="background:#fff; border-radius:10px; min-height:90px; margin-bottom:15px; padding:15px 20px; display:flex; align-items:center;">
            <div style="width:48px; height:48px; background:#ff7800; border-radius:8px; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(255,120,0,.25); margin-right:15px; flex-shrink:0;">
                <i class="fa fa-comments" style="font-size:20px; color:#fff;"></i>
            </div>
            <div>
                <span style="display:block; color:#222; font-size:14px; font-weight:550;">
                    Total Testimonials
                </span>
                <span style="display:block; color:#222; font-size:24px; font-weight:550; margin-top:2px;">
                    <?php echo $total_testimonial; ?>
                </span>
            </div>
        </div>
    </div>
    </div>

    <!-- Statistika Pengunjung -->
  <div class="row">
    <div class="col-md-12">
      <div class="box box-solid" style="border-radius:10px; overflow:hidden;">
        <div class="box-header with-border">
          <h3 class="box-title">Statistik Pengunjung</h3>
          <div class="box-tools pull-right">
            <span class="label label-default" style="font-size:13px; padding:6px 12px; border-radius:20px; font-weight:500; background: #e8e9eb; color:#6b7280; display:inline-flex; align-items:center; justify-content:center; line-height:1;">7 hari terakhir</span>          </div>
        </div>
        <div class="box-body" style="height:400px;">
            <canvas id="visitorChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- News
  <div class="row">

    <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header with-border" style="display:flex; align-items:center; justify-content:space-between;">
                <h3 class="box-title">News</h3>
                <a href="news.php" class="btn btn-sm" style="background:#ff7800; color:#fff; border-radius:6px;">
                    <i class="fa fa-plus"></i> Tambah Berita
                </a>
            </div>
            <div class="box-body" style="padding:0;">
                <table class="table" style="margin-bottom:0;">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Views</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($news_list) > 0): ?>
                            <?php foreach ($news_list as $news): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($news['news_title']); ?></td>
                                <td><?php echo htmlspecialchars($news['category_name']); ?></td>
                                <td><?php echo date('d M Y', strtotime($news['news_date'])); ?></td>
                                <td><?php echo $news['total_view']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" style="text-align:center; color:#999;">Belum ada berita</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

  </div> -->

</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
fetch('ga4-stats.php')
  .then(res => res.json())
  .then(data => {
    if (!data.success) {
      console.error(data.message);
      return;
    }

    const ctx = document.getElementById('visitorChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(255, 140, 0, 0.4)');
    gradient.addColorStop(1, 'rgba(255, 140, 0, 0)');

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: data.labels,
        datasets: [{
          data: data.values,
          borderColor: '#ff8c00',
          backgroundColor: gradient,
          fill: true,
          tension: 0,
          pointRadius: 5,
          pointHoverRadius: 6,
          pointBackgroundColor: '#ff8c00',
          pointBorderColor: '#fff',
          pointBorderWidth: 2,
          borderWidth: 3
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          y: { display: false },
          x: { grid: { display: false }, ticks: { color: '#9ca3af' }  }
        }
      }
    });
  });
</script>

<?php require_once('footer.php'); ?>