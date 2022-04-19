<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    auth_check();
  }

  public function index()
  {
    $data = [
      'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
      'title' => 'My Profile'
    ];

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('user/index', $data);
    $this->load->view('templates/footer');
  }

  public function update()
  {
    $data = [
      'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
      'title' => 'Update Profile'
    ];

    $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('user/update', $data);
      $this->load->view('templates/footer');
    } else {
      $email = $this->input->post('email');
      $name = $this->input->post('name');

      $uploadImg = $_FILES['image']['name'];
      if ($uploadImg) {
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size']      = '2048';
        $config['upload_path']   = './assets/img/profile/';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
          $oldImg = $data['user']['image'];
          if ($oldImg != 'default.png') {
            unlink(FCPATH . 'assets/img/profile/' . $oldImg);
          }
          $newImg = $this->upload->data('file_name');
          $this->db->set('image', $newImg);
        } else {
          echo $this->upload->display_errors();
        }
      }

      $this->db->set('name', $name);
      $this->db->where('email', $email);
      $this->db->update('user');
      $this->session->set_flashdata('message', '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully updated profile.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('user');
    }
  }

  public function changepassword()
  {
    $data = [
      'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
      'title' => 'Change Password'
    ];

    $this->form_validation->set_rules('currentPassword', 'Current Password', 'required|trim', [
      'required' => 'Please input your current password.'
    ]);
    $this->form_validation->set_rules('newPassword1', 'New Password', 'required|trim|min_length[6]|matches[newPassword2]', [
      'required' => 'Please input your new password.',
      'min_length' => 'New password must be at least 6 characters.',
      'matches' => 'Please input matching password.'
    ]);
    $this->form_validation->set_rules('newPassword2', 'Confirm Password', 'required|trim|min_length[6]|matches[newPassword1]', [
      'required' => 'Please confirm your new password.',
      'min_length' => 'New password must be at least 6 characters.',
      'matches' => 'Please input matching password.'
    ]);

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('user/changepassword', $data);
      $this->load->view('templates/footer');
    } else {
      $currentPassword = $this->input->post('currentPassword');
      $newPassword = $this->input->post('newPassword1');
      if (!password_verify($currentPassword, $data['user']['password'])) {
        $this->session->set_flashdata('message', '
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          Your credential is incorrect. Please try again.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
        </div>');
        redirect('user/changepassword');
      } else {
        if ($currentPassword == $newPassword) {
          $this->session->set_flashdata('message', '
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Please refrain from using old password.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
          </div>');
          redirect('user/changepassword');
        } else {
          $password_hash = password_hash($newPassword, PASSWORD_DEFAULT);
          $this->db->set('password', $password_hash);
          $this->db->where('email', $this->session->userdata('email'));
          $this->db->update('user');
          $this->session->set_flashdata('message', '
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            Your password has been changed.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
          </div>');
          redirect('user');
        }
      }
    }
  }
}
