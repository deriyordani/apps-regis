<?php
class Diklat extends CI_Controller{
	function __construct(){
		parent::__construct();

		if (!$this->im_login->is_login('log_username')) {
			redirect('auth/login');
		}


		$this->each_page 	= 20;
		$this->page_int 	= 5;

		$this->load->model('diklat_m');
		$this->load->model('diklat_persyaratan_m');
	}

	function temp(){
		$this->im_render->manage('manage/envi/dummy');
	}

	function index(){

		//clear session
		$session = array('uc_pendaftar','account_id','nama_lengkap','tempat_lahir','tanggal_lahir','alamat_rumah','no_telepon',
						'email','nama_instansi','alamat_instansi','seafarers_code','type_pendaftaran','uc_pendaftaran'
					);

		$this->session->unset_userdata($session);
		//end clear session
			
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
							'model'			=> 'diklat_m'
						);

		$query = $this->diklat_m->get_list(NULL,$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$query = $this->diklat_m->get_list(NULL);
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();
		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;

		$data['title'] = 'Diklat';
		$data['subtitle'] = 'Daftar';

		$this->im_render->manage('manage/diklat/list',$data);
	}

	function page(){
		//$page = (@$_POST['js_page'] != NULL ? @$_POST['js_page'] : 1);
		$page = $_POST['js_page'];
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
							'model'			=> 'diklat_m'
						);

		$filter = ['uc_jenis_diklat' =>  $this->input->post('js_uc_jenis_diklat'), 'search' => $this->input->post('js_search')];

		$query = $this->diklat_m->get_list($filter,$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$query = $this->diklat_m->get_list($filter);
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();
		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;


		$this->load->view('manage/diklat/page',$data);
	}

	function add(){
		$this->load->view('manage/diklat/add');
	}

	function insert(){

		$uc = unique_code();

		$data = array(
						'uc'		 	=> $uc,
						'uc_jenis_diklat' 	=> $this->input->post('f_jenis_diklat'),
						'kode_diklat'	=> $this->input->post('f_kode_diklat'),
						'nama_diklat'	=> $this->input->post('f_nama_diklat'),
						'lama_diklat'	=> $this->input->post('f_lama_diklat')
					);

		$this->diklat_m->insert_data($data);

		redirect('manage/diklat');
	}

	function edit(){
		

		$query = $this->diklat_m->get_filtered(array('uc' => $this->input->post('js_uc')));
		if ($query->num_rows() > 0) {
			$data['row'] = $query->row();
		}

		$this->load->view('manage/diklat/edit',$data);

		
	}

	function update(){

		$data = array(
						'uc_jenis_diklat' 	=> $this->input->post('f_jenis_diklat'),
						'kode_diklat'	=> $this->input->post('f_kode_diklat'),
						'nama_diklat'	=> $this->input->post('f_nama_diklat'),
						'lama_diklat'	=> $this->input->post('f_lama_diklat')
					);

		$this->diklat_m->update_data($data, array('uc' => $this->input->post('f_uc')));

		redirect('manage/diklat');

	}

	function delete($unique_code = 0){
		if ($unique_code != 0) {

			$query = $this->diklat_m->get_filtered(array('uc' => $unique_code));
			if ($query->num_rows() > 0) {
				$this->diklat_m->delete_data(array('uc' => $unique_code));
			}
		}

		redirect('manage/diklat');
	}



	function persyaratan($uc_diklat = NULL){
		if ($uc_diklat != NULL) {
			

			$query = $this->diklat_m->get_list(array('uc_diklat' => $uc_diklat));
			if ($query->num_rows() > 0) {
				$data['row'] = $query->row();
			}


			$this->load->model('persyaratan_m');

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
								'model'			=> 'persyaratan_m'
							);

			$query = $this->persyaratan_m->search_syarat($uc_diklat,NULL,$this->each_page, $offset);
			if ($query->num_rows() > 0) {
				$data['persyaratan'] = $query->result();
			}

			// $query = $this->persyaratan_m->search_syarat($uc_diklat,NULL);
			// if ($query->num_rows() > 0) {
			// 	$params['total_record'] = $query->num_rows();
			// 	$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			// 	$data['total_record'] 	= $query->num_rows();
			// }

			$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;



			$this->load->model('diklat_persyaratan_m');

			

			$query = $this->diklat_persyaratan_m->get_list($uc_diklat);
			if ($query->num_rows() > 0) {
				$data['syarat'] = $query->result();
			}


			$this->im_render->manage('manage/diklat/persyaratan', $data);

		}
	}

	function persyaratan_page(){
		
		$uc_diklat = $this->input->post('js_uc_diklat');
		$text = $this->input->post('js_text');


		// $query = $this->diklat_m->get_list(array('uc_diklat' => $uc_diklat));
		// if ($query->num_rows() > 0) {
		// 	$data['row'] = $query->row();
		// }


		$this->load->model('persyaratan_m');

		$page = $_POST['js_page'];
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
							'model'			=> 'persyaratan_m'
						);

		$query = $this->persyaratan_m->search_syarat($uc_diklat,$text,$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['persyaratan'] = $query->result();
		}

		$query = $this->persyaratan_m->search_syarat($uc_diklat,$text);
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();
		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;

		$data['uc_diklat'] = $uc_diklat;


		$this->load->view('manage/diklat/search_persyaratan', $data);

		
	}

	function search_persyaratan(){

		$this->load->model('persyaratan_m');

		$text = $this->input->post('js_text');
		$uc_diklat = $this->input->post('js_uc_diklat');

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
							'model'			=> 'persyaratan_m'
						);

		$query = $this->persyaratan_m->search_syarat($uc_diklat,$text,$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['persyaratan'] = $query->result();
		}

		$query = $this->persyaratan_m->search_syarat($uc_diklat,$text);
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();
		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;

		$data['uc_diklat'] = $uc_diklat;

		$this->load->view('manage/diklat/search_persyaratan', $data);

	}


	function tambah_persyaratan($uc_diklat, $uc_persyaratan){
		$this->load->model('diklat_persyaratan_m');

		$data = [

			'uc' => unique_code(),
			'uc_diklat' => $uc_diklat,
			'uc_persyaratan' => $uc_persyaratan
		];

		$this->diklat_persyaratan_m->insert_data($data);

		redirect('manage/diklat/persyaratan/'.$uc_diklat);
	}

	function hapus_persyaratan($uc_diklat, $uc_persyaratan){
		$this->load->model('diklat_persyaratan_m');
		$this->diklat_persyaratan_m->delete_data(array('uc' => $uc_persyaratan));

		redirect('manage/diklat/persyaratan/'.$uc_diklat);
	}

}