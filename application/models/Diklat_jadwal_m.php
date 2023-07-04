<?php
class Diklat_jadwal_m extends MY_Model{
	function __construct(){
		parent::__construct();

		$this->table_name = 'dkp_diklat_jadwal';
	}

	function get_jadwal_diklat($data = NULL,$limit = NULL,$offset = 0){
		$sql = " SELECT dj.*,dk.nama_diklat, dk.`kode_diklat`, dk.`biaya`,dt.tahun, jd.jenis_diklat ";
		$sql .= " FROM `".$this->table_name."` dj ";
		$sql .= " LEFT JOIN `dkp_diklat` dk ON dj.uc_diklat = dk.uc ";
		$sql .= " LEFT JOIN dkp_jenis_diklat jd ON dk.uc_jenis_diklat = jd.uc ";
		$sql .= " LEFT JOIN `dkp_diklat_tahun` dt ON dj.uc_diklat_tahun = dt.uc ";
		$sql .= " WHERE dj.is_exist = '1' ";

		// $sql .= " AND YEAR (NOW()) ";

		if (@$data['uc'] != NULL) {
			$sql .= " AND dj.uc = '".$data['uc']."' ";
		}

		if (@$data['info'] != NULL) {
			$sql .= " AND dj.pelaksanaan_mulai >= '".current_time()."' ";
		}
		
		if (@$data['uc_diklat'] != NULL) {
			$sql .= " AND dj.uc_diklat = '".$data['uc_diklat']."' ";
		}

		if (@$data['angkatan'] != NULL) {
			$sql .= " AND dt.uc = '".$data['angkatan']."' ";
		}

		if (@$data['periode'] != NULL) {
			$sql .= " AND dj.periode = '".$data['periode']."' ";
		}

		if (@$data['month'] != NULL) {
			$sql .= " AND MONTH( dj.pelaksanaan_mulai ) = '".$data['month']."' ";
		}else{
			$sql .= " AND MONTH( dj.pelaksanaan_mulai ) = '".time_format(current_time(), 'm')."' ";
		}

		if (@$data['year'] != NULL) {
			$sql .= " AND YEAR(dj.pelaksanaan_mulai) = '".$data['year']."' ";
		}else{
			$sql .= " AND YEAR( dj.pelaksanaan_mulai ) = '".time_format(current_time(), 'Y')."' ";
		}

		if ($limit != NULL) {
			$sql .= " LIMIT ".$offset.", ".$limit." ";
		}

		//echo $sql;
		return $this->exec_query($sql);
	}

	function get_date_now($pelaksanaan_mulai = NULL, $limit = NULL,$offset = 0){
		$sql = " SELECT dj.*, dt.tahun,d.kode_diklat, d.nama_diklat, pd.uc_jadwal_diklat"; 
		$sql .= " FROM `dkp_diklat_jadwal` dj ";
		$sql .= " LEFT JOIN `dkp_diklat_tahun` dt ON dj.uc_diklat_tahun = dt.uc ";
		$sql .= " LEFT JOIN `dkp_pendaftaran_diklat` pd on dj.uc = pd.uc_jadwal_diklat ";
		$sql .= " AND pd.uc_pendaftaran = '".$this->session->userdata('uc_pendaftaran')."' ";
		$sql .= " LEFT JOIN `dkp_diklat` d ON dt.uc_diklat = d.uc ";
		$sql .= " WHERE dj.is_exist = '1' ";

		if ($pelaksanaan_mulai != NULL) {
			$sql .= " AND DATE(dj.pelaksanaan_mulai) = '".$pelaksanaan_mulai."'  ";
		}

		if ($this->session->userdata('type_pendaftaran') == 0) {
			//JIKA DAFTAR BLM PUNYA BST
			$sql .= "AND d.uc = '75-27751-70' ";
		}else{
			$sql .= " AND d.uc NOT IN ('75-27751-70') ";
		}

		if ($limit != NULL) {
			$sql .= " LIMIT ".$offset.", ".$limit." ";
		}

		return $this->exec_query($sql);
	}

