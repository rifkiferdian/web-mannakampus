<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['slug']))
{
    header('location: '.BASE_URL);
    exit;
}
else
{
    // Check the page slug is valid or not.
    $statement = $pdo->prepare("SELECT * FROM tbl_team_member WHERE slug=?");
    $statement->execute(array($_REQUEST['slug']));
    $total = $statement->rowCount();
    if( $total == 0 )
    {
        header('location: '.BASE_URL);
        exit;
    }
}

// Getting the detailed data of a service from slug
$statement = $pdo->prepare("SELECT * FROM tbl_team_member WHERE slug=?");
$statement->execute(array($_REQUEST['slug']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);               
foreach ($result as $row)
{
    $name              = $row['name'];
    $slug              = $row['slug'];
    $designation_id    = $row['designation_id'];
    $photo             = $row['photo'];
    $banner            = $row['banner'];
    $degree            = $row['degree'];
    $detail            = $row['detail'];
    $facebook          = $row['facebook'];
    $twitter           = $row['twitter'];
    $linkedin          = $row['linkedin'];
    $youtube           = $row['youtube'];
    $google_plus       = $row['google_plus'];
    $instagram         = $row['instagram'];
    $flickr            = $row['flickr'];
    $address           = $row['address'];
    $practice_location = $row['practice_location'];
    $phone             = $row['phone'];
    $email             = $row['email'];
    $website           = $row['website'];
    $status            = $row['status'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_designation WHERE designation_id=?");
$statement->execute(array($designation_id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);               
foreach ($result as $row)
{
    $designation_name = $row['designation_name'];
}
?>

<style>
    /* Styling untuk Layout Side-by-Side yang Ditengahkan */
    .mk-award-single {
        padding: 60px 0 90px;
        background: #ffffff;
    }
    
    /* Wrapper untuk membatasi lebar agar berada di tengah */
    .mk-award-wrapper {
        max-width: 1050px; /* Lebar maksimal konten */
        margin: 0 auto; /* Memposisikan konten di tengah */
    }
    
    /* Bagian Header (Kategori & Judul) */
    .mk-award-header {
        margin-bottom: 40px;
        border-bottom: 2px solid #F5F5F5;
        padding-bottom: 25px;
    }
    .mk-award-meta {
        display: flex;
        gap: 20px;
        margin-bottom: 12px;
        color: #E8792E;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .mk-award-meta i {
        margin-right: 6px;
    }
    .mk-award-title {
        font-size: 36px;
        font-weight: 800;
        color: #2E2620;
        margin: 0;
        line-height: 1.3;
    }
    
    /* Gambar di Kiri */
    .mk-award-image {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        background: #f9f9f9;
    }
    .mk-award-image img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
    }
    
    /* Teks di Kanan */
    .mk-award-content {
        font-size: 16px;
        line-height: 1.8;
        color: #444;
        padding-left: 10px; 
    }
    .mk-award-content h4 {
        color: #E8792E;
        font-weight: 700;
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 20px;
    }
    .mk-award-content p {
        margin-bottom: 20px;
    }
    
    /* Tombol Bagikan (Share) */
    .mk-award-share {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px dashed #ddd;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .mk-award-share span {
        font-weight: 700;
        color: #2E2620;
        font-size: 15px;
    }
    .mk-award-share a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #F5F5F5;
        color: #666;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .mk-award-share a:hover {
        background: #E8792E;
        color: #fff;
        transform: translateY(-2px);
    }
    
    /* Responsif untuk layar Tablet/HP */
    @media (max-width: 991px) {
        .mk-award-content {
            padding-left: 0;
            margin-top: 30px; 
        }
    }
    @media (max-width: 768px) {
        .mk-award-title { font-size: 26px; }
        .mk-award-single { padding: 40px 0 60px; }
    }
</style>

<!-- Artikel Penghargaan Start -->
<section class="mk-award-single">
    <div class="container">
        <!-- Wrapper Tengah -->
        <div class="mk-award-wrapper">
            
            <!-- Header (Judul di atas gambar dan teks) -->
            <div class="mk-award-header">
                <div class="mk-award-meta">
                    <span><i class="fa fa-tag"></i> Kategori: <?php echo $designation_name; ?></span>
                </div>
                <h1 class="mk-award-title"><?php echo $name; ?></h1>
            </div>

            <!-- Layout 2 Kolom -->
            <div class="row">
                
                <!-- Kolom Kiri: Gambar (Porsi 5 kolom dari 12) -->
                <div class="col-md-5">
                    <div class="mk-award-image">
                        <img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo $photo; ?>" alt="<?php echo $name; ?>">
                    </div>
                </div>
                
                <!-- Kolom Kanan: Teks & Share (Porsi 7 kolom dari 12) -->
                <div class="col-md-7">
                    <div class="mk-award-content">
                        
                        <?php if($degree != ''): ?>
                            <h4><?php echo $degree; ?></h4>
                        <?php endif; ?>
                        
                        <!-- Isi Deskripsi Penghargaan -->
                        <?php echo $detail; ?>
                        
                        <!-- Tombol Bagikan -->
                        <div class="mk-award-share">
                            <span>Bagikan:</span>
                            <?php if($facebook!=''): ?>
                                <a href="<?php echo $facebook; ?>" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a>
                            <?php endif; ?>

                            <?php if($twitter!=''): ?>
                                <a href="<?php echo $twitter; ?>" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a>
                            <?php endif; ?>

                            <?php if($linkedin!=''): ?>
                                <a href="<?php echo $linkedin; ?>" target="_blank" title="LinkedIn"><i class="fa fa-linkedin"></i></a>
                            <?php endif; ?>

                            <?php if($instagram!=''): ?>
                                <a href="<?php echo $instagram; ?>" target="_blank" title="Instagram"><i class="fa fa-instagram"></i></a>
                            <?php endif; ?>
                            
                            <?php if($youtube!=''): ?>
                                <a href="<?php echo $youtube; ?>" target="_blank" title="YouTube"><i class="fa fa-youtube"></i></a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

            </div>
            
        </div> <!-- End Wrapper Tengah -->
    </div>
</section>
<!-- Artikel Penghargaan End -->

<?php require_once('footer.php'); ?>