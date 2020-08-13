<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model {

   public function getAbout()
   {
      return $this->db->get('contact')->row();
   }

}

/* End of file Contact_model.php */
