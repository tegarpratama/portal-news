<?php

function is_login()
{
   $CI =& get_instance();

   $CI->load->library('ion_auth');
   if (!$CI->ion_auth->logged_in()){
      $CI->session->set_flashdata('error', 'Silahkan login terlebih dahulu.');
      redirect('auth/login');
   }else if(!$CI->ion_auth->is_admin()){
      $CI->session->set_flashdata('error', 'Oops, Terjadi suatu kesalahan.');
      redirect('auth/login');
   }
}

function slugify($text)
{
   // replace non letter or digits by -
   $text = preg_replace('~[^\pL\d]+~u', '-', $text);

   // transliterate
   $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

   // remove unwanted characters
   $text = preg_replace('~[^-\w]+~', '', $text);

   // trim
   $text = trim($text, '-');

   // remove duplicate -
   $text = preg_replace('~-+~', '-', $text);

   // lowercase
   $text = strtolower($text);

   if (empty($text)) {
      return 'n-a';
   }

   return $text;  
}

// function getDropDownList($table, $columns){
//    $CI =& get_instance();

//    $query = $CI->db->select($columns)->from($table)->get();

//    if($query->num_rows() >= 1){
//       $option1 = ['' => '- Pilih -'];
//       $option2 = array_column($query->result_array(), $columns[1], $columns[0]);
//       $options = $option1 + $option2;

//       return $options;
//    }

//    return $options = ['' => '- Pilih -'];
// }