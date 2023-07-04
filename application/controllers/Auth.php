<?php
Class Auth extends CI_Controller{
	function __construct(){
		parent::__construct();
	}

	function login(){
		$this->load->view('auth/login');
	}

	function verifying(){
		if ($row = $this->im_login->verifying(trim($this->input->post('f_username')), md5(trim($this->input->post('f_password'))))){
			$data = array(
							'log_user_id'		=> $row->id,
							'log_username'		=> $row->username,
							'log_name'			=> $row->nama_lengkap,							
							'log_type'			=> $row->type,
							'log_uc'			=> $row->uc,
							'log_photo'			=> $row->photo,
							'log_nip'			=> $row->nip
							);

			$this->session->set_userdata($data);
			
			redirect('manage/dashboard');		
		}
		else{
			$data['warning'] = "Invalid Username or Password!";
			$this->load->view('auth/login', $data);
		}
	}


	function logout(){
		$this->session->sess_destroy();		
		redirect('auth/login');
	}

	function login_user(){
		$this->load->view('auth/login_user');
	}

	function verifying_user(){
		if ($row = $this->im_login->verifying(trim($this->input->post('f_username')), md5(trim($this->input->post('f_password'))))){
			$data = array(
							'log_user_id'		=> $row->id,
							'log_username'		=> $row->username,
							'log_name'			=> $row->nama_lengkap,							
							'log_type'			=> $row->type,
							'log_uc'			=> $row->uc,
							'log_photo'			=> $row->photo,
							'log_nip'			=> $row->nip
							);

			$this->session->set_userdata($data);
			
			redirect('manage/dashboard');		
		}
		else{
			$data['warning'] = "Invalid Username or Password!";
			$this->load->view('auth/login', $data);
		}
	}


	
}