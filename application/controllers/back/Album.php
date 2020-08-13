<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Album extends CI_Controller {

   var $table = 'album';
	var $tableJoin = '';
	var $id = 'id';
	var $column_order = ['', 'album_name', 'photo', 'album_seo', 'is_active'];
	var $column_search = ['album_name', 'photo', 'album_seo', 'is_active'];

   public function __construct()
	{
		parent::__construct();
      $this->load->model('my_model', 'my');
      $this->load->model('album_model', 'album');
   }
   
	public function ajax_list()
   {
      $list = $this->my->get_datatables();
      $data = [];
      $no = 1;

      foreach($list as $li){
         $row = [];
         $row[] = $no++;
         $row[] = $li->album_name;
         
         if($li->photo){
            $row[] = '<a href="' . base_url('images/album/' . $li->photo).'" target="_blank"><img src="'.base_url('images/album/' . $li->photo) . '" class="img-responsive" style="max-height:150px; max-width:250px;"/></a>';
         }else{
            $row[] = '(No photo)';
         }

         if($li->album_seo){
            $row[] = '<a href="' . base_url('article/gallery/' . $li->album_seo).'" target="_blank">' .'article/gallery/' . $li->album_seo . '</a>';
         }else{
            $row[] = '(No Link)';
         }

			$row[] = $li->is_active;
         $row[] = 
         '<a class="btn btn-sm btn-warning text-white" href="#" 
         title="Edit" onclick="edit_album('."'" . $li->id . "'".')">
			<i class="fa fa-pencil-alt mr-1"></i> Edit</a>

			<a class="btn btn-sm btn-danger" href="#" 
			title="Delete" onclick="delete_album('."'".$li->id."'".')">
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
      $this->form_validation->set_rules('album_name','Album Name','trim|required');

      if($this->form_validation->run() != false){

         $data = [
            'album_name' => $this->input->post('album_name', true),
            'album_seo' => slugify($this->input->post('album_name', true)),
            'is_active' => $this->input->post('is_active', true),
         ];

         if($this->input->post('remove_photo')){
            if(file_exists('images/album/' . $this->input->post('remove_photo')) && $this->input->post('remove_photo')){
               $this->album->deleteImage($this->input->post('remove_photo'));
            }

            $data['photo'] = '';
         }

         $id = $this->input->post('id', true);

         // For Insert Album
         if(empty($id)){
            
            if(!empty($_FILES['photo']['name'])){
               $upload = $this->album->uploadImage();	
               $data['photo'] = $upload;
            }
            
            $this->my->save($data);
            $status = true;
         }
         // For Update Album
         else{
            if(!empty($_FILES['photo']['name'])){
               $upload = $this->album->uploadImage();
               $album = $this->my->get_by_id($id);

               if(file_exists('images/album/' . $album->photo) && $album->photo){
                  unlink('images/album/' . $album->photo);
               }

               $data['photo'] = $upload;
            }

            $this->my->update(['id' => $id], $data);
            $status = true;
         }

         echo json_encode(["status" => $status]);         
      }
   }

	public function delete(){
      $album = $this->my->get_by_id($this->input->post('id', true));

      if(file_exists('images/album/' . $album->photo) && $album->photo){
         $this->album->deleteImage($album->photo);
      }

		$this->my->delete($this->input->post('id', true));
		echo json_encode(["status" => TRUE]);
   }
   

}

/* End of file Album.php */
