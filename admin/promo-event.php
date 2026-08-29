<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Promo &amp; Event Utama</h1>
	</div>
	<div class="content-header-right">
		<a href="promo-event-add.php" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Baru</a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<?php if(isset($_GET['added'])): ?>
			<div class="alert alert-success">Promo atau event berhasil ditambahkan.</div>
			<?php elseif(isset($_GET['updated'])): ?>
			<div class="alert alert-success">Promo atau event berhasil diperbarui.</div>
			<?php elseif(isset($_GET['deleted'])): ?>
			<div class="alert alert-success">Promo atau event berhasil dihapus.</div>
			<?php endif; ?>
			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Gambar</th>
								<th>Judul</th>
								<th>Tipe</th>
								<th>Periode</th>
								<th>Homepage</th>
								<th>Urutan</th>
								<th>Status</th>
								<th style="width:185px;">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$statement = $pdo->prepare("SELECT * FROM tbl_promo_event ORDER BY display_order ASC, id DESC");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $index => $row):
							?>
							<tr>
								<td><?php echo $index + 1; ?></td>
								<td style="width:160px;">
									<img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="" style="width:150px;height:75px;object-fit:contain;background:#f5f5f5;">
								</td>
								<td>
									<strong><?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?></strong><br>
									<small><?php echo htmlspecialchars($row['slug'], ENT_QUOTES, 'UTF-8'); ?></small>
								</td>
								<td><?php echo htmlspecialchars($row['type'], ENT_QUOTES, 'UTF-8'); ?></td>
								<td>
									<?php echo date('d M Y', strtotime($row['start_date'])); ?><br>
									<small>sampai <?php echo date('d M Y', strtotime($row['end_date'])); ?></small>
								</td>
								<td><?php echo $row['is_featured'] ? '<span class="label label-success">Tampil</span>' : '<span class="label label-default">Tidak</span>'; ?></td>
								<td><?php echo (int)$row['display_order']; ?></td>
								<td>
									<span class="label <?php echo $row['status'] === 'Active' ? 'label-success' : 'label-default'; ?>">
										<?php echo $row['status'] === 'Active' ? 'Aktif' : 'Nonaktif'; ?>
									</span>
								</td>
								<td>
									<a href="<?php echo BASE_URL; ?>promo-event/<?php echo rawurlencode($row['slug']); ?>" class="btn btn-info btn-xs" target="_blank" rel="noopener noreferrer">Lihat</a>
									<a href="promo-event-edit.php?id=<?php echo (int)$row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
									<a href="#" class="btn btn-danger btn-xs" data-href="promo-event-delete.php?id=<?php echo (int)$row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Hapus</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="delete-modal-title" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="delete-modal-title">Konfirmasi Hapus</h4>
			</div>
			<div class="modal-body">Yakin ingin menghapus promo atau event ini? Gambar yang terkait juga akan dihapus.</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<a class="btn btn-danger btn-ok">Hapus</a>
			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>
