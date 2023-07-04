<?php
class Persyaratan_m extends MY_Model{
	function __construct(){
		parent::__construct();

		$this->table_name = 'dkp_persyaratan';
	}


	function search_syarat($uc_diklat,$text,$limit = NULL,$offset = 0){

		$sql = " SELECT p.* FROM `dkp_persyaratan` p WHERE p.uc NOT IN (select uc_persyaratan from dkp_diklat_persyaratan where uc_diklat = '".$uc_diklat."') ";

		$sql .= " AND  p.persyaratan LIKE '%".$text."%'";
		//$sql = " SELECT * FROM `dkp_persyaratan` WHERE `persyaratan` LIKE '%".$text."%'  ";


		if ($limit != NULL) {
			$sql .= " LIMIT ".$offset.", ".$limit." ";
		}

		return $this->exec_query($sql);

	}

}