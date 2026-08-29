<?php
ob_start();
session_start();
include("config.php");
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';
$flash_success_message = '';

if(isset($_SESSION['success_message'])) {
	$flash_success_message = $_SESSION['success_message'];
	unset($_SESSION['success_message']);
}

require '../assets/mail/PHPMailer.php';
require '../assets/mail/Exception.php';
$mail = new PHPMailer\PHPMailer\PHPMailer();

// Check if the user is logged in or not
if(!isset($_SESSION['user'])) {
	header('location: login.php');
	exit;
}

// Ambil nama halaman saat ini lebih awal agar tidak terjadi error pada in_array
$cur_page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);

// ==========================================
// MENU ACTIVE STATE & PAGE GROUPS
// ==========================================

// Kelompokkan semua file yang termasuk "keluarga" tiap submenu Outlet
$branch_info_pages       = ['branch-info.php', 'branch-info-add.php', 'branch-info-edit.php'];
$branch_videos_pages     = ['branch-videos.php', 'branch-videos-add.php', 'branch-videos-edit.php'];
$branch_tenants_pages    = ['branch-tenants.php', 'branch-tenants-add.php', 'branch-tenants-edit.php'];
$branch_katalog_pages    = ['branch-katalog.php', 'branch-katalog-add.php', 'branch-katalog-edit.php'];
$branch_facilities_pages = ['branch-facilities.php', 'branch-facilities-add.php', 'branch-facilities-edit.php'];
$branch_galleries_pages  = ['branch-galleries.php', 'branch-galleries-add.php', 'branch-galleries-edit.php'];
$branch_promo_pages      = ['branch-promo.php', 'branch-promo-add.php', 'branch-promo-edit.php'];

$outlet_pages = array_merge(
    ['outlet.php'],
    $branch_info_pages,
    $branch_videos_pages,
    $branch_tenants_pages,
    $branch_katalog_pages,
    $branch_facilities_pages,
    $branch_galleries_pages,
    $branch_promo_pages
);

// Kelompokkan file untuk tiap submenu News
$news_category_pages = ['category.php', 'category-add.php', 'category-edit.php', 'category-delete.php'];
$news_content_pages  = ['news.php', 'news-add.php', 'news-edit.php', 'news-delete.php'];
$news_comment_pages  = ['comment.php'];

$news_pages = array_merge(
    $news_category_pages,
    $news_content_pages,
    $news_comment_pages
);

$award_category_pages = ['designation.php', 'designation-add.php', 'designation-edit.php', 'designation-delete.php'];
$award_award_pages = ['team-member.php', 'team-member-add.php', 'team-member-edit.php', 'team-member-delete.php'];

$award_pages = array_merge(
	$award_category_pages,
	$award_award_pages
);

// Kelompokkan file untuk tiap submenu prize_draw
$prize_draw_program_pages = ['program.php', 'program-add.php', 'program-edit.php', 'program-delete.php'];
$prize_draw_periode_pages = ['periode.php', 'periode-add.php', 'periode-edit.php', 'periode-delete.php'];
$prize_draw_reward_pages  = ['reward.php', 'reward-add.php', 'reward-edit.php', 'reward-delete.php'];
$prize_draw_winners_pages = ['winners.php', 'winners-add.php', 'winners-edit.php', 'winners-delete.php'];
$prize_draw_sponsor_pages = ['sponsor.php', 'sponsor-add.php', 'sponsor-edit.php', 'sponsor-delete.php'];

$prize_draw_pages = array_merge(
    $prize_draw_program_pages,
	$prize_draw_periode_pages,
	$prize_draw_reward_pages,
    $prize_draw_winners_pages,
	$prize_draw_sponsor_pages
);


