<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

  <div class="row">
    <div class="col-lg-8">
      <?= form_open_multipart('user/update') ?>
      <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="email" id="email" value="<?= $user['email'] ?>" readonly>
        </div>
      </div>
      <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">Full Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="name" id="name" value="<?= $user['name'] ?>">
          <?= form_error('name', '<small class="text-danger pl-3">', '</small>') ?>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-2">Image</div>
        <div class="col-sm-10">
          <div class="row">
            <div class="col-sm-4">
              <img src="<?= base_url('assets/img/profile/') . $user['image'] ?>" class="img-thumbnail" alt="" />
            </div>
            <div class="col-sm-8">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="image" name="image">
                <label class="custom-file-label" for="image">Choose file</label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group row d-flex justify-content-end">
        <div class="col-sm-10">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
      </form>
    </div>
  </div>

</div>
</div>