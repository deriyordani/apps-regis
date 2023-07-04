<?php
class Diklat extends CI_Controller{
	function __construct(){
		parent::__construct();

		if (!$this->im_login->is_login('log_username')) {
			redirect('manage/login');
		}


		$this->each_page 	= 10;
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

		$filter = ['uc_jenis_diklat' => $_POST['js_jenis_diklat']];

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
		$data['title'] = 'Diklat';
		$data['subtitle'] = 'Tambah';

		$this->im_render->manage('manage/diklat/add',$data);
	}

	function insert(){
		if ($this->input->post('f_save')) {
			$uc = unique_code();

			$data = array(
							'uc'		 	=> $uc,
							'kode_diklat'	=> $this->input->post('f_kode_diklat'),
							'nama_diklat'	=> $this->input->post('f_nama_diklat'),
							'biaya'			=> $this->input->post('f_biaya'),
							'lama_diklat'	=> $this->input->post('f_lama_diklat')
						);

			$this->diklat_m->insert_data($data);

			$values = "";
			for ($i=1; $i <= 15 ; $i++) {
				if ($this->input->post('f_syarat_'.$i) != NULL) {
					$values .= "('".$this->input->post('f_syarat_'.$i)."','".$uc."','".unique_code()."'),";
				}
				
			}

			$values = substr_replace($values, '', -1);
			$field = "(`persyaratan`, `uc_diklat`,`uc`)";

			$this->diklat_persyaratan_m->insert_multi_value($field,$values);
		}

		redirect('manage/diklat');
	}

	function edit($unique_code = 0){
		if ($unique_code != 0) {

			$query = $this->diklat_m->get_filtered(array('uc' => $unique_code));
			if ($query->num_rows() > 0) {
				$data['row'] = $query->row();
			}

			$query = $this->diklat_persyaratan_m->get_filtered(array('uc_diklat' => $unique_code),'id','ASC');
			if ($query->num_rows() > 0) {
				$data['syarat'] = $query->result();
			}

			$data['title'] = 'Diklat';
			$data['subtitle'] = 'Ubah';

			$this->im_render->manage('manage/diklat/edit',$data);

		}else{
			redirct('manage/diklat');
		}
	}

	function update(){

		$unique_code = $this->input->post('f_unique_code');

		//delete syarat
		$query = $this->diklat_persyaratan_m->get_filtered(array('uc_diklat' => $unique_code));
		if ($query->num_rows() > 0) {
			$this->diklat_persyaratan_m->delete_data(array('uc_diklat' => $unique_code));
		}

		//insert again syarat
		$values = "";
		for ($i=1; $i <= 15 ; $i++) {
			if ($this->input->post('f_syarat_'.$i) != NULL) {
				$values .= "('".$this->input->post('f_syarat_'.$i)."','".$unique_code."','".unique_code()."'),";
			}
			
		}

		$values = substr_replace($values, '', -1);
		$field = "(`persyaratan`, `uc_diklat`,`uc`)";

		$this->diklat_persyaratan_m->insert_multi_value($field,$values);

		//update diklat

		$data = array(
						
						'kode_diklat'	=> $this->input->post('f_kode_diklat'),
						'nama_diklat'	=> $this->input->post('f_nama_diklat'),
						'biaya'			=> $this->input->post('f_biaya'),
						'lama_diklat'	=> $this->input->post('f_lama_diklat')
					);

		$filter = array('uc' => $unique_code);

		$this->diklat_m->update_data($data,$filter);
	

		redirect('manage/diklat');
	}

	function delete($unique_code = 0){
		if ($unique_code != 0) {
			//delete syarat
			$query = $this->diklat_persyaratan_m->get_filtered(array('uc_diklat' => $unique_code));
			if ($query->num_rows() > 0) {

				$this->diklat_persyaratan_m->delete_data(array('uc_diklat' => $unique_code));
			}

			$query = $this->diklat_m->get_filtered(array('uc' => $unique_code));
			if ($query->num_rows() > 0) {
				$this->diklat_m->delete_data(array('uc' => $unique_code));
			}
		}

		redirect('manage/diklat');
	}

