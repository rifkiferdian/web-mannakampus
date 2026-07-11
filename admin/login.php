<?php
ob_start();
session_start();
include("config.php");
$error_message='';

if(isset($_POST['form1'])) {
        
    if(empty($_POST['email']) || empty($_POST['password'])) {
        $error_message = 'Email and/or Password can not be empty<br>';
    } else {
		
		$email = strip_tags($_POST['email']);
		$password = strip_tags($_POST['password']);

    	$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE email=? AND status=?");
    	$statement->execute(array($email,'Active'));
    	$total = $statement->rowCount();    
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);    
        if($total==0) {
            $error_message .= 'Email Address does not match<br>';
        } else {       
            foreach($result as $row) { 
                $row_password = $row['password'];
            }
        
            if( $row_password != md5($password) ) {
                $error_message .= 'Password does not match<br>';
            } else {       
            
				$_SESSION['user'] = $row;
                header("location: index.php");
            }
        }
    }

    
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin Login - Manna Kampus</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/datepicker3.css">
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">

	<link rel="stylesheet" href="style.css">
</head>

<body class="hold-transition login-page sidebar-mini mk-admin-login-page">

<main class="mk-admin-login">
	<section class="mk-admin-card">
		<div class="mk-admin-card-left">
			<img src="../assets/uploads/logo.png" alt="Manna Kampus" class="mk-admin-logo">

			<div class="mk-admin-heading">
				<h1>Admin Portal</h1>
				<p>Secure access for authorized personnel only.</p>
			</div>

			<?php 
			if( (isset($error_message)) && ($error_message!='') ):
				echo '<div class="error mk-login-error">'.$error_message.'</div>';
			endif;
			?>

			<form action="" method="post" class="mk-admin-form">
				<div class="mk-field">
					<label for="email">Username or Email</label>
					<div class="mk-input-wrap">
						<i class="fa fa-user-o"></i>
						<input id="email" class="form-control" placeholder="admin@gmail.com" name="email" type="email" autocomplete="off" autofocus>
					</div>
				</div>

				<div class="mk-field">
					<div class="mk-label-row">
						<label for="password">Password</label>
						<a href="#" class="mk-forgot-link">Forgot Password?</a>
					</div>
					<div class="mk-input-wrap">
						<i class="fa fa-lock"></i>
						<input id="password" class="form-control" placeholder="Password" name="password" type="password" autocomplete="off" value="">
						<button type="button" class="mk-password-toggle" aria-label="Show password"><i class="fa fa-eye"></i></button>
					</div>
				</div>

				<label class="mk-remember">
					<input type="checkbox" name="remember_device" value="1">
					<span>Remember this device</span>
				</label>

				<button type="submit" class="mk-login-button" name="form1">
					Login to Dashboard <i class="fa fa-arrow-right"></i>
				</button>
			</form>
		</div>

		<aside class="mk-admin-card-right">
			<div class="mk-sop-title">
				<i class="fa fa-file-text-o"></i>
				<h2>Panduan Penulisan Berita &amp;<br>Informasi (SOP)</h2>
			</div>
			<ul>
				<li>Gunakan bahasa yang formal, ramah, dan sesuai dengan identitas Manna Kampus.</li>
				<li>Pastikan gambar pendukung memiliki resolusi tinggi dan relevan.</li>
				<li>Verifikasi keakuratan data dan tanggal sebelum dipublikasikan.</li>
				<li>Setiap konten berita wajib melalui persetujuan Editor Senior.</li>
			</ul>
		</aside>
	</section>

	<div class="mk-admin-footer">
		<div><i class="fa fa-shield"></i> 256-BIT SSL ENCRYPTED CONNECTION</div>
		<a href="<?php echo BASE_URL; ?>"><i class="fa fa-arrow-left"></i> Back to Website</a>
	</div>
</main>


<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/select2.full.min.js"></script>
<script src="js/jquery.inputmask.js"></script>
<script src="js/jquery.inputmask.date.extensions.js"></script>
<script src="js/jquery.inputmask.extensions.js"></script>
<script src="js/moment.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/icheck.min.js"></script>
<script src="js/fastclick.js"></script>
<script src="js/jquery.sparkline.min.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<script src="js/app.min.js"></script>
<script src="js/demo.js"></script>
<script>
	(function() {
		var toggle = document.querySelector('.mk-password-toggle');
		var password = document.getElementById('password');
		if (!toggle || !password) return;
		toggle.addEventListener('click', function() {
			var isPassword = password.getAttribute('type') === 'password';
			password.setAttribute('type', isPassword ? 'text' : 'password');
			toggle.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
		});
	})();
</script>

</body>
</html>
