<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Posting_model extends CI_Model {

   public $perPage = 5;

   public function getChoice()
   {
      $this->db->from('posting');
      $this->db->join('category', 'category.id = posting. id_category');
      $this->db->where('choice', 'Y');
      $this->db->where('posting.is_active', 'Y');
      $this->db->order_by('posting.id', 'desc');
      $this->db->limit(4);
      return $this->db->get()->result();
   }

   public function getThread()
   {
      $this->db->from('posting');
      $this->db->join('category', 'category.id = posting. id_category');
      $this->db->where('thread', 'Y');
      $this->db->where('posting.is_active', 'Y');
      $this->db->order_by('posting.id', 'desc');
      $this->db->limit(4);
      return $this->db->get()->result();
   }

   public function getFeatured()
   {
      $this->db->from('posting');
      $this->db->join('category', 'category.id = posting. id_category');
      $this->db->where('featured', 'Y');
      $this->db->where('posting.is_active', 'Y');
      $this->db->order_by('posting.id', 'desc');
      $this->db->limit(3);
      return $this->db->get()->result();
   }
  
   public function getLastNews()
   {
      $this->db->from('posting');
      $this->db->join('category', 'category.id = posting. id_category');
      $this->db->where('posting.is_active', 'Y');
      $this->db->order_by('posting.id', 'desc');
      $this->db->limit(4);
      return $this->db->get()->result();
   }

   public function getMostPopular()
   {
      $this->db->from('posting');
      $this->db->join('category', 'category.id = posting. id_category');
      $this->db->where('thread', 'Y');
      $this->db->where('posting.is_active', 'Y');
      $this->db->order_by('posting.id', 'desc');
      $this->db->limit(1);
      return $this->db->get()->row();
   }

   public function getVideoGames()
   {
      $this->db->from('posting');
      $this->db->join('category', 'category.id = posting. id_category');
      $this->db->where('category.slug', 'video-game');
      $this->db->where('posting.is_active', 'Y');
      $this->db->order_by('posting.id', 'desc');
      $this->db->limit(5);
      return $this->db->get()->result();
   }
   
   public function getAllPosting($page)
   {
      $this->db->from('posting');
      $this->db->join('category', 'category.id = posting. id_category');
      $this->db->where('posting.is_active', 'Y');
      $this->paginate($page);
      $this->db->order_by('posting.id', 'desc');
      return $this->db->get()->result();
   }

   public function getPosting($seo_title)
   {
      $this->db->from('posting');
      $this->db->join('category', 'category.id = posting. id_category');
      $this->db->where('seo_title', $seo_title);
      return $this->db->get()->row();
   }

   public function getPostingById($id)
   {
      $this->db->from('posting');
      $this->db->join('category', 'category.id = posting. id_category');
      $this->db->where('posting.id', $id);
      return $this->db->get()->row();
   }

   public function getPostingByCategory($category, $page)
   {
      $this->db->from('posting');
      $this->db->join('category', 'category.id = posting. id_category');
      $this->db->where('posting.is_active', 'Y');
      $this->db->where('category.slug', $category);
      $this->paginate($page);
      $this->db->order_by('posting.id', 'desc');
      return $this->db->get()->result();
   }

   public function countPosting($category = null)
   {
      if($category){
         $idCategory = $this->_getIdCategory($category);
         $this->db->where('id_category', $idCategory->id);
      }

      $this->db->where('posting.is_active', 'Y');  
      return $this->db->count_all_results('posting');
   }

   public function _getIdCategory($category)
   {
      $this->db->where('slug', $category);
      return $this->db->get('category')->row();
   }

   public function getDefaultValues()
   {
      return [
         'title'        => '',
         'seo_title'    => '',
         'content'      => '',
         'featured'     => 'N',
         'choice'       => 'N',
         'thread'       => 'N',
         'id_category'  => '',
         'photo'        => '',
         'is_active'    => 'Y',
         'date'         => ''
      ];
   }

   public function uploadImage(){

      $config = [
        'upload_path'     => './images/posting',
        'encrypt_name'    => TRUE,
        'allowed_types'   => 'jpg|jpeg|gif|png|JPG|PNG',
        'max_size'        => 1000,
        'max_width'       => 0,
        'max_height'      => 0,
        'overwrite'       => TRUE,
        'file_ext_tolower'=> TRUE
      ];
  
      $this->load->library('upload', $config);
  
      if(!$this->upload->do_upload('photo')){
        $data['error_string'] = 'Upload error: '.$this->upload->display_errors('',''); 
        exit();
      }
      return $this->upload->data('file_name');
   }
  
   public function deleteImage($fileName){
      if(file_exists("./images/posting/$fileName")){
        unlink("./images/posting/$fileName");
      }
   }

   public function paginate($page){
      return  $this->db->limit($this->perPage, $this->calculateRealOffset($page));
   }
  
   public function calculateRealOffset($page){
      if(is_null($page) || empty($page)){
         $offset = 0;
      }else{
         $offset = ($page * $this->perPage) - $this->perPage;
      }
      
      return $offset;
   }
  
   public function makePagination($baseUrl, $uriSegment, $totalRows = null){
      $this->load->library('pagination');

      $config = [
         'base_url'            => $baseUrl,
         'uri_segment'         => $uriSegment,
         'per_page'            => $this->perPage,
         'total_rows'          => $totalRows,
         'use_page_numbers'    => true,
         
         'full_tag_open'       => '<ul class="pagination justify-content-center">',
         'full_tag_close'      => '</ul>',
         
         'attributes'          => ['class' => 'page-link text-danger'],
         'first_link'          => false,
         'last_link'           => false,
         'first_tag_open'      => '<li class="page-item">',
         'first_tag_close'     => '</li>',
         'prev_link'           => '&lt',
         'prev_tag_open'       => '<li class="page-item">',
         'prev_tag_close'      => '</li>',
         'next-link'           => '&gt',
         'next_tag_open'       => '<li class="page-item">',
         'next_tag_close'      => '</li>',
         'last_tag_open'       => '<li class="page-item">',
         'last_tag_close'      => '</li>', 
         'cur_tag_open'        => '<li class="page-item danger"><a href="#" class="page-link text-white">',
         'cur_tag_close'       => '<span class="sr-only">(current)</span></a></li>',
         'num_tag_open'        => '<li class="page-item">',
         'num_tag_close'       => '</li>'
      ];

      $this->pagination->initialize($config);
      return $this->pagination->create_links();
   }

}

/* End of file Category_model.php */
