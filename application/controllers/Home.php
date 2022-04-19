<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
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
      'title' => 'Home'
    ];
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('home/index', $data);
    $this->load->view('templates/footer', $data);
  }

  public function about()
  {
    $data = [
      'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
      'title' => 'About'
    ];
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('home/about', $data);
    $this->load->view('templates/footer', $data);
  }

  public function contact()
  {
    $data = [
      'user' => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
      'title' => 'Contact'
    ];
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('home/contact', $data);
    $this->load->view('templates/footer', $data);
  }
}
