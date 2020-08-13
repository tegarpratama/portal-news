<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {
   
   public function __construct()
   {
      parent::__construct();
      $this->load->model('identity_model', 'identity', true);
      $this->load->model('banner_model', 'banner', true);
      $this->load->model('posting_model', 'posting', true);
      $this->load->model('category_model', 'category', true);
   }
   
   public function index($page = null)
   {
      $data['favicon']     = $this->identity->getIdentity();
      $data['title']       = 'Blog';
      $data['navbar']      = $this->category->getCategory();
      $data['banner']      = $this->banner->getBanner();
      $data['category']    = $this->category->getCategory();
      $data['post']        = $this->posting->getAllPosting($page);
      $data['popular']     = $this->posting->getMostPopular();
      $data['trending']    = $this->posting->getThread();
      $data['category']    = $this->category->getCategory();

      $data['total_rows']  = $this->posting->countPosting();
      $data['pagination']  = $this->posting->makePagination(
         base_url('blog'), 2, $data['total_rows']
      );

      $data['page'] = 'blog';
      $this->load->view('front/layouts/app', $data);
   } 

   public function category($category, $page = null)
   {
      $data['favicon']     = $this->identity->getIdentity();
      $data['title']       = 'Blog';
      $data['category']    = $this->category->getCategory();
      $data['post']        = $this->posting->getPostingByCategory($category, $page);
      $data['popular']     = $this->posting->getMostPopular();
      $data['trending']    = $this->posting->getThread();
      $data['category']    = $this->category->getCategory();

      $data['total_rows']  = $this->posting->countPosting($category);
      $data['pagination']  = $this->posting->makePagination(
         base_url("blog/category/$category/"), 4, $data['total_rows']
      );

      $data['page'] = 'blog';
      $this->load->view('front/layouts/app', $data);
   }

   public function read($seo_title)
   {
      $row = $this->posting->getPosting($seo_title);
      
      if($row){
         $data['posting']     = $row;
         $data['title']       = $row->title;
         $data['favicon']     = $this->identity->getIdentity();
         $data['banner']      = $this->banner->getBanner();
         $data['popular']     = $this->posting->getMostPopular();
         $data['trending']    = $this->posting->getThread();
         $data['category']    = $this->category->getCategory();
         $data['page']        = 'news-detail';
         $this->load->view('front/layouts/app', $data);
      }else{
         redirect(base_url('home'));
      }
   }

}

/* End of file Blog.php */
