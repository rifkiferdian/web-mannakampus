<?php require_once('header.php'); ?>

<?php
if(isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
?>

<style>
    /* Mencegah teks URL merusak lebar kolom */
    #example1 td {
        word-break: break-all;
    }
    .facility-icon-cell {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .facility-icon-cell .icon-box {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: #fff;
        flex-shrink: 0;
    }
    .facility-thumb {
        position: relative;
        display: inline-block;
    }
    .facility-thumb img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .facility-thumb .thumb-count {
        position: absolute;
        bottom: -6px;
        right: -6px;
        background: #367fa9;
        color: #fff;
        font-size: 10px;
        border-radius: 10px;
        padding: 1px 5px;
        line-height: 1.4;
    }
    .no-thumb {
        color: #999;
        font-size: 12px;
    }
</style>

<section class="content-header">
    <div class="content-header-left">
        <h1>Branch Facilities</h1>
    </div>
    <div class="content-header-right">
        <a href="branch-facilities-add.php" class="btn btn-primary btn-sm">Add New</a>
    </div>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">

        <?php if(!empty($success_message)): ?>
        <div class="callout callout-success">
            <p><?php echo $success_message; ?></p>
        </div>
        <?php endif; ?>

      <div class="box box-info">
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th width="200">Branch</th>
                    <th width="220">Facility</th>
                    <th>Description</th>
                    <th width="180">Icon</th>
                    <th width="90">Image</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i=0;
                $statement = $pdo->prepare("SELECT f.*, c.nama_cabang FROM tbl_cabang_fasilitas f LEFT JOIN tbl_cabang c ON f.id_cabang = c.id ORDER BY f.id ASC");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                // Ambil semua gambar sekaligus (hindari query berulang di dalam loop)
                $images_by_facility = [];
                if (!empty($result)) {
                    $facility_ids = array_column($result, 'id');
                    $placeholders = implode(',', array_fill(0, count($facility_ids), '?'));
                    $img_statement = $pdo->prepare("SELECT id_fasilitas, gambar FROM tbl_cabang_fasilitas_gambar WHERE id_fasilitas IN ($placeholders) ORDER BY id ASC");
                    $img_statement->execute($facility_ids);
                    $all_images = $img_statement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($all_images as $img) {
                        $images_by_facility[$img['id_fasilitas']][] = $img['gambar'];
                    }
                }

                foreach ($result as $row) {
                    $i++;
                    $facility_images = $images_by_facility[$row['id']] ?? [];
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($row['nama_cabang'] ?? $row['id_cabang'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_fasilitas'] ?? ''); ?></td>
                        <td><?php echo !empty($row['deskripsi']) ? htmlspecialchars($row['deskripsi']) : '-'; ?></td>
                        <td>
                            <?php if (!empty($row['icon'])): ?>
                            <div class="facility-icon-cell">
                                <span class="icon-box"><i class="<?php echo htmlspecialchars($row['icon']); ?>" style="font-size:16px;"></i></span>
                                <span style="font-size:12px; color:#777;"><?php echo htmlspecialchars($row['icon']); ?></span>
                            </div>
                            <?php else: ?>
                            -
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($facility_images)): ?>
                            <div class="facility-thumb">
                                <img src="../assets/uploads/<?php echo htmlspecialchars($facility_images[0]); ?>" alt="">
                                <?php if (count($facility_images) > 1): ?>
                                <span class="thumb-count">+<?php echo count($facility_images) - 1; ?></span>
                                <?php endif; ?>
                            </div>
                            <?php else: ?>
                            <span class="no-thumb">No image</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="branch-facilities-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                            <a href="#" class="btn btn-danger btn-xs" data-href="branch-facilities-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>