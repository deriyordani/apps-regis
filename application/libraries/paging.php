<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Paging extends CI_Controller{
    function __construct(){
        $this->CI =& get_instance();
        
        //$this->CI->load->library('session');
        $this->CI->load->model('user_m');
    }

 public function paging($base_url)
    {
        $this->load->library('pagination');
        $config = array(
            'base_url'         => $base_url,
            'total_rows'       => $this->hitung_semua(),
            'per_page'         => $this->per_halaman,
            'num_links'        => 4,
            'use_page_numbers' => TRUE,
            'first_link'       => '&#124;&lt; First',
            'last_link'        => 'Last &gt;&#124;',
            'next_link'        => 'Next &gt;',
            'prev_link'        => '&lt; Prev',
        );
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }
}