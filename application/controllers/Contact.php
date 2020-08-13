<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

   public function __construct()
   {
      parent::__construct();
      $this->load->model('identity_model', 'identity', true);
      $this->load->model('banner_model', 'banner', true);
      $this->load->model('category_model', 'category', true);
      $this->load->model('contact_model', 'contact', true);
   }
   
   public function index()
   {
      $data['favicon']     = $this->identity->getIdentity();
      $data['title']       = 'Blog';
      $data['navbar']      = $this->category->getCategory();
      $data['banner']      = $this->banner->getBanner();
      $data['category']    = $this->category->getCategory();
      $data['content']     = $this->contact->getAbout();
      $data['page'] = 'about';
      $this->load->view('front/layouts/app', $data);
   }

}

/* End of file Contact.php */
