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
</style>

<section class="content-header">
    <div class="content-header-left">
        <h1>Branch Promo</h1>
    </div>
    <div class="content-header-right">
        <a href="branch-promo-add.php" class="btn btn-primary btn-sm">Add New</a>
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
                    <th>SL</th>
                    <th width="170">Branch</th>
                    <th width="120">Badge</th>
                    <th width="140">Category</th>
                    <th>Product Name</th>
                    <th>Regular Price</th>
                    <th>Promo Price</th>
                    <th>Photo</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i=0;
                $statement = $pdo->prepare("SELECT p.*, c.nama_cabang FROM tbl_cabang_promo p LEFT JOIN tbl_cabang c ON p.id_cabang = c.id ORDER BY p.id ASC");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $row) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($row['nama_cabang'] ?? $row['id_cabang'] ?? ''); ?></td>
                        <td><?php echo !empty($row['badge']) ? htmlspecialchars($row['badge']) : '-'; ?></td>
                        <td><?php echo !empty($row['kategori']) ? htmlspecialchars($row['kategori']) : '-'; ?></td>
                        <td><?php echo htmlspecialchars($row['nama_produk'] ?? ''); ?></td>
                        <td><?php echo !empty($row['harga_coret']) ? htmlspecialchars($row['harga_coret']) : '-'; ?></td>
                        <td><?php echo htmlspecialchars($row['harga_promo'] ?? ''); ?></td>
                        <td>
                            <?php if(!empty($row['foto'])): ?>
                                <img src="../assets/uploads/<?php echo htmlspecialchars($row['foto']); ?>" alt="" style="max-width:120px;height:auto;object-fit:contain;background:#f5f5f5;">
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="branch-promo-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                            <a href="#" class="btn btn-danger btn-xs" data-href="branch-promo-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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