<?php
class Tahun_diklat_m extends MY_Model{
	function __construct(){
		parent::__construct();

		$this->table_name = 'dkp_diklat_tahun';
	}

	function get_diklat($uc = NULL){
		$sql = " SELECT dt.*, d.kode_diklat,d.nama_diklat,d.biaya,d.lama_diklat,d.uc as uc_diklat ";
		$sql .= " FROM `".$this->table_name."` dt ";
		$sql .= " LEFT JOIN dkp_diklat d ON dt.uc_diklat = d.uc ";

		if ($uc != NULL) {
			$sql .= " WHERE dt.uc = '".$uc."' ";
		}

		return $this->exec_query($sql);
	}

	function get_tahun_diklat($uc_diklat_tahun){
		$sql  = " SELECT dt.*, d.kode_diklat, d.nama_diklat, d.lama_diklat
					FROM dkp_diklat_tahun dt
					LEFT JOIN dkp_diklat d ON dt.uc_diklat = d.uc
		 ";


		if ($uc_diklat_tahun != NULL) {
			$sql .= " WHERE dt.uc = '".$uc_diklat_tahun."' AND dt.is_exist = '1'";
		}

		return $this->exec_query($sql);
	}
}