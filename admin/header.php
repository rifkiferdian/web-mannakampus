<?php
ob_start();
session_start();
include("config.php");
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// echo "<pre>". print_r($_SESSION,1) ."</pre>"; die();

require '../assets/mail/PHPMailer.php';
require '../assets/mail/Exception.php';
$mail = new PHPMailer\PHPMailer\PHPMailer();

// Check if the user is logged in or not
if(!isset($_SESSION['user'])) {
	header('location: login.php');
	exit;
}

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

// Getting data from the website settings table
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$receive_email = $row['receive_email'];
}

// Current Page Access Level check for all pages
$cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

// Cek apakah halaman sekarang termasuk salah satu "keluarga" Outlet
$is_outlet_active = in_array($cur_page, $outlet_pages);
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
	<!-- Font Awesome 6.x CDN -->
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


</head>

<body class="hold-transition fixed skin-yellow sidebar-mini">

	<div class="wrapper">

		<header class="main-header">

			<a href="index.php" class="logo">
				<span class="logo-lg">Consultine</span>
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

  		<?php $cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); ?>

  		<aside class="main-sidebar">

  			<?php if ($_SESSION['user']['role'] == 'News'): ?>
  				<section class="sidebar">
      
      			<ul class="sidebar-menu">

			        <li class="treeview <?php if($cur_page == 'index.php') {echo 'active';} ?>">
			          <a href="index.php">
			            <i class="fa fa-hand-o-right"></i> <span>Dashboard</span>
			          </a>
			        </li>
		        	
		        	<li class="treeview <?php if( ($cur_page == 'slider-add.php')||($cur_page == 'slider.php')||($cur_page == 'slider-edit.php') ) {echo 'active';} ?>">
			          <a href="slider.php">
			            <i class="fa fa-hand-o-right"></i> <span>Slider</span>
			          </a>
			        </li>

					<li class="treeview <?php if( ($cur_page == 'promo-event-add.php')||($cur_page == 'promo-event.php')||($cur_page == 'promo-event-edit.php') ) {echo 'active';} ?>">
			          <a href="promo-event.php">
			            <i class="fa fa-calendar"></i> <span>Promo &amp; Event Utama</span>
			          </a>
			        </li>

					<li class="treeview <?php if( ($cur_page == 'category-add.php')||($cur_page == 'category.php')||($cur_page == 'category-edit.php') || ($cur_page == 'news-add.php')||($cur_page == 'news.php')||($cur_page == 'news-edit.php') || ($cur_page == 'comment.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-hand-o-right"></i>
							<span>News</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="category.php"><i class="fa fa-circle-o"></i> Category</a></li>
							<li><a href="news.php"><i class="fa fa-circle-o"></i> News</a></li>
							<li><a href="comment.php"><i class="fa fa-circle-o"></i> Comment</a></li>
						</ul>
					</li>

					<li class="treeview <?php if( ($cur_page == 'file-add.php')||($cur_page == 'file.php')||($cur_page == 'file-edit.php') ) {echo 'active';} ?>">
			          <a href="file.php">
			            <i class="fa fa-hand-o-right"></i> <span>File Upload (Media)</span>
			          </a>
			        </li>

       
      			</ul>
    		</section>

  			<?php else: ?>
  			

    		<section class="sidebar">
      
      			<ul class="sidebar-menu">

			        <li class="treeview <?php if($cur_page == 'index.php') {echo 'active';} ?>">
			          <a href="index.php">
			            <i class="fa fa-hand-o-right"></i> <span>Dashboard</span>
			          </a>
			        </li>

					

			        <li class="treeview <?php if( ($cur_page == 'settings.php') ) {echo 'active';} ?>">
			          <a href="settings.php">
			            <i class="fa fa-hand-o-right"></i> <span>Settings</span>
			          </a>
			        </li>



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
			        

					<li class="treeview <?php if( ($cur_page == 'category-add.php')||($cur_page == 'category.php')||($cur_page == 'category-edit.php') || ($cur_page == 'news-add.php')||($cur_page == 'news.php')||($cur_page == 'news-edit.php') || ($cur_page == 'comment.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-hand-o-right"></i>
							<span>News</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="category.php"><i class="fa fa-circle-o"></i> Category</a></li>
							<li><a href="news.php"><i class="fa fa-circle-o"></i> News</a></li>
							<li><a href="comment.php"><i class="fa fa-circle-o"></i> Comment</a></li>
						</ul>
					</li>

										

					<li class="treeview <?php if( ($cur_page == 'designation-add.php')||($cur_page == 'designation.php')||($cur_page == 'designation-edit.php') || ($cur_page == 'team-member-add.php')||($cur_page == 'team-member.php')||($cur_page == 'team-member-edit.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-hand-o-right"></i>
							<span>Penghargaan MannaKampus</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="designation.php"><i class="fa fa-circle-o"></i> Kategori Penghargaan</a></li>
							<li><a href="team-member.php"><i class="fa fa-circle-o"></i> Data Penghargaan</a></li>
						</ul>
					</li>

					
					<li class="treeview <?php if( ($cur_page == 'slider-add.php')||($cur_page == 'slider.php')||($cur_page == 'slider-edit.php') ) {echo 'active';} ?>">
			          <a href="slider.php">
			            <i class="fa fa-hand-o-right"></i> <span>Slider</span>
			          </a>
			        </li>

					<li class="treeview <?php if( ($cur_page == 'promo-event-add.php')||($cur_page == 'promo-event.php')||($cur_page == 'promo-event-edit.php') ) {echo 'active';} ?>">
			          <a href="promo-event.php">
			            <i class="fa fa-calendar"></i> <span>Promo &amp; Event Utama</span>
			          </a>
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
					


					<li class="treeview <?php if( ($cur_page == 'faq-category-add.php')||($cur_page == 'faq-category.php')||($cur_page == 'faq-category-edit.php') || ($cur_page == 'faq-add.php')||($cur_page == 'faq.php')||($cur_page == 'faq-edit.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-hand-o-right"></i>
							<span>FAQ</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="faq-category.php"><i class="fa fa-circle-o"></i> FAQ Category</a></li>
							<li><a href="faq.php"><i class="fa fa-circle-o"></i> FAQ</a></li>
						</ul>
					</li>


			        <li class="treeview <?php if( ($cur_page == 'photo-category-add.php')||($cur_page == 'photo-category.php')||($cur_page == 'photo-category-edit.php') || ($cur_page == 'photo-add.php')||($cur_page == 'photo.php')||($cur_page == 'photo-edit.php') || ($cur_page == 'video-category-add.php')||($cur_page == 'video-category.php')||($cur_page == 'video-category-edit.php') || ($cur_page == 'video-add.php')||($cur_page == 'video.php')||($cur_page == 'video-edit.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-hand-o-right"></i>
							<span>Photo and Video</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="photo-category.php"><i class="fa fa-circle-o"></i> Photo Category</a></li>
							<li><a href="photo.php"><i class="fa fa-circle-o"></i> Photo Gallery</a></li>
							<li><a href="video-category.php"><i class="fa fa-circle-o"></i> Video Category</a></li>
							<li><a href="video.php"><i class="fa fa-circle-o"></i> Video</a></li>
						</ul>
					</li>

					
					


					<li class="treeview <?php if( ($cur_page == 'file-add.php')||($cur_page == 'file.php')||($cur_page == 'file-edit.php') ) {echo 'active';} ?>">
			          <a href="file.php">
			            <i class="fa fa-hand-o-right"></i> <span>File Upload (Media)</span>
			          </a>
			        </li>


					
			        <li class="treeview <?php if( ($cur_page == 'social-media.php') ) {echo 'active';} ?>">
			          <a href="social-media.php">
			            <i class="fa fa-hand-o-right"></i> <span>Social Media</span>
			          </a>
			        </li>

			        <li class="treeview <?php if( ($cur_page == 'subscriber.php')||($cur_page == 'subscriber-email.php') ) {echo 'active';} ?>">
						<a href="#">
							<i class="fa fa-hand-o-right"></i>
							<span>Subscriber</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li><a href="subscriber.php"><i class="fa fa-circle-o"></i> All Subscribers</a></li>
							<li><a href="subscriber-email.php"><i class="fa fa-circle-o"></i> Email to Subscribers</a></li>
						</ul>
					</li>


					<?php $is_outlet_active = in_array($cur_page, $outlet_pages); ?>
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
								<a href="branch-info.php"> <i class="fa fa-circle-o"></i> Branch Information</a>
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
      			</ul>
    		</section>

    		<?php endif ?>

  		</aside>

  		<div class="content-wrapper">