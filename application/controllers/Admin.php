<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
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
      'title' => 'Dashboard'
    ];

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/index', $data);
    $this->load->view('templates/footer');
  }

  public function role()
  {
    $data = [
      'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
      'title' => 'Role Management',
      'role' => $this->admin->getRoles()
    ];

    $this->form_validation->set_rules('role', 'Role', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('admin/role', $data);
      $this->load->view('templates/footer');
    } else {
      $this->db->insert('user_role', ['role' => $this->input->post('role')]);
      $this->session->set_flashdata('message', '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully adding a role.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('admin/role');
    }
  }

  public function updaterole($id)
  {
    $data = [
      'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
      'title' => 'Role Management',
      'role' => $this->admin->getRole($id)
    ];

    $this->form_validation->set_rules('role', 'Role', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('admin/updaterole', $data);
      $this->load->view('templates/footer');
    } else {
      $this->db->where('id', $this->input->post('id'));
      $this->db->update('user_role', ['role' => $this->input->post('role')]);
      $this->session->set_flashdata('message', '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully updating a role.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('admin/role');
    }
  }

  public function deleterole($id)
  {
    $this->admin->deleteRole($id);
    $this->session->set_flashdata('message', '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully deleting a role.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>');
    redirect('admin/role');
  }

  public function roleaccess($role_id)
  {
    $data = [
      'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
      'title' => 'Role Management',
      'role' => $this->db->get_where('user_role', [
        'id' => $role_id
      ])->row_array()
    ];
    $this->db->where('id >', 2);
    $data['menu'] = $this->db->get('user_menu')->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('admin/roleaccess', $data);
    $this->load->view('templates/footer');
  }

  public function changeaccess()
  {
    $menu_id = $this->input->post('menuId');
    $role_id = $this->input->post('roleId');

    $data = [
      'menu_id' => $menu_id,
      'role_id' => $role_id
    ];

    $result = $this->db->get_where('user_access_menu', $data);

    if ($result->num_rows() < 1) {
      $this->db->insert('user_access_menu', $data);
    } else {
      $this->db->delete('user_access_menu', $data);
    }

    $this->session->set_flashdata('message', '
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      User access has been updated.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
      </button>
    </div>');
  }
}
