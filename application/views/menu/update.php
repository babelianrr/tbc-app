<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= $title ?> | Update Menu</h1>
  <div class="row mb-3">
    <div class="col-lg-8">
      <form action="<?= base_url('menu/update/') . $menu['id'] ?>" method="post">
        <input type="hidden" name="id" value="<?= $menu['id'] ?>">
        <div class="mb-3">
          <div class="form-group">
            <input type="text" class="form-control" id="menu" name="menu" placeholder="Enter Menu Name" value="<?= $menu['menu'] ?>">
          </div>
        </div>
        <div class="mb-3">
          <a href="<?= base_url('menu') ?>" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>