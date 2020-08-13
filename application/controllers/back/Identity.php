<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Identity extends CI_Controller {

   var $table = 'identity';
   var $id = 'id';
	var $tableJoin = '';
   var $column_order = [];
   var $column_search = [];
  
   public function __construct()
   {
      parent::__construct();
      $this->load->model('my_model', 'my', true);
      $this->load->model('identity_model', 'identity', true);
   }

   public function ajax_list()
   {
      $list = $this->my->get_datatables();
      $data = [];
      $no = $_POST['start'];

      foreach($list as $li){
         $no++;
         $row = [];
         $row[] = $no++;
         $row[] = $li->web_name;
         $row[] = 
         '<a class="btn btn-sm btn-warning text-white" href="#" 
         title="Edit" onclick="edit_identity('."'" . $li->id . "'".')">
         <i class="fa fa-pencil-alt mr-1"></i> Edit</a>';
         $data[] = $row;
      }

      $output = [
         'draw'            => $_POST['draw'],
         'recordsTotal'    => $this->my->count_all(),
         'recordsFiltered' => $this->my->count_filtered(),
         'data'            => $data
      ];

      echo json_encode($output);
   }

   public function get_data()
   {
      $data = $this->my->get_by_id($this->input->post('id', true));
      echo json_encode($data);
   }

   public function update()
   {
      $this->form_validation->set_rules('web_name','Web Name','trim|required');

		if($this->form_validation->run() != false){
			$data = [
				'web_name' => $this->input->post('web_name', true),
            'web_address'  => $this->input->post('web_address', true),
				'meta_description'  => $this->input->post('meta_description', true),
				'meta_keyword'  => $this->input->post('meta_keyword', true)
         ];

         if($this->input->post('remove_photo')){
            $this->identity->deleteImage($this->input->post('remove_photo'));
            $data['photo'] = '';
         }
      
         if(!empty($_FILES['photo']['name'])){
            $upload = $this->identity->uploadImage();
            $identity = $this->my->get_by_id($this->input->post('id'));

            if(file_exists('images/favicon/' . $identity->photo) && $identity->photo){
               $this->identity->deleteImage($identity->photo);
            }

            $data['photo'] = $upload;

         }

			$id = $this->input->post('id', true);
			$this->my->update([$this->id, $id], $data);
			echo json_encode(['status' => TRUE]);
		}
      
   }  
  

}

/* End of file Identity.php */
