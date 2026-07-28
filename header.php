<?php
ob_start();
session_start();
include("admin/config.php");
include("admin/functions.php");
include("admin/inc/language_data.php");

require 'assets/mail/PHPMailer.php';
require 'assets/mail/Exception.php';
$mail = new PHPMailer\PHPMailer\PHPMailer();
							
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=?");
$statement->execute(array(1));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$mod_rewrite = $row['mod_rewrite'];
	$color = $row['color'];
}
$color = 'ff7a00';
if($mod_rewrite == 'Off') {
	define("URL_CATEGORY", "category.php?slug=");
	define("URL_PAGE", "page.php?slug=");
	define("URL_NEWS", "news.php?slug=");
	define("URL_SERVICE", "service.php?slug=");
	define("URL_TEAM", "team-member.php?slug=");
	define("URL_SEARCH", "search.php");
} else {
	define("URL_CATEGORY", "category/");
	define("URL_PAGE", "page/");
	define("URL_NEWS", "news/");
	define("URL_SERVICE", "service/");
	define("URL_TEAM", "team-member/");
	define("URL_SEARCH", "search");
}
?>
<?php
// Getting the basic data for the website from database
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
	$logo = $row['logo'];
	$favicon = $row['favicon'];
	$contact_email = $row['contact_email'];
	$contact_phone = $row['contact_phone'];
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>

	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-L1HKGJE7GT"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-L1HKGJE7GT');
	</script>

	<!-- Meta Tags -->	
	<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>


	<!-- Showing the SEO related meta tags data -->
	<?php
	
	// Getting the current page URL
	$cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

	if($cur_page == 'news.php')
	{
		$statement = $pdo->prepare("SELECT * FROM tbl_news WHERE news_slug=?");
		$statement->execute(array($_REQUEST['slug']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) 
		{
		    $og_photo = $row['photo'];
		    $og_title = $row['news_title'];
		    $og_slug = $row['news_slug'];
			$og_description = substr(strip_tags($row['news_content']),0,200).'...';
			echo '<meta name="description" content="'.$row['meta_description'].'">';
			echo '<meta name="keywords" content="'.$row['meta_keyword'].'">';
			echo '<title>'.$row['meta_title'].'</title>';
		}
	}

	if($cur_page == 'page.php')
	{
		$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE page_slug=?");
		$statement->execute(array($_REQUEST['slug']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) 
		{
			echo '<meta name="description" content="'.$row['meta_description'].'">';
			echo '<meta name="keywords" content="'.$row['meta_keyword'].'">';
			echo '<title>'.$row['meta_title'].'</title>';
		}
	}

	if($cur_page == 'promo-event.php')
	{
		$statement = $pdo->prepare("SELECT * FROM tbl_promo_event WHERE slug=? AND status=?");
		$statement->execute(array(isset($_REQUEST['slug']) ? $_REQUEST['slug'] : '', 'Active'));
		$row = $statement->fetch(PDO::FETCH_ASSOC);
		if($row)
		{
			echo '<meta name="description" content="'.htmlspecialchars($row['short_description'], ENT_QUOTES, 'UTF-8').'">';
			echo '<title>'.htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8').' - Manna Kampus</title>';
			echo '<meta property="og:title" content="'.htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8').'">';
			echo '<meta property="og:description" content="'.htmlspecialchars($row['short_description'], ENT_QUOTES, 'UTF-8').'">';
			echo '<meta property="og:image" content="'.BASE_URL.'assets/uploads/'.rawurlencode($row['image']).'">';
		}
	}

	if($cur_page == 'category.php')
	{
		$statement = $pdo->prepare("SELECT * FROM tbl_category WHERE category_slug=?");
		$statement->execute(array($_REQUEST['slug']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row)
		{
			echo '<meta name="description" content="'.$row['meta_description'].'">';
			echo '<meta name="keywords" content="'.$row['meta_keyword'].'">';
			echo '<title>'.$row['meta_title'].'</title>';
		}
	}

	if($cur_page == 'index.php')
	{
		$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) 
		{
			echo '<meta name="description" content="'.$row['meta_description_home'].'">';
			echo '<meta name="keywords" content="'.$row['meta_keyword_home'].'">';
			echo '<title>'.$row['meta_title_home'].'</title>';
		}
	}
	
	if($cur_page == 'team-member.php')
	{
		$statement = $pdo->prepare("SELECT * FROM tbl_team_member WHERE slug=?");
		$statement->execute(array($_REQUEST['slug']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) 
		{
			echo '<meta name="description" content="'.$row['meta_description'].'">';
			echo '<meta name="keywords" content="'.$row['meta_keyword'].'">';
			echo '<title>'.$row['meta_title'].'</title>';
		}
	}
	
	if($cur_page == 'service.php')
	{
		$statement = $pdo->prepare("SELECT * FROM tbl_service WHERE slug=?");
		$statement->execute(array($_REQUEST['slug']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) 
		{
			echo '<meta name="description" content="'.$row['meta_description'].'">';
			echo '<meta name="keywords" content="'.$row['meta_keyword'].'">';
			echo '<title>'.$row['meta_title'].'</title>';
		}
	}
	?>

	<!-- Favicon -->
	<link href="<?php echo BASE_URL; ?>assets/uploads/<?php echo $favicon; ?>" rel="shortcut icon" type="image/png">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/slicknav.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/superfish.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/animate.css">
	
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/jquery.bxslider.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/hover.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/magnific-popup.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css?v=mk-home-20260728-6">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/responsive.css?v=mk-home-20260711-17">

	<script src="<?php echo BASE_URL; ?>assets/js/modernizr.min.js"></script>

	<?php if($cur_page == 'news.php'): ?>
		<meta property="og:title" content="<?php echo $og_title; ?>">
		<meta property="og:type" content="website">
		<meta property="og:url" content="<?php echo BASE_URL.URL_NEWS.$og_slug; ?>">
		<meta property="og:description" content="<?php echo $og_description; ?>">
		<meta property="og:image" content="<?php echo BASE_URL; ?>assets/uploads/<?php echo $og_photo; ?>">
	<?php endif; ?>

	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/cookieconsent.min.css">
	<script src="<?php echo BASE_URL; ?>assets/js/cookieconsent.min.js"></script>
	
	
	<style>
		.top-bar,
		.sf-menu li li:hover,
		.slider p.button a,
		.team-member-v1 .text,
		.why-us .overlay,
		.team-member-v1 .owl-controls .owl-prev:hover, 
		.team-member-v1 .owl-controls .owl-next:hover,
		.news-v1 .owl-controls .owl-prev:hover, 
		.news-v1 .owl-controls .owl-next:hover,
		.testimonial-v1 .overlay,
		.newsletter-area .overlay,
		.footer-col h3:after,
		.scrollup i,
		.page-banner .overlay,
		.team-member-v3 .text p.button a,
		.team-member-detail .contact .icon,
		.team-member-detail .team-member-single .social ul li a,
		ul.gallery-menu li.filter.active,
		ul.gallery-menu li:hover,
		.gallery .inner .icons-inner a,
		.widget h4,
		.widget-search button,
		.blog p.button a:hover,
		.contact-v1 .cform-1 .btn-success {
			background: #<?php echo $color; ?>!important;
		}

		.sf-menu li a,
		.service-v1 .heading h2,
		.service-v1 .text h3 a,
		.team-member-v1 .heading h2,
		.news-v1 .heading h2,
		.news-v1 .text h3 a,
		.testimonial-v1 .owl-controls .owl-prev, 
		.testimonial-v1 .owl-controls .owl-next,
		.partner-v1 .heading h2,
		.team-member-v3 .text h3 a,
		.team-member-detail .team-member-single .text p,
		.team-member-detail .team-member-detail-tab .nav-tabs>li>a,
		ul.gallery-menu li,
		.widget ul li a:hover,
		.blog .text ul.status li a,
		.blog .text ul.status li,
		.blog h3 a:hover,
		.heading-normal h2 {
			color: #<?php echo $color; ?>!important;	
		}

		ul.gallery-menu li.filter.active,
		ul.gallery-menu li:hover,
		.widget-search input:focus,
		.widget-search button,
		.form-control:focus,
		.contact-v1 .cform-1 .btn-success {
			border-color: #<?php echo $color; ?>!important;		
		}

		.heading-normal h2 {
			border-bottom-color: #<?php echo $color; ?>!important;			
		}

		.slider p.button a:hover,
		.team-member-v1 .text:hover,
		.team-member-v3 .text p.button a:hover,
		.team-member-detail .team-member-single .social ul li a:hover,
		.gallery .inner .icons-inner a:hover,
		.contact-v1 .cform-1 .btn-success:hover {
			background: #333!important;
		}

		.news-v1 .text h3 a:hover {
			color: #333!important;	
		}

		.contact-v1 .cform-1 .btn-success:hover {
			border-color: #333!important;
		}

		ul.gallery-menu li.filter.active,
		ul.gallery-menu li:hover {
			color: #fff!important;
		}

		.top-bar,
		.slider p.button a,
		.team-member-v1 .text,
		.why-us .overlay,
		.testimonial-v1 .overlay,
		.newsletter-area .overlay,
		.scrollup i,
		.page-banner .overlay,
		.team-member-v3 .text p.button a,
		.team-member-detail .contact .icon,
		.team-member-detail .team-member-single .social ul li a,
		ul.gallery-menu li.filter.active,
		ul.gallery-menu li:hover,
		.gallery .inner .icons-inner a,
		.widget h4,
		.widget-search button,
		.blog p.button a:hover,
		.contact-v1 .cform-1 .btn-success {
			background: linear-gradient(135deg, #ff9f1c 0%, #ff7a00 52%, #ff5c00 100%)!important;
		}

		.slider p.button a:hover,
		.team-member-v1 .text:hover,
		.team-member-v3 .text p.button a:hover,
		.team-member-detail .team-member-single .social ul li a:hover,
		.gallery .inner .icons-inner a:hover,
		.contact-v1 .cform-1 .btn-success:hover,
		.scrollup i:hover {
			background: linear-gradient(135deg, #ff5c00 0%, #d94800 100%)!important;
		}

		.sf-menu > li > a {
			color: #1f2933!important;
		}

		.sf-menu > li:first-child > a,
		.sf-menu > li > a:hover,
		.sf-menu > li.sfHover > a {
			color: #c05c00!important;
		}

		.sf-menu li li a,
		.sf-menu li:hover li a {
			color: #1f2933!important;
		}

		.sf-menu li li:hover a {
			color: #ff7a00!important;
		}
	
		.cc-banner.cc-bottom {
			z-index: 999999!important;
		}

		html,
		body {
			background-color: #fff!important;
			background-image: none!important;
		}
		#preloader,
		#status,
		.top-bar,
		.cc-window,
		.cc-revoke,
		.whatsapp-float,
		.st-sticky-share-buttons,
		.st-sticky-share-buttons *,
		#st-1,
		#st-2,
		.st-btn,
		.st-total {
			display: none!important;
		}
		.page-wrapper {
			width: 100%!important;
			max-width: none!important;
			margin: 0!important;
			border-radius: 0!important;
			background: #f5f5f3!important;
			overflow: visible!important;
		}
		.mk-topbar {
			position: -webkit-sticky!important;
			position: sticky!important;
			top: 0!important;
			width: 100%!important;
			background: #e86600!important;
			color: #fff!important;
			font-size: 13px!important;
			line-height: 1!important;
			z-index: 1100!important;
		}
		.mk-topbar .container {
			width: 100%!important;
			max-width: 1180px!important;
			margin-left: auto!important;
			margin-right: auto!important;
			padding-left: 28px!important;
			padding-right: 28px!important;
		}
		.mk-topbar-inner {
			min-height: 46px!important;
			display: flex!important;
			align-items: center!important;
			justify-content: space-between!important;
			gap: 20px!important;
		}
		.mk-topbar-left {
			display: flex!important;
			align-items: center!important;
			gap: 28px!important;
		}
		.mk-topbar-contact {
			display: flex!important;
			align-items: center!important;
			gap: 22px!important;
			min-width: 0!important;
		}
		.mk-topbar-contact span,
		.mk-topbar-right {
			display: inline-flex!important;
			align-items: center!important;
			gap: 7px!important;
			white-space: nowrap!important;
		}
		.mk-topbar i {
			color: #fff!important;
			font-size: 13px!important;
		}
		.mk-topbar a,
		.mk-topbar a:hover,
		.mk-topbar a:focus {
			color: #fff!important;
			text-decoration: none!important;
			font-weight: 600!important;
		}
		.mk-topbar-link,
		.mk-topbar-link:hover,
		.mk-topbar-link:focus {
			color: #fff!important;
			font-weight: 700!important;
			text-decoration: none!important;
		}
		.mk-topbar-menu {
			position: relative!important;
			display: inline-flex!important;
			align-items: center!important;
			min-height: 46px!important;
		}
		.mk-topbar-menu-trigger {
			display: inline-flex!important;
			align-items: center!important;
			gap: 7px!important;
			height: 46px!important;
		}
		.mk-topbar-menu.has-dropdown .mk-topbar-menu-trigger:after {
			content: "\f107"!important;
			font-family: "FontAwesome"!important;
			font-size: 12px!important;
			line-height: 1!important;
		}
		.mk-topbar-dropdown {
			position: absolute!important;
			top: 100%!important;
			left: 0!important;
			right: auto!important;
			display: none!important;
			min-width: 210px!important;
			padding: 8px!important;
			background: #fff!important;
			border: 1px solid rgba(15,23,42,0.08)!important;
			border-radius: 6px!important;
			box-shadow: 0 18px 45px rgba(15,23,42,0.16)!important;
			z-index: 9999!important;
		}
		.mk-topbar-dropdown:before {
			content: ""!important;
			position: absolute!important;
			top: -7px!important;
			left: 18px!important;
			width: 14px!important;
			height: 14px!important;
			background: #fff!important;
			border-left: 1px solid rgba(15,23,42,0.08)!important;
			border-top: 1px solid rgba(15,23,42,0.08)!important;
			transform: rotate(45deg)!important;
		}
		.mk-topbar-menu:hover .mk-topbar-dropdown,
		.mk-topbar-menu:focus-within .mk-topbar-dropdown,
		.mk-topbar-menu.is-open .mk-topbar-dropdown {
			display: block!important;
		}
		.mk-topbar-menu.is-open .mk-topbar-menu-trigger:after {
			-webkit-transform: rotate(180deg)!important;
			transform: rotate(180deg)!important;
		}
		.mk-topbar-dropdown a,
		.mk-topbar-dropdown a:hover,
		.mk-topbar-dropdown a:focus {
			display: block!important;
			padding: 10px 12px!important;
			border-radius: 4px!important;
			color: #1f2933!important;
			font-size: 13px!important;
			font-weight: 700!important;
			text-decoration: none!important;
			white-space: nowrap!important;
		}
		.mk-topbar-dropdown a:hover {
			background: #fff4e8!important;
			color: #ff7a00!important;
		}
		.mk-topbar-right {
			font-weight: 600!important;
			gap: 14px!important;
		}
		.mk-topbar-lang {
			display: inline-flex!important;
			align-items: center!important;
			gap: 7px!important;
		}
		.mk-topbar-button,
		.mk-topbar-button:hover,
		.mk-topbar-button:focus {
			display: inline-flex!important;
			align-items: center!important;
			justify-content: center!important;
			gap: 7px!important;
			min-height: 26px!important;
			padding: 0 12px!important;
			border: 1px solid #fff!important;
			border-radius: 4px!important;
			background: #fff!important;
			color: #d95f00!important;
			font-size: 12px!important;
			font-weight: 800!important;
			line-height: 1!important;
			text-decoration: none!important;
			white-space: nowrap!important;
			opacity: 1!important;
			text-shadow: none!important;
		}
		.mk-topbar .mk-topbar-button,
		.mk-topbar .mk-topbar-button:hover,
		.mk-topbar .mk-topbar-button:focus {
			color: #d95f00!important;
		}
		.mk-topbar-button i {
			display: inline-block!important;
			color: #d95f00!important;
			font-size: 13px!important;
			line-height: 1!important;
			opacity: 1!important;
		}
		.mk-topbar-button:hover {
			background: #fff7ef!important;
			color: #b84f00!important;
		}
		.mk-topbar-button:hover i {
			color: #b84f00!important;
		}
		.mk-header,
		.mk-header.sticky {
			position: -webkit-sticky!important;
			position: sticky!important;
			top: 46px!important;
			left: auto!important;
			width: 100%!important;
			height: 72px!important;
			min-height: 72px!important;
			background: #fff!important;
			border: 0!important;
			border-radius: 0!important;
			box-shadow: 0 4px 18px rgba(15,23,42,0.08)!important;
			z-index: 1000!important;
		}
		.mk-header .container,
		.mk-hero .container {
			width: 100%!important;
			max-width: 1180px!important;
			margin-left: auto!important;
			margin-right: auto!important;
		}
		.mk-header .container {
			position: relative!important;
			padding-left: 28px!important;
			padding-right: 28px!important;
		}
		.mk-navbar {
			height: 72px!important;
			display: flex!important;
			align-items: center!important;
			justify-content: space-between!important;
			gap: 28px!important;
		}
		.mk-brand,
		.mk-brand:hover,
		.mk-brand:focus {
			color: #ff7a00!important;
			font-size: 24px!important;
			font-weight: 800!important;
			line-height: 1!important;
			text-decoration: none!important;
			white-space: nowrap!important;
		}
		.mk-brand img {
			display: block!important;
			width: auto!important;
			max-width: 180px!important;
			max-height: 48px!important;
			object-fit: contain!important;
		}
		.mk-mobile-menu {
			display: none!important;
		}
		.mk-nav {
			display: flex!important;
			align-items: center!important;
			justify-content: flex-end!important;
			gap: 26px!important;
			flex: 1!important;
		}
		.mk-nav a,
		.mk-nav a:hover,
		.mk-nav a:focus {
			position: relative!important;
			color: #1f2933!important;
			font-size: 14px!important;
			font-weight: 600!important;
			line-height: 72px!important;
			text-decoration: none!important;
			white-space: nowrap!important;
		}
		.mk-nav a.active,
		.mk-nav a:hover {
			color: #b95a00!important;
		}
		.mk-nav a.active:after,
		.mk-nav a:hover:after {
			content: ""!important;
			position: absolute!important;
			left: 0!important;
			right: 0!important;
			bottom: 20px!important;
			height: 2px!important;
			background: #ff7a00!important;
		}
		.mk-hero {
			position: relative!important;
			min-height: 560px!important;
			height: 560px!important;
			overflow: hidden!important;
		}
		.mk-hero-carousel {
			position: relative!important;
			background: #f5f5f3!important;
		}
		.mk-hero-carousel .carousel-inner {
			height: 560px!important;
		}
		.mk-hero-carousel.carousel-fade .carousel-inner .item {
			left: 0!important;
			opacity: 0;
			-webkit-transform: translate3d(0, 0, 0)!important;
			transform: translate3d(0, 0, 0)!important;
			-webkit-transition: opacity 0.9s ease-in-out!important;
			transition: opacity 0.9s ease-in-out!important;
		}
		.mk-hero-carousel.carousel-fade .carousel-inner .active,
		.mk-hero-carousel.carousel-fade .carousel-inner .next.left,
		.mk-hero-carousel.carousel-fade .carousel-inner .prev.right {
			opacity: 1;
		}
		.mk-hero-carousel.carousel-fade .carousel-inner .active.left,
		.mk-hero-carousel.carousel-fade .carousel-inner .active.right {
			opacity: 0;
		}
		.mk-hero .hero-background {
			position: absolute!important;
			inset: -2%!important;
			background-repeat: no-repeat!important;
			background-size: cover!important;
			background-position: center center!important;
			-webkit-transform: scale(1)!important;
			transform: scale(1)!important;
			will-change: transform!important;
		}
		.mk-hero-carousel .item.active .hero-background {
			-webkit-animation: mkHeroBackgroundZoom 6.8s ease-out both;
			animation: mkHeroBackgroundZoom 6.8s ease-out both;
		}
		@-webkit-keyframes mkHeroBackgroundZoom {
			from { -webkit-transform: scale(1); transform: scale(1); }
			to { -webkit-transform: scale(1.07); transform: scale(1.07); }
		}
		@keyframes mkHeroBackgroundZoom {
			from { -webkit-transform: scale(1); transform: scale(1); }
			to { -webkit-transform: scale(1.07); transform: scale(1.07); }
		}
		.mk-hero-carousel .carousel-control {
			width: 58px!important;
			background: none!important;
			opacity: 1!important;
			text-shadow: none!important;
			z-index: 10!important;
		}
		.mk-hero-carousel .carousel-control i {
			position: absolute!important;
			top: 50%!important;
			left: 50%!important;
			width: 42px!important;
			height: 42px!important;
			margin: -21px 0 0 -21px!important;
			border-radius: 50%!important;
			background: rgba(255,255,255,0.92)!important;
			color: #d95f00!important;
			font-size: 28px!important;
			line-height: 42px!important;
			box-shadow: 0 8px 24px rgba(15,23,42,0.15)!important;
		}
		.mk-hero-carousel .carousel-indicators {
			bottom: 18px!important;
			z-index: 12!important;
		}
		.mk-hero-carousel .carousel-indicators li {
			width: 10px!important;
			height: 10px!important;
			margin: 0 4px!important;
			border-color: #ff7a00!important;
			background: #fff!important;
		}
		.mk-hero-carousel .carousel-indicators li.active {
			background: #ff7a00!important;
		}
		.mk-hero .hero-overlay {
			position: absolute!important;
			inset: 0!important;
			background: linear-gradient(90deg, rgba(255,255,255,0.74) 0%, rgba(255,255,255,0.58) 42%, rgba(255,255,255,0.1) 100%)!important;
		}
		.mk-hero-position-center .hero-overlay {
			background: rgba(255,255,255,0.58)!important;
		}
		.mk-hero-position-right .hero-overlay {
			background: linear-gradient(270deg, rgba(255,255,255,0.78) 0%, rgba(255,255,255,0.6) 42%, rgba(255,255,255,0.08) 100%)!important;
		}
		.mk-hero .container {
			position: relative!important;
			z-index: 2!important;
			min-height: 560px!important;
			display: flex!important;
			align-items: center!important;
			padding-left: 28px!important;
			padding-right: 28px!important;
		}
		.mk-hero-position-center .container {
			justify-content: center!important;
		}
		.mk-hero-position-right .container {
			justify-content: flex-end!important;
		}
		.mk-hero .hero-content {
			width: 500px!important;
			min-width: 0!important;
		}
		.mk-hero-position-center .hero-content {
			text-align: center!important;
		}
		.mk-hero-position-right .hero-content {
			text-align: right!important;
		}
		.mk-hero-position-center .hero-content p,
		.mk-hero-position-right .hero-content p {
			margin-left: auto!important;
			margin-right: auto!important;
		}
		.mk-hero-position-right .hero-content p {
			margin-right: 0!important;
		}
		.mk-hero-position-center .hero-actions {
			justify-content: center!important;
		}
		.mk-hero-position-right .hero-actions {
			justify-content: flex-end!important;
		}
		.mk-hero-carousel .item .hero-eyebrow,
		.mk-hero-carousel .item .hero-content h1,
		.mk-hero-carousel .item .hero-content > p,
		.mk-hero-carousel .item .hero-actions {
			opacity: 0;
		}
		.mk-hero-carousel .item.active:not(.left):not(.right) .hero-eyebrow,
		.mk-hero-carousel .item.active:not(.left):not(.right) .hero-content h1,
		.mk-hero-carousel .item.active:not(.left):not(.right) .hero-content > p,
		.mk-hero-carousel .item.active:not(.left):not(.right) .hero-actions {
			-webkit-animation: mkHeroTextIn 0.75s cubic-bezier(0.22, 1, 0.36, 1) both;
			animation: mkHeroTextIn 0.75s cubic-bezier(0.22, 1, 0.36, 1) both;
		}
		.mk-hero-carousel .item.active:not(.left):not(.right) .hero-eyebrow {
			-webkit-animation-delay: 0.12s;
			animation-delay: 0.12s;
		}
		.mk-hero-carousel .item.active:not(.left):not(.right) .hero-content h1 {
			-webkit-animation-delay: 0.25s;
			animation-delay: 0.25s;
		}
		.mk-hero-carousel .item.active:not(.left):not(.right) .hero-content > p {
			-webkit-animation-delay: 0.38s;
			animation-delay: 0.38s;
		}
		.mk-hero-carousel .item.active:not(.left):not(.right) .hero-actions {
			-webkit-animation-delay: 0.51s;
			animation-delay: 0.51s;
		}
		@-webkit-keyframes mkHeroTextIn {
			from {
				opacity: 0;
				-webkit-transform: translateY(28px);
				transform: translateY(28px);
			}
			to {
				opacity: 1;
				-webkit-transform: translateY(0);
				transform: translateY(0);
			}
		}
		@keyframes mkHeroTextIn {
			from {
				opacity: 0;
				-webkit-transform: translateY(28px);
				transform: translateY(28px);
			}
			to {
				opacity: 1;
				-webkit-transform: translateY(0);
				transform: translateY(0);
			}
		}
		.mk-hero .hero-eyebrow {
			display: inline-block!important;
			margin-bottom: 25px!important;
			padding: 7px 13px!important;
			border: 1px solid rgba(255,122,0,0.24)!important;
			border-radius: 10px!important;
			background: rgba(255,122,0,0.08)!important;
			color: #ff6f00!important;
			font-size: 14px!important;
			font-weight: 500!important;
			line-height: 1!important;
			letter-spacing: 1px!important;
			text-transform: uppercase!important;
		}
		.mk-hero .hero-content h1 {
			max-width: 470px!important;
			margin: 0 0 22px!important;
			color: #060606!important;
			font-size: 44px!important;
			line-height: 1.16!important;
			font-weight: 900!important;
		}
		.mk-hero .hero-content h1 span {
			display: block!important;
			color: #ff7a00!important;
		}
		.mk-hero .hero-content p {
			max-width: 500px!important;
			margin-bottom: 0!important;
			color: #334155!important;
			font-size: 16px!important;
			line-height: 1.6!important;
		}
		.mk-hero .hero-actions {
			display: flex!important;
			align-items: center!important;
			gap: 8px!important;
			margin-top: 22px!important;
		}
		.mk-hero .hero-actions .btn {
			width: 218px!important;
			min-width: 218px!important;
			height: 66px!important;
			padding: 0!important;
			border-radius: 4px!important;
			font-size: 15px!important;
			font-weight: 800!important;
			line-height: 66px!important;
			text-align: center!important;
			box-shadow: none!important;
		}
		.mk-hero .hero-btn-primary {
			background: #ff7a00!important;
			border-color: #ff7a00!important;
			color: #fff!important;
		}
		.mk-hero .hero-btn-secondary {
			background: #fff!important;
			border: 1px solid rgba(15,23,42,0.08)!important;
			color: #050505!important;
		}
		.mk-hero .hero-btn-secondary i {
			margin-left: 10px!important;
		}
		@media only screen and (max-width: 991px) {
			.mk-header,
			.mk-header.sticky {
				height: 72px!important;
				min-height: 72px!important;
			}
			.mk-navbar {
				position: relative!important;
				height: 72px!important;
				min-height: 72px!important;
				flex-wrap: nowrap!important;
				padding: 0!important;
			}
			.mk-nav-desktop {
				display: none!important;
			}
			.mk-mobile-menu {
				position: relative!important;
				display: block!important;
				margin-left: auto!important;
				z-index: 1001!important;
			}
			.mk-mobile-menu summary {
				display: flex!important;
				width: 44px!important;
				height: 44px!important;
				align-items: center!important;
				justify-content: center!important;
				border: 1px solid rgba(255,122,0,0.24)!important;
				border-radius: 6px!important;
				background: #fff7ef!important;
				color: #d95f00!important;
				font-size: 20px!important;
				cursor: pointer!important;
				list-style: none!important;
			}
			.mk-mobile-menu summary::-webkit-details-marker {
				display: none!important;
			}
			.mk-mobile-menu[open] summary .fa:before {
				content: "\f00d"!important;
			}
			.mk-mobile-nav {
				position: absolute!important;
				top: 58px!important;
				right: 0!important;
				display: flex!important;
				width: 320px!important;
				max-width: calc(100vw - 48px)!important;
				max-height: calc(100vh - 130px)!important;
				padding: 8px 18px 14px!important;
				flex-direction: column!important;
				overflow-y: auto!important;
				border-top: 2px solid #ff7a00!important;
				border-radius: 0 0 10px 10px!important;
				background: #fff!important;
				box-shadow: 0 18px 35px rgba(15,23,42,0.18)!important;
			}
			.mk-mobile-nav a {
				position: relative!important;
				display: block!important;
				min-height: 48px!important;
				padding: 0 8px!important;
				border-bottom: 1px solid rgba(15,23,42,0.07)!important;
				color: #1f2933!important;
				font-size: 14px!important;
				font-weight: 600!important;
				line-height: 48px!important;
				text-decoration: none!important;
			}
			.mk-mobile-nav a:last-child {
				border-bottom: 0!important;
			}
			.mk-mobile-nav a.active,
			.mk-mobile-nav a:hover {
				color: #b95a00!important;
			}
			.mk-mobile-nav a.active:before {
				content: ""!important;
				position: absolute!important;
				top: 13px!important;
				left: -10px!important;
				width: 3px!important;
				height: 22px!important;
				border-radius: 3px!important;
				background: #ff7a00!important;
			}
			.mk-hero,
			.mk-hero .container {
				min-height: 520px!important;
				height: auto!important;
			}
			.mk-hero-carousel .carousel-inner {
				height: 520px!important;
			}
			.mk-hero-carousel .carousel-control {
				width: 42px!important;
			}
		}
		@media only screen and (max-width: 640px) {
			.mk-header,
			.mk-header.sticky {
				top: 62px!important;
			}
			.mk-topbar-inner {
				min-height: 46px!important;
				justify-content: space-between!important;
				padding: 8px 0!important;
			}
			.mk-topbar-left {
				min-width: 0!important;
				gap: 10px!important;
				overflow: visible!important;
			}
			.mk-topbar-menu-trigger {
				gap: 4px!important;
				font-size: 12px!important;
			}
			.mk-topbar-menu.has-dropdown .mk-topbar-dropdown {
				display: none!important;
			}
			.mk-topbar-menu.has-dropdown.is-open .mk-topbar-dropdown {
				display: block!important;
			}
			.mk-topbar-menu:last-child .mk-topbar-dropdown {
				right: 0!important;
				left: auto!important;
			}
			.mk-topbar-menu:last-child .mk-topbar-dropdown:before {
				right: 18px!important;
				left: auto!important;
			}
			.mk-topbar-right {
				flex: 0 0 auto!important;
			}
			.mk-topbar-button,
			.mk-topbar-button:hover,
			.mk-topbar-button:focus {
				width: 36px!important;
				min-width: 36px!important;
				padding: 0!important;
				font-size: 0!important;
			}
			.mk-topbar-button i {
				margin: 0!important;
				font-size: 14px!important;
			}
			.page-wrapper,
			.mk-header {
				border-radius: 0!important;
			}
			.mk-header .container,
			.mk-hero .container {
				padding-left: 24px!important;
				padding-right: 24px!important;
			}
			.mk-brand {
				font-size: 20px!important;
			}
			.mk-hero .hero-content {
				width: 100%!important;
			}
			.mk-hero-position-right .hero-content {
				text-align: left!important;
			}
			.mk-hero-position-right .hero-content p {
				margin-left: 0!important;
			}
			.mk-hero-position-right .hero-actions {
				justify-content: flex-start!important;
			}
			.mk-hero .hero-content h1 {
				font-size: 34px!important;
			}
			.mk-hero .hero-actions {
				display: block!important;
			}
			.mk-hero .hero-actions .btn {
				width: 100%!important;
				min-width: 0!important;
				margin-bottom: 10px!important;
			}
		}
		@media (prefers-reduced-motion: reduce) {
			.mk-hero-carousel.carousel-fade .carousel-inner .item {
				-webkit-transition: none!important;
				transition: none!important;
			}
			.mk-hero-carousel .item.active .hero-background,
			.mk-hero-carousel .item.active .hero-eyebrow,
			.mk-hero-carousel .item.active .hero-content h1,
			.mk-hero-carousel .item.active .hero-content > p,
			.mk-hero-carousel .item.active .hero-actions {
				opacity: 1!important;
				-webkit-animation: none!important;
				animation: none!important;
			}
		}

		/* Keep Promo & Event banners at their final size during every carousel state. */
		#promo-event-carousel .carousel-inner > .item,
		#promo-event-carousel .carousel-inner > .item.active,
		#promo-event-carousel .carousel-inner > .item.next,
		#promo-event-carousel .carousel-inner > .item.prev,
		#promo-event-carousel .carousel-inner > .item.left,
		#promo-event-carousel .carousel-inner > .item.right {
			left: 0!important;
			opacity: 1!important;
			-webkit-transform: none!important;
			transform: none!important;
			-webkit-transition: none!important;
			transition: none!important;
		}
		#promo-event-carousel .promo-event-visual img {
			width: 100%!important;
			max-width: none!important;
			height: 100%!important;
			-webkit-transform: none!important;
			transform: none!important;
			-webkit-transition: none!important;
			transition: none!important;
		}

	</style>


</head>
<body>
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-L1HKGJE7GT"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-L1HKGJE7GT');
	</script>
<?php
// Getting Facebook comment code from the database
$statement = $pdo->prepare("SELECT * FROM tbl_comment WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) 
{
	echo $row['code_body'];
}
?>
	
	<div id="preloader">
		<div id="status"></div>
	</div>
	
	<div class="page-wrapper">
		
		<div class="mk-topbar">
			<div class="container">
					<div class="mk-topbar-inner">
					<div class="mk-topbar-left">
						<div class="mk-topbar-menu">
							<a href="#" class="mk-topbar-link mk-topbar-menu-trigger">MannaKampus</a>
						</div>
						<div class="mk-topbar-menu has-dropdown">
							<a href="#" class="mk-topbar-link mk-topbar-menu-trigger" role="button" aria-expanded="false">Mitra Bisnis</a>
							<div class="mk-topbar-dropdown">
								<a href="#">Tenant</a>
								<a href="#">Register New Supplier</a>
								<a href="#">B2B</a>
							</div>
						</div>
						<div class="mk-topbar-menu has-dropdown">
							<a href="#" class="mk-topbar-link mk-topbar-menu-trigger" role="button" aria-expanded="false">Our Brands</a>
							<div class="mk-topbar-dropdown">
								<a target="_blank" href="#">Lega Legi Kopi & Resto </a>
								<a target="_blank" href="#">ROEMI Xtraordinary Ice Cream</a>
								<a target="_blank" href="https://mannabakeryjogja.com/">Manna Bakery Jogja</a>
							</div>
						</div>
						
					</div>
					<div class="mk-topbar-right">
						<a href="mailto:<?php echo $contact_email; ?>" class="mk-topbar-button"><i class="fa fa-commenting-o"></i> Hubungi Kami</a>
					</div>
				</div>
			</div>
		</div>

		<!-- Header Start -->
		<header class="mk-header">
			<div class="container">
				<div class="mk-navbar">
					<a href="<?php echo BASE_URL; ?>" class="mk-brand"><img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $logo; ?>" alt="Manna Kampus"></a>
					<nav class="mk-nav mk-nav-desktop" aria-label="Navigasi utama">
						<a href="<?php echo BASE_URL; ?>" class="active">Homepage</a>
						<a href="#">About Us</a>
						<a href="<?php echo BASE_URL; ?>#promo-events">Promo</a>
						<a href="#">Blog</a>
						<a href="#">Corporate</a>
						<a href="#">Join Us</a>
						<a href="#">Career</a>
					</nav>
					<details class="mk-mobile-menu">
						<summary aria-label="Buka menu navigasi"><i class="fa fa-bars" aria-hidden="true"></i></summary>
						<nav class="mk-mobile-nav" aria-label="Navigasi utama mobile">
							<a href="<?php echo BASE_URL; ?>" class="active">Homepage</a>
							<a href="#">About Us</a>
							<a href="<?php echo BASE_URL; ?>#promo-events">Promo</a>
							<a href="#">Blog</a>
							<a href="#">Corporate</a>
							<a href="#">Join Us</a>
							<a href="#">Career</a>
						</nav>
					</details>
				</div>
			</div>
		</header>
		<script>
		(function() {
			var dropdownMenus = document.querySelectorAll('.mk-topbar-menu.has-dropdown');

			function closeTopbarDropdowns(exceptMenu) {
				for (var i = 0; i < dropdownMenus.length; i++) {
					if (dropdownMenus[i] !== exceptMenu) {
						dropdownMenus[i].classList.remove('is-open');
						dropdownMenus[i].querySelector('.mk-topbar-menu-trigger').setAttribute('aria-expanded', 'false');
					}
				}
			}

			for (var i = 0; i < dropdownMenus.length; i++) {
				(function(menu) {
					var trigger = menu.querySelector('.mk-topbar-menu-trigger');
					trigger.addEventListener('click', function(event) {
						event.preventDefault();
						var willOpen = !menu.classList.contains('is-open');
						closeTopbarDropdowns(menu);
						menu.classList.toggle('is-open', willOpen);
						trigger.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
					});
				})(dropdownMenus[i]);
			}

			document.addEventListener('click', function(event) {
				if (!event.target.closest('.mk-topbar-menu.has-dropdown')) {
					closeTopbarDropdowns();
				}
			});

			document.addEventListener('keydown', function(event) {
				if (event.key === 'Escape') {
					closeTopbarDropdowns();
				}
			});
		})();
		</script>
		<!-- Header End -->
