<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter PHPMailer Class
 *
 * This class enables SMTP email with PHPMailer
 *
 * @category    Libraries
 * @author      Babelian
 * @link        https://thebabelianchannel.site
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailer_Lib
{
  public function __construct()
  {
    log_message('Debug', 'PHPMailer class is loaded.');
  }

  public function load()
  {
    // Include PHPMailer library files
    require_once APPPATH . '../vendor/phpmailer/phpmailer/src/Exception.php';
    require_once APPPATH . '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require_once APPPATH . '../vendor/phpmailer/phpmailer/src/SMTP.php';

    $mail = new PHPMailer;
    return $mail;
  }
}
