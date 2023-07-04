<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class License_lib extends CI_Controller{
	function __construct(){
		$this->CI =& get_instance();

		$this->CI->load->library('encryption'); 

		$this->CI->load->model('info_m');
	}

	private $rotations = 0 ;


	function encrypt($key){
		$hasil_enkripsi = $this->CI->encryption->encrypt($key);

		return $hasil_enkripsi;
	}

	function decrypt($key){
		$hasil = $this->CI->encryption->decrypt($key);

		return $hasil;
	}


	function get_volume_label($drive) {
		if (preg_match('#Volume Serial Number is (.*)\n#i', shell_exec('dir '.$drive.':'), $m)) {
			$volname = $m[1];
		} else {
			$volname = '';
		}

		return $volname;
	}

	function license_valid(){
		$CI =& get_instance();

		$vol = str_replace("(","",str_replace(")","",$this->get_volume_label("c")));
		
		$rows = $this->CI->info_m->get_filtered(array('status' => '1'))->row();


		if ($vol == $this->decrypt($rows->license)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
}
?>