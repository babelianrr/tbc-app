<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>


  <div class="row">
    <div class="col-lg-6">
      <?php if (validation_errors()) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <?= validation_errors() ?>
        </div>
      <?php endif; ?>
      <?= $this->session->flashdata('message') ?>
      <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newModal">Add New Menu</a>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Menu</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($menu as $m) : ?>
            <tr>
              <th scope="row"><?= $i ?>.</th>
              <td><?= $m['menu'] ?></td>
              <td>
                <a href="<?= base_url('menu/update/') . $m['id'] ?>" class="badge badge-info">Update</a>
                <a href="<?= base_url('menu/delete') ?>" class="badge badge-danger" onclick="return confirm('Are you sure to delete this menu?');">Delete</a>
              </td>
            </tr>
            <?php $i++; ?>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newModalLabel">Add New Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('menu') ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" id="menu" name="menu" placeholder="Enter Menu Name">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>