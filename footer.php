<?php
	$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) 
	{
		$footer_about                = $row['footer_about'];
		$footer_copyright            = $row['footer_copyright'];
		$contact_address             = $row['contact_address'];
		$contact_email               = $row['contact_email'];
		$contact_phone               = $row['contact_phone'];
		$contact_fax                 = $row['contact_fax'];
		$total_recent_news_footer    = $row['total_recent_news_footer'];
		$total_popular_news_footer   = $row['total_popular_news_footer'];
		$total_recent_news_sidebar   = $row['total_recent_news_sidebar'];
		$total_popular_news_sidebar  = $row['total_popular_news_sidebar'];
		$total_recent_news_home_page = $row['total_recent_news_home_page'];
		$newsletter_title            = $row['newsletter_title'];
		$newsletter_text             = $row['newsletter_text'];
		$newsletter_photo            = $row['newsletter_photo'];
		$newsletter_status           = $row['newsletter_status'];

		$receive_email = $row['receive_email'];
	}

	// Ambil data cabang untuk modal Live Chat / WhatsApp (dipakai global di semua halaman)
	$footer_cabang_stmt = $pdo->prepare("SELECT * FROM tbl_cabang ORDER BY id ASC");
	$footer_cabang_stmt->execute();
	$footer_result_cabang = $footer_cabang_stmt->fetchAll(PDO::FETCH_ASSOC);
	?>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
.footer-main .footer-brand .footer-logo{margin-bottom:35px;}
.footer-main .footer-brand .footer-logo img{max-width:250px;width:100%;height:auto;display:block;}

