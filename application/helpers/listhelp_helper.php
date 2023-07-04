<?php

function list_jenis_diklat($filter = NULL){
	$CI =& get_instance();
	$CI->load->model('jenis_diklat_m');
	
	if ($filter != NULL) {		
		$query = $CI->jenis_diklat_m->get_filtered($filter);
	}
	else {
		$query = $CI->jenis_diklat_m->get_all('id','ASC');	
	}
	
	if ($query->num_rows() > 0) {
		return $query->result();
	}
	else {
		return NULL;
	}
}

function list_jenis_tarif($filter = NULL){
	$CI =& get_instance();
	$CI->load->model('jenis_tarif_m');
	
	if ($filter != NULL) {		
		$query = $CI->jenis_tarif_m->get_filtered($filter);
	}
	else {
		$query = $CI->jenis_tarif_m->get_all('id','ASC');	
	}
	
	if ($query->num_rows() > 0) {
		return $query->result();
	}
	else {
		return NULL;
	}
}

function list_diklat($filter = NULL){
	$CI =& get_instance();
	$CI->load->model('diklat_m');
	
	if ($filter != NULL) {		
		$query = $CI->diklat_m->get_filtered($filter,'nama_diklat','ASC');
	}
	else {
		$query = $CI->diklat_m->get_all('nama_diklat','ASC');	
	}
	
	if ($query->num_rows() > 0) {
		return $query->result();
	}
	else {
		return NULL;
	}
}


function list_diklat_jadwal($filter = NULL){
	$CI =& get_instance();
	$CI->load->model('diklat_jadwal_m');
	
	if ($filter != NULL) {		
		$query = $CI->diklat_jadwal_m->get_filtered($filter);
	}
	else {
		$query = $CI->diklat_jadwal_m->get_all('pelaksanaan_mulai','DESC','pelaksanaan_akhir','DESC');	
	}
	
	if ($query->num_rows() > 0) {
		return $query->result();
	}
	else {
		return NULL;
	}
}

function list_angkatan($filter = NULL){
	$CI =& get_instance();
	$CI->load->model('tahun_diklat_m');
	
	if ($filter != NULL) {		
		$query = $CI->tahun_diklat_m->get_filtered($filter);
	}
	else {
		$query = $CI->tahun_diklat_m->get_all('id','ASC');	
	}
	
	if ($query->num_rows() > 0) {
		return $query->result();
	}
	else {
		return NULL;
	}
}

?>