<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	var $table = 'category';
	var $id = 'id';
	var $tableJoin = '';
	var $column_order = ['','category_name', 'slug', 'is_active'];
	var $column_search = ['category_name', 'slug', 'is_active'];

   public function __construct()
	{
		parent::__construct();
		$this->load->model('my_model', 'my');
   }
   
	public function ajax_list()
   {
      $list = $this->my->get_datatables();
      $data = [];
      $no = 1;

      foreach($list as $li){
         $row = [];
         $row[] = $no++;
			$row[] = $li->category_name;
			$row[] = $li->slug;
			$row[] = $li->is_active;
         $row[] = 
         '<a class="btn btn-sm btn-warning text-white" href="#" 
         title="Edit" onclick="edit_category('."'" . $li->id . "'".')">
			<i class="fa fa-pencil-alt mr-1"></i> Edit</a>

			<a class="btn btn-sm btn-danger" href="#" 
			title="Delete" onclick="delete_category('."'".$li->id."'".')">
			<i class="fa fa-trash mr-1"></i> Delete</a>';
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

	public function action()
	{
		$this->form_validation->set_rules('category_name','Category','trim|required');

		if($this->form_validation->run() != false){
			$data = [
				'category_name' 	=> $this->input->post('category_name', true),
				'slug'				=> slugify($this->input->post('category_name', true)),
				'is_active'			=> $this->input->post('is_active', true)
			];

			$id = $this->input->post('id', true);

			// For Update
			if(!empty($id)){
				$this->my->update(['id' => $id], $data);
				$status = true;
			}
			// For Insert
			else{
				$this->my->save($data);
				$status = true;
			}

			echo json_encode(["status" => $status]);
		}
	}

	public function delete(){
		$this->my->delete($this->input->post('id', true));
		echo json_encode(["status" => TRUE]);
	}
	

}

/* End of file Category.php */
