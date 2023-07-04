<?php
class Jadwal_diklat extends CI_Controller{
	function __construct(){
		parent::__construct();

		if (!$this->im_login->is_login('log_username')) {
			redirect('auth/login');
		}

		$this->each_page 	= 30;
		$this->page_int 	= 10;

		$this->load->model('diklat_jadwal_m');

	}

	function index(){
		//clear session
		$session = array('uc_pendaftar','account_id','nama_lengkap','tempat_lahir','tanggal_lahir','alamat_rumah','no_telepon','email','nama_instansi','alamat_instansi','seafarers_code','type_pendaftaran','uc_pendaftaran'
					);

		$this->session->unset_userdata($session);
		//end clear session
			
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
							'model'			=> 'diklat_jadwal_m'
						);

		$query = $this->diklat_jadwal_m->get_jadwal_diklat(NULL,$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$query = $this->diklat_jadwal_m->get_jadwal_diklat(NULL);
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

		// Date
		$tgl = current_time();
		//time_format($tgl, 'Y-m-d');

		$data['date_now'] = time_format($tgl, 'Y');

		$data['title'] = 'Jadwal Diklat';
		$data['subtitle'] = 'Daftar';

		$this->im_render->manage('manage/jadwal_diklat/list',$data);
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

	function page(){
		$data = "";

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

		// Date
		$tgl = current_time();
		//time_format($tgl, 'Y-m-d');

		$data['date_now'] = time_format($tgl, 'Y');

		// echo "<pre>";
		// print_r($filtered);
		$this->load->view('manage/jadwal_diklat/page',$data);
	}

	function add(){
		$data ="";
		$this->load->model('diklat_m');

		$query = $this->diklat_m->get_all('nama_diklat','ASC');
		if ($query->num_rows() > 0) {
			$data['diklat']	= $query->result();
		}

		$data['title'] = 'Jadwal Diklat';
		$data['subtitle'] = 'Tambah';

		$this->im_render->manage('manage/jadwal_diklat/add',$data);
	}

	

	function edit(){
		$data = NULL;
		$uc = $this->input->post('js_uc');

		$this->load->model('diklat_m');

		$query = $this->diklat_m->get_all('nama_diklat','ASC');
		if ($query->num_rows() > 0) {
			$data['diklat']	= $query->result();
		}

		$query = $this->diklat_jadwal_m->get_filtered(array('uc' => $uc));
		if ($query->num_rows() > 0) {
			$data['row'] = $query->row();
			$row = $query->row();
		}

		$this->load->view('manage/jadwal_diklat/edit',$data);

	}

	function update(){
		if ($this->input->post('f_save')) {

			$jml = $this->input->post('f_jml');

			switch ($jml) {
				case 1: $kouta = '30'; break;
				case 2: $kouta = '60'; break;
				case 3: $kouta = '90'; break;
				case 4: $kouta = '120'; break;
			}

			$uc_jadwal = $this->input->post('f_uc');

			$this->load->model('diklat_peserta_m');
			$query = $this->diklat_peserta_m->get_filtered(array('uc_jadwal_diklat' => $uc_jadwal));
			if ($query->num_rows() > 0) {
				$jml_peserta = $query->num_rows();
			}

			$sisa_kursi = ($kouta - $jml_peserta);

			$data = array(
						
							'pelaksanaan_akhir'		=> time_format($this->input->post('f_pel_akhir'), 'Y-m-d'),
							'pendaftaran_mulai'		=> time_format($this->input->post('f_pen_mulai'),'Y-m-d'),
							'pendaftaran_akhir'		=> time_format($this->input->post('f_pen_akhir'),'Y-m-d'),
							'jumlah_kelas'			=> $jml,
							'kouta'					=> $kouta,
							'sisa_kursi'			=> $sisa_kursi
						);

			$filter = array('uc' => $uc_jadwal);
			$this->diklat_jadwal_m->update_data($data, $filter);

		}

		redirect('manage/jadwal_diklat');

	}

	function delete($uc = 0){
		if ($uc != 0) {
			//$this->diklat_jadwal_m->delete_data(array('uc' => $uc));

			$this->diklat_jadwal_m->update_data(array('is_exist' => 1),array('uc' => $uc));
		}

		redirect('manage/jadwal_diklat');
	}

	function atur_jadwal($uc_tahun = NULL, $uc_diklat = NULL){
		$data = "";

		$this->load->model('diklat_m');
		$query = $this->diklat_m->get_list(array('uc_diklat' => $uc_diklat));
		if ($query->num_rows() > 0) {
			$data['dk']	= $query->row();
		}

		$filter = array('uc_diklat_tahun' => $uc_tahun,'uc_diklat' => $uc_diklat);

		$this->load->model('tahun_diklat_m');
		$query = $this->diklat_jadwal_m->get_filtered($filter,'id','ASC');
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
			$data['num_rows'] = $query->num_rows();
		}

		$data['title'] = 'Jadwal Diklat';
		$data['subtitle'] = 'Atur Jadwal';
		$data['uc_diklat_tahun'] = $uc_tahun;
		$data['uc_diklat']		= $uc_diklat;

		$this->im_render->manage('manage/jadwal_diklat/atur_jadwal',$data);
	}

