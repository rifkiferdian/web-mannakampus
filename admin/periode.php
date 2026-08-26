<?php require_once('header.php'); ?>

<?php
if(isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}
?>

<style>
    #example1 td {
        word-break: break-all;
    }
</style>

<section class="content-header">
    <div class="content-header-left">
        <h1>Periode</h1>
    </div>
    <div class="content-header-right">
        <a href="periode-add.php" class="btn btn-primary btn-sm">Add New</a>
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
                    <th width="50">SL</th>
                    <th>Program Name</th>
                    <th width="100">Year</th>
                    <th>Periode Name</th>
                    <th width="150">Draw Date</th>
                    <th width="140">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                // Mengambil program_name dan year dari tbl_program
                $statement = $pdo->prepare("SELECT p.*, pr.program_name, pr.year 
                                            FROM tbl_periode p 
                                            LEFT JOIN tbl_program pr ON p.id_program = pr.id 
                                            ORDER BY p.id ASC");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $row) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($row['program_name'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['year'] ?? '-'); ?></td>                        <td><?php echo htmlspecialchars($row['periode_name'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['draw_date'] ?? ''); ?></td>
                        <td>
                            <a href="periode-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                            <a href="#" class="btn btn-danger btn-xs" data-href="periode-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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