	function persyaratan($unique_code){
		$data = "";

		$query = $this->diklat_m->get_filtered(array('uc' => $unique_code));
		if ($query->num_rows() > 0) {
			$data['row'] = $query->row();
		}

		$query = $this->diklat_persyaratan_m->get_filtered(array('uc_diklat' => $unique_code),'id','ASC');
		if ($query->num_rows() > 0) {
			$data['syarat'] = $query->result();
		}

		$data['title'] = 'Diklat';
		$data['subtitle'] = 'Persyaratan';

		$this->im_render->manage('manage/diklat/persyaratan',$data);
	}

	function jadwal($uc_diklat = 0){
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
							'model'			=> 'diklat_m'
						);

		$query = $this->diklat_m->get_filtered(array('uc' => $uc_diklat));
		if ($query->num_rows() > 0) {
			$data['row'] = $query->row();
			$row = $query->row();
		}

		$this->load->model('diklat_jadwal_m');
		$query = $this->diklat_jadwal_m->get_filtered(array('uc_diklat' => $uc_diklat),'pelaksanaan_mulai','ASC',$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$query = $this->diklat_jadwal_m->get_filtered(array('uc_diklat' => $uc_diklat));
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();

		}

		$data['uc_diklat'] = $uc_diklat;

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;

		$data['title'] = 'Diklat';
		$data['subtitle'] = "Jadwal Diklat [".$row->kode_diklat."] ".$row->nama_diklat." " ;

