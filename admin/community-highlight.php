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
    .highlight-thumb img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .no-thumb {
        color: #999;
        font-size: 12px;
    }
</style>

<section class="content-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;">
    <div class="content-header-left">
        <h1 style="margin:0;">Community Highlight</h1>
    </div>
    <div class="content-header-right">
        <a href="community-highlight-add.php" class="btn btn-primary btn-sm">Add New</a>
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
                    <th width="90">Image</th>
                    <th width="220">Title</th>
                    <th width="110">Platform</th>
                    <th width="90">Type</th>
                    <th width="150">Author</th>
                    <th width="80">Order</th>
                    <th width="80">Status</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $statement = $pdo->prepare("SELECT * FROM sorotan_komunitas ORDER BY sort_order ASC, id DESC");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $row) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                            <?php if (!empty($row['image'])): ?>
                            <div class="highlight-thumb">
                            <img src="../assets/uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="">                            </div>
                            <?php else: ?>
                            <span class="no-thumb">No image</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo ucfirst(htmlspecialchars($row['platform'])); ?></td>
                        <td>
                            <span class="label <?php echo $row['type'] === 'video' ? 'label-danger' : 'label-info'; ?>">
                                <?php echo ucfirst($row['type']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($row['author']); ?></td>
                        <td><?php echo (int) $row['sort_order']; ?></td>
                        <td>
                            <span class="label <?php echo $row['is_active'] ? 'label-success' : 'label-default'; ?>">
                                <?php echo $row['is_active'] ? 'Active' : 'Inactive'; ?>
                            </span>
                        </td>
                        <td>
                            <a href="community-highlight-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                            <a href="#" class="btn btn-danger btn-xs" data-href="community-highlight-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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