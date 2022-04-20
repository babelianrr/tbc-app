<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
  }

  public function index()
  {
    $this->goToDefaultPage();
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required|trim');

    if ($this->form_validation->run() == false) {
      $data = ['title' => 'Login'];
      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/login');
      $this->load->view('templates/auth_footer');
    } else {
      $this->_login();
    }
  }

  private function _login()
  {
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    $user = $this->db->get_where('user', ['email' => $email])->row_array();

    if ($user) {
      if ($user['is_active'] == 1) {
        if (password_verify($password, $user['password'])) {
          $data = [
            'email' => $user['email'],
            'role' => $user['role_id']
          ];

          $this->session->set_userdata($data);
          redirect('home');
        } else {
          $this->session->set_flashdata('message', '
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Credentials does not match.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
          </div>');
          redirect('auth');
        }
      } else {
        $this->session->set_flashdata('message', '
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Your account hasn\'t been activated yet. Please check your email to activate.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>');
        redirect('auth');
      }
    } else {
      $this->session->set_flashdata('message', '
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Account not found. Please register.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('auth');
    }
  }

  public function register()
  {
    $this->goToDefaultPage();
    $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[3]');
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
      'is_unique' => 'This email has already taken'
    ]);
    $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', [
      'matches' => 'Passwords doesn\'t match',
      'min_length' => 'Password is too short'
    ]);
    $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]', [
      'matches' => 'Passwords doesn\'t match',
      'min_length' => 'Password is too short'
    ]);

    if ($this->form_validation->run() == false) {
      $data = ['title' => 'Register'];
      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/register');
      $this->load->view('templates/auth_footer');
    } else {
      $email = $this->input->post('email', true);
      $data = [
        'name' => htmlspecialchars($this->input->post('name', true)),
        'email' => htmlspecialchars($email),
        'image' => 'default.png',
        'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
        'role_id' => 2,
        'is_active' => 0,
        'created_at' => time()
      ];

      $token = base64_encode(random_bytes(32));
      $user_token = [
        'email' => $email,
        'token' => $token,
        'created_at' => time()
      ];

      $this->db->insert('user', $data);
      $this->db->insert('user_token', $user_token);

      $this->_sendEmail($token, 'verify');

      $this->session->set_flashdata('message', '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully registering an account. Please check your email (main inbox or spam) to activate the account.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('auth');
    }
  }

  public function logout()
  {
    $this->session->unset_userdata('email');
    $this->session->unset_userdata('role_id');

    redirect('auth');
  }

  public function blocked()
  {
    $data = [
      'title' => 'Access Denied'
    ];

    $this->load->view('templates/header', $data);
    $this->load->view('auth/blocked');
    $this->load->view('templates/footer');
  }

  public function goToDefaultPage()
  {
    if ($this->session->userdata('email')) {
      redirect('home');
    }
  }

  private function _sendEmail($token, $type)
  {
    $this->load->library('Phpmailer_lib');

    $mail = $this->phpmailer_lib->load();

    $mail->isSMTP();
    $mail->Host = 'ssl://smtp.googlemail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'thebabelian@gmail.com'; // your gmail address
    $mail->Password = '2a70f021f09c50be74caf805d7928249f7af0060'; // your gmail password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('account@thebabelianchannel.site', 'TBC App Account'); // your email address to send the email from

    $mail->addAddress($this->input->post('email'));

    $mail->isHTML(true);

    if ($type == 'verify') {
      $mail->Subject = 'Account Verification';
      $mail->Body = 'Welcome to thebabelianchannel.site! Please verify your account by clicking the link below. <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>';
    } else if ($type == 'forgot') {
      $mail->Subject = 'Reset Password';
      $mail->Body = 'Looks like you\'ve forgotten your password. Don\'t worry, you can reset your password by clicking the link below. <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>';
    }

    if (!$mail->send()) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
      return true;
    }
  }

  public function verify()
  {
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    $user = $this->db->get_where('user', ['email' => $email])->row_array();

    if ($user) {
      $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

      if ($user_token) {
        if (time() - $user_token['created_at'] < (60 * 60 * 24)) {

          $this->db->set('is_active', 1);
          $this->db->where('email', $email);
          $this->db->update('user');
          $this->db->delete('user_token', ['email' => $email]);
          $this->session->set_flashdata('message', '
          <div class="alert alert-success alert-dismissible fade show" role="alert">' . $email . ' has been activated. Please login.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
          </div>');
          redirect('auth');
        } else {

          $this->db->delete('user', ['email' => $email]);
          $this->db->delete('user_token', ['email' => $email]);

          $this->session->set_flashdata('message', '
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Failed activating account due to expired token.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
          </div>');
          redirect('auth');
        }
      } else {
        $this->session->set_flashdata('message', '
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Failed activating account due to incorrect token.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
        </div>');
        redirect('auth');
      }
    } else {
      $this->session->set_flashdata('message', '
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Failed activating account due to incorrect email.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('auth');
    }
  }

  public function forgotpassword()
  {
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

    if ($this->form_validation->run() == false) {
      $data = ['title' => 'Forgot Password'];
      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/forgotpassword');
      $this->load->view('templates/auth_footer');
    } else {
      $email = $this->input->post('email');
      $user = $this->db->get_where('user', [
        'email' => $email,
        'is_active' => 1
      ])->row_array();

      if ($user) {
        $token = base64_encode(random_bytes(32));
        $user_token = [
          'email' => $email,
          'token' => $token,
          'created_at' => time()
        ];

        $this->db->insert('user_token', $user_token);
        $this->_sendEmail($token, 'forgot');
        $this->session->set_flashdata('message', '
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          Please check your email to reset your password.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
        </div>');
        redirect('auth/forgotpassword');
      } else {
        $this->session->set_flashdata('message', '
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          The email was not yet registered or activated.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
        </div>');
        redirect('auth/forgotpassword');
      }
    }
  }

  public function resetpassword()
  {
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    $user = $this->db->get_where('user', ['email' => $email])->row_array();

    if ($user) {
      $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

      if ($user_token) {
        if (time() - $user_token['created_at'] < (60 * 60 * 24)) {

          $this->session->set_userdata('reset_email', $email);
          $this->changepassword();
        } else {

          $this->db->delete('user', ['email' => $email]);
          $this->db->delete('user_token', ['email' => $email]);

          $this->session->set_flashdata('message', '
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Failed to reset password due to expired token.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
          </div>');
          redirect('auth');
        }
      } else {
        $this->session->set_flashdata('message', '
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Failed to reset password due to incorrect token.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
        </div>');
        redirect('auth');
      }
    } else {
      $this->session->set_flashdata('message', '
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Failed to reset password due to incorrect email.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('auth');
    }
  }

  public function changepassword()
  {
    if (!$this->session->userdata('reset_email')) {
      redirect('auth');
    }

    $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', [
      'matches' => 'Passwords doesn\'t match',
      'min_length' => 'Password is too short'
    ]);
    $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[6]|matches[password1]', [
      'matches' => 'Passwords doesn\'t match',
      'min_length' => 'Password is too short'
    ]);

    if ($this->form_validation->run() == false) {
      $data = ['title' => 'Forgot Password'];
      $this->load->view('templates/auth_header', $data);
      $this->load->view('auth/changepassword');
      $this->load->view('templates/auth_footer');
    } else {
      $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
      $email = $this->session->userdata('reset_email');

      $this->db->set('password', $password);
      $this->db->where('email', $email);
      $this->db->update('user');

      $this->session->unset_userdata('reset_email');

      $this->session->set_flashdata('message', '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Your password has been changed.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('auth');
    }
  }
}
