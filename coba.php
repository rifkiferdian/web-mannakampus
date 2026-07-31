<?php require_once('header.php'); ?>
		
<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['slug']))
{
	header('location: '.BASE_URL);
	exit;
}
?>
<?php
// Include config for BASE_URL
include("admin/config.php");
$whatsapp_icon = 'whatsapp.png';
?>
	<div class="whatsapp-float" style="position: fixed; bottom: 100px; right: 20px; z-index: 99;">
		<a href="https://wa.me/6282312345678/?text=Hi,%20Admin." target="_blank" rel="noopener">
		<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $whatsapp_icon; ?>" width="65" height="66" alt="Hubungi Kami Melalui WhatsApp"></a>
	</div>
?>
<?php require_once('footer.php'); ?>