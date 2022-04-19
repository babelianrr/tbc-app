<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <div class="row">
            <div class="col-lg">
              <div class="p-5">
                <div class="text-center">
                  <div class="h4 text-gray-900">Forgot Your Password?</div>
                  <div class="fs-5 text-gray-700 mb-4">Please enter your email to verify that this is you.</div>
                  <?= $this->session->flashdata('message') ?>
                </div>
                <form class="user" method="post" action="<?= base_url('auth/forgotpassword') ?>">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="email" placeholder="Enter Email Address" name="email" value="<?= set_value('email') ?>">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                  </div>
                  <button type="submit" class="btn btn-primary btn-user btn-block">
                    Reset Password
                  </button>
                </form>
                <hr>
                <div class="text-center">
                  <a class="small" href="<?= base_url('auth') ?>">&larr; Back to Login</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>