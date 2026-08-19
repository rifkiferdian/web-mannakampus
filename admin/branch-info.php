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
        <h1>Branch Information</h1>
    </div>
    <div class="content-header-right">
        <a href="branch-info-add.php" class="btn btn-primary btn-sm">Add New</a>
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
                    <th width="200">Branch Name</th>
                    <th width="220">Address</th>
                    <th>Operating Hours</th>
                    <th>Contact</th>
                    <th width="100">Badge Type</th>
                    <th>Image</th>
                    <th width="200">Maps Link</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i=0;
                $statement = $pdo->prepare("SELECT * FROM tbl_cabang ORDER BY id ASC");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
                
                foreach ($result as $row) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['nama_cabang']; ?></td>
                        <td><?php echo $row['alamat']; ?></td>
                        <td><?php echo $row['jam_operasional']; ?></td>
                        <td><?php echo $row['kontak']; ?></td>
                        <td><?php echo $row['badge_tipe']; ?></td>
                        <td>
                            <?php if(!empty($row['foto'])): ?>
                                <img src="../assets/uploads/<?php echo htmlspecialchars($row['foto']); ?>" alt="" style="max-width:120px;height:auto;object-fit:contain;background:#f5f5f5;">
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['link_maps']; ?></td>
                        <td>
                            <a href="branch-info-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                            <a href="#" class="btn btn-danger btn-xs" data-href="branch-info-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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