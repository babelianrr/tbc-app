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

    $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[3]');
    $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
    $this->form_validation->set_rules('message', 'Message', 'required|trim|min_length[10]');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('home/contact', $data);
      $this->load->view('templates/footer', $data);
    } else {
      $this->_sendEmail();
      $this->session->set_flashdata('message', '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Your inquiry has been sent.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>');
      redirect('home/contact');
    }
  }

  private function _sendEmail()
  {
    $this->load->library('Phpmailer_lib');

    $mail = $this->phpmailer_lib->load();

    $mail->isSMTP();
    $mail->Host = 'ssl://smtp.googlemail.com';
    $mail->SMTPAuth = true;
    $mail->Username = ''; // your gmail address
    $mail->Password = ''; // your gmail password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('', ''); // your email address to send the email from

    $mail->addAddress(''); // email address to receive the inquiry email
    $mail->isHTML(true);
    $mail->Subject = $this->input->post('email') . ' | Inquiry';
    $mail->Body = 'Name: ' . $this->input->post('name') . '<br>Message: ' . $this->input->post('message');

    if (!$mail->send()) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
      return true;
    }
  }
}
