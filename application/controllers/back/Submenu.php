<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Submenu extends CI_Controller {

	var $table = 'submenu';
	var $id = 'id';
	var $tableJoin = 'menu';
	var $select = ['submenu.*','menu.title AS menu_title'];
	var $column_order = ['','submenu.sub_title', 'submenu.sub_url', 'submenu.id_menu','submenu.is_active'];
	var $column_search = ['submenu.sub_title', 'submenu.sub_url','submenu.is_active'];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('my_model', 'my', true);
	}

	public function ajax_list()
   {
      $list = $this->my->get_datatables();
      $data = [];
      $no = 1;

      foreach($list as $li){
         $row = [];
         $row[] = $no++;
			$row[] = $li->sub_title;
			$row[] = $li->sub_url;
			$row[] = $li->menu_title;
			$row[] = $li->is_active;
         $row[] = 
         '<a class="btn btn-sm btn-warning text-white" href="#" 
         title="Edit" onclick="edit_submenu('."'" . $li->id . "'".')">
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

	public function action()
	{
		$this->form_validation->set_rules('sub_title','Submenu','trim|required');
		$this->form_validation->set_rules('sub_url','URL','trim|required');
		$this->form_validation->set_rules('id_menu','Menu Utama','trim|required');

		if($this->form_validation->run() != false){
			$data = [
				'id_menu' => $this->input->post('id_menu', true),
				'sub_title' => $this->input->post('sub_title', true),
				'sub_url'  => $this->input->post('sub_url', true),
				'is_active'  => $this->input->post('is_active', true)
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

/* End of file Submenu.php */
