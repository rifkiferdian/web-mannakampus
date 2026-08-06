<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$total_recent_news_home_page = $row['total_recent_news_home_page'];
	$home_title_service          = $row['home_title_service'];
	$home_subtitle_service       = $row['home_subtitle_service'];
	$home_status_service         = $row['home_status_service'];
	$home_title_team_member      = $row['home_title_team_member'];
	$home_subtitle_team_member   = $row['home_subtitle_team_member'];
	$home_status_team_member     = $row['home_status_team_member'];
	$home_title_testimonial      = $row['home_title_testimonial'];
	$home_subtitle_testimonial   = $row['home_subtitle_testimonial'];
	$home_photo_testimonial      = $row['home_photo_testimonial'];
	$home_status_testimonial     = $row['home_status_testimonial'];
	$home_title_news             = $row['home_title_news'];
	$home_subtitle_news          = $row['home_subtitle_news'];
	$home_status_news            = $row['home_status_news'];
	$home_title_partner          = $row['home_title_partner'];
	$home_subtitle_partner       = $row['home_subtitle_partner'];
	$home_status_partner         = $row['home_status_partner'];
	$counter_1_title             = $row['counter_1_title'];
    $counter_1_value             = $row['counter_1_value'];
    $counter_2_title             = $row['counter_2_title'];
    $counter_2_value             = $row['counter_2_value'];
    $counter_3_title             = $row['counter_3_title'];
    $counter_3_value             = $row['counter_3_value'];
    $counter_4_title             = $row['counter_4_title'];
    $counter_4_value             = $row['counter_4_value'];
    $counter_photo               = $row['counter_photo'];
    $counter_status              = $row['counter_status'];
}

