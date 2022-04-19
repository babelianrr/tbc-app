<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= $title ?> | Update Submenu</h1>
  <div class="row mb-3">
    <div class="col-lg-8">
      <form action="<?= base_url('menu/updatesubmenu/') . $submenu['id'] ?>" method="post">
        <div class="mb-3">
          <input type="hidden" name="id" id="id" value="<?= $submenu['id'] ?>">
          <div class="form-group">
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Submenu Name" value="<?= $submenu['title'] ?>">
          </div>
          <div class="form-group">
            <select name="menu_id" id="menu_id" class="form-control">
              <?php foreach ($menu as $m) : ?>
                <?php if ($submenu['menu_id'] == $m['id']) : ?>
                  <option value="<?= $m['id'] ?>" selected><?= $m['menu'] ?></option>
                <?php else : ?>
                  <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="url" name="url" placeholder="Enter URL" value="<?= $submenu['url'] ?>">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="icon" name="icon" placeholder="Enter Icon Classes" value="<?= $submenu['icon'] ?>">
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="<?= $submenu['is_active'] ?>" name="is_active" id="is_active" <?= $submenu['is_active'] == 1 ? 'checked' : '' ?>>
              <label class="form-check-label" for="is_active">
                Active?
              </label>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <a href="<?= base_url('menu/submenu') ?>" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>