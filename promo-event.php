<?php require_once('header.php'); ?>

<?php
$slug = isset($_REQUEST['slug']) ? trim($_REQUEST['slug']) : '';
$statement = $pdo->prepare("SELECT * FROM tbl_promo_event WHERE slug=? AND status=?");
$statement->execute(array($slug, 'Active'));
$promo_event = $statement->fetch(PDO::FETCH_ASSOC);

if(!$promo_event) {
	header('location: '.BASE_URL);
	exit;
}

function promo_event_detail_date($start_date, $end_date) {
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

<main class="promo-event-detail">
	<div class="container">
		<article class="promo-event-detail-card">
			<img class="promo-event-detail-image" src="<?php echo BASE_URL; ?>assets/uploads/<?php echo htmlspecialchars($promo_event['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($promo_event['title'], ENT_QUOTES, 'UTF-8'); ?>">
			<div class="promo-event-detail-content">
				<span class="promo-event-type"><?php echo htmlspecialchars($promo_event['type'], ENT_QUOTES, 'UTF-8'); ?></span>
				<h1><?php echo htmlspecialchars($promo_event['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
				<p class="promo-event-detail-lead"><?php echo htmlspecialchars($promo_event['short_description'], ENT_QUOTES, 'UTF-8'); ?></p>

				<div class="promo-event-detail-meta">
					<span><i class="fa fa-calendar"></i><?php echo promo_event_detail_date($promo_event['start_date'], $promo_event['end_date']); ?></span>
					<?php if(trim($promo_event['location']) !== ''): ?>
					<span><i class="fa fa-map-marker"></i><?php echo htmlspecialchars($promo_event['location'], ENT_QUOTES, 'UTF-8'); ?></span>
					<?php endif; ?>
				</div>

				<div class="promo-event-detail-body">
					<?php echo $promo_event['content']; ?>
				</div>

				<a href="<?php echo BASE_URL; ?>#promo-events" class="promo-event-back"><i class="fa fa-arrow-left"></i> Kembali ke Promo &amp; Event</a>
			</div>
		</article>
	</div>
</main>

<?php require_once('footer.php'); ?>