// Kelompokkan file untuk menu FAQ, Photo and Video, serta Subscriber
$faq_category_pages = ['faq-category.php', 'faq-category-add.php', 'faq-category-edit.php', 'faq-category-delete.php'];
$faq_pages          = ['faq.php', 'faq-add.php', 'faq-edit.php', 'faq-delete.php'];
$faq_menu_pages     = array_merge($faq_category_pages, $faq_pages);

$photo_category_pages = ['photo-category.php', 'photo-category-add.php', 'photo-category-edit.php', 'photo-category-delete.php'];
$photo_gallery_pages  = ['photo.php', 'photo-add.php', 'photo-edit.php', 'photo-delete.php'];
$video_category_pages = ['video-category.php', 'video-category-add.php', 'video-category-edit.php', 'video-category-delete.php'];
$video_pages          = ['video.php', 'video-add.php', 'video-edit.php', 'video-delete.php'];
$photo_video_menu_pages = array_merge($photo_category_pages, $photo_gallery_pages, $video_category_pages, $video_pages);

$subscriber_list_pages  = ['subscriber.php', 'subscriber-delete.php', 'subscriber-remove.php', 'subscriber-csv.php'];
$subscriber_email_pages = ['subscriber-email.php'];
$subscriber_menu_pages  = array_merge($subscriber_list_pages, $subscriber_email_pages);

// Getting data from the website settings table
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$receive_email = $row['receive_email'];
}

