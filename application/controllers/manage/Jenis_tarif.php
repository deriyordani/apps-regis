<?php
class Jenis_tarif extends CI_Controller{
	function __construct(){
		parent::__construct();

		if (!$this->im_login->is_login('log_username')) {
			redirect('auth/login');
		}


		$this->each_page 	= 20;
		$this->page_int 	= 5;

		$this->load->model('jenis_tarif_m');
	}

	function index(){
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
							'model'			=> 'jenis_tarif_m'
						);

		$query = $this->jenis_tarif_m->get_all('id','ASC',$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$query = $this->jenis_tarif_m->get_all('id','ASC');
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();
		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;

		$this->im_render->manage('manage/jenis_tarif/list', $data);
	}


	function page(){
		$data = NULL;

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
							'model'			=> 'jenis_tarif_m'
						);

		$query = $this->jenis_tarif_m->get_all('id','ASC',$this->each_page, $offset);
		if ($query->num_rows() > 0) {
			$data['result'] = $query->result();
		}

		$query = $this->jenis_tarif_m->get_all('id','ASC');
		if ($query->num_rows() > 0) {
			$params['total_record'] = $query->num_rows();
			$data['pagination'] 	= $this->im_pagination->render_ajax($params);
			$data['total_record'] 	= $query->num_rows();
		}

		$data['numbering'] 	= ($this->each_page * ($page-1)) + 1;

		$this->load->view('manage/jenis_tarif/page', $data);
	}


	function add(){
		$this->load->view('manage/jenis_tarif/add');
	}

	function insert(){
		$data = [

			'uc' => unique_code(),
			'jenis_tarif' => $this->input->post('f_jenis_tarif')
		];

		$this->jenis_tarif_m->insert_data($data);

		redirect('manage/jenis_tarif');
	}

	function edit(){
		$data = NULL;

		$data['row'] = $this->jenis_tarif_m->get_filtered(array('uc' => $this->input->post('js_uc')))->row();

		$this->load->view('manage/jenis_tarif/edit', $data);
	}

	function update(){

		$data = [

			'jenis_tarif' => $this->input->post('f_jenis_tarif')
		];

		$this->jenis_tarif_m->update_data($data, array('uc' => $this->input->post('f_uc')));

		redirect('manage/jenis_tarif');

	}

	function delete($uc = NULL){
		$this->jenis_tarif_m->delete_data(array('uc' => $uc));

		redirect('manage/jenis_tarif');
	}




}