	function get_by_diklat($filter = NULL, $limit = NULL,$offset = 0){
		$sql = " SELECT dj.*, dt.tahun,d.kode_diklat, d.nama_diklat, pd.uc_jadwal_diklat"; 
		$sql .= " FROM `dkp_diklat_jadwal` dj ";
		$sql .= " LEFT JOIN `dkp_diklat_tahun` dt ON dj.uc_diklat_tahun = dt.uc ";
		$sql .= " LEFT JOIN `dkp_pendaftaran_diklat` pd on dj.uc = pd.uc_jadwal_diklat ";
		$sql .= " AND pd.uc_pendaftaran = '".$this->session->userdata('uc_pendaftaran')."' ";
		$sql .= " LEFT JOIN `dkp_diklat` d ON dt.uc_diklat = d.uc ";
		$sql .= " WHERE dj.is_exist = '1' ";

		if (@$filter['uc_diklat'] != NULL) {
			$sql .= " AND dj.uc_diklat = '".$filter['uc_diklat']."' ";
		}

		if ($limit != NULL) {
			$sql .= " LIMIT ".$offset.", ".$limit." ";
		}

		return $this->exec_query($sql);
	}

	function get_info($uc = 0){
		$sql = " SELECT dj . * ,dt.tahun,d.kode_diklat, d.nama_diklat, dpn.type_pendaftaran ";
		$sql .= " FROM `dkp_diklat_jadwal` dj ";
		$sql .= " LEFT JOIN `dkp_diklat_tahun` dt ON dj.uc_diklat_tahun = dt.uc ";
		$sql .= " LEFT JOIN dkp_diklat d ON dt.uc_diklat = d.uc ";
		$sql .= " LEFT JOIN dkp_pendaftaran_diklat dpd ON dj.uc = dpd.uc_jadwal_diklat " ;
		$sql .= " LEFT JOIN dkp_pendaftaran dpn ON dpd.uc_pendaftaran = dpn.uc " ;

		$sql .= " WHERE dj.uc = '".$uc."' ";
		return $this->exec_query($sql);
	}

	function get_filter_diklat($data = NULL,$limit = NULL,$offset = 0){
		$sql = " SELECT dj.* , d.nama_diklat " ;
		$sql .= " FROM `dkp_diklat_jadwal` dj " ;
		$sql .= " LEFT JOIN `dkp_diklat` d ON dj.uc_diklat = d.uc " ;
		$sql .= " WHERE dj.is_exist = '1' ";

		if (@$data['uc_diklat'] != 'all') {
			$sql .= " AND dj.uc_diklat = '".$data['uc_diklat']."' ";
		}
		
		// if (@$data['pelaksanaan_mulai'] != NULL && @$data['pelaksanaan_akhir'] != NULL) {
		// 	$sql .= " AND dj.pelaksanaan_mulai BETWEEN '".$data['pelaksanaan_mulai']."' AND '".$data['pelaksanaan_akhir']."' ";
		// }

		// if (@$data['uc_diklat'] != NULL) {
		// 	$sql .= " WHERE dj.uc_diklat = '".$data['uc_diklat']."' ";
		// 	$sql .= " AND pelaksanaan_mulai >= '".$data['pelaksanaan_mulai']."' " ;
		// 	$sql .= " AND pelaksanaan_akhir <= '".$data['pelaksanaan_akhir']."'  " ;
		// }		
		if(@$data['pelaksanaan_mulai'] != NULL){
			$sql .= " AND pelaksanaan_mulai >= '".$data['pelaksanaan_mulai']."' ";
		}

		if (@$data['pelaksanaan_akhir'] != NULL) {
			$sql .= " AND pelaksanaan_akhir <= '".$data['pelaksanaan_akhir']."' ";
		}

		$sql .= " ORDER BY `dj`.`pelaksanaan_mulai` DESC , `dj`.`pelaksanaan_akhir` DESC " ;
		// echo $sql;
		if ($limit != NULL) {
			$sql .= " LIMIT ".$offset.", ".$limit." ";
		}

		return $this->exec_query($sql);
	}

	function get_tahun_diklat($data = NULL,$limit = NULL,$offset = 0){
		$sql = " SELECT dj.* ,dt.tahun " ;
		$sql .= " FROM `dkp_diklat_jadwal` dj " ;
		$sql .= " LEFT JOIN `dkp_diklat_tahun` dt ON dj.uc_diklat_tahun = dt.uc	 " ;
		$sql .= " WHERE dj.is_exist = '1' ";

		if(@$data['uc_diklat_tahun'] != NULL){
			$sql .= " AND dj.uc_diklat_tahun = '".$data['uc_diklat_tahun']."' ";
		}

		if(@$data['uc_diklat'] != NULL){
			$sql .= " AND dj.uc_diklat = '".$data['uc_diklat']."' ";
		}

		// $sql .= " ORDER BY `dj`.`pelaksanaan_mulai` ASC " ;

		if ($limit != NULL) {
			$sql .= " LIMIT ".$offset.", ".$limit." ";
		}
		return $this->exec_query($sql);

	
	}


}