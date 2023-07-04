<?php
class Biaya_diklat extends CI_Controller{
	function __construct(){
		parent::__construct();

		if (!$this->im_login->is_login('log_username')) {
			redirect('auth/login');
		}


		$this->each_page 	= 10;
		$this->page_int 	= 5;

		$this->load->model('diklat_m');
		$this->load->model('diklat_tarif_m');
	}


	function daftar($uc_diklat_tahun = NULL, $uc_diklat = NULL){
		$data = NULL;


		$query = $this->diklat_m->get_list(array('uc_diklat' => $uc_diklat));
		if ($query->num_rows() > 0) {
			$data['dk'] = $query->row();
		}

		$data['uc_diklat_tahun'] = $uc_diklat_tahun;
		$data['uc_diklat'] = $uc_diklat;

		$data['result'] = $this->diklat_tarif_m->get_list_biaya($uc_diklat_tahun, $uc_diklat)->result();

		$this->im_render->manage('manage/biaya_diklat/list',$data);
	}

	function paget_daftar(){

	}

	function insert(){

		$uc_diklat_tahun = $this->input->post('js_uc_diklat_tahun');
		$uc_diklat = $this->input->post('js_uc_diklat');


		$data = [

			'uc' => unique_code(),
			'uc_diklat_tahun' => $uc_diklat_tahun,
			'uc_diklat' => $uc_diklat,
			'uc_jenis_tarif' => $this->input->post('js_uc_jenis_tarif'),
			'total_tarif' => str_replace('.', '', $this->input->post('js_total_tarif'))
		];

		$this->diklat_tarif_m->insert_data($data);


		$data['result'] = $this->diklat_tarif_m->get_list_biaya($uc_diklat_tahun, $uc_diklat)->result();


		$this->load->view('manage/biaya_diklat/load_table_biaya', $data);

		// if ($this->input->post('f_save')) {
			
		// 	$uc_diklat_tahun = $this->input->post('f_uc_diklat_tahun');
		// 	$uc_diklat = $this->input->post('f_uc_diklat');

		// 	$data = [

		// 		'uc' => unique_code(),
		// 		'uc_diklat_tahun' => $uc_diklat_tahun,
		// 		'uc_diklat' => $uc_diklat,
		// 		'uc_jenis_tarif' => $this->input->post('f_jenis_tarif'),
		// 		'id_semester' => $this->input->post('f_id_semester'),
		// 		'total_tarif' => $this->input->post('f_total_tarif')
		// 	];

		// 	$this->diklat_tarif_m->insert_data($data);
		// }

		// redirect('manage/biaya_diklat/daftar/'.$uc_diklat_tahun.'/'.$uc_diklat);
	}

	function delete($uc_diklat_biaya = NULL, $uc_diklat_tahun = NULL, $uc_diklat = NULL){

		if ($uc_diklat_biaya != NULL) {
			
			$this->diklat_tarif_m->delete_data(array('uc' => $uc_diklat_biaya));
		}


		redirect('manage/biaya_diklat/daftar/'.$uc_diklat_tahun.'/'.$uc_diklat);

	}

}