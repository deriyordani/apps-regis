<?php
Class Schedule extends CI_Controller{
	function __construct(){
		parent::__construct();

		$this->load->model('diklat_m');
		$this->load->model('diklat_jadwal_m');
		$this->load->model('pendaftar_m');
		$this->load->model('diklat_peserta_m');

		$this->load->model('jenis_diklat_m');
		$this->load->model('diklat_tarif_m');


		$this->each_page 	= 10;
		$this->page_int 	= 10;

	}

	function index(){
		redirect('home');
	}

	function lists($uc_diklat = NULL){
		$data = NULL;

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
							'model'			=> 'diklat_jadwal_m'
						);



		$filtered = array(
			'uc_diklat'		=> $uc_diklat,
			

		);


		$query = $this->diklat_jadwal_m->get_jadwal_diklat($filtered,$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$query = $this->diklat_jadwal_m->get_jadwal_diklat($filtered);
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();
		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;

		$this->load->model('diklat_m');
		$query = $this->diklat_m->get_all('nama_diklat','ASC');
		if ($query->num_rows() > 0) {
			$data['diklat'] = $query->result();
		}


		$tgl = current_time();
		//time_format($tgl, 'Y-m-d');

		$data['date_now'] = time_format($tgl, 'Y');

		$data['uc_diklat'] = $uc_diklat;

		$this->im_render->main('frontend/schedule', $data);
	}


	function page(){
		$data = NULL;

		$page = ($_POST['js_page'] != NULL ? $_POST['js_page'] : 1);
		$bulan = $this->input->post('js_bulan');
		$tahun = $this->input->post('js_tahun');

		if ($bulan == '0') {
			$bulan = NULL;
		}else{
			$bulan = $this->input->post('js_bulan');
		}

		if ($tahun == '0') {
			$tahun = NULL;
		}else{
			$tahun = $this->input->post('js_tahun');
		}


		$filtered = array(	
			'uc_jenis_diklat' => ($_POST['js_uc_jenis_diklat'] != NULL ? $_POST['js_uc_jenis_diklat'] : NULL),
			'uc_diklat'		=> ($_POST['js_uc_diklat'] != NULL ? $_POST['js_uc_diklat'] : NULL),
			'angkatan'		=> ($_POST['js_angkatan'] != NULL ? $_POST['js_angkatan'] : NULL),
			'periode'		=> ($_POST['js_periode'] != NULL ? $_POST['js_periode'] : NULL),
			'month'			=> $bulan,
			'year'			=> $tahun

		);

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
							'model'			=> 'diklat_jadwal_m'
						);

		$query = $this->diklat_jadwal_m->get_jadwal_diklat($filtered,$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$query = $this->diklat_jadwal_m->get_jadwal_diklat($filtered);
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();
		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;

		$this->load->view('frontend/schedule_page', $data);
	}


	function get_diklat(){
		$this->load->model('diklat_m');

		$uc_jenis_diklat = $this->input->post('js_uc_jenis_diklat');

		$data['result'] = $this->diklat_m->get_filtered(array('uc_jenis_diklat' => $uc_jenis_diklat))->result();

		$this->load->view('manage/jadwal_diklat/get_diklat', $data);

	}

	function get_angkatan(){
		$this->load->model('tahun_diklat_m');
		$uc_diklat = $this->input->post('js_uc_diklat');
		$query = $this->tahun_diklat_m->get_filtered(array('uc_diklat' => $uc_diklat,'is_exist' => 1));
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$this->load->view('manage/jadwal_diklat/get_angkatan',$data);
	}


	function load_angkatan(){
		$this->load->model('tahun_diklat_m');

		$uc_diklat = $this->input->post('js_uc_diklat');

		$query = $this->tahun_diklat_m->get_filtered(array('uc_diklat' => $uc_diklat,'is_exist' => 1));
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$this->load->view('manage/jadwal_diklat/load_angkatan',$data);
	}


	function get_periode(){
		$uc_tahun = $this->input->post('js_uc_tahun');
		$uc_diklat = $this->input->post('js_uc_diklat');

		$query = $this->diklat_jadwal_m->get_filtered(array('uc_diklat' => $uc_diklat,'uc_diklat_tahun' => $uc_tahun),'id','ASC');
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$this->load->view('manage/jadwal_diklat/get_periode',$data);
	}


	function rincian_biaya(){
		$data = NULL;

		$uc_diklat_jadwal = $this->input->post('js_uc_diklat_jadwal');
		$uc_diklat = $this->input->post('js_uc_diklat');
		$uc_diklat_tahun = $this->input->post('js_uc_diklat_tahun');

		

		$data['info'] = $this->diklat_jadwal_m->get_jadwal_diklat(array('uc' => $uc_diklat_jadwal))->row();

		$data['result'] = $this->diklat_tarif_m->get_list_biaya($uc_diklat_tahun, $uc_diklat)->result();

		$this->load->view('frontend/rincian_biaya',$data);
	}
}