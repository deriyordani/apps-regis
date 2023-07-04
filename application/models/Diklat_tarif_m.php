<?php
class Diklat_tarif_m extends MY_Model{
	function __construct(){
		parent::__construct();

		$this->table_name = 'dkp_diklat_tarif';
	}

	function get_list_biaya($uc_diklat_tahun, $uc_diklat){
		$sql = "

			SELECT dt.*, dh.tahun, d.kode_diklat, d.nama_diklat, jt.jenis_tarif
			FROM dkp_diklat_tarif dt
			LEFT JOIN dkp_diklat_tahun dh ON dt.uc_diklat_tahun = dh.uc
			LEFT JOIN dkp_diklat d ON dh.uc_diklat = d.uc
			LEFT JOIN  dkp_jenis_tarif jt ON dt.uc_jenis_tarif = jt.uc

			WHERE dt.uc_diklat_tahun = '".$uc_diklat_tahun."' AND dt.uc_diklat = '".$uc_diklat."'
		";

		return $this->exec_query($sql);


	}

}