// Status aktif menu
$is_prize_draw_active  = in_array($cur_page, $prize_draw_pages);
$is_outlet_active      = in_array($cur_page, $outlet_pages);
$is_news_active        = in_array($cur_page, $news_pages);
$is_faq_active         = in_array($cur_page, $faq_menu_pages);
$is_photo_video_active = in_array($cur_page, $photo_video_menu_pages);
$is_subscriber_active  = in_array($cur_page, $subscriber_menu_pages);
$is_award_active	   = in_array($cur_page, $award_pages);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Consultine - Admin Panel</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/datepicker3.css">
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/jquery.fancybox.css">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">
	<link rel="stylesheet" href="css/on-off-switch.css">
	<link rel="stylesheet" href="css/summernote.css">
	<link rel="stylesheet" href="style.css">
	<style>
	/* Mengatur ukuran gambar di tabel agar lebih besar & jelas */
	.table img, 
	table.dataTable tbody td img {
		width: 100px !important;    /* Ubah sesuai selera (contoh: 100px atau 120px) */
		height: auto !important;   /* Menjaga proporsi gambar agar tidak terdistorsi */
		max-height: 100px !important;
		object-fit: contain;      /* Gambar tetap rapi tanpa terpotong */
		border-radius: 6px;        /* Bonus: bikin sudut gambar agak melengkung rapi */
		padding: 2px;
	}

	/* Menyesuaikan posisi sel tabel agar sejajar di tengah secara vertikal */
	.table tbody td {
		vertical-align: middle !important;
	}
		.admin-success-toast { position:fixed; top:70px; right:24px; z-index:11000; max-width:420px; margin:0; border:0; border-left:4px solid #2e8b57; box-shadow:0 8px 24px rgba(0,0,0,.18); }
		@media (max-width:767px) { .admin-success-toast { top:60px; right:12px; left:12px; max-width:none; } }

		.auto-page-section {
			font-size: 12.5px;
			font-weight: 600;
			color: #f86d1d;
			text-transform: uppercase;
			margin-bottom: 4px;
			letter-spacing: 1.4px;
		}

		.content-header .content-header-left h1 {
			margin: 0;
			font-size: 24px;
			font-weight: 700;
			line-height: 1.25;
		}

		.auto-breadcrumb {
			margin-top: 5px;
			margin-bottom: 5px;
			font-size: 14px;
			color: #777;
			line-height: 1.4;
			font-weight: 515;
		}
	</style>
</head>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const headerLeft = document.querySelector('.content-header-left');
    const title = headerLeft ? headerLeft.querySelector('h1') : null;

    if (!headerLeft || !title) {
        return;
    }

    const sectionMap = {
        'page.php': 'WEBSITE',
        'page-add.php': 'WEBSITE',
        'page-edit.php': 'WEBSITE',

        'menu.php': 'WEBSITE',
        'menu-add.php': 'WEBSITE',
        'menu-edit.php': 'WEBSITE',

        'language.php': 'WEBSITE',

        'category.php': 'CONTENT',
        'category-add.php': 'CONTENT',
        'category-edit.php': 'CONTENT',
        'category-delete.php': 'CONTENT',

        'news.php': 'CONTENT',
        'news-add.php': 'CONTENT',
        'news-edit.php': 'CONTENT',
        'news-delete.php': 'CONTENT',

        'comment.php': 'CONTENT',

        'promo-event.php': 'CONTENT',
        'promo-event-add.php': 'CONTENT',
        'promo-event-edit.php': 'CONTENT',

        'designation.php': 'CONTENT',
        'designation-add.php': 'CONTENT',
        'designation-edit.php': 'CONTENT',

        'team-member.php': 'CONTENT',
        'team-member-add.php': 'CONTENT',
        'team-member-edit.php': 'CONTENT',

        'testimonial.php': 'CONTENT',
        'testimonial-add.php': 'CONTENT',
        'testimonial-edit.php': 'CONTENT',

        'partner.php': 'CONTENT',
        'partner-add.php': 'CONTENT',
        'partner-edit.php': 'CONTENT',

        'service.php': 'CONTENT',
        'service-add.php': 'CONTENT',
        'service-edit.php': 'CONTENT',

        'slider.php': 'MEDIA',
        'slider-add.php': 'MEDIA',
        'slider-edit.php': 'MEDIA',

        'photo-category.php': 'MEDIA',
        'photo-category-add.php': 'MEDIA',
        'photo-category-edit.php': 'MEDIA',

        'photo.php': 'MEDIA',
        'photo-add.php': 'MEDIA',
        'photo-edit.php': 'MEDIA',

        'video-category.php': 'MEDIA',
        'video-category-add.php': 'MEDIA',
        'video-category-edit.php': 'MEDIA',

        'video.php': 'MEDIA',
        'video-add.php': 'MEDIA',
        'video-edit.php': 'MEDIA',

        'file.php': 'MEDIA',
        'file-add.php': 'MEDIA',
        'file-edit.php': 'MEDIA',

        'social-media.php': 'AUDIENCE',

        'subscriber.php': 'AUDIENCE',
        'subscriber-delete.php': 'AUDIENCE',
        'subscriber-remove.php': 'AUDIENCE',
        'subscriber-csv.php': 'AUDIENCE',
        'subscriber-email.php': 'AUDIENCE',

        'settings.php': 'SETTINGS'
    };

    const breadcrumbMap = {
        'designation.php': 'Award',
        'designation-add.php': 'Award',
        'designation-edit.php': 'Award',

        'team-member.php': 'Award',
        'team-member-add.php': 'Award',
        'team-member-edit.php': 'Award',

        'category.php': 'News',
        'category-add.php': 'News',
        'category-edit.php': 'News',
        'category-delete.php': 'News',

        'news.php': 'News',
        'news-add.php': 'News',
        'news-edit.php': 'News',
        'news-delete.php': 'News',

        'comment.php': 'News',

        'faq-category.php': 'FAQ',
        'faq-category-add.php': 'FAQ',
        'faq-category-edit.php': 'FAQ',
        'faq-category-delete.php': 'FAQ',

        'faq.php': 'FAQ',
        'faq-add.php': 'FAQ',
        'faq-edit.php': 'FAQ',
        'faq-delete.php': 'FAQ',

        'photo-category.php': 'Photo and Video',
        'photo-category-add.php': 'Photo and Video',
        'photo-category-edit.php': 'Photo and Video',

        'photo.php': 'Photo and Video',
        'photo-add.php': 'Photo and Video',
        'photo-edit.php': 'Photo and Video',

        'video-category.php': 'Photo and Video',
        'video-category-add.php': 'Photo and Video',
        'video-category-edit.php': 'Photo and Video',

        'video.php': 'Photo and Video',
        'video-add.php': 'Photo and Video',
        'video-edit.php': 'Photo and Video',

        'subscriber.php': 'Subscriber',
        'subscriber-email.php': 'Subscriber',

        'branch-info.php': 'Outlet',
        'branch-info-add.php': 'Outlet',
        'branch-info-edit.php': 'Outlet',

        'branch-videos.php': 'Outlet',
        'branch-videos-add.php': 'Outlet',
        'branch-videos-edit.php': 'Outlet',

        'branch-tenants.php': 'Outlet',
        'branch-tenants-add.php': 'Outlet',
        'branch-tenants-edit.php': 'Outlet',

        'branch-katalog.php': 'Outlet',
        'branch-katalog-add.php': 'Outlet',
        'branch-katalog-edit.php': 'Outlet',

        'branch-facilities.php': 'Outlet',
        'branch-facilities-add.php': 'Outlet',
        'branch-facilities-edit.php': 'Outlet',

        'branch-galleries.php': 'Outlet',
        'branch-galleries-add.php': 'Outlet',
        'branch-galleries-edit.php': 'Outlet',

        'branch-promo.php': 'Outlet',
        'branch-promo-add.php': 'Outlet',
        'branch-promo-edit.php': 'Outlet',

        'program.php': 'Prize Draw',
        'program-add.php': 'Prize Draw',
        'program-edit.php': 'Prize Draw',

        'periode.php': 'Prize Draw',
        'periode-add.php': 'Prize Draw',
        'periode-edit.php': 'Prize Draw',

        'reward.php': 'Prize Draw',
        'reward-add.php': 'Prize Draw',
        'reward-edit.php': 'Prize Draw',

        'winners.php': 'Prize Draw',
        'winners-add.php': 'Prize Draw',
        'winners-edit.php': 'Prize Draw',

        'sponsor.php': 'Prize Draw',
        'sponsor-add.php': 'Prize Draw',
        'sponsor-edit.php': 'Prize Draw'
    };

    const currentPage = window.location.pathname.split('/').pop();

    const section = sectionMap[currentPage] || '';
    const parent = breadcrumbMap[currentPage] || '';

    if (section) {
        const sectionElement = document.createElement('div');

        sectionElement.className = 'auto-page-section';
        sectionElement.textContent = section;

        headerLeft.insertBefore(sectionElement, title);
    }

    if (parent) {
        const breadcrumb = document.createElement('div');

        breadcrumb.className = 'auto-breadcrumb';
        breadcrumb.textContent = parent + ' > ' + title.textContent.trim();

        headerLeft.appendChild(breadcrumb);
    }
});
</script>


