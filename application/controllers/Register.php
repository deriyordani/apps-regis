<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

Class Register extends CI_Controller{
	function __construct(){
		parent::__construct();

		$this->load->model('diklat_m');
		$this->load->model('diklat_jadwal_m');
		$this->load->model('pendaftar_m');
		$this->load->model('diklat_peserta_m');

		$this->load->model('jenis_diklat_m');
		$this->load->model('diklat_tarif_m');


		$this->load->model('pendaftar_m');
		$this->load->model('pendaftaran_m');
		$this->load->model('pendaftaran_diklat_m');
		$this->load->model('pendaftaran_checklist_m');


		$this->each_page 	= 10;
		$this->page_int 	= 10;


		require APPPATH.'libraries/phpmailer/src/Exception.php';
        require APPPATH.'libraries/phpmailer/src/PHPMailer.php';
        require APPPATH.'libraries/phpmailer/src/SMTP.php';



	}


	function index(){

	}

	function step_1($uc_jadwal_diklat = NULL){
		if ($uc_jadwal_diklat != NULL) {
			

			$data = NULL;

			$data['uc_jadwal_diklat'] = $uc_jadwal_diklat;

			$this->im_render->main('frontend/step_1', $data);

		}else{

			redirect('home');
		}


	}

	function insert_step_1(){
		if ($this->input->post('f_save')) {

			if ($this->input->post('f_status') == 0) {
				$this->do_bst();
			}else{
				$this->do_non_bst();
			}
			
		}

		redirect('register/step_2');
	}

	function do_bst(){
		$unique_code = unique_code();
		$data = array(
						'uc'				=> $unique_code,
						'account_id'		=> accound_id(),
						'nama_lengkap'		=> $this->input->post('f_name_peserta'),
						'tempat_lahir'		=> $this->input->post('f_tempat_lahir'),
						'tanggal_lahir'		=> time_format($this->input->post('f_tgl_lahir'), 'Y-m-d'),
						'alamat_rumah'		=> $this->input->post('f_alamat_rumah'),
						'no_telepon'		=> $this->input->post('f_no_hp'),
						'email'				=> $this->input->post('f_email'),
						'nama_instansi'		=> $this->input->post('f_instansi'),
						'alamat_instansi'	=> $this->input->post('f_alamat_instansi'),
						'seafarers_code'	=> ($this->input->post('f_seafarers_code') != '' ? $this->input->post('f_seafarers_code') : NULL),
						'password'			=> md5('123')
					);

		$this->pendaftar_m->insert_data($data);

		$uc_pendaftaran = unique_code();

		$datas_pendaftaran = array(
									'uc' 					=> $uc_pendaftaran,
									'uc_pendaftar'			=> $unique_code,
									'no_pendaftaran'		=> no_pendaftaran(),
									'tanggal_daftar'		=> time_format(current_time(),'Y-m-d H:i'),
									'type_pendaftaran'		=> $this->input->post('f_status')
								);

		$this->pendaftaran_m->insert_data($datas_pendaftaran);

		$query = $this->pendaftar_m->get_filtered(array('uc' => $unique_code));
		if ($query->num_rows() > 0) {
			$row = $query->row();

			$daf = $this->pendaftaran_m->get_filtered(array('uc_pendaftar' => $unique_code))->row();

			$data = array(

						'uc_pendaftar'		=> $row->uc,
						'account_id'		=> $row->account_id,
						'nama_lengkap'		=> $row->nama_lengkap,
						'tempat_lahir'		=> $row->tempat_lahir,
						'tanggal_lahir'		=> $row->tanggal_lahir,
						'alamat_rumah'		=> $row->alamat_rumah,
						'no_telepon'		=> $row->no_telepon,
						'email'				=> $row->email,
						'nama_instansi'		=> $row->nama_instansi,
						'alamat_instansi'	=> $row->alamat_instansi,
						'seafarers_code'	=> $row->seafarers_code,
						'uc_pendaftaran'	=> $daf->uc,
						'type_pendaftaran'	=> $daf->type_pendaftaran
					);

			$this->session->set_userdata($data);
		}


		//INSERT TO DAFTAR DIKLAT
		$data_diklat = [

			'uc' => unique_code(),
			'uc_pendaftaran' => $uc_pendaftaran,
			'uc_jadwal_diklat' => $this->input->post('f_uc_jadwal_diklat')
		];

		$this->pendaftaran_diklat_m->insert_data($data_diklat);




	}


	function do_non_bst(){

		$query = $this->pendaftar_m->get_filtered(array('seafarers_code' => $this->input->post('f_seafarers_code')));
		if ($query->num_rows() > 0) {
			$res = $query->row();
			$query = $this->pendaftar_m->get_filtered(array('uc' => $res->uc));
			if ($query->num_rows() > 0) {
				$row = $query->row();

				$daf = $this->pendaftaran_m->get_filtered(array('uc_pendaftar' => $res->uc))->row();

				
				$uc_pendaftaran = unique_code();
				$type_pendaftaran = $this->input->post('f_status');

				$datas_pendaftaran = array(
										'uc' 					=> $uc_pendaftaran,
										'uc_pendaftar'			=> $res->uc,
										'no_pendaftaran'		=> no_pendaftaran(),
										'tanggal_daftar'		=> time_format(current_time(),'Y-m-d H:i'),
										'type_pendaftaran'		=> $type_pendaftaran
									);

				$this->pendaftaran_m->insert_data($datas_pendaftaran);

				$data = array(
							'uc_pendaftar'		=> $row->uc,
							'account_id'		=> $row->account_id,
							'nama_lengkap'		=> $row->nama_lengkap,
							'tempat_lahir'		=> $row->tempat_lahir,
							'tanggal_lahir'		=> $row->tanggal_lahir,
							'alamat_rumah'		=> $row->alamat_rumah,
							'no_telepon'		=> $row->no_telepon,
							'email'				=> $row->email,
							'nama_instansi'		=> $row->nama_instansi,
							'alamat_instansi'	=> $row->alamat_instansi,
							'seafarers_code'	=> $row->seafarers_code,
							'uc_pendaftaran'	=> $uc_pendaftaran,
							'type_pendaftaran'	=> $type_pendaftaran
						);



				$this->session->set_userdata($data);


				//INSERT TO DAFTAR DIKLAT

				$data_diklat = [

					'uc' => unique_code(),
					'uc_pendaftaran' => $uc_pendaftaran,
					'uc_jadwal_diklat' => $this->input->post('f_uc_jadwal_diklat')
				];

				$this->pendaftaran_diklat_m->insert_data($data_diklat);
			}

		}else{

			$unique_code = unique_code();
			$data = array(
							'uc'				=> $unique_code,
							'account_id'		=> accound_id(),
							'nama_lengkap'		=> $this->input->post('f_name_peserta'),
							'tempat_lahir'		=> $this->input->post('f_tempat_lahir'),
							'tanggal_lahir'		=> time_format($this->input->post('f_tgl_lahir'), 'Y-m-d'),
							'alamat_rumah'		=> $this->input->post('f_alamat_rumah'),
							'no_telepon'		=> $this->input->post('f_no_hp'),
							'email'				=> $this->input->post('f_email'),
							'nama_instansi'		=> $this->input->post('f_instansi'),
							'alamat_instansi'	=> $this->input->post('f_alamat_instansi'),
							'seafarers_code'	=> ($this->input->post('f_seafarers_code') != '' ? $this->input->post('f_seafarers_code') : NULL),
							'password'			=> md5('123')
						);

			$this->pendaftar_m->insert_data($data);

			$uc_pendaftaran = unique_code();

			$datas_pendaftaran = array(
										'uc' 					=> $uc_pendaftaran,
										'uc_pendaftar'			=> $unique_code,
										'no_pendaftaran'		=> no_pendaftaran(),
										'tanggal_daftar'		=> time_format(current_time(),'Y-m-d H:i'),
										'type_pendaftaran'		=> $this->input->post('f_status')
									);

			$this->pendaftaran_m->insert_data($datas_pendaftaran);


			//INSERT TO DAFTAR DIKLAT

			$data_diklat = [

				'uc' => unique_code(),
				'uc_pendaftaran' => $uc_pendaftaran,
				'uc_jadwal_diklat' => $this->input->post('f_uc_jadwal_diklat')
			];

			$this->pendaftaran_diklat_m->insert_data($data_diklat);

			$query = $this->pendaftar_m->get_filtered(array('uc' => $unique_code));
			if ($query->num_rows() > 0) {
				$row = $query->row();

				$daf = $this->pendaftaran_m->get_filtered(array('uc_pendaftar' => $unique_code))->row();

				$data = array(
							'uc_pendaftar'		=> $row->uc,
							'account_id'		=> $row->account_id,
							'nama_lengkap'		=> $row->nama_lengkap,
							'tempat_lahir'		=> $row->tempat_lahir,
							'tanggal_lahir'		=> $row->tanggal_lahir,
							'alamat_rumah'		=> $row->alamat_rumah,
							'no_telepon'		=> $row->no_telepon,
							'email'				=> $row->email,
							'nama_instansi'		=> $row->nama_instansi,
							'alamat_instansi'	=> $row->alamat_instansi,
							'seafarers_code'	=> $row->seafarers_code,
							'uc_pendaftaran'	=> $daf->uc,
							'type_pendaftaran'	=> $this->input->post('f_status')
						);

				$this->session->set_userdata($data);
			}
		}
	}

	function check_seafarers_code(){
		$sef_code = $this->input->post('js_seafarers_code');

		if ($sef_code != "") {
			$query = $this->pendaftar_m->get_filtered(array('seafarers_code' => $sef_code));
			if ($query->num_rows() > 0) {
				$row = $query->row();

				$value = array(
							'nama_lengkap' 		=> $row->nama_lengkap,
							'seafarers'			=> $row->seafarers_code,
							'tmp_lahir'			=> $row->tempat_lahir,
							'tgl_lahir'			=> time_format($row->tanggal_lahir,'Y-m-d'),
							'alamat_rumah'		=> $row->alamat_rumah,
							'no_hp'				=> $row->no_telepon,
							'email'				=> $row->email,
							'instansi'			=> $row->nama_instansi,
							'alamat_instansi'	=> $row->alamat_instansi
						
						);

				echo json_encode($value);
			}
			
		}
		
	}

	function step_2(){

		if ($this->session->userdata('uc_pendaftaran') != NULL) {


			$data = NULL;

			//info daftar
			$data['info'] = $this->pendaftaran_m->get_info_daftar()->row();

			$uc_diklat = $data['info']->uc_diklat;
			$uc_diklat_tahun = $data['info']->uc_diklat_tahun;


			$data['result'] = $this->diklat_tarif_m->get_list_biaya($uc_diklat_tahun, $uc_diklat)->result();


			$this->im_render->main('frontend/step_2', $data);


		}else{

			redirect('home');
		}
	}

	function step_3(){
		echo "Create Virtual Account";
	}

}