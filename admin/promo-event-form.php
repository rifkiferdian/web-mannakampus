<section class="content">
	<div class="row">
		<div class="col-md-12">
			<?php if($error_message): ?>
			<div class="callout callout-danger">
				<h4>Periksa kembali data berikut:</h4>
				<p><?php echo $error_message; ?></p>
			</div>
			<?php endif; ?>

			<?php if($success_message): ?>
			<div class="callout callout-success">
				<h4>Berhasil:</h4>
				<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
				<div class="box box-info">
					<div class="box-body">
						<?php if($is_edit): ?>
						<input type="hidden" name="current_image" value="<?php echo promo_event_escape($form_data['image']); ?>">
						<div class="form-group">
							<label class="col-sm-2 control-label">Gambar Saat Ini</label>
							<div class="col-sm-9">
								<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo promo_event_escape($form_data['image']); ?>" alt="" style="width:100%;max-width:600px;height:auto;background:#f5f5f5;">
							</div>
						</div>
						<?php endif; ?>

						<div class="form-group">
							<label class="col-sm-2 control-label"><?php echo $is_edit ? 'Ganti Gambar' : 'Gambar'; ?> <?php if(!$is_edit): ?><span>*</span><?php endif; ?></label>
							<div class="col-sm-9" style="padding-top:5px;">
								<input type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.webp">
								<small>JPG, PNG, GIF, atau WebP, maksimal 8 MB. Rekomendasi ukuran 1800 × 800 px.</small>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Judul <span>*</span></label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="title" value="<?php echo promo_event_escape($form_data['title']); ?>" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Slug</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="slug" value="<?php echo promo_event_escape($form_data['slug']); ?>" placeholder="Otomatis dari title jika dikosongkan">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Tipe <span>*</span></label>
							<div class="col-sm-4">
								<select class="form-control" name="type" required>
									<?php foreach(array('Promo', 'Store Opening', 'Gebyar Undian') as $type): ?>
									<option value="<?php echo $type; ?>" <?php if($form_data['type'] === $type) { echo 'selected'; } ?>><?php echo $type; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Deskripsi Singkat <span>*</span></label>
							<div class="col-sm-9">
								<textarea class="form-control" name="short_description" rows="4" required><?php echo promo_event_escape($form_data['short_description']); ?></textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Content <span>*</span></label>
							<div class="col-sm-9">
								<textarea class="form-control editor" name="content" rows="12" required><?php echo promo_event_escape($form_data['content']); ?></textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Lokasi</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="location" value="<?php echo promo_event_escape($form_data['location']); ?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Periode <span>*</span></label>
							<div class="col-sm-3">
								<input type="date" class="form-control" name="start_date" value="<?php echo promo_event_escape($form_data['start_date']); ?>" required>
							</div>
							<div class="col-sm-1 text-center" style="padding-top:7px;">sampai</div>
							<div class="col-sm-3">
								<input type="date" class="form-control" name="end_date" value="<?php echo promo_event_escape($form_data['end_date']); ?>" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Button</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="button_text" value="<?php echo promo_event_escape($form_data['button_text']); ?>" placeholder="Lihat Detail">
							</div>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="button_url" value="<?php echo promo_event_escape($form_data['button_url']); ?>" placeholder="Otomatis menuju halaman detail jika kosong">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Urutan Tampil</label>
							<div class="col-sm-2">
								<input type="number" class="form-control" name="display_order" value="<?php echo (int)$form_data['display_order']; ?>" min="0">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Homepage</label>
							<div class="col-sm-4" style="padding-top:7px;">
								<label><input type="checkbox" name="is_featured" value="1" <?php if($form_data['is_featured']) { echo 'checked'; } ?>> Tampilkan di Promo &amp; Event Utama</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-4">
								<select class="form-control" name="status">
									<option value="Active" <?php if($form_data['status'] === 'Active') { echo 'selected'; } ?>>Aktif</option>
									<option value="Inactive" <?php if($form_data['status'] === 'Inactive') { echo 'selected'; } ?>>Nonaktif</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-6">
								<button type="submit" class="btn btn-success" name="form1"><i class="fa fa-save"></i> <?php echo $is_edit ? 'Simpan Perubahan' : 'Simpan'; ?></button>
								<a href="promo-event.php" class="btn btn-default">Batal</a>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
