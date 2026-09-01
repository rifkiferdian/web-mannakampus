<?php require_once('header.php'); ?>
<?php require_once('image-upload-utils.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['page_name'])) {
        $valid = 0;
        $error_message .= "Page Name can not be empty<br>";
    } else {
    	// Duplicate Page checking
    	$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE page_name=?");
    	$statement->execute(array($_POST['page_name']));
    	$total = $statement->rowCount();
    	if($total) {
    		$valid = 0;
        	$error_message .= "Page Name already exists<br>";
    	}
    }

    $image_valid = isset($_FILES['banner']) ? image_upload_validate($_FILES['banner']) : false;
    if($image_valid === false) {
        $valid = 0;
        $error_message .= 'You must have to upload a valid JPG or PNG file for banner (max 3 MB)<br>';
    }

    if($valid == 1) {

    	// getting auto increment id
		$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_page'");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row) {
			$ai_id=$row[10];
		}

    	if($_POST['page_slug'] == '') {
    		// generate slug
    		$temp_string = strtolower($_POST['page_name']);
    		$page_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string);
    	} else {
    		$temp_string = strtolower($_POST['page_slug']);
    		$page_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string);
    	}

    	// if slug already exists, then rename it
		$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE page_slug=?");
		$statement->execute(array($page_slug));
		$total = $statement->rowCount();
		if($total) {
			$page_slug = $page_slug.'-1';
		}

		$final_name = image_upload_save_as_webp(
			$_FILES['banner'],
			'page-banner-'.$ai_id,
			__DIR__.'/../assets/uploads/'
		);

		if($final_name === false) {
			$error_message .= 'Banner tidak dapat diunggah.<br>';
		} else {
			// saving into the database
			$statement = $pdo->prepare("INSERT INTO tbl_page (page_name,page_slug,page_content,page_layout,banner,status,meta_title,meta_keyword,meta_description) VALUES (?,?,?,?,?,?,?,?,?)");
			$statement->execute(array($_POST['page_name'],$page_slug,$_POST['page_content'],$_POST['page_layout'],$final_name,$_POST['status'],$_POST['meta_title'],$_POST['meta_keyword'],$_POST['meta_description']));

			$success_message = 'Page is added successfully.';
		}
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Page</h1>
	</div>
	<div class="content-header-right">
		<a href="page.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php if($error_message): ?>
			<div class="callout callout-danger">
			
			<p>
			<?php echo $error_message; ?>
			</p>
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
							<label for="" class="col-sm-2 control-label">Page Name <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="page_name" placeholder="Example: About Us">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Page Slug </label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="page_slug" placeholder="Example: about-us">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Page Layout </label>
							<div class="col-sm-2">
								<select class="form-control select2" name="page_layout" style="width:300px;" onchange="showContentInputArea(this)">
									<option value="Full Width Page Layout">Full Width Page Layout</option>
									<option value="FAQ Page Layout">FAQ Page Layout</option>
									<option value="Team Member Page Layout">Team Member Page Layout</option>
									<option value="Photo Gallery Page Layout">Photo Gallery Page Layout</option>
									<option value="Video Gallery Page Layout">Video Gallery Page Layout</option>
									<option value="Blog Page Layout">Blog Page Layout</option>
									<option value="Contact Us Page Layout">Contact Us Page Layout</option>
								</select>
							</div>
						</div>
						
						<div class="form-group" id="showPageContent">
							<label for="" class="col-sm-2 control-label">Page Content </label>
							<div class="col-sm-9">
								<textarea class="form-control editor" name="page_content"></textarea>
							</div>
						</div>	
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Banner <span>*</span></label>
							<div class="col-sm-9" style="padding-top:5px">
								<input type="file" name="banner" accept="image/jpeg, image/png">(Only jpg and png are allowed, max 3 MB)
							</div>
						</div>					
						<div class="form-group">
				            <label for="" class="col-sm-2 control-label">Active? </label>
				            <div class="col-sm-6">
				                <label class="radio-inline">
				                    <input type="radio" name="status" value="Active" checked>Yes
				                </label>
				                <label class="radio-inline">
				                    <input type="radio" name="status" value="Inactive">No
				                </label>
				            </div>
				        </div>
						<h3 class="seo-info">SEO Information</h3>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Meta Title </label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="meta_title">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Meta Keywords </label>
							<div class="col-sm-9">
								<textarea class="form-control" name="meta_keyword" style="height:100px;"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Meta Description </label>
							<div class="col-sm-9">
								<textarea class="form-control" name="meta_description" style="height:100px;"></textarea>
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