<?php
class Tahun_diklat extends CI_Controller{
	function __construct(){
		parent::__construct();

		if (!$this->im_login->is_login('log_username')) {
			redirect('auth/login');
		}


		$this->each_page 	= 20;
		$this->page_int 	= 5;

		$this->load->model('tahun_diklat_m');
		$this->load->model('diklat_m');
	}



	function daftar($uc_diklat = NULL){
		$data = "";
		$page = 1;
		//	Pagination Initialization
		$this->load->library('im_pagination');
		///	Define Offset
		$offset = ($page - 1) * $this->each_page;
		//	Define Parameters
		$params = array(
							'page_number'	=> $page,
							'each_page'		=> $this->each_page,
							'page_int'		=> $this->page_int,	
							'segment' 		=> 'page',						
							'model'			=> 'operator_m'
						);

		$query = $this->diklat_m->get_list(array('uc_diklat' => $uc_diklat));
		if ($query->num_rows() > 0) {
			$data['dk'] = $query->row();
		}

		$query = $this->tahun_diklat_m->get_filtered(array('uc_diklat' => $uc_diklat,'is_exist' => 1),'id','DESC',$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}


		$query = $this->tahun_diklat_m->get_filtered(array('uc_diklat' => $uc_diklat));
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();
		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;

		$this->im_render->manage('manage/tahun_diklat/list',$data);
	}


		function get_daftar(){
		$data = "";
		$page = $_POST['js_page'];
		$uc_diklat = $_POST['js_uc_diklat'];
		//	Pagination Initialization
		$this->load->library('im_pagination');
		///	Define Offset
		$offset = ($page - 1) * $this->each_page;
		//	Define Parameters
		$params = array(
							'page_number'	=> $page,
							'each_page'		=> $this->each_page,
							'page_int'		=> $this->page_int,	
							'segment' 		=> 'page',						
							'model'			=> 'operator_m'
						);

		$query = $this->diklat_m->get_filtered(array('uc' => $uc_diklat));
		if ($query->num_rows() > 0) {
			$data['dk'] = $query->row();
		}

		$query = $this->tahun_diklat_m->get_filtered(array('uc_diklat' => $uc_diklat,'is_exist' => 1),'id','DESC',$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}


		$query = $this->tahun_diklat_m->get_filtered(array('uc_diklat' => $uc_diklat));
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();
		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;

		$data['title'] = 'Tahun Diklat';
		$data['subtitle'] = 'Daftar';

		$this->load->view('manage/tahun_diklat/page',$data);
	}

	function add(){

		$uc_diklat = $this->input->post('js_uc_diklat');

		

		$query = $this->diklat_m->get_filtered(array('uc' => $uc_diklat));
		if ($query->num_rows() > 0) {
			$data['row'] = $query->row();
		}

		$this->load->view('manage/tahun_diklat/add',$data);
	}

	function insert(){
		if ($this->input->post('f_save')) {
			$uc_diklat = $this->input->post('f_uc_diklat');
			$unique_code = unique_code();
			$data = array(
							'uc'		=> $unique_code,
							'uc_diklat' => $uc_diklat,
							'tahun'		=> time_format($this->input->post('f_tahun') ,'Y')
						);

			$this->tahun_diklat_m->insert_data($data);

			$this->load->model('diklat_jadwal_m');
			$value = "";
			for ($i=1; $i <= 48  ; $i++) { 
				$value .= "('".unique_code()."','".$uc_diklat."','".$unique_code."','".$i."','0'),";
			}

			$fields = "(`uc`,`uc_diklat`,`uc_diklat_tahun`,`periode`,`is_exist`)";

			$value = substr_replace($value, '', -1);

			$this->diklat_jadwal_m->insert_multi_value($fields,$value);
		}

		redirect('manage/tahun_diklat/daftar/'.$uc_diklat);
	}

	function edit(){

		$uc = $this->input->post('js_uc_tahun_diklat');

		$query = $this->tahun_diklat_m->get_diklat($uc);
		if ($query->num_rows() > 0) {
			$data['row'] = $query->row();
		}

		$this->load->view('manage/tahun_diklat/edit', $data);

	}

	function update(){
		if ($this->input->post('f_save')) {

			$uc_diklat = $this->input->post('f_uc_diklat');
			$data = array('tahun' => $this->input->post('f_tahun'));

			$where = array('uc' => $this->input->post('f_uc'));

			$this->tahun_diklat_m->update_data($data,$where);
		}

		redirect('manage/tahun_diklat/daftar/'.$uc_diklat);
	}

	function delete($uc = NULL, $uc_diklat = NULL){

		$where = array('uc' => $uc);

		$this->tahun_diklat_m->update_data(array('is_exist' => 0),$where);
		

		redirect('manage/tahun_diklat/daftar/'.$uc_diklat);

	}




}