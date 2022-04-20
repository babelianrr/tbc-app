<div class="container-fluid">
  <div class="row mt-5 mb-5">
    <div class="col-lg-9">
      <h1><?= $title ?> Us</h1>
      <div class="row">
        <div class="col-lg-9">
          <?= $this->session->flashdata('message') ?>
          <form action="<?= base_url('home/contact') ?>" method="post">
            <div class="form-group mb-3">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" name="name">
              <?= form_error('name', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="form-group mb-3">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email">
              <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="form-group mb-3">
              <label for="message">Your Message</label>
              <textarea class="form-control" id="message" name="message" rows="5"></textarea>
              <?= form_error('message', '<small class="text-danger pl-3">', '</small>') ?>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-info"><i class="fas fa-paper-plane"></i> Send</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>