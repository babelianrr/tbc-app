<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
  public function getMenu()
  {
    return $this->db->get('user_menu')->result_array();
  }

  public function getOneMenu($id)
  {
    return $this->db->get_where('user_menu', ['id' => $id])->row_array();
  }

  public function getSubMenu()
  {
    $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu` 
                FROM `user_sub_menu` JOIN `user_menu`
                  ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
             ";

    return $this->db->query($query)->result_array();
  }

  public function getOneSubMenu($id)
  {
    $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu` 
                FROM `user_sub_menu` JOIN `user_menu`
                  ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
               WHERE `user_sub_menu`.`id` = $id
             ";

    return $this->db->query($query)->row_array();
  }

  public function deleteSubMenu($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('user_sub_menu');
  }
}
