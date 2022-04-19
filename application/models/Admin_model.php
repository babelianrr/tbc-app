<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
  public function getRoles()
  {
    return $this->db->get('user_role')->result_array();
  }

  public function getRole($id)
  {
    return $this->db->get_where('user_role', ['id' => $id])->row_array();
  }

  public function deleteRole($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('user_role');
  }
}
