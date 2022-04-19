<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>


  <div class="row">
    <div class="col-lg-10">
      <?php if (validation_errors()) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <?= validation_errors() ?>
        </div>
      <?php endif; ?>
      <?= $this->session->flashdata('message') ?>
      <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newModal">Add New Submenu</a>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Submenu</th>
            <th scope="col">Menu</th>
            <th scope="col">URL</th>
            <th scope="col">Icon</th>
            <th scope="col">Active</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($subMenu as $sm) : ?>
            <tr>
              <th scope="row"><?= $i ?>.</th>
              <td><?= $sm['title'] ?></td>
              <td><?= $sm['menu'] ?></td>
              <td><?= $sm['url'] ?></td>
              <td><i class="<?= $sm['icon'] ?>"></i></td>
              <td><?= $sm['is_active'] == 1 ? 'Active' : 'Inactive' ?></td>
              <td>
                <a href="<?= base_url('menu/updatesubmenu/') . $sm['id'] ?>" class="badge badge-info">Update</a>
                <a href="<?= base_url('menu/deletesubmenu/') . $sm['id'] ?>" class="badge badge-danger" onclick="return confirm('Are you sure to delete this submenu?');">Delete</a>
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
        <h5 class="modal-title" id="newModalLabel">Add New Submenu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('menu/submenu') ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Submenu Name">
          </div>
          <div class="form-group">
            <select name="menu_id" id="menu_id" class="form-control">
              <option value="">Select Menu Name</option>
              <?php foreach ($menu as $m) : ?>
                <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="url" name="url" placeholder="Enter URL">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="icon" name="icon" placeholder="Enter Icon Classes">
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" checked>
              <label class="form-check-label" for="is_active">
                Active?
              </label>
            </div>
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