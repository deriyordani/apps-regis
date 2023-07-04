<?php
class Diklat_persyaratan_m extends MY_Model{
	function __construct(){
		parent::__construct();

		$this->table_name = 'dkp_diklat_persyaratan';
	}

	function get_list($uc_diklat, $limit = NULL,$offset = 0){
		$sql = " SELECT dp.*, p.persyaratan
				FROM `dkp_diklat_persyaratan` dp
				LEFT JOIN dkp_persyaratan p ON dp.uc_persyaratan = p.uc
				WHERE dp.uc_diklat = '".$uc_diklat."' ";


		if ($limit != NULL) {
			$sql .= " LIMIT ".$offset.", ".$limit." ";
		}

		return $this->exec_query($sql);
	}
}