	function update_jadwal_ajax(){
		$pel_akhir = $_POST['js_pel_akhir'];
		$pen_akhir = $_POST['js_pen_akhir'];
		$pel_mulai = $_POST['js_pel_mulai'];

		$jml = $_POST['js_jumlah'];

		switch ($jml) {
			case 1: $kouta = '30'; break;
			case 2: $kouta = '60'; break;
			case 3: $kouta = '90'; break;
			case 4: $kouta = '120'; break;
		}

		$uc_jadwal = $_POST['js_uc'];

		$this->load->model('diklat_peserta_m');
		$query = $this->diklat_peserta_m->get_filtered(array('uc_jadwal_diklat' => $uc_jadwal));
		if ($query->num_rows() > 0) {
			$jml_peserta = $query->num_rows();
		}

		$sisa_kursi = ($kouta - $jml_peserta);

		$data = array(
						'pendaftaran_akhir'		=> ($pen_akhir != 'NULL' ? time_format($pen_akhir, 'Y-m-d') : NULL ),
						'pelaksanaan_mulai'		=> ($pel_mulai != 'NULL' ? time_format($pel_mulai,'Y-m-d'): NULL ),
						'pelaksanaan_akhir'		=> ($pel_akhir != 'NULL' ? time_format($pel_akhir,'Y-m-d'): NULL ),
						'is_exist'				=> 1,
						'jumlah_kelas'			=> $jml,
						'kouta'					=> $kouta,
						'sisa_kursi'			=> $sisa_kursi
				);

		$filter = array('uc' => $uc_jadwal);

		$this->diklat_jadwal_m->update_data($data, $filter);
	}

	function jadwal($uc_tahun = NULL, $uc_diklat = NULL){
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

		$this->load->model('diklat_m');
		$query = $this->diklat_m->get_filtered(array('uc' => $uc_diklat));
		if ($query->num_rows() > 0) {
			$data['row'] = $query->row();
			$row = $query->row();
		}

		$this->load->model('diklat_jadwal_m');
		$filter = array('uc_diklat_tahun' => $uc_tahun,'uc_diklat' => $uc_diklat);
		$query = $this->diklat_jadwal_m->get_tahun_diklat($filter,$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$query = $this->diklat_jadwal_m->get_tahun_diklat($filter);
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();

		}

		$data['uc_diklat'] = $uc_diklat;
		$data['uc_diklat_tahun'] = $uc_tahun;

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;

		$data['title'] = 'Diklat';
		$data['subtitle'] = "Jadwal Diklat [".$row->kode_diklat."] ".$row->nama_diklat." " ;

		// echo "<pre>";
		// print_r($data);
		$this->im_render->manage('manage/jadwal_diklat/jadwal',$data);
	}

	function page_jadwal(){
		$data = "";

		$page = $_POST['js_page'];
		$uc_diklat = $_POST['js_uc_diklat'];
		$uc_diklat_tahun = $_POST['js_uc_diklat_tahun'];
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
		$filter = array('uc_diklat_tahun' => $uc_diklat_tahun,'uc_diklat' => $uc_diklat);
		$query = $this->diklat_jadwal_m->get_tahun_diklat($filter,$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$query = $this->diklat_jadwal_m->get_tahun_diklat($filter);
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();

		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;

		$this->load->view('manage/jadwal_diklat/page_jadwal',$data);
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

		$this->im_render->manage('manage/jadwal_diklat/pendaftar',$data);
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

		$this->load->view('manage/jadwal_diklat/page_pendaftar',$data);
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

		$this->im_render->manage('manage/jadwal_diklat/peserta',$data);
	}

	function page_peserta(){
		$data = "";
		$uc_jadwal_diklat = $_POST['js_uc_jadwal_diklat'];
		$js_kelas = $_POST['js_kelas'];

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

		$this->load->view('manage/jadwal_diklat/page_peserta',$data);
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
		
			$this->load->view('manage/jadwal_diklat/export_pendaftaran',$data);
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
				$this->load->view('manage/jadwal_diklat/export_peserta',$data);
			}else{

				$data = "<script>alert('empty , can not do export data.');</script>";
				$this->session->set_flashdata('alert', $data);
				redirect('manage/jadwal_diklat/peserta/'.$uc_jadwal_diklat);
				
			}

		}else{
			redirect('manage/jadwal_diklat/');
		}
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

			$this->load->view('manage/jadwal_diklat/export_absen',$data);
		}else{
			redirect('manage/jadwal_diklat/');
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
		$this->im_render->manage('manage/jadwal_diklat/edit_seafers_code',$data);
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

			redirect('manage/jadwal_diklat/peserta/'.$uc_jadwal_diklat);

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
		$this->load->view('manage/jadwal_diklat/get_filter_peserta',$data);
	}

	function add_atur_jadwal(){
		$this->load->view('manage/jadwal_diklat/popup_atur_jadwal');
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

	function proses_atur_jadwal(){
		if ($this->input->post('f_save')) {
			$uc_diklat = $this->input->post('f_uc_diklat');
			$uc_tahun = $this->input->post('f_uc_angkatan');

			redirect('manage/jadwal_diklat/atur_jadwal/'.$uc_tahun."/".$uc_diklat);
		}
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

}