<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
  <div class="row">
    <div class="col-lg-7">
      <?= form_error('role', '<div class="alert alert-warning alert-dismissible fade show" role="alert">', '</div>'); ?>
      <?= $this->session->flashdata('message') ?>
      <form action="<?= base_url('admin/updaterole/') . $role['id'] ?>" method="post">
        <input type="hidden" name="id" value="<?= $role['id'] ?>">
        <div class="mb-3">
          <div class="form-group">
            <input type="text" class="form-control" id="role" name="role" placeholder="Enter Role Name" value="<?= $role['role'] ?>">
          </div>
        </div>
        <div class="mb-3">
          <a href="<?= base_url('admin/role') ?>" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>