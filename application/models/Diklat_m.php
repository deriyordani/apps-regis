<?php
class Diklat_m extends MY_Model{
	function __construct(){
		parent::__construct();

		$this->table_name = 'dkp_diklat';
	}

	function get_list($filter = NULL, $limit = NULL,$offset = 0){
		$sql = " SELECT d.*, jd.jenis_diklat
				FROM `dkp_diklat` d
				LEFT JOIN dkp_jenis_diklat jd ON d.uc_jenis_diklat = jd.uc 

				WHERE d.is_exist = '1'

		";


		if (@$filter['uc_jenis_diklat'] != NULL) {
			$sql .= " AND d.uc_jenis_diklat = '".$filter['uc_jenis_diklat']."' ";
		}


		if (@$filter['search'] != NULL) {
			$sql .= " AND d.nama_diklat LIKE '%".$filter['search']."%' ";
		}

		if (@$filter['uc_diklat'] != NULL) {
			$sql .= " AND d.uc = '".$filter['uc_diklat']."' ";
		}

		$sql .=" ORDER BY d.id DESC ";


		if ($limit != NULL) {
			$sql .= " LIMIT ".$offset.", ".$limit." ";
		}

		return $this->exec_query($sql);
	}

	function get_diklat($limit = NULL,$offset = 0){
		$sql = " SELECT * FROM `".$this->table_name."`  ";

		if($this->session->userdata('type_pendaftaran') != 1){
			//jika memilih type bst
			$sql .= " WHERE uc = '75-27751-70' ";
		}else{
			$sql .= " WHERE uc NOT IN ('75-27751-70') ";
		}

		if ($limit != NULL) {
			$sql .= " LIMIT ".$offset.", ".$limit." ";
		}

		return $this->exec_query($sql);
	}
}