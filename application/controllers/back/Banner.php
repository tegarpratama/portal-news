<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends CI_Controller {

   var $table = 'banner';
	var $id = 'id';
   var $tableJoin = '';
	var $column_search = ['title', 'photo'];

   public function __construct()
	{
		parent::__construct();
      $this->load->model('my_model', 'my');
      $this->load->model('banner_model', 'banner');
   }
   
	public function ajax_list()
   {
      $list = $this->my->get_datatables();
      $data = [];
      $no = 1;

      foreach($list as $li){
         $row = [];
         $row[] = $no++;
         $row[] = $li->title;

         if($li->photo){
            $row[] = '<a href="' . base_url('images/banner/' . $li->photo).'" target="_blank"><img src="'.base_url('images/banner/' . $li->photo) . '" class="img-responsive" style="max-height:250px; max-width:650px;"/></a>';
         }else{
            $row[] = '(No photo)';
         }

         $row[] = 
         '<a class="btn btn-sm btn-warning text-white" href="#" 
         title="Edit" onclick="edit_banner('."'" . $li->id . "'".')">
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
      $this->form_validation->set_rules('title','Judul','required');

      if($this->form_validation->run() != false){
         $data = [
            'title' => $this->input->post('title', true),
         ];

         // For Remove Photo
         if($this->input->post('remove_photo')){
            if(file_exists('images/banner/' . $this->input->post('remove_photo')) && $this->input->post('remove_photo')){
               $this->banner->deleteImage($this->input->post('remove_photo'));
            }

            $data['photo'] = '';
         }

         $id = $this->input->post('id', true);

         if(!empty($_FILES['photo']['name'])){
            $upload = $this->banner->uploadImage();
            $banner = $this->my->get_by_id($id);

            if(file_exists('images/banner/' . $banner->photo) && $banner->photo){
               unlink('images/banner/' . $banner->photo);
            }

            $data['photo'] = $upload;
         }

         $this->my->update(['id' => $id], $data);
         $status = true;

         echo json_encode(["status" => $status]);
      }
   }


}

/* End of file Banner.php */
