<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <div class="row">
            <div class="col-lg">
              <div class="p-5">
                <div class="text-center">
                  <div class="h4 text-gray-900">Reset Your Password</div>
                  <div class="fs-5 text-gray-700 mb-4">Please enter your password for <?= $this->session->userdata('reset_email') ?> to reset</div>
                  <?= $this->session->flashdata('message') ?>
                </div>
                <form class="user" method="post" action="<?= base_url('auth/changepassword') ?>">
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="password1" placeholder="Enter New Password" name="password1">
                    <?= form_error('password1', '<small class="text-danger pl-3">', '</small>') ?>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="password2" placeholder="Repeat New Password" name="password2">
                    <?= form_error('password2', '<small class="text-danger pl-3">', '</small>') ?>
                  </div>
                  <button type="submit" class="btn btn-primary btn-user btn-block">
                    Change Password
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>