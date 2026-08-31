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
        <h1>Branch Katalog</h1>
    </div>
    <div class="content-header-right">
        <a href="branch-katalog-add.php" class="btn btn-primary btn-sm">Add New</a>
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
                        <th width="60">No</th>
                        <th width="180">Branch</th>
                        <th width="200">Photo</th>
                        <th width="130">Start Date</th>
                        <th width="130">End Date</th>
                        <th width="100">Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
            <tbody>
                <?php
                $i=0;
                $statement = $pdo->prepare("SELECT f.*, c.nama_cabang FROM tbl_flyer f LEFT JOIN tbl_cabang c ON f.id_cabang = c.id ORDER BY f.id ASC");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($result as $row) {
                        $i++;

                        $photo_file = !empty($row['photo']) ? '../assets/uploads/' . $row['photo'] : '';
                        $photo_exists = $photo_file && file_exists($photo_file);

                        $today = date('Y-m-d');

                        if (!empty($row['start_date']) && !empty($row['end_date'])) {
                            if ($today < $row['start_date']) {
                                $status = 'Scheduled';
                                $status_class = 'label-warning';
                            } elseif ($today > $row['end_date']) {
                                $status = 'Expired';
                                $status_class = 'label-danger';
                            } else {
                                $status = 'Active';
                                $status_class = 'label-success';
                            }
                        } else {
                            $status = 'No Date';
                            $status_class = 'label-default';
                        }
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($row['nama_cabang'] ?? $row['cabang_id'] ?? ''); ?></td>
                        <td>
                            <?php if($photo_exists): ?>
                                <img src="<?php echo $photo_file; ?>" alt="<?php echo htmlspecialchars($row['photo']); ?>" style="max-width:120px; max-height:80px; display:block; margin-bottom:4px;" />
                            <?php elseif(!empty($row['photo'])): ?>
                                <?php echo htmlspecialchars($row['photo']); ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo !empty($row['start_date']) ? date('d/m/Y', strtotime($row['start_date'])) : '-'; ?>
                        </td>

                        <td>
                            <?php echo !empty($row['end_date']) ? date('d/m/Y', strtotime($row['end_date'])) : '-'; ?>
                        </td>

                        <td>
                            <span class="label <?php echo $status_class; ?>">
                                <?php echo $status; ?>
                            </span>
                        </td>
                        <td>
                            <a href="branch-katalog-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                            <a href="#" class="btn btn-danger btn-xs" data-href="branch-katalog-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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