<script>
    $(document).ready(function() {
        // Memaksa scrollbar sidebar kembali ke paling atas
        $('.main-sidebar, .sidebar').scrollTop(0);
    });
</script>


<body class="hold-transition fixed skin-yellow sidebar-mini">

	<div class="wrapper">

		<header class="main-header">
			<a href="index.php" class="logo">
				<span class="logo-lg">Manna Kampus</span>
			</a>

			<nav class="navbar navbar-static-top">
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<span style="float:left;line-height:50px;color:#fff;padding-left:15px;font-size:18px;">Admin Panel</span>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="../assets/uploads/<?php echo $_SESSION['user']['photo']; ?>" class="user-image" alt="User Image">
								<span class="hidden-xs"><?php echo 'Admin'; ?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-footer">
									<div>
										<a href="profile-edit.php" class="btn btn-default btn-flat">Edit Profile</a>
									</div>
									<div>
										<a href="logout.php" class="btn btn-default btn-flat">Log out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<aside class="main-sidebar">
				<section class="sidebar">
					<ul class="sidebar-menu">
						<li class="treeview <?php if($cur_page == 'index.php') {echo 'active';} ?>">
							<a href="index.php">
								<i class="fa fa-hand-o-right"></i> <span>Dashboard</span>
							</a>
						</li>

						<li class="header">WEBSITE</li>

						<li class="treeview <?php if( ($cur_page == 'page-add.php')||($cur_page == 'page.php')||($cur_page == 'page-edit.php') ) {echo 'active';} ?>">
							<a href="page.php">
								<i class="fa fa-hand-o-right"></i> <span>Page</span>
							</a>
						</li>

						<li class="treeview <?php if( ($cur_page == 'menu-add.php')||($cur_page == 'menu.php')||($cur_page == 'menu-edit.php') ) {echo 'active';} ?>">
							<a href="menu.php">
								<i class="fa fa-hand-o-right"></i> <span>Menu</span>
							</a>
						</li>

						<li class="treeview <?php if( ($cur_page == 'language.php') ) {echo 'active';} ?>">
							<a href="language.php">
								<i class="fa fa-hand-o-right"></i> <span>Language</span>
							</a>
						</li>

						<li class="header">CONTENT</li>

						<li class="treeview <?php echo $is_news_active ? 'active menu-open' : ''; ?>">
							<a href="#">
								<i class="fa fa-hand-o-right"></i>
								<span>News</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu" style="<?php echo $is_news_active ? 'display:block;' : ''; ?>">
								<li class="<?php echo in_array($cur_page, $news_category_pages) ? 'active' : ''; ?>">
									<a href="category.php"><i class="fa fa-circle-o"></i> Category</a>
								</li>
								<li class="<?php echo in_array($cur_page, $news_content_pages) ? 'active' : ''; ?>">
									<a href="news.php"><i class="fa fa-circle-o"></i> News</a>
								</li>
							</ul>
						</li>

						<li class="treeview <?php if( ($cur_page == 'promo-event-add.php')||($cur_page == 'promo-event.php')||($cur_page == 'promo-event-edit.php') ) {echo 'active';} ?>">
							<a href="promo-event.php">
								<i class="fa fa-calendar"></i> <span>Promo &amp; Event Utama</span>
							</a>
						</li>

						<li class="treeview <?php echo $is_award_active ? 'active menu-open' : ''; ?>">
							<a href="#">
								<i class="fa fa-hand-o-right"></i>
								<span>Award</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu" style="<?php echo $is_award_active ? 'display:block;' : ''; ?>">
								<li class="<?php echo in_array($cur_page, $award_category_pages) ? 'active' : ''; ?>">
									<a href="designation.php"><i class="fa fa-circle-o"></i> Categories</a>
								</li>
								<li class="<?php echo in_array($cur_page, $award_award_pages) ? 'active' : ''; ?>">
									<a href="team-member.php"><i class="fa fa-circle-o"></i> Award Data</a>
								</li>
							</ul>
						</li>

						<li class="treeview <?php echo $is_prize_draw_active ? 'active menu-open' : ''; ?>">
							<a href="#">
								<i class="fa fa-hand-o-right"></i>
								<span>Prize Draw</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu" style="<?php echo $is_prize_draw_active ? 'display:block;' : ''; ?>">
								<li class="<?php echo in_array($cur_page, $prize_draw_program_pages) ? 'active' : ''; ?>">
									<a href="program.php"><i class="fa fa-circle-o"></i> Program</a>
								</li>
								<li class="<?php echo in_array($cur_page, $prize_draw_periode_pages) ? 'active' : ''; ?>">
									<a href="periode.php"><i class="fa fa-circle-o"></i> Periode</a>
								</li>
								<li class="<?php echo in_array($cur_page, $prize_draw_reward_pages) ? 'active' : ''; ?>">
									<a href="reward.php"><i class="fa fa-circle-o"></i> Reward</a>
								</li>
								<li class="<?php echo in_array($cur_page, $prize_draw_winners_pages) ? 'active' : ''; ?>">
									<a href="winners.php"><i class="fa fa-circle-o"></i> Winners</a>
								</li>
								<li class="<?php echo in_array($cur_page, $prize_draw_sponsor_pages) ? 'active' : ''; ?>">
									<a href="sponsor.php"><i class="fa fa-circle-o"></i> Sponsor</a>
								</li>
							</ul>
						</li>

						<li class="treeview <?php if( ($cur_page == 'testimonial-add.php')||($cur_page == 'testimonial.php')||($cur_page == 'testimonial-edit.php') ) {echo 'active';} ?>">
							<a href="testimonial.php">
								<i class="fa fa-hand-o-right"></i> <span>Testimonial</span>
							</a>
						</li>

						<li class="treeview <?php if( ($cur_page == 'partner-add.php')||($cur_page == 'partner.php')||($cur_page == 'partner-edit.php') ) {echo 'active';} ?>">
							<a href="partner.php">
								<i class="fa fa-hand-o-right"></i> <span>Partner</span>
							</a>
						</li>

						<li class="treeview <?php if( ($cur_page == 'service-add.php')||($cur_page == 'service.php')||($cur_page == 'service-edit.php') ) {echo 'active';} ?>">
							<a href="service.php">
								<i class="fa fa-hand-o-right"></i> <span>Service</span>
							</a>
						</li>

						<li class="treeview <?php echo $is_faq_active ? 'active menu-open' : ''; ?>">
							<a href="#">
								<i class="fa fa-hand-o-right"></i>
								<span>FAQ</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu" style="<?php echo $is_faq_active ? 'display:block;' : ''; ?>">
								<li class="<?php echo in_array($cur_page, $faq_category_pages) ? 'active' : ''; ?>">
									<a href="faq-category.php"><i class="fa fa-circle-o"></i> FAQ Category</a>
								</li>
								<li class="<?php echo in_array($cur_page, $faq_pages) ? 'active' : ''; ?>">
									<a href="faq.php"><i class="fa fa-circle-o"></i> FAQ</a>
								</li>
							</ul>
						</li>

						<li class="treeview <?php echo $is_outlet_active ? 'active menu-open' : ''; ?>">
							<a href="#">
								<i class="fa fa-hand-o-right"></i>
								<span>Outlet</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu" style="<?php echo $is_outlet_active ? 'display:block;' : ''; ?>">
								<li class="<?php echo in_array($cur_page, $branch_info_pages) ? 'active' : ''; ?>">
									<a href="branch-info.php"><i class="fa fa-circle-o"></i> Branch Information</a>
								</li>
								<li class="<?php echo in_array($cur_page, $branch_videos_pages) ? 'active' : ''; ?>">
									<a href="branch-videos.php"><i class="fa fa-circle-o"></i> Branch Videos</a>
								</li>
								<li class="<?php echo in_array($cur_page, $branch_tenants_pages) ? 'active' : ''; ?>">
									<a href="branch-tenants.php"><i class="fa fa-circle-o"></i> Branch Tenants</a>
								</li>
								<li class="<?php echo in_array($cur_page, $branch_promo_pages) ? 'active' : ''; ?>">
									<a href="branch-promo.php"><i class="fa fa-circle-o"></i> Branch Promo</a>
								</li>
								<li class="<?php echo in_array($cur_page, $branch_katalog_pages) ? 'active' : ''; ?>">
									<a href="branch-katalog.php"><i class="fa fa-circle-o"></i> Branch Katalog</a>
								</li>
								<li class="<?php echo in_array($cur_page, $branch_facilities_pages) ? 'active' : ''; ?>">
									<a href="branch-facilities.php"><i class="fa fa-circle-o"></i> Branch Facilities</a>
								</li>
								<li class="<?php echo in_array($cur_page, $branch_galleries_pages) ? 'active' : ''; ?>">
									<a href="branch-galleries.php"><i class="fa fa-circle-o"></i> Branch Galleries</a>
								</li>
							</ul>
						</li>

						<li class="header">MEDIA</li>

						<li class="treeview <?php if( ($cur_page == 'slider-add.php')||($cur_page == 'slider.php')||($cur_page == 'slider-edit.php') ) {echo 'active';} ?>">
							<a href="slider.php">
								<i class="fa fa-hand-o-right"></i> <span>Slider</span>
							</a>
						</li>

						<li class="treeview <?php echo $is_photo_video_active ? 'active menu-open' : ''; ?>">
							<a href="#">
								<i class="fa fa-hand-o-right"></i>
								<span>Photo and Video</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu" style="<?php echo $is_photo_video_active ? 'display:block;' : ''; ?>">
								<li class="<?php echo in_array($cur_page, $photo_category_pages) ? 'active' : ''; ?>"><a href="photo-category.php"><i class="fa fa-circle-o"></i> Photo Category</a></li>
								<li class="<?php echo in_array($cur_page, $photo_gallery_pages) ? 'active' : ''; ?>"><a href="photo.php"><i class="fa fa-circle-o"></i> Photo Gallery</a></li>
								<li class="<?php echo in_array($cur_page, $video_category_pages) ? 'active' : ''; ?>"><a href="video-category.php"><i class="fa fa-circle-o"></i> Video Category</a></li>
								<li class="<?php echo in_array($cur_page, $video_pages) ? 'active' : ''; ?>"><a href="video.php"><i class="fa fa-circle-o"></i> Video</a></li>
							</ul>
						</li>

						<li class="treeview <?php if( ($cur_page == 'file-add.php')||($cur_page == 'file.php')||($cur_page == 'file-edit.php') ) {echo 'active';} ?>">
							<a href="file.php">
								<i class="fa fa-hand-o-right"></i> <span>File Upload (Media)</span>
							</a>
						</li>

						<li class="header">AUDIENCE</li>

						<li class="treeview <?php if( ($cur_page == 'social-media.php') ) {echo 'active';} ?>">
							<a href="social-media.php">
								<i class="fa fa-hand-o-right"></i> <span>Social Media</span>
							</a>
						</li>

						<li class="treeview <?php echo $is_subscriber_active ? 'active menu-open' : ''; ?>">
							<a href="#">
								<i class="fa fa-hand-o-right"></i>
								<span>Subscriber</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu" style="<?php echo $is_subscriber_active ? 'display:block;' : ''; ?>">
								<li class="<?php echo in_array($cur_page, $subscriber_list_pages) ? 'active' : ''; ?>"><a href="subscriber.php"><i class="fa fa-circle-o"></i> All Subscribers</a></li>
								<li class="<?php echo in_array($cur_page, $subscriber_email_pages) ? 'active' : ''; ?>"><a href="subscriber-email.php"><i class="fa fa-circle-o"></i> Email to Subscribers</a></li>
							</ul>
						</li>

						<li class="header">SETTINGS</li>

						<li class="treeview <?php if( ($cur_page == 'settings.php') ) {echo 'active';} ?>">
							<a href="settings.php">
								<i class="fa fa-hand-o-right"></i> <span>Settings</span>
							</a>
						</li>
					</ul>
				</section>
		</aside>

		<div class="content-wrapper">
			<?php if($flash_success_message !== ''): ?>
			<div id="admin-success-toast" class="alert alert-success alert-dismissible admin-success-toast">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?php echo htmlspecialchars($flash_success_message, ENT_QUOTES, 'UTF-8'); ?>
			</div>
			<script>setTimeout(function(){ var toast = document.getElementById('admin-success-toast'); if(toast) { toast.style.display = 'none'; } }, 5000);</script>
			<?php endif; ?>