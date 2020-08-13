<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

	var $table = 'contact';
	var $id = 'id';
	var $tableJoin = '';
	var $column_order = [];
	var $column_search = [];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('my_model', 'my', true);
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
			$row[] = $li->contact_name;
			$row[] = $li->description;
         $row[] = 
         '<a class="btn btn-sm btn-warning text-white" href="#" 
         title="Edit" onclick="edit_contact('."'" . $li->id . "'".')">
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
		$this->form_validation->set_rules('contact_name','Contact','trim|required');
		$this->form_validation->set_rules('description','Description','required');

		if($this->form_validation->run() != false){
			$data = [
				'contact_name' => $this->input->post('contact_name', true),
				'description'  => $this->input->post('description', true)
			];

			$id = $this->input->post('id');
			$this->my->update([$this->id, $id], $data);
			echo json_encode(['status' => TRUE]);
		}
	}

}

/* End of file Contact.php */
