<?php
Class Home extends CI_Controller{
	function __construct(){
		parent::__construct();

		$this->load->model('diklat_m');
		$this->load->model('diklat_jadwal_m');
		$this->load->model('pendaftar_m');
		$this->load->model('diklat_peserta_m');

		$this->load->model('jenis_diklat_m');

	}

	function index(){
		$data = NULL;

		$data['count_diklat'] = $this->diklat_m->get_all()->num_rows();
		$data['count_jadwal'] = $this->diklat_jadwal_m->get_filtered(array('is_exist' => 1))->num_rows();
		$data['count_peserta'] = $this->diklat_peserta_m->get_all()->num_rows();
		$data['count_pendaftar'] = $this->pendaftar_m->get_all()->num_rows();

		$this->im_render->main('frontend/home', $data);
	}
}