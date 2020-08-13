<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {

   var $table = 'gallery';
	var $id = 'id';
   var $tableJoin = 'album';
	var $select = ['gallery.*','album.album_name AS album_name'];
	var $column_order = ['', 'gallery.gallery_name', '', 'album.album_name', '', 'is_active'];
	var $column_search = ['gallery.gallery_name', 'gallery.information', 'album.album_name', 'gallery.is_active'];

   public function __construct()
	{
		parent::__construct();
      $this->load->model('my_model', 'my');
      $this->load->model('gallery_model', 'gallery');
   }
   
	public function ajax_list()
   {
      $list = $this->my->get_datatables();
      $data = [];
      $no = 1;

      foreach($list as $li){
         $row = [];
         $row[] = $no++;
         $row[] = $li->gallery_name;
         $row[] = $li->information;
         $row[] = $li->album_name;

         if($li->photo){
            $row[] = '<a href="' . base_url('images/gallery/' . $li->photo).'" target="_blank"><img src="'.base_url('images/gallery/' . $li->photo) . '" class="img-responsive" style="max-height:150px; max-width:250px;"/></a>';
         }else{
            $row[] = '(No photo)';
         }

         $row[] = $li->is_active;
         $row[] = 
         '<a class="btn btn-sm btn-warning text-white" href="#" 
         title="Edit" onclick="edit_gallery('."'" . $li->id . "'".')">
			<i class="fa fa-pencil-alt mr-1"></i> Edit</a>

			<a class="btn btn-sm btn-danger" href="#" 
			title="Delete" onclick="delete_gallery('."'".$li->id."'".')">
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
      $this->form_validation->set_rules('gallery_name','Galeri','trim|required');

      if($this->form_validation->run() != false){

         if(empty($this->input->post('id_album', true))){
				echo json_encode(["status" => FALSE]);
         }else{

            $data = [
               'id_album' => $this->input->post('id_album', true),
               'gallery_name' => $this->input->post('gallery_name', true),
               'gallery_seo' => slugify($this->input->post('gallery_name', true)),
               'information' => $this->input->post('information', true),
               'is_active' => $this->input->post('is_active', true),
            ];

            if($this->input->post('remove_photo')){
					if(file_exists('images/gallery/' . $this->input->post('remove_photo')) && $this->input->post('remove_photo')){
						$this->gallery->deleteImage($this->input->post('remove_photo'));
					}
	
					$data['photo'] = '';
				}

            $id = $this->input->post('id', true);
   
            // For Insert Gallery
            if(empty($id)){

               if(!empty($_FILES['photo']['name'])){
						$upload = $this->gallery->uploadImage();	
						$data['photo'] = $upload;
					}
					
					$this->my->save($data);
					$status = true;
            }
            // For Update gallery
            else{
               if(!empty($_FILES['photo']['name'])){
						$upload = $this->gallery->uploadImage();
						$gallery = $this->my->get_by_id($id);
	
						if(file_exists('images/gallery/' . $gallery->photo) && $gallery->photo){
							unlink('images/gallery/' . $gallery->photo);
						}
	
						$data['photo'] = $upload;
					}
	
					$this->my->update(['id' => $id], $data);
               $status = true;
            }
   
            echo json_encode(["status" => $status]);
         }

      }
   }

   public function delete(){
      $id = $this->input->post('id', true);
      $gallery = $this->my->get_by_id($id);

      if(file_exists('images/gallery/' . $gallery->photo) && $gallery->photo){
         $this->gallery->deleteImage($gallery->photo);
      }

		$this->my->delete($id);
		echo json_encode(["status" => TRUE]);
   }

}

/* End of file Gallery.php */
