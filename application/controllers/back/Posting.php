<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Posting extends CI_Controller {

	var $table = 'posting';
	var $tableJoin = 'category';
	var $id = 'id';
	var $select = ['posting.*','category.category_name AS category'];
	var $column_order = ['posting.id','posting.title', 'posting.featured', 'posting.choice', 'posting.thread', 'category.category_name', 'posting.is_active', 'posting.date'];
	var $column_search = ['posting.title', 'posting.seo_title','posting.featured', 'posting.choice', 'posting.thread', 'category.category_name', 'posting.is_active', 'posting.date'];

	public function __construct()
	{
		parent::__construct();
		$this->load->model('my_model', 'my', true);
		$this->load->model('posting_model', 'posting', true);
		$this->load->model('menu_model', 'menu', true);
      $this->load->model('category_model', 'category', true);	
	}
	
	public function ajax_list()
   {
      $list = $this->my->get_datatables($this->tableJoin, $this->select);
      $data = [];
      foreach($list as $li){
			$row = [];
			$row[] = '<input type="checkbox" class="data-check" value="' . $li->id . '">';
			$row[] = $li->title;
			$row[] = $li->featured;
			$row[] = $li->choice;
			$row[] = $li->thread;
			$row[] = $li->category;
			$row[] = $li->is_active;
			$row[] = $li->date;

         $row[] = 
         '<a class="btn btn-sm btn-warning text-white" href="'.base_url("back/posting/update/$li->id").'" 
         title="Edit">
			<i class="fa fa-pencil-alt mr-1"></i></a>

			<a class="btn btn-sm btn-danger" href="#" 
			title="Delete" onclick="delete_posting('."'".$li->id."'".')">
			<i class="fa fa-trash mr-1"></i></a>';
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

	public function create()
	{
		if(!$_POST){
			$input = (object) $this->posting->getDefaultValues();
		}else{
			$input = (object) $this->input->post(null, true);
		}

		$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('content','Content','required');
		$this->form_validation->set_rules('id_category','Category','required');

		if($this->form_validation->run() == false){
			$data['title'] = 'Tambah Posting';
			$data['form_action'] = base_url("back/posting/create");
			$data['menu'] = $this->menu->getMenu();
			$data['category'] = $this->category->getCategory();
			$data['input'] = $input;
			$this->load->view('back/pages/article/form_post', $data);
		}else{
			
			$data = [
				'title' => $this->input->post('title', true),
				'seo_title' => slugify($this->input->post('title', true)),
				'content' => $this->input->post('content', true),
				'featured' => $this->input->post('featured', true),
				'choice' => $this->input->post('choice', true),
				'thread' => $this->input->post('thread', true),
				'id_category' => $this->input->post('id_category', true),
				'is_active' => $this->input->post('is_active', true),
				'date' => date('Y-m-d')
			];

			
			if(!empty($_FILES['photo']['name'])){
				$upload = $this->posting->uploadImage();
				$this->_create_thumbs($upload);	
				$data['photo'] = $upload;
			}
			
			$this->my->save($data);
			$this->session->set_flashdata('success', 'Posting Berhasil Ditambahkan.');

			redirect(base_url('admin/posting'));
		}

	}

	public function update($id)
	{
		$dataPost = $this->posting->getPostingById($id);

		if(!$dataPost){
			$this->session->set_flashdata('warning','Maaf, data tidak dapat ditemukan!');
			redirect(base_url('admin/posting'));
		}

		if(!$_POST){
			$input = $dataPost;
		}else{
			$input = (object) $this->input->post(null, true);
		}

		$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('content','Content','required');
		$this->form_validation->set_rules('id_category','Category','required');

		if($this->form_validation->run() == false){
			$data['title'] = 'Edit Posting';
			$data['form_action'] = base_url("back/posting/update/$id");
			$data['menu'] = $this->menu->getMenu();
			$data['category'] = $this->category->getCategory();
			$data['input'] = $input;
			$this->load->view('back/pages/article/form_post', $data);
		}else{
			
			$data = [
				'title' => $this->input->post('title', true),
				'seo_title' => slugify($this->input->post('title', true)),
				'content' => $this->input->post('content', true),
				'featured' => $this->input->post('featured', true),
				'choice' => $this->input->post('choice', true),
				'thread' => $this->input->post('thread', true),
				'id_category' => $this->input->post('id_category', true),
				'is_active' => $this->input->post('is_active', true),
				'date' => date('Y-m-d')
			];


			if(!empty($_FILES['photo']['name'])){
				$upload = $this->posting->uploadImage();
				$this->_create_thumbs($upload);
				$posting = $this->my->get_by_id($id);

				if(file_exists('images/posting/' . $posting->photo) && $posting->photo){
					unlink('images/posting/' . $posting->photo);
					unlink('images/posting/large/' . $posting->photo);
					unlink('images/posting/medium/' . $posting->photo);
					unlink('images/posting/small/' . $posting->photo);
					unlink('images/posting/xsmall/' . $posting->photo);
				}

				$data['photo'] = $upload;
			}

			$this->my->update(['id' => $id], $data);
			$this->session->set_flashdata('success', 'Posting Berhasil Diupdate.');

			redirect(base_url('admin/posting'));
		}

	}

	public function _create_thumbs($file_name)
	{
		$config = [
			// Large Image
			[
				'image_library'	=> 'GD2',
				'source_image'		=> './images/posting/' . $file_name,
				'maintain_ratio'	=> TRUE,
				'width'				=> 770,
				'height'				=> 450,
				'new_image'			=> './images/posting/large/' . $file_name
			],
			// Medium Image
			[
				'image_library'	=> 'GD2',
				'source_image'		=> './images/posting/' . $file_name,
				'maintain_ratio'	=> FALSE,
				'width'				=> 300,
				'height'				=> 188,
				'new_image'			=> './images/posting/medium/' . $file_name
			],
			// Small Image
			[
				'image_library'	=> 'GD2',
				'source_image'		=> './images/posting/' . $file_name,
				'maintain_ratio'	=> FALSE,
				'width'				=> 270,
				'height'				=> 169,
				'new_image'			=> './images/posting/small/' . $file_name
			],
			// XSmall Image
			[
				'image_library'	=> 'GD2',
				'source_image'		=> './images/posting/' . $file_name,
				'maintain_ratio'	=> FALSE,
				'width'				=> 170,
				'height'				=> 100,
				'new_image'			=> './images/posting/xsmall/' . $file_name
			],
		];

		$this->load->library('image_lib', $config[0]);

		foreach ($config as $item){
			$this->image_lib->initialize($item);

			if(!$this->image_lib->resize()){
				return false;
			}

			$this->image_lib->clear();
		}
	}
	
	public function delete(){
		$id = $this->input->post('id', true);
		$posting = $this->my->get_by_id($id);

		if(file_exists('images/posting/' . $posting->photo) && $posting->photo){
			unlink('images/posting/' . $posting->photo);
			unlink('images/posting/large/' . $posting->photo);
			unlink('images/posting/medium/' . $posting->photo);
			unlink('images/posting/small/' . $posting->photo);
			unlink('images/posting/xsmall/' . $posting->photo);
		}

		$this->my->delete($id);
		echo json_encode(["status" => TRUE]);
	}

	public function bulk_delete()
	{
		$list_id = $this->input->post('id', true);
		
		foreach ($list_id as $id){
			$posting = $this->my->get_by_id($id);
	
			if(file_exists('images/posting/' . $posting->photo) && $posting->photo){
				unlink('images/posting/' . $posting->photo);
				unlink('images/posting/large/' . $posting->photo);
				unlink('images/posting/medium/' . $posting->photo);
				unlink('images/posting/small/' . $posting->photo);
				unlink('images/posting/xsmall/' . $posting->photo);
			}

			$this->my->delete($id);
		}

		echo json_encode(["status" => TRUE]);
	}


}

/* End of file Posting.php */
