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
    /* Mengatur ukuran gambar di tabel agar lebih besar & jelas */
.table img, 
table.dataTable tbody td img {
    width: 200px !important;    /* Ubah sesuai selera (contoh: 100px atau 120px) */
    height: auto !important;   /* Menjaga proporsi gambar agar tidak terdistorsi */
    max-height: 100px !important;
    object-fit: contain;      /* Gambar tetap rapi tanpa terpotong */
    border-radius: 6px;        /* Bonus: bikin sudut gambar agak melengkung rapi */
    padding: 2px;
}

/* Menyesuaikan posisi sel tabel agar sejajar di tengah secara vertikal */
.table tbody td {
    vertical-align: middle !important;
}
</style>

<section class="content-header">
    <div class="content-header-left">
        <h1>Winners</h1>
    </div>
    <div class="content-header-right">
        <a href="winners-add.php" class="btn btn-primary btn-sm">Add New</a>
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
                    <th width="30">SL</th>
                    <th width="150">Photo</th>
                    <th>Winner Name</th>
                    <th>Member No.</th>
                    <th>Reward</th>
                    <th>Periode & Program</th>
                    <th>Address</th>
                    <th>Testimonial</th>
                    <th width="120">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                // JOIN 4 Tabel: tbl_winners -> tbl_reward -> tbl_periode -> tbl_program (Urutan ASC)
                $statement = $pdo->prepare("SELECT w.*, r.prize_name, p.periode_name, pr.program_name, pr.year 
                                            FROM tbl_winners w 
                                            LEFT JOIN tbl_reward r ON w.id_reward = r.id 
                                            LEFT JOIN tbl_periode p ON w.id_periode = p.id 
                                            LEFT JOIN tbl_program pr ON p.id_program = pr.id 
                                            ORDER BY w.id ASC");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $row) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                            <?php if(!empty($row['photo']) && file_exists('../assets/uploads/' . $row['photo'])): ?>
                                <img src="../assets/uploads/<?php echo htmlspecialchars($row['photo']); ?>" alt="" style="width:50px;">
                            <?php else: ?>
                                <span style="color:#999; font-size:12px;">No Photo</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['winners_name'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($row['member_number'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($row['prize_name'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars(($row['program_name'] ?? '-') . ' (' . ($row['year'] ?? '-') . ') - ' . ($row['periode_name'] ?? '-')); ?></td>
                        <td><?php echo htmlspecialchars($row['address'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($row['testimonial'] ?? '-'); ?></td>
                        <td>
                            <a href="winners-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                            <a href="#" class="btn btn-danger btn-xs" data-href="winners-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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