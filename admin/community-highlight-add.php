<?php require_once('header.php'); ?>
<?php
$upload_dir = '../assets/uploads/';
$allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
$max_size = 2 * 1024 * 1024;

if(isset($_POST['form1'])) {
    $valid = 1;

    if(empty($_POST['title'])) {
        $valid = 0;
        $error_message .= "Title can not be empty<br>";
    }

    if(empty($_POST['url'])) {
        $valid = 0;
        $error_message .= "URL can not be empty<br>";
    }

    if(empty($_POST['author'])) {
        $valid = 0;
        $error_message .= "Author can not be empty<br>";
    }

    $new_filename = null;

    if (empty($_FILES['image']['name'])) {
        $valid = 0;
        $error_message .= "Thumbnail image can not be empty<br>";
    } else {
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $valid = 0;
            $error_message .= "Gagal upload file: " . htmlspecialchars($_FILES['image']['name']) . "<br>";
        } else {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed_ext)) {
                $valid = 0;
                $error_message .= "Format file tidak didukung: " . htmlspecialchars($_FILES['image']['name']) . " (hanya jpg, jpeg, png, webp)<br>";
            } elseif ($_FILES['image']['size'] > $max_size) {
                $valid = 0;
                $error_message .= "Ukuran file terlalu besar (maks 2MB)<br>";
            } else {
                $new_filename = 'highlight-' . time() . '-' . uniqid() . '.' . $ext;
            }
        }
    }

    if($valid == 1) {
        $destination = $upload_dir . $new_filename;
        move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        $statement = $pdo->prepare(
            "INSERT INTO sorotan_komunitas (title, platform, image, url, author, type, sort_order, is_active)
             VALUES (?,?,?,?,?,?,?,?)"
        );
        $statement->execute(array(
            $_POST['title'],
            $_POST['platform'],
            $new_filename,
            $_POST['url'],
            $_POST['author'],
            $_POST['type'],
            (int) $_POST['sort_order'],
            isset($_POST['is_active']) ? 1 : 0
        ));

        $_SESSION['success_message'] = 'Community highlight is added successfully.';
        header('Location: community-highlight.php');
        exit;
    }
}
?>

<section class="content-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">
    <div class="content-header-left">
        <h1 style="margin:0;">Add Community Highlight</h1>
    </div>
    <div class="content-header-right">
        <a href="community-highlight.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">

            <?php if($error_message): ?>
            <div class="callout callout-danger">
            <p><?php echo $error_message; ?></p>
            </div>
            <?php endif; ?>

            <?php if($success_message): ?>
            <div class="callout callout-success">
            <p><?php echo $success_message; ?></p>
            </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Title <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($_POST['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Example: Keseruan belanja di Manna Kampus">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Platform <span>*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="platform">
                                    <?php foreach(['instagram','tiktok','youtube','facebook'] as $p): ?>
                                    <option value="<?php echo $p; ?>" <?php echo (isset($_POST['platform']) && $_POST['platform'] == $p) ? 'selected' : ''; ?>><?php echo ucfirst($p); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Content Type <span>*</span></label>
                            <div class="col-sm-4">
                                <select class="form-control" name="type">
                                    <option value="image" <?php echo (isset($_POST['type']) && $_POST['type'] == 'image') ? 'selected' : ''; ?>>Image (Photo)</option>
                                    <option value="video" <?php echo (isset($_POST['type']) && $_POST['type'] == 'video') ? 'selected' : ''; ?>>Video</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Post URL <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="url" value="<?php echo htmlspecialchars($_POST['url'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="https://...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Author <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="author" value="<?php echo htmlspecialchars($_POST['author'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="@mannakampus">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Sort Order</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" name="sort_order" value="<?php echo htmlspecialchars($_POST['sort_order'] ?? '0', ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Thumbnail Image <span>*</span></label>
                            <div class="col-sm-6">
                                <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp">
                                <p class="help-block">Format: jpg, jpeg, png, webp. Maks 2MB.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Active</label>
                            <div class="col-sm-6">
                                <input type="checkbox" name="is_active" value="1" checked> Show on website
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>

</section>

<?php require_once('footer.php'); ?>