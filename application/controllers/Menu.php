<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
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
      'title' => 'Menu Management',
      'menu' => $this->menu->getMenu()
    ];

    $this->form_validation->set_rules('menu', 'Menu', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/index', $data);
      $this->load->view('templates/footer');
    } else {
      $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
      $this->session->set_flashdata('message', '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully adding a menu.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('menu');
    }
  }

  public function update($id)
  {
    $data = [
      'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
      'title' => 'Menu Management',
      'menu' => $this->menu->getOneMenu($id)
    ];

    $this->form_validation->set_rules('menu', 'Menu', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/update', $data);
      $this->load->view('templates/footer');
    } else {
      $this->db->where('id', $this->input->post('id'));
      $this->db->update('user_menu', ['menu' => $this->input->post('menu')]);
      $this->session->set_flashdata('message', '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully adding a menu.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('menu');
    }
  }

  public function submenu()
  {
    $data = [
      'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
      'title' => 'Submenu Management',
      'menu' => $this->db->get('user_menu')->result_array(),
      'subMenu' => $this->menu->getSubMenu()
    ];

    $this->form_validation->set_rules('title', 'Title', 'required|trim');
    $this->form_validation->set_rules('menu_id', 'Menu', 'required');
    $this->form_validation->set_rules('url', 'URL', 'required|trim');
    $this->form_validation->set_rules('icon', 'Icon', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/submenu', $data);
      $this->load->view('templates/footer');
    } else {
      $data = [
        'title' => $this->input->post('title'),
        'menu_id' => $this->input->post('menu_id'),
        'url' => $this->input->post('url'),
        'icon' => $this->input->post('icon'),
        'is_active' => $this->input->post('is_active'),
      ];
      $this->db->insert('user_sub_menu', $data);
      $this->session->set_flashdata('message', '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully adding a submenu.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('menu/submenu');
    }
  }

  public function updatesubmenu($id)
  {
    $data = [
      'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
      'title' => 'Submenu Management',
      'submenu' => $this->menu->getOneSubMenu($id),
      'menu' => $this->menu->getMenu()
    ];

    $this->form_validation->set_rules('title', 'Title', 'required|trim');
    $this->form_validation->set_rules('menu_id', 'Menu', 'required');
    $this->form_validation->set_rules('url', 'URL', 'required|trim');
    $this->form_validation->set_rules('icon', 'Icon', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('menu/updatesubmenu', $data);
      $this->load->view('templates/footer');
    } else {
      $data = [
        'title' => $this->input->post('title'),
        'menu_id' => $this->input->post('menu_id'),
        'url' => $this->input->post('url'),
        'icon' => $this->input->post('icon'),
        'is_active' => $this->input->post('is_active'),
      ];
      $this->db->where('id', $this->input->post('id'));
      $this->db->update('user_sub_menu', $data);
      $this->session->set_flashdata('message', '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully updating a menu.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('menu/submenu');
    }
  }

  public function delsubmenu($id)
  {
    $this->menu->deleteSubMenu($id);
    $this->session->set_flashdata('message', '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Successfully deleting a submenu.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>');
    redirect('menu/submenu');
  }
}
