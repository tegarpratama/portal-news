<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Submenu_model extends CI_Model {

   public function getSubmenu($id){
      $this->db->select('submenu.title', 'submenu.sub_url', 'submenu.is_active');
      $this->db->from('submenu');
      $this->db->join('menu', 'menu.id = submenu.id_menu');
      $this->db->where('submenu.id_menu', $id);
      return $this->db->get();
   }

}

/* End of file Submenu_model.php */