		$this->im_render->manage('manage/diklat/jadwal',$data);
	}

	function page_jadwal(){
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
							'model'			=> 'diklat_m'
						);

		$this->load->model('diklat_jadwal_m');
		$query = $this->diklat_jadwal_m->get_filtered(array('uc_diklat' => $uc_diklat),'pelaksanaan_mulai','ASC',$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$query = $this->diklat_jadwal_m->get_filtered(array('uc_diklat' => $uc_diklat));
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();
		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;

		$this->load->view('manage/diklat/page_jadwal',$data);
	}

	function pendaftar($uc_jadwal_diklat = 0){
		$data = "";

		//informasi
		$this->load->model('diklat_jadwal_m');
		$query = $this->diklat_jadwal_m->get_info($uc_jadwal_diklat);
		if ($query->num_rows() > 0) {
			$data['info'] = $query->row();
		}

		//pendaftar
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
							'model'			=> 'pendaftaran_m'
						);

		$this->load->model('pendaftaran_m');
		$filtered = array('uc_jadwal_diklat' => $uc_jadwal_diklat);
		$query = $this->pendaftaran_m->get_pendaftaran_diklat($filtered,$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$query = $this->pendaftaran_m->get_pendaftaran_diklat($filtered);
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();

		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;
		$data['uc_jadwal_diklat'] = $uc_jadwal_diklat;

		$data['title'] = 'Diklat';
		$data['subtitle'] = 'Pendaftar';

		$this->im_render->manage('manage/diklat/pendaftar',$data);
	}

	function page_pendaftar(){
		$data = "";
		$uc_jadwal_diklat = $_POST['js_uc_jadwal_diklat'];

		//informasi
		$this->load->model('diklat_jadwal_m');
		$query = $this->diklat_jadwal_m->get_info($uc_jadwal_diklat);
		if ($query->num_rows() > 0) {
			$data['info'] = $query->row();
		}

		//pendaftar
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
							'model'			=> 'pendaftaran_m'
						);

		$this->load->model('pendaftaran_m');
		$filtered = array('uc_jadwal_diklat' => $uc_jadwal_diklat);
		$query = $this->pendaftaran_m->get_pendaftaran_diklat($filtered,$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$query = $this->pendaftaran_m->get_pendaftaran_diklat($filtered);
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();

		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;

		$this->load->view('manage/diklat/page_pendaftar',$data);
	}

	function peserta($uc_jadwal_diklat = 0){
		$data = "";

		//informasi
		$this->load->model('diklat_jadwal_m');
		$query = $this->diklat_jadwal_m->get_info($uc_jadwal_diklat);
		if ($query->num_rows() > 0) {
			$data['info'] = $query->row();
		}

		//pendaftar
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
							'model'			=> 'pendaftaran_m'
						);

		$this->load->model('pendaftaran_m');
		$filtered = array('uc_jadwal_diklat' => $uc_jadwal_diklat,'is_comfrim' => 1);
		$query = $this->pendaftaran_m->get_pendaftaran_diklat($filtered,$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$query = $this->pendaftaran_m->get_pendaftaran_diklat($filtered);
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();

		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;
		$data['uc_jadwal_diklat'] = $uc_jadwal_diklat;
		$data['message'] = $this->session->flashdata('alert');

		$data['title'] = 'Diklat';
		$data['subtitle'] = 'Peserta';

		$this->im_render->manage('manage/diklat/peserta',$data);
	}

	function page_peserta(){
		$data = "";
		$uc_jadwal_diklat = $_POST['js_uc_jadwal_diklat'];
		$uc_jadwal_diklat = $_POST['js_kelas'];

		//informasi
		$this->load->model('diklat_jadwal_m');
		$query = $this->diklat_jadwal_m->get_info($uc_jadwal_diklat);
		if ($query->num_rows() > 0) {
			$data['info'] = $query->row();
		}

		//pendaftar
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
							'model'			=> 'pendaftaran_m'
						);

		$this->load->model('pendaftaran_m');
		$filtered = array('uc_jadwal_diklat' => $uc_jadwal_diklat,'is_comfrim' => 1, 'kelas' => $js_kelas);
		$query = $this->pendaftaran_m->get_pendaftaran_diklat($filtered,$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$query = $this->pendaftaran_m->get_pendaftaran_diklat($filtered);
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();

		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;

		$this->load->view('manage/diklat/page_peserta',$data);
	}

	function export_jadwal($uc_tahun = NULL,$uc_diklat = NULL, $uc_jadwal_diklat = NULL){
		if ($uc_diklat != NULL) {
			$data="";



			$this->load->model('diklat_jadwal_m');
			$query = $this->diklat_jadwal_m->get_info($uc_jadwal_diklat);
			if ($query->num_rows() > 0) {
				$data['row'] = $query->row();
			}

			$this->load->model('diklat_jadwal_m');
			$filter = array('uc_diklat_tahun' => $uc_tahun,'uc_diklat' => $uc_diklat);
			$query = $this->diklat_jadwal_m->get_tahun_diklat($filter);
			if ($query->num_rows() > 0) {
				$data['result'] = $query->result();
			}			
			
		
			$this->load->view('manage/diklat/export_to_excel',$data);
		}

	}

	function export_pendaftaran($uc_jadwal_diklat = NULL){
		if ($uc_jadwal_diklat != NULL){
			$data="";

			$this->load->model('diklat_jadwal_m');
			$query = $this->diklat_jadwal_m->get_info($uc_jadwal_diklat);
			if ($query->num_rows() > 0) {
				$data['row'] = $query->row();
			}

			$this->load->model('pendaftaran_m');
			$filtered = array('uc_jadwal_diklat' => $uc_jadwal_diklat);
			$query = $this->pendaftaran_m->get_pendaftaran_diklat($filtered);
			if ($query->num_rows() > 0) {
				$data['result'] = $query->result();
			}			
		
			$this->load->view('manage/diklat/export_pendaftaran',$data);
		}

	}

	function export_peserta(){
		if ($this->input->post('f_save')) {
			$data="";

			$uc_jadwal_diklat = $this->input->post('f_uc_jadwal_diklat');
			$kelas = $this->input->post('f_kelas_text');	
			
			//informasi
			$this->load->model('diklat_jadwal_m');
			$query = $this->diklat_jadwal_m->get_info($uc_jadwal_diklat);
			if ($query->num_rows() > 0) {
				$data['row'] = $query->row();
			}

			$this->load->model('pendaftaran_m');
			$filtered = array('uc_jadwal_diklat' => $uc_jadwal_diklat,'is_comfrim' => 1, 'kelas' => $kelas);
			$query = $this->pendaftaran_m->get_pendaftaran_diklat($filtered);
			if ($query->num_rows() > 0) {
				$data['result'] = $query->result();
			}

			if ($data['result'] != NULL ) {
				$this->load->view('manage/diklat/export_peserta',$data);
			}else{

				$data = "<script>alert('empty , can not do export data.');</script>";
				$this->session->set_flashdata('alert', $data);
				redirect('manage/diklat/peserta/'.$uc_jadwal_diklat);
				
			}

		}else{
			redirect('manage/diklat/');
		}
	}

	function filter_kelas(){
		$data="";

		$uc_jadwal_diklat = $this->input->post('js_uc_jadwal_diklat');
		$kelas = $this->input->post('js_kelas');

		//pendaftar
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
							'model'			=> 'pendaftaran_m'
						);

		$this->load->model('pendaftaran_m');
		$filtered = array('uc_jadwal_diklat' => $uc_jadwal_diklat,'is_comfrim' => 1, 'kelas' => $kelas);
		$query = $this->pendaftaran_m->get_pendaftaran_diklat($filtered,$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$query = $this->pendaftaran_m->get_pendaftaran_diklat($filtered);
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();

		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;
		$data['uc_jadwal_diklat'] = $uc_jadwal_diklat;
		$data['kelas'] = $kelas;
		$this->load->view('manage/diklat/get_filter_peserta',$data);
	}

	function export_absensi(){
		if ($this->input->post('f_save')) {
			// $data="";
			$uc_jadwal_diklat = $this->input->post('f_uc_jadwal_diklat');
			$kelas = $this->input->post('f_kelas');

			//informasi
			$this->load->model('diklat_jadwal_m');
			$query = $this->diklat_jadwal_m->get_info($uc_jadwal_diklat);
			if ($query->num_rows() > 0) {
				$data['row'] = $query->row();
			}

			$this->load->model('pendaftaran_m');
			$filtered = array('uc_jadwal_diklat' => $uc_jadwal_diklat,'is_comfrim' => 1, 'kelas' => $kelas);
			$query = $this->pendaftaran_m->get_pendaftaran_diklat($filtered);
			if ($query->num_rows() > 0) {
				$data['result'] = $query->result();
			}

			$this->load->view('manage/diklat/export_absen',$data);
		}else{
			redirect('manage/diklat/');
		}
		

	}

	function edit_seaferers_code($uc_jadwal_diklat = 0){
		$data = "";

		//informasi
		$this->load->model('diklat_jadwal_m');
		$query = $this->diklat_jadwal_m->get_info($uc_jadwal_diklat);
		if ($query->num_rows() > 0) {
			$data['info'] = $query->row();
		}

		//pendaftar
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
							'model'			=> 'pendaftaran_m'
						);

		$this->load->model('pendaftaran_m');
		$filtered = array('uc_jadwal_diklat' => $uc_jadwal_diklat,'is_comfrim' => 1);
		$query = $this->pendaftaran_m->get_pendaftaran_diklat($filtered,$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$query = $this->pendaftaran_m->get_pendaftaran_diklat($filtered);
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();

		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;
		$data['uc_jadwal_diklat'] = $uc_jadwal_diklat;
		$data['message'] = $this->session->flashdata('alert');

		$data['title'] = 'Diklat';
		$data['subtitle'] = 'Update Seafarers Code';
		$this->im_render->manage('manage/diklat/edit_seafers_code',$data);
	}

	function update_seaferers_code(){
		if ($this->input->post('f_save')) {

			$this->load->model('pendaftar_m');
			
			$total =  count($this->input->post('f_uc_peserta'));
			$code = $this->input->post('f_seafers_code');
			$uc = $this->input->post('f_uc_peserta');
			$uc_jadwal_diklat = $this->input->post('f_uc_jadwal_diklat');


			for ($i=0; $i < $total ; $i++) { 
				$this->pendaftar_m->update_data(array('seafarers_code'	=> $code[$i]),array('uc' => $uc[$i]));				
			}

			redirect('manage/diklat/peserta/'.$uc_jadwal_diklat);

		}
	}


}