$statement = $pdo->prepare("SELECT photo, heading, content, button_text, button_url, position
							FROM tbl_slider
							WHERE status=?
							ORDER BY id ASC");
$statement->execute(array('Active'));
$home_sliders = $statement->fetchAll(PDO::FETCH_ASSOC);

if(!$home_sliders) {
	$home_sliders = array(
		array(
			'photo'       => 'manna-hero-market.png',
			'heading'     => 'Rumah Belanja Terpercaya',
			'content'     => 'Serving the community since 1985 with premium quality goods, professional service, and the warmest shopping experience in town.',
			'button_text' => 'Shop Now',
			'button_url'  => '#',
			'position'    => 'Left'
		)
	);
}

$statement = $pdo->prepare("SELECT *
							FROM tbl_promo_event
							WHERE status=? AND is_featured=1 AND end_date>=CURDATE() AND type<>?
							ORDER BY display_order ASC, start_date ASC, id DESC");
$statement->execute(array('Active', 'Promo Pembayaran'));
$home_promo_events = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $pdo->prepare("SELECT *
							FROM tbl_promo_event
							WHERE status=? AND is_featured=1 AND end_date>=CURDATE() AND type=?
							ORDER BY display_order ASC, start_date ASC, id DESC");
$statement->execute(array('Active', 'Promo Pembayaran'));
$home_payment_promos = $statement->fetchAll(PDO::FETCH_ASSOC);

function home_promo_event_url($url, $slug) {
	$url = trim($url);
	if($url === '') {
		return BASE_URL.'promo-event/'.rawurlencode($slug);
	}
	if(preg_match('#^(?:https?:)?//#i', $url) || substr($url, 0, 1) === '#' || substr($url, 0, 1) === '/') {
		return $url;
	}
	return BASE_URL.ltrim($url, '/');
}

function home_promo_event_date($start_date, $end_date) {
	$months = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	$start = new DateTime($start_date);
	$end = new DateTime($end_date);
	if($start_date === $end_date) {
		return $start->format('j').' '.$months[(int)$start->format('n')].' '.$start->format('Y');
	}
	if($start->format('Y') === $end->format('Y')) {
		return $start->format('j').' '.$months[(int)$start->format('n')].' – '.$end->format('j').' '.$months[(int)$end->format('n')].' '.$end->format('Y');
	}
	return $start->format('j').' '.$months[(int)$start->format('n')].' '.$start->format('Y').' – '.$end->format('j').' '.$months[(int)$end->format('n')].' '.$end->format('Y');
}
?>

<!-- Hero Start -->
<div id="home-hero-slider" class="carousel slide carousel-fade mk-hero-carousel" data-ride="carousel" data-interval="6000">
	<?php if(count($home_sliders) > 1): ?>
	<ol class="carousel-indicators">
		<?php foreach ($home_sliders as $slider_index => $slider): ?>
		<li data-target="#home-hero-slider" data-slide-to="<?php echo $slider_index; ?>"<?php if($slider_index == 0) { echo ' class="active"'; } ?>></li>
		<?php endforeach; ?>
	</ol>
	<?php endif; ?>

	<div class="carousel-inner" role="listbox">
		<?php foreach ($home_sliders as $slider_index => $slider): ?>
		<?php
		$slider_position = in_array($slider['position'], array('Left', 'Center', 'Right')) ? strtolower($slider['position']) : 'left';
		$heading_words = preg_split('/\s+/u', trim($slider['heading']));
		$heading_highlight = '';
		if($heading_words && $heading_words[0] !== '') {
			$heading_highlight = array_pop($heading_words);
		}
		?>
		<section class="item hero-section mk-hero mk-hero-position-<?php echo $slider_position; ?><?php if($slider_index == 0) { echo ' active'; } ?>">
			<div class="hero-background" style="background-image:url('<?php echo htmlspecialchars(BASE_URL.'assets/uploads/'.$slider['photo'], ENT_QUOTES, 'UTF-8'); ?>');"></div>
			<div class="hero-overlay"></div>
			<div class="container">
				<div class="hero-content">
					<div class="hero-eyebrow">Trusted For Generations</div>

					<?php if($heading_highlight !== ''): ?>
					<h1>
						<?php echo htmlspecialchars(implode(' ', $heading_words), ENT_QUOTES, 'UTF-8'); ?>
						<span><?php echo htmlspecialchars($heading_highlight, ENT_QUOTES, 'UTF-8'); ?></span>
					</h1>
					<?php endif; ?>

					<?php if(trim($slider['content']) !== ''): ?>
					<p><?php echo nl2br(htmlspecialchars($slider['content'], ENT_QUOTES, 'UTF-8')); ?></p>
					<?php endif; ?>

					<?php if(trim($slider['button_text']) !== ''): ?>
					<div class="hero-actions">
						<a href="<?php echo htmlspecialchars($slider['button_url'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-flat hero-btn-primary"><?php echo htmlspecialchars($slider['button_text'], ENT_QUOTES, 'UTF-8'); ?></a>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php endforeach; ?>
	</div>

	<?php if(count($home_sliders) > 1): ?>
	<a class="left carousel-control" href="#home-hero-slider" role="button" data-slide="prev">
		<i class="fa fa-angle-left" aria-hidden="true"></i>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#home-hero-slider" role="button" data-slide="next">
		<i class="fa fa-angle-right" aria-hidden="true"></i>
		<span class="sr-only">Next</span>
	</a>
	<?php endif; ?>
</div>
<!-- Hero End -->

<?php if($home_promo_events): ?>
<!-- Promo & Event Start -->
<section class="promo-events" id="promo-events">
	<img class="promo-event-decoration promo-event-decoration-left" src="<?php echo BASE_URL; ?>assets/images/promo-event-shopper-left.webp" alt="" aria-hidden="true">
	<img class="promo-event-decoration promo-event-decoration-right" src="<?php echo BASE_URL; ?>assets/images/promo-event-shopper-right.webp" alt="" aria-hidden="true">
	<div class="container">
		<div class="promo-events-head">
			<div>
				<span class="promo-events-eyebrow">Jangan Lewatkan</span>
				<h2>Promo &amp; Event Utama</h2>
				<p>Temukan program spesial dan kabar terbaru dari Manna Kampus.</p>
			</div>
		</div>

		<div id="promo-event-carousel" class="carousel promo-event-carousel promo-event-instant" data-ride="carousel" data-interval="9000">
			<div class="carousel-inner" role="listbox">
				<?php foreach($home_promo_events as $promo_index => $promo_event): ?>
				<?php $promo_url = home_promo_event_url($promo_event['button_url'], $promo_event['slug']); ?>
				<article class="item<?php if($promo_index === 0) { echo ' active'; } ?>">
					<div class="promo-event-card">
						<a href="<?php echo htmlspecialchars($promo_url, ENT_QUOTES, 'UTF-8'); ?>" class="promo-event-visual" aria-label="<?php echo htmlspecialchars($promo_event['title'], ENT_QUOTES, 'UTF-8'); ?>">
							<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo htmlspecialchars($promo_event['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($promo_event['title'], ENT_QUOTES, 'UTF-8'); ?>">
						</a>
						<div class="promo-event-info">
							<div class="promo-event-copy">
								<span class="promo-event-type"><?php echo htmlspecialchars($promo_event['type'], ENT_QUOTES, 'UTF-8'); ?></span>
								<h3><?php echo htmlspecialchars($promo_event['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
								<p><?php echo htmlspecialchars($promo_event['short_description'], ENT_QUOTES, 'UTF-8'); ?></p>
								<div class="promo-event-meta">
									<span><i class="fa fa-calendar"></i> <?php echo home_promo_event_date($promo_event['start_date'], $promo_event['end_date']); ?></span>
									<?php if(trim($promo_event['location']) !== ''): ?>
									<span><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($promo_event['location'], ENT_QUOTES, 'UTF-8'); ?></span>
									<?php endif; ?>
								</div>
							</div>
							<a href="<?php echo htmlspecialchars($promo_url, ENT_QUOTES, 'UTF-8'); ?>" class="promo-event-button">
								<?php echo htmlspecialchars($promo_event['button_text'], ENT_QUOTES, 'UTF-8'); ?> <i class="fa fa-arrow-right"></i>
							</a>
						</div>
					</div>
				</article>
				<?php endforeach; ?>
			</div>

			<?php if(count($home_promo_events) > 1): ?>
			<div class="promo-event-navigation">
				<div class="promo-event-progress">
					<div class="promo-event-counter">
						<strong class="promo-event-current">01</strong>
						<span>/</span>
						<span><?php echo str_pad(count($home_promo_events), 2, '0', STR_PAD_LEFT); ?></span>
					</div>
					<ol class="carousel-indicators">
						<?php foreach($home_promo_events as $promo_index => $promo_event): ?>
						<li data-target="#promo-event-carousel" data-slide-to="<?php echo $promo_index; ?>" aria-label="Tampilkan promo <?php echo $promo_index + 1; ?>"<?php if($promo_index === 0) { echo ' class="active"'; } ?>></li>
						<?php endforeach; ?>
					</ol>
				</div>
				<div class="promo-event-arrows">
					<a href="#promo-event-carousel" role="button" data-slide="prev" aria-label="Promo sebelumnya"><i class="fa fa-angle-left"></i></a>
					<a href="#promo-event-carousel" role="button" data-slide="next" aria-label="Promo berikutnya"><i class="fa fa-angle-right"></i></a>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<!-- Promo & Event End -->
<?php endif; ?>

<?php if($home_payment_promos): ?>
<!-- Payment Promo Start -->
<section class="payment-promos" id="payment-promos">
	<div class="container">
		<div class="payment-promos-head">
			<h2>Promo Pembayaran</h2>
		</div>

		<div class="payment-promo-carousel owl-carousel">
			<?php foreach($home_payment_promos as $payment_promo): ?>
			<article class="payment-promo-card">
				<a class="payment-promo-image payment-promo-image-popup" href="<?php echo BASE_URL; ?>assets/uploads/<?php echo htmlspecialchars($payment_promo['image'], ENT_QUOTES, 'UTF-8'); ?>" aria-label="Perbesar <?php echo htmlspecialchars($payment_promo['title'], ENT_QUOTES, 'UTF-8'); ?>">
					<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo htmlspecialchars($payment_promo['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($payment_promo['title'], ENT_QUOTES, 'UTF-8'); ?>">
					<span class="payment-promo-zoom"><i class="fa fa-search-plus"></i></span>
				</a>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<!-- Payment Promo End -->
<?php endif; ?>

<!-- Weekly Offers Start -->
<section class="weekly-offers">
	<div class="container">
		<div class="weekly-offers-head">
			<div>
				<h2>Weekly Special Offers</h2>
				<p>Don't miss out on our curated selection of deals.</p>
			</div>
			<a href="<?php echo BASE_URL.URL_SEARCH; ?>" class="weekly-offers-link">View All Deals <i class="fa fa-arrow-right"></i></a>
		</div>

		<div class="weekly-offers-grid">
			<a href="<?php echo BASE_URL.URL_SEARCH; ?>" class="offer-card offer-card-featured" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads/promo-fresh-harvest.png);">
				<div class="offer-shade"></div>
				<div class="offer-copy">
					<span class="offer-badge">Fresh Harvest</span>
					<h3>Morning Pick: Up to 30% Off</h3>
					<p>Organic fruits directly from local farmers.</p>
				</div>
			</a>

			<div class="weekly-offers-side">
				<a href="<?php echo BASE_URL.URL_SEARCH; ?>" class="offer-card offer-card-wide" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads/promo-dairy-delights.png);">
					<div class="offer-copy offer-copy-dark">
						<h3>Dairy Delights</h3>
						<p>Buy 2 Get 1 Free on select brands</p>
					</div>
				</a>

				<div class="weekly-offers-small">
					<a href="<?php echo BASE_URL.URL_SEARCH; ?>" class="offer-card offer-card-solid">
						<i class="fa fa-tags"></i>
						<div class="offer-copy">
							<h3>Member Day</h3>
							<p>Double Points Today!</p>
						</div>
					</a>

					<a href="<?php echo BASE_URL.URL_SEARCH; ?>" class="offer-card offer-card-small-image" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads/promo-home-care.png);">
						<span>Home Care</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Weekly Offers End -->


<?php if($home_status_service == 'Show'): ?>
<!-- Service Start -->
<section class="service-v1">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading wow fadeInUp">
					<h2><?php echo $home_title_service; ?></h2>
					<p><?php echo $home_subtitle_service; ?></p>
				</div>
			</div>
		</div>
		<div class="row">
			<?php
			$statement = $pdo->prepare("SELECT * FROM tbl_service ORDER BY id ASC");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			$service_icons = array(
				'ultimate-trust' => 'fa-shield',
				'premium-quality' => 'fa-certificate',
				'convenience' => 'fa-shopping-basket'
			);
			foreach ($result as $row) {
				$icon_class = isset($service_icons[$row['slug']]) ? $service_icons[$row['slug']] : 'fa-check-circle-o';
				?>
				<div class="col-sm-6 col-md-4 ser-item wow fadeInUp">
					<div class="item">
						<div class="service-icon" aria-hidden="true">
							<i class="fa <?php echo $icon_class; ?>"></i>
						</div>
						<div class="text">
							<h3><a href="<?php echo BASE_URL.URL_SERVICE.$row['slug']; ?>"><?php echo $row['name']; ?></a></h3>
							<p>
								<?php echo $row['short_description']; ?>
							</p>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</section>
<!-- Service End -->
<?php endif; ?>



<?php if($home_status_team_member == 'Show'): ?>
<!-- Penghargaan MannaKampus Start -->
<section class="team-member-v1">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading wow fadeInUp">
					<h2><?php echo $home_title_team_member; ?></h2>
					<p><?php echo $home_subtitle_team_member; ?></p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				
				<!-- Penghargaan Carousel Start -->
				<div class="team-member-carousel">
					<?php
					$statement = $pdo->prepare("SELECT 
												
												t1.id,
												t1.name,
												t1.slug,
												t1.designation_id,
												t1.photo,
												t1.facebook,
												t1.twitter,
												t1.linkedin,
												t1.youtube,
												t1.google_plus,
												t1.instagram,
												t1.flickr,

												t2.designation_id,
												t2.designation_name

					                           FROM tbl_team_member t1
					                           JOIN tbl_designation t2
					                           ON t1.designation_id = t2.designation_id
					                           WHERE t1.status = ?
					                           ");
					$statement->execute(array('Active'));
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
					foreach ($result as $row) {
						?>
						<div class="item wow fadeInUp">
							<div class="thumb">
								<div class="photo" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>);"></div>
								<div class="overlay"></div>
								<div class="social-icons">
									<ul>
										<?php if($row['facebook']!=''): ?>
											<li><a href="<?php echo $row['facebook']; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
										<?php endif; ?>

										<?php if($row['twitter']!=''): ?>
											<li><a href="<?php echo $row['twitter']; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
										<?php endif; ?>

										<?php if($row['linkedin']!=''): ?>
											<li><a href="<?php echo $row['linkedin']; ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
										<?php endif; ?>

										<?php if($row['youtube']!=''): ?>
											<li><a href="<?php echo $row['youtube']; ?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
										<?php endif; ?>

										<?php if($row['google_plus']!=''): ?>
											<li><a href="<?php echo $row['google_plus']; ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
										<?php endif; ?>

										<?php if($row['instagram']!=''): ?>
											<li><a href="<?php echo $row['instagram']; ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
										<?php endif; ?>

										<?php if($row['flickr']!=''): ?>
											<li><a href="<?php echo $row['flickr']; ?>" target="_blank"><i class="fa fa-flickr"></i></a></li>
										<?php endif; ?>
									</ul>
								</div>
							</div>
							<div class="text">
								<h3><a href="<?php echo BASE_URL.URL_TEAM.$row['slug']; ?>"><?php echo $row['name']; ?></a></h3>
								<p><?php echo $row['designation_name']; ?></p>
							</div>
						</div>
						<?php
					}
					?>					
				</div>
				<!-- Penghargaan Carousel End -->

			</div>
		</div>
	</div>
</section>
<!-- Penghargaan MannaKampus End -->
<?php endif; ?>



<?php if($counter_status == 'Show'): ?>
<div class="why-us" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads/<?php echo $counter_photo; ?>);">
	<div class="overlay"></div>
	<div class="container">
		<div class="row why-us-counter">
			<div class="col-md-3">
				<div class="counter"><?php echo $counter_1_value; ?></div>
				<div class="title"><?php echo $counter_1_title; ?></div>
			</div>
			<div class="col-md-3">
				<div class="counter"><?php echo $counter_2_value; ?></div>
				<div class="title"><?php echo $counter_2_title; ?></div>
			</div>
			<div class="col-md-3">
				<div class="counter"><?php echo $counter_3_value; ?></div>
				<div class="title"><?php echo $counter_3_title; ?></div>
			</div>
			<div class="col-md-3">
				<div class="counter"><?php echo $counter_4_value; ?></div>
				<div class="title"><?php echo $counter_4_title; ?></div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>



<?php if($home_status_news == 'Show'): ?>
<!-- News Start -->
<section class="news-v1">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading wow fadeInUp">
					<h2><?php echo $home_title_news; ?></h2>
					<p><?php echo $home_subtitle_news; ?></p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				
				<!-- News Carousel Start -->
				<div class="news-carousel">

					<?php
					$i=0;
					$statement = $pdo->prepare("SELECT * FROM tbl_news ORDER BY news_id DESC");
					$statement->execute();
					$result = $statement->fetchAll();							
					foreach ($result as $row) {
						$i++;
						if($i>$total_recent_news_home_page) {break;}
						?>
						<div class="item wow fadeInUp">
							<div class="thumb">
								<div class="photo" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>);"></div>
							</div>
							<div class="text">
								<h3><a href="<?php echo BASE_URL.URL_NEWS.$row['news_slug']; ?>"><?php echo $row['news_title']; ?></a></h3>
								<?php echo $row['news_content_short']; ?>
							</div>
						</div>
						<?php
					}
					?>
					
				</div>
				<!-- News Carousel End -->

			</div>
		</div>
	</div>
</section>
<!-- News End -->
<?php endif; ?>





<?php if($home_status_testimonial == 'Show'): ?>
<!-- Testimonial Start -->
<section class="testimonial-v1" style="background-image:url(<?php echo BASE_URL; ?>assets/uploads/<?php echo $home_photo_testimonial; ?>);">
	<div class="overlay"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading">
					<h2><?php echo $home_title_testimonial; ?></h2>
					<p><?php echo $home_subtitle_testimonial; ?></p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				
				<!-- Testimonial Carousel Start -->
				<div class="testimonial-carousel">
					<?php
					$statement = $pdo->prepare("SELECT * FROM tbl_testimonial ORDER BY id ASC");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
					foreach ($result as $row) {
						?>
						<div class="item">
							<div class="testimonial-wrapper">								
								<div class="content">									
									<div class="author">
										<div class="photo">
											<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['name']; ?>">
										</div>
										<div class="text">
											<h3><?php echo $row['name']; ?></h3>
											<h4><?php echo $row['designation']; ?> 
											<?php if($row['company']!=''): ?>
											<span>(<?php echo $row['company']; ?>)</span>
											<?php endif; ?>
											</h4>
										</div>
									</div>	
									<div class="comment">
										<p>
											<?php echo nl2br($row['comment']); ?>
										</p>
										<div class="icon"></div>
									</div>									
								</div>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<!-- Testimonial Carousel End -->

			</div>
		</div>
	</div>
</section>
<!-- Testimonial End -->
<?php endif; ?>


	


<?php if($home_status_partner == 'Show'): ?>
<!-- Partner Start -->
<section class="partner-v1">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading">
					<h2><?php echo $home_title_partner; ?></h2>
					<p><?php echo $home_subtitle_partner; ?></p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="partner-carousel">
					<?php
					$statement = $pdo->prepare("SELECT * FROM tbl_partner ORDER BY id ASC");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
					foreach ($result as $row) {
						?>
						<div class="item">
							<div class="inner">
								<?php if($row['url']==''): ?>
									<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['name']; ?>">
								<?php else: ?>
									<a href="<?php echo $row['url']; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['name']; ?>"></a>
								<?php endif; ?>
								
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Partner End -->
<?php endif; ?>

<?php require_once('footer.php'); ?>