.footer-main .footer-brand p{margin-bottom: 0;}
.footer-main .footer-brand-actions{display:flex;gap:10px;}
.footer-main .footer-brand-actions .brand-icon{width:38px;height:38px;border-radius:8px;background: #f5f5f5;color: #5b2106;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-size:16px;transition:all .2s;}
.footer-main .footer-brand-actions .brand-icon:hover{background: #5b2106;color: #fff;}

.footer-bottom{border-top:1px solid #af4a22;}
.footer-bottom-inner{display:flex !important;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;width:100%;}
.footer-bottom .copyright{margin:0;font-size:14px;font-weight:700;color:#333;}
.payment-icons{display:flex !important;gap:10px;align-items:center;}
.payment-icons i{width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;border:1px solid #5b2106;border-radius:8px;color:#5b2106;font-size:16px;box-sizing:border-box;}

/* ---------------- Modal Pilih Cabang & Konfirmasi WA (Global) ---------------- */
.mk-modal-overlay{
	position:fixed; inset:0; background:rgba(20,20,20,0.55);
	display:flex; align-items:center; justify-content:center;
	z-index:9999; opacity:0; visibility:hidden; transition:0.25s;
	padding:20px;
}
.mk-modal-overlay.active{ opacity:1; visibility:visible; }

.mk-modal-box{
	background:#fff; border-radius:16px; width:100%; max-width:520px;
	max-height:85vh; display:flex; flex-direction:column;
	padding:28px; position:relative; box-shadow:0 20px 50px rgba(0,0,0,0.25);
	transform:translateY(20px); transition:0.25s;
}
.mk-modal-overlay.active .mk-modal-box{ transform:translateY(0); }

.mk-modal-close{
	position:absolute; top:18px; right:18px; background:none; border:none;
	font-size:3.5rem; color:#8A7F73; cursor:pointer; line-height:1;
}
.mk-modal-close:hover{ color:#2E2620; }

.mk-modal-header{ display:flex; gap:14px; margin-bottom:20px; padding-right:24px; }
.mk-modal-header .mk-modal-icon{
	width:48px; height:48px; flex-shrink:0; border-radius:50%;
	background:#FDEDE0; color:#E8792E;
	display:flex; align-items:center; justify-content:center; font-size:1.2rem;
}
.mk-modal-header h3{ margin:0 0 4px; font-size:1.5rem; font-weight:800; color:#2E2620; }
.mk-modal-header p{ margin:0; font-size:1.25rem; color:#8A7F73; line-height:1.5; }

.mk-modal-search{ margin-bottom:16px; }
.mk-modal-search input{
	width:100%; padding:12px 14px; border:1px solid #EDE4D8; border-radius:10px;
	font-size:1.25rem; font-family:inherit; box-sizing:border-box;
}
.mk-modal-search input:focus{ outline:none; border-color:#E8792E; }

.mk-modal-list{ overflow-y:auto; display:flex; flex-direction:column; gap:12px; padding-right:4px; }
.mk-cabang-item{
	display:flex; align-items:center; gap:14px; padding:12px; border-radius:12px;
	border:1px solid #EDE4D8; cursor:pointer; transition:0.2s; background:#FAFAF8;
}
.mk-cabang-item:hover{ background:#FDEDE0; border-color:#E8792E; }
.mk-cabang-item img{ width:64px; height:64px; border-radius:8px; object-fit:cover; flex-shrink:0; }
.mk-cabang-info{ flex:1; min-width:0; }
.mk-cabang-name{ margin:0 0 3px; font-weight:700; font-size:1.25rem; color:#2E2620; display:flex; align-items:center; gap:6px; }
.mk-cabang-name i{
	color:#E8792E; font-size:1.25rem; position:relative; display:inline-block;
	width:1.25rem; line-height:1; text-align:center;
}
.mk-cabang-name i::after{
	content:""; position:absolute; width:.28em; height:.28em; border-radius:50%;
	background:#fff; left:50%; top:28%; transform:translate(-50%,-50%);
}
.mk-cabang-address{ margin:0 0 4px; font-size:1.25rem; color:#8A7F73; line-height:1.4; }
.mk-cabang-wa{ margin:0; font-size:1.25rem; color: #25D366; font-weight:600; display:flex; align-items:center; gap:5px; }
.mk-cabang-arrow{ color:#C9C1B8; flex-shrink:0; }

.mk-modal-footnote{
	margin:16px 0 0; font-size:1.25rem; color: #8A7F73; display:flex; align-items:center; gap:6px;
}

/* Modal konfirmasi WA */
.mk-modal-confirm{ max-width:400px; text-align:center; align-items:center; }
.mk-wa-confirm-icon{
	width:64px; height:64px; border-radius:50%; background:#E7F6EA; color:#227A3E;
	display:flex; align-items:center; justify-content:center; font-size:1.8rem;
	margin:0 auto 18px;
}
.mk-modal-confirm h3{ margin:0 0 8px; font-size:1.5rem; font-weight:800; color:#2E2620; }
.mk-modal-confirm p{ margin:0 0 24px; font-size:1.25rem; color:#8A7F73; line-height:1.5; }
.mk-wa-confirm-btn{
	display:flex; align-items:center; justify-content:center; gap:8px; width:100%;
	padding:14px; background:#E8792E; color:#fff; border:none;
	border-radius:10px; font-weight:700; font-size:1.25rem; text-decoration:none;
	margin-bottom:12px; transition:0.2s;
}
.mk-wa-confirm-btn:hover{ background:#C9611F; }
.mk-wa-confirm-cancel{
	background:none; border:none; color:#8A7F73; font-size:1.25rem; cursor:pointer; padding:6px;
}
.mk-wa-confirm-cancel:hover{ color:#2E2620; }

@media (max-width:576px){
	.mk-modal-box{ padding:22px; max-height:80vh; }
	.mk-cabang-item img{ width:52px; height:52px; }
}
</style>

	<?php if($newsletter_status=='Show'): ?>
	<div class="newsletter-area" style="background-image: url(<?php echo BASE_URL; ?>assets/uploads/<?php echo $newsletter_photo; ?>);">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="newsletter-headline wow fadeInUp">
						<h2><?php echo $newsletter_title; ?></h2>
						<?php if($newsletter_text!=''): ?>
						<p>
							<?php echo nl2br($newsletter_text); ?>
						</p>
						<?php endif; ?>
					</div>
					<div class="newsletter-submit wow fadeInUp">
						<?php
			if(isset($_POST['form_subscribe']))
			{

				if(empty($_POST['email_subscribe'])) 
			    {
			        $valid = 0;
			        $error_message1 .= EMAIL_EMPTY_CHECK;
			    }
			    else
			    {
			    	if (filter_var($_POST['email_subscribe'], FILTER_VALIDATE_EMAIL) === false)
				    {
				        $valid = 0;
				        $error_message1 .= EMAIL_VALID_CHECK;
				    }
				    else
				    {
				    	$statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_email=?");
				    	$statement->execute(array($_POST['email_subscribe']));
				    	$total = $statement->rowCount();							
				    	if($total)
				    	{
				    		$valid = 0;
				        	$error_message1 .= EMAIL_EXIST_CHECK;
				    	}
				    	else
				    	{
				    		// Sending email to the requested subscriber for email confirmation
				    		// Getting activation key to send via email. also it will be saved to database until user click on the activation link.
				    		$key = md5(uniqid(rand(), true));

				    		// Getting current date
				    		$current_date = date('Y-m-d');

				    		// Getting current date and time
				    		$current_date_time = date('Y-m-d H:i:s');

				    		// Inserting data into the database
				    		$statement = $pdo->prepare("INSERT INTO tbl_subscriber (subs_email,subs_date,subs_date_time,subs_hash,subs_active) VALUES (?,?,?,?,?)");
				    		$statement->execute(array($_POST['email_subscribe'],$current_date,$current_date_time,$key,0));

				    		// Sending Confirmation Email
				    		$to = $_POST['email_subscribe'];
							$subject = 'Subscriber Email Confirmation';
							
							// Getting the url of the verification link
							$verification_url = BASE_URL.'verify.php?email='.$to.'&key='.$key;

							$message = '
Thanks for your interest to subscribe our newsletter!<br><br>
Please click this link to confirm your subscription:
					'.$verification_url.'<br><br>
This link will be active only for 24 hours.
					';


							try {
							    $mail->setFrom($receive_email, 'Admin');
							    $mail->addAddress($to);
							    $mail->addReplyTo($receive_email, 'Admin');
							    
							    $mail->isHTML(true);
							    $mail->Subject = $subject;
					  
							    $mail->Body = $message;
							    $mail->send();

							    $success_message1 = SUBSCRIPTION_SUCCESS_MESSAGE;
							} catch (Exception $e) {
							    echo 'Message could not be sent.';
							    echo 'Mailer Error: ' . $mail->ErrorInfo;
							}							
				    	}
				    }
			    }
			}
			if($error_message1 != '') {
				echo "<script>alert('".$error_message1."')</script>";
			}
			if($success_message1 != '') {
				echo "<script>alert('".$success_message1."')</script>";
			}
			?>
						<form action="" method="post">
							<input type="text" placeholder="<?php echo ENTER_YOUR_EMAIL; ?>" name="email_subscribe">
							<input type="submit" value="<?php echo SUBMIT; ?>" name="form_subscribe">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

		
		<!-- Footer Main Start -->
		<section class="footer-main">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-md-3 col-lg-3 footer-col footer-brand wow fadeInLeft">
    					<div class="footer-logo">
        					<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $logo; ?>" alt="Manna Kampus">
    </div>
   <?php echo $footer_about; ?>
   
    <div class="footer-brand-actions">
        <a href="#" class="brand-icon" title="QR Code"><i class="fa-solid fa-qrcode"></i></a>
        <a href="#" class="brand-icon" title="Bagikan"><i class="fa-solid fa-share"></i></a>
		<a href="https://www.youtube.com" class="brand-icon" title="YouTube" target="_blank"><i class="fa-brands fa-youtube"></i></a>
		<a href="https://www.tiktok.com" class="brand-icon" title="TikTok" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
        <a href="https://www.facebook.com" class="brand-icon" title="Facebook" target="_blank"><i class="fa-brands fa-facebook"></i></a>
		<a href="https://www.instagram.com" class="brand-icon" title="Instagram" target="_blank"><i class="fa-brands fa-instagram"></i></a>
    </div>
</div>
					<div class="col-sm-6 col-md-3 col-lg-3 footer-col footer-links-col wow fadeInLeft">
	<h3>Perusahaan</h3>
	<ul>
		<li><a href="#">Tentang Kami</a></li>
		<li><a href="#">Karir</a></li>
		<li><a href="#">Hubungi Kami</a></li>
	</ul>
</div>

<div class="col-sm-6 col-md-3 col-lg-3 footer-col footer-links-col wow fadeInRight">
	<h3>Bantuan</h3>
	<ul>
		<li><a href="#">Layanan Pelanggan</a></li>
		<li><a href="#">Kebijakan Privasi</a></li>
		<li><a href="#">Syarat &amp; Ketentuan</a></li>
		<li><a href="#">Pengiriman &amp; Pengembalian</a></li>
	</ul>
</div>
					<div class="col-sm-6 col-md-3 col-lg-3 footer-col wow fadeInRight">
						<h3>Hubungi Kami</h3>
						<div class="contact-item">
							<div class="icon"><i class="fa-solid fa-location-dot"></i></div>
							<div class="text"><?php echo $contact_address; ?></div>
						</div>
						<div class="contact-item">
							<div class="icon"><i class="fa fa-phone"></i></div>
							<div class="text"><?php echo $contact_phone; ?></div>
						</div>
						<div class="contact-item">
							<div class="icon"><i class="fa fa-fax"></i></div>
							<div class="text"><?php echo $contact_fax; ?></div>
						</div>
						<div class="contact-item">
							<div class="icon"><i class="fa fa-envelope-o"></i></div>
							<div class="text"><?php echo $contact_email; ?></div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Footer Main End -->

		<!-- Footer Bottom Start -->
		<section class="footer-bottom">
			<div class="container">
				<div class="footer-bottom-inner">
					<div class="copyright">
						<?php echo $footer_copyright; ?>
					</div>
					<div class="payment-icons">
						<i class="fa-solid fa-money-check"></i>
						<i class="fa-solid fa-credit-card"></i>
						<i class="fa-solid fa-wallet"></i>
					</div>
				</div>
			</div>
		</section>
		<!-- Footer Bottom End -->


		<a href="#" class="scrollup">
			<i class="fa fa-angle-up"></i>
		</a>

<!-- Whatsapp Button (sekarang membuka modal pilih cabang) -->
<a href="#" id="btnWhatsappFloat" rel="noopener" 
   class="whatsapp-float" 
   aria-label="Hubungi Kami via WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- Modal: Pilih Cabang untuk Live Chat / WhatsApp (Global, dipakai semua halaman) -->
<div class="mk-modal-overlay" id="mkCabangModalOverlay">
	<div class="mk-modal-box">
		<button class="mk-modal-close" id="mkCabangModalClose" type="button">&times;</button>
		<div class="mk-modal-header">
			<div class="mk-modal-icon"><i class="fa fa-comment" aria-hidden="true"></i></div>
			<div>
				<h3>Hubungi Cabang Manna Kampus</h3>
				<p>Pilih cabang terdekat atau cabang yang ingin Anda hubungi melalui WhatsApp.</p>
			</div>
		</div>

		<div class="mk-modal-search">
			<input type="text" id="mkCabangSearchInput" placeholder="Cari cabang...">
		</div>

		<div class="mk-modal-list" id="mkCabangList">
			<?php if (!empty($footer_result_cabang)): ?>
				<?php foreach ($footer_result_cabang as $row):
					$nama_cb   = htmlspecialchars($row['nama_cabang'] ?? '', ENT_QUOTES, 'UTF-8');
					$alamat_cb = htmlspecialchars($row['alamat'] ?? '', ENT_QUOTES, 'UTF-8');
					$foto_cb   = !empty($row['foto'])
						? BASE_URL . 'assets/uploads/' . htmlspecialchars($row['foto'], ENT_QUOTES, 'UTF-8')
						: BASE_URL . 'assets/uploads/default-cabang.jpg';

					// Bersihkan nomor kontak, ubah awalan 0 jadi 62 untuk format wa.me
					$kontak_raw = preg_replace('/[^0-9]/', '', $row['kontak'] ?? '');
					if ($kontak_raw !== '' && substr($kontak_raw, 0, 1) === '0') {
						$kontak_wa = '62' . substr($kontak_raw, 1);
					} else {
						$kontak_wa = $kontak_raw;
					}
				?>
				<div class="mk-cabang-item"
					 data-nama="<?php echo $nama_cb; ?>"
					 data-alamat="<?php echo $alamat_cb; ?>"
					 data-kontak="<?php echo htmlspecialchars($kontak_wa, ENT_QUOTES, 'UTF-8'); ?>">
					<img src="<?php echo $foto_cb; ?>" alt="<?php echo $nama_cb; ?>">
					<div class="mk-cabang-info">
						<p class="mk-cabang-name"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $nama_cb; ?></p>
						<p class="mk-cabang-address"><?php echo $alamat_cb; ?></p>
						<p class="mk-cabang-wa"><i class="fab fa-whatsapp" aria-hidden="true"></i> Chat melalui WhatsApp</p>
					</div>
					<i class="fa fa-chevron-right mk-cabang-arrow" aria-hidden="true"></i>
				</div>
				<?php endforeach; ?>
			<?php else: ?>
				<p style="text-align:center; color:#8A7F73; padding:20px 0;">Belum ada data cabang.</p>
			<?php endif; ?>
		</div>

		<p class="mk-modal-footnote"><i class="fa fa-info-circle" aria-hidden="true"></i> Jam operasional chat mengikuti jam operasional masing-masing cabang.</p>
	</div>
</div>

<!-- Modal: Konfirmasi Redirect ke WhatsApp (Global) -->
<div class="mk-modal-overlay" id="mkWaConfirmOverlay">
	<div class="mk-modal-box mk-modal-confirm">
		<button class="mk-modal-close" id="mkWaConfirmClose" type="button">&times;</button>
		<div class="mk-wa-confirm-icon"><i class="fa fa-check" aria-hidden="true"></i></div>
		<h3>Mengarahkan ke WhatsApp</h3>
		<p>Anda akan diarahkan untuk chat dengan <br><strong id="mkWaConfirmName"></strong>.</p>
		<a href="#" target="_blank" rel="noopener" id="mkWaConfirmBtn" class="mk-wa-confirm-btn">
			<i class="fab fa-whatsapp" aria-hidden="true"></i> Buka WhatsApp
		</a>
		<button type="button" class="mk-wa-confirm-cancel" id="mkWaConfirmCancel">Batal</button>
	</div>
</div>

<script>
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#000"
    },
    "button": {
      "background": "#f1d600"
    }
  },
  "position": "bottom-left"
})});
</script>


	<!-- Scripts -->
	<script src="<?php echo BASE_URL; ?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/js/jquery.slicknav.min.js"></script>	
	<script src="<?php echo BASE_URL; ?>assets/js/hoverIntent.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/js/superfish.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/js/owl.carousel.min.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/js/owl.animate.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/js/wow.min.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/js/jquery.bxslider.min.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/js/jquery.mixitup.min.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/js/jquery.magnific-popup.min.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/js/waypoints.min.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/js/jquery.counterup.min.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/js/custom.js"></script>

	<script>
	/* --- Modal Live Chat / WhatsApp: Pilih Cabang -> Konfirmasi WhatsApp (Global) --- */
	(function () {
		const cabangModalOverlay  = document.getElementById('mkCabangModalOverlay');
		const cabangModalClose    = document.getElementById('mkCabangModalClose');
		const cabangSearchInput   = document.getElementById('mkCabangSearchInput');
		const cabangItems         = document.querySelectorAll('.mk-cabang-item');

		const waConfirmOverlay = document.getElementById('mkWaConfirmOverlay');
		const waConfirmClose   = document.getElementById('mkWaConfirmClose');
		const waConfirmCancel  = document.getElementById('mkWaConfirmCancel');
		const waConfirmName    = document.getElementById('mkWaConfirmName');
		const waConfirmBtn     = document.getElementById('mkWaConfirmBtn');

		// Nomor WA default/pusat jika cabang tidak punya nomor kontak valid
		const DEFAULT_WA_NUMBER = '6285943611060';

		function openCabangModal() {
			if (!cabangModalOverlay) return;
			cabangModalOverlay.classList.add('active');
			document.body.style.overflow = 'hidden';
		}
		function closeCabangModal() {
			if (!cabangModalOverlay) return;
			cabangModalOverlay.classList.remove('active');
			document.body.style.overflow = '';
		}
		function openWaConfirm(nama, kontak) {
			if (!waConfirmOverlay) return;
			waConfirmName.textContent = nama;
			const phone = kontak && kontak.length >= 8 ? kontak : DEFAULT_WA_NUMBER;
			const pesan = encodeURIComponent('Halo Manna Kampus ' + nama + ', saya ingin bertanya.');
			waConfirmBtn.href = 'https://wa.me/' + phone + '?text=' + pesan;
			waConfirmOverlay.classList.add('active');
		}
		function closeWaConfirm() {
			if (!waConfirmOverlay) return;
			waConfirmOverlay.classList.remove('active');
			document.body.style.overflow = '';
		}

		// Trigger dari tombol WA floating (semua halaman)
		const btnWhatsappFloat = document.getElementById('btnWhatsappFloat');
		if (btnWhatsappFloat) {
			btnWhatsappFloat.addEventListener('click', function (e) {
				e.preventDefault();
				openCabangModal();
			});
		}

		// Trigger dari tombol "Mulai Chat" (khusus di contact-us.php, jika ada)
		const btnMulaiChat = document.getElementById('btnMulaiChat');
		if (btnMulaiChat) {
			btnMulaiChat.addEventListener('click', function (e) {
				e.preventDefault();
				openCabangModal();
			});
		}

		if (cabangModalClose) cabangModalClose.addEventListener('click', closeCabangModal);
		if (cabangModalOverlay) {
			cabangModalOverlay.addEventListener('click', function (e) {
				if (e.target === cabangModalOverlay) closeCabangModal();
			});
		}

		cabangItems.forEach(function (item) {
			item.addEventListener('click', function () {
				const nama   = this.dataset.nama || '';
				const kontak = this.dataset.kontak || '';
				closeCabangModal();
				openWaConfirm(nama, kontak);
			});
		});

		if (waConfirmClose)  waConfirmClose.addEventListener('click', closeWaConfirm);
		if (waConfirmCancel) waConfirmCancel.addEventListener('click', closeWaConfirm);
		if (waConfirmOverlay) {
			waConfirmOverlay.addEventListener('click', function (e) {
				if (e.target === waConfirmOverlay) closeWaConfirm();
			});
		}

		if (cabangSearchInput) {
			cabangSearchInput.addEventListener('input', function () {
				const keyword = this.value.toLowerCase().trim();
				cabangItems.forEach(function (item) {
					const nama   = (item.dataset.nama || '').toLowerCase();
					const alamat = (item.dataset.alamat || '').toLowerCase();
					const visible = !keyword || nama.includes(keyword) || alamat.includes(keyword);
					item.style.display = visible ? '' : 'none';
				});
			});
		}

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') {
				closeCabangModal();
				closeWaConfirm();
			}
		});
	})();
	</script>
	
</body